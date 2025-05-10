<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    {include 'templates/head.tpl'}
</head>
<body>

<!-- Botón de cierre de sesión -->
<button class="btn btn-logout" onclick="window.location.href='index.php'">Cerrar sesión</button>

<!-- Encabezado -->
<div class="container-fluid text-center welcome-section">
    <img src="public/img/logo-instiform.png" alt="Logo de Instiform" class="img-fluid logo-small">
    <h1 class="welcome-heading">Consultar Boletín de Calificaciones</h1>
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
    <form method="POST" action="">
        <input type="hidden" name="accion" value="buscar">
        <div class="form-group">
            <label for="dni">Ingrese el DNI del estudiante:</label>
            <input type="text" class="form-control" id="dni" name="dni" required pattern="\d+" title="Solo se permiten números" autocomplete="off">
        </div>
        <button type="submit" class="btn btn-custom">Buscar</button>
    </form>

    <!-- Mostrar tabla o mensaje según los resultados -->
    {if isset($notas)}
        {if $notas|@count > 0}
            <h2>Calificaciones</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Calificación</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$notas item=nota}
                        <tr>
                            <td>{$nota.materia}</td>
                            <td>
                                {foreach from=$nota.calificacion item=cal}
                                    {$cal}<br>
                                {/foreach}
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        {else}
            <p>No se encontraron calificaciones para el DNI ingresado.</p>
        {/if}
    {/if}
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

{include file='templates/footer.tpl'}
</body>
</html>

