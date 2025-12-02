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
        .panel-card {
            max-width: 720px;
            margin: 0 auto;
            text-align: left;
        }
        .panel-card .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
        .panel-table {
            max-width: 720px;
            margin: 0 auto;
            text-align: left;
        }
        .panel-table .table th {
            width: 35%;
            vertical-align: middle;
            text-align: center;
        }
        .panel-table .table td {
            vertical-align: middle;
        }
        .acciones-nota {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        .acciones-nota form {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin: 0;
        }
        .acciones-nota .form-editar input[type="number"] {
            width: 80px;
        }
        .historial-table thead {
            background-color: #f5f5f5;
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

<!-- Contenido principal -->
<div class="container text-center mt-4">

    <!-- Mensaje -->
    {if isset($mensaje)}
        <div class="alert alert-{$mensaje_tipo}" role="alert">
            {$mensaje}
        </div>
    {/if}

    <!-- Formulario de búsqueda por DNI -->
    <h3 class="mb-4">Buscar Estudiante por DNI</h3>
    <form action="" method="POST" class="panel-card text-left mb-4">
        <input type="hidden" name="accion" value="buscar">
        <div class="form-group">
            <label for="dni_estudiante">DNI:</label>
            <input type="text" class="form-control" id="dni_estudiante" name="dni_estudiante"
                   value="{$dniEstudiante}" required pattern="\d+" autocomplete="off">
        </div>
        <div class="text-center">
            <button type="submit" name="buscar_dni" class="btn-formal">Buscar</button>
        </div>
    </form>

    <!-- Datos del estudiante -->
    {if $estudiante}
        <h3 class="mt-4">Datos del Estudiante</h3>
        <div class="panel-table">
            <table class="table table-striped mt-3 mb-0">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{$estudiante.dni}</td>
                        <td>{$estudiante.nombre}</td>
                        <td>{$estudiante.apellido}</td>
                        <td>{$estudiante.email}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    {/if}

    <!-- Formulario para ingresar nota -->
    {if $estudiante && $cursos|@count > 0}
        <h3 class="mt-4">Ingresar Nota</h3>
        <form action="" method="POST" class="panel-table mb-4 text-left">
            <table class="table table-striped mb-3">
                <tbody>
                    <tr>
                        <th scope="row">Curso</th>
                        <td>
                            <select class="form-control" id="id_curso" name="id_curso" required>
                                {foreach from=$cursos item=curso}
                                    <option value="{$curso.id}">{$curso.nombre}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Nota</th>
                        <td>
                            <input type="number" class="form-control" id="nota" name="nota" required min="1" max="10" step="1">
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="dni_estudiante" value="{$dniEstudiante}">
            <div class="text-center">
                <button type="submit" name="ingresar_nota" class="btn-formal">Guardar Nota</button>
            </div>
        </form>
    {elseif $estudiante && isset($dniEstudiante)}
        <p class="mt-4 text-secondary">El estudiante no está inscrito en ningún curso.</p>
    {/if}

    <!-- Historial de calificaciones -->
    {if $estudiante}
        <h3 class="mt-4">Historial de Calificaciones</h3>
        {if $historial|@count > 0}
            <div class="panel-table table-responsive">
                <table class="table table-striped historial-table">
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Fecha</th>
                            <th>Nota</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$historial item=registro}
                            <tr>
                                <td>{$registro.materia}</td>
                                <td>{if $registro.fecha_formateada}{$registro.fecha_formateada}{else}-{/if}</td>
                                <td>{$registro.calificacion}</td>
                                <td>
                                    <div class="acciones-nota">
                                        <form action="" method="POST" class="form-editar">
                                            <input type="hidden" name="dni_estudiante" value="{$dniEstudiante}">
                                            <input type="hidden" name="calificacion_id" value="{$registro.id}">
                                            <input type="number" name="nota" class="form-control form-control-sm" value="{$registro.calificacion}" min="1" max="10" step="1" required>
                                            <button type="submit" name="editar_calificacion" class="btn-formal btn-formal-sm">Actualizar</button>
                                            <button type="submit" name="eliminar_calificacion" class="btn-formal btn-formal-danger btn-formal-sm" onclick="return confirm('¿Eliminar esta calificación?');">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        {else}
            <p class="mt-3 mb-0">Este estudiante aún no tiene calificaciones registradas.</p>
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
