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


//login usuarios
Route::post('login',[AuthController::class,'login']);



//usuarios
Route::apiResource('usuarios',UsuariosController::class);
Route::put('password/{id}',[UsuariosController::class,'cambiarPassword']);
Route::post('register',[UsuariosController::class,'register']);






//clientes
Route::apiResource('clientes',ClientesController::class);
Route::put('cambioPassword/{id}',[ClientesController::class,'cambiarPasswordCliente']);
Route::post('loginCliente',[ClientesAuthController::class,'login']);

//carrito de clientes

Route::get('productosCarro/{id}',[ClientesController::class,'verCarrito']);







//productos
Route::apiResource('productos',ProductoController::class);
Route::post('crearProducto',[ProductoController::class,'crearProducto']);





//categorias
Route::apiResource('categorias',CategoriaController::class);
Route::post('crearCategoria',[CategoriaController::class,'crearCategoria']);



//carrito

Route::post('addCar',[CarritosController::class,'addCar']);

/*comentadodidiiadadao
Route::get('verCarrito/{id}',[CarritosController::class,'verCarrito']);*/


