<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadUser extends Model
{
    protected $table='actividad_user';

    protected $guarded=[];

    //  public function producto(){
    //     return $this->belongsTo(Producto::class,'producto_id');
    // }

    // public function servicio(){
    //     return $this->belongsTo(Servicios::class,'servicio_id');
    // }
}
