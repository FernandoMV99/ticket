<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanSoporteTecnico extends Model
{
    protected $table='plan_soporte_tecnico';

    protected $guarded=[];

    //  public function plansoporte(){
    //     return $this->belongsTo(PlanSoporteTecnico::class,'plan_soporte');
    // }
    // public function marca(){
    //     return $this->belongsTo(Marv::class,'tipo_equipo');
    // }


}
