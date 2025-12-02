<?php
/* Smarty version 5.4.0, created on 2025-12-02 19:55:24
  from 'file:menuEstudiante.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_692f361cc95d19_32034086',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '899b5689ca086acaa6beb1785234f53c529c6eb4' => 
    array (
      0 => 'menuEstudiante.tpl',
      1 => 1764690425,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_692f361cc95d19_32034086 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\InstiformMayo\\app\\views';
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <?php $_smarty_tpl->renderSubTemplate('file:head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
    <style>
        .main-content {
            min-height: calc(80vh - 160px);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        footer {
            position: relative;
            bottom: 0;
            width: 100%;
        }
        .logo-small {
            max-width: 80px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<button class="btn btn-logout" onclick="window.location.href='logout.php'">Cerrar sesión</button>

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
                <a class="nav-link" href="inscribirCurso.php<?php if ((null !== ($_smarty_tpl->getValue('usuario')['dni'] ?? null)) && $_smarty_tpl->getValue('usuario')['dni'] != '') {?>?dni=<?php echo rawurlencode((string)$_smarty_tpl->getValue('usuario')['dni']);
}?>">Inscribirse a Curso</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="anularInscripcion.php<?php if ((null !== ($_smarty_tpl->getValue('usuario')['dni'] ?? null)) && $_smarty_tpl->getValue('usuario')['dni'] != '') {?>?dni=<?php echo rawurlencode((string)$_smarty_tpl->getValue('usuario')['dni']);
}?>">Inscripciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="exportarInscripciones.php">Descargar inscripciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="boletin.php<?php if ((null !== ($_smarty_tpl->getValue('usuario')['dni'] ?? null)) && $_smarty_tpl->getValue('usuario')['dni'] != '') {?>?dni=<?php echo rawurlencode((string)$_smarty_tpl->getValue('usuario')['dni']);
}?>">Boletín</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container text-center main-content">
    <h2 class="text-dark">Bienvenido/a <?php if ($_smarty_tpl->getValue('usuario')['nombre']) {
echo $_smarty_tpl->getValue('usuario')['nombre'];
}
if ($_smarty_tpl->getValue('usuario')['apellido']) {?> <?php echo $_smarty_tpl->getValue('usuario')['apellido'];
}?></h2>
    <p class="text-muted">Seleccioná una opción del menú para comenzar.</p>
</div>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

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
