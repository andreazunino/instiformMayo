<?php
require_once __DIR__ . '/../lib/smarty/libs/Smarty.class.php';

$pdo = new PDO('pgsql:host=localhost;dbname=postgres', 'postgres', 'sur2010');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Configurar Smarty
$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . '/../app/views');
$smarty->setCompileDir(__DIR__ . '/../app/templates_c');
$smarty->setCacheDir(__DIR__ . '/../app/cache');
$smarty->setConfigDir(__DIR__);
?>
