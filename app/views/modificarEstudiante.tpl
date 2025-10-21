<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    {include 'head.tpl'}
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

<!-- Navegación -->
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

<!-- Contenido -->
<div class="container text-center mt-4">
    
    <!-- Mostrar mensajes -->
    {if $mensaje}
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {$mensaje}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    {/if}

    <!-- Formulario para modificar -->
    {if isset($estudiante)}
        <h3 class="mb-4">Editar datos de: {$estudiante.nombre} {$estudiante.apellido}</h3>
        <form method="POST" action="modificarEstudiante.php">
            <input type="hidden" name="dni" value="{$estudiante.dni}">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" value="{$estudiante.nombre}" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" class="form-control" name="apellido" value="{$estudiante.apellido}" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" value="{$estudiante.email}" required autocomplete="off">
            </div>
            <button type="submit" class="btn-formal">Modificar</button>
        </form>

    {else}
        <h3 class="mb-4">Buscar Estudiante por DNI</h3>
        <form method="POST" action="modificarEstudiante.php">
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="text" class="form-control" name="dni" required pattern="\d+" autocomplete="off">
            </div>
            <button type="submit" class="btn-formal">Buscar</button>
        </form>
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
