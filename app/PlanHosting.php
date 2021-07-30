<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanHosting extends Model
{
	protected $table='plan_hosting';

	protected $guarded=[];

	// public function monedas(){
	// 	return $this->belongsTo(Moneda::class,'moneda');
	// }
	// public function proveedores(){
	// 	return $this->belongsTo(ProveedorDominios::class,'proveedor');
	// }
	// public function clientes(){
	// 	return $this->belongsTo(User::class,'cliente');
	// }


}

