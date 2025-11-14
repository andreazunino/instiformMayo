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
        <div class="alert alert-success mt-3">{$mensaje}</div>
    {/if}
    {if isset($mensaje_error)}
        <div class="alert alert-danger mt-3">{$mensaje_error}</div>
    {/if}

    <!-- Formulario de búsqueda -->
    <form method="POST" action="borrarInscripcion.php" class="mb-5">
        <input type="hidden" name="accion" value="buscar">
        <div class="form-group mb-3">
            <label for="dniAlumno">DNI del Alumno:</label>
            <input type="text" class="form-control" id="dniAlumno" name="dniAlumno" placeholder="Ej: 12345678" required pattern="\d+" autocomplete="off">
        </div>
        <div class="form-group mb-3">
            <label for="nombreMateria">Nombre de la Materia:</label>
            <input type="text" class="form-control" id="nombreMateria" name="nombreMateria" placeholder="Ej: Matemática">
        </div>
        <button type="submit" class="btn-formal">Buscar</button>
    </form>

    <!-- Tabla de resultados -->
    {if isset($inscripciones)}
        <h2 class="mb-4">Resultados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DNI Alumno</th>
                    <th>Nombre Alumno</th>
                    <th>Curso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {foreach $inscripciones as $inscripcion}
                    <tr>
                        <td>{$inscripcion.id}</td>
                        <td>{$inscripcion.dni|default:$inscripcion.dni_estudiante|default:'N/A'}</td>
                        <td>{$inscripcion.nombre} {$inscripcion.apellido}</td>
                        <td>{$inscripcion.curso|default:$inscripcion.curso_nombre|default:'-'}</td>
                        <td>
                            <a href="borrarInscripcion.php?id={$inscripcion.id}" 
                               class="btn-formal btn-formal-danger btn-formal-sm" 
                               onclick="return confirm('¿Estás seguro de que deseas eliminar esta inscripción?');">
                                Borrar
                            </a>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    {elseif isset($mensaje) && $mensaje_tipo == 'warning'}
        <p class="mt-4 text-warning">No se encontraron inscripciones que coincidan con los criterios.</p>
    {/if}
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

{include file='footer.tpl'}
</body>
</html>

