<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class UsuariosController extends Controller
{
    
    public function index()
    {

        try{

            $usuarios = Usuarios::all();

            return response()->json([

                'status' => true,
                'message' => 'Usuarios obtenidos correctamente',
                'data' => $usuarios,
                'code' => 200

            ],200);

        }catch(\Exception $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error en la solicitud',
                'warning' => $e->getMessage(),
                'code' => 400

            ],400);
        }
    }

   
   
    public function register(Request $request)
    {

        try{

            $usuarioValidado = $request->validate([

                'nombre' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'password' => 'required|string|min:4|max:255',
                "perfil_usuario" => "string|nullable"

            ]);


        $usuarioValidado['password'] = Hash::make($usuarioValidado['password']);    


        $usuarioNuevo = Usuarios::create($usuarioValidado);

        return response()->json([

            'status' => true,
            'message' => 'Usuario registrado exitosamente',
            'data' => $usuarioNuevo,
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


    public function cambiarPassword(Request $request , $id){

        try{

            $passwordValidado = $request->validate([

                'password' => 'required|min:4|max:255|string'
            ]);


            $usuario = Usuarios::find($id);


            if(!$usuario){

                return response()->json([

                    'status' => false,
                    'message' => 'El Usuario no existe o no se encuentra en la base de datos',
                    'code' => 404


                ],404);

            }

            $usuario->password = Hash::make($passwordValidado['password']);

            $usuario->save();

            return response()->json([

                'status' => true,
                'message' => 'Password actualizado correctamente',
                'data' => $usuario,
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




    public function show($id){

        try{

            $usuario = Usuarios::find($id);

            if(!$usuario){

                return response()->json([

                    'status' => false,
                    'message' => 'El usuario no existe o no se encuentra en la base de datos',
                    'code' => 404

                ],404);

            }

            return response()->json([

                'status' => true,
                'message' => 'Usuario encontrado exitosamente',
                'data' => $usuario,
                'code' => 200
            ],200);

        }catch(\Exception $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error en la solicitud',
                'warning' => $e->getMessage(),
                'code' => 400

            ],400);

        }


    }

   

    public function update(Request $request , $id){

        try{


            $usuarioValidado = $request->validate([

                'nombre' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'password' => 'required|string|min:8|max:255'

            ]);

            $usuario = Usuarios::find($id);

            if(!$usuario){

                return response()->json([

                    'status' => false,
                    'message' => 'El usuario no se encuentra en la base de datos o no existe',
                    'code' => 404,
                ],404);

            }

            $usuarioValidado['password'] = Hash::make($usuarioValidado['password']);


            $usuario->update($usuarioValidado);

            return response()->json([

                'status' => true,
                'message' => 'Usuario actualizado correctamente',
                'data' => $usuario,
                'code' => 200,

            ],200);

        }catch(\Illuminate\Validation\ValidationException $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error de validacion en los campos solicitados',
                'warning' => $e->errors(),
                'code' => 400

            ],400);

        }catch(\Exception $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error en la solicitud',
                'warning' => $e->getMessage(),
                'code' => 400

            ],400);

        }

    }



    
   
     public function destroy($id){

        try{

            $usuario = Usuarios::find($id);

            if(!$usuario){

                return response()->json([

                    'status' => false,
                    'message' => 'El usuario no existe o no se encuentra en la base de datos',
                    'code' => 400
                ],400);


            }

            $usuario->delete();

            return response()->json([

                'data' => true,
                'message' => 'Usuario eliminado exitosamente',
                'code' => 200

            ],200);

        

        }catch(\Exception $e){

            return response()->json([

                'status' => false,
                'message' => 'Ocurrio un error en la solicitud',
                'warning' => $e->getMessage(),
                'code' => 400

            ],400);

        }


     }



     //cambiar foto de perfil 



     public function cambiarFoto(Request $request , $id){


        try{

            $imagenValidada = $request->validate([

                'perfil_usuario' => 'required|string|nullable'

            ]);


            $usuario = Usuarios::find($id);


            if(!$usuario){

                return response()->json([

                    'status' => false,
                    'message' => 'El usuario con el id:  ' .$id. ' no existe o no se encuentra en la base de datos',
                    'code' => 404

                ],404);

            }


            $usuario->update($imagenValidada);


            return response()->json([

                'status' => true,
                'message' => 'El perfil del usuario ha sido cambiado correctamnete',
                'data' => $usuario,
                'code' => 200

            ],200);



        }catch(\Illuminate\Validation\ValidationException $e){

            return response()->json([

                'status' => false,
                'message' => 'Hay un error de validacion',
                'warning' => $e->errors(),
                'code' => 400

            ],400);

        }catch(\Exception $e){

            return response()->json([

                'status' => false,
                'message' => 'Hay un error interno en la solicitud',
                'warning' => $e->getMessage(),
                'code' => 500

            ],500);

        }


     }
}
