<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Productos;

class VentasController extends Controller
{


    public function registrarCompra(Request $request){

        try{

            $ventaValidada = $request->validate([

                'vendedor_id' => 'required|numeric|exists:usuarios,id',
                'cliente_id' => 'required|numeric|exists:clientes,id',

            ]);

            $formularioValidado = $request->validate([
  
                'productos' => 'required|array',
                'productos.*.producto_id' => 'required|numeric|exists:productos,id',
                'productos.*.cantidad' => 'required|numeric',

            ]);

           $precioFinal = 0;


            $venta = Venta::create($ventaValidada);


            foreach($formularioValidado['productos'] as  $producto){

                $productoEncontrado = Productos::find($producto['producto_id']);


                if($productoEncontrado){

                    $venta->detalles()->create([

                        'producto_id' => $producto['producto_id'],
                        'cantidad' => $producto['cantidad'],
                        'precio_unitario' => $productoEncontrado->precio_producto
    
    
                    ]);
    


                }

            }


            $venta->update(['precio_final' => $precioFinal]);


            return response()->json([

                'status' => true,
                'message' => 'Venta exitosa',
                'data' => $venta,
                'code' => 201

            ],201);


        }catch(\Illuminate\Validation\ValidationException $e){

            return response()->json([

                'status' => false,
                'message' => 'Error de validacion',
                'warning' => $e->errors(),
                'code' => 400

            ],400);

        }catch(\Exception $e){

            return response()->json([

                'status' => false,
                'mesage' => 'Error interno',
                'warning' => $e->getMessage(),
                'code' => 500

            ],500);

        }







    }












    
}
