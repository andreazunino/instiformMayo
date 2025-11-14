<?php

declare(strict_types=1);

class EstudianteModelTest extends TestCase
{
    private PDO $pdo;
    private Estudiante $model;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->crearSchema();
        $this->model = new Estudiante($this->pdo);
    }

    private function crearSchema(): void
    {
        $this->pdo->exec("
            CREATE TABLE estudiante (
                dni TEXT PRIMARY KEY,
                nombre TEXT NOT NULL,
                apellido TEXT NOT NULL,
                email TEXT NOT NULL
            );
            CREATE TABLE inscripcion (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                dni_estudiante TEXT,
                id_curso INTEGER
            );
        ");
    }

    public function testCrearYObtenerEstudiante(): void
    {
        $this->assertTrue(
            $this->model->crear('100', 'Ana', 'García', 'ana@example.com'),
            'No se pudo crear el estudiante.'
        );

        $estudiante = $this->model->obtenerPorDNI('100');
        $this->assertEquals('Ana', $estudiante['nombre'], 'El nombre recuperado no coincide.');
        $this->assertEquals('García', $estudiante['apellido'], 'El apellido recuperado no coincide.');
    }

    public function testModificarEstudiante(): void
    {
        $this->model->crear('101', 'Luis', 'Suarez', 'luis@example.com');
        $this->assertTrue(
            $this->model->modificar('101', 'Luis Alberto', 'Suarez', 'luisa@example.com'),
            'La actualización del estudiante falló.'
        );

        $actualizado = $this->model->obtenerPorDNI('101');
        $this->assertEquals('Luis Alberto', $actualizado['nombre'], 'El nombre no se actualizó.');
        $this->assertEquals('luisa@example.com', $actualizado['email'], 'El email no se actualizó.');
    }

    public function testEliminarEstudiante(): void
    {
        $this->model->crear('102', 'Maria', 'Lopez', 'maria@example.com');
        $this->pdo->prepare('INSERT INTO inscripcion (dni_estudiante, id_curso) VALUES (?, ?)')->execute(['102', 1]);

        $this->assertTrue($this->model->eliminar('102'), 'No se pudo eliminar el estudiante.');
        $resultado = $this->model->obtenerPorDNI('102');
        $this->assertTrue($resultado === false || $resultado === null, 'El estudiante debería haberse eliminado.');
    }
}
