<?php
require_once '../../sql/db.php';
require_once '../../models/Estudiante.php';
require_once '../../lib/smarty/libs/Smarty.class.php';

$smarty = new Smarty\Smarty;
$estudianteModel = new Estudiante($pdo);

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

$smarty->display('../../templates/altaEstudiante.tpl');
