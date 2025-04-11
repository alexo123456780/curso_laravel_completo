<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Venta extends Model
{

    use HasFactory, Notifiable;


    protected $fillable = ['vendedor_id','cliente_id','precio_final'];


    public function cliente(){

        return $this->belongsTo(Clientes::class,'cliente_id');

    }

    public function vendedor(){

        return $this->belongsTo(Usuarios::class,'vendedor_id');

    }


    public function detalles(){

        return $this->hasMany(DetalleVenta::class);
        
    }







    
}
