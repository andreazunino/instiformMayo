<?php
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';

$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

// Verificar existencia real del archivo antes de mostrar
if (!file_exists(__DIR__ . '/../views/head.tpl')) {
    die("❌ El archivo head.tpl no existe en la ruta esperada.");
}

$smarty->display('menuEstudiante.tpl');


