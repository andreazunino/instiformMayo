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
<button class="btn btn-logout" onclick="window.location.href='logout.php'">Cerrar sesión</button>

<!-- Encabezado con logo -->
<div class="container-fluid text-center welcome-section">
    <img src="../../public/img/Logo Instiform.png" alt="Logo de Instiform" class="img-fluid logo-small">
    <h1 class="welcome-heading">Descargar Boletín de un Estudiante</h1>
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

<!-- Formulario -->
<div class="container text-center mt-4">
    <form action="generarBoletin.php" method="GET" target="_blank">
        <div class="form-group">
            <label for="dni">Seleccioná un estudiante:</label>
            <select name="dni" id="dni" class="form-control" required>
                <option value="">-- Seleccionar --</option>
                {foreach from=$estudiantes item=e}
                    <option value="{$e.dni}">{$e.apellido}, {$e.nombre} - DNI: {$e.dni}</option>
                {/foreach}
            </select>
        </div>
        <button type="submit" class="btn-formal">Descargar Boletín PDF</button>
    </form>
</div>

<!-- Footer -->
{include file='footer.tpl'}

</body>
</html>
