<?php
/* Smarty version 5.4.0, created on 2025-12-02 20:35:09
  from 'file:anularInscripcion.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_692f3f6dbff502_87923983',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cd2d5f2e0f252f15e00d15880b36d787e703d107' => 
    array (
      0 => 'anularInscripcion.tpl',
      1 => 1764685941,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_692f3f6dbff502_87923983 (\Smarty\Template $_smarty_tpl) {
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
                <a class="nav-link" href="menuEstudiante.php">
                    Volver al Menú Estudiante
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container text-center">
<h3>Anular Inscripción</h3>
    <!-- Mensaje de éxito o error -->
    <?php if ((null !== ($_smarty_tpl->getValue('mensaje') ?? null))) {?>
        <div class="alert alert-<?php echo $_smarty_tpl->getValue('mensaje_tipo');?>
" role="alert">
            <?php echo $_smarty_tpl->getValue('mensaje');?>

        </div>
    <?php }?>

    <!-- Formulario para buscar inscripciones -->
    <form method="POST" action="">
        <input type="hidden" name="accion" value="buscar">
        <?php if ((null !== ($_smarty_tpl->getValue('usuario')['role'] ?? null)) && $_smarty_tpl->getValue('usuario')['role'] == 'estudiante' && $_smarty_tpl->getValue('dniEstudiante')) {?>
            <input type="hidden" name="dni" value="<?php echo $_smarty_tpl->getValue('dniEstudiante');?>
">
            <div class="alert alert-info mt-2 mb-3" role="alert">
                <strong>DNI detectado:</strong> <span style="font-size:1.1rem;"><?php echo $_smarty_tpl->getValue('dniEstudiante');?>
</span>
            </div>
            <noscript><button type="submit" class="btn-formal">Ver mis inscripciones</button></noscript>
        <?php } else { ?>
            <div class="form-group">
                <label for="dni">Ingrese el DNI del estudiante:</label>
                <input type="text" class="form-control" id="dni" name="dni" required pattern="\d+" title="Solo se permiten números" autocomplete="off">
            </div>
            <button type="submit" class="btn-formal">Buscar</button>
        <?php }?>
    </form>

    <!-- Mostrar tabla o mensaje según los resultados -->
    <?php if ((null !== ($_smarty_tpl->getValue('cursos') ?? null))) {?>
        <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('cursos')) > 0) {?>
            <h2>Cursos en los que estás inscrito</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Acción</th>
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
                            <td><?php echo $_smarty_tpl->getValue('curso')['nombre'];?>
</td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="accion" value="anular">
                                    <input type="hidden" name="dniEstudiante" value="<?php echo $_smarty_tpl->getValue('dniEstudiante');?>
">
                                    <input type="hidden" name="idCursoAnular" value="<?php echo $_smarty_tpl->getValue('curso')['id'];?>
">
                                    <button type="submit" class="btn-formal btn-formal-sm">Anular Inscripción</button>
                                </form>
                            </td>
                        </tr>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No estás inscrito en ningún curso.</p>
        <?php }?>
    <?php }?>
</div>

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

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
</body>
</html>
<?php }
}
