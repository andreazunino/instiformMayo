<?php

declare(strict_types=1);

class CursoModelTest extends TestCase
{
    private PDO $pdo;
    private Curso $model;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("
            CREATE TABLE curso (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nombre TEXT NOT NULL,
                cupo INTEGER NOT NULL
            );
        ");
        $this->model = new Curso($this->pdo);
    }

    public function testCrearYListarCursos(): void
    {
        $this->assertTrue($this->model->crear('Matemática', 30), 'No se pudo crear el curso.');
        $this->assertTrue($this->model->crear('Lengua', 25), 'No se pudo crear el segundo curso.');

        $cursos = $this->model->listarTodos();
        $this->assertEquals(2, count($cursos), 'La cantidad de cursos listados no es correcta.');
    }

    public function testModificarCurso(): void
    {
        $this->model->crear('Historia', 20);
        $curso = $this->model->listarTodos()[0];

        $this->assertTrue(
            $this->model->modificar($curso['id'], 'Historia Universal', 22),
            'No se pudo modificar el curso.'
        );

        $actualizado = $this->model->obtenerPorId($curso['id']);
        $this->assertEquals('Historia Universal', $actualizado['nombre'], 'El curso no se actualizó correctamente.');
        $this->assertEquals(22, (int) $actualizado['cupo'], 'El cupo no se actualizó correctamente.');
    }

    public function testEliminarCurso(): void
    {
        $this->model->crear('Geografía', 18);
        $curso = $this->model->listarTodos()[0];

        $this->assertTrue($this->model->eliminar($curso['id']), 'No se pudo eliminar el curso.');
        $borrado = $this->model->obtenerPorId($curso['id']);
        $this->assertTrue($borrado === false || $borrado === null, 'El curso debería haberse eliminado.');
    }
}
