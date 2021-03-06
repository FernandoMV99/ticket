@extends('menu.layout')

@section('img_title', 'ticket2.svg')
@section('title', 'Motivos')
@section('value_accion1', 'Agregar')
@section('data-toggle1', 'modal')
@section('data-target1', '#AgregarMotivo')

@section('content')
{{-- Modal Agregar Motivos --}}
<div class="modal inmodal" id="AgregarMotivo" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated flipInY">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Agregar Motivo</h4>
			</div>
			<form action ="{{route('motivos.store')}}" method="POST" enctype="multipart/form-data" >
				@csrf
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Motivo:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="motivo" value="" required="required" autocomplete="off">
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


{{--Fin Modal Agregar Motivos --}}

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
									<th>Estado</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($motivos as $motivo)
								<tr>
									<td>{{$motivo->id}} </td>
									<td>{{$motivo->nombre}}</td>
									<td>@if($motivo->estado_id==2)<button class="btn btn-warning btn-xs">Desactivo</button>@else <button class="btn btn-info btn-xs">Activo</button> @endif</td>
									<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal2{{$motivo->id}}">Editar</button></td>

									<div class="modal inmodal" id="myModal2{{$motivo->id}}" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content animated flipInY">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
													<h4 class="modal-title">Editar Motivos</h4>
												</div>
												<form action ="{{route('motivos.update',$motivo->id)}}" method="POST" enctype="multipart/form-data" >
													@csrf
													@method('PATCH')
													<div class="modal-body">
														<div class="form-group row">
															<label class="col-sm-2 col-form-label">Motivo:</label>
															<div class="col-sm-10">
																<input type="text" class="form-control" name="motivo" value="{{$motivo->nombre}}" required="required" autocomplete="off">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-2 col-form-label">estado:</label>
															<div class="col-sm-10">
																<input type="checkbox" class="js-switch_{{$motivo->id}}" name="estado"  @if($motivo->estado_id==1) checked="" @endif />
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
<link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
<!-- Switchery -->
<script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>

@foreach($motivos as $motivo)
<script>
	var elem_2 = document.querySelector('.js-switch_{{$motivo->id}}');
	var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach

@endsection