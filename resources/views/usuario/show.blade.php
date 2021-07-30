@extends('menu.layout')
@section('img_title', 'user.svg')
@section('title', 'Usuario/Ver')
@section('value_accion1', 'Atras')
@section('href_accion1', route('usuario.index'))
@section('content')
<style>
.iconos_perfil{padding-bottom: 8px;padding-right: 5px}
.form-control{padding-top: 10px;margin-bottom: 10px;border-radius: 3px}
.iconos_perfil_form{margin-top: 10px}
input#archivoInput{
	position:absolute;
	top:0px;
	left:0px;
	right:0px;
	bottom:0px;
	width:100%;
	height:100%;
	opacity: 0	;
}
.form-control.form-control-sm{padding-top: 1px}
</style>
<div class="wrapper wrapper-content">
	<div class="row animated fadeInRight">
		<div class="col-md-4">
			<!-- Vista editar -->
			<div class="ibox" id="vista_usuario">
				<div class="ibox-title" style="text-align: right;padding-right: 10px;">
					<button class="btn " id="boton" style="margin-top: 5px;background:#228b2200;" onclick="editar_usuario()"><img alt="image" width="25px"  src="{{asset('multimedia/editar.svg')}}">
					</button>
				</div>
				<div>
					<div class="ibox-content">
						<center><img alt="image" width="200px"  style="border-radius: 10px" src="{{asset('multimedia/users/')}}/{{ $usuario->foto }}"></center>
					</div>
					<div class="ibox-content profile-content">
						@if($usuario->estado_activo==1) <span class="label label-info">Activo</span> @else <span class="label label-default">Desactivo</span> @endif
						<h4>
							<img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/identificacion.svg')}}">
							<strong>{{$usuario->name}} {{$usuario->last_name}}</strong>
						</h4>
						<h4><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/empresa.svg')}}">{{$usuario->empresa}}</h4>
						<h4><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/empresa.svg')}}">{{$usuario->document_identificacion->nombre}}: {{$usuario->numero_identificacion}}</h4>
						<h4><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/rol.svg')}}">{{$usuario->roles->nombre}}</h4>
						<h4><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/correo.svg')}}">{{$usuario->email}}</h4>
						<h4><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/celular.svg')}}">{{$usuario->celular}}</h4>
						<h4><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/pais.svg')}}">{{$usuario->pais}}</h3>

							<!-- Conteo de Clientes -->
							@if($usuario->roles_id==3)
							<div class="row m-t-lg">
								<div class="col-md-4">
									<h4><strong>{{$cantidad_tickets_generados}}</strong> Tickets Generados</h4>
								</div>
								<div class="col-md-4">
									<h4><strong> {{$cantidad_tickets_abiertos}} </strong> Tickets Abiertos</h4>
								</div>
								<div class="col-md-4">
									<h4><strong>{{$cantidad_tickets_cerrados}}</strong> Tickets Cerrados</h4>
								</div>
							</div>
							@endif
							<!--Fin Conteo de Clientes -->

						</div>
					</div>
				</div>
				<!-- FIN Vista editar -->

				<!-- Formulario editar -->
				<div class="ibox" id="form_usuario" hidden >
					<div class="ibox-title" style="text-align: right;padding-right: 10px;">
						<button class="btn " id="boton" style="margin-top: 5px;background:#228b2200;" onclick="editar_usuario()"><img alt="image" width="25px"  src="{{asset('multimedia/cancelar.svg')}}">
						</button>
					</div>
					<div>
						@csrf<form action="{{ route('usuario.update',$usuario->id) }}"  enctype="multipart/form-data" method="post">
							@csrf
							@method('PATCH')
							<div class="ibox-content">
								<div class="row">
									<div class="col-sm-12">
										<input type="file" id="archivoInput" width="200px" name="foto" onchange="return validarExt()"  /></center>
										<input type="hidden" name="foto_original" value="{{$usuario->foto}}"  /></center>
										<div id="visorArchivo">
											<!--Aqui se desplegará el fichero-->
											<center ><img style="border-radius: 10px"  name="foto"  src="{{asset('multimedia/users/')}}/{{ $usuario->foto }}" width="200px" />
											</center>
										</div>
									</div>

								</div>
							</div>
							<div class="ibox-content profile-content">
								<div class="row">
									<div class="col-sm-12" align="center" >
										<select class="form-control" style="height:45px;width: 200px" name="estado_activo">
											<option value="{{$usuario->estado_activo}}">{{$usuario->estado->nombre}}</option>
											@foreach($estado as $estados)
											<option value="{{$estados->id}}">{{$estados->nombre}}</option>
											@endforeach
										</select>
									</div>
									<div class="col-sm-2"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/identificacion.svg')}}"></div>
									<div class="col-sm-10"><input name="name" type="text" class="form-control" value="{{$usuario->name}}"></div>
									<div class="col-sm-2"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/identificacion.svg')}}"></div>
									<div class="col-sm-10"><input name="last_name" type="text" class="form-control" value="{{$usuario->last_name}}"></div>
									<div class="col-sm-2"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/empresa.svg')}}"></div>
									<div class="col-sm-10"><input name="empresa" type="text" class="form-control" value="{{$usuario->empresa}}"></div>

									<div class="col-sm-2"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/empresa.svg')}}"></div>
									<div class="col-sm-10">
										<div class="row">
											<div class="col-sm-4">
												<select name="documento_identificacion"  class="form-control" style="height: 36px;">
													@foreach($documento_identificacion as $documento_identificacions)
													<option value="{{$documento_identificacions->id}}"  @if($documento_identificacions->id==$usuario->documento_identificacion) selected="" @endif>{{$documento_identificacions->nombre}}</option>
												@endforeach</select>
											</div>
											<div class="col-sm-8" style="margin-left:0px ;">
												<input name="numero_identificacion" type="text" class="form-control" value="{{$usuario->numero_identificacion}}">
											</div>
										</div>
									</div>

									<div class="col-sm-2"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/rol.svg')}}"></div>
									<div class="col-sm-10">
										<select class="form-control" style="height:45px" name="roles_id">
											<option value="{{$usuario->roles_id}}">{{$usuario->roles->nombre}}</option>
											@foreach($roles as $rol)
											<option value="{{$rol->id}}">{{$rol->nombre}}</option>
											@endforeach
										</select>
									</div>
									<div class="col-sm-2"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/correo.svg')}}"></div>
									<div class="col-sm-10"><input name="email" type="text" class="form-control" value="{{$usuario->email}}"></div>
									<div class="col-sm-2"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/celular.svg')}}"></div>
									<div class="col-sm-10"><input name="celular" type="text" class="form-control"value="{{$usuario->celular}}"></div>
									<div class="col-sm-2"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/pais.svg')}}"></div>
									<div class="col-sm-10">
										<select class="form-control" style="height:45px" name="pais">
											<option value="{{$usuario->pais}}">{{$usuario->pais}}</option>
											@foreach($paises as $pais)
											<option value="{{$pais->nombre}}">{{$pais->nombre}}</option>
											@endforeach
										</select>
									</div>

									<div class="col-md-12" align="center">
										<button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-save"></i> Guardar</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- FIN Formulario editar -->

			</div>

			<div class="col-md-8">
				<div class="ibox ">
					<div class="ibox-title">
						<h5>Tickets Generados</h5>
					</div>
					<div class="ibox-content">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover dataTables-example" >
								<thead>
									<tr>
										<th>Codigo</th>
										<th>Asunto</th>
										<th>Motivo</th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@if($usuario->roles_id==3)
									@foreach($tickets_cliente as $tickets_agregados)
									<tr class="gradeX">
										<td>{{$tickets_agregados->codigo_ticket}}</td>
										<td>{{$tickets_agregados->asunto}}</td>
										<td>{{$tickets_agregados->motivo->nombre}}</td>
										<td>@if($tickets_agregados->estado_resuelto==1) <span class="label label-default">Cerrado</span> @else <span class="label label-primary">Abierto</span> @endif</td>
										<td><a href="{{ route('tickets.show', $tickets_agregados->id) }}"><button type="button" class="btn btn-s-m btn-primary">Ver</button></a></td>
									</tr>
									@endforeach
									@else
									@foreach($tickets_trabajador as $tickets_agregados)
									<tr class="gradeX">
										<td>{{$tickets_agregados->codigo_ticket}}</td>
										<td>{{$tickets_agregados->asunto}}</td>
										<td>{{$tickets_agregados->motivo->nombre}}</td>
										<td>@if($tickets_agregados->estado_resuelto==1) <span class="label label-default">Cerrado</span> @else <span class="label label-primary">Abierto</span> @endif</td>
										<td><a href="{{ route('tickets.show', $tickets_agregados->id) }}"><button type="button" class="btn btn-s-m btn-primary">Ver</button></a></td>
									</tr>
									@endforeach
									@endif
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

	<!-- foto previzualizar-->
	<script type="text/javascript">
		function validarExt()
		{
			var archivoInput = document.getElementById('archivoInput');
			if (archivoInput.files && archivoInput.files[0])
			{
				var visor = new FileReader();
				visor.onload = function(e)
				{
					document.getElementById('visorArchivo').innerHTML =
					'<center><img name="foto" src="'+e.target.result+' "width="200px" style="border-radius: 10px;" /></center>';
				};
				visor.readAsDataURL(archivoInput.files[0]);
			}
		}
	</script>
	<!-- FIN foto previzualizar-->
	<!-- Formulario Cambio de vista a Formulario-->
	<script>
		function editar_usuario() {
			var vista_usuario = document.getElementById("vista_usuario");
			var form_usuario = document.getElementById("form_usuario");
			var boton=document.getElementById("boton");

			if( vista_usuario.hasAttribute("hidden") )
			{
				vista_usuario.removeAttribute("hidden", "");
				boton.innerHTML='<img alt="image" width="25px"  src="{{asset('multimedia/editar.svg')}}">';
				form_usuario.setAttribute("hidden", "");
			}
			else{
				vista_usuario.setAttribute("hidden", "");
				boton.innerHTML='<img alt="image" width="25px"  src="{{asset('multimedia/cancelar.svg')}}">';
				form_usuario.removeAttribute("hidden", "");

			}
		}
	</script>
	<!-- Fin Formulario Cambio de vista a Formulario-->
	@endsection