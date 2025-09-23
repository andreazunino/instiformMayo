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
            vertical-align: top;
        }
        .tabla th {
            background-color: #4a90e2;
            color: white;
        }
        .lista-calificaciones {
            margin: 0;
            padding-left: 1rem;
        }
    </style>
</head>
<body>
    <div class="boletin">
        <h1>Boletín de Calificaciones</h1>
        <div class="datos">
            <p><strong>Estudiante:</strong> {}, {}</p>
            <p><strong>DNI:</strong> {}</p>
            <p><strong>Fecha:</strong> {}</p>
        </div>
        <div class="tabla">
            {if |@count > 0}
                <table>
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Calificaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from= item=nota}
                        <tr>
                            <td>{.materia}</td>
                            <td>
                                {if isset(.calificaciones) && .calificaciones|@count > 0}
                                    <ul class="lista-calificaciones">
                                        {foreach from=.calificaciones item=detalle}
                                            <li>
                                                {.valor}
                                                {if .fecha_formateada}
                                                    <span>({.fecha_formateada})</span>
                                                {/if}
                                            </li>
                                        {/foreach}
                                    </ul>
                                {else}
                                    {.calificacion|default:'-'}
                                {/if}
                            </td>
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
