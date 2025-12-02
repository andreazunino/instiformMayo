<?php
/* Smarty version 5.4.0, created on 2025-12-02 20:34:27
  from 'file:borrarInscripcion.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_692f3f4362c4e0_08770491',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '28a102bdcad0ead095adc4769709375ade22d33d' => 
    array (
      0 => 'borrarInscripcion.tpl',
      1 => 1764704053,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_692f3f4362c4e0_08770491 (\Smarty\Template $_smarty_tpl) {
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
                <a class="nav-link" href="menuAdministrador.php">Volver al Menú Administrador</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Contenedor principal -->
<div class="container text-center">
    <!-- Mostrar mensajes de éxito o error -->
    <?php if ((null !== ($_smarty_tpl->getValue('mensaje') ?? null))) {?>
        <div class="alert alert-success mt-3"><?php echo $_smarty_tpl->getValue('mensaje');?>
</div>
    <?php }?>
    <?php if ((null !== ($_smarty_tpl->getValue('mensaje_error') ?? null))) {?>
        <div class="alert alert-danger mt-3"><?php echo $_smarty_tpl->getValue('mensaje_error');?>
</div>
    <?php }?>

    <!-- Formulario de búsqueda -->
    <form method="POST" action="borrarInscripcion.php" class="mb-5">
        <input type="hidden" name="accion" value="buscar">
        <div class="form-group mb-3">
            <label for="dniAlumno">DNI del Alumno:</label>
            <input type="text" class="form-control" id="dniAlumno" name="dniAlumno" placeholder="Ej: 12345678" required pattern="\d+" autocomplete="off">
        </div>
        <button type="submit" class="btn-formal">Buscar</button>
    </form>

    <!-- Tabla de resultados -->
    <?php if ((null !== ($_smarty_tpl->getValue('inscripciones') ?? null))) {?>
        <h2 class="mb-4">Resultados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DNI Alumno</th>
                    <th>Nombre Alumno</th>
                    <th>Curso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('inscripciones'), 'inscripcion');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('inscripcion')->value) {
$foreach0DoElse = false;
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->getValue('inscripcion')['id'];?>
</td>
                        <td><?php echo (($tmp = (($tmp = $_smarty_tpl->getValue('inscripcion')['dni'] ?? null)===null||$tmp==='' ? $_smarty_tpl->getValue('inscripcion')['dni_estudiante'] ?? null : $tmp) ?? null)===null||$tmp==='' ? 'N/A' ?? null : $tmp);?>
</td>
                        <td><?php echo $_smarty_tpl->getValue('inscripcion')['nombre'];?>
 <?php echo $_smarty_tpl->getValue('inscripcion')['apellido'];?>
</td>
                        <td><?php echo (($tmp = (($tmp = $_smarty_tpl->getValue('inscripcion')['curso'] ?? null)===null||$tmp==='' ? $_smarty_tpl->getValue('inscripcion')['curso_nombre'] ?? null : $tmp) ?? null)===null||$tmp==='' ? '-' ?? null : $tmp);?>
</td>
                        <td>
                            <a href="borrarInscripcion.php?id=<?php echo $_smarty_tpl->getValue('inscripcion')['id'];?>
"
                               class="btn-formal btn-formal-danger btn-formal-sm delete-inscripcion">
                                Borrar
                            </a>
                        </td>
                    </tr>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </tbody>
        </table>
    <?php } elseif ((null !== ($_smarty_tpl->getValue('mensaje') ?? null)) && $_smarty_tpl->getValue('mensaje_tipo') == 'warning') {?>
        <p class="mt-4 text-warning">No se encontraron inscripciones que coincidan con los criterios.</p>
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

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteLabel">Eliminar inscripción</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar esta inscripción?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<?php echo '<script'; ?>
>
    (function() {
        var targetHref = null;
        $(document).on('click', '.delete-inscripcion', function (e) {
            e.preventDefault();
            targetHref = $(this).attr('href');
            $('#confirmDeleteModal').modal('show');
        });
        $('#confirmDeleteBtn').on('click', function () {
            if (targetHref) {
                window.location.href = targetHref;
            }
        });
        $('#confirmDeleteModal').on('hidden.bs.modal', function () {
            targetHref = null;
        });
    })();
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
</body>
</html>
<?php }
}
