-- Ensure the estudiante table stores an email address for each record.
ALTER TABLE IF EXISTS estudiante
    ADD COLUMN IF NOT EXISTS email VARCHAR(255);

