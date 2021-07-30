<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table='estado';

    protected $guarded=[];

    //  public function producto(){
    //     return $this->belongsTo(Producto::class,'producto_id');
    // }

    // public function servicio(){
    //     return $this->belongsTo(Servicios::class,'servicio_id');
    // }
}
