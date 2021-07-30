@extends('menu.layout_cliente')
@section('img_title', 'equipos.svg')
@section('title', 'Mis Equipos')

@section('atributo1', 'hidden')

<?php
use App\SoftwareEquipo;
?>
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<span hidden=""> {{$count=count($cliente_logeado)}}</span>
	@if($count==0)
	<div class="row" >
		<div class="col-lg-12" align="center" >
			<span style="font-size: 60px;color:#d0d0d0c9;">No hay Equipos</span>
		</div>
		@else
		<div class="row">
			@endif
			@foreach($cliente_logeado as $equipos)
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
							<strong>N/S:</strong> {{$equipos->numero_serie}} <br>
							<strong>Usuario:</strong> {{$equipos->usuario}}<br>
							<textarea class="form-control" rows="4" style="height: auto;font-size:12px;border: 1px solid #e5e6e700;">{{$equipos->descripcion_hardware}}</textarea>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>

	{{-- Modal Programas --}}
	<style>
	.disabled{background-color: #e9ecef;opacity: 1;}
</style>
@foreach($cliente_logeado as $equipos)
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
					</ul>
					<div class="tab-content">
						<div role="tabpanel" id="equipo{{$equipos->id}}"   class="tab-pane active"  >
							<div class="panel-body">
								<form action="">
									<div class="row" >
										<div class="col-4">
											<label for="">Tipo de Equipo:</label>
											<div class="form-control disabled">{{$equipos->tipoequipo->nombre}}</div>
										</div>
										<div class="col-4">
											<label for="">Marca:</label>
											<div class="form-control disabled">{{$equipos->marcas->nombre}}</div>
										</div>
										<div class="col-4">
											<label for="">Numero Serie:</label>
											<div class="form-control disabled">{{$equipos->numero_serie}}</div>
										</div>
										<div class="col-4">
											<label for="">Usuario del Equipo:</label>
											<div class="form-control disabled">{{$equipos->usuario}}</div>
										</div>
										<div class="col-8">
											<label for="">Detalles de Hardware:</label>
											<textarea class="form-control" disabled="" rows="5" style="height: auto;font-size:12px;">{{$equipos->descripcion_hardware}}</textarea>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div role="tabpanel" id="pro_instalado{{$equipos->id}}"  class="tab-pane"  >
							<div class="panel-body">
								<div class="row">
									@foreach($soft as $softs)
									<div class="col-lg-4">
										<div class="contact-box">
											<div class="row" >
												<div class="col-12">
													<label for="">Nombre del Programa:</label>
													<div class="form-control disabled">{{$softs->nombre_programa}}</div>
												</div>
												<div class="col-12">
													<label for="">Licencia:</label>
													<div class="form-control disabled">{{$softs->cod_licencia}}</div>
												</div>
											</div>
										</div>
									</div>
									@endforeach
								</div>
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
@endsection