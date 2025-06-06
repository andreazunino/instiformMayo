<?php

class Estudiante
{
    private $pdo;

    public function __construct($conexion)
    {
        $this->pdo = $conexion;
    }

    public function crear($dni, $nombre, $apellido, $email)
    {
        $stmt = $this->pdo->prepare("INSERT INTO estudiante (dni, nombre, apellido, email) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$dni, $nombre, $apellido, $email]);
    }

    public function obtenerPorDNI($dni)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM estudiante WHERE dni = ?");
        $stmt->execute([$dni]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function modificar($dni, $nombre, $apellido, $email)
    {
        $stmt = $this->pdo->prepare("UPDATE estudiante SET nombre = ?, apellido = ?, email = ? WHERE dni = ?");
        return $stmt->execute([$nombre, $apellido, $email, $dni]);
    }

    public function eliminar($dni)
    {
        // 1) Eliminar inscripciones relacionadas
        $stmt1 = $this->pdo->prepare("DELETE FROM inscripcion WHERE dni_estudiante = ?");
        $stmt1->execute([$dni]);
    
        // 2) Eliminar estudiante
        $stmt2 = $this->pdo->prepare("DELETE FROM estudiante WHERE dni = ?");
        return $stmt2->execute([$dni]);
    }
    

    public function listarTodos()
    {
        $stmt = $this->pdo->query("SELECT * FROM estudiante ORDER BY apellido, nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
