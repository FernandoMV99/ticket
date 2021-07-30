@extends('menu.layout')
@section('img_title', 'ticket2.svg')

@section('title', 'Tickets')
@section('atributo1', 'hidden')

@section('content')
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
										<th>Asunto</th>
										<th>Motivo</th>
										<th>Cliente</th>
										<th>Trabajador</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@foreach($tickets_agregado as $tickets_agregados)

									<tr class="gradeX">
										@if($tickets_agregados->estado_id==1)
										<td><img src="{{ asset('multimedia/circulo.png') }}" width="9px" alt="">{{$tickets_agregados->codigo_ticket}}</td>
										@else
										<td>{{$tickets_agregados->codigo_ticket}}</td>
										@endif
										<td>{{$tickets_agregados->asunto}}</td>
										<td>{{$tickets_agregados->motivo->nombre}}</td>
										<td>{{$tickets_agregados->clientes->name}}</td>
										<td>@if(isset($tickets_agregados->trabajador)){{$tickets_agregados->trabajadors->name}}@endif</td>
										<td><a href="{{ route('tickets.show', $tickets_agregados->id) }}"><button type="button" class="btn btn-s-m btn-primary">Ver</button></a></td>
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