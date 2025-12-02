-- Tabla de usuarios para autenticacion basada en roles
CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL CHECK (role IN ('admin', 'estudiante')),
    creado_en TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW()
);

-- Usuario admin inicial (clave: admin123)
INSERT INTO usuarios (username, password_hash, role)
VALUES ('admin', '$2y$10$0FMFhYCcmfo9nB5pYsoLReAgrGGiwhQOI2dRvax1zBGO0mcbzUIVS', 'admin')
ON CONFLICT (username) DO NOTHING;

-- Usuario de ejemplo para estudiantes (clave: alumno123)
INSERT INTO usuarios (username, password_hash, role)
VALUES ('alumno', '$2y$10$q9deIiew2hyg.ILUmklh7.eEWQ70oVhFKQXpzkbI3AIfukOJUO2Vy', 'estudiante')
ON CONFLICT (username) DO NOTHING;
