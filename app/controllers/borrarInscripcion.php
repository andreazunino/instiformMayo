<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../lib/auth.php';

$smarty = new Smarty\Smarty();
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$inscripcionModel = new Inscripcion($pdo);
requireLogin(['admin']);

$mensaje = '';
$mensaje_error = '';
$inscripciones = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'buscar') {
    $dni = $_POST['dniAlumno'] ?? '';
    $materia = $_POST['nombreMateria'] ?? '';

    if (!empty($dni)) {
        $inscripciones = $inscripcionModel->buscarInscripciones($dni, $materia);

        if (count($inscripciones) === 0) {
            $mensaje = 'No se encontraron inscripciones que coincidan con los criterios.';
            $mensaje_tipo = 'warning';
        } else {
            $smarty->assign('inscripciones', $inscripciones);
        }
    } else {
        $mensaje_error = 'Debe ingresar el DNI del alumno.';
    }
}

// Si se solicita eliminar una inscripción por ID
if (isset($_GET['id'])) {
    $idInscripcion = $_GET['id'];
    $exito = $inscripcionModel->eliminarPorId($idInscripcion);

    if ($exito) {
        $mensaje = 'Inscripción eliminada correctamente.';
    } else {
        $mensaje_error = 'No se pudo eliminar la inscripción.';
    }
}

// Asignar mensajes a la plantilla si existen
if (!empty($mensaje)) {
    $smarty->assign('mensaje', $mensaje);
    $smarty->assign('mensaje_tipo', $mensaje_tipo ?? 'success');
}
if (!empty($mensaje_error)) {
    $smarty->assign('mensaje_error', $mensaje_error);
}

$smarty->assign('inscripciones', $inscripciones);

$smarty->display('borrarInscripcion.tpl');
