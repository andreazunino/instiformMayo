<?php
/* Smarty version 5.4.0, created on 2025-05-13 22:14:18
  from 'file:menuEstudiante.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_6823a81a6e7049_60081320',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '899b5689ca086acaa6beb1785234f53c529c6eb4' => 
    array (
      0 => 'menuEstudiante.tpl',
      1 => 1746879176,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:templates/head.tpl' => 1,
    'file:templates/footer.tpl' => 1,
  ),
))) {
function content_6823a81a6e7049_60081320 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\InstiformMayo\\app\\views';
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <?php $_smarty_tpl->renderSubTemplate('file:templates/head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
</head>
<body>

<!-- Botón de cerrar sesión -->
<button class="btn btn-logout" onclick="window.location.href='index.php'">Cerrar sesión</button>

<!-- Encabezado con logo -->
<div class="container-fluid text-center welcome-section">
    <img src="public/img/logo-instiform.png" alt="Logo de Instiform" class="img-fluid logo-small">
    <h1 class="welcome-heading">Instiform</h1>
</div>

<!-- Menú de navegación para estudiante -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cursos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="inscribirCurso.php">Inscribirse a Curso</a>
                    <a class="dropdown-item" href="anularInscripcion.php">Anular Inscripción</a>
                    <a class="dropdown-item" href="boletin.php">Ver Boletín</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<!-- Bienvenida -->
<div class="container text-center mt-4">
    <h2 class="text-dark">Bienvenido/a Estudiante</h2>
    <p class="text-muted">Seleccioná una opción del menú para comenzar.</p>
</div>

<!-- Footer -->
<?php $_smarty_tpl->renderSubTemplate('file:templates/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
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
