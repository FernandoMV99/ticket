<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificadoSsl extends Model
{
	protected $table='certificado_ssl';

	protected $guarded=[];

	public function monedas(){
		return $this->belongsTo(Moneda::class,'moneda');
	}
	public function proveedores(){
		return $this->belongsTo(ProveedorDominios::class,'proveedor');
	}
	public function clientes(){
		return $this->belongsTo(User::class,'cliente');
	}
	public function planes_ssl(){
		return $this->belongsTo(PlanCertificadoSsl::class,'plan_certificado_ssl');
	}


}

