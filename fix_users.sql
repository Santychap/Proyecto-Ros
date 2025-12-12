UPDATE users SET activo = 1 WHERE activo IS NULL;
UPDATE users SET fecha_creacion = NOW() WHERE fecha_creacion IS NULL;
UPDATE users SET fecha_actualizacion = NOW() WHERE fecha_actualizacion IS NULL;
