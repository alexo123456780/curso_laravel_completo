<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Productos;

class ProductoController extends Controller
{
   
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
            'data' => $productos,
            'code' => 200
        ],200);

        
    }


    public function store(Request $request)
    {

        try{

            $productoValidados = $request->validate([

                'nombre_producto' => 'required|string|max:255',
                'precio_producto' => 'required|numeric',
                'descripcion' => 'required|string|nullable',
                'usuario_id' => 'required|exists:usuarios,id',
                "categoria_id" =>"required|exists:categorias,id",
                'imagen_producto' => 'required|string|nullable'

            ]);



            $productoNuevo = Productos::create($productoValidados);

            return response()->json([

                'status' => true,
                'message' => 'Producto creado exitosamente',
                'data' => $productoNuevo,
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
                'message' => 'Ocurrio un interno en la solicitud',
                'warning' => $e->getMessage(),
                'code' => 500

            ],500);

        }
       
    }


    public function crearProducto(Request $request){

        try{

            $productosValidados = $request->validate([

                'nombre_producto' => 'required|string|max:255',
                'precio_producto' => 'required|numeric',
                'descripcion' => 'required|string|nullable',
                'usuario_id' => 'required|exists:usuarios,id',
                "categoria_id" =>"required|exists:categorias,id",
                'imagen_producto' => 'required|string|nullable'


            ]);



            $productoNuevo = Productos::create($productosValidados);

            return response()->json([

                'status' => true,
                'message' => 'Producto creado exitosamente',
                'data' => $productoNuevo,
                'code' => 201

            ],201);


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
                'warning' =>$e->getMessage(),
                'code' => 500

            ],500);

        }

    }



   
    public function show($id)
    {
        try{

            $productoEncontrado = Productos::find($id);

            if(!$productoEncontrado){

                return response()->json([

                    'status' => false,
                    'message' => 'El id del producto no existe',
                    'code' => 404,

                ],404);
            }


            return response()->json([

                'status' => true,
                'message' => 'Producto encontrado exitosamente',
                'data' => $productoEncontrado,
                'code' => 200

            ],200);

        }catch(\Exception $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error interno en la peticion'.$e->getMessage(),
                'code' => 400

            ],400);

        }
        
    }


    public function update(Request $request, $id)
    {

        try{

            $productoEncontrado = Productos::find($id);


            $productoValidados = $request->validate([

                'nombre_producto' => 'required|string|max:255',
                'precio_producto' => 'required|numeric',
                'descripcion' => 'required|string|nullable',
                'imagen_producto' =>  'required|string|nullable'

            ]);

            if(!$productoEncontrado){

                return response()->json([

                    'status' => false,
                    'message' => 'El id del producto no existe',
                    'code' => 404

                ],404);


            }

        


            $productoEncontrado->update($productoValidados);


            return response()->json([

                'status' => true,
                'message' => 'El producto se actualizo correctamente',
                'data' => $productoEncontrado,
                'code' => 200

            ],200);


        }catch(\Illuminate\Validation\ValidationException $e){

            return response()->json([

                'status' => false,
                'message' => 'error de validacion',
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

    
    public function destroy($id)
    {

        try{

            $productoEncontrado = Productos::find($id);

            if(!$productoEncontrado){

                return response()->json([

                    'status' => false,
                    'message' => 'El numero del id no existe',
                    'code' => 404

                ],404);

            }


            $productoEncontrado->delete();

            return response()->json([

                'status' => true,
                'message' => 'Producto eliminado exitosamente',
                'code' => 200,

            ],200);



        }catch(\Exception $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error en la solicitud',
                'warning' => $e->getMessage(),
                'code' => 500

            ],500);

        }
        
    }


    public function cambiarImagenProducto(Request $request, $id){

        try{

            $imagenValidada = $request->validate([

                'imagen_producto' =>  'required|string|nullable'
            ]);

            $productoExistente = Productos::find($id);

            if(!$productoExistente){
                return response()->json([

                    'status' => false,
                    'message' => 'El producto no existe o no se encuentra en la base de datos',
                    'code' => 404
                ],404);

            }


            $productoExistente->update($imagenValidada);


            return response()->json([

                'status' => true,
                'message' => 'La imagen del producto ha sido cambidao exitosamnete',
                'data' => $productoExistente,
                'code' => 200

            ],200);


        }catch(\Illuminate\Validation\ValidationException $e){

            return response()->json([

                'status' => false,
                'message' => 'error de validacion de la imagen del producto',
                'warning' => $e->errors(),
                'code' => 400

            ],400);



        }catch(\Exception $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error en la solicitud',
                'warning' => $e->getMessage(),
                'code' => 500

            ],500);


        }






    }
}
