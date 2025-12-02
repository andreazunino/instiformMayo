<?php

require_once __DIR__ . '/../../config/constants.php';
require_once APP_ROOT . '/app/lib/fpdf/fpdf.php';

class BoletinPdf extends FPDF
{
    private const COLOR_PRIMARY = [33, 90, 140];
    private const COLOR_TEXT = [55, 64, 74];
    private const COLOR_ROW_ALT = [248, 250, 253];
    private const COLOR_BORDER = [220, 226, 235];

    private $logoPath;
    private $footerText;
    private $periodoLabel = null;
    private $firmaNombre = null;
    private $firmaCargo = null;
    private $firmaPath = null;

    public function __construct(?string $logoPath = null, ?string $footerText = null)
    {
        parent::__construct();
        $this->logoPath = $this->resolveLogoPath($logoPath);
        $this->footerText = $footerText ?? APP_PDF_FOOTER_TEXT;
        $this->SetMargins(20, 25, 20);
        $this->SetAutoPageBreak(true, 25);
    }

    public static function convertirTexto(string $texto): string
    {
        $convertido = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $texto);
        return $convertido !== false ? $convertido : $texto;
    }

    public function setPeriodo(?string $desde, ?string $hasta): void
    {
        if ($desde || $hasta) {
            $this->periodoLabel = trim(($desde ?? '') . ' - ' . ($hasta ?? ''), ' -');
        }
    }

    public function setFirma(?string $nombre, ?string $cargo = null, ?string $firmaPath = null): void
    {
        $this->firmaNombre = $nombre;
        $this->firmaCargo = $cargo;
        $this->firmaPath = $firmaPath;
    }

    public function Header(): void
    {
        if ($this->logoPath !== '' && file_exists($this->logoPath)) {
            $this->Image($this->logoPath, 15, 12, 28);
        }

        $this->SetDrawColor(200, 200, 200);
        $this->Line(15, 40, 195, 40);

        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(33, 37, 41);
        $this->Cell(0, 12, self::convertirTexto('Boletín de Calificaciones'), 0, 1, 'C');
        $this->Ln(6);
    }

    public function Footer(): void
    {
        $this->SetY(-18);
        $this->SetDrawColor(220, 220, 220);
        $this->Line(15, $this->GetY(), 195, $this->GetY());

        $this->SetFont('Arial', 'I', 9);
        $this->SetTextColor(120, 130, 140);
        $this->Cell(0, 10, self::convertirTexto($this->footerText), 0, 0, 'C');
    }

    public function renderEncabezadoEstudiante(array $estudiante, string $dni, ?string $fecha = null): void
    {
        $fecha = $fecha ?? date('d/m/Y');
        $apellido = $estudiante['apellido'] ?? '';
        $nombre = $estudiante['nombre'] ?? '';
        $nombreCompleto = trim($apellido . ', ' . $nombre, ', ');

        [$rt, $gt, $bt] = self::COLOR_TEXT;

        $this->SetFont('Arial', '', 12);
        $this->SetTextColor($rt, $gt, $bt);
        $this->Cell(0, 8, self::convertirTexto('Estudiante: ' . $nombreCompleto), 0, 1);
        $this->Cell(0, 8, self::convertirTexto('DNI: ' . $dni), 0, 1);
        $this->Cell(0, 8, self::convertirTexto('Fecha: ' . $fecha), 0, 1);
        if ($this->periodoLabel) {
            $this->Cell(0, 8, self::convertirTexto('Periodo: ' . $this->periodoLabel), 0, 1);
        }
        $this->Ln(6);
    }

    public function renderTablaNotas(array $notas): void
    {
        $tablaWidth = $this->GetPageWidth() - $this->lMargin - $this->rMargin;
        $colNota = $tablaWidth * 0.6;
        $colMateria = $tablaWidth - $colNota;

        $this->renderTablaHeader($colMateria, $colNota);
        $fill = false;

        foreach ($notas as $nota) {
            if ($this->GetY() + 9 > $this->PageBreakTrigger) {
                $this->Cell($colMateria + $colNota, 0, '', 'T');
                $this->AddPage();
                $this->renderTablaHeader($colMateria, $colNota);
                $fill = false;
            }

            $materia = self::convertirTexto($nota['materia'] ?? '');
            $calificacionTexto = $this->formatearCalificacionesTexto($nota);

            $this->Cell($colMateria, 9, $materia, 'LR', 0, 'L', $fill);
            $this->Cell($colNota, 9, $calificacionTexto, 'LR', 1, 'L', $fill);
            $fill = !$fill;
        }

        $this->Cell($colMateria + $colNota, 0, '', 'T');
    }

    public function renderMensajeSinNotas(string $mensaje): void
    {
        [$rt, $gt, $bt] = self::COLOR_TEXT;

        $this->SetFont('Arial', 'I', 12);
        $this->SetTextColor($rt, $gt, $bt);
        $this->MultiCell(0, 8, self::convertirTexto($mensaje));
    }

    public function renderSeccionFirma(): void
    {
        if (empty($this->firmaNombre)) {
            return;
        }

        $this->Ln(14);
        $y = $this->GetY();

        if (!empty($this->firmaPath) && file_exists($this->firmaPath)) {
            $this->Image($this->firmaPath, $this->GetX(), $y - 4, 40);
        }

        $this->SetDrawColor(180, 180, 180);
        $this->Line($this->GetX(), $y + 14, $this->GetX() + 60, $y + 14);

        $this->Ln(16);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(60, 7, self::convertirTexto($this->firmaNombre), 0, 1, 'L');

        if (!empty($this->firmaCargo)) {
            $this->SetFont('Arial', '', 10);
            $this->Cell(60, 6, self::convertirTexto($this->firmaCargo), 0, 1, 'L');
        }
    }

    private function resolveLogoPath(?string $logoPath): string
    {
        $candidates = array_filter([
            $logoPath,
            defined('APP_LOGO_PATH') ? APP_LOGO_PATH : null,
            defined('APP_LOGO_FALLBACK_PATH') ? APP_LOGO_FALLBACK_PATH : null,
        ]);

        foreach ($candidates as $candidate) {
            if ($candidate !== null && file_exists($candidate)) {
                return $candidate;
            }
        }

        return '';
    }

    private function renderTablaHeader(float $colMateria, float $colNota): void
    {
        [$rp, $gp, $bp] = self::COLOR_PRIMARY;
        [$rt, $gt, $bt] = self::COLOR_TEXT;
        [$rb, $gb, $bb] = self::COLOR_BORDER;
        [$ra, $ga, $ba] = self::COLOR_ROW_ALT;

        $this->SetFillColor($rp, $gp, $bp);
        $this->SetTextColor(255, 255, 255);
        $this->SetDrawColor($rp, $gp, $bp);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell($colMateria, 10, self::convertirTexto('Materia'), 1, 0, 'L', true);
        $this->Cell($colNota, 10, self::convertirTexto('Calificaciones'), 1, 1, 'L', true);

        $this->SetFont('Arial', '', 12);
        $this->SetTextColor($rt, $gt, $bt);
        $this->SetDrawColor($rb, $gb, $bb);
        $this->SetFillColor($ra, $ga, $ba);
    }

    private function formatearCalificacionesTexto(array $nota): string
    {
        if (!empty($nota['calificaciones']) && is_array($nota['calificaciones'])) {
            $partes = [];
            foreach ($nota['calificaciones'] as $detalle) {
                $valor = isset($detalle['valor']) ? (string) $detalle['valor'] : '';
                if ($valor === '') {
                    continue;
                }

                $segmentos = [];
                if (!empty($detalle['actividad'])) {
                    $segmentos[] = $detalle['actividad'];
                }

                $meta = [];
                if (isset($detalle['peso']) && $detalle['peso'] !== '' && (float) $detalle['peso'] !== 1.0) {
                    $meta[] = 'peso ' . $detalle['peso'];
                }
                if (!empty($detalle['fecha_formateada'])) {
                    $meta[] = $detalle['fecha_formateada'];
                }
                if (!empty($meta)) {
                    $valor .= ' (' . implode(' · ', $meta) . ')';
                }

                if (!empty($segmentos)) {
                    $segmentos[] = $valor;
                    $partes[] = implode(' - ', $segmentos);
                } else {
                    $partes[] = $valor;
                }
            }

            if (!empty($partes)) {
                return self::convertirTexto(implode(' / ', $partes));
            }
        }

        if (isset($nota['calificacion']) && $nota['calificacion'] !== '') {
            return self::convertirTexto((string) $nota['calificacion']);
        }

        return '-';
    }
}
