<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    {include file='head.tpl'}
    <style>
        .main-content {
            min-height: calc(80vh - 160px);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        footer {
            position: relative;
            bottom: 0;
            width: 100%;
        }
        .logo-small {
            max-width: 80px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<button class="btn btn-logout" onclick="window.location.href='logout.php'">Cerrar sesión</button>

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
                <a class="nav-link" href="inscribirCurso.php{if isset($usuario.dni) && $usuario.dni ne ''}?dni={$usuario.dni|escape:'url'}{/if}">Inscribirse a Curso</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="anularInscripcion.php{if isset($usuario.dni) && $usuario.dni ne ''}?dni={$usuario.dni|escape:'url'}{/if}">Inscripciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="exportarInscripciones.php">Descargar inscripciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="boletin.php{if isset($usuario.dni) && $usuario.dni ne ''}?dni={$usuario.dni|escape:'url'}{/if}">Boletín</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container text-center main-content">
    <h2 class="text-dark">Bienvenido/a {if $usuario.nombre}{$usuario.nombre}{/if}{if $usuario.apellido} {$usuario.apellido}{/if}</h2>
    <p class="text-muted">Seleccioná una opción del menú para comenzar.</p>
</div>

{include file='footer.tpl'}

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>


