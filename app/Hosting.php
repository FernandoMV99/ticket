<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hosting extends Model
{
	protected $table='hosting';

	protected $guarded=[];

	public function monedas(){
		return $this->belongsTo(Moneda::class,'moneda');
	}
	public function clientes(){
		return $this->belongsTo(User::class,'cliente');
	}
	public function plan_hostings(){
		return $this->belongsTo(PlanHosting::class,'plan_hosting');
	}


}

