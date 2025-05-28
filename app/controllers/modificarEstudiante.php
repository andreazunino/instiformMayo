<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../models/Estudiante.php';

$smarty = new Smarty\Smarty;
$estudianteModel = new Estudiante($pdo);
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

// Si se está modificando
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['dni'])) {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];

    $exito = $estudianteModel->modificar($dni, $nombre, $apellido, $email);
    if ($exito) {
        $smarty->assign('mensaje', 'Estudiante modificado correctamente.');
    } else {
        $smarty->assign('mensaje', 'Error al modificar el estudiante.');
    }

    $estudiante = $estudianteModel->obtenerPorDNI($dni);
    $smarty->assign('estudiante', $estudiante);

// Si se busca estudiante por DNI
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dni'])) {
    $dni = $_POST['dni'];
    $estudiante = $estudianteModel->obtenerPorDNI($dni);

    if ($estudiante) {
        $smarty->assign('estudiante', $estudiante);
    } else {
        $smarty->assign('mensaje', 'No se encontró un estudiante con ese DNI.');
        $smarty->assign('mensaje_tipo', 'warning');
    }
}

$smarty->display('modificarEstudiante.tpl');
