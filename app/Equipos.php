<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
    protected $table='equipos';

    protected $guarded=[];

     public function tipoequipo(){
        return $this->belongsTo(TipoEquipo::class,'tipo_equipo');
    }
    public function marcas(){
        return $this->belongsTo(Marcas::class,'marca');
    }


}
