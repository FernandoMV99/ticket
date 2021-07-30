<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketsAgregado extends Model
{
    protected $table='tickets_agregado';

    protected $guarded=[];

     public function motivo(){
        return $this->belongsTo(Motivo::class,'motivo_id');
    }
     public function clientes(){
        return $this->belongsTo(User::class,'cliente');
    }
      public function trabajadors(){
        return $this->belongsTo(User::class,'trabajador');
    }
     public function equipos(){
        return $this->belongsTo(Equipos::class,'equipo');
    }

    // public function servicio(){
    //     return $this->belongsTo(Servicios::class,'servicio_id');
    // }
}
