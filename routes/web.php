<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;


 //Rutas del Catálogo Principal

// Página principal: muestra el catálogo con filtros
Route::get('/', [ProductoController::class, 'index'])->name('catalogo');

// Detalle de un producto individual
Route::get('/producto/{producto}', [ProductoController::class, 'show'])->name('producto.show');

 //Rutas de Administración (Gestor CRUD de Productos)

Route::get('/admin/productos', [ProductoController::class, 'adminIndex'])->name('admin.productos');
Route::post('/admin/productos', [ProductoController::class, 'store'])->name('admin.productos.store');
Route::put('/admin/productos/{producto}', [ProductoController::class, 'update'])->name('admin.productos.update');
Route::delete('/admin/productos/{producto}', [ProductoController::class, 'destroy'])->name('admin.productos.destroy');


//Rutas del Carrito de Compras y Checkout

Route::get('/carrito', [VentaController::class, 'carrito'])->name('carrito');
Route::post('/carrito/agregar/{producto}', [VentaController::class, 'agregarAlCarrito'])->name('carrito.agregar');
Route::delete('/carrito/remover/{id}', [VentaController::class, 'removerDelCarrito'])->name('carrito.remover');

Route::get('/checkout', [VentaController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [VentaController::class, 'procesarCompra'])->name('checkout.procesar');
Route::put('/carrito/actualizar/{id}', [VentaController::class, 'actualizarCantidad'])->name('carrito.actualizar');
Route::get('/factura/{venta}', [VentaController::class, 'factura'])->name('factura.mostrar');