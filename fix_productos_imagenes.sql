-- Script para corregir las URLs de imágenes de productos
-- Ejecutar este script para actualizar las imágenes existentes

-- Actualizar productos con las imágenes correctas que existen
UPDATE productos SET imagen_url = '/images/productos/patacon.jpg' 
WHERE nombre LIKE '%Lomo%' OR nombre LIKE '%Patacón%' OR nombre LIKE '%Ensalada%';

UPDATE productos SET imagen_url = '/images/productos/coca.jpg' 
WHERE nombre LIKE '%Coca%' OR nombre LIKE '%Inca%' OR nombre LIKE '%bebida%';

UPDATE productos SET imagen_url = '/images/productos/fresas%20con%20crema.jpg' 
WHERE nombre LIKE '%Tiramisú%' OR nombre LIKE '%postre%' OR nombre LIKE '%fresas%';

UPDATE productos SET imagen_url = '/images/productos/11.jpg' 
WHERE imagen_url IS NULL OR imagen_url = '/images/productos/ensalada-cesar.jpg';

-- Verificar los cambios
SELECT id_producto, nombre, imagen_url FROM productos;