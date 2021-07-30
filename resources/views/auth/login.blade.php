<!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Ladda style -->
        <link href="{{ asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
        <title>Ticket-Entrar</title>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
          <style type="text/css">
/*@import url('https://fonts.googleapis.com/css?family=Numans');
https://images2.alphacoders.com/361/thumb-1920-36170.jpg
*/
html,body{
    background-image: url("{{ asset('multimedia/fondo_playa.jpeg') }}");
    background-size: cover;
    background-repeat: no-repeat;
    height: 100%;
    font-family: 'Numans', sans-serif;
}
.pt-4, .py-4{
    padding-top: 10% !important;
}
.container{
    height: 100%;
    align-content: center;
}

.card{
    height: 370px;
    margin-top: auto;
    margin-bottom: auto;
    width: 400px;
    background-color: rgba(0,0,0,0.5) !important;
}

.social_icon span{
    font-size: 60px;
    margin-left: 10px;
    color: #3F7B26;
}

.social_icon span:hover{
    color: white;
    cursor: pointer;
}

.card-header h3{
    color: white;
}

.social_icon{
    position: absolute;
    right: 20px;
    top: -45px;
}

.input-group-prepend span{
    width: 50px;
    background-color: #3F7B26;
    color: black;
    border:0 !important;
}

input:focus{
    outline: 0 0 0 0  !important;
    box-shadow: 0 0 0 0 !important;
}
.remember{color: white;}
.remember input
{ width: 15px;
    height: 15px;
    margin-left: 15px;
    margin-right: 5px;
}

.login_btn{
    color: black;
    background-color: #3F7B26;
    width: 100px;
}

.login_btn:hover{
    color: black;
    background-color: white;
}

.links{
    color: white;
}

.links a{
    margin-left: 4px;
}
.cwhite{
  color: white;
}
.letra{
    font-family: Arial, Helvetica, sans-serif;
}
</style>

    </head>
    <body>

        <div class="container">
            <div class="d-flex justify-content-center h-100">
                <div class="card">
                    <div class="card-header">
                        <center><h3 class="letra">Iniciar Sesion</h3></center>

                    </div>
                    <div class="card-body"  >
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img src="{{ asset('multimedia/perfil.svg') }}" width="25px"> </span>
                                </div>
                                <!-- <input type="text" class="form-control" placeholder="Nombre Usuario" > -->
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Nombre Usuario">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div><style>.input-group-text{background-color: #16ffe9a6 !important}</style>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img src="{{ asset('multimedia/pasword.svg') }}" width="25px"> </span>
                                </div>
                                <!-- <input type="password" class="form-control" placeholder="contraseña" > -->
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"  placeholder="contraseña">

                                @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>


                            <center>
                                <div class="form-group " >
                                    <button type="submit" class="ladda-button btn btn-info" data-style="zoom-out"> {{ __('Ingresar') }}</button><br>
                                </div>
                            </center>
                        </form>
                    </div>
                    <div class="card-footer">
                        {{-- <div class="d-flex justify-content-center links">
                            No tienes una Cuenta?<a  href="{{ route('register') }}" style="color: blue">{{ __('Registrar') }}</a>
                        </div> --}}
                       {{--  <div class="d-flex justify-content-center">
                           @if (Route::has('password.request'))
                           <a  href="{{ route('password.request') }}" style="color: white">{{ __('¿Olvidaste tu contraseña?') }}</a>
                           @endif
                       </div> --}}
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

<!-- Ladda -->
<script src="{{ asset('js/plugins/ladda/spin.min.js')}}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.min.js')}}"></script>
{{-- <script src="js/plugins/ladda/ladda.jquery.min.js"></script> --}}

<script>
    $(document).ready(function (){
        // Bind normal buttons
        Ladda.bind( '.ladda-button',{ timeout: 10000 });
    });
</script>
<!-- Notificacion de Errores -->
{{-- @if($errors->any())
@foreach ($errors->all() as $error)
<link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: false,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            toastr.info('Acabas de Cambiar tu Contraseña: Inicia Session');
        }, 0);
    });
</script>
@endforeach
@endif --}}
<!-- FIN Notificacion de Errores -->
</body>


</html>
