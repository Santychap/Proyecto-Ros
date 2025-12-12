<?php

/**
 * Archivo de rutas web del sistema de restaurante
 * Organizado por secciones: públicas, autenticadas, admin
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\DashboardController;
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
use App\Http\Controllers\InventarioController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Página principal
Route::view('/', 'welcome');

// Ruta pública para el menú
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// Rutas públicas para mostrar noticias y promociones
Route::get('/noticias-web', [NoticiaController::class, 'publicIndex'])->name('noticias.publicIndex');
Route::get('/promociones-web', [PromocionController::class, 'publicIndex'])->name('promociones.publicIndex');

// Ruta pública para reservas
Route::get('/reservas-web', [ReservaController::class, 'publicCreate'])->name('reservas.publicCreate');
Route::post('/reservas-web', [ReservaController::class, 'publicStore'])->name('reservas.publicStore');

/*
|--------------------------------------------------------------------------
| RUTAS AUTENTICADAS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ReporteController;
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/empleado', [DashboardController::class, 'empleado'])->name('dashboard.empleado');
    // Ruta de reportes solo para administrador
    Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('reportes/pdf/{tipo}', [ReporteController::class, 'descargarPDF'])->name('reportes.pdf');
    Route::get('reportes/{tipo}', [ReporteController::class, 'mostrarReporteIndividual'])->name('reportes.individual');
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
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/confirmacion/{pedido}', [PedidoController::class, 'confirmacion'])->name('pedidos.confirmacion');
    Route::post('/pedidos/{pedido}/cancelar', [PedidoController::class, 'cancelar'])->name('pedidos.cancelar');
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::put('/pedidos/{pedido}/estado', [PedidoController::class, 'actualizarEstado'])->name('pedidos.actualizarEstado');
    Route::put('/pedidos/{pedido}/cancelar', [PedidoController::class, 'adminCancelar'])->name('pedidos.adminCancelar');
    Route::get('/pedidos/historial', [PedidoController::class, 'historial'])->name('pedidos.historial');
    Route::get('/pedidos/pendientes', [PedidoController::class, 'pendientes'])->name('pedidos.pendientes');
    // --- Rutas para pagos ---
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
    Route::get('/pagos/admin', [PagoController::class, 'admin'])->name('pagos.admin');
    Route::get('/pagos/historial', [PagoController::class, 'historial'])->name('pagos.historial');
    Route::get('/pagos/create/{pedido}', [PagoController::class, 'create'])->name('pagos.create');
    Route::post('/pagos/store/{pedido}', [PagoController::class, 'store'])->name('pagos.store');
    Route::get('/pagos/{pago}', [PagoController::class, 'show'])->name('pagos.show');
    Route::put('/pagos/{pago}/estado', [PagoController::class, 'cambiarEstado'])->name('pagos.cambiarEstado');

    // --- Rutas para Noticias y Promociones (solo admin, validar dentro del controlador) ---
    Route::resource('noticias', NoticiaController::class);

    // Rutas para Promociones - Corregido el parámetro
    Route::resource('promociones', PromocionController::class)
        ->parameters(['promociones' => 'promocion']);

    // Rutas para Inventario
    Route::resource('inventario', InventarioController::class);
    Route::post('inventario/{inventario}/ajustar-stock', [InventarioController::class, 'ajustarStock'])->name('inventario.ajustar-stock');
});

/*
|--------------------------------------------------------------------------
| RUTAS DEL CARRITO
|--------------------------------------------------------------------------
*/
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito', [CarritoController::class, 'mostrar'])->name('carrito.mostrar');
Route::post('/carrito/actualizar', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
Route::post('/carrito/eliminar', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
Route::post('/carrito/confirmar', [CarritoController::class, 'confirmarPedido'])->name('carrito.confirmar');



// routes/web.php
Route::patch('/users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
Route::patch('/users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');


// Rutas de autenticación (login, registro, etc)
require __DIR__ . '/auth.php';
