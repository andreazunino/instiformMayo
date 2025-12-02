<?php
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../lib/auth.php';

$smarty = new Smarty\Smarty;  
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

requireLogin(['admin']);
$usuario = currentUser();
$smarty->assign('usuario', $usuario);
$smarty->display('menuAdministrador.tpl');



            
