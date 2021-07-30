<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanCertificadoSsl extends Model
{
	protected $table='plan_certificado_ssl';

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

