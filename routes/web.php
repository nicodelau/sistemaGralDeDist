<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TalonarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/clientes', function () {
    return view('clientes');
})->middleware(['auth', 'verified'])->name('clientes');

Route::get('/talonario', function () {
    return view('talonario');
})->middleware(['auth', 'verified'])->name('talonario');

Route::get('/stock', function () {
    return view('stock');
})->middleware(['auth', 'verified'])->name('stock');

Route::get('/facturas', function () {
    return view('facturas');
})->middleware(['auth', 'verified'])->name('facturas');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// lista de precios

Route::get('/buscarProducto', [ProductoController::class, 'getProduct'])->name('buscarProducto');

Route::get('/listaDePrecios', [ProductoController::class, 'getProducts'])->name('listaDePrecios');

Route::get('/cargarProducto', [ProductoController::class, 'addProduct'])->name('cargarProducto');

Route::get('/modificarProducto', [ProductoController::class, 'modifProduct'])->name('modificarProducto');

Route::get('/deleteProducto', [ProductoController::class, 'deleteProducto'])->name('deleteProducto');

// clientes

Route::get('/buscarCliente', [ClienteController::class, 'getCliente'])->name('buscarCliente');

Route::get('/clientes', [ClienteController::class, 'getClientes'])->name('clientes');

Route::get('/cargarCliente', [ClienteController::class, 'addCliente'])->name('agregarCliente');

Route::get('/modificarCliente', [ClienteController::class, 'modifCliente'])->name('modificarCliente');

Route::get('/deleteCliente', [ClienteController::class, 'deleteCliente'])->name('deleteCliente');

Route::get('/cuantoDebe', [ClienteController::class, 'cuantoDebe'])->name('cuantoDebe');

// talonario

Route::get('/guardarTalonario', [TalonarioController::class, 'guardarTalonario'])->name('guardarTalonario');

Route::get('/getCuenta', [TalonarioController::class, 'getCuenta'])->name('getCuenta');

Route::get('/modificarTalonario', [TalonarioController::class, 'modificarTalonario'])->name('modificarTalonario');

Route::get('/modificarTalonarioFromCuentas', [TalonarioController::class, 'modificarTalonarioFromCuentas'])->name('modificarTalonarioFromCuentas');

require __DIR__.'/auth.php';
