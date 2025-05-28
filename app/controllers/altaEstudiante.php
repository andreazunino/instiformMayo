<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../models/Estudiante.php'; // ✅ Agregado

$smarty = new Smarty\Smarty;
$estudianteModel = new Estudiante($pdo);
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];

    if (!empty($dni) && !empty($nombre) && !empty($apellido) && !empty($email)) {
        $exito = $estudianteModel->crear($dni, $nombre, $apellido, $email);
        if ($exito) {
            $smarty->assign('mensaje', 'Estudiante registrado con éxito.');
            $smarty->assign('mensaje_tipo', 'success');
        } else {
            $smarty->assign('mensaje', 'Hubo un error al registrar al estudiante.');
            $smarty->assign('mensaje_tipo', 'danger');
        }
    } else {
        $smarty->assign('mensaje', 'Todos los campos son obligatorios.');
        $smarty->assign('mensaje_tipo', 'warning');
    }
}

$smarty->display('altaEstudiante.tpl');
