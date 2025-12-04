<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../models/Estudiante.php';
require_once __DIR__ . '/../lib/auth.php';

$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$inscripcionModel = new Inscripcion($pdo);
$estudianteModel = new Estudiante($pdo);

requireLogin(['estudiante']);
$usuario = currentUser();
$smarty->assign('usuario', $usuario);

$dniEstudiante = $_POST['dni'] ?? $_POST['dniEstudiante'] ?? $_GET['dni'] ?? ($usuario['dni'] ?? null);
$smarty->assign('dniEstudiante', $dniEstudiante);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estudianteValido = true;

    if ($dniEstudiante) {
        $estudiante = $estudianteModel->obtenerPorDNI($dniEstudiante);
        if (
            !$estudiante &&
            $usuario &&
            ($usuario['role'] ?? null) === 'estudiante' &&
            ($usuario['dni'] ?? null) === $dniEstudiante
        ) {
            // Auto-registra al estudiante con los datos de la cuenta si falta en la tabla
            $estudianteModel->crear(
                $dniEstudiante,
                $usuario['nombre'] !== null && $usuario['nombre'] !== '' ? $usuario['nombre'] : ($usuario['username'] ?? 'Estudiante'),
                $usuario['apellido'] !== null && $usuario['apellido'] !== '' ? $usuario['apellido'] : ' ',
                $usuario['email'] ?? (($usuario['username'] ?? 'usuario') . '@example.com')
            );
            $estudiante = $estudianteModel->obtenerPorDNI($dniEstudiante);
        }
        if (!$estudiante) {
            $estudianteValido = false;
            $smarty->assign('mensaje', 'El DNI ingresado no corresponde a un estudiante registrado.');
            $smarty->assign('mensaje_tipo', 'danger');
        }
    }

    if ($estudianteValido && isset($_POST['idCurso'], $_POST['dniEstudiante'])) {
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
            }
        }

        $smarty->assign('mensaje', $exito
            ? 'Te inscribiste correctamente al curso.'
            : 'No se pudo realizar la inscripcion.');
        $smarty->assign('mensaje_tipo', $exito ? 'success' : 'danger');
    }

    if ($dniEstudiante && $estudianteValido) {
        $cursos = $inscripcionModel->cursosDisponiblesParaEstudiante($dniEstudiante);

        if (!empty($cursos)) {
            $smarty->assign('cursos', $cursos);
        } else {
            $smarty->assign('mensaje', 'No hay cursos disponibles para tu inscripcion.');
            $smarty->assign('mensaje_tipo', 'warning');
        }

        $smarty->assign('dniEstudiante', $dniEstudiante);
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $dniEstudiante) {
    $cursos = $inscripcionModel->cursosDisponiblesParaEstudiante($dniEstudiante);
    if (!empty($cursos)) {
        $smarty->assign('cursos', $cursos);
    } else {
        $smarty->assign('mensaje', 'No hay cursos disponibles para tu inscripcion.');
        $smarty->assign('mensaje_tipo', 'info');
    }
}

$smarty->display('inscribirCurso.tpl');
