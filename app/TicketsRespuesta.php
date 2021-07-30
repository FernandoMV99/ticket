<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketsRespuesta extends Model
{
    protected $table='tickets_respuesta';

    protected $guarded=[];

    //  public function motivo(){
    //     return $this->belongsTo(Motivo::class,'motivo_id');
    // }
     public function clientes(){
        return $this->belongsTo(User::class,'cliente');
    }
       public function trabajadors(){
        return $this->belongsTo(User::class,'trabajador');
    }
      public function ticket_agregado(){
        return $this->belongsTo(TicketsAgregado::class,'ticket_agregado_id');
    }

    // public function servicio(){
    //     return $this->belongsTo(Servicios::class,'servicio_id');
    // }
}
