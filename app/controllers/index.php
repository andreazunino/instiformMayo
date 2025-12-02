<?php
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../lib/auth.php';

requireLogin();

$usuario = currentUser();
if ($usuario) {
    redirectToDashboard($usuario);
}

$smarty = new Smarty\Smarty;
$smarty->display('../templates/index.tpl');
