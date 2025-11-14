<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../models/Estudiante.php';
// Asegurate de tener este modelo

$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$inscripcionModel = new Inscripcion($pdo);
$estudianteModel = new Estudiante($pdo);

$dniEstudiante = $_POST['dni'] ?? $_POST['dniEstudiante'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estudianteValido = true;

    if ($dniEstudiante) {
        $estudiante = $estudianteModel->obtenerPorDNI($dniEstudiante);
        if (!$estudiante) {
            $estudianteValido = false;
            $smarty->assign('mensaje', 'El DNI ingresado no corresponde a un estudiante registrado.');
            $smarty->assign('mensaje_tipo', 'danger');
        }
    }

    // Inscripción del curso
    if ($estudianteValido && isset($_POST['idCurso'], $_POST['dniEstudiante'])) {
        $idCurso = $_POST['idCurso'];
        try {
            $exito = $inscripcionModel->inscribir($dniEstudiante, $idCurso);
        } catch (PDOException $e) {
            $exito = false;
        }

        $smarty->assign('mensaje', $exito
            ? 'Te inscribiste correctamente al curso.'
            : 'No se pudo realizar la inscripción.');
        $smarty->assign('mensaje_tipo', $exito ? 'success' : 'danger');
    }

    // Buscar cursos disponibles para ese estudiante
    if ($dniEstudiante && $estudianteValido) {
        $cursos = $inscripcionModel->cursosDisponiblesParaEstudiante($dniEstudiante);

        if (!empty($cursos)) {
            $smarty->assign('cursos', $cursos);
        } else {    
            $smarty->assign('mensaje', 'No hay cursos disponibles para tu inscripción.');
            $smarty->assign('mensaje_tipo', 'warning');
        }

        $smarty->assign('dniEstudiante', $dniEstudiante);
    }
}

$smarty->display('inscribirCurso.tpl');
