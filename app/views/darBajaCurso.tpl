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

<!-- Contenedor principal -->
<div class="container text-center">
    <!-- Mostrar mensajes de éxito o error -->
    {if isset($mensaje)}
        <div class="alert alert-{$mensaje_tipo} mt-3">{$mensaje}</div>
    {/if}

    <!-- Formulario para dar de baja un curso -->
    <form action="darBajaCurso.php" method="POST">
        <input type="hidden" name="accion" value="baja">
        <div class="form-group">
            <label for="curso">Selecciona el Curso:</label>
            <select id="curso" name="curso" class="form-control" required>
                <option value="">-- Selecciona un curso --</option>
                {foreach from=$cursos item=curso}
                    <option value="{$curso.id}">{$curso.nombre} (Cupo: {$curso.cupo})</option>
                {/foreach}
            </select>
        </div>
        <button type="submit" class="btn-custom">Dar de Baja</button>
    </form>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

{include file='footer.tpl'}
</body>
</html>


