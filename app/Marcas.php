<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marcas extends Model
{
    protected $table='marcas';

    protected $guarded=[];

    //  public function tipoequipo(){
    //     return $this->belongsTo(TipoEquipo::class,'tipo_equipo');
    // }
    // public function marca(){
    //     return $this->belongsTo(Marv::class,'tipo_equipo');
    // }


}
