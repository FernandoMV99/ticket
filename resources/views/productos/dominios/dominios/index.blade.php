@extends('menu.layout')

@section('title', 'Dominios')
@section('img_title', 'dominios.svg')

@section('value_accion1', 'Agregar')
@section('data-toggle1', 'modal')
@section('data-target1', '#AgregarMotivo')

@section('content')
<?php
use Carbon\Carbon;
use App\Dominios;
?>

<!-- Modal Agregar Motivos-->
<div class="modal inmodal" id="AgregarMotivo" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceIn">
			<div class="modal-header"><h4 class="modal-title">Agregar Dominios</h4></div>
			<form action ="{{route('dominios.store')}}" method="POST" enctype="multipart/form-data" >
				@csrf
				<div class="modal-body">
					<div class="tile-body">

						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Nombre del Cliente:</label>
								<select class="form-control"  name="cliente" required="" >
									@foreach($clientes as $cliente)
									<option value="{{$cliente->id}}"  @if(old('cliente')==$cliente->id) selected="selected" @endif >{{$cliente->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-6">
								<label>Nombre del Proveedor de Dominio:</label>
								<select class="form-control" name="proveedor" required="" >
									@foreach($proveedores as $proveedor)
									<option value="{{$proveedor->id}}"  @if(old('proveedor')==$proveedor->id) selected="selected" @endif>{{$proveedor->nombre}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Fecha de compra:</label>
								<input type="date" class="form-control" name="fecha_compra" required value="{{old('fecha_compra')}}">
							</div>
							<div class="form-group col-md-6">
								<label>Fecha de vencimiento:</label>
								<select  class="form-control required"  name="fecha_vencimiento" required>
									<option value="1" @if(old('fecha_vencimiento')=='1') selected="selected" @endif >1 Año</option>
									<option value="2" @if(old('fecha_vencimiento')=='2') selected="selected" @endif >2 Años</option>
									<option value="3" @if(old('fecha_vencimiento')=='3') selected="selected" @endif >3 Años</option>
									<option value="4" @if(old('fecha_vencimiento')=='4') selected="selected" @endif >4 Años</option>
									<option value="5" @if(old('fecha_vencimiento')=='5') selected="selected" @endif >5 Años</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="see_domain_name">Nombre de dominio:</label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text">www.</span></div>

									<input type="text" class="form-control" autocomplete="off" onkeyup="this.value=Numeros(this.value)" name="nombre_dominio" placeholder="Dominio" required="">
									<div class="input-group-append">
										<select class="input-group-text" name="plan_dominio" >
											@foreach($plan_dominio as $plan_dominios)
											<option value="{{$plan_dominios->id}}" @if(old('plan_dominio')==$plan_dominios->id) selected="selected" @endif>.{{$plan_dominios->nombre}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label >
								Agregar una descripción sobre el dominio (DNS, soporte, etc):
							</label>
							<textarea class="form-control" name="descripcion" rows="3">{{old('descripcion')}}</textarea>
						</div>
					</div>
					<div class="tile-footer">
						<label>¿Desea Enviar correo de Notificación al cliente?</label>
						<input type="radio" name="email_envio" value="0" checked="">Si
						<input type="radio" name="email_envio" value="1">No<br>

						<button class="btn btn-primary btn-lg" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Registrar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Fin Modal Agregar Motivos-->

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
									<th>Cliente</th>
									<th>Nombre Dominio</th>
									<th>Fecha Vencimiento</th>
									<th>Dias Faltantes</th>
									<th>Precio Compra</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($dominios as $dominio)
								<tr>
									<td>{{$dominio->id}}
										@if($dominio->estado==1 & $dominio->estado_anulado==1)
										<span class="label label-danger">Anulado</span>
										@elseif($dominio->estado==1 & $dominio->estado_anulado==0)
										<span class="label label-warning">Inactivo</span>
										@elseif($dominio->estado==0 & $dominio->estado_anulado==0)
										<span class="label label-info">Activo</span>
									@endif</td>

									<td>{{$dominio->clientes->name}} {{$dominio->clientes->last_name}}</td>
									<td>{{$dominio->nombre_dominio}}</td>
									<td>{{$dominio->fecha_vencimiento}}</td>
									<td>
										<span hidden="">
											{{$date = $dominio->fecha_vencimiento."+ 1 days"}}
											{{$datework = Carbon::createFromDate($date)}}
											{{$now = Carbon::now()}}
											@if($datework>$now)
											{{$testdate = $now->diffInDays($datework)}}
											@else
											{{$testdate = '-'.$now->diffInDays($datework)}}
											@endif
										</span>
										@if($testdate<31 & $testdate>15)<strong style="color: #00ad75">{{$testdate}} Días</strong>
											@elseif($testdate<16 & $testdate>7)<strong style="color: #c17312b8">{{$testdate}} Días</strong>
												@elseif($testdate<8)<strong style="color: #ff1515f2">{{$testdate}} Días</strong>
													@else <strong>{{$testdate}} Días</strong>
													@endif
												</td>
												<td>{{$dominio->moneda}}{{$dominio->precio}}</td>
												<td>@if($testdate<30 & $dominio->estado_anulado==0 )
													<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#Renovar{{$dominio->id}}">Renovar</button>
													@else
													<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#DominioEdit{{$dominio->id}}">Ver</button>
													@endif

												</td>
												<!-- Formulario Anular-->
												<form action="{{ route('dominios.update',$dominio->id) }}"  enctype="multipart/form-data" method="post"  name="anular_registro{{$dominio->id}}">
													@csrf
													@method('PATCH')
													<input type="hidden" name="nombre_dominio" value="{{$dominio->nombre_dominio}}">
													<input type="hidden" name="boton" value="Anulado">
												</form>
												<!-- Formulario Anular-->
												{{-- Renovar ver --}}
												<div class="modal inmodal" id="Renovar{{$dominio->id}}" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog modal-lg">
														<div class="modal-content animated flipInY">
															<div class="modal-header">
																<h4 class="modal-title">Editar Dominio</h4>
																@if($dominio->estado_anulado=='0') <button class="demo4 a{{$dominio->id}}" style="background:#ff000000;border: 0px;"><img class="input-group-text" style="background:#ff000000;border: 0px;width: 50px" src="{{ asset('/multimedia/anulado.svg')}}" /></button> @endif
															</div>
															<form action="{{ route('dominios.update',$dominio->id) }}"  enctype="multipart/form-data" method="post">
																@csrf
																@method('PATCH')
																<div class="modal-body">
																	<div class="tile-body">
																		<div class="form-row">
																			<div class="form-group col-md-6">
																				<label>Nombre Dominio:</label>
																				<input class="form-control" value="{{$dominio->nombre_dominio}}" disabled="">
																			</div>
																			<div class="form-group col-md-6">
																				<label>Fecha de compra:</label>
																				<input class="form-control" value="{{$dominio->fecha_compra}}" disabled="">
																			</div>
																		</div>

																		<div class="form-row">
																			<div class="form-group col-md-6	">
																				<label>Fecha de vencimiento:</label>
																				<input class="form-control" value="{{$dominio->fecha_vencimiento}}" disabled="">
																			</div>
																			<div class="form-group col-md-6">
																				<label>Años a sumar:</label>
																				<select  class="form-control required"  name="fecha_vencimiento" required="" >
																					<option value="" >Seleccionar Cantidad de años</option>
																					<option value="1" >1 Año</option>
																					<option value="2" >2 Años</option>
																					<option value="3" >3 Años</option>
																					<option value="4" >4 Años</option>
																					<option value="5" >5 Años</option>
																				</select>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="modal-footer">
																	<input type="hidden" name="boton" value="Renovar">
																	<button type="submit" class="btn btn-primary">Renovar</button>
																</div>
															</form>
														</div>
													</div>
												</div>
												{{-- Renovar ver --}}

												{{-- modal ver --}}
												<div class="modal inmodal" id="DominioEdit{{$dominio->id}}" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog modal-lg">
														<div class="modal-content animated flipInY">
															<div class="modal-header">
																<h4 class="modal-title">Editar Dominio</h4>
																@if($dominio->estado_anulado=='0') <button class="demo4 a{{$dominio->id}}" style="background:#ff000000;border: 0px;"><img class="input-group-text" style="background:#ff000000;border: 0px;width: 50px" src="{{ asset('/multimedia/anulado.svg')}}" /></button> @endif
															</div>
															<form action="{{ route('dominios.update',$dominio->id) }}"  enctype="multipart/form-data" method="post">
																@csrf
																@method('PATCH')
																<div class="modal-body">
																	<div class="tile-body">
																		<div class="form-row">
																			<div class="form-group col-md-6">
																				<label>Nombre del Cliente:</label>
																				<input class="form-control" value="{{$dominio->clientes->name}} {{$dominio->clientes->last_name}}" disabled="">
																			</div>
																			<div class="form-group col-md-6">
																				<label>Nombre del Proveedor de Dominio:</label>
																				<select class="form-control" name="proveedor" required="" @if($dominio->estado_anulado=='1') disabled="" @endif >
																					@foreach($proveedores as $proveedor)
																					<option value="{{$proveedor->id}}"  @if($dominio->proveedor==$proveedor->id) selected="selected" @endif>{{$proveedor->nombre}}</option>
																					@endforeach
																				</select>
																			</div>
																		</div>

																		<div class="form-row">
																			<div class="form-group col-md-6">
																				<label>Fecha de compra:</label>
																				<input class="form-control" value="{{$dominio->fecha_compra}}" disabled="">
																			</div>
																			<div class="form-group col-md-4">
																				<label>Fecha de vencimiento:</label>
																				<input class="form-control" value="{{$dominio->fecha_vencimiento}}" disabled="">
																			</div>
																			<div class="form-group col-md-2">
																				<label>Años:</label>
																				<select  class="form-control required"  name="fecha_vencimiento" required="" @if($dominio->estado_anulado=='1') disabled="" @endif >
																					<option value="1" @if($dominio->anos=='1') selected="selected" @endif >1 Año</option>
																					<option value="2" @if($dominio->anos=='2') selected="selected" @endif >2 Años</option>
																					<option value="3" @if($dominio->anos=='3') selected="selected" @endif >3 Años</option>
																					<option value="4" @if($dominio->anos=='4') selected="selected" @endif >4 Años</option>
																					<option value="5" @if($dominio->anos=='5') selected="selected" @endif >5 Años</option>
																				</select>
																			</div>
																		</div>
																		<div class="form-row">
																			<div class="form-group col-md-6">
																				<label for="see_domain_name">Nombre de dominio:</label>
																				<input class="form-control" value="{{$dominio->nombre_dominio}}" disabled="">
																			</div>
																			<div class="form-group col-md-6">
																				<label for="see_domain_name">Precio:</label>
																				<input class="form-control" value="{{$dominio->moneda}} {{$dominio->precio}}" disabled="">
																			</div>
																		</div>
																		<div class="form-row">
																			<div class="form-group col-md-12">
																				<label for="see_domain_name">Descripcion:</label>
																				<textarea class="form-control" name="descripcion" @if($dominio->estado_anulado=='1') disabled="" @endif >{{$dominio->descripcion}}</textarea>
																			</div>

																		</div>
																	</div>
																</div>
																<div class="modal-footer">
																	<input type="hidden" name="boton" value="Guardar">
																	<button type="submit" class="btn btn-primary" @if($dominio->estado_anulado=='1') hidden="" @endif>Guardar</button>
																</div>
															</form>
														</div>
													</div>
												</div>
												{{-- modal ver --}}
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
			<script>
function Numeros(string){//Solo numeros
	var out = '';
    var filtro = 'qwertyuiopasdfghjklñzxcvbnm1234567890QWERTYUIOPASDFGHJKLÑZXCVBNM';//Caracteres validos

    //Recorrer el texto y verificar si el caracter se encuentra en la lista de validos
    for (var i=0; i<string.length; i++)
    	if (filtro.indexOf(string.charAt(i)) != -1)
             //Se añaden a la salida los caracteres validos
         out += string.charAt(i);

    //Retornar valor filtrado
    return out;
}
</script>
@foreach($dominios as $dominio)

<!-- Sweet alert -->
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<!-- Sweet Alert -->
<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<script>

	$(document).ready(function () {
		$('.demo4.a{{$dominio->id}}').click(function () {
			swal({
				title: "Estas Seguro?",
				text: "Tu Registro sera anulado sin modo a recuperarlo!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, Borrar!",
				cancelButtonText: "No, Cancelar!",
				closeOnConfirm: false,
				closeOnCancel: false },
				function (isConfirm) {
					if (isConfirm) {
						document.anular_registro{{$dominio->id}}.submit()
						swal("Eliminado!", "Tu Registro Fue anulado ", "success");
					} else {
						swal("Cancelado", "Cancelado la anulacion", "error");
					}
				});
		});
	});
</script>
@endforeach
@endsection