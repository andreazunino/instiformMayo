<!DOCTYPE html>
<html lang="es">
<head>
          {include file='head.tpl'}
   
    <style>
        .logo-small {
            max-width: 80px;
            margin-top: 10px;
        }
        .panel-form {
            max-width: 520px;
            margin: 0 auto;
        }
        .panel-form .btn-formal {
            display: block;
            margin: 0 auto;
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
    <h3 class="mb-4">Buscar Estudiante por DNI</h3>
    <form action="bajaEstudiante.php" method="post" class="panel-form text-left">
        <input type="hidden" name="accion" value="buscar">
        <div class="form-group">
            <label for="documento">DNI:</label>
            <input type="text" class="form-control" id="documento" name="documento" required pattern="\d+" autocomplete="off">
        </div>
        <button type="submit" name="buscarDocumento" class="btn-formal">Buscar</button>
    </form>

    <!-- Mostrar mensaje -->
    {if isset($mensaje)}
        <div class="alert alert-{$mensaje_tipo|default:'info'} mt-3 mb-0">{$mensaje}</div>
    {/if}

    <!-- Mostrar datos del estudiante encontrado -->
    {if isset($estudiante)}
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
                <tr>
                    <td>{$estudiante.dni|default:''}</td>
                    <td>{$estudiante.nombre|default:''}</td>
                    <td>{$estudiante.apellido|default:''}</td>
                    <td>{$estudiante.email|default:''}</td>
                </tr>
            </tbody>
        </table>
        <div class="alert alert-warning mt-3" role="alert">
            Esta acción eliminará al estudiante y todas sus inscripciones asociadas.
        </div>
        <form action="bajaEstudiante.php" method="POST" class="text-center">
            <input type="hidden" name="accion" value="eliminar">
            <input type="hidden" name="dni_estudiante" value="{$estudiante.dni|default:''}">
            <button type="submit" class="btn-formal">Confirmar Baja</button>
        </form>
    {/if}
</div>

<!-- Scripts necesarios para Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

{include file='footer.tpl'}
</body>
</html>
