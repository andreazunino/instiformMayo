<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../lib/fpdf/fpdf.php';

$inscripcionModel = new Inscripcion($pdo);

// Validar DNI
$dniEstudiante = $_GET['dni'] ?? null;
if (!$dniEstudiante) {
    die('DNI no especificado.');
}

// Traer datos del estudiante
$stmt = $pdo->prepare("SELECT nombre, apellido FROM estudiante WHERE dni = ?");
$stmt->execute([$dniEstudiante]);
$estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$estudiante) {
    die('Estudiante no encontrado.');
}

$nombre = $estudiante['nombre'];
$apellido = $estudiante['apellido'];

// Traer notas (puede estar vacío)
$notas = $inscripcionModel->obtenerNotasPorDNI($dniEstudiante);

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();

// Logo (si existe)
$logoPath = __DIR__ . '/../../public/img/Logo Instiform.png';
if (file_exists($logoPath)) {
    $pdf->Image($logoPath, 10, 6, 30);
}

// Título
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode('Boletín de Calificaciones'), 0, 1, 'C');
$pdf->Ln(5);

// Datos del alumno
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode("Estudiante: $apellido, $nombre"), 0, 1);
$pdf->Cell(0, 10, "DNI: $dniEstudiante", 0, 1);
$pdf->Cell(0, 10, "Fecha: " . date('d/m/Y'), 0, 1);
$pdf->Ln(5);

// Verificamos si hay notas
if (!empty($notas)) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(120, 10, 'Materia', 1);
    $pdf->Cell(40, 10, 'Calificación', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    foreach ($notas as $nota) {
        $materia = utf8_decode($nota['materia']);
        $calificacion = $nota['calificacion'];
        $pdf->Cell(120, 10, $materia, 1);
        $pdf->Cell(40, 10, $calificacion, 1);
        $pdf->Ln();
    }
} else {
    // Mostrar mensaje si no hay notas
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->MultiCell(0, 10, utf8_decode("Este estudiante aún no tiene calificaciones registradas.\n\nEste boletín ha sido generado únicamente como documento informativo."));
}

// Footer
$pdf->Ln(15);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, utf8_decode("Documento generado por Instiform – Sistema de Gestión"), 0, 0, 'C');

// Salida
$pdf->Output('I', "Boletin_$dniEstudiante.pdf");
exit;
