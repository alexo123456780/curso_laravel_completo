<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{


    use HasFactory;


    protected $fillable = ['cliente_id', 'producto_id','cantidad_productos'];


    public function productos(){

        return $this->belongsTo(Productos::class ,'producto_id');

    }






    
}
