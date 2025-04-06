<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\Productos;

class CarritosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function verCarrito($id){

        try{




            //la funcion whit sirve para ver algo relacion de una clave foranea en este caso el de productos
            $carritos = Carrito::with('productos')->find($id);


            if(!$carritos){

                return response()->json([

                    'status' => false,
                    'message' => 'El id del carrito no existe',
                    'code' => 404
                ],404);

            }


            $productoEncontrados = $carritos->productos;

            return response()->json([

                'status' => true,
                'message' => 'Productos encontrados',
                'data' => $productoEncontrados,
                'code' => 200
            ],200);


        }catch(\Exception $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error interno en la solicitud',
                'warning' => $e->getMessage(),
                'code' => 500

        
            ],500);

        }














    }






    //funcion para agregar al carrito 

    public function addCar(Request $request){

        try{

            $validaciones = $request->validate([

                'cliente_id' => 'required|numeric|exists:clientes,id',
                'producto_id' => 'required|numeric|exists:productos,id'

            ]);


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

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
