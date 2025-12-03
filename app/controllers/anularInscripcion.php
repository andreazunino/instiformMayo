<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../lib/auth.php';

$smarty = new Smarty\Smarty;
$inscripcionModel = new Inscripcion($pdo);
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');
$usuario = currentUser();
$dniEstudiante = $_POST['dni'] ?? $_POST['dniEstudiante'] ?? $_GET['dni'] ?? ($usuario['dni'] ?? null);

requireLogin(['estudiante']);
$smarty->assign('usuario', $usuario);
$smarty->assign('dniEstudiante', $dniEstudiante);

// Si se quiere anular una inscripcion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idCursoAnular'], $_POST['dniEstudiante'])) {
    $idCurso = $_POST['idCursoAnular'];

    $exito = $inscripcionModel->anular($dniEstudiante, $idCurso);
    if ($exito) {
        $smarty->assign('mensaje', 'Inscripción anulada correctamente.');
        $smarty->assign('mensaje_tipo', 'success');
    } else {
        $smarty->assign('mensaje', 'No se pudo anular la inscripción.');
        $smarty->assign('mensaje_tipo', 'danger');
    }

    // Refrescamos cursos
    $cursos = $inscripcionModel->obtenerCursosPorDNI($dniEstudiante);
    $smarty->assign('cursos', $cursos);
    $smarty->assign('dniEstudiante', $dniEstudiante);
}

// Si viene solo la busqueda por DNI
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dni'])) {
    $cursos = $inscripcionModel->obtenerCursosPorDNI($dniEstudiante);

    if (count($cursos) > 0) {
        $smarty->assign('cursos', $cursos);
    } else {
        $smarty->assign('mensaje', 'No estás inscrito en ningún curso.');
        $smarty->assign('mensaje_tipo', 'info');
    }

    $smarty->assign('dniEstudiante', $dniEstudiante);
}

// Carga automatica para estudiante logueado con DNI
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $dniEstudiante) {
    $cursos = $inscripcionModel->obtenerCursosPorDNI($dniEstudiante);
    if (count($cursos) > 0) {
        $smarty->assign('cursos', $cursos);
        $smarty->assign('dniEstudiante', $dniEstudiante);
    } else {
        $smarty->assign('mensaje', 'No estás inscrito en ningún curso.');
        $smarty->assign('mensaje_tipo', 'info');
    }
}

$smarty->display('anularInscripcion.tpl');
