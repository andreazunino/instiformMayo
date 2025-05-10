<?php
require_once '../../sql/db.php';
require_once '../../models/Inscripcion.php';
require_once '../../lib/smarty/libs/Smarty.class.php';

$smarty = new Smarty\Smarty;
$inscripcionModel = new Inscripcion($pdo);

// Obtener el DNI del formulario si viene
$dniEstudiante = $_POST['dni_estudiante'] ?? null;

// Si viene la acción de guardar nota
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ingresar_nota'])) {
    $idCurso = $_POST['id_curso'];
    $nota = $_POST['nota'];

    if (!is_numeric($nota) || $nota < 1 || $nota > 10) {
        $smarty->assign('mensaje', 'La nota debe ser un número entre 1 y 10.');
        $smarty->assign('mensaje_tipo', 'warning');
    } else {
        $exito = $inscripcionModel->guardarNota($dniEstudiante, $idCurso, $nota);

        if ($exito) {
            $smarty->assign('mensaje', 'Nota guardada correctamente.');
            $smarty->assign('mensaje_tipo', 'success');
        } else {
            $smarty->assign('mensaje', 'No se pudo guardar la nota.');
            $smarty->assign('mensaje_tipo', 'danger');
        }
    }

    // Refrescar cursos después de la operación
    $cursos = $inscripcionModel->obtenerCursosPorDNI($dniEstudiante);
    $smarty->assign('cursos', $cursos);
    $smarty->assign('dniEstudiante', $dniEstudiante);

// Si solo se quiere buscar cursos por DNI
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscar_dni'])) {
    $cursos = $inscripcionModel->obtenerCursosPorDNI($dniEstudiante);

    if (count($cursos) > 0) {
        $smarty->assign('cursos', $cursos);
    } else {
        $smarty->assign('mensaje', 'Este estudiante no está inscrito en ningún curso.');
        $smarty->assign('mensaje_tipo', 'info');
    }

    $smarty->assign('dniEstudiante', $dniEstudiante);
}

$smarty->display('../../templates/notas.tpl');
