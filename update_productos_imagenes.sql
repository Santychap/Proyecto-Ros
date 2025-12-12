-- Script para actualizar productos existentes con URLs de imágenes
-- Ejecutar este script en la base de datos para agregar imágenes a productos existentes

-- Actualizar productos con imágenes disponibles
UPDATE productos SET imagen_url = '/images/productos/patacon.jpg' WHERE nombre LIKE '%Lomo%' OR nombre LIKE '%Patacón%';
UPDATE productos SET imagen_url = '/images/productos/coca.jpg' WHERE nombre LIKE '%Coca%' OR nombre LIKE '%Inca%' OR nombre LIKE '%bebida%';
UPDATE productos SET imagen_url = '/images/productos/fresas con crema.jpg' WHERE nombre LIKE '%Tiramisú%' OR nombre LIKE '%postre%' OR nombre LIKE '%fresas%';
UPDATE productos SET imagen_url = '/images/productos/11.jpg' WHERE nombre LIKE '%Ensalada%' OR imagen_url IS NULL;

-- Verificar los cambios
SELECT id_producto, nombre, imagen_url FROM productos WHERE imagen_url IS NOT NULL;