<?php
session_start();

if (!isset($_SESSION['name'])) {
    // Manejo de sesión no iniciada, redirige o maneja la situación según sea necesario
    exit("Sesión no iniciada");
}

require '../../backend/fpdf/fpdf.php';
date_default_timezone_set('America/Lima');

class PDF extends FPDF
{
    // ... (resto del código de la clase PDF)
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Resto del código para configurar el encabezado y el pie de página...

// Información del paciente
$pdf->SetFont('Arial', 'B', 10);
$pdf->Text(10, 48, utf8_decode('DATOS DEL PACIENTE'));
$pdf->Ln(50);

// Encabezados de la tabla de datos del paciente
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 7, utf8_decode('NSS'), 1, 0, 'C', 0);
$pdf->Cell(40, 7, utf8_decode('Nombre'), 1, 0, 'C', 0);
$pdf->Cell(40, 7, utf8_decode('Apellido'), 1, 0, 'C', 0);
$pdf->Cell(30, 7, utf8_decode('Nacimiento'), 1, 0, 'C', 0);
$pdf->Cell(30, 7, utf8_decode('Género'), 1, 0, 'C', 0);
$pdf->Cell(30, 7, utf8_decode('Sangre'), 1, 1, 'C', 0);
$pdf->SetFont('Arial', '', 10);

// Obtener datos del paciente
require '../../backend/bd/Conexion.php';
$id = $_GET['id'];

$stmt = $connect->prepare("SELECT * FROM patients WHERE idpa = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();

while ($row = $stmt->fetch()) {
    // Llenar la tabla con datos del paciente
    $pdf->Cell(20, 7, utf8_decode($row['numhs']), 1, 0, 'L', 0);
    $pdf->Cell(40, 7, utf8_decode($row['nompa']), 1, 0, 'L', 0);
    $pdf->Cell(40, 7, utf8_decode($row['apepa']), 1, 0, 'L', 0);
    $pdf->Cell(30, 7, utf8_decode($row['cump']), 1, 0, 'L', 0);
    $pdf->Cell(30, 7, utf8_decode($row['sex']), 1, 0, 'L', 0);
    $pdf->Cell(30, 7, utf8_decode($row['grup']), 1, 0, 'R', 0);
    $pdf->Ln(10);
}

// Resto del código para el genograma, consulta y tratamiento del paciente...

$pdf->Output('historia_clinica.pdf', 'D');
?>
