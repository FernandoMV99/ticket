@extends('menu.layout')

@section('title', 'Certificado SSL')
@section('img_title', 'certificado.svg')

@section('value_accion1', 'Agregar')
@section('data-toggle1', 'modal')
@section('data-target1', '#AgregarSSL')

@section('content')
<?php
use Carbon\Carbon;
use App\Dominios;
?>

<!-- Modal Agregar Motivos-->
<div class="modal inmodal" id="AgregarSSL" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceIn">
			<div class="modal-header"><h4 class="modal-title">Agregar Certificado</h4></div>
			<form action ="{{route('certificado_ssl.store')}}" method="POST" enctype="multipart/form-data" >
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
								<label>Nombre del Proveedor :</label>
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
							<div class="form-group col-md-6">
								<label for="see_domain_name">Nombre de dominio:</label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text">http://</span></div>
									<input list="browsers" class="form-control" name="nombre_dominio" autocomplete="off" required="required">
									<datalist id="browsers">
										@foreach($dominios as $dominio)<option value="{{$dominio->nombre_dominio}}">@endforeach
										</datalist>
									</div>
								</div>
								<div class="form-group col-md-6">
									<label for="see_domain_name">Plan SSL:</label>
									<div class="input-group">
										<select class="form-control" name="plan_certificado_ssl" required="" >
											@foreach($plan_ssl as $plan_ssls)
											<option value="{{$plan_ssls->id}}"  @if(old('plan_certificado_ssl')==$plan_ssls->id) selected="selected" @endif>{{$plan_ssls->nombre}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label >
									Agregar una descripción:
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
										<th>Plan del Certificado</th>
										<th>Fecha Vencimiento</th>
										<th>Dias Faltantes</th>
										<th>Precio Compra</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@foreach($certificados_ssl as $certificados_ssls)
									<tr>
										<td>{{$certificados_ssls->id}}
											@if($certificados_ssls->estado==1 & $certificados_ssls->estado_anulado==1)
											<span class="label label-danger">Anulado</span>
											@elseif($certificados_ssls->estado==1 & $certificados_ssls->estado_anulado==0)
											<span class="label label-warning">Inactivo</span>
											@elseif($certificados_ssls->estado==0 & $certificados_ssls->estado_anulado==0)
											<span class="label label-info">Activo</span>
										@endif</td>

										<td>{{$certificados_ssls->clientes->name}} {{$certificados_ssls->clientes->last_name}}</td>
										<td>{{$certificados_ssls->nombre_dominio}}</td>
										<td>{{$certificados_ssls->planes_ssl->nombre}}</td>
										<td>{{$certificados_ssls->fecha_vencimiento}}</td>
										<td>
											<span hidden="">
												{{$date = $certificados_ssls->fecha_vencimiento."+ 1 days"}}
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
													<td>{{$certificados_ssls->moneda}}{{$certificados_ssls->precio}}</td>
													<td>
														@if($testdate<30 & $certificados_ssls->estado_anulado==0)
															<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#Renovar{{$certificados_ssls->id}}">Renovar</button>
															@else
															<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#certificadoEdit{{$certificados_ssls->id}}">Ver</button>
															@endif
														</td>
														{{-- Renovar --}}
														<div class="modal inmodal" id="Renovar{{$certificados_ssls->id}}" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog modal-lg">
																<div class="modal-content animated flipInY">
																	<div class="modal-header">
																		<h4 class="modal-title">Renovar Certificado</h4>
																		@if($certificados_ssls->estado_anulado=='0') <button class="demo4 a{{$certificados_ssls->id}}" style="background:#ff000000;border: 0px;"><img class="input-group-text" style="background:#ff000000;border: 0px;width: 50px" src="{{ asset('/multimedia/anulado.svg')}}" /></button> @endif
																	</div>
																	<form action="{{ route('certificado_ssl.update',$certificados_ssls->id) }}"  enctype="multipart/form-data" method="post">
																		@csrf
																		@method('PATCH')
																		<div class="modal-body">
																			<div class="tile-body">

																				<div class="form-row">
																					<div class="form-group col-md-4">
																						<label for="see_domain_name">Nombre de dominio:</label>
																						<div class="input-group">
																							<input value="{{$certificados_ssls->nombre_dominio}}" class="form-control" disabled="" autocomplete="off" required="required">
																						</div>
																					</div>
																					<div class="form-group col-md-4">
																						<label>Fecha de compra:</label>
																						<input type="text" class="form-control" required value="{{$certificados_ssls->fecha_compra}}" disabled="">
																					</div>
																					<div class="form-group col-md-4">
																						<label>Fecha de vencimiento:</label>
																						<input type="text" class="form-control" required value="{{$certificados_ssls->fecha_vencimiento}}" disabled="">
																					</div>
																				</div>
																				<div class="form-row">
																					<div class="form-group col-md-6">
																						<label for="see_domain_name">Plan SSL:</label>
																						<div class="input-group">
																							<select class="form-control" name="plan_certificado_id" required="" >
																								@foreach($plan_ssl as $plan_ssls)
																								<option value="{{$plan_ssls->id}}"  @if($certificados_ssls->planes_ssl->id==$plan_ssls->id) selected="selected" @endif>{{$plan_ssls->nombre}}</option>
																								@endforeach
																							</select>
																						</div>
																					</div>
																					<div class="form-group col-md-6">
																						<label>Fecha de vencimiento:</label>
																						<select  class="form-control required"  name="fecha_vencimiento" required>
																							<option >Selecciona cantidad de años</option>
																							<option value="1">1 Año</option>
																							<option value="2">2 Años</option>
																							<option value="3">3 Años</option>
																							<option value="4">4 Años</option>
																							<option value="5">5 Años</option>
																						</select>
																					</div>
																				</div>
																			</div>

																			<div class="tile-footer" >
																				<input type="submit"  class="btn btn-primary btn-lg" name="boton" value="Renovar">
																			</div>
																		</div>
																	</form>
																</div>
															</div>
														</div>
														{{-- Renovar --}}
														<div class="modal inmodal" id="certificadoEdit{{$certificados_ssls->id}}" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog modal-lg">
																<div class="modal-content animated flipInY">
																	<div class="modal-header">
																		<h4 class="modal-title">Editar Certificado</h4>
																		@if($certificados_ssls->estado_anulado=='0') <button class="demo4 a{{$certificados_ssls->id}}" style="background:#ff000000;border: 0px;"><img class="input-group-text" style="background:#ff000000;border: 0px;width: 50px" src="{{ asset('/multimedia/anulado.svg')}}" /></button> @endif
																	</div>
																	<form action="{{ route('certificado_ssl.update',$certificados_ssls->id) }}"  enctype="multipart/form-data" method="post">
																		@csrf
																		@method('PATCH')
																		<div class="modal-body">
																			<div class="tile-body">

																				<div class="form-row">
																					<div class="form-group col-md-6">
																						<label>Nombre del Cliente:</label>
																						<input type="text" disabled="" value="{{$certificados_ssls->clientes->name}} {{$certificados_ssls->clientes->last_name}}" class="form-control">
																					</div>
																					<div class="form-group col-md-6">
																						<label>Nombre del Proveedor :</label>
																						<select class="form-control" name="proveedor" required="" @if($certificados_ssls->estado_anulado==1) disabled="" @endif >
																							@foreach($proveedores as $proveedor)
																							<option value="{{$proveedor->id}}"   @if($certificados_ssls->proveedores->id==$proveedor->id) selected="selected" @endif>{{$proveedor->nombre}}</option>
																							@endforeach
																						</select>
																					</div>
																				</div>

																				<div class="form-row">
																					<div class="form-group col-md-6">
																						<label>Fecha de compra:</label>
																						<input type="text" class="form-control" required value="{{$certificados_ssls->fecha_compra}}" disabled="">
																					</div>
																					<div class="form-group col-md-6">
																						<label>Fecha de vencimiento:</label>
																						<select  class="form-control required"  name="fecha_vencimiento" @if($certificados_ssls->estado_anulado==1) disabled="" @endif  required >
																							<option value="1" @if($certificados_ssls->anos=='1') selected="selected" @endif >1 Año</option>
																							<option value="2" @if($certificados_ssls->anos=='2') selected="selected" @endif >2 Años</option>
																							<option value="3" @if($certificados_ssls->anos=='3') selected="selected" @endif >3 Años</option>
																							<option value="4" @if($certificados_ssls->anos=='4') selected="selected" @endif >4 Años</option>
																							<option value="5" @if($certificados_ssls->anos=='5') selected="selected" @endif >5 Años</option>
																						</select>
																					</div>
																				</div>
																				<div class="form-row">
																					<div class="form-group col-md-6">
																						<label for="see_domain_name">Nombre de dominio:</label>
																						<div class="input-group">
																							<input value="{{$certificados_ssls->nombre_dominio}}" class="form-control" disabled="" autocomplete="off" required="required">
																						</div>
																					</div>
																					<div class="form-group col-md-6">
																						<label for="see_domain_name">Plan SSL:</label>
																						<div class="input-group">
																							<select class="form-control" name="plan_certificado_ssl" required="" @if($certificados_ssls->estado_anulado==1) disabled="" @endif  >
																								@foreach($plan_ssl as $plan_ssls)
																								<option value="{{$plan_ssls->id}}"  @if($certificados_ssls->planes_ssl->id==$plan_ssls->id) selected="selected" @endif>{{$plan_ssls->nombre}}</option>
																								@endforeach
																							</select>
																						</div>
																					</div>
																				</div>
																				<div class="form-group">
																					<label >
																						Agregar una descripción:
																					</label>
																					<textarea class="form-control" name="descripcion" @if($certificados_ssls->estado_anulado==1) disabled="" @endif  rows="3">{{$certificados_ssls->descripcion}}</textarea>
																				</div>
																			</div>
																			<div class="tile-footer" @if($certificados_ssls->estado_anulado==1) hidden="" @endif >
																				<input type="submit"  class="btn btn-primary btn-lg" name="boton" value="Actualizar">
																			</div>
																		</div>
																	</form>
																</div>
															</div>
														</div>
														{{-- Modal actilizar --}}
														<!-- Formulario Anular-->
														<form action="{{ route('certificado_ssl.update',$certificados_ssls->id) }}"  enctype="multipart/form-data" method="post"  name="anular_registro{{$certificados_ssls->id}}">
															@csrf
															@method('PATCH')
															<input type="hidden" name="nombre_dominio" value="{{$certificados_ssls->nombre_dominio}}">
															<input type="hidden" name="boton" value="Anulado">
														</form>
														<!-- Formulario Anular-->
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
					@foreach($certificados_ssl as $certificados_ssls)

					<!-- Sweet alert -->
					<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
					<!-- Sweet Alert -->
					<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
					<script>

						$(document).ready(function () {
							$('.demo4.a{{$certificados_ssls->id}}').click(function () {
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
											document.anular_registro{{$certificados_ssls->id}}.submit()
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