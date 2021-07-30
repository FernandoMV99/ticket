<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dominios extends Model
{
	protected $table='dominios';

	protected $guarded=[];

	public function proveedores(){
		return $this->belongsTo(ProveedorDominios::class,'proveedor');
	}
	public function clientes(){
		return $this->belongsTo(User::class,'cliente');
	}


}

