@extends('menu.layout_cliente')

@section('img_title', 'certificado.svg')

@section('title', 'Mis Certificados')
@section('atributo1', 'hidden')


@section('content')
<?php
use Carbon\Carbon;
use App\Dominios;
?>
{{-- <td>  <dd>
	<div class="progress m-b-1">
		<div style="width: 60%;" class="progress-bar progress-bar-striped progress-bar-animated"></div>
	</div>
	<small>Project completed in <strong>60%</strong>. Remaining close the project, sign a contract and invoice.</small>
</dd></td> --}}
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12" >
			<div class="ibox ">
				<div class="ibox-content">
					<div class="table-responsive">
						<span hidden=""> {{$i=1}}</span>
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<th>ITEM</th>
								<th>Datos Del Certificado</th>
							</thead>
							<tbody>
								@foreach($certificados_ssl_cliente as $certificados_ssls)
								<tr>
									<td>{{$certificados_ssls->id}}</td>
									<td>
										<div class="row">
											<div class="col-lg-6" align="left">
												<dl class="row mb-0">
													<div class="col-sm-4"><dt>Estado:</dt> </div>
												<div class="col-sm-8 text-sm-left"><dd class="mb-1">@if($certificados_ssls->estado==0)<span class="label label-info">Activo</span> @else <span class="label label-warning">Suspendido</span>@endif</div>
													</dl>
													<dl class="row mb-0">
														<div class="col-sm-4"><dt>Dominio:</dt> </div>
														<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{$certificados_ssls->nombre_dominio}}</dd> </div>
													</dl>
													<dl class="row mb-0">
														<div class="col-sm-4"><dt>Dias Faltantes:</dt> </div>
														<div class="col-sm-8 text-sm-left"> <dd class="mb-1">
															<span hidden="">
																{{$date = $certificados_ssls->fecha_vencimiento}}
																{{$datework = Carbon::createFromDate($date)}}
																{{$fecha_compra = Carbon::createFromDate($certificados_ssls->fecha_inicio)}}
																{{$now = Carbon::now()}}
																{{ $cienporciento=$fecha_compra->diffInDays($datework)}}
																@if ($datework>$now)
																{{$testdate=$now->diffInDays($datework)}}
																@else
																{{$testdate= 0}}
																@endif
																{{$num_porsentaje=100-(($testdate*100)/$cienporciento)}}

																@if ($num_porsentaje<0)
																{{$porsentaje= 0}}
																@else
																{{$porsentaje=$num_porsentaje}}
																@endif

															</span>
															@if($testdate<31 & $testdate>15)<strong style="color: #00ad75">{{$testdate}} D??as</strong>
																@elseif($testdate<16 & $testdate>7)<strong style="color: #c17312b8">{{$testdate}} D??as</strong>
																	@elseif($testdate<8)<strong style="color: #ff1515f2">{{$testdate}} D??as</strong>
																		@else <strong>{{$testdate}} D??as</strong>
																	@endif</dd>
																</div>
															</dl>
															<dl class="row mb-0">
																<div class="col-sm-4">
																	<dt>porcentaje:</dt>
																</div>
																<div class="col-sm-7 text-sm-left">
																	<dd class="mb-1">
																		<div class="progress m-b-1" style="background-color: #0b34ff2e">
																			@if($testdate<31 & $testdate>15)
																				<div style="width: {{round($porsentaje, 0)}}%;background-color:#00ad75;" class="progress-bar progress-bar-striped progress-bar-animated"></div>
																				@elseif($testdate<16 & $testdate>7)
																					<div style="width: {{round($porsentaje, 0)}}%;background-color:#c17312b8;" class="progress-bar progress-bar-striped progress-bar-animated"></div>
																					@elseif($testdate<8)
																					<div style="width: {{round($porsentaje, 0)}}%;background-color:#ff1515f2;" class="progress-bar progress-bar-striped progress-bar-animated"></div>
																					@else
																					<div style="width: {{round($porsentaje, 0)}}%" class="progress-bar progress-bar-striped progress-bar-animated"></div>
																					@endif
																				</div>
																			</dd>
																		</div>
																		<div class="col-sm-1 text-sm-left">{{round($porsentaje, 0)}}%</div>
																	</dl>
																</div>
																<div class="col-lg-6" id="cluster_info">

																	<dl class="row mb-0">
																		<div class="col-sm-4">
																			<dt>Fecha Compra:</dt>
																		</div>
																		<div class="col-sm-8 text-sm-left">
																			<dd class="mb-1">{{$certificados_ssls->fecha_compra}}</dd>
																		</div>
																	</dl>
																	<dl class="row mb-0">
																		<div class="col-sm-4">
																			<dt>Fecha Vencimiento:</dt>
																		</div>
																		<div class="col-sm-8 text-sm-left">
																			<dd class="mb-1">{{$certificados_ssls->fecha_vencimiento}}</dd>
																		</div>
																	</dl>
																	{{-- <dl class="row mb-0">
																		<div class="col-sm-4">
																			<dt>Fecha Creacion:</dt>
																		</div>
																		<div class="col-sm-8 text-sm-left">
																			<dd class="mb-1">{{$certificados_ssls->created_at}}</dd>
																		</div>
																	</dl> --}}
																	<dl class="row mb-0">
																		<div class="col-sm-4"><dt>Descripcion:</dt> </div>
																		<div class="col-sm-8 text-sm-left"> <dd class="mb-1">{{$certificados_ssls->descripcion}}</dd></div>
																	</dl>
																</div>
															</div>
														</td>
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


					@endsection