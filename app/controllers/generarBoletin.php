<?php
require_once(__DIR__ . '/../../sql/db.php');
require_once(__DIR__ . '/../models/Inscripcion.php');
require_once(__DIR__ . '/../lib/fpdf/fpdf.php'); // Librería para generar PDF

$dni = $_GET['dni'] ?? null;

if (!$dni) {
    die('DNI no proporcionado.');
}

$inscripcionModel = new Inscripcion($pdo);
$notas = $inscripcionModel->obtenerNotasPorDNI($dni);

if (!$notas) {
    die('No se encontraron calificaciones.');
}

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Boletín de Calificaciones', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
foreach ($notas as $nota) {
    $pdf->Cell(0, 10, 'Materia: ' . $nota['materia'], 0, 1);
    foreach ($nota['calificacion'] as $cal) {
        $pdf->Cell(0, 8, ' - Calificación: ' . $cal, 0, 1);
    }
    $pdf->Ln(5);
}

$pdf->Output('I', 'Boletin_' . $dni . '.pdf');

