<?php
/* Smarty version 5.4.0, created on 2025-05-28 21:31:19
  from 'file:menuAdministrador.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_683764874b7036_57831708',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3b91ce0c73169aafbadcacace9257b8ad8ece73b' => 
    array (
      0 => 'menuAdministrador.tpl',
      1 => 1748460674,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.tpl' => 1,
  ),
))) {
function content_683764874b7036_57831708 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\InstiformMayo\\app\\views';
?><!DOCTYPE html>
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

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto d-flex">

            <!-- Estudiantes -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownEstudiantes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Administrar Estudiantes
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownEstudiantes">
                    <a class="dropdown-item" href="altaEstudiante.php">Dar de Alta</a>
                    <a class="dropdown-item" href="bajaEstudiante.php">Dar de Baja</a>
                    <a class="dropdown-item" href="modificarEstudiante.php">Modificar Datos</a>
                    <a class="dropdown-item" href="verDatosEstudiante.php">Ver Datos de Estudiantes</a>
                    <a class="dropdown-item" href="seleccionarEstudianteBoletin.php">Boletín en PDF</a>
                </div>
            </li>

            <!-- Cursos -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCursos" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Administrar Cursos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownCursos">
                    <a class="dropdown-item" href="darAltaCurso.php">Dar de Alta</a>
                    <a class="dropdown-item" href="darBajaCurso.php">Dar de Baja</a>
                    <a class="dropdown-item" href="modificarDatosCurso.php">Modificar Datos</a>
                    <a class="dropdown-item" href="listarCursos.php">Listar Cursos</a>
                    <a class="dropdown-item" href="notas.php">Notas</a>
                </div>
            </li>

            <!-- Inscripciones -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownInscripciones" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Administrar Inscripciones
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownInscripciones">
                    <a class="dropdown-item" href="inscribirEstudiante.php">Inscribir</a>
                    <a class="dropdown-item" href="borrarInscripcion.php">Borrar Inscripción</a>
                    <a class="dropdown-item" href="listarInscripciones.php">Listar Inscripciones</a>
                </div>
            </li>

        </ul>
    </div>
</nav>

<!-- Mensaje de bienvenida -->
<div class="container text-center">
    <h2>Bienvenido Administrador</h2>
</div>

<!-- Scripts Bootstrap -->
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
