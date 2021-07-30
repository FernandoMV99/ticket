<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
	protected $table='licencias';

	protected $guarded=[];

	public function categoria(){
		return $this->belongsTo(Categoria::class,'categoria_licencia');
	}
	public function clientes(){
		return $this->belongsTo(User::class,'cliente');
	}
	public function equipos(){
		return $this->belongsTo(Equipos::class,'equipo');
	}



}

