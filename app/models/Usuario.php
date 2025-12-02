<?php

class Usuario
{
    private $pdo;
    private $tablaVerificada = false;

    public function __construct($conexion)
    {
        $this->pdo = $conexion;
    }

    public function obtenerPorUsername(string $username): ?array
    {
        $this->asegurarTabla();
        $stmt = $this->pdo->prepare('SELECT id, username, password_hash, role, nombre, apellido, dni, email FROM usuarios WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function crear(string $username, string $passwordPlano, string $role, ?string $nombre = null, ?string $apellido = null, ?string $dni = null, ?string $email = null): bool
    {
        $hash = $passwordPlano; // Guardar plano a pedido del usuario
        $stmt = $this->pdo->prepare('INSERT INTO usuarios (username, password_hash, role, nombre, apellido, dni, email) VALUES (?, ?, ?, ?, ?, ?, ?)');

        return $stmt->execute([$username, $hash, $role, $nombre, $apellido, $dni, $email]);
    }

    public function validarCredenciales(string $username, string $password): ?array
    {
        $usuario = $this->obtenerPorUsername($username);
        if (
            $usuario &&
            (
                password_verify($password, $usuario['password_hash'])
                || $password === $usuario['password_hash'] // Soporta texto plano
            )
        ) {
            return $usuario;
        }

        return null;
    }

    private function asegurarTabla(): void
    {
        if ($this->tablaVerificada) {
            return;
        }

        try {
            $this->pdo->query('SELECT 1 FROM usuarios LIMIT 1');
            $this->tablaVerificada = true;
            $this->asegurarColumnasExtras();
            return;
        } catch (PDOException $e) {
            if ($e->getCode() !== '42P01') {
                throw $e;
            }
        }

        $this->crearTablaUsuarios();
        $this->tablaVerificada = true;
    }

    private function crearTablaUsuarios(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS usuarios (
                id SERIAL PRIMARY KEY,
                username VARCHAR(50) NOT NULL UNIQUE,
                password_hash VARCHAR(255) NOT NULL,
                role VARCHAR(20) NOT NULL CHECK (role IN ('admin', 'estudiante')),
                nombre VARCHAR(80),
                apellido VARCHAR(80),
                dni VARCHAR(20),
                email VARCHAR(120),
                creado_en TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW()
            );
        ");

        $this->asegurarColumnasExtras();

        // Semilla admin por defecto (clave plana: admin123) si no existe
        $hashAdmin = 'admin123';
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (username, password_hash, role, nombre, apellido) VALUES ('admin', ?, 'admin', 'Admin', 'Instiform') ON CONFLICT (username) DO NOTHING");
        $stmt->execute([$hashAdmin]);
    }

    private function asegurarColumnasExtras(): void
    {
        try {
            $this->pdo->exec("ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS nombre VARCHAR(80);");
            $this->pdo->exec("ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS apellido VARCHAR(80);");
            $this->pdo->exec("ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS dni VARCHAR(20);");
            $this->pdo->exec("ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS email VARCHAR(120);");

            // Completar datos básicos para el admin por defecto si faltan
            $this->pdo->exec("
                UPDATE usuarios
                SET nombre = COALESCE(nombre, 'Admin'),
                    apellido = COALESCE(apellido, 'Instiform')
                WHERE username = 'admin'
            ");
        } catch (PDOException $e) {
            error_log('No se pudieron asegurar columnas de usuarios: ' . $e->getMessage());
        }
    }

    public function listarTodos(): array
    {
        $this->asegurarTabla();
        $stmt = $this->pdo->query('SELECT id, username, role, nombre, apellido, dni, email, creado_en FROM usuarios ORDER BY creado_en DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existeUsername(string $username): bool
    {
        $this->asegurarTabla();
        $stmt = $this->pdo->prepare('SELECT 1 FROM usuarios WHERE username = ?');
        $stmt->execute([$username]);
        return (bool) $stmt->fetchColumn();
    }
}
