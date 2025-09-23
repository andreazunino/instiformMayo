<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
   {include file='head.tpl'}
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
    {if isset($mensaje)}
        <div class="alert alert-{$mensaje_tipo}" role="alert">
            {$mensaje}
        </div>
    {/if}

    <!-- Formulario de búsqueda por DNI -->
    <form action="" method="POST" class="mb-4">
        <div class="form-group">
            <label for="dni_estudiante">DNI del Estudiante:</label>
            <input type="text" class="form-control" id="dni_estudiante" name="dni_estudiante"
                   value="{$dniEstudiante}" required pattern="\d+" autocomplete="off">
        </div>
        <button type="submit" name="buscar_dni" class="btn-custom">Buscar</button>
    </form>

    <!-- Formulario para ingresar nota -->
    {if $cursos|@count > 0}
        <h2>Ingresar Nota</h2>
        <form action="" method="POST" class="mb-4">
            <div class="form-group">
                <label for="id_curso">Curso:</label>
                <select class="form-control" id="id_curso" name="id_curso" required>
                    {foreach from=$cursos item=curso}
                        <option value="{$curso.id}">{$curso.nombre}</option>
                    {/foreach}
                </select>
            </div>
            <div class="form-group">
                <label for="nota">Nota:</label>
                <input type="number" class="form-control" id="nota" name="nota" required min="1" max="10">
            </div>
            <input type="hidden" name="dni_estudiante" value="{$dniEstudiante}">
            <button type="submit" name="ingresar_nota" class="btn btn-success">Guardar Nota</button>
        </form>
    {elseif isset($dniEstudiante)}
        <p class="mt-4 text-warning">El estudiante no está inscrito en ningún curso.</p>
    {/if}

    <!-- Historial de calificaciones -->
    {if isset($historial)}
        <h2 class="mt-5">Historial de calificaciones</h2>
        {if $historial|@count > 0}
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
                        {foreach from=$historial item=registro}
                            <tr>
                                <td>{$registro.materia}</td>
                                <td>{$registro.calificacion}</td>
                                <td>{if $registro.fecha_formateada}{$registro.fecha_formateada}{else}-{/if}</td>
                                <td>
                                    <form action="" method="POST" class="d-inline-flex align-items-center mb-2 mb-lg-0">
                                        <input type="hidden" name="dni_estudiante" value="{$dniEstudiante}">
                                        <input type="hidden" name="calificacion_id" value="{$registro.id}">
                                        <input type="number" name="nota" class="form-control form-control-sm mr-2" value="{$registro.calificacion}" min="1" max="10" required>
                                        <button type="submit" name="editar_calificacion" class="btn btn-sm btn-primary">Actualizar</button>
                                    </form>
                                    <form action="" method="POST" class="d-inline">
                                        <input type="hidden" name="dni_estudiante" value="{$dniEstudiante}">
                                        <input type="hidden" name="calificacion_id" value="{$registro.id}">
                                        <button type="submit" name="eliminar_calificacion" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta calificación?');">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        {else}
            <p class="mt-3">Este estudiante aún no tiene calificaciones registradas.</p>
        {/if}
    {/if}
</div>

<!-- Footer -->
{include file='footer.tpl'}

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
