@extends('menu.layout')

@section('img_title', 'equipos.svg')
@section('title', 'Marcas')

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
				<form action="{{ route('marcas.store') }}" id="form" enctype="multipart/form-data" method="post" class="wizard-big">
					@csrf
					<div class="row">
						<div class="col-sm-12">
							<label for="">Nombre:</label>
							<input type="text" value="" class="form-control" name="nombre" required="required">
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
									<th></th>
								</tr>
							</thead>
							<tbody>
								<span hidden="">
									{{$i=1}}
								</span>
								@foreach($marcas as $marca)
								<tr>
									<td> {{$i++}}
										@if($marca->estado==1)<button class="btn btn-warning btn-xs">Desactivo</button>@endif
									</td>
									<td>{{$marca->nombre}}</td>
									<td><button type="button"  class="btn btn-info " data-toggle="modal" data-target="#myModal{{$marca->id}}">VER</button></td>
									<div class="modal inmodal fade" id="myModal{{$marca->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Editar Marca</h4>
												</div>
												<div class="modal-body">
													<form action="{{ route('marcas.update',$marca->id) }}"  enctype="multipart/form-data" method="post">
														@csrf
														@method('PATCH')
														<div class="row">
															<div class="col-sm-6">
																<label for="">Nombre:</label>
																<input type="text" value="{{$marca->nombre}}"  name="nombre" class="form-control">
															</div>
															<div class="col-sm-6">
																<label for="">Estado:</label><br>
																<input type="checkbox" class="js-switch_{{$marca->id}}" name="estado"  @if($marca->estado==0)checked=""@endif />
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

@foreach($marcas as $marca)
<script>
	var elem_2 = document.querySelector('.js-switch_{{$marca->id}}');
	var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach


@endsection