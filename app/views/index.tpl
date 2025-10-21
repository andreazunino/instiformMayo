<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instiform</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/styles.css">
    <style>
        body {
            background: linear-gradient(to bottom, #a1c4fd, #c2e9fb);
            min-height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        .container-welcome {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .welcome-heading {
            font-size: 36px;
            font-weight: bold;
            color: #343a40;
            margin-top: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        .btn-formal {
            margin: 10px;
        }
        .logo-large {
            max-width: 400px;
            margin: 20px;
        }
    </style>
</head>
<body>

<div class="container-fluid text-center container-welcome">
    <img src="public/img/Logo Instiform.png" alt="Logo de Instiform" class="img-fluid logo-large">
    <h1 class="welcome-heading">Bienvenido a Instiform</h1>

    <button onclick="window.location.href='app/controllers/menuEstudiante.php'" class="btn-formal">
        Soy Estudiante
    </button>

    <button class="btn-formal" data-toggle="modal" data-target="#adminModal">
        Soy Administrador
    </button>
</div>

<!-- Modal para administrador -->
<div class="modal fade" id="adminModal" tabindex="-1" role="dialog" aria-labelledby="adminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form id="admin-form">
        <div class="modal-header">
          <h5 class="modal-title" id="adminModalLabel">Contraseña del administrador</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="password" class="form-control" id="admin-password" placeholder="Ingrese contraseña" required>
          <div id="login-error" class="text-danger mt-2"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn-formal">Ingresar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('admin-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const password = document.getElementById('admin-password').value;
    if (password === 'admin123') {
        window.location.href = 'app/controllers/menuAdministrador.php';
    } else {
        document.getElementById('login-error').innerText = 'Contraseña incorrecta.';
    }
});
</script>

</body>
</html>
