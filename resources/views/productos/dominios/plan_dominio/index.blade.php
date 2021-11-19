@extends('menu.layout')

@section('title', 'Plan Dominios')

@section('img_title', 'dominios.svg')
@section('value_accion1', 'Agregar')
@section('data-toggle1', 'modal')
@section('data-target1', '#AgregarPlanDominios')

@section('content')

<!--  Modal Agregar Plan -->
<div class="modal inmodal" id="AgregarPlanDominios" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated flipInY">
			<div class="modal-header">
				<h4 class="modal-title">Agregar Plan </h4>
			</div>
			<form action ="{{route('plan_dominio.store')}}" method="POST" enctype="multipart/form-data" >
				@csrf
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Nombre:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" autocomplete="off" required="required" onkeyup="this.value=Numeros(this.value)" name="nombre" required="">

						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Moneda:</label>
						<div class="col-sm-4">
							<select  id="" class="form-control" name="moneda">
								@foreach($moneda as $monedas)
								<option value="{{$monedas->simbolo}}">{{$monedas->simbolo}}</option>
								@endforeach
							</select>
						</div>
						<label class="col-sm-2 col-form-label">Precio:</label>
						<div class="col-sm-4">
							<input type="number" class="form-control" name="precio" value="" required="required" autocomplete="off">
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
									<th>precio</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($plan_dominio as $plan_dominios)
								<tr>
									<td>{{$plan_dominios->id}}</td>
									<td>{{$plan_dominios->nombre}}</td>
									<td>{{$plan_dominios->moneda}} {{$plan_dominios->precio}}</td>

									<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#DominioEdit{{$plan_dominios->id}}">Editar</button></td>

									<div class="modal inmodal" id="DominioEdit{{$plan_dominios->id}}" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content animated flipInY">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
													<h4 class="modal-title">Editar Planes</h4>
												</div>
												<form action ="{{route('proveedor_dominio.update',$plan_dominios->id)}}" method="POST" enctype="multipart/form-data" >
													@csrf
													@method('PATCH')
													<div class="modal-body">
														<div class="form-group row">
															<label class="col-sm-2 col-form-label">Nombre:</label>
															<div class="col-sm-10">
																<input type="text" class="form-control" value="{{$plan_dominios->nombre}}" disabled="">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-2 col-form-label">Moneda:</label>
															<div class="col-sm-10">

																<select name="" id="" class="form-control" name="moneda">
																	@foreach($moneda as $monedas)
																	<option value="{{$monedas->simbolo}}" @if($monedas->simbolo==$plan_dominios->moneda) selected="" @endif >{{$monedas->simbolo}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-2 col-form-label">Precio:</label>
															<div class="col-sm-10">
																<input type="number" class="form-control" name="correo" value="{{$plan_dominios->precio}}" required="required" autocomplete="off">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-2 col-form-label">estado:</label>

															<div class="col-sm-10">
																@if($plan_dominios->estado ==1)
																<input type="checkbox" name="estado" class="js-switch{{$plan_dominios->id}}" checked=""  />
																@else
																<input type="checkbox" name="estado" class="js-switch{{$plan_dominios->id}}" />
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

<script>
function Numeros(string){//Solo numeros
	var out = '';
    var filtro = 'qwertyuiopasdfghjklñzxcvbnm';//Caracteres validos

    //Recorrer el texto y verificar si el caracter se encuentra en la lista de validos
    for (var i=0; i<string.length; i++)
    	if (filtro.indexOf(string.charAt(i)) != -1)
             //Se añaden a la salida los caracteres validos
         out += string.charAt(i);

    //Retornar valor filtrado
    return out;
}
</script>
@foreach($plan_dominio as $plan_dominios)
<script>
	var elem = document.querySelector('.js-switch{{$plan_dominios->id}}');
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