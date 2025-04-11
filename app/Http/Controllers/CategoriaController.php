<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try{

            $allCategories = Categorias::all();


            if($allCategories->isEmpty()){

                return response()->json([

                    'status' => 'true',
                    'message' => 'No hay Categorias Existententes Aun',
                    'data' => [],
                    'code' => 404

                ],404);

            }


            return response()->json([

                'status' => true,
                'message' => 'Se obtuvieron todas las categorias correctamente',
                'data' => $allCategories,
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

    
    public function store(Request $request)
    {

        try{

            $categoriaValidada = $request->validate([

                'nombre_categoria' => 'string|max:255|unique:categorias|required',
                'imagen_categoria' => 'required|string'

            ]);


            $nuevaCategoria = Categorias::create($categoriaValidada);


            return response()->json([

                'status' => 'true',
                'message' => 'Categoria creada exitosamente',
                'data' => $nuevaCategoria,
                'code' => 201

            ],201);


        }catch(\Illuminate\Validation\ValidationException $e){

            return response()->json([

                'status' => 'false',
                'message' => 'Ocurrio un error de validacion de datos',
                'warning' => $e->errors(),
                'code' => 400

            ],400);

        }catch(\Exception $e){

            return response()->json([

                'status' => 'false',
                'message' => 'Ocurrio un error interno en la solicitud',
                'warning' => $e->getMessage(),
                'code' => 500

            ],500);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        try{

            $categoriaEncontrada = Categorias::find($id);

            if(!$categoriaEncontrada){

                return response()->json([

                    'status' => false,
                    'message' => 'El id '.   $id.  ' no existe o no se encuentra en la base de datos',
                    'code' => 404

                ],404);
            }


            return response()->json([

                'status' => true,
                'message' => 'Categoria encontrada exitosamente',
                'data' => $categoriaEncontrada,
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


    public function crearCategoria(Request $request){

        try{

            $categoriaValidada = $request->validate([

                'nombre_categoria' => 'required|string|max:255',
                'imagen_categoria' => 'required|string|nullable'
            ]);



            
            $categoriaNueva = Categorias::create($categoriaValidada);


            return response()->json([

                'status' => 'true',
                'message' => 'Categoria Creada Exitosamente',
                'data' => $categoriaNueva,
                'code' => 201

            ],201);

        }catch(\Illuminate\Validation\ValidationException $e){


            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error de validacion',
                'warning' => $e->errors(),
                'code' =>400

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


    public function cambiarImagenCategoria(Request $request , $id){


        try{

            $imagenValidada = $request->validate([

                'imagen_categoria' => 'required|string|nullable',

            ]);

            $categoriaExistente = Categorias::find($id);


            if(!$categoriaExistente){

                return response()->json([

                    'status' => false,
                    'message' => 'La categoria no existe o no se encuentra en la base de datos',
                    'code' => 404
                ],404);

            }

            $categoriaExistente->update($imagenValidada);


            return response()->json([

                'status' => true,
                'message' => 'La imagen de la categoria ha sido cambiada exitosamente',
                'data' => $categoriaExistente,
                'code' => 200

            ],200);


        }catch(\Illuminate\Validation\ValidationException $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error de validacion en la imagen',
                'warning' => $e->errors(),
                'code' => 400,

            ],400);

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
