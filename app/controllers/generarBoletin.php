<?php
require_once(__DIR__ . '/../../sql/db.php');
require_once(__DIR__ . '/../models/Inscripcion.php');

if (!defined('FPDF_FONTPATH')) {
    define('FPDF_FONTPATH', __DIR__ . '/../lib/font/');
}

require_once(__DIR__ . '/../lib/fpdf/fpdf.php'); // Librería para generar PDF

function convertirTexto(string $texto): string
{
    $convertido = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $texto);
    return $convertido !== false ? $convertido : $texto;
}

class PDFBoletin extends FPDF
{
    public function Header(): void
    {
        $logoPath = __DIR__ . '/../../public/img/Logo Instiform.png';
        if (!file_exists($logoPath)) {
            $logoPath = __DIR__ . '/../../public/img/logo-instiform.png';
        }

        if (file_exists($logoPath)) {
            $this->Image($logoPath, 15, 12, 28);
        }

        $this->SetDrawColor(200, 200, 200);
        $this->Line(15, 40, 195, 40);

        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(33, 37, 41);
        $this->Cell(0, 12, convertirTexto('Boletín de Calificaciones'), 0, 1, 'C');
        $this->Ln(6);
    }

    public function Footer(): void
    {
        $this->SetY(-18);
        $this->SetDrawColor(220, 220, 220);
        $this->Line(15, $this->GetY(), 195, $this->GetY());

        $this->SetFont('Arial', 'I', 9);
        $this->SetTextColor(120, 130, 140);
        $this->Cell(0, 10, convertirTexto('Documento generado por Instiform – Sistema de Gestión'), 0, 0, 'C');
    }
}

$dni = $_GET['dni'] ?? null;

if (!$dni) {
    die('DNI no proporcionado.');
}

// Obtener datos del estudiante para mostrar en el PDF
$stmt = $pdo->prepare('SELECT nombre, apellido FROM estudiante WHERE dni = ?');
$stmt->execute([$dni]);
$estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$estudiante) {
    die('Estudiante no encontrado.');
}

$inscripcionModel = new Inscripcion($pdo);
$notas = $inscripcionModel->obtenerNotasPorDNI($dni);

if (!$notas) {
    die('No se encontraron calificaciones.');
}

// Crear PDF
$pdf = new PDFBoletin();
$pdf->SetMargins(20, 25, 20);
$pdf->SetAutoPageBreak(true, 25);
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(55, 64, 74);

$nombreCompleto = $estudiante['apellido'] . ', ' . $estudiante['nombre'];
$pdf->Cell(0, 8, convertirTexto('Estudiante: ' . $nombreCompleto), 0, 1);
$pdf->Cell(0, 8, convertirTexto('DNI: ' . $dni), 0, 1);
$pdf->Cell(0, 8, convertirTexto('Fecha: ' . date('d/m/Y')), 0, 1);
$pdf->Ln(6);

// Encabezado de tabla estilizado
$colMateria = 130;
$colNota = 50;

$pdf->SetFillColor(33, 90, 140);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetDrawColor(33, 90, 140);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell($colMateria, 10, convertirTexto('Materia'), 1, 0, 'L', true);
$pdf->Cell($colNota, 10, convertirTexto('Calificación'), 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(55, 64, 74);
$pdf->SetDrawColor(220, 226, 235);
$pdf->SetFillColor(248, 250, 253);
$fill = false;
foreach ($notas as $nota) {
    $materia = convertirTexto($nota['materia']);
    $calificacionValor = isset($nota['calificacion']) ? (string) $nota['calificacion'] : '-';
    $calificacion = convertirTexto($calificacionValor);

    $pdf->Cell($colMateria, 9, $materia, 'LR', 0, 'L', $fill);
    $pdf->Cell($colNota, 9, $calificacion, 'LR', 1, 'C', $fill);
    $fill = !$fill;
}

// Línea de cierre de tabla
$pdf->Cell($colMateria + $colNota, 0, '', 'T');

$pdf->Output('I', 'Boletin_' . $dni . '.pdf');
