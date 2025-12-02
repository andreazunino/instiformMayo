<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    {include file='head.tpl'}
    <style>
        .panel-card {
            max-width: 820px;
            margin: 0 auto;
            text-align: left;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
            padding: 22px 26px;
        }
        .panel-table {
            max-width: 980px;
            margin: 0 auto;
        }
        .section-title {
            font-weight: 700;
            letter-spacing: 0.3px;
        }
        .input-group-label {
            font-weight: 600;
            color: #495057;
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
        <ul class="navbar-nav mx-auto d-flex">
            <li class="nav-item">
                <a class="nav-link" href="menuAdministrador.php">Volver al Menú Administrador</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    {if $mensaje}
        <div class="alert alert-{$mensaje_tipo|default:'info'}" role="alert">
            {$mensaje}
        </div>
    {/if}

    <h3 class="mb-3 text-center section-title">Administrar Usuarios</h3>

    <div class="panel-card mb-4">
        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="input-group-label" for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off">
                </div>
                <div class="form-group col-md-6">
                    <label class="input-group-label" for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" autocomplete="off">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="input-group-label" for="dni">DNI</label>
                    <input type="text" class="form-control" id="dni" name="dni" autocomplete="off">
                </div>
                <div class="form-group col-md-6">
                    <label class="input-group-label" for="role">Rol</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="">Seleccionar rol</option>
                        <option value="admin">Admin</option>
                        <option value="estudiante">Estudiante</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="input-group-label" for="username">Usuario</label>
                    <input type="text" class="form-control" id="username" name="username" required autocomplete="off">
                </div>
                <div class="form-group col-md-6">
                    <label class="input-group-label" for="password">Contraseña</label>
                    <input type="text" class="form-control" id="password" name="password" required autocomplete="off">
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn-formal mt-2">Crear usuario</button>
            </div>
        </form>
    </div>

    <div class="panel-table">
        <h4 class="mb-3 text-center section-title">Usuarios existentes</h4>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Creado</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$usuarios item=u}
                        <tr>
                            <td>{$u.username}</td>
                            <td>{$u.role}</td>
                            <td>{$u.nombre}</td>
                            <td>{$u.apellido}</td>
                            <td>{$u.dni}</td>
                            <td>{$u.creado_en}</td>
                        </tr>
                    {/foreach}
                    {if $usuarios|@count == 0}
                        <tr>
                            <td colspan="6" class="text-center text-muted">No hay usuarios registrados.</td>
                        </tr>
                    {/if}
                </tbody>
            </table>
        </div>
    </div>
</div>

{include file='footer.tpl'}

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
