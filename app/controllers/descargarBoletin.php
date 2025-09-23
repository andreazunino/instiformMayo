<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../models/Inscripcion.php';

if (!defined('FPDF_FONTPATH')) {
    define('FPDF_FONTPATH', __DIR__ . '/../lib/font/');
}

require_once __DIR__ . '/../lib/fpdf/fpdf.php';

$smarty = new Smarty\Smarty;

$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$inscripcionModel = new Inscripcion($pdo);

$dniEstudiante = $_GET['dni'] ?? null;
if (!$dniEstudiante) {
    die('DNI no especificado.');
}

$stmt = $pdo->prepare("SELECT nombre, apellido FROM estudiante WHERE dni = ?");
$stmt->execute([$dniEstudiante]);
$estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$estudiante) {
    die('Estudiante no encontrado.');
}

$nombre = $estudiante['nombre'];
$apellido = $estudiante['apellido'];
$notas = $inscripcionModel->obtenerNotasPorDNI($dniEstudiante);

class PDF extends FPDF {
    function Header() {
        $logoPath = __DIR__ . '/../../public/img/Logo Instiform.png';
        if (!file_exists($logoPath)) {
            $logoPath = __DIR__ . '/../../public/img/logo-instiform.png';
        }

        if (file_exists($logoPath)) {
            $this->Image($logoPath, 10, 6, 30);
        }
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 15, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Boletín de Calificaciones'), 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Documento generado por Instiform – Sistema de Gestión'), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', "Estudiante: $apellido, $nombre"), 0, 1);
$pdf->Cell(0, 10, "DNI: $dniEstudiante", 0, 1);
$pdf->Cell(0, 10, "Fecha: " . date('d/m/Y'), 0, 1);
$pdf->Ln(5);

if (!empty($notas)) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(120, 10, 'Materia', 1);
    $pdf->Cell(40, 10, 'Calificación', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    foreach ($notas as $nota) {
        $materia = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $nota['materia']);
        $calificacion = $nota['calificacion'];
        $pdf->Cell(120, 10, $materia, 1);
        $pdf->Cell(40, 10, $calificacion, 1);
        $pdf->Ln();
    }
} else {
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->MultiCell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', "Este estudiante aún no tiene calificaciones registradas.

Este boletín ha sido generado únicamente como documento informativo."));
}

$pdf->Output('D', "Boletin_$dniEstudiante.pdf");
exit;
?>
