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
                <a class="nav-link" href="menuEstudiante.php">Volver al Menú Estudiante</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container text-center">
    <!-- Formulario para buscar cursos por DNI -->
    <h3>Buscar Cursos Disponibles</h3>
    <form method="POST">
        <input type="hidden" name="accion" value="buscar">
        {if isset($usuario.role) && $usuario.role == 'estudiante' && $dniEstudiante}
            <input type="hidden" name="dni" value="{$dniEstudiante}">
            <div class="alert alert-info mt-2 mb-3" role="alert">
                <strong>DNI detectado:</strong> <span style="font-size:1.1rem;">{$dniEstudiante}</span>
            </div>
            <noscript><button type="submit" class="btn-formal">Ver cursos disponibles</button></noscript>
        {else}
            <div class="form-group">
                <label for="dni">DNI del Estudiante:</label>
                <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingrese el DNI del estudiante" required pattern="\d+" autocomplete="off">
            </div>
            <button type="submit" class="btn-formal">Buscar</button>
        {/if}
    </form>

    <!-- Mostrar mensaje -->
    {if $mensaje}
        <div class="alert alert-{$mensaje_tipo} mt-3">{$mensaje}</div>
    {/if}
    {if isset($comprobante_id)}
        <div class="alert alert-success mt-3">
            Comprobante listo. <a class="alert-link" href="comprobanteInscripcion.php?id={$comprobante_id}" target="_blank" rel="noopener">Descargar comprobante{if $comprobante_curso} de {$comprobante_curso}{/if}</a>
        </div>
    {/if}

    <!-- Mostrar cursos disponibles -->
    {if $cursos}
        <h3 class="mt-4">Cursos Disponibles</h3>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Nombre del Curso</th>
                    <th>Cupo Disponible</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$cursos item=curso}
                    <tr>
                        <td>{$curso.nombre}</td>
                        <td>{$curso.cupo}</td>
                        <td>
                            <!-- Formulario para inscribir al estudiante -->
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="accion" value="inscribir">
                                <input type="hidden" name="dniEstudiante" value="{$dniEstudiante}">
                                <input type="hidden" name="idCurso" value="{$curso.id}">
                                <button type="submit" class="btn-formal btn-formal-sm">Inscribir</button>
                            </form>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
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
