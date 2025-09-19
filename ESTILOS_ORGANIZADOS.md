# 🎨 ESTILOS ORGANIZADOS - RESTAURANTE

## 📁 Estructura de Archivos CSS

### 📍 Ubicación: `public/css/`

| Archivo | Descripción | Usado en |
|---------|-------------|----------|
| `estilos-del-menu.css` | Estilos principales del menú y página de inicio | Layout: `menu.blade.php` |
| `menu-styles.css` | Estilos complementarios para el menú | Layout: `menu.blade.php` |
| `carrito.css` | Estilos completos para el carrito de compras | Layout: `carrito.blade.php` |
| `dashboard.css` | Estilos para el dashboard y panel administrativo | Layout: `app.blade.php` |
| `reservas.css` | Estilos específicos para la gestión de reservas | Vistas: `reservas/*` |
| `productos.css` | Estilos para la gestión de productos | Vistas: `productos/*` |

### 📍 Ubicación: `resources/css/` (Archivos fuente)

| Archivo | Descripción | Estado |
|---------|-------------|--------|
| `estilos-del-menu.css` | Archivo fuente del menú | ✅ Sincronizado |
| `carrito.css` | Archivo fuente del carrito | ✅ Sincronizado |

## 🎯 Layouts y sus Estilos

### 1. Layout Principal (`layouts/app.blade.php`)
```html
<!-- Fuentes -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- Dashboard Styles -->
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
```

### 2. Layout del Menú (`layouts/menu.blade.php`)
```html
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
<!-- Menu Styles -->
<link rel="stylesheet" href="{{ asset('css/estilos-del-menu.css') }}">
<link rel="stylesheet" href="{{ asset('css/menu-styles.css') }}">
```

### 3. Layout del Carrito (`layouts/carrito.blade.php`)
```html
<!-- Fuentes -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Carrito Styles -->
<link rel="stylesheet" href="{{ asset('css/carrito.css') }}">
```

### 4. Layout de Bienvenida (`layouts/welcome.blade.php`)
```html
<!-- Fuentes -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Estilos inline personalizados -->
```

## 🎨 Paleta de Colores Unificada

### Colores Principales
- **Dorado Principal**: `#ffd700` (Gold)
- **Dorado Claro**: `#ffed4e`
- **Negro**: `#000000`
- **Gris Oscuro**: `#333333`
- **Gris Claro**: `#f8f9fa`

### Colores de Estado
- **Éxito**: `#28a745` (Verde)
- **Advertencia**: `#ffc107` (Amarillo)
- **Error**: `#dc3545` (Rojo)
- **Info**: `#17a2b8` (Azul)

### Gradientes
- **Principal**: `linear-gradient(135deg, #ffd700 0%, #ffed4e 100%)`
- **Oscuro**: `linear-gradient(135deg, #000000 0%, #1a1a1a 100%)`
- **Claro**: `linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)`

## 📱 Responsive Design

### Breakpoints Estándar
- **Mobile**: `max-width: 480px`
- **Tablet**: `max-width: 768px`
- **Desktop**: `max-width: 1024px`
- **Large Desktop**: `max-width: 1200px`

## 🔧 JavaScript Asociado

### Archivos JS
| Archivo | Ubicación | Descripción |
|---------|-----------|-------------|
| `carrito.js` | `public/js/` | Funcionalidades del carrito |
| `menu-test.js` | `resources/js/` | Pruebas del menú |
| `main.js` | `resources/js/` | Funciones principales |

## 📋 Cómo Usar los Estilos

### Para Nuevas Vistas

1. **Extender el layout apropiado:**
```php
@extends('layouts.app') // Para vistas administrativas
@extends('layouts.menu') // Para vistas del menú
@extends('layouts.carrito') // Para vistas del carrito
```

2. **Agregar estilos específicos:**
```php
@push('styles')
<link rel="stylesheet" href="{{ asset('css/tu-archivo.css') }}">
@endpush
```

3. **Agregar scripts específicos:**
```php
@push('scripts')
<script src="{{ asset('js/tu-script.js') }}"></script>
@endpush
```

### Clases CSS Principales

#### Botones
- `.btn-primary` - Botón principal dorado
- `.btn-secondary` - Botón secundario gris
- `.btn-success` - Botón verde
- `.btn-danger` - Botón rojo

#### Cards
- `.dashboard-card` - Tarjeta del dashboard
- `.menu-card` - Tarjeta del menú
- `.reserva-card` - Tarjeta de reserva
- `.producto-card` - Tarjeta de producto

#### Formularios
- `.form-control` - Input estándar
- `.form-label` - Etiqueta de formulario
- `.form-group` - Grupo de formulario

## ✅ Estado de Implementación

- [x] Estilos del menú principal
- [x] Estilos del carrito
- [x] Estilos del dashboard
- [x] Estilos de reservas
- [x] Estilos de productos
- [x] Layout principal actualizado
- [x] Layout del menú actualizado
- [x] Layout del carrito actualizado
- [x] JavaScript del carrito
- [x] Vista de reservas actualizada

## 🚀 Próximos Pasos

1. Actualizar vistas de productos
2. Actualizar vistas de pedidos
3. Crear estilos para noticias y promociones
4. Optimizar para mejor rendimiento
5. Agregar animaciones adicionales

## 📝 Notas Importantes

- Todos los archivos CSS están optimizados para responsive design
- Se utiliza Font Awesome 6.0.0 para iconos
- Las fuentes principales son Open Sans y Playfair Display
- Los colores siguen una paleta unificada
- Todos los layouts tienen soporte para @stack('styles') y @stack('scripts')