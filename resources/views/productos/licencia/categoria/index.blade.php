@extends('menu.layout')

@section('img_title', 'categorias.svg')
@section('title', 'Categoria Licencias')
@section('value_accion1', 'Agregar')
@section('data-toggle1', 'modal')
@section('data-target1', '#AgregarProveedorDominios')

@section('content')

<!--  Modal Agregar Proveedor -->
<div class="modal inmodal" id="AgregarProveedorDominios" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated flipInY">
			<div class="modal-header">
				<h4 class="modal-title">Plan Categoria</h4>
			</div>
			<form action ="{{route('categoria.store')}}" method="POST" enctype="multipart/form-data" >
				@csrf
				<div class="modal-body">
					<div class="tile">
						<div class="tile-body">
							<div class="form-group">
								<label for="title">Nombre de la Categoria:</label>
								<input class="form-control" type="text" name="nombre" required="" autocomplete="off">
							</div>
							<div class="form-group">
								<label for="title">Descripcion:</label>
								<textarea class="form-control" type="text" name="descripcion" required="" autocomplete="off"></textarea>
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
								@foreach($categoria as $categorias)
								<tr>
									<td>{{$categorias->id}}@if($categorias->estado ==0) <span class="label label-info">Activo</span> @else <span class="label label-default">Desactivo</span> @endif</td>
									<td>{{$categorias->nombre}}</td>
									<td>{{$categorias->descripcion}}</td>
									<td>{{$categorias->moneda}}{{$categorias->precio}}</td>

									<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#PlanHostingEdit{{$categorias->id}}">Editar</button></td>

									<div class="modal inmodal" id="PlanHostingEdit{{$categorias->id}}" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content animated flipInY">
												<div class="modal-header">
													<h4 class="modal-title">Editar Categoria</h4>
												</div>
												<form action ="{{route('categoria.update',$categorias->id)}}" method="POST" enctype="multipart/form-data" >
													@csrf
													@method('PATCH')
													<div class="modal-body">
														<div class="tile">
															<div class="tile-body">
																<div class="form-group">
																	<label for="title">Nombre:</label>
																	<input class="form-control" type="text" name="nombre" required="" value="{{$categorias->nombre}}" autocomplete="off">
																</div>
																<div class="form-group">
																	<label for="description">Descripcion:</label>
																	<textarea class="form-control" name="descripcion" rows="3">{{$categorias->descripcion}}</textarea>
																</div>
																<div class="form-group">
																	<label for="total_price">Precio:</label>
																	<div class="input-group">
																		<div class="input-group-prepend">
																			<select name="moneda" id="" class="input-group-text">
																				<option value="{{$categorias->moneda}}">{{$categorias->moneda}}</option>
																				@foreach($moneda as $monedas)
																				<option value="{{$monedas->simbolo}}">{{$monedas->simbolo}}</option>
																				@endforeach
																			</select>
																		</div>
																		<input type="number" class="form-control" name="precio" value="{{$categorias->precio}}" required="" autocomplete="off">
																		<label class="col-sm-2 col-form-label">estado:</label>
																		@if($categorias->estado ==0)
																		<input type="checkbox" name="estado" class="js-switch{{$categorias->id}}" checked=""  />
																		@else
																		<input type="checkbox" name="estado" class="js-switch{{$categorias->id}}" />
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
	@foreach($categoria as $categorias)
	<script>
		var elem = document.querySelector('.js-switch{{$categorias->id}}');
		var switchery = new Switchery(elem, { color: 'rgb(47 162 0)' });
	</script>
	@endforeach

@endsection