<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\PromocionController;
<<<<<<< HEAD
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportesController;
=======
>>>>>>> c5eafba12a8e0645d3d855a7405f2f47bcd1ef45

// ========================================
// RUTAS PÚBLICAS
// ========================================

// Página principal
Route::view('/', 'welcome')->name('home');

// Menú público
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

<<<<<<< HEAD
// Noticias y promociones públicas
Route::get('/noticias-web', [NoticiaController::class, 'publicIndex'])->name('noticias.publicIndex');
Route::get('/promociones-web', [PromocionController::class, 'publicIndex'])->name('promociones.publicIndex');

// Reservas públicas
Route::get('/reservas-web', [ReservaController::class, 'publicIndex'])->name('reservas.publicIndex');
Route::post('/reservas-web', [ReservaController::class, 'publicStore'])->name('reservas.publicStore');

// Carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('/carrito/eliminar', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::get('/carrito/count', [CarritoController::class, 'count'])->name('carrito.count');

// ========================================
// RUTAS PROTEGIDAS (Requieren autenticación)
// ========================================

=======
// Rutas públicas para mostrar noticias y promociones
Route::get('/noticias-web', [NoticiaController::class, 'publicIndex'])->name('noticias.publicIndex');
Route::get('/promociones-web', [PromocionController::class, 'publicIndex'])->name('promociones.publicIndex');

// Rutas protegidas (requieren login y verificación)
>>>>>>> c5eafba12a8e0645d3d855a7405f2f47bcd1ef45
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard inteligente por roles
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Perfil de usuario
    Route::view('/profile', 'profile')->name('profile');

    // ========================================
    // RECURSOS ADMINISTRATIVOS
    // ========================================
    
    // Gestión de reservas
    Route::resource('reservas', ReservaController::class);
    
    // Gestión de usuarios (solo admin)
    Route::resource('users', UserController::class);
    
    // Gestión de mesas
    Route::resource('mesas', MesaController::class);
    
    // Gestión de productos
    Route::resource('productos', ProductoController::class);
    
    // Gestión de categorías
    Route::resource('categorias', CategoriaController::class);
    
    // Gestión de noticias (solo admin)
    Route::resource('noticias', NoticiaController::class);
    
    // Gestión de promociones (solo admin)
    Route::resource('promociones', PromocionController::class)
        ->parameters(['promociones' => 'promocion']);
    
    // Reportes
    Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');

    // ========================================
    // HORARIOS
    // ========================================
    
    Route::get('/horarios', [HorarioController::class, 'index'])->name('horarios.index');
    Route::get('/horarios/create', [HorarioController::class, 'create'])->name('horarios.create');
    Route::post('/horarios', [HorarioController::class, 'store'])->name('horarios.store');
    Route::get('/horarios/{horario}/edit', [HorarioController::class, 'edit'])->name('horarios.edit');
    Route::put('/horarios/{horario}', [HorarioController::class, 'update'])->name('horarios.update');
    Route::delete('/horarios/{horario}', [HorarioController::class, 'destroy'])->name('horarios.destroy');

<<<<<<< HEAD
    // ========================================
    // PEDIDOS
    // ========================================
    
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/confirmacion/{pedido}', [PedidoController::class, 'confirmacion'])->name('pedidos.confirmacion');
    Route::post('/pedidos/{pedido}/cancelar', [PedidoController::class, 'cancelar'])->name('pedidos.cancelar');
    Route::put('/pedidos/{pedido}/estado', [PedidoController::class, 'actualizarEstado'])->name('pedidos.actualizarEstado');
    Route::put('/pedidos/{pedido}/cancelar', [PedidoController::class, 'adminCancelar'])->name('pedidos.adminCancelar');
    Route::delete('/pedidos/{pedido}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');
    Route::delete('/pedidos-vaciar-todos', [PedidoController::class, 'vaciarTodos'])->name('pedidos.vaciarTodos');
    Route::get('/pedidos/historial', [PedidoController::class, 'historial'])->name('pedidos.historial');

    // ========================================
    // PAGOS
    // ========================================
    
    Route::resource('pagos', PagoController::class);
=======
    // Solo los administradores deberían ver estas rutas, valida dentro del controlador
    Route::get('horarios/create', [HorarioController::class, 'create'])->name('horarios.create');
    Route::post('horarios', [HorarioController::class, 'store'])->name('horarios.store');
    Route::get('horarios/{horario}/edit', [HorarioController::class, 'edit'])->name('horarios.edit');
    Route::put('horarios/{horario}', [HorarioController::class, 'update'])->name('horarios.update');
    Route::delete('horarios/{horario}', [HorarioController::class, 'destroy'])->name('horarios.destroy');

    // --- Rutas para pedidos ---
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/confirmacion/{pedido}', [PedidoController::class, 'confirmacion'])->name('pedidos.confirmacion');
    Route::post('/pedidos/{pedido}/cancelar', [PedidoController::class, 'cancelar'])->name('pedidos.cancelar');
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::put('/pedidos/{pedido}/estado', [PedidoController::class, 'actualizarEstado'])->name('pedidos.actualizarEstado');
    Route::put('/pedidos/{pedido}/cancelar', [PedidoController::class, 'adminCancelar'])->name('pedidos.adminCancelar');
    Route::get('/pedidos/historial', [PedidoController::class, 'historial'])->name('pedidos.historial');

    // --- Rutas para pagos ---
    // Cliente: iniciar pago
    Route::get('/pagos/create/{pedido}', [PagoController::class, 'create'])->name('pagos.create');
    Route::post('/pagos/store/{pedido}', [PagoController::class, 'store'])->name('pagos.store');

    // Cliente y administrador: ver pagos
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
    Route::get('/pagos/{pago}', [PagoController::class, 'show'])->name('pagos.show');

    // --- Rutas para Noticias y Promociones (solo admin, validar dentro del controlador) ---
    Route::resource('noticias', NoticiaController::class);

    // Rutas para Promociones - Corregido el parámetro
    Route::resource('promociones', PromocionController::class)
        ->parameters(['promociones' => 'promocion']);
>>>>>>> c5eafba12a8e0645d3d855a7405f2f47bcd1ef45
});

// ========================================
// RUTAS DE AUTENTICACIÓN
// ========================================

<<<<<<< HEAD
require __DIR__ . '/auth.php';
=======


// routes/web.php
Route::patch('/users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
Route::patch('/users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');


// Rutas de autenticación (login, registro, etc)
require __DIR__ . '/auth.php';
>>>>>>> c5eafba12a8e0645d3d855a7405f2f47bcd1ef45
