<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuariosController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientesController;

use App\Http\Controllers\ClientesAuthController;

use App\Http\Controllers\CategoriaController;

use App\Http\Controllers\CarritosController;

use App\Http\Controllers\VentasController;

//login usuarios
Route::post('login',[AuthController::class,'login']);



//usuarios
Route::apiResource('usuarios',UsuariosController::class);
Route::put('password/{id}',[UsuariosController::class,'cambiarPassword']);
Route::post('register',[UsuariosController::class,'register']);
Route::put('cambiarFoto/{id}',[UsuariosController::class, 'cambiarFoto']);



//clientes
Route::apiResource('clientes',ClientesController::class);
Route::put('cambioPassword/{id}',[ClientesController::class,'cambiarPasswordCliente']);
Route::post('loginCliente',[ClientesAuthController::class,'login']);
Route::post('registrarCliente',[ClientesController::class,'registrarCliente']);
Route::put('cambiarFotoCliente/{id}',[ClientesController::class,'cambiarFoto']);

//carrito de clientes

Route::get('productosCarro/{id}',[ClientesController::class,'verCarrito']);







//productos
Route::apiResource('productos',ProductoController::class);
Route::post('crearProducto',[ProductoController::class,'crearProducto']);
Route::put('cambiarImagenP/{id}',[ProductoController::class,'cambiarImagenProducto']);
Route::put('agregarStock/{id}',[ProductoController::class,'agregarStock']);





//categorias
Route::apiResource('categorias',CategoriaController::class);
Route::post('crearCategoria',[CategoriaController::class,'crearCategoria']);
Route::put('cambiarImagenC/{id}',[CategoriaController::class, 'cambiarImagenCategoria']);



//carrito

Route::post('addCar',[CarritosController::class,'addCar']);

Route::delete('eliminarCarrito/{id}',[CarritosController::class,'eliminarCarrito']);

/*comentadodidiiadadao
Route::get('verCarrito/{id}',[CarritosController::class,'verCarrito']);*/


//ventas

Route::post('realizarVenta',[VentasController::class,'venta']);