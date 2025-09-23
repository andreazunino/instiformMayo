<?php
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

if (!defined('APP_PUBLIC_PATH')) {
    define('APP_PUBLIC_PATH', APP_ROOT . '/public');
}

if (!defined('APP_IMAGE_PATH')) {
    define('APP_IMAGE_PATH', APP_PUBLIC_PATH . '/img');
}

if (!defined('APP_FONT_PATH')) {
    define('APP_FONT_PATH', APP_ROOT . '/app/lib/font/');
}

if (!defined('FPDF_FONTPATH')) {
    define('FPDF_FONTPATH', APP_FONT_PATH);
}

if (!defined('APP_LOGO_PATH')) {
    define('APP_LOGO_PATH', APP_IMAGE_PATH . '/Logo Instiform.png');
}

if (!defined('APP_LOGO_FALLBACK_PATH')) {
    define('APP_LOGO_FALLBACK_PATH', APP_IMAGE_PATH . '/logo-instiform.png');
}

if (!defined('APP_PDF_FOOTER_TEXT')) {
    define('APP_PDF_FOOTER_TEXT', 'Documento generado por Instiform – Sistema de Gestión');
}
?>
