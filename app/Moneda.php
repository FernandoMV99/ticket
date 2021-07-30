<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    protected $table='moneda';

    protected $guarded=[];

    //  public function producto(){
    //     return $this->belongsTo(Producto::class,'producto_id');
    // }


}

