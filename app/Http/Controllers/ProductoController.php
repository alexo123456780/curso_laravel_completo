<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Productos;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $productos = Productos::all();

        if($productos->isEmpty()){

            return response()->json([

                'status' => true,
                'message' => 'No hay productos aun en la base de datos',
                'data' => []

            ],200);

        }


        return response()->json([

            'status' => true,
            'message' => 'Se obtuvieron todos los productos correctamente',
            'data' => $productos
        ],200);

        
    }






    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $productosValidados = $request->validate([

            'nombre_producto' => 'required|string|max:255',
            'precio_producto' => 'required|numeric',
            'descripcion' => 'required|nullable|string'

        ]);


        try{

            $productoNuevo = Productos::create($productosValidados);

            if(!$productoNuevo){

                return response()->json([

                    'status' => false,
                    'message' => 'Ocurrio un error en la validacion de datos',
                    'response' => 400

                ],400);

            }


            return response()->json([

                'status' => true,
                'message' => 'Producto creado exitosamente',
                'data' => $productoNuevo

            ],200);



        }catch(\Exception $e){


            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error en la solicitud',
                'response' => 400

            ],400);

        }        
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
