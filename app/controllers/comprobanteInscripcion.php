<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../models/Estudiante.php';
require_once __DIR__ . '/../models/Curso.php';
require_once __DIR__ . '/../../config/constants.php';
require_once APP_ROOT . '/app/lib/fpdf/fpdf.php';

requireLogin(['admin', 'estudiante']);
$usuario = currentUser();
$rol = $usuario['role'] ?? '';
$dniSesion = $usuario['dni'] ?? null;
$tz = new DateTimeZone('America/Argentina/Buenos_Aires');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo 'ID de inscripcion invalido.';
    exit;
}

$inscripcionModel = new Inscripcion($pdo);
$estudianteModel = new Estudiante($pdo);
$cursoModel = new Curso($pdo);

$inscripcion = $inscripcionModel->obtenerInscripcionPorId($id);
if (!$inscripcion) {
    http_response_code(404);
    echo 'Inscripcion no encontrada.';
    exit;
}

if ($rol === 'estudiante' && $dniSesion !== $inscripcion['dni']) {
    http_response_code(403);
    echo 'No estas autorizado para ver este comprobante.';
    exit;
}

$estudiante = $estudianteModel->obtenerPorDNI($inscripcion['dni']) ?: [];
$curso = $cursoModel->obtenerPorId($inscripcion['id_curso']) ?: [];

function ci_convert(string $texto): string
{
    $convertido = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $texto);
    return $convertido !== false ? $convertido : $texto;
}

$pdf = new FPDF();
$pdf->AddPage();

if (defined('APP_LOGO_PATH') && file_exists(APP_LOGO_PATH)) {
    $pdf->Image(APP_LOGO_PATH, 10, 10, 28);
    $pdf->Ln(10);
}

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 12, ci_convert('Comprobante de inscripcion'), 0, 1, 'C');
$pdf->Ln(4);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, ci_convert('Fecha: ' . (new DateTime('now', $tz))->format('d/m/Y H:i')), 0, 1);
$pdf->Cell(0, 8, ci_convert('Codigo de inscripcion: ' . $inscripcion['id']), 0, 1);

$nombreCompleto = trim(($estudiante['apellido'] ?? '') . ' ' . ($estudiante['nombre'] ?? ''));
$pdf->Cell(0, 8, ci_convert('Estudiante: ' . ($nombreCompleto ?: '')), 0, 1);
$pdf->Cell(0, 8, ci_convert('DNI: ' . $inscripcion['dni']), 0, 1);
$cursoNombre = $curso['nombre'] ?? ($inscripcion['curso'] ?? '');
$pdf->Cell(0, 8, ci_convert('Curso: ' . $cursoNombre), 0, 1);
$pdf->Ln(8);
$pdf->MultiCell(0, 8, ci_convert('Este comprobante acredita que la inscripcion fue registrada correctamente en el sistema Instiform.'));

$pdf->Ln(14);
$pdf->SetFont('Arial', 'I', 9);
$pdf->SetTextColor(120, 130, 140);
$pdf->Cell(0, 8, ci_convert('Documento generado por Instiform - Sistema de Gestion'), 0, 1, 'C');

$fileName = 'comprobante_inscripcion_' . $inscripcion['id'] . '.pdf';
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $fileName . '"');
$pdf->Output('I', $fileName);
exit;
