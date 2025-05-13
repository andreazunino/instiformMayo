<?php
// Cargar la clase principal de Smarty

require __DIR__ . '/app/lib/Smarty/libs/Smarty.class.php';


// Crear una instancia de Smarty
$smarty = new Smarty\Smarty;

// Configurar rutas de Smarty
$smarty->setTemplateDir(__DIR__ . '/app/views/');
$smarty->setCompileDir(__DIR__ . '/app/templates_c/');

// Mostrar la plantilla principal
$smarty->display('index.tpl');

