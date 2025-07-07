<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boletín del Estudiante</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
        }
        .boletin {
            background: #fff;
            padding: 30px;
            max-width: 800px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        .boletin h1 {
            text-align: center;
            color: #333;
        }
        .datos, .tabla {
            margin-top: 20px;
        }
        .tabla table {
            width: 100%;
            border-collapse: collapse;
        }
        .tabla th, .tabla td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        .tabla th {
            background-color: #4a90e2;
            color: white;
        }
    </style>
</head>
<body>
    <div class="boletin">
        <h1>Boletín de Calificaciones</h1>
        <div class="datos">
            <p><strong>Estudiante:</strong> {$apellido}, {$nombre}</p>
            <p><strong>DNI:</strong> {$dni}</p>
            <p><strong>Fecha:</strong> {$fecha}</p>
        </div>
        <div class="tabla">
            {if $notas|@count > 0}
                <table>
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Calificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$notas item=nota}
                        <tr>
                            <td>{$nota.materia}</td>
                            <td>{$nota.calificacion}</td>
                        </tr>
                        {/foreach}
                    </tbody>
                </table>
            {else}
                <p>Este estudiante aún no tiene calificaciones registradas.</p>
            {/if}
        </div>
    </div>
</body>
</html>
