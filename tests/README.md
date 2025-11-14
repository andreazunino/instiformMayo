# Pruebas básicas

Se agregó un runner muy simple que no depende de PHPUnit para poder ejecutar pruebas unitarias contra los modelos sin necesidad de instalar dependencias externas.

## Suites incluidas

- `EstudianteModelTest` y `CursoModelTest` levantan una base SQLite en memoria dentro de `setUp()` y ejercitan los métodos CRUD de ambos modelos. Al ser una base temporal, los tests no dependen de la instancia PostgreSQL configurada para la aplicación.
- El runner (`tests/run.php`) usa `TestRunner` para ejecutar cada método que empiece con `test` y reportar el resultado por consola.

## Ejecutar

```bash
cd c:\xampp\htdocs\InstiformMayo
php tests/run.php
```
En PowerShell: `PS C:\xampp\htdocs\InstiformMayo> C:\xampp\php\php.exe tests\run.php`

El comando creará las tablas temporales en memoria y verificará las operaciones esenciales de los modelos `Estudiante` y `Curso`. El proceso finaliza con código `0` si todos los tests pasan, o `1` en caso contrario.

## ¿Cómo validar la conexión PostgreSQL?

Actualmente ninguna suite toca la base real, por lo que los tests siguen pasando aunque desconecteemos PostgreSQL. Para cubrir ese caso:

1. Crear `tests/unit/DatabaseConnectionTest.php` que incluya `BASE_PATH . '/sql/db.php'` en `setUp()`, guarde la variable `$pdo` y ejecute una consulta trivial (`SELECT 1`).
2. Registrar el archivo nuevo en `tests/bootstrap.php` con un `require_once`.
3. En `tests/run.php` agregar `$runner->addTest(new DatabaseConnectionTest());`.

Con eso, si la conexión definida en `sql/db.php` falla, la nueva suite marcará el fallo y el comando retornará `1`.
