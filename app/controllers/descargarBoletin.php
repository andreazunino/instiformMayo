<?php
require_once '../../sql/db.php';
require_once '../../models/Inscripcion.php';
require_once '../../lib/fpdf/fpdf.php';

$inscripcionModel = new Inscripcion($pdo);

$dniEstudiante = $_GET['dni'] ?? null;
if (!$dniEstudiante) {
    die('DNI no especificado.');
}

// Traer datos del boletín
$boletin = $inscripcionModel->obtenerBoletinCompleto($dniEstudiante);

if (!$boletin || count($boletin) === 0) {
    die('No se encontraron calificaciones para este estudiante.');
}

$nombre = $boletin[0]['nombre'];
$apellido = $boletin[0]['apellido'];

$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image('../../public/img/logo-instiform.png', 10, 6, 30);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode('Boletín de Calificaciones'), 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Estudiante: $apellido, $nombre", 0, 1);
$pdf->Cell(0, 10, "DNI: $dniEstudiante", 0, 1);
$pdf->Cell(0, 10, "Fecha: " . date('d/m/Y'), 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(120, 10, 'Materia', 1);
$pdf->Cell(40, 10, 'Calificación', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
foreach ($boletin as $nota) {
    $pdf->Cell(120, 10, utf8_decode($nota['materia']), 1);
    $pdf->Cell(40, 10, $nota['calificacion'], 1);
    $pdf->Ln();
}

$pdf->Output('I', "Boletin_$dniEstudiante.pdf");
exit;
