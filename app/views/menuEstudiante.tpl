<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    {include file='head.tpl'}
    <style>
        .main-content {
            min-height: calc(80vh - 160px);  /*Altura restante sin navbar y footer */
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

<!-- Botón de cerrar sesión -->
<button class="btn btn-logout" onclick="window.location.href='../../index.php'">Cerrar sesión</button>

<!-- Encabezado con logo -->
<div class="container-fluid text-center welcome-section">
    <img src="../../public/img/Logo Instiform.png" alt="Logo de Instiform" class="logo-small">
    <h1 class="welcome-heading">Instiform</h1>
</div>

<!-- Menú de navegación para estudiante -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cursos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="inscribirCurso.php">Inscribirse a Curso</a>
                    <a class="dropdown-item" href="anularInscripcion.php">Anular Inscripción</a>
                    <a class="dropdown-item" href="boletin.php">Ver Boletín</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<!-- Contenido centrado -->
<div class="container text-center main-content">
    <h2 class="text-dark">Bienvenido/a Estudiante</h2>
    <p class="text-muted">Seleccioná una opción del menú para comenzar.</p>
</div>

<!-- Footer -->
{include file='footer.tpl'}

<!-- Scripts necesarios para Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
