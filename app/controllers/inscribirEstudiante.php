<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../models/Curso.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../models/Estudiante.php';
require_once __DIR__ . '/../lib/auth.php';

$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$inscripcionModel = new Inscripcion($pdo);
$estudianteModel = new Estudiante($pdo);
$cursoModel = new Curso($pdo);

requireLogin(['admin']);

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

    // Si viene la solicitud de inscripcion
    if ($estudianteValido && isset($_POST['accion']) && $_POST['accion'] === 'inscribir' && isset($_POST['idCurso'], $_POST['dniEstudiante'])) {
        $idCurso = $_POST['idCurso'];

        try {
            $inscripcionId = $inscripcionModel->inscribir($dniEstudiante, $idCurso);
        } catch (PDOException $e) {
            $inscripcionId = false;
        }
        $exito = $inscripcionId !== false;

        if ($exito && $inscripcionId) {
            $detalle = $inscripcionModel->obtenerInscripcionPorId((int) $inscripcionId);
            $smarty->assign('comprobante_id', (int) $inscripcionId);
            if ($detalle) {
                $smarty->assign('comprobante_curso', $detalle['curso'] ?? null);
                $smarty->assign('comprobante_dni', $detalle['dni'] ?? null);
            }
        }
        $smarty->assign('mensaje', $exito ? "Estudiante inscrito correctamente." : "Error al inscribir. Posiblemente ya esta inscrito.");
        $smarty->assign('mensaje_tipo', $exito ? "success" : "danger");
    }

    // Si viene el DNI para buscar cursos
    if ($dniEstudiante && $estudianteValido) {
        $cursos = $inscripcionModel->cursosDisponiblesParaEstudiante($dniEstudiante);

        if (count($cursos) > 0) {
            $smarty->assign('cursos', $cursos);
        } else {
            $smarty->assign('mensaje', 'No hay cursos disponibles para este estudiante.');
            $smarty->assign('mensaje_tipo', 'warning');
        }

        $smarty->assign('dniEstudiante', $dniEstudiante);
    }
}

$smarty->display('inscribirEstudiante.tpl');
