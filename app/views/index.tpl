<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instiform</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        .btn-custom {
            background-color: #4a90e2;
            color: #ffffff;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 50px;
            transition: background-color 0.3s ease;
            margin: 10px;
        }

        .btn-custom:hover {
            background-color: #357abd;
        }

        #admin-login-form {
            display: none;
            margin-top: 20px;
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

    <!-- Botones -->
    <button onclick="window.location.href='app/controllers/menuEstudiante.php'" class="btn btn-custom">Soy Estudiante</button>
    <button onclick="toggleAdminForm()" class="btn btn-custom">Soy Administrador</button>

    <!-- Formulario de login admin -->
    <div id="admin-login-form" class="col-md-4 offset-md-4">
        <form id="admin-form">
            <div class="form-group">
                <input type="password" id="admin-password" class="form-control" placeholder="Contraseña del administrador" required>
            </div>
            <button type="submit" class="btn btn-custom btn-block">Ingresar</button>
        </form>
        <div id="login-error" style="color: red; margin-top: 10px;"></div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    function toggleAdminForm() {
        const form = document.getElementById('admin-login-form');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    document.getElementById('admin-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const password = document.getElementById('admin-password').value;

        // Validación simple
        if (password === 'admin123') {
            window.location.href = 'app/controllers/menuAdministrador.php';
        } else {
            document.getElementById('login-error').innerText = 'Contraseña incorrecta. Intentá nuevamente.';
        }
    });
</script>

</body>
</html>
