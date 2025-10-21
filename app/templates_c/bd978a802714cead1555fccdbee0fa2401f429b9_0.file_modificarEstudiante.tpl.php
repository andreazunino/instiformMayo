<?php
/* Smarty version 5.4.0, created on 2025-10-22 00:43:21
  from 'file:modificarEstudiante.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_68f80c892908f3_02907762',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bd978a802714cead1555fccdbee0fa2401f429b9' => 
    array (
      0 => 'modificarEstudiante.tpl',
      1 => 1761085016,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_68f80c892908f3_02907762 (\Smarty\Template $_smarty_tpl) {
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

<!-- Navegación -->
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

<!-- Contenido -->
<div class="container text-center mt-4">
    
    <!-- Mostrar mensajes -->
    <?php if ($_smarty_tpl->getValue('mensaje')) {?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_smarty_tpl->getValue('mensaje');?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php }?>

    <!-- Formulario para modificar -->
    <?php if ((null !== ($_smarty_tpl->getValue('estudiante') ?? null))) {?>
        <h3 class="mb-4">Editar datos de: <?php echo $_smarty_tpl->getValue('estudiante')['nombre'];?>
 <?php echo $_smarty_tpl->getValue('estudiante')['apellido'];?>
</h3>
        <form method="POST" action="modificarEstudiante.php">
            <input type="hidden" name="dni" value="<?php echo $_smarty_tpl->getValue('estudiante')['dni'];?>
">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo $_smarty_tpl->getValue('estudiante')['nombre'];?>
" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" class="form-control" name="apellido" value="<?php echo $_smarty_tpl->getValue('estudiante')['apellido'];?>
" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo $_smarty_tpl->getValue('estudiante')['email'];?>
" required autocomplete="off">
            </div>
            <button type="submit" class="btn-formal">Modificar</button>
        </form>

    <?php } else { ?>
        <h3 class="mb-4">Buscar Estudiante por DNI</h3>
        <form method="POST" action="modificarEstudiante.php">
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" class="form-control" name="dni" required pattern="\d+" autocomplete="off">
            </div>
            <button type="submit" class="btn-formal">Buscar</button>
        </form>
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
