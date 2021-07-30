<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motivo extends Model
{
    protected $table='motivo';

    protected $guarded=[];

    //  public function producto(){
    //     return $this->belongsTo(Producto::class,'producto_id');
    // }

    public function estado(){
        return $this->belongsTo(Estado::class,'estado_id');
    }
}
