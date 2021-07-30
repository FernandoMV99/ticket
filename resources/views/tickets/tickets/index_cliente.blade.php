@extends('menu.layout_cliente')
@section('img_title', 'ticket2.svg')

@section('title', 'Mis Tickets')
@section('value_accion1', 'Agregar')
@section('data-toggle1', 'modal')
@section('data-target1', '#AgregarTicket')


<link href="{{ asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
@section('content')
{{-- FIN MODAL AGREGAR TICKET --}}
<div class="modal inmodal fade" id="AgregarTicket" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="padding-top: 0px;padding-bottom: 5px;border-bottom: 0px;">
				<h4 class="modal-title">Generar Ticket</h4>
				@if(isset($soporte_existe))
				@if($soporte_existe->fecha_vencimiento < $date_now)
				<div class="alert alert-warning alert-dismissable" style="margin-bottom: 0px;"><b>Nota:</b> Tu Plan de Soporte a vencido, Es Posible que se te sumen Cargos por la asistencia.</div>
				@elseif($soporte_existe->estado == 1)
				<div class="alert alert-warning alert-dismissable" style="margin-bottom: 0px;"><b>Nota:</b> Tu Plan de Soporte esta Desactivado, Es Posible que se te sumen Cargos por la asistencia.</div>
				@endif
				@else
				<div class="alert alert-warning alert-dismissable" style="margin-bottom: 0px;"><b>Nota:</b> No cuentas con ningun Plan de Soporte, Es Posible que se te sumen Cargos por la asistencia.</div>
				@endif
			</div>
			<div >
				<form action ="{{route('tickets.store')}}" method="POST" enctype="multipart/form-data" >
					@csrf
					<div class="row">
						<div class="col-lg-12">
							<div class="mail-box">
								<div class="mail-body">
									<div class="form-group row"><label class="col-sm-2 col-form-label">Motivo:</label>
										<div class="col-sm-10"><select class="form-control" name="motivo">@foreach($motivo as $motivos)
											<option value="{{$motivos->id}}">{{$motivos->nombre}}</option>@endforeach</select></div>
										</div>
										<div class="form-group row"><label class="col-sm-2 col-form-label">Asunto:</label>
											<div class="col-sm-10"><input type="text" class="form-control" name="asunto" value="" required="required"></div>
										</div>
										<div class="form-group row"><label class="col-sm-2 col-form-label">Equipo:</label>
											<div class="col-sm-10">
												<select class="form-control" name="equipo_soporte">
													<option value="">Soporte sin Equipo</option>
													<option value="new">Mi equipo no está Registrado</option>
													@foreach($equipo as $equipos)
													<option value="{{$equipos->id}}"> {{$equipos->codigo_equipo}} / {{$equipos->tipoequipo->nombre}} / {{$equipos->marcas->nombre}} / {{$equipos->usuario}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>

									{{-- <div class="mail-text h-200"> --}}
										<textarea name="mensaje" required="" class="summernote" rows="8" required="required"></textarea>
										{{-- <div class="clearfix"></div> --}}
									{{-- </div> --}}
									<div class="modal-footer" style="padding-bottom: 0px;">
										<button class="ladda-button btn btn-primary" data-style="zoom-out">Enviar</button>
									</div>

								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>

	{{-- FIN MODAL AGREGAR TICKET --}}
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-lg-12" >
				<div class="ibox ">
					<div class="ibox-content">
						<div class="table-responsive">

							<table class="table table-striped table-bordered table-hover dataTables-example" >
								<thead>
									<tr>
										<th>Codigo</th>
										<th>Motivo</th>
										<th>Asunto</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@foreach($tickets_agregado_cliente as $tickets_agregado_clientes)
									<tr class="gradeX">
										<td>{{$tickets_agregado_clientes->codigo_ticket}}
										</td>
										<td>{{$tickets_agregado_clientes->motivo->nombre}}</td>
										<td>{{$tickets_agregado_clientes->asunto}}</td>
										<td><a href="{{ route('tickets.show', $tickets_agregado_clientes->id) }}"><button type="button" class="btn btn-s-m btn-primary">Ver</button></a></td>
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
	<style>
	.note-editable.card-block{height: 198px}
	table{font-size: 13px}
	.note-insert{display: none}
	.note-view{display: none}
</style>
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


<!-- iCheck -->
<script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>

<!-- SUMMERNOTE -->
<script src="{{asset('js/plugins/summernote/summernote-bs4.js')}}"></script>

<script>
	$(document).ready(function(){

		$('.summernote').summernote();

	});

</script>


@endsection