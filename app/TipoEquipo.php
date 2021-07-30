<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEquipo extends Model
{
    protected $table='tipo_equipo';

    protected $guarded=[];

    //  public function tipo_equipo(){
    //     return $this->belongsTo(Producto::class,'producto_id');
    // }


}
