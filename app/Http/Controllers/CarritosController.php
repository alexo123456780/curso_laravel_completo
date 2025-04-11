<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\Productos;

class CarritosController extends Controller
{
   

    //funcion para agregar al carrito 

    public function addCar(Request $request){

        try{

            $validaciones = $request->validate([

                'cliente_id' => 'required|numeric|exists:clientes,id',
                'producto_id' => 'required|numeric|exists:productos,id'

            ]);


            $productoExistente = Carrito::where('cliente_id', $validaciones['cliente_id'])->where('producto_id',$validaciones['producto_id'])->exists();


            if($productoExistente){

                return response()->json([

                    'status' => false,
                    'message' => 'El carrito existe actualmente',
                    'data' => 400

                ],400);
            }

            $productoAgregado = Carrito::create($validaciones);

            return response()->json([

                'status' => true,
                'message' => 'Producto agregado exitosamente al carrito',
                'data' => $productoAgregado,
                'code' => 200
                
            ],200);


        }catch(\Illuminate\Validation\ValidationException $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error de validacion',
                'warning' => $e->errors(),
                'code' => 400

            ],400);

        }catch(\Exception $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error interno en la solicitud',
                'warning' => $e->getMessage(),
                'code' => 500

            ],500);

        }


    }


    //eliminar carrito

    public function eliminarCarrito($id){

        try{

            $productoCarrito = Carrito::find($id);


            if(!$productoCarrito){

                return response()->json([

                    'status' => false,
                    'message' => 'No existe el id:  '.$id.' del carrito solicitado',
                    'code' => 404

                ],404);
            }


            $productoCarrito->delete();


            return response()->json([

                'status' => true,
                'message' => 'El articulo del carrito ha sido eliminado',
                'code' => 200

            ],200);

        }catch(\Exception $e){

            return response()->json([

                'status' => false,
                'message' => 'Error interno en la solicitud',
                'warning' => $e->getMessage(),
                'code' => 500

            ],500);

        }

    }

}
