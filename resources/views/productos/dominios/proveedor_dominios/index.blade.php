@extends('menu.layout')

@section('title', 'Proveedor Dominios')

@section('img_title', 'dominios.svg')
@section('value_accion1', 'Agregar')
@section('data-toggle1', 'modal')
@section('data-target1', '#AgregarProveedorDominios')

@section('content')

<!--  Modal Agregar Proveedor -->
<div class="modal inmodal" id="AgregarProveedorDominios" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated flipInY">
			<div class="modal-header">
				<h4 class="modal-title">Agregar Proveedor </h4>
			</div>
			<form action ="{{route('proveedor_dominio.store')}}" method="POST" enctype="multipart/form-data" >
				@csrf
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nombre:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="nombre" value="" required="required" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Descripción:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="descripcion" value="" required="required" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Correo:</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" name="correo" value="" required="required" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Fin Modal Agregar Proveedor -->

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
									<th>Descripcion</th>
									<th>Correo</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($provedor_dominios as $provedor_dominio)
								<tr>
									<td>{{$provedor_dominio->id}}</td>
									<td>{{$provedor_dominio->nombre}}</td>
									<td>{{$provedor_dominio->descripcion}}</td>
									<td>{{$provedor_dominio->correo}}</td>

									<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#DominioEdit{{$provedor_dominio->id}}">Editar</button></td>

									<div class="modal inmodal" id="DominioEdit{{$provedor_dominio->id}}" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content animated flipInY">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
													<h4 class="modal-title">Modal title</h4>
												</div>
												<form action ="{{route('proveedor_dominio.update',$provedor_dominio->id)}}" method="POST" enctype="multipart/form-data" >
													@csrf
													@method('PATCH')
													<div class="modal-body">
														<div class="form-group row">
															<label class="col-sm-2 col-form-label">Nombre:</label>
															<div class="col-sm-10">
																<input type="text" class="form-control" name="nombre" value="{{$provedor_dominio->nombre}}" required="required" autocomplete="off">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-2 col-form-label">Descripción:</label>
															<div class="col-sm-10">
																<input type="text" class="form-control" name="descripcion" value="{{$provedor_dominio->descripcion}}" required="required" autocomplete="off">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-2 col-form-label">Correo:</label>
															<div class="col-sm-10">
																<input type="email" class="form-control" name="correo" value="{{$provedor_dominio->correo}}" required="required" autocomplete="off">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-2 col-form-label">estado:</label>

															<div class="col-sm-10">
																@if($provedor_dominio->estado ==1)
																<input type="checkbox" name="estado" class="js-switch{{$provedor_dominio->id}}" checked=""  />
																@else
																<input type="checkbox" name="estado" class="js-switch{{$provedor_dominio->id}}" />
																@endif
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="submit" class="btn btn-primary">Guardar</button>
													</div>
												</form>
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
<!-- Switchery -->
<link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
@foreach($provedor_dominios as $provedor_dominio)
<script>
	var elem = document.querySelector('.js-switch{{$provedor_dominio->id}}');
	var switchery = new Switchery(elem, { color: 'rgb(47 162 0)' });

	// var elem_2 = document.querySelector('.js-switch_2');
	// var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });

	// var elem_3 = document.querySelector('.js-switch_3');
	// var switchery_3 = new Switchery(elem_3, { color: '#1AB394' });

	// var elem_4 = document.querySelector('.js-switch_4');
	// var switchery_4 = new Switchery(elem_4, { color: '#f8ac59' });
	// switchery_4.disable();
</script>
@endforeach

@endsection