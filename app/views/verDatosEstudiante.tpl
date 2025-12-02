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
<button class="btn btn-logout" onclick="window.location.href='logout.php'">Cerrar sesión</button>

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
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link" href="menuAdministrador.php">Volver al Menú Administrador</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container text-center mt-4">
    <!-- Mensaje -->
    {if $mensaje}
        <div class="alert alert-{$mensaje_tipo} mt-3">{$mensaje}</div>
    {/if}

    <!-- Tabla de estudiantes -->
    {if $estudiantes|@count > 0}
        <h3 class="mt-4">Estudiantes Registrados</h3>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$estudiantes item=estudiante}
                    <tr>
                        <td>{$estudiante.dni}</td>
                        <td>{$estudiante.nombre}</td>
                        <td>{$estudiante.apellido}</td>
                        <td>{$estudiante.email}</td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    {else}
        <p class="mt-4 text-muted">No hay estudiantes registrados en el sistema.</p>
    {/if}
</div>

<!-- Footer -->
{include file='footer.tpl'}

<!-- Scripts Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
