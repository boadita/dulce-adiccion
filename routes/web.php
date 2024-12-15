<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('direccion', DireccionController::class);
    Route::resource('pedidos', PedidosController::class);
    Route::post('/pedidos/store', [PedidosController::class, 'store']);
    Route::resource('productos', ProductoController::class);
    Route::resource('items', ItemsController::class);
    Route::post('/filtrarProductos', [ProductoController::class, 'filtrarProductos'])->name('filtrar.productos');
    Route::get('/filtrarProductos', [ProductoController::class, 'filtrarProductos'])->name('filtrar.productos');
    Route::get('/hoy', [PedidosController::class, 'hoy'])->name('pedidos.hoy');
    Route::get('/historial', [PedidosController::class, 'historial'])->name('pedidos.historial');
    Route::get('/filtrar', [PedidosController::class, 'filtrar'])->name('pedidos.filtrar');
    Route::get('/pdf/{id}', [PedidosController::class, 'pdf'])->name('pedidos.pdf');
    Route::get('/historial_pdf', [PedidosController::class, 'historial_pdf'])->name('pedidos.historial_pdf');
    Route::get('/historial_excel', [PedidosController::class, 'historial_excel'])->name('pedidos.historial_excel');
});
