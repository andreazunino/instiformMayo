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
        <button type="submit" name="buscar_dni" class="btn btn-custom">Buscar</button>
    </form>

    <!-- Formulario para ingresar nota -->
    {if $cursos|@count > 0}
        <h2>Ingresar Nota</h2>
        <form action="" method="POST">
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
</div>

<!-- Footer -->
{include file='footer.tpl'}

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
