<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boletín - Instiform</title>
    {include file='head.tpl'}
    <style>
        .logo-small {
            max-width: 80px;
            margin-top: 10px;
        }
        .lista-calificaciones {
            margin: 0;
            padding-left: 1rem;
            text-align: left;
        }
        .lista-calificaciones li {
            list-style-type: disc;
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
                <a class="nav-link" href="menuEstudiante.php">Volver al Menú Estudiante</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container text-center">
    <!-- Formulario para buscar boletín -->
    <h3>Consultar Boletín</h3>
    <form method="POST" action="">
        <input type="hidden" name="accion" value="buscar">
        <div class="form-group">
            <label for="dni">DNI del Estudiante:</label>
            <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingrese el DNI del estudiante" required pattern="\d+" autocomplete="off">
        </div>
        <button type="submit" class="btn-formal">Buscar</button>
    </form>

    <!-- Mostrar mensaje -->
    {if isset($mensaje)}
        <div class="alert alert-{$mensaje_tipo|default:'info'} mt-3">{$mensaje}</div>
    {/if}

    <!-- Mostrar tabla de notas -->
    {if isset($notas)}
        {if $notas|@count > 0}
            <h3 class="mt-4">Calificaciones</h3>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Calificaciones</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$notas item=nota}
                        <tr>
                            <td>{$nota.materia}</td>
                            <td>
                                {if isset($nota.calificaciones) && $nota.calificaciones|@count > 0}
                                    <ul class="lista-calificaciones">
                                        {foreach from=$nota.calificaciones item=detalle}
                                            <li>
                                                {$detalle.valor}
                                                {if $detalle.fecha_formateada}
                                                    <span class="text-muted">({$detalle.fecha_formateada})</span>
                                                {/if}
                                            </li>
                                        {/foreach}
                                    </ul>
                                {else}
                                    {$nota.calificacion|default:'-'}
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        {else}
            <p class="mt-3">No se encontraron calificaciones para el DNI ingresado.</p>
        {/if}
    {/if}
</div>

<!-- Footer -->
{include file='footer.tpl'}

<!-- Scripts necesarios -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
