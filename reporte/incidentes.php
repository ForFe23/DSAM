<?php
session_start();
$id_usuarios_sesion =  $_SESSION["IDUSUARIO"];
include('../php/connection.php');

$id_equipo = $_GET['id_equipo'];
$id_cliente = $_GET['id_cliente'];

$consulta_equipo = "SELECT * FROM equipo WHERE ID = $id_equipo ;";
$result_equipo = $conn->query($consulta_equipo);

if ($result_equipo->num_rows > 0) {

    while ($row_equipo = $result_equipo->fetch_assoc()) {

        $serie_equipo = $row_equipo['SERIEEQUIPO'];
        $marca_equipo = $row_equipo['MARCAEQUIPO'];
        $tipo_equipo = $row_equipo['TIPOEQUIPO'];
        $activo_equipo = $row_equipo['ACTIVOEQUIPO'];
        if (empty($activo_equipo)) {
            $activo_equipo = '-';
        }
    }
    $Consulta_tecnico_cabecera = "SELECT * from usuarios WHERE IDUSUARIO = $id_usuarios_sesion ; ";
    $result_tecnico_cabecera = $conn->query($Consulta_tecnico_cabecera);
    if ($result_tecnico_cabecera->num_rows > 0) {
        while ($row_tecnico_cabecera = $result_tecnico_cabecera->fetch_assoc()) {
            $nombre_tecnico_cabecera = $row_tecnico_cabecera['NOMBRESUSUARIO'];
        }
    }
    $consulta_empresa = "SELECT * from cliente WHERE IDCLIENTE= $id_cliente ; ";
    $result_empresa = $conn->query($consulta_empresa);
    if ($result_empresa->num_rows > 0) {
        while ($row_empresa = $result_empresa->fetch_assoc()) {
            $nomble_cliente = $row_empresa['NOMBRECLIENTE'];
            $calle_cliente = $row_empresa['Calle'];
            $ciudad_cliente = $row_empresa['Ciudad'];
        }
    }

    require('../fpdf186/fpdf.php');

    class PDF extends FPDF
    {
        private $empresa;
        private $ciudad;
        private $callePrincipal;

        public function setEmpresa($empresa, $ciudad, $callePrincipal)
        {
            $this->empresa = $empresa;
            $this->ciudad = $ciudad;
            $this->callePrincipal = $callePrincipal;
        }

        function Header()
        {
            $this->SetFont('Arial', '', 11);
            $this->SetTextColor(0, 0, 0);
            $this->SetXY(150, 10);
        }

        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo()), 0, 0, 'C');
        }


        function Content()
        {
            $this->SetFont('Arial', '', 11);
            $this->SetTextColor(0, 0, 0);
            $this->AddParagraph($this->empresa . "\n" . $this->callePrincipal . "\n" . $this->ciudad, 10, 60);
        }

        public function AddParagraph($text, $x, $y)
        {
            $this->SetXY($x, $y);
            $this->MultiCell(0, 5, utf8_decode($text), 0, 'L');
        }

        public function AddIncidencia($activo, $fecha, $tecnico, $costo, $detalle)
        {
            // Definir posición X e Y
            $x = 0; // Ajusta según tu necesidad
            $y = $this->GetY();

            // Definir alto de la celda
            $cellHeight = 11;

            // Establecer color de fondo para todas las celdas
            $this->SetFillColor(255, 255, 255); // Color #E6E6E6

            // Guardar posición actual
            $currentX = $this->GetX();
            $currentY = $this->GetY();

            // Dibujar la línea superior más gruesa y más a la izquierda para la celda de activo
            $this->SetLineWidth(1); // Ancho de línea 1
            $this->Line($currentX - 15, $currentY - 1, $currentX + 130, $currentY - 1); // Movimiento a la izquierda

            // Restaurar ancho de línea a 0.2 (valor predeterminado)
            $this->SetLineWidth(0.1);

            // Restaurar posición
            $this->SetXY($currentX, $currentY);

            // Agregar celdas para cada variable
            $this->SetX(0); // Cambia 10 según tu necesidad
            $this->Cell(30, $cellHeight, '' . utf8_decode($activo), 0, 0, 'L', true);

            // Establecer posición X para la segunda celda (Fecha)
            $this->SetX(25); // Cambia 50 según tu necesidad (Suma el ancho de la celda anterior)
            $this->Cell(30, $cellHeight, '' . utf8_decode($fecha), 0, 0, 'L', false);

            // Establecer posición X para la tercera celda (Técnico)
            $this->SetX(60); // Cambia 90 según tu necesidad (Suma el ancho de las celdas anteriores)
            $this->Cell(40, $cellHeight, '' . utf8_decode($tecnico), 0, 0, 'L', false);

            // Establecer posición X para la cuarta celda (Costo)
            $this->SetX(110); // Cambia 130 según tu necesidad (Suma el ancho de las celdas anteriores)
            $this->Cell(30, $cellHeight, '' . utf8_decode($costo), 0, 0, 'L', false);

            // Dibujar la línea superior más gruesa y más a la izquierda para la celda de detalle
            $currentX = $this->GetX();
            $currentY = $this->GetY();
            $this->SetLineWidth(1); // Ancho de línea 1
            $this->Line($currentX - 2, $currentY - 1, $currentX + 130, $currentY - 1); // Movimiento a la izquierda

            // Restaurar ancho de línea a 0.2 (valor predeterminado)
            $this->SetLineWidth(0.1);

            // Restaurar posición
            $this->SetXY($currentX, $currentY);

            // Restaurar el color de fondo a blanco
            $this->SetFillColor(255, 255, 255);

            // Ajustar la posición X para el detalle y establecer un nuevo tamaño de fuente
            $this->SetX($this->GetX() + $x);
            $this->SetFont('Arial', '', 11);
            $this->MultiCell(0, 5, utf8_decode($detalle), 0, 'L');

            // Restaurar la fuente y añadir un salto de línea
            $this->SetFont('Arial', '', 11);
            $this->Ln();
        }
    }

    $pdf = new PDF();
    $pdf->AddPage();

    $imagePath1 = '../reporte/dapcom.jpeg';
    $x1 = 20;
    $y1 = 2;
    $width1 = 50;
    $pdf->Image($imagePath1, $x1, $y1, $width1);

    $imagePath2 = '../reporte/linea.jpeg';
    $x2 = 0;
    $y2 = 40;
    $width2 = 220;
    $pdf->Image($imagePath2, $x2, $y2, $width2);

    $imagePath3 = '../reporte/cabecera.jpeg';
    $x3 = 0;
    $y3 = 110;
    $width3 = 220;
    $pdf->Image($imagePath3, $x3, $y3, $width3);

    $pdf->setEmpresa($nomble_cliente, $ciudad_cliente, $calle_cliente);
    $pdf->Content();

    $pdf->SetFont('Arial', 'B', 19.5);
    $pdf->AddParagraph('INCIDENCIAS', 115, 50);
    $pdf->SetFont('Arial', '', 11);

    $pdf->AddParagraph('DAPCOMPUTER S.A.S' . "\nAv. 6 de Diciembre N49.276 y Álamos Edificio Vega Oficina 3A" . "\nPBX: (+593) 2 6037 789", 150, 10);


    $fecha_actual_equipo = date('m/d/Y');

    $Tecnico = 'Técnico Ñandú';
    $Activo = 'Activo-001';

    $pdf->AddParagraph('Fecha:' . "\n" . utf8_decode($fecha_actual_equipo), 115, 62);


    $pdf->AddParagraph('Activo:' . "\n" . utf8_decode($activo_equipo), 145, 62);


    $pdf->AddParagraph('Técnico:' . "\n" . utf8_decode($nombre_tecnico_cabecera), 178, 62);


    $pdf->AddParagraph('Marca:' . "\n" . utf8_decode($marca_equipo), 115, 75);


    $pdf->AddParagraph('Tipo:' . "\n" . utf8_decode($tipo_equipo), 145, 75);

    // POSICION GENERACION REPORTE DE EQUIPO EJE Y
    $pdf->SetY(125);

    $contador = 1;


    $consulta_incidentes = "SELECT i.FECHAINCIDENTE, u.NOMBRESUSUARIO, i.COSTOINCIDENTE, i.DETALLEINCIDENTE
                        FROM incidente i
                        INNER JOIN usuarios u ON i.IDUSUARIO = u.IDUSUARIO
                        WHERE i.SERIEEQUIPO = '$serie_equipo'";
    $result_incidentes = $conn->query($consulta_incidentes);


    if ($result_incidentes->num_rows > 0) {

        while ($row = $result_incidentes->fetch_assoc()) {
            $pdf->AddIncidencia(
                'N°' . $contador++,
                $fecha_formateada = date('Y-m-d', strtotime($row['FECHAINCIDENTE'])),
                $row['NOMBRESUSUARIO'],
                $row['COSTOINCIDENTE'],
                $row['DETALLEINCIDENTE']
            );
        }
    } else {
        // Manejar caso en el que no hay incidentes disponibles
    }


    $pdf->Output();
} else {
    echo "no hay equipos con este id, consulta al programador";
}
$conn->close();
