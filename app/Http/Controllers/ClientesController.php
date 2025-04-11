<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use Illuminate\Support\Facades\Hash;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try{

            $clientes = Clientes::all();


            if($clientes->isEmpty()){

                return response()->json([

                    'status' => true,
                    'message' => 'No hay clientes registrados',
                    'data' => [],
                    'code' => 200,

                ],200);

            }


            return response()->json([

                'status' => true,
                'message' => 'Clientes obtenidos correctamente',
                'data' => $clientes,
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

            $clienteValidacion = $request->validate([

                'nombre_cliente' => 'required|max:255|string',
                'email'=> 'required|unique:clientes|string',
                'password' => 'required|min:4|max:255|string',
                'telefono' => 'required|max:10|string',
                'direccion' =>'required|max:255|string',
                'perfil_cliente' => 'required|string|nullable'
            ]);

            $clienteValidacion['password'] = Hash::make($clienteValidacion['password']);


            $clienteNuevo = Clientes::create($clienteValidacion);


            return response()->json([

                'status' => true,
                'message' => 'Cliente creado correctamente',
                'data' => $clienteNuevo,
                'code' => 200

            ],200);


        }catch(\Illuminate\Validation\ValidationException $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error de validacion de datos',
                'warning' => $e->errors(),
                'code' => 400

            ],400);

        }catch(\Exception $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio  un error interno en la solicitud',
                'warning' => $e->getMessage(),
                'code' => 500

            ],500);

        }
        
    }



    public function registrarCliente(Request $request){


        try{


            $clienteValidado = $request->validate([

                'nombre_cliente' => 'required|max:255|string',
                'email'=> 'required|unique:clientes|string',
                'password' => 'required|min:4|max:8|string',
                'telefono' => 'required|max:10|string',
                'direccion' =>'required|max:255|string',
                'perfil_cliente' => 'required|string|nullable'
            ]);


            $clienteValidado['password'] = Hash::make($clienteValidado['password']);


            $clienteNuevo = Clientes::create($clienteValidado);



            return response()->json([

                'status' => true,
                'message' => 'Cliente registrado correctamente',
                'data' => $clienteNuevo,
                'code' => 201

            ],201);

        }catch(\Illuminate\Validation\ValidationException $e){

            return response()->json([

                'status' => false,
                'message' =>  'Ocurrio un error de validacion',
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






   
    public function show($id)
    {


        try{

            $clienteEncontrado = Clientes::find($id);

            if(!$clienteEncontrado){

                return response()->json([

                    'status' => false,
                    'message' => 'El cliente no existe o no esta registrado en la base de datos',
                    'code' => 404,

                ],404);

            }


            return response()->json([

                'status' => true,
                'message' => 'Cliente encontrado correctamente',
                'data' => $clienteEncontrado,
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

   
    public function update(Request $request, $id)
    {

        try{

            $clienteEncontrado = Clientes::find($id);


            if(!$clienteEncontrado){


                return response()->json([

                    'status' => false,
                    'message' => 'El usuario no existe o no se encuentra en la base de datos',
                    'code' => 404
                ],404);

            }

            $clienteValidacion = $request->validate([

                'nombre_cliente' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'telefono' =>'required|string|max:10',
                'direccion' =>'required|string|max:255',
                'perfil_cliente' =>'required|string|max:255|nullable',
                'password' =>  'required|min:4|max:8|string'

            ]);

            $clienteValidacion['password'] = Hash::make($clienteValidacion['password']);


            $clienteEncontrado->update($clienteValidacion);

            return response()->json([

                'status' => true,
                'message' => 'Cliente actualizado correctamente',
                'data' => $clienteEncontrado,
                'code' => 200

            ],200);

        }catch(\Illuminate\Validation\ValidationException $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error de validacion de datos',
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



    //funcion para cambiar el password del cliente


    public function cambiarPasswordCliente(Request $request, $id ){



    try{


        $clienteExistente = Clientes::find($id);

        if(!$clienteExistente){

            return response()->json([

                'status' => false,
                'message' => 'El cliente no existe o no se encuentra en la base de datos',
                'code' => 404,
            ],404);

        }


        $datosValidados = $request->validate([

            'password' => 'required|string|min:4|max:20'


        ]);



        $datosValidados['password'] = Hash::make($datosValidados['password']);



        $clienteExistente->update($datosValidados);



        return response()->json([

            'status' => true,
            'message' => 'Password actualizado correctamente',
            'data' => $clienteExistente,
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
            'code' => 500,

        ],500);

    }
    }


    //funcion para ver el carrito del cliente y los productos que tiene en su carrito



    public function verCarrito($id){

        try{


            $carrito = Clientes::with('productos')->find($id);


            if(!$carrito){

                return response()->json([

                    'status' => false,
                    'message' => 'El id del cliente no existe o no se encuentra en la base de datos:  '.$id.' id desconocido',
                    'code' => 404

                ],404);

            }



            if($carrito['productos']->isEmpty()){

                return response()->json([

                    'status' => true,
                    'message' => 'El cliente no tiene productos en el carrito aun',
                    'data' => [],
                    'code' => 200

                ],200);

            }


            $productosCarrito = $carrito['productos'];



            return response()->json([


                'status' => true,
                'message' => 'Productos del carrito obtenido correctamente',
                'data' => $productosCarrito,
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


    public function cambiarFoto(Request $request, $id){

        try{

            $imagenValidada = $request->validate([

                'perfil_cliente' => 'required|string|nullable'

            ]);


            $clienteCambiado = Clientes::find($id);


            if(!$clienteCambiado){

                return response()->json([

                    'status' => 'false',
                    'message' => 'El cliente que busca no se encuentra o no existe',
                    'code' => 404
                ],404);

            }


            $clienteCambiado->update($imagenValidada);


            return response()->json([

                'status' => true,
                'message' => 'Perfil del cliente cambiado correctamente',
                'data' => $clienteCambiado,
                'code' => 200

            ],200);


        }catch(\Illuminate\Validation\ValidationException $e){

            return response()->json([

                'status' => false,
                'message' => 'Error de validacion de imagen',
                'warning' => $e->errors(),
                'code' => 400

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
