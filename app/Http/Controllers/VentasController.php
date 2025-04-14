<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Productos;

class VentasController extends Controller
{

    public function venta(Request $request){

        try{

            $pedido = $request->validate([

                'vendedor_id' => 'required|numeric|exists:usuarios,id',
                'cliente_id' => 'required|numeric|exists:clientes,id',
                'precio_final' => 'required|array',
                'precio_final.*.producto_id' => 'required|numeric|exists:productos,id',
                'precio_final.*.cantidad' => 'required|numeric',
                'precio_final.*.precio_unitario' => 'required|numeric'

            ]);


            //creo una variable donde se va almacenar el array de la el requues pedido
            $PrecioFinal = $pedido['precio_final'];


            $total = 0;

            foreach($PrecioFinal as $precio){

                $producto = Productos::find($precio['producto_id']);


                if($pedido['vendedor_id'] != $producto['usuario_id']){

                    return response()->json([

                        'status' => false,
                        'message' => 'No puedes comprar un producto que no le pertenece al vendedor real, el vendedor real tiene el id: '  .$producto['usuario_id'],
                        'code' => 400,

                    ],400);
                }



                if($precio['cantidad'] > $producto['cantidad_productos']){

                    return response()->json([

                        'status' => false,
                        'message' => 'No hay suficientes productos en stock',
                        'code' => 400
    
                    ]);


                }

                if($precio['cantidad'] <= 0){

                    return response()->json([

                        'status' => false,
                        'message' => 'La cantidad de productos debe de ser un numero mayor a 0',
                        'code' => 400

                    ]);

                }


                if($precio['precio_unitario'] != $producto['precio_producto']){

                    return response()->json([

                        'status' => false,
                        'message' => 'Pague la cantidad exacta del producto',
                        'code' => 400
                    ],400);

                }


                $calcularPrecio = $precio['cantidad'] * $precio['precio_unitario'];

                $total += $calcularPrecio;


                $restaProductos = $producto['cantidad_productos'] - $precio['cantidad'];

                $producto->update([

                    'cantidad_productos' => $restaProductos
    
                ]);


            }

            $pedido['precio_final'] = $total;

            $ventaCreada = Venta::create($pedido);

            foreach($PrecioFinal as $ventitas){

                DetalleVenta::create([

                    'venta_id' => $ventaCreada->id,
                    'producto_id' => $ventitas['producto_id'],
                    'cantidad' => $ventitas['cantidad'],
                    'precio_unitario' => $ventitas['precio_unitario']

                ]);
            }

          return response()->json([

            'status' => true,
            'message' => 'Venta creada exitosamente',
            'data' => $ventaCreada,
            'code' => 201

          ],201);
           


        }catch(\Illuminate\Validation\ValidationException $e){

            return response()->json([

                'status' => false,
                'message' => 'Error de validaciones en algunos de los campos solicitados',
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
