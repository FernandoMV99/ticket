@extends('menu.layout')

@section('img_title', 'equipos.svg')
@section('title', 'Tipos Equipos')

@section('value_accion1', 'Agregar')
@section('data-toggle1', 'modal')
@section('data-target1', '#AgregarTipoProducto')

@section('content')
{{-- Modal Agregar --}}
<div class="modal inmodal fade" id="AgregarTipoProducto" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Agregar Tipos</h4>
			</div>
			<div class="modal-body">
				<form action="{{ route('tipo_equipo.store') }}" id="form" enctype="multipart/form-data" method="post" class="wizard-big">
					@csrf
					<div class="row">
						<div class="col-sm-12">
							<label for="">Nombre:</label>
							<input type="text" value="" class="form-control" name="nombre">
						</div>
						<div class="col-sm-12" align="center" style="margin-top: 10px">
							<input type="file" id="archivoInput" width="200px" name="foto" onchange="return validarExt()" /></center></center>
							<div id="visorArchivo">
								<!--Aqui se desplegará el fichero-->
								<center ><img style="border-radius: 10px" src="{{asset('multimedia/equipos.svg')}}/" width="200px" />
								</center>
							</div>
						</div>
						<div class="col-sm-12" align="right">
							<button type="submit" class="btn btn-primary">Actualizar</button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>
{{-- FIN Modal Agregar --}}
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12" >
			<div class="ibox ">
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th>Item</th>
									<th>Nombre</th>
									<th>imagen</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<span hidden="">
									{{$i=1}}
								</span>
								@foreach($tipo_equipo as $tipo_equipos)
								<tr>
									<td> {{$i++}}
										@if($tipo_equipos->estado==1)<button class="btn btn-warning btn-xs">Desactivo</button>@endif
									</td>
									<td>{{$tipo_equipos->nombre}}</td>
									<td><img alt="image" class=" m-t-xs img-fluid" width="20px" src="{{asset('multimedia/tipo_equipo')}}/{{$tipo_equipos->imagen}}"></td>
									<td><button type="button"  class="btn btn-info " data-toggle="modal" data-target="#myModal{{$tipo_equipos->id}}">VER</button></td>
									<div class="modal inmodal fade" id="myModal{{$tipo_equipos->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Modal title</h4>
												</div>
												<div class="modal-body">
													<form action="{{ route('tipo_equipo.update',$tipo_equipos->id) }}"  enctype="multipart/form-data" method="post">
														@csrf
														@method('PATCH')
														<div class="row">
															<div class="col-sm-6">
																<label for="">Nombre:</label>
																<input type="text" value="{{$tipo_equipos->nombre}}"  name="nombre" class="form-control">
															</div>
															<div class="col-sm-6">
																<label for="">Estado:</label><br>
																<input type="checkbox" class="js-switch_{{$tipo_equipos->id}}" name="estado"  @if($tipo_equipos->estado==0)checked=""@endif />
															</div>

															<div class="col-sm-12" align="center" style="margin-top: 10px">
																<input type="file" id="archivoInput{{$tipo_equipos->id}}" width="200px" name="foto" onchange="return validarExt{{$tipo_equipos->id}}()"  /></center>
																<input type="hidden" name="foto_original" value="{{$tipo_equipos->imagen}}"  /></center>
																<div id="visorArchivo{{$tipo_equipos->id}}">
																	<!--Aqui se desplegará el fichero-->
																	<center ><img style="border-radius: 10px"  name="foto"  src="{{asset('multimedia/tipo_equipo/')}}/{{ $tipo_equipos->imagen }}" width="200px" />
																	</center>
																</div>
															</div>
															<div class="col-sm-12" align="right">
																<button type="submit" class="btn btn-primary">Actualizar</button>
															</div>
														</div>
													</form>

												</div>
											</div>
										</div>
									</div>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
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
<link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
<!-- Switchery -->
<script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>
@foreach($tipo_equipo as $tipo_equipos)
<script>
	var elem_2 = document.querySelector('.js-switch_{{$tipo_equipos->id}}');
	var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
<!-- foto previzualizar-->
<style>

input#archivoInput{{$tipo_equipos->id}}{
	position:absolute;
	top:0px;
	left:0px;
	right:0px;
	bottom:0px;
	width:100%;
	height:100%;
	opacity: 0	;
}
input#archivoInput{
	position:absolute;
	top:0px;
	left:0px;
	right:0px;
	bottom:0px;
	width:100%;
	height:100%;
	opacity: 0	;
}
</style>
<script type="text/javascript">
	function validarExt{{$tipo_equipos->id}}()
	{
		var archivoInput = document.getElementById('archivoInput{{$tipo_equipos->id}}');
		if (archivoInput.files && archivoInput.files[0])
		{
			var visor = new FileReader();
			visor.onload = function(e)
			{
				document.getElementById('visorArchivo{{$tipo_equipos->id}}').innerHTML =
				'<center><img name="foto" src="'+e.target.result+' "width="200px" style="border-radius: 10px;" /></center>';
			};
			visor.readAsDataURL(archivoInput.files[0]);
		}
	}
</script>
@endforeach
<script type="text/javascript">
	function validarExt()
	{
		var archivoInput = document.getElementById('archivoInput');
		if (archivoInput.files && archivoInput.files[0])
		{
			var visor = new FileReader();
			visor.onload = function(e)
			{
				document.getElementById('visorArchivo').innerHTML =
				'<center><img name="foto" src="'+e.target.result+' "width="200px" style="border-radius: 10px;" /></center>';
			};
			visor.readAsDataURL(archivoInput.files[0]);
		}
	}
</script>

<!-- FIN foto previzualizar-->
@endsection