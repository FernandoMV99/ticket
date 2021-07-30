<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table='empresa';

    protected $guarded=[];

    //  public function producto(){
    //     return $this->belongsTo(Producto::class,'producto_id');
    // }


}
