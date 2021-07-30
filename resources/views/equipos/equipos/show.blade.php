@extends('menu.layout')

@section('img_title', 'equipos.svg')
@section('title', 'Equipos')

@if($count_equipos==0)
@section('atributo1', 'hidden')
@else
@section('value_accion1', 'Agregar')
@section('data-toggle1', 'modal')
@section('data-target1', '#agregar')
@endif


<?php
use App\SoftwareEquipo;
?>
@section('content')
<style>
.plus{
	background: url('{{asset('multimedia/equipos.svg')}}') no-repeat center; background-size: contain;
	background-color: rgba(255, 255, 255, 0.486);
	background-blend-mode: overlay;
	transition: 0.3s;
}
.plus:hover{
	background-blend-mode: darken;
}
</style>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		@if($count_equipos==0)
		<div class="col-lg-4" data-toggle="modal" data-target="#agregar">
			<div class="contact-box">
				<div class="row" >
					<div class="col-12" align="center" >
						<div class="text-center plus">
							<i class="fa fa-plus big-icon"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif

		@foreach($equipo_cliente as $equipos)
		<div class="col-lg-4" data-toggle="modal" data-target="#Software{{$equipos->id}}">
			<div class="contact-box">
				<div class="row" >
					<div class="col-4">
						<div class="text-center">
							<img alt="image" class=" m-t-xs img-fluid" src="{{asset('multimedia/tipo_equipo')}}/{{$equipos->tipoequipo->imagen}}">
							<div class="m-t-xs font-bold">{{$equipos->tipoequipo->nombre}}</div>
						</div>
					</div>
					<div class="col-8">
						<h3><strong>{{$equipos->marcas->nombre}} / {{$equipos->codigo_equipo}}</strong></h3>
						<strong >N/S: </strong>{{$equipos->numero_serie}} <br>
						<strong >Usuario:</strong> {{$equipos->usuario}} <br>
						<textarea class="form-control" rows="4" style="height: auto;font-size:12px;border: 1px solid #e5e6e700;">{{$equipos->descripcion_hardware}} </textarea>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
{{-- Modal Agregar Equipo --}}
<div class="modal inmodal fade" id="agregar" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="ibox-title" align="center" style="padding:10px 0;border-bottom: 2px solid #00000026;">
				<h4 class="modal-title">Agregar Equipo</h4>
			</div>
			<div class="modal-body">
				<form action="{{ route('equipos.store') }}" id="form" enctype="multipart/form-data" method="post" class="wizard-big">
					@csrf
					<div class="row" >
						<div class="col-4">
							<input type="hidden" value="{{$id}}" hidden="hidden" name="id_cliente">
							<label for="">Tipo de Equipo:</label>
							<select class="form-control" name="tipo_equipo" required="required">
								@foreach($tipo_equipo as $tipo_equipos)
								<option value="{{$tipo_equipos->id}}" >{{$tipo_equipos->nombre}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-4">
							<label for="">Marca:</label>
							<select class="form-control" name="marca"  required="required">
								@foreach($marcas as $marca)
								<option value="{{$marca->id}}" >{{$marca->nombre}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-4">
							<label for="">Numero Serie:</label>
							<input type="text" class="form-control" name="numero_serie">
						</div>
						<div class="col-4">
							<label for="">Usuario del Equipo:</label>
							<input type="text" class="form-control"  required="required" name="usuario" value="{{$user->name}} {{$user->last_name}}">
						</div>
						<div class="col-8">
							<label for="">Detalles de Hardware:</label>
							<textarea class="form-control" name="descripcion_hardware" rows="5" style="height: auto;font-size:12px;"></textarea>
						</div>
						<div class="col-12" align="right" style="margin-top: 10px">
							<button type="submit" class="btn btn-success">Registrar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
{{-- Modal Agregar Equipo --}}

{{-- Modal Programas --}}
@foreach($equipo_cliente as $equipos)
<span hidden="hidden">
	{{$soft=SoftwareEquipo::where('equipos',$equipos->id)->get()}}
	{{$count_soft=count($soft)}}
</span>
<div class="modal inmodal fade" id="Software{{$equipos->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="ibox-title" align="center" style="padding:10px 0;border-bottom: 2px solid #00000026;">
				<h4 class="modal-title">Detalles Software</h4>
			</div>
			<div class="modal-body">
				<div class="tabs-container">
					<ul class="nav nav-tabs" role="tablist">
						<li><a  class="nav-link active"  data-toggle="tab" href="#equipo{{$equipos->id}}">Equipo</a></li>
						@if($count_soft>0)<li><a class="nav-link" data-toggle="tab" href="#pro_instalado{{$equipos->id}}">Programas Instalados</a></li>@endif
						<li><a  class="nav-link"   data-toggle="tab" href="#agregar_pro{{$equipos->id}}">Agregar Programas</a></li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" id="equipo{{$equipos->id}}"   class="tab-pane active"  >
							<div class="panel-body">
								<form action="{{ route('equipos.update',$equipos->id) }}"  enctype="multipart/form-data" method="post">
									@csrf
									@method('PATCH')
									<div class="row" >
										<div class="col-4">
											<label for="">Tipo de Equipo:</label>
											<select class="form-control" required="" name="tipo_equipo">
												@foreach($tipo_equipo as $tipo_equipos)
												<option value="{{$tipo_equipos->id}}" @if($tipo_equipos->id==$equipos->tipoequipo->id) selected="" @endif >{{$tipo_equipos->nombre}}</option>
												@endforeach
											</select>
										</div>
										<div class="col-4">
											<label for="">Marca:</label>
											<select class="form-control"  required="" name="marca">
												@foreach($marcas as $marca)
												<option value="{{$marca->id}}" @if($marca->id==$equipos->marcas->id) selected="" @endif >{{$marca->nombre}}</option>
												@endforeach
											</select>
										</div><style>.col-4{margin-top: 5px;  }</style>
										<div class="col-4">
											<label for="">Numero Serie:</label>
											<input type="text" class="form-control"   name="numero_serie" value="{{$equipos->numero_serie}}">
										</div>
										<div class="col-4">
											<label for="">Usuario del Equipo:</label>
											<input type="text" class="form-control"   name="usuario" value="{{$equipos->usuario}}">
										</div>
										<div class="col-8">
											<label for="">Detalles de Hardware:</label>
											<textarea class="form-control" rows="5"   name="descripcion_hardware" style="height: auto;font-size:12px;">{{$equipos->descripcion_hardware}}</textarea>
										</div>
										<div class="col-12" style="margin-top:10px" align="right">
											<button type="submit" class="btn btn-success">Actualizar</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div role="tabpanel" id="pro_instalado{{$equipos->id}}"  class="tab-pane"  >
							<div class="panel-body">
								<span hidden="hidden">
									{{$soft=SoftwareEquipo::where('equipos',$equipos->id)->get()}}
								</span>
								<form action="{{ route('software_equipos.update',$equipos->id) }}"  enctype="multipart/form-data" method="post">
									@csrf
									@method('PATCH')
									<div class="row">
										@foreach($soft as $softs)
										<div class="col-lg-4">
											<div class="contact-box">
												<div class="row" >
													<div class="col-12">
														<label for="">Nombre del Programa:</label>
														<input type="hidden" hidden="" class="form-control" name="id_software[]" value="{{$softs->id}}">
														<input type="text" class="form-control" name="nombre_programa[]" value="{{$softs->nombre_programa}}">
													</div>
													<div class="col-12">
														<label for="">Licencia:</label>
														<input type="text" class="form-control" name="cod_licencia[]" value="{{$softs->cod_licencia}}">
													</div>
													<div class="col-12" align="center">
														<label>Adquirido por Nosotros:</label>
														<input type="checkbox"  class="form-control"  onclick="check{{$softs->id}}()"   @if($softs->comprado_aqui==1) checked="" @endif >
														<input type="hidden" hidden="" name="comprado_aqui[]" id="myCheck{{$softs->id}}" @if($softs->comprado_aqui==1) value="1" @elseif($softs->comprado_aqui==0) value="0" @endif >
													</div>

												</div>
											</div>
										</div>


										<script>
											function check{{$softs->id}}() {
												if(document.getElementById("myCheck{{$softs->id}}").value=='0'){
													document.getElementById("myCheck{{$softs->id}}").value='1';
												}else{
													document.getElementById("myCheck{{$softs->id}}").value='0';
												}

											}

										</script>
										@endforeach
										<div class="col-12" align="right">
											<button type="submit"class="ladda-button btn btn-success" data-style="slide-up">Actualizar</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div role="tabpanel" id="agregar_pro{{$equipos->id}}" class="tab-pane">
							<div class="panel-body">
								<div class="row">

									<div class="col-lg-12">
										<button style="display: inline;background: none;padding-top: 0px;height: 38px;" class="btn" type="button" id="add_field{{$equipos->id}}" >
											<img src="{{asset('multimedia/agregar.png')}}" width="20px">
										</button>
									</div>
								</div>
								<form action="{{ route('software_equipos.store') }}" id="form" enctype="multipart/form-data" method="post" class="wizard-big">
									@csrf
									<input type="hidden" value="{{$equipos->id}}" hidden="" name="id_equipo">
									<div class="row" id="listas{{$equipos->id}}">
										<div class="col-lg-4">
											<div class="contact-box" style="margin-bottom: 0px">
												<div class="row" >
													<div class="col-12">
														<label for="">Nombre del Programa:</label>
														<input required="required" type="text" class="form-control" name="nombre_programa[]" required="required">
													</div>
													<div class="col-12">
														<label for="">Licencia:</label>
														<input type="text" class="form-control" name="cod_licencia[]">
													</div>
													<div class="col-12" align="center">
														<label>Adquirido por Nosotros:</label>
														<select name="comprado_aqui[]" class="form-control">
															<option value="0">No</option>
															<option value="1">Si</option>
														</select>

													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="" align="right">
										<button type="submit"class="ladda-button btn btn-success" data-style="slide-up">Registrar</button>
									</div>
								</form>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endforeach

{{-- Modal Programas --}}

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Page-Level Scripts -->
<script>
	$(document).ready(function(){
		$('.dataTables-example').DataTable({
			pageLength: 10,
			responsive: true,
			dom: '<"htmlbuttons"B>lTfgitp',
			buttons: []});
	});
</script>


@foreach($equipo_cliente as $equipos)
<script>
var campos_max{{$equipos->id}} = 5; //max de 10 campos
var x{{$equipos->id}}x = 0;
var borar_ifv= 0;
$(document).ready(function(){
	$("#add_field{{$equipos->id}}").click(function(e){
  e.preventDefault(); //prevenir novos clicks
  if (x{{$equipos->id}}x < campos_max{{$equipos->id}}){
  	$("#listas{{$equipos->id}}").append(
  		'<div class="col-lg-4">'+
  		'<div class="contact-box"  style="margin-bottom: 0px">'+
  		'<div class="row" >'+
  		'<div class="col-12">'+
  		'<label for="">Nombre del Programa:</label>'+
  		'<input type="text" class="form-control" name="nombre_programa[]">'+
  		'</div>'+
  		'<div class="col-12">'+
  		'<label for="">Licencia:</label>'+
  		'<input type="text" class="form-control" name="cod_licencia[]">'+
  		'</div>'+
  		'<div class="col-12">'+
  		'<label for="">Adquirido por Nosotros:</label>'+
  		'<select name="comprado_aqui[]" class="form-control">'+
  		'<option value="0">No</option>'+
  		'<option value="1">Si</option>'+
  		'</select>'+
  		'</div>'+
  		'</div>'+
  		'</div>'+
  		'<button style="display: inline;background: none;" class="remover_campo{{$equipos->id}} btn" type="button" >'+
  		'<img src="{{asset('multimedia/borrar.png')}}" width="25px">'+
  		'</button>'+
  		'</div>');
  	x{{$equipos->id}}x++;
  }
});

  // Remover o div anterior
  $("#listas{{$equipos->id}}").on("click", ".remover_campo{{$equipos->id}}", function (e) {
  	e.preventDefault();
  	$(this).parent('div').remove();
  	x{{$equipos->id}}x--;
  });
});

</script>
@endforeach
@endsection