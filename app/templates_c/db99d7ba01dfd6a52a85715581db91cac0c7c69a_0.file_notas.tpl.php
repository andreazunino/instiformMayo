<?php
/* Smarty version 5.4.0, created on 2025-12-04 12:48:35
  from 'file:notas.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_693175138193d2_74349856',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'db99d7ba01dfd6a52a85715581db91cac0c7c69a' => 
    array (
      0 => 'notas.tpl',
      1 => 1764848882,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_693175138193d2_74349856 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\InstiformMayo\\app\\views';
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
   <?php $_smarty_tpl->renderSubTemplate('file:head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
    <style>
        .logo-small {
            max-width: 80px;
            margin-top: 10px;
        }
        .panel-card {
            max-width: 720px;
            margin: 0 auto;
            text-align: left;
        }
        .panel-card .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
        .panel-table {
            max-width: 720px;
            margin: 0 auto;
            text-align: left;
        }
        .panel-table .table th {
            width: 35%;
            vertical-align: middle;
            text-align: center;
        }
        .panel-table .table td {
            vertical-align: middle;
        }
        .acciones-nota {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        .acciones-nota form {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin: 0;
        }
        .acciones-nota .form-editar input[type="number"] {
            width: 80px;
        }
        .historial-table thead {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

<!-- Botón de cerrar sesión -->
<button class="btn btn-logout" onclick="window.location.href='logout.php'">Cerrar sesión</button>

<!-- Encabezado con logo -->
<div class="container-fluid text-center welcome-section">
    <img src="../../public/img/Logo Instiform.png" alt="Logo de Instiform" class="logo-small">
    <h1 class="welcome-heading">Instiform</h1>
</div>

<!-- Menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto d-flex">
            <li class="nav-item">
                <a class="nav-link" href="menuAdministrador.php">Volver al Menú Administrador</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container text-center mt-4">

    <!-- Mensaje -->
    <?php if ((null !== ($_smarty_tpl->getValue('mensaje') ?? null))) {?>
        <div class="alert alert-<?php echo $_smarty_tpl->getValue('mensaje_tipo');?>
" role="alert">
            <?php echo $_smarty_tpl->getValue('mensaje');?>

        </div>
    <?php }?>

    <!-- Formulario de búsqueda por DNI -->
    <h3 class="mb-4">Buscar Estudiante por DNI</h3>
    <form action="" method="POST" class="panel-card text-left mb-4">
        <input type="hidden" name="accion" value="buscar">
        <div class="form-group">
            <label for="dni_estudiante">DNI:</label>
            <input type="text" class="form-control" id="dni_estudiante" name="dni_estudiante"
                   value="<?php echo $_smarty_tpl->getValue('dniEstudiante');?>
" required pattern="\d+" autocomplete="off">
        </div>
        <div class="text-center">
            <button type="submit" name="buscar_dni" class="btn-formal">Buscar</button>
        </div>
    </form>

    <!-- Datos del estudiante -->
    <?php if ($_smarty_tpl->getValue('estudiante')) {?>
        <h3 class="mt-4">Datos del Estudiante</h3>
        <div class="panel-table">
            <table class="table table-striped mt-3 mb-0">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $_smarty_tpl->getValue('estudiante')['dni'];?>
</td>
                        <td><?php echo $_smarty_tpl->getValue('estudiante')['nombre'];?>
</td>
                        <td><?php echo $_smarty_tpl->getValue('estudiante')['apellido'];?>
</td>
                        <td><?php echo $_smarty_tpl->getValue('estudiante')['email'];?>
</td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php }?>

    <!-- Formulario para ingresar nota -->
    <?php if ($_smarty_tpl->getValue('estudiante') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('cursos')) > 0) {?>
        <h3 class="mt-4">Ingresar Nota</h3>
        <form action="" method="POST" class="panel-table mb-4 text-left">
            <table class="table table-striped mb-3">
                <tbody>
                    <tr>
                        <th scope="row">Curso</th>
                        <td>
                            <select class="form-control" id="id_curso" name="id_curso" required>
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('cursos'), 'curso');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('curso')->value) {
$foreach0DoElse = false;
?>
                                    <option value="<?php echo $_smarty_tpl->getValue('curso')['id'];?>
"><?php echo $_smarty_tpl->getValue('curso')['nombre'];?>
</option>
                                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Nota</th>
                        <td>
                            <input type="number" class="form-control" id="nota" name="nota" required min="1" max="10" step="1">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Observaciones</th>
                        <td>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="2" placeholder="Texto optativo"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="dni_estudiante" value="<?php echo $_smarty_tpl->getValue('dniEstudiante');?>
">
            <div class="text-center">
                <button type="submit" name="ingresar_nota" class="btn-formal">Guardar Nota</button>
            </div>
        </form>
    <?php } elseif ($_smarty_tpl->getValue('estudiante') && (null !== ($_smarty_tpl->getValue('dniEstudiante') ?? null))) {?>
        <p class="mt-4 text-secondary">El estudiante no está inscrito en ningún curso.</p>
    <?php }?>

    <!-- Historial de calificaciones -->
    <?php if ($_smarty_tpl->getValue('estudiante')) {?>
        <h3 class="mt-4">Historial de Calificaciones</h3>
        <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('historial')) > 0) {?>
            <div class="panel-table table-responsive">
                <table class="table table-striped historial-table">
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Fecha</th>
                            <th>Nota</th>
                            <th>Observaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('historial'), 'registro');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('registro')->value) {
$foreach1DoElse = false;
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->getValue('registro')['materia'];?>
</td>
                                <td><?php if ($_smarty_tpl->getValue('registro')['fecha_formateada']) {
echo $_smarty_tpl->getValue('registro')['fecha_formateada'];
} else { ?>-<?php }?></td>
                                <td><?php echo $_smarty_tpl->getValue('registro')['calificacion'];?>
</td>
                                <td><?php if ($_smarty_tpl->getValue('registro')['observaciones']) {
echo $_smarty_tpl->getValue('registro')['observaciones'];
} else { ?>-<?php }?></td>
                                <td>
                                    <div class="acciones-nota">
                                        <form action="" method="POST" class="form-editar">
                                            <input type="hidden" name="dni_estudiante" value="<?php echo $_smarty_tpl->getValue('dniEstudiante');?>
">
                                            <input type="hidden" name="calificacion_id" value="<?php echo $_smarty_tpl->getValue('registro')['id'];?>
">
                                            <input type="number" name="nota" class="form-control form-control-sm" value="<?php echo $_smarty_tpl->getValue('registro')['calificacion'];?>
" min="1" max="10" step="1" required>
                                            <button type="submit" name="editar_calificacion" class="btn-formal btn-formal-sm">Actualizar</button>
                                            <button type="submit" name="eliminar_calificacion" class="btn-formal btn-formal-danger btn-formal-sm" onclick="return confirm('¿Eliminar esta calificación?');">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <p class="mt-3 mb-0">Este estudiante aún no tiene calificaciones registradas.</p>
        <?php }?>
    <?php }?>
</div>

<!-- Footer -->
<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<!-- Scripts -->
<?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.5.1.slim.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"><?php echo '</script'; ?>
>

</body>
</html>
<?php }
}
