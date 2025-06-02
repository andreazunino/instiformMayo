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

<div class="container text-center">
    <!-- Formulario de búsqueda por nombre -->
    <h3>Buscar Cursos por Nombre</h3>
    <form method="POST" class="mb-4">
        <input type="hidden" name="accion" value="buscar">
        <div class="form-group">
            <input type="text" class="form-control" name="nombreCurso" placeholder="Ingrese el nombre del curso" value="{$nombreCurso|default:''}" autocomplete="off">
        </div>
        <button type="submit" class="btn btn-custom">Buscar</button>
    </form>

    <!-- Mostrar mensaje -->
    {if $mensaje}
        <div class="alert alert-{$mensaje_tipo} mt-3">{$mensaje}</div>
    {/if}

    <!-- Mostrar cursos -->
    {if $cursos}
        <h3 class="mt-4">Resultados</h3>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Curso</th>
                    <th>Cupo Disponible</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$cursos item=curso}
                    <tr>
                        <td>{$curso.id}</td>
                        <td>{$curso.nombre}</td>
                        <td>{$curso.cupo}</td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    {else}
        <p class="mt-4">No se encontraron cursos.</p>
    {/if}
</div>

<!-- Footer -->
{include file='footer.tpl'}

<!-- Scripts necesarios para Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
