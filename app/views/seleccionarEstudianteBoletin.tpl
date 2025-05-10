<!DOCTYPE html>
<html lang="es">
{include file='templates/head.tpl'}
<body>

<button class="btn btn-logout" onclick="window.location.href='menuAdministrador.php'">Volver al menú</button>

<div class="container text-center welcome-section">
    <img src="public/img/logo-instiform.png" alt="Logo de Instiform" class="img-fluid logo-small">
    <h1 class="welcome-heading">Descargar Boletín de un Estudiante</h1>
</div>

<div class="container text-center mt-4">
    <form action="descargarBoletin.php" method="GET" target="_blank">
        <div class="form-group">
            <label for="dni">Seleccioná un estudiante:</label>
            <select name="dni" id="dni" class="form-control" required>
                <option value="">-- Seleccionar --</option>
                {foreach from=$estudiantes item=e}
                    <option value="{$e.dni}">{$e.apellido}, {$e.nombre} - DNI: {$e.dni}</option>
                {/foreach}
            </select>
        </div>
        <button type="submit" class="btn btn-custom mt-3">Descargar Boletín PDF</button>
    </form>
</div>

{include file='templates/footer.tpl'}

</body>
</html>
