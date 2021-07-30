<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanDominio extends Model
{
	protected $table='plan_dominio';

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

