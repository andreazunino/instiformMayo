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
                <a class="nav-link" href="menuEstudiante.php">
                    Volver al Menú Estudiante
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container text-center">
    <!-- Mensaje de éxito o error -->
    {if isset($mensaje)}
        <div class="alert alert-{$mensaje_tipo}" role="alert">
            {$mensaje}
        </div>
    {/if}

    <!-- Formulario para buscar boletín -->
    <form method="POST" action="">
        <input type="hidden" name="accion" value="buscar">
        <div class="form-group">
            <label for="dni">Ingrese el DNI del estudiante:</label>
            <input type="text" class="form-control" id="dni" name="dni" required pattern="\d+" title="Solo se permiten números" autocomplete="off">
        </div>
        <button type="submit" class="btn btn-custom">Buscar</button>
    </form>

    <!-- Mostrar tabla o mensaje según los resultados -->
    {if isset($cursos)}
        {if $cursos|@count > 0}
            <h2>Cursos en los que estás inscrito</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$cursos item=curso}
                        <tr>
                            <td>{$curso.nombre}</td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="accion" value="anular">
                                    <input type="hidden" name="dniEstudiante" value="{$dniEstudiante}">
                                    <input type="hidden" name="idCursoAnular" value="{$curso.id}">
                                    <button type="submit" class="btn btn-danger">Anular Inscripción</button>
                                </form>
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        {else}
            <p>No estás inscrito en ningún curso.</p>
        {/if}
    {/if}
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

{include file='footer.tpl'}
</body>
</html>

