<?php
/* Smarty version 5.4.0, created on 2025-06-08 00:28:37
  from 'file:listarCursos.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_6844bd15639cc4_04449044',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5a50f3ee3c3e3e726cc6e120265e1c5ab71afb98' => 
    array (
      0 => 'listarCursos.tpl',
      1 => 1749335315,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_6844bd15639cc4_04449044 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\InstiforMayo\\instiformMayo\\app\\views';
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

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link" href="menuAdministrador.php">Volver al Menú Administrador</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container text-center">
    <!-- Formulario de búsqueda por nombre -->
    <h3>Buscar Cursos por Nombre</h3>
    <form method="POST" class="mb-4">
        <input type="hidden" name="accion" value="buscar">
        <div class="form-group">
            <input type="text" class="form-control" name="nombreCurso" placeholder="Ingrese el nombre del curso" value="<?php echo (($tmp = $_smarty_tpl->getValue('nombreCurso') ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" autocomplete="off">
        </div>
        <button type="submit" class="btn-custom">Buscar</button>
    </form>

    <!-- Mostrar mensaje -->
    <?php if ($_smarty_tpl->getValue('mensaje')) {?>
        <div class="alert alert-<?php echo $_smarty_tpl->getValue('mensaje_tipo');?>
 mt-3"><?php echo $_smarty_tpl->getValue('mensaje');?>
</div>
    <?php }?>

    <!-- Mostrar cursos -->
    <?php if ($_smarty_tpl->getValue('cursos')) {?>
        <h3 class="mt-4">Resultados</h3>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Curso</th>
                    <th>Cupo Disponible</th>
                </tr>
            </thead>
            <tbody>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('cursos'), 'curso');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('curso')->value) {
$foreach0DoElse = false;
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->getValue('curso')['id'];?>
</td>
                        <td><?php echo $_smarty_tpl->getValue('curso')['nombre'];?>
</td>
                        <td><?php echo $_smarty_tpl->getValue('curso')['cupo'];?>
</td>
                    </tr>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="mt-4">No se encontraron cursos.</p>
    <?php }?>
</div>

<!-- Footer -->
<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<!-- Scripts necesarios para Bootstrap -->
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
