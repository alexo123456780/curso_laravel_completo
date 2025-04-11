<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DetalleVenta extends Model
{

    use HasFactory, Notifiable;

    protected $fillable = ['venta_id','producto_id','cantidad','precio_unitario'];

    public function producto(){

        return $this->belongsTo(Productos::class,'producto_id');


    }

    public function venta(){

        return $this->belongsTo(Venta::class,'venta_id');

    }
    
}
