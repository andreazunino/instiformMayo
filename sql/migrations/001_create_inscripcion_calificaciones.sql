CREATE TABLE IF NOT EXISTS inscripcion_calificaciones (
    id SERIAL PRIMARY KEY,
    inscripcion_id INTEGER NOT NULL REFERENCES inscripcion(id) ON DELETE CASCADE,
    calificacion NUMERIC(5,2) NOT NULL,
    fecha_registro TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS idx_inscripcion_calificaciones_inscripcion_id
    ON inscripcion_calificaciones (inscripcion_id);
