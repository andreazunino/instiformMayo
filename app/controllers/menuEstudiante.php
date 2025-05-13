<?php
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../lib/Smarty/libs/Autoloader.php';

Smarty_Autoloader::register();

$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$smarty->display('menuEstudiante.tpl');
