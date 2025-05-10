<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    {include file='templates/head.tpl'}
</head>
<body>

<!-- Botón de cerrar sesión -->
<button class="btn btn-logout" onclick="window.location.href='index.php'">Cerrar sesión</button>

<!-- Encabezado con logo y título -->
<div class="container-fluid text-center welcome-section">
    <img src="public/img/logo-instiform.png" alt="Logo de Instiform" class="img-fluid logo-small">
    <h1 class="welcome-heading">Dar de Alta Curso</h1>
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
    {if isset($error)}
        <div class="alert alert-danger mt-3">{$error}</div>
    {/if}
    {if isset($mensaje)}
        <div class="alert alert-success mt-3">{$mensaje}</div>
    {/if}

    <!-- Formulario para dar de alta un curso -->
    <form action="darAltaCurso.php" method="POST">
        <input type="hidden" name="accion" value="alta">
        <div class="form-group">
            <label for="id">ID del Curso:</label>
            <input type="number" class="form-control" id="id" name="id" required min="1">
        </div>
        <div class="form-group">
            <label for="nombre">Nombre del Curso:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="100" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="cupo">Cupo:</label>
            <input type="number" class="form-control" id="cupo" name="cupo" required min="1">
        </div>
        <button type="submit" class="btn btn-custom">Dar de Alta</button>
    </form>
</div>

<!-- Footer -->
{include file='templates/footer.tpl'}

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
