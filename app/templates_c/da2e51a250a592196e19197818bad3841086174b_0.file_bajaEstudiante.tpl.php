<?php
/* Smarty version 5.4.0, created on 2025-05-28 22:40:22
  from 'file:bajaEstudiante.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_683774b6016ea5_74467666',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'da2e51a250a592196e19197818bad3841086174b' => 
    array (
      0 => 'bajaEstudiante.tpl',
      1 => 1748464547,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_683774b6016ea5_74467666 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\InstiformMayo\\app\\views';
?><!DOCTYPE html>
<html lang="es">
<head>
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
    <!-- Formulario para buscar estudiante -->
    <h3>Buscar por Número de Documento</h3>
    <form action="bajaEstudiante.php" method="post">
        <input type="hidden" name="accion" value="buscar">
        <div class="form-group">
            <label for="documento">Número de Documento:</label>
            <input type="text" class="form-control" id="documento" name="documento" required pattern="\d+" autocomplete="off">
        </div>
        <button type="submit" name="buscarDocumento" class="btn btn-danger">Buscar Estudiante</button>
    </form>

    <!-- Mostrar mensaje -->
    <?php if ((null !== ($_smarty_tpl->getValue('mensaje') ?? null))) {?>
        <div class="alert alert-warning mt-3"><?php echo $_smarty_tpl->getValue('mensaje');?>
</div>
    <?php }?>

    <!-- Mostrar datos del estudiante encontrado -->
    <?php if ((null !== ($_smarty_tpl->getValue('estudiante') ?? null))) {?>
        <h3>Datos del Estudiante</h3>
        <p><strong>DNI:</strong> <?php echo (($tmp = $_smarty_tpl->getValue('estudiante')['dni'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
        <p><strong>Nombre:</strong> <?php echo (($tmp = $_smarty_tpl->getValue('estudiante')['nombre'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
        <p><strong>Apellido:</strong> <?php echo (($tmp = $_smarty_tpl->getValue('estudiante')['apellido'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
        <p><strong>Email:</strong> <?php echo (($tmp = $_smarty_tpl->getValue('estudiante')['email'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
</p>
        <form action="bajaEstudiante.php" method="POST">
            <input type="hidden" name="accion" value="eliminar">
            <input type="hidden" name="dni_estudiante" value="<?php echo (($tmp = $_smarty_tpl->getValue('estudiante')['dni'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
            <button type="submit" class="btn btn-danger">Eliminar Estudiante</button>
        </form>
    <?php }?>
</div>

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

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
</body>
</html>

<?php }
}
