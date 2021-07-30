@extends('menu.layout')
@section('img_title', 'soporte_tecnico.svg')
@section('title', 'Soporte Tecnico')

@section('value_accion1', 'Agregar')
@section('data-toggle1', 'modal')
@section('data-target1', '#AgregarSoporte')

@section('content')
<?php
use Carbon\Carbon;
use App\Equipos;
use App\Dominios;
?>
<div class="modal inmodal" id="AgregarSoporte" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceIn">
			<div class="modal-header" style="padding: 10px"><h4 class="modal-title">Agregar Soporte</h4></div>
			<form action ="{{route('soporte_tecnico.store')}}" method="POST" enctype="multipart/form-data" >
				@csrf
				<div class="modal-body" style="background:white;">
					<div >
						<div >
							<div class="tab-content">
								<div role="tabpanel" id="tab-1" class="tab-pane active show">
									<div class="panel-body">
										<div class="tile-body">
											<div class="form-row">
												<div class="form-group col-md-6">
													<label>Nombre del Cliente o Empresa:</label>
													<select name="cliente"  class="form-control">
														@foreach($clientes as $cliente)
														<option value="{{$cliente->id}}">{{$cliente->name}} {{$cliente->last_name}}</option>
														@endforeach
													</select>
												</div>

												<div class="form-group col-md-6">
													<label>Plan Soporte:</label>
													<select class="form-control" name="plan_soporte" required="">
														@foreach($plan_soporte as $plan_soportes)
														<option value="{{$plan_soportes->id}}">{{$plan_soportes->nombre}}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<label>Fecha de inicio:</label>
													<input type="date" class="form-control" name="fecha_inicio" required="">
												</div>
												<div class="form-group col-md-6">
													<label >Duración del contrato:</label>
													<div class="input-group">
														<input type="number" class="form-control" autocomplete="off" name="fecha_vencimiento" required="" value="1">
														<div class="input-group-append">
															<span class="input-group-text">meses</span>
														</div>
													</div>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-3">
													<label>Cantidad de Equipos:</label>
													<input type="number" class="form-control" name="cantidad_equipos" required="">
												</div>
												<div class="form-group col-md-3">
													<label >Precio:</label>
													<div class="input-group">
														<div class="input-group-append">
															<select class="input-group-text" name="moneda" >
																@foreach($moneda as $monedas)
																<option value="{{$monedas->simbolo}}">{{$monedas->simbolo}}</option>
																@endforeach
															</select>
														</div>
														<input type="number" class="form-control" autocomplete="off" name="precio" required="">
													</div>
												</div>
												<div class="form-group col-md-6">
													<label >Descripcion:</label>
													<textarea class="form-control" name="descripcion"></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tile-footer" style="padding: 0px 20px;text-align: center;">
						<label>¿Desea Enviar correo de Notificación al cliente?</label>
						<input type="radio" name="email_envio" value="0" checked="">Si
						<input type="radio" name="email_envio" value="1">No<br>
						<input class="btn btn-primary btn-lg" type="submit" value="Registrar">
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
								<tr align="center">
									<th>Item</th>
									<th>Nombre Cliente</th>
									<th>Plan Soporte</th>
									<th>Catd.Equipos</th>
									<th>Meses</th>
									<th>Fecha Caducidad</th>
									<th>Dias Faltantes</th>
									<th>Precio</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<span hidden="">
									{{$i=1}}
								</span>
								{{-- @foreach($soporte_tecnico as $soporte_tecnicos) --}}
								@foreach($soporte_tecnico as $soporte_tecnicos)
								<tr>
									<td>{{$soporte_tecnicos->id}}
										@if($soporte_tecnicos->estado==1 & $soporte_tecnicos->estado_anulado==1)
										<span class="label label-danger">Anulado</span>
										@elseif($soporte_tecnicos->estado==1 & $soporte_tecnicos->estado_anulado==0)
										<span class="label label-warning">Inactivo</span>
										@elseif($soporte_tecnicos->estado==0 & $soporte_tecnicos->estado_anulado==0)
										<span class="label label-info">Activo</span>
									@endif</td>
									<td>{{$soporte_tecnicos->clientes->name}} {{$soporte_tecnicos->clientes->last_name}}</td>
									<td>{{$soporte_tecnicos->plansoporte->nombre}} </td>
									<td>{{$soporte_tecnicos->cantidad_equipos}} </td>
									<td>{{$soporte_tecnicos->anos}} Mes(es)</td>
									<td>{{$soporte_tecnicos->fecha_vencimiento}}</td>
									<td>
										<span hidden="">
											{{$date = $soporte_tecnicos->fecha_vencimiento."+ 1 days"}}
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
												<td>{{$soporte_tecnicos->moneda}}{{$soporte_tecnicos->precio}}</td>
												<!-- Formulario Anular-->
												<form action="{{ route('soporte_tecnico.update',$soporte_tecnicos->id) }}"  enctype="multipart/form-data" method="post"  name="anular_registro{{$soporte_tecnicos->id}}">
													@csrf
													@method('PATCH')
													<input type="hidden" name="dominio" value="{{$soporte_tecnicos->dominio}}">
													<input type="hidden" name="boton" value="Anulado">
												</form>
												<!-- Formulario Anular-->
												<td>
													@if($testdate<2 & $soporte_tecnicos->estado_anulado==0)
														<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#Renovar{{$soporte_tecnicos->id}}">Renovar</button>
														@else
														<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#HostingEdit{{$soporte_tecnicos->id}}">Ver</button >
													@endif</td>

													{{--  --}}
													<div class="modal inmodal" id="Renovar{{$soporte_tecnicos->id}}" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-lg">
															<div class="modal-content animated bounceIn">
																<div class="modal-header" style="padding: 10px">
																	<h4 class="modal-title">Renovar Soporte</h4>
																	@if($soporte_tecnicos->estado_anulado=='0') <button class="demo4 a{{$soporte_tecnicos->id}}" style="background:#ff000000;border: 0px;"><img class="input-group-text" style="background:#ff000000;border: 0px;width: 50px" src="{{ asset('/multimedia/anulado.svg')}}" /></button> @endif

																</div>

																<form action="{{ route('soporte_tecnico.update',$soporte_tecnicos->id) }}"  enctype="multipart/form-data" method="post">
																	@csrf
																	@method('PATCH')
																	<div class="modal-body">
																		<div class="col-lg-12">
																			<div class="tabs-container">
																				<div class="tab-content">
																					<div role="tabpanel" id="renovar{{$soporte_tecnicos->id}}" class="tab-pane active show">
																						<div class="panel-body">
																							<div class="tile-body">
																								<div class="form-row">

																									<div class="form-group col-md-4">
																										<label>Nombre del Cliente o Empresa:</label>
																										<input type="text" class="form-control" disabled="" value="{{$soporte_tecnicos->clientes->name}} {{$soporte_tecnicos->clientes->last_name}}">
																									</div>
																									<div class="form-group col-md-4">
																										<label>Fecha compra:</label>
																										<input type="text" class="form-control" readonly="" name="fecha_inicio" value="{{$soporte_tecnicos->fecha_inicio}}">
																									</div>	<div class="form-group col-md-4">
																										<label>Fecha Vencimiento:</label>
																										<input type="text" class="form-control" readonly="" name="fecha_inicio" value="{{$soporte_tecnicos->fecha_vencimiento}}">
																									</div>

																									<div class="form-group col-md-6">
																										<label>Plan Soporte:</label>
																										<select class="form-control" name="plan_soporte" required="">
																											@foreach($plan_soporte as $plan_soportes)
																											<option value="{{$plan_soportes->id}}" @if($plan_soportes->id==$soporte_tecnicos->id) selected @endif >{{$plan_soportes->nombre}}</option>
																											@endforeach
																										</select>
																									</div>

																									<div class="form-group col-md-6">
																										<label >Duración del contrato:</label>
																										<div class="input-group">
																											<input type="number" class="form-control" autocomplete="off" name="fecha_vencimiento" required="" value="{{$soporte_tecnicos->anos}}">
																											<div class="input-group-append">
																												<span  class="input-group-text" >Meses</span>
																											</div>
																										</div>

																									</div>

																									<div class="form-group col-md-6">
																										<label >Precio:</label>
																										<div class="input-group">
																											<div class="input-group-append">
																												<select class="input-group-text" name="moneda" >
																													@foreach($moneda as $monedas)
																													<option value="{{$monedas->simbolo}}">{{$monedas->simbolo}}</option>
																													@endforeach
																												</select>
																											</div>
																											<input type="number" class="form-control" autocomplete="off" name="precio" required="" value="{{$soporte_tecnicos->precio}}">
																										</div>
																									</div>
																									<div class="form-group col-md-6">
																										<label>Cantidad Equipos:</label>
																										<input type="number" class="form-control" autocomplete="off" name="cantidad_equipos" required="" value="{{$soporte_tecnicos->cantidad_equipos}}">
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="tile-footer" style="padding: 0px 20px;text-align: center;">
																			<input class="btn btn-primary btn-lg" type="submit" value="Renovar" name="boton" @if($soporte_tecnicos->estado_anulado=='1') disabled="" @endif>
																		</div>
																	</div>
																</form>
															</div>
														</div>
													</div>
													{{-- Modal renovar --}}
													{{-- modal actulizar --}}
													<div class="modal inmodal" id="HostingEdit{{$soporte_tecnicos->id}}" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-lg">
															<div class="modal-content animated bounceIn">
																<div class="modal-header" style="padding: 10px">
																	<div class="row">
																		<div class="col-lg-8" align="right">
																			<h4 class="modal-title">Editar Soporte</h4>
																		</div>
																		<div class="col-lg-4" align="right">
																			@if($soporte_tecnicos->estado_anulado=='0') <button class="demo4 a{{$soporte_tecnicos->id}}" style="background:#ff000000;border: 0px; cursor: pointer;"><img class="input-group-text" style="background:#ff000000;border: 0px;width: 50px" src="{{ asset('/multimedia/anulado.svg')}}" /></button> @endif
																		</div>
																	{{-- 	<div class="col-lg-12" >
																			<div class="alert alert-warning alert-dismissable"  style="margin-bottom:2px">
																				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
																				Los Equipos Seleccionados Superan la Cantidad de lo Establecido.
																			</div>
																		</div> --}}
																	</div>
																</div>
																<div class="modal-body">
																	<div class="col-lg-12">
																		<div class="tabs-container">

																			<ul class="nav nav-tabs" role="tablist">
																				<li><a class="nav-link active show" data-toggle="tab" href="#DatosSoporte{{$soporte_tecnicos->id}}" style="font-size:15px;">Datos Soporte</a></li>
																				<li  @if($soporte_tecnicos->estado_anulado=='1')hidden="hidden" @endif><a class="nav-link" data-toggle="tab" href="#Equipos{{$soporte_tecnicos->id}}" >Equipos</a></li>
																			</ul>
																			<div class="tab-content">
																				<div role="tabpanel" id="DatosSoporte{{$soporte_tecnicos->id}}" class="tab-pane active show">
																					<div class="panel-body">
																						<div class="tile-body">
																							<form action="{{ route('soporte_tecnico.update',$soporte_tecnicos->id) }}"  enctype="multipart/form-data" method="post">
																								@csrf
																								@method('PATCH')
																								<div class="form-row">
																									<div class="form-group col-md-6">
																										<label>Nombre del Cliente o Empresa:</label>
																										<input type="text" class="form-control" disabled="" value="{{$soporte_tecnicos->clientes->name}} {{$soporte_tecnicos->clientes->last_name}}">
																									</div>

																									<div class="form-group col-md-6">
																										<label>Plan Soporte:</label>

																										<select class="form-control" name="plan_soporte" required="">
																											@foreach($plan_soporte as $plan_soportes)
																											<option value="{{$plan_soportes->id}}" @if($plan_soportes->id==$soporte_tecnicos->id) selected @endif >{{$plan_soportes->nombre}}</option>
																											@endforeach
																										</select>
																									</div>
																								</div>
																								<div class="form-row">
																									<div class="form-group col-md-6">
																										<label>Fecha de inicio:</label>
																										<input type="date" class="form-control" readonly="" name="fecha_inicio" value="{{$soporte_tecnicos->fecha_inicio}}">
																									</div>
																									<div class="form-group col-md-3">
																										<label >Duración del contrato:</label>
																										<div class="input-group">
																											<input type="number" class="form-control" autocomplete="off" name="fecha_vencimiento" required="" value="{{$soporte_tecnicos->anos}}">
																											<div class="input-group-append">
																												<span  class="input-group-text" >Meses</span>
																											</div>
																										</div>

																									</div>
																									<div class="form-group col-md-3">
																										<label >Equipos Seleccionados:</label>
																										<input type="disabled" class="form-control" disabled="" value="{{$soporte_tecnicos->cantidad_equipos_asignados}}">
																									</div>
																								</div>
																								<div class="form-row">
																									<div class="form-group col-md-3">
																										<label>Cantidad Equipos:</label>
																										<input type="number" class="form-control" autocomplete="off" name="cantidad_equipos" required="" value="{{$soporte_tecnicos->cantidad_equipos}}">
																									</div>
																									<div class="form-group col-md-3">
																										<label>Precio:</label>
																										<div class="input-group">
																											<div class="input-group-append">
																												<select class="input-group-text" name="moneda" >
																													@foreach($moneda as $monedas)
																													<option value="{{$monedas->simbolo}}">{{$monedas->simbolo}}</option>
																													@endforeach
																												</select>
																											</div>
																											<input type="number" class="form-control" autocomplete="off" name="precio" required="" value="{{$soporte_tecnicos->precio}}">
																										</div>
																									</div>
																									<div class="form-group col-md-6">
																										<label>Descripcion:</label>
																										<textarea name="descripcion" class="form-control" rows="5" >{{$soporte_tecnicos->descripcion}}</textarea>
																									</div>
																								</div>
																								<div class="tile-footer" style="padding: 0px 20px;text-align: center;">
																									<input class="btn btn-primary btn-lg" type="submit" value="Actualizar" name="boton" @if($soporte_tecnicos->estado_anulado=='1')hidden="hidden" @endif>
																								</div>
																							</form>
																						</div>
																					</div>
																				</div>



																				<div role="tabpanel" id="Equipos{{$soporte_tecnicos->id}}" class="tab-pane">
																					<div class="panel-body">
																						<span hidden="">
																							{{$equipos=Equipos::where('cliente',$soporte_tecnicos->cliente)->where('estado',0)->get()}}
																							{{$count_equipos=Equipos::where('cliente',$soporte_tecnicos->cliente)->where('estado',0)->count()}}

																						</span>
																						<div align="right">
																							<div class="input-group">
																								<div class="input-group-append">
																									<img src="{{asset('multimedia/equipos.svg')}}"  style="background-color: #e9ecef00;
																									border: 1px solid #ced4da00;" class="input-group-text" width="50px">

																								</div>
																								<input type="text" id="numero_count{{$soporte_tecnicos->id}}" disabled="" style="text-align: left;border: 1px solid transparent;background-color: #e9ecef0d; width: 100px" value="{{$soporte_tecnicos->cantidad_equipos_asignados}}">
																							</div>

																						</div>
																						<div class="row" >
																							@if($count_equipos==0)
																							<div class="col-lg-12" align="center">
																								<span><h1 style="color:gray;">No hay Productos</h1></span>
																							</div>
																							@endif
																							<form action="{{ route('soporte_tecnico.update',$soporte_tecnicos->id) }}"  enctype="multipart/form-data" method="post" id="equipos{{$soporte_tecnicos->id}}">
																								@csrf
																								@method('PATCH')
																								@foreach($equipos as $equipo)
																								<div class="col-lg-4" >
																									<label for="size_{{$equipo->id}}"   onclick="myFunction{{$soporte_tecnicos->id}}()">
																										<div class="contact-box" id="contenedor_{{$soporte_tecnicos->id}}">
																											<div class="row" >
																												<div class="col-4">
																													<div class="text-center">
																														<img alt="image" class=" m-t-xs img-fluid" src="{{asset('multimedia/tipo_equipo')}}/{{$equipo->tipoequipo->imagen}}">
																													</div>
																												</div>
																												<div class="col-8">
																													<h3><strong>{{$equipo->marcas->nombre}}</strong></h3>
																													<strong >N/S: </strong>{{$equipo->numero_serie}} <br>
																													<strong >Usuario:</strong> {{$equipo->usuario}} <br>
																												</div>

																												<input type="checkbox" id="size_{{$equipo->id}}" onclick="check{{$equipo->id}}()" @if($equipo->estado_soporte==0) checked="" @endif   >
																												<input type="hidden" hidden="" name="boton" value="Equipos">
																												<input name="id_equipo[]" type="hidden" readonly="" value="{{$equipo->id}}" hidden="">
																												<input  name="equipo_select[]" type="hidden" readonly="" id="myCheck{{$equipo->id}}" @if($equipo->estado_soporte==1) value="1" @elseif($equipo->estado_soporte==0) value="0" @endif hidden="" >
																												<script>
																													function check{{$equipo->id}}() {
																														if(document.getElementById("myCheck{{$equipo->id}}").value=='0'){
																															document.getElementById("myCheck{{$equipo->id}}").value='1';
																														}else{
																															document.getElementById("myCheck{{$equipo->id}}").value='0';
																														}
																													}
																												</script>
																											</div>
																										</div>
																									</label>
																								</div>

																								@endforeach
																							</form>
																						</div>

																						<input  class="btn btn-success" type="button" value="Guardar" onclick="document.getElementById('equipos{{$soporte_tecnicos->id}}').submit();"@if($count_equipos==0) hidden="" @endif>
																					</div>
																				</div>

																			</div>
																		</div>

																	</div>
																</div>
															</div>
														</div>
													</div>
													{{-- modal actulizar --}}

												</tr>
												<script>
													function myFunction{{$soporte_tecnicos->id}}() {
														var $marcados{{$soporte_tecnicos->id}} =$("#contenedor_{{$soporte_tecnicos->id}} input:checked");
														document.getElementById("numero_count{{$soporte_tecnicos->id}}").value=$marcados{{$soporte_tecnicos->id}}.length;
													}
												</script>
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
				@foreach($soporte_tecnico as $soporte_tecnicos)
				<!-- Sweet alert -->
				<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
				<!-- Sweet Alert -->
				<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
				<script>

					$(document).ready(function () {
						$('.demo4.a{{$soporte_tecnicos->id}}').click(function () {
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
										document.anular_registro{{$soporte_tecnicos->id}}.submit()
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