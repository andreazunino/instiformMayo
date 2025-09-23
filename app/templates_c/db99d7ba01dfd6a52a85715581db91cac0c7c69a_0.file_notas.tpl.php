<?php
/* Smarty version 5.4.0, created on 2025-09-23 23:49:29
  from 'file:notas.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_68d315e9273255_26467623',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'db99d7ba01dfd6a52a85715581db91cac0c7c69a' => 
    array (
      0 => 'notas.tpl',
      1 => 1758663700,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68d315e9273255_26467623 (\Smarty\Template $_smarty_tpl) {
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
    </style>
</head>
<body>

<!-- Botón de cerrar sesión -->
<button class="btn btn-logout" onclick="window.location.href='../../index.php'">Cerrar sesión</button>

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
    <form action="" method="POST" class="mb-4">
        <div class="form-group">
            <label for="dni_estudiante">DNI del Estudiante:</label>
            <input type="text" class="form-control" id="dni_estudiante" name="dni_estudiante"
                   value="<?php echo $_smarty_tpl->getValue('dniEstudiante');?>
" required pattern="\d+" autocomplete="off">
        </div>
        <button type="submit" name="buscar_dni" class="btn-custom">Buscar</button>
    </form>

    <!-- Formulario para ingresar nota -->
    <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('cursos')) > 0) {?>
        <h2>Ingresar Nota</h2>
        <form action="" method="POST" class="mb-4">
            <div class="form-group">
                <label for="id_curso">Curso:</label>
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
            </div>
            <div class="form-group">
                <label for="nota">Nota:</label>
                <input type="number" class="form-control" id="nota" name="nota" required min="1" max="10">
            </div>
            <input type="hidden" name="dni_estudiante" value="<?php echo $_smarty_tpl->getValue('dniEstudiante');?>
">
            <button type="submit" name="ingresar_nota" class="btn btn-success">Guardar Nota</button>
        </form>
    <?php } elseif ((null !== ($_smarty_tpl->getValue('dniEstudiante') ?? null))) {?>
        <p class="mt-4 text-warning">El estudiante no está inscrito en ningún curso.</p>
    <?php }?>

    <!-- Historial de calificaciones -->
    <?php if ((null !== ($_smarty_tpl->getValue('historial') ?? null))) {?>
        <h2 class="mt-5">Historial de calificaciones</h2>
        <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('historial')) > 0) {?>
            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Materia</th>
                            <th>Nota</th>
                            <th>Fecha</th>
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
                                <td><?php echo $_smarty_tpl->getValue('registro')['calificacion'];?>
</td>
                                <td><?php if ($_smarty_tpl->getValue('registro')['fecha_formateada']) {
echo $_smarty_tpl->getValue('registro')['fecha_formateada'];
} else { ?>-<?php }?></td>
                                <td>
                                    <form action="" method="POST" class="d-inline-flex align-items-center mb-2 mb-lg-0">
                                        <input type="hidden" name="dni_estudiante" value="<?php echo $_smarty_tpl->getValue('dniEstudiante');?>
">
                                        <input type="hidden" name="calificacion_id" value="<?php echo $_smarty_tpl->getValue('registro')['id'];?>
">
                                        <input type="number" name="nota" class="form-control form-control-sm mr-2" value="<?php echo $_smarty_tpl->getValue('registro')['calificacion'];?>
" min="1" max="10" required>
                                        <button type="submit" name="editar_calificacion" class="btn btn-sm btn-primary">Actualizar</button>
                                    </form>
                                    <form action="" method="POST" class="d-inline">
                                        <input type="hidden" name="dni_estudiante" value="<?php echo $_smarty_tpl->getValue('dniEstudiante');?>
">
                                        <input type="hidden" name="calificacion_id" value="<?php echo $_smarty_tpl->getValue('registro')['id'];?>
">
                                        <button type="submit" name="eliminar_calificacion" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta calificación?');">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <p class="mt-3">Este estudiante aún no tiene calificaciones registradas.</p>
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
