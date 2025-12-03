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
        .student-summary {
            max-width: 640px;
            margin: 0 auto 24px auto;
            text-align: left;
        }
        .student-summary .card-title {
            margin-bottom: 0.35rem;
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
        <div class="alert alert-{$mensaje_tipo|default:'success'} mt-3 mb-4">{$mensaje}</div>
    {/if}
    {if isset($mensaje_error)}
        <div class="alert alert-danger mt-3">{$mensaje_error}</div>
    {/if}

    <!-- Formulario de búsqueda -->
    <form method="POST" action="borrarInscripcion.php" class="mb-5">
        <input type="hidden" name="accion" value="buscar">
        <div class="form-group mb-3">
            <label for="dniAlumno">DNI del Alumno:</label>
            <input type="text" class="form-control" id="dniAlumno" name="dniAlumno" placeholder="Ej: 12345678" value="{$dni_buscado|default:''}" required pattern="\d+" autocomplete="off">
        </div>
        <button type="submit" class="btn-formal">Buscar</button>
    </form>

    {if isset($estudiante)}
        <div class="card shadow-sm student-summary">
            <div class="card-body">
                <h5 class="card-title">Datos del estudiante</h5>
                <p class="mb-1"><strong>DNI:</strong> {$estudiante.dni|default:'-'}</p>
                <p class="mb-1"><strong>Nombre:</strong> {$estudiante.nombre|default:'-'} {$estudiante.apellido|default:''}</p>
                <p class="mb-0"><strong>Email:</strong> {$estudiante.email|default:'-'}</p>
            </div>
        </div>
    {/if}

    <!-- Tabla de resultados -->
    {if isset($inscripciones) && $inscripciones|@count > 0}
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
                            <a href="borrarInscripcion.php?id={$inscripcion.id}&dni={$dni_buscado|default:''}"
                               class="btn-formal btn-formal-danger btn-formal-sm delete-inscripcion">
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

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteLabel">Eliminar inscripción</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar esta inscripción?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<script>
    (function() {
        var targetHref = null;
        $(document).on('click', '.delete-inscripcion', function (e) {
            e.preventDefault();
            targetHref = $(this).attr('href');
            $('#confirmDeleteModal').modal('show');
        });
        $('#confirmDeleteBtn').on('click', function () {
            if (targetHref) {
                window.location.href = targetHref;
            }
        });
        $('#confirmDeleteModal').on('hidden.bs.modal', function () {
            targetHref = null;
        });
    })();
</script>

{include file='footer.tpl'}
</body>
</html>
