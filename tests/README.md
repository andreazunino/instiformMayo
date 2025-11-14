# Pruebas básicas

Se agregó un runner muy simple que no depende de PHPUnit para poder ejecutar pruebas unitarias contra los modelos sin necesidad de instalar dependencias externas.

## Ejecutar

```bash
cd c:\xampp\htdocs\InstiformMayo
php tests/run.php
```
En powershell: PS C:\xampp\htdocs\InstiformMayo> C:\xampp\php\php.exe tests\run.php

El comando creará un conjunto de tablas temporales en una base SQLite en memoria y verificará operaciones esenciales de los modelos `Estudiante` y `Curso`. El proceso finaliza con código `0` si todos los tests pasan, o `1` en caso contrario.
