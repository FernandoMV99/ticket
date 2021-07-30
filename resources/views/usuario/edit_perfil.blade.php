@extends('menu.layout')
@section('img_title', 'user.svg')
@section('title', 'Usuario/Ver')
@section('atributo1', 'hidden')
@section('content')
<style>
	.iconos_perfil{padding-bottom: 8px;padding-right: 5px;padding-top: 10px}
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




		<div @if($usuario->roles_id==3) class="col-md-6" @else class="col-md-12" @endif>
			<!-- Vista editar -->
			<div class="ibox" id="vista_usuario">
				<div class="ibox-title" style="text-align: right;padding-right: 10px;">
					@if($usuario->estado_confirmado==1)<button class="btn " id="boton" style="margin-top: 5px;background:#228b2200;" onclick="editar_usuario()"><img alt="image" width="25px"  src="{{asset('multimedia/editar.svg')}}">
					</button>@endif
				</div>
				<div>
					<div class="ibox-content">
						<center><img alt="image" width="200px"  style="border-radius: 10px" src="{{asset('multimedia/users/')}}/{{ $usuario->foto }}"></center>
					</div>

					<div class="ibox-content profile-content">
						@if($usuario->estado_confirmado==2)
						<p class="font-bold  alert alert-success m-b-sm" style="">
							se envio el codigo de confirmacion a "{{$usuario->email2}}", Si aun no recibes el Codigo: <a href="#">Reenviar</a>
						</p>
						<form action="{{ route('usuario.confirmar_email') }}"  enctype="multipart/form-data" method="post">
							@csrf
							<input  name="email_actual" type="hidden" hidden value="{{$usuario->email}}">
							<input type="hidden" hidden="" name="email" class="form-control" value="{{$usuario->email2}}">
							<div class="row">
								<div class="col-sm-1"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/correo.svg')}}"></div>
								<div class="col-sm-4"><input type="" disabled=""  class="form-control" value="{{$usuario->email2}}">
								</div>
								<div class="col-sm-1"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/codigo_confirmacion.svg')}}"></div>
								<div class="col-sm-4"><input type="text" name="codigo" class="form-control" data-mask="999-999-999" placeholder=""></div>
								<div class="col-sm-2"><button type="submit" name="boton_conf" value="confirmar" class="btn btn-primary">Confirmar</button></div>

								<div class="col-md-1"><button type="submit" name="boton_conf" value="restaurar" class="btn btn-info">Restaurar</button></div>
								<div class="col-md-2"><input  disabled="" class="form-control"  style="width: 200px;display: inline;" value="{{$usuario->email}}"></div>
							</div>
						</form>
						@elseif($usuario->estado_confirmado==1)
						@if($usuario->estado_activo==1) <span class="label label-info">Activo</span> @else <span class="label label-default">Desactivo</span> @endif
						<div class="row">
							<div class="col-md-1"><img alt="image" width="30px" class="iconos_perfil" src="{{asset('multimedia/identificacion.svg')}}"></div>
							<div class="col-md-5" style="font-size: 15px;padding-top: 10px">{{$usuario->name}} {{$usuario->last_name}}</div>
							<div class="col-md-1"><img alt="image" width="30px" class="iconos_perfil" src="{{asset('multimedia/empresa.svg')}}"></div>
							<div class="col-md-5" style="font-size: 15px;padding-top: 10px"> {{$usuario->empresa}}</div>
							<div class="col-md-1"><img alt="image" width="30px" class="iconos_perfil" src="{{asset('multimedia/rol.svg')}}"></div>
							<div class="col-md-5" style="font-size: 15px;padding-top: 10px">{{$usuario->roles->nombre}}</div>
							<div class="col-md-1"><img alt="image" width="30px" class="iconos_perfil" src="{{asset('multimedia/correo.svg')}}"></div>
							<div class="col-md-5" style="font-size: 15px;padding-top: 10px">{{$usuario->email}}</div>
							<div class="col-md-1"><img alt="image" width="30px" class="iconos_perfil" src="{{asset('multimedia/celular.svg')}}"></div>
							<div class="col-md-5" style="font-size: 15px;padding-top: 10px">{{$usuario->celular}}</div>
							<div class="col-md-1"><img alt="image" width="30px" class="iconos_perfil" src="{{asset('multimedia/pais.svg')}}"></div>
							<div class="col-md-5" style="font-size: 15px;padding-top: 10px">{{$usuario->pais}}</div>
						</div>
						@endif

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
					<form action="{{ route('usuario.update',$usuario->id) }}" onkeypress="return anular(event)" enctype="multipart/form-data" method="post" id="formulario_usuario">
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
								<div class="col-sm-1"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/identificacion.svg')}}"></div>
								<div class="col-sm-5"><input name="name" id="idnombre" type="text" class="form-control" value="{{$usuario->name}}"></div>
								<div class="col-sm-1"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/identificacion.svg')}}"></div>
								<div class="col-sm-5"><input name="last_name" type="text" class="form-control" value="{{$usuario->last_name}}"></div>
								<div class="col-sm-1"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/empresa.svg')}}"></div>
								<div class="col-sm-5"><input name="empresa" type="text" class="form-control" value="{{$usuario->empresa}}"></div>
								<div class="col-sm-1"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/correo.svg')}}"></div>
								<div class="col-sm-5"><input name="email" type="text" class="form-control" value="{{$usuario->email}}"></div>
								<div class="col-sm-1"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/celular.svg')}}"></div>
								<div class="col-sm-5"><input name="celular" type="text" class="form-control"value="{{$usuario->celular}}"></div>
								<div class="col-sm-1"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/pais.svg')}}"></div>
								<div class="col-sm-5">
									<select class="form-control" style="height:45px" name="pais">
										@foreach($paises as $pais)
										<option value="{{$pais->nombre}}" @if($usuario->pais==$pais->nombre) selected="" @endif>{{$pais->nombre}}</option>
										@endforeach
									</select>
								</div>
								<input type="hidden" name="accion" value="editar_datos">
								<div class="col-sm-6" align="center" >
									<button type="submit" class="btn btn-primary "  style="width: 200px"><i class="fa fa-save"></i> Guardar</button>
								</div>
							</form>
						{{-- </div>
						</div> --}}
						<form onkeypress="return anular(event)" enctype="multipart/form-data" method="post" id="contrasena">
							@csrf
							@method('PATCH')
							<div class="col-sm-6">
								<div class="row">
									<input type="hidden" name="accion" value="envio_codigo">

									<div class="col-sm-2"><img alt="image" width="25px" class="iconos_perfil_form" src="{{asset('multimedia/contraseña.svg')}}"></div>

									{{--Botones de Cambiar Contraseña  --}}
									<div class="col-sm-5">
										<button type="button" id="button_si_envia_correo"  style="margin-bottom: 10px"  data-target="#CambiarContrasena" data-toggle="modal" onclick="CambiarContra()" class="btn btn-info">Cambiar Contraseña</button>
										<button type="button" id="button_no_envia_correo"  style="margin-bottom: 10px;display:none"  data-target="#CambiarContrasena" data-toggle="modal" class="btn btn-info">Cambiar Contraseña</button>
									</div>
									{{-- Botones de Cambiar Contraseña --}}

								</div>
							</div>
						</div>
					</div>
				</form>
				{{-- modal codigo --}}

				<div class="modal inmodal fade" id="CambiarContrasena" tabindex="-1" role="dialog"  aria-hidden="true" >
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header" >
								<h4 class="modal-title">Cambiar Contraseña</h4>
							</div>
							<form  action="{{ route('usuario.update',$usuario->id) }}" id="formulario_validar_cod" action="" onkeypress="return anular(event)"  enctype="multipart/form-data" method="post" >
								@csrf
								@method('PATCH')
								<div class="modal-body">
									<div id="divmsg"  style="display:none"  class="alert alert-danger" role="alert"></div>

									<input type="text" name="codigo" class="form-control" required="" required="" id="input_codigo" data-mask="999-999-999" placeholder="123-456-789"><br>
									<p id="mensaje_reenvio">No Recibiste el Codigo? <strong><span id="cronometro" style="color: green">129</span>s</strong></p>
									<input class="form-control" type="text" name="contrasena" required="" id="input_nueva_contraseña" placeholder="Escriba Su Nueva Contraseña" style="display:none">
								</div>
								<div class="modal-footer">
									<input type="hidden" name="accion" value="validar_codigo">

									<button type="button" class="btn btn-primary"  id="boton_codigo" onclick="ValidarCod()" >validar</button>
									<button type="submit" class="btn btn-primary" style="display:none"  id="boton_guardar">Guardar</button>

								</div>
							</form>
						</div>

					</div>
				</div>
				<script>


				</script>

				{{-- Fin modal codigo --}}
				<script type="text/javascript" >
					function anular(e) {
						tecla = (document.all) ? e.keyCode : e.which;
						return (tecla != 13);
					}
				</script >
				<script>
					let h1 = document.getElementById('cronometro');
					let centecimos = 0;
					let segundos = 129;

					function run(){
						if((centecimos == 0) &&( segundos == 0)){h1.style.color = 'red';}
						else{
							if(centecimos == 0){
								--segundos;
								centecimos = 99;
							}else{
								--centecimos;
							}
							h1.innerHTML = segundos ;
						}
					}
					function CambiarContra(){

						var url = "{{ route('usuario.update',$usuario->id) }}";
						$.ajax({
							type:'POST',
							url:url,
							data:$('#contrasena').serialize(),
							success: function(registro){
								var alerta=(registro.mensaje);
								setInterval(run, 10);
							}
						});
						return false;
					}
				</script>
			</div>
		</div>
		<script>
			function ValidarCod(){
				var urls = "{{ route('usuario.update',$usuario->id) }}";
				$.ajax({
					type:'POST',
					url:urls,
					data:$('#formulario_validar_cod').serialize(),
					success: function(registros){
						var codigo_contra=(registros.mensaje);
						var input_codigo=$("#input_codigo").val();
						if (input_codigo!=codigo_contra) {
											 $("#divmsg").empty(); //limpiar div
											 $("#divmsg").append("<p>Codigo Erroneo, Verifique bien su Codigo</p>");
											 $("#divmsg").show(400);
											 $("#divmsg").hide(8000);
											}
											else{
												$("#input_nueva_contraseña").show(500);
												$("#boton_guardar").show(500);

												$("#input_codigo").hide(0);
												$("#boton_codigo").hide(0);

												$("#button_si_envia_correo").hide(0);
												$("#button_no_envia_correo").show(0);

												$("#mensaje_reenvio").hide(0);

											}
										}
									});
				return false;
			}
		</script>
		<!-- FIN Formulario editar -->
	</div>

	<!-- Conteo de Clientes -->
	@if($usuario->roles_id==3)
	<div class="col-md-6" >

		<div class="ibox" id="vista_usuario">

			<div class="ibox-content profile-content">

				<div class="row">
					<div class="col-lg-12">
						<div class="row ">
							<div class="col-sm-12"><center><img alt="image" style="width: 100px" src="{{asset('multimedia/ticket2.svg')}}"></center></div>
							<div class="col-sm-3"><h4>Tickets Generados</h4></div>
							<div class="col-sm-2"><h4>:</h4></div>
							<div class="col-sm-7"><h4><strong>{{$cantidad_tickets_generados}} Tickets</strong> </h4></div>

							<div class="col-sm-3"><h4> Tickets Abiertos</h4></div>
							<div class="col-sm-2"><h4>:</h4></div>
							<div class="col-sm-7"><h4><strong> {{$cantidad_tickets_abiertos}} Tickets</strong> </h4></div>

							<div class="col-sm-3"><h4>Tickets Cerrados</h4></div>
							<div class="col-sm-2"><h4>:</h4></div>
							<div class="col-sm-7"><h4><strong>{{$cantidad_tickets_cerrados}} Tickets</strong></h4></div>
						</div>
					</div>
					{{-- <div class="col-lg-6">
						<div class="row">
							<div class="col-sm-12"><center><img alt="image" style="width: 100px" src="{{asset('multimedia/productos_web.svg')}}"></center></div>
							<div class="col-sm-5"><h4>Dominios Comprados</h4></div>
							<div class="col-sm-2"><h4>:</h4></div>
							<div class="col-sm-5"><h4><strong>{{$cantidad_tickets_generados}} Dominios</strong> </h4></div>

							<div class="col-sm-5"><h4>Dominios Caducados</h4></div>
							<div class="col-sm-2"><h4>:</h4></div>
							<div class="col-sm-5"><h4><strong> {{$cantidad_tickets_abiertos}} Dominios</strong> </h4></div>

							<div class="col-sm-5"><h4>Hosting Comprados</h4></div>
							<div class="col-sm-2"><h4>:</h4></div>
							<div class="col-sm-5"><h4><strong>{{$hosting}} Hosting</strong></h4></div>

							<div class="col-sm-5"><h4>Hosting Caducados</h4></div>
							<div class="col-sm-2"><h4>:</h4></div>
							<div class="col-sm-5"><h4><strong>{{$hosting_suspendidos}} Hosting</strong></h4></div>
						</div>
					</div> --}}
				</div>
			</div>
		</div>
	</div>
	@endif
	<!--Fin Conteo de Clientes -->

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
<!-- Input Mask NUMERO DE CONFIRMACION-->
<script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>

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