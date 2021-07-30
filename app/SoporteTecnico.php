<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoporteTecnico extends Model
{
    protected $table='soporte_tecnico';

    protected $guarded=[];

     public function clientes(){
        return $this->belongsTo(User::class,'cliente');
    }
     public function plansoporte(){
        return $this->belongsTo(PlanSoporteTecnico::class,'plan_soporte');
    }


}

