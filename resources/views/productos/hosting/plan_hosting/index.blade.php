@extends('menu.layout')

@section('img_title', 'plan.svg')

@section('title', 'Planes Hosting')
@section('value_accion1', 'Agregar')
@section('data-toggle1', 'modal')
@section('data-target1', '#AgregarProveedorDominios')

@section('content')

<!--  Modal Agregar Proveedor -->
<div class="modal inmodal" id="AgregarProveedorDominios" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated flipInY">
			<div class="modal-header">
				<h4 class="modal-title">Plan Hosting</h4>
			</div>
			<form action ="{{route('planes_hosting.store')}}" method="POST" enctype="multipart/form-data" >
				@csrf
				<div class="modal-body">
					<div class="tile">
						<div class="tile-body">
							<div class="form-group">
								<label for="title">Título para el Plan:</label>
								<input class="form-control" type="text" name="nombre" required="" autocomplete="off">
							</div>
							<div class="form-group">
								<label for="description">
									Agregar una descripción (cantidad de correos, base de datos, etc):
								</label>
								<textarea class="form-control" name="descripcion" rows="3"></textarea>
							</div>
							<div class="form-group">
								<label for="total_price">Precio:</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<select name="moneda" id="" class="input-group-text">
											@foreach($moneda as $monedas)
											<option value="{{$monedas->simbolo}}">{{$monedas->simbolo}}</option>
											@endforeach
										</select>
									</div>
									<input type="number" class="form-control" name="precio"required="" autocomplete="off">
									<button class="btn btn-primary btn-lg" type="submit">
										<i class="fa fa-fw fa-lg fa-check-circle"></i>Registrar
									</button>
								</div>
							</div>
						</div>
					</div>
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
									<th>precio</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($plan_hosting as $plan_hostings)
								<tr>
									<td>{{$plan_hostings->id}}@if($plan_hostings->estado ==1) <span class="label label-info">Activo</span> @else <span class="label label-default">Desactivo</span> @endif</td>
									<td>{{$plan_hostings->nombre}}</td>
									<td>{{$plan_hostings->descripcion}}</td>
									<td>{{$plan_hostings->moneda}}{{$plan_hostings->precio}}</td>

									<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#PlanHostingEdit{{$plan_hostings->id}}">Editar</button></td>

									<div class="modal inmodal" id="PlanHostingEdit{{$plan_hostings->id}}" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content animated flipInY">
												<div class="modal-header">
													<h4 class="modal-title">Editar Plan Hosting</h4>
												</div>
												<form action ="{{route('planes_hosting.update',$plan_hostings->id)}}" method="POST" enctype="multipart/form-data" >
													@csrf
													@method('PATCH')
													<div class="modal-body">
														<div class="tile">
															<div class="tile-body">
																<div class="form-group">
																	<label for="title">Título para el Plan:</label>
																	<input class="form-control" type="text" name="nombre" required="" value="{{$plan_hostings->nombre}}" autocomplete="off">
																</div>
																<div class="form-group">
																	<label for="description">
																		Agregar una descripción (cantidad de correos, base de datos, etc):
																	</label>
																	<textarea class="form-control" name="descripcion" rows="3">{{$plan_hostings->descripcion}}</textarea>
																</div>
																<div class="form-group">
																	<label for="total_price">Precio:</label>
																	<div class="input-group">
																		<div class="input-group-prepend">
																			<select name="moneda" id="" class="input-group-text">
																				<option value="{{$plan_hostings->moneda}}">{{$plan_hostings->moneda}}</option>
																				@foreach($moneda as $monedas)
																				<option value="{{$monedas->simbolo}}">{{$monedas->simbolo}}</option>
																				@endforeach
																			</select>
																		</div>
																		<input type="number" class="form-control" name="precio" value="{{$plan_hostings->precio}}" required="" autocomplete="off">
																		<label class="col-sm-2 col-form-label">estado:</label>
																		@if($plan_hostings->estado ==1)
																		<input type="checkbox" name="estado" class="js-switch{{$plan_hostings->id}}" checked=""  />
																		@else
																		<input type="checkbox" name="estado" class="js-switch{{$plan_hostings->id}}" />
																		@endif
																	</div>
																	<div class="form-group row">

																		<div class="col-sm-10">

																		</div>
																	</div>
																</div>
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
	@foreach($plan_hosting as $plan_hostings)
	<script>
		var elem = document.querySelector('.js-switch{{$plan_hostings->id}}');
		var switchery = new Switchery(elem, { color: 'rgb(47 162 0)' });
	</script>
	@endforeach

@endsection