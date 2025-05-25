<?php
require_once __DIR__ . '/../lib/Smarty/libs/Autoloader.php';
Smarty_Autoloader::register();

require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';

$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$smarty->display('menuAdministrador.tpl');
