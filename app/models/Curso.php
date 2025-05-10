<?php

class Curso
{
    private $pdo;

    public function __construct($conexion)
    {
        $this->pdo = $conexion;
    }

    public function crear($id, $nombre, $cupo)
    {
        $stmt = $this->pdo->prepare("INSERT INTO curso (id, nombre, cupo) VALUES (?, ?, ?)");
        return $stmt->execute([$id, $nombre, $cupo]);
    }

    public function listarTodos()
    {
        $stmt = $this->pdo->query("SELECT * FROM curso ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminar($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM curso WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM curso WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function modificar($id, $nombre, $cupo)
    {
        $stmt = $this->pdo->prepare("UPDATE curso SET nombre = ?, cupo = ? WHERE id = ?");
        return $stmt->execute([$nombre, $cupo, $id]);
    }
}
