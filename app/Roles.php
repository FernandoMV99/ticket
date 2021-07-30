<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table='roles';

    protected $guarded=[];

    //  public function producto(){
    //     return $this->belongsTo(Producto::class,'producto_id');
    // }


}
