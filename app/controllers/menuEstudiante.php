<?php
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../lib/auth.php';

$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

requireLogin(['estudiante']);
$usuario = currentUser();
$smarty->assign('usuario', $usuario);

$smarty->display('menuEstudiante.tpl');
