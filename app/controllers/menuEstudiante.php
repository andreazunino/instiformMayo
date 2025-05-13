<?php
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';


$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$smarty->display('menuEstudiante.tpl');
