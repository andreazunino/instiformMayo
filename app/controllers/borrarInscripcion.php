<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../models/Estudiante.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../lib/auth.php';

$smarty = new Smarty\Smarty();
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$inscripcionModel = new Inscripcion($pdo);
$estudianteModel = new Estudiante($pdo);
requireLogin(['admin']);

$mensaje = '';
$mensaje_error = '';
$inscripciones = [];
$estudiante = null;
$dniBuscado = trim($_POST['dniAlumno'] ?? ($_GET['dni'] ?? ''));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'buscar') {
    if (!empty($dniBuscado)) {
        $estudiante = $estudianteModel->obtenerPorDNI($dniBuscado);

        if ($estudiante) {
            $inscripciones = $inscripcionModel->buscarInscripciones($dniBuscado, '');

            if (count($inscripciones) === 0) {
                $mensaje = 'No se encontraron inscripciones que coincidan con los criterios.';
                $mensaje_tipo = 'warning';
            } else {
                $smarty->assign('inscripciones', $inscripciones);
            }
        } else {
            $mensaje = 'No se encontro un estudiante con ese DNI.';
            $mensaje_tipo = 'warning';
        }
    } else {
        $mensaje_error = 'Debe ingresar el DNI del alumno.';
    }
}

// Si se solicita eliminar una inscripcion por ID
if (isset($_GET['id'])) {
    $idInscripcion = $_GET['id'];
    $exito = $inscripcionModel->eliminarPorId($idInscripcion);

    if ($exito) {
        $mensaje = 'Inscripcion eliminada correctamente.';
    } else {
        $mensaje_error = 'No se pudo eliminar la inscripcion.';
    }

    // Tras eliminar, si tenemos un DNI cargado volvemos a mostrar datos restantes
    if (!empty($dniBuscado)) {
        $estudiante = $estudianteModel->obtenerPorDNI($dniBuscado);
        if ($estudiante) {
            $inscripciones = $inscripcionModel->buscarInscripciones($dniBuscado, '');
            $smarty->assign('inscripciones', $inscripciones);
        }
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
$smarty->assign('estudiante', $estudiante);
$smarty->assign('dni_buscado', $dniBuscado);

$smarty->display('borrarInscripcion.tpl');
