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

// Ruta pública para la página principal (welcome)
Route::view('/', 'welcome');

// Ruta pública para el menú
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// Rutas protegidas (requieren login y verificación)
Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');

    // Recursos protegidos
    Route::resource('reservas', ReservaController::class);

    // Recursos para usuarios autenticados (admin o no)
    Route::resource('users', UserController::class);
    Route::resource('mesas', MesaController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('categorias', CategoriaController::class);

    // Rutas horarios (cualquier autenticado puede verlos)
    Route::get('horarios', [HorarioController::class, 'index'])->name('horarios.index');

    // Solo los administradores deberían ver estas rutas, valida dentro del controlador
    Route::get('horarios/create', [HorarioController::class, 'create'])->name('horarios.create');
    Route::post('horarios', [HorarioController::class, 'store'])->name('horarios.store');
    Route::get('horarios/{horario}/edit', [HorarioController::class, 'edit'])->name('horarios.edit');
    Route::put('horarios/{horario}', [HorarioController::class, 'update'])->name('horarios.update');
    Route::delete('horarios/{horario}', [HorarioController::class, 'destroy'])->name('horarios.destroy');

    // --- Rutas para pedidos ---

    // Cliente: crear pedido y ver confirmación
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/confirmacion', [PedidoController::class, 'confirmacion'])->name('pedidos.confirmacion');

    // Cliente: cancelar su pedido (POST porque es una acción)
    Route::post('/pedidos/{pedido}/cancelar', [PedidoController::class, 'cancelar'])->name('pedidos.cancelar');

    // Empleado y Admin: ver pedidos
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');

    // Empleado y Admin: actualizar estado (PUT)
    Route::put('/pedidos/{pedido}/estado', [PedidoController::class, 'actualizarEstado'])->name('pedidos.actualizarEstado');

    // Admin: cancelar pedido (PUT)
    Route::put('/pedidos/{pedido}/cancelar', [PedidoController::class, 'adminCancelar'])->name('pedidos.adminCancelar');

    // Admin: historial completo de pedidos
    Route::get('/pedidos/historial', [PedidoController::class, 'historial'])->name('pedidos.historial');
});

// Rutas para el carrito (públicas o protegidas según lógica de negocio)
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito', [CarritoController::class, 'mostrar'])->name('carrito.mostrar');
Route::post('/carrito/actualizar', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
Route::post('/carrito/eliminar', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');

// Rutas de autenticación (login, registro, etc)
require __DIR__ . '/auth.php';
