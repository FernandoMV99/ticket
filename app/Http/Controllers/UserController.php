<?php
namespace App\Http\Controllers;
use App\DocumentoIdentificacion;
use App\Empresa;
use App\Estado;
use App\Hosting;
use App\Motivo;
use App\Paises;
use App\Roles;
use App\TicketsAgregado;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Swift_Attachment;
use Swift_MailTransport;
use Swift_Mailer;
use Swift_Message;
use Swift_Preferences;
use Swift_SmtpTransport;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->roles_id == 3){return back();}/*Clientes no entran*/
        $usuarios=User::where('id','!=',auth()->user()->id)->get();
        $roles=Roles::all();
        $paises=Paises::all();
        $documento_iden=DocumentoIdentificacion::where('estado',0)->get();
        $item=1;
        return view('usuario.index',compact('usuarios','roles','paises','item','documento_iden'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function crear($id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario_logeado=auth()->user()->id;
        $numero_validacion=rand(100000000, 900000000) ;
        $codigo_1 = substr($numero_validacion, 0, 3);
        $codigo_2 = substr($numero_validacion, 3, 3);
        $codigo_3 = substr($numero_validacion, 6, 3);
        $codigo_confirmacion=$codigo_1.'-'.$codigo_2.'-'.$codigo_3;/*Codigo unido */

        $contrasena_generada=bin2hex(random_bytes(5));

        $empresa=Empresa::first();

        $nombre_empresa=$empresa->nombre;
        $correo_empresa=$empresa->correo;
        $contraseña_empresa=$empresa->contrasena;
        $encryption=$empresa->encryption;
        $smpt=$empresa->smpt;
        $puerto=$empresa->puerto;

        $correo_envio=$request->get('email');

        $asunto_mensaje='ENVIO DE CREDENCIALES';

        $this->validate($request,[
            'email' => ['required','email','unique:users,email'],
        ],[
            'email.unique' => 'El correo ya existe',
        ]);

        if($request->hasfile('foto')){
            $image1 =$request->file('foto');
            $nombre_foto =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/multimedia/users/');
            $image1->move($destinationPath,$nombre_foto);
        }else{
            $nombre_foto='usuario.svg';
        }
        $usuarios=new User;
        $usuarios->name=$request->get('name');
        $usuarios->last_name=$request->get('last_name');
        $usuarios->empresa=$request->get('empresa');
        $usuarios->documento_identificacion=$request->get('documento_identificacion');
        $usuarios->numero_identificacion=$request->get('numero_identificacion');
        $usuarios->celular=$request->get('celular');
        $usuarios->pais=$request->get('pais');
        $usuarios->email=$request->get('email');
        $usuarios->roles_id=$request->get('roles_id');
        $usuarios->password=bcrypt($contrasena_generada);
        $usuarios->foto=$nombre_foto;
        $usuarios->codigo_confirmacion=null;
        $usuarios->estado_confirmado='1';/*ACTIVO*/
        $usuarios->estado_activo='1';
        $usuarios->user_registrado=$usuario_logeado;
        $usuarios->save();

        /*Envio de Correo de codigo*/
        $mensaje=  view('html_sms.sms_envio_credenciales',compact('empresa','correo_envio','usuarios','contrasena_generada'));
        $transport=(new Swift_SmtpTransport( $smpt ,$puerto,$encryption))->setUsername($correo_empresa)->setPassword($contraseña_empresa);
        $mailer = new Swift_Mailer($transport);
        $message = (new Swift_Message($asunto_mensaje))->setFrom([$correo_empresa=> $nombre_empresa])->setTo([$correo_envio])->setBody($mensaje, 'text/html');
        $result = $mailer->send($message);
        /*Fin Envio de Correo de codigo*/

        return redirect()->route('usuario.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (auth()->user()->roles_id == 3){return back();}/*Clientes no entran*/
        if ($id == auth()->user()->id ){return redirect()->route('usuario.edit',$id);}/*el mismo usuario no puede entrar*/

        $usuario=User::where('id',$id)->first();
        $cantidad_tickets_generados=TicketsAgregado::where('cliente',$id)->count();
        $cantidad_tickets_abiertos=TicketsAgregado::where('cliente',$id)->where('estado_resuelto','0')->count();
        $cantidad_tickets_cerrados=TicketsAgregado::where('cliente',$id)->where('estado_resuelto','1')->count();
        $tickets_cliente=TicketsAgregado::where('cliente',$id)->get();
        $tickets_trabajador=TicketsAgregado::where('trabajador',$id)->get();
        $roles=Roles::all();
        $documento_identificacion=DocumentoIdentificacion::all();
        $paises=Paises::all();
        $estado=Estado::where('id', '!=' ,$usuario->estado_activo)->get();
        return view('usuario.show',compact('usuario','cantidad_tickets_generados','cantidad_tickets_abiertos','cantidad_tickets_cerrados','tickets_cliente','tickets_trabajador','roles','paises','estado','documento_identificacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   /*Editar Perfil Logeado*/
        if (auth()->user()->id != $id){return back();}/*solo Usuario Logeado*/
        $usuario=User::where('id',$id)->first();
        $cantidad_tickets_generados=TicketsAgregado::where('cliente',$id)->count();
        $cantidad_tickets_abiertos=TicketsAgregado::where('cliente',$id)->where('estado_resuelto','0')->count();
        $cantidad_tickets_cerrados=TicketsAgregado::where('cliente',$id)->where('estado_resuelto','1')->count();
        $hosting=Hosting::where('cliente',$id)->where('estado','0')->count();
        $hosting_suspendidos=Hosting::where('cliente',$id)->where('estado','1')->where('estado_anulado','0')->count();
        $paises=Paises::all();
        if (auth()->user()->roles_id ==3 ) {
        return view('usuario.edit_perfil_cliente',compact('hosting','hosting_suspendidos','usuario' ,'cantidad_tickets_generados','cantidad_tickets_abiertos','cantidad_tickets_cerrados','paises'));
        }
        else{
        return view('usuario.edit_perfil',compact('hosting','hosting_suspendidos','usuario' ,'cantidad_tickets_generados','cantidad_tickets_abiertos','cantidad_tickets_cerrados','paises'));

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $usuario_edit=User::where('id',$id)->first();
        $accion=$request->get('accion');

        /*Codigo Aleatorio*/
        $numero_validacion=rand(100000000, 900000000) ;
        $codigo_1 = substr($numero_validacion, 0, 3);
        $codigo_2 = substr($numero_validacion, 3, 3);
        $codigo_3 = substr($numero_validacion, 6, 3);
        $codigo_confirmacion=$codigo_1.'-'.$codigo_2.'-'.$codigo_3;/*Codigo unido */
        /*Fin Codigo Aleatorio*/

        /*config mensaje gmail*/
        $empresa=Empresa::first();
        $asunto_mensaje='CODIGO DE VALIDACION';
        $nombre_empresa=$empresa->nombre;
        $correo_empresa=$empresa->correo;
        $contraseña_empresa=$empresa->contrasena;
        $encryption=$empresa->encryption;
        $smpt=$empresa->smpt;
        $puerto=$empresa->puerto;

        /* Fin config mensaje gmail*/

        $correo_usuario=$request->get('email');

        $correo_repetido=User::where('email',$correo_usuario)->first();

        $codigo=$request->get('codigo');

        if ($accion=='envio_codigo') {

            $usuarios=User::find($id);
            $usuarios->codigo_confirmacion=$codigo_confirmacion;
            $usuarios->save();

            /*Envio de Correo de codigo*/
            $mensaje=  view('html_sms.sms_cod_confirmacion_cambio_contrasena',compact('empresa','usuario_edit','codigo_confirmacion'));
            $transport=(new Swift_SmtpTransport( $smpt ,$puerto,$encryption))->setUsername($correo_empresa)->setPassword($contraseña_empresa);
            $mailer = new Swift_Mailer($transport);
            $message = (new Swift_Message($asunto_mensaje))->setFrom([$correo_empresa=> $nombre_empresa])->setTo([$usuario_edit->email])->setBody($mensaje, 'text/html');
            $result = $mailer->send($message);
            return response()->json(['mensaje'=>'Se envio biewn']);

            /*Fin Envio de Correo de codigo*/
        }

        elseif ($accion=='validar_codigo') {
            $contrasena=$request->get('contrasena');
            if (isset($contrasena)) {
                $contrasena=$request->get('contrasena');

                $usuarios=User::find($id);
                $usuarios->password=bcrypt($contrasena);
                $usuarios->codigo_confirmacion=NULL;
                $usuarios->save();
                Auth::logout();
                return Redirect::to('/login')->withErrors(['Acabas de Cambiar Contraseñan: Inicia Session Nuevamente']);
            }else{
                return response()->json(['mensaje'=>$usuario_edit->codigo_confirmacion]);
            }
        }

        elseif ($accion=='editar_datos') {
         if ($usuario_edit->email!=$correo_usuario) {

            if (isset($correo_repetido) ) {
              $this->validate($request,[
                'email' => ['required','email','unique:users,email'],
            ],[
                'email.unique' => 'El correo ya existe',
            ]);
          }
          else{
            $usuarios=User::find($id);
            $usuarios->email2=$request->get('email');
            $usuarios->estado_confirmado=2;
            $usuarios->codigo_confirmacion=$codigo_confirmacion;
            $usuarios->save();

            /*Envio de Correo de codigo*/
            $mensaje=  view('html_sms.sms_cod_confirmacion',compact('empresa','usuario_edit','codigo_confirmacion'));
            $transport=(new Swift_SmtpTransport( $smpt ,$puerto,$encryption))->setUsername($correo_empresa)->setPassword($contraseña_empresa);
            $mailer = new Swift_Mailer($transport);
            $message = (new Swift_Message($asunto_mensaje))->setFrom([$correo_empresa=> $nombre_empresa])->setTo([$correo_usuario])->setBody($mensaje, 'text/html');
            $result = $mailer->send($message);
            /*Fin Envio de Correo de codigo*/

            return redirect()->route('usuario.show', $id);
        }
    }
}


$roles=$request->get('roles_id');
if($request->hasfile('foto')){
    $image1 =$request->file('foto');
    $nombre_foto =time().$image1->getClientOriginalName();
    $destinationPath = public_path('/multimedia/users/');
    $image1->move($destinationPath,$nombre_foto);
}else{
    $nombre_foto=$request->get('foto_original');
}
$usuarios=User::find($id);
$usuarios->name=$request->get('name');
$usuarios->last_name=$request->get('last_name');
$usuarios->empresa=$request->get('empresa');
$usuarios->documento_identificacion=$request->get('documento_identificacion');
$usuarios->numero_identificacion=$request->get('numero_identificacion');
$usuarios->celular=$request->get('celular');
$usuarios->pais=$request->get('pais');
$usuarios->email=$request->get('email');
$usuarios->foto=$nombre_foto;
if (isset($roles)) {
    $usuarios->estado_confirmado=$request->get('estado_activo');/*Activo Desactivo*/
    $usuarios->roles_id=$request->get('roles_id');
    $usuarios->estado_activo=$request->get('estado_activo');}
    $usuarios->save();
    return redirect()->route('usuario.show', $id);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmar_email(Request $request)
    {
     /*config mensaje gmail*/
     $empresa=Empresa::first();
     $asunto_mensaje='BIENVENIDO NUEVAMENTE';
     $nombre_empresa=$empresa->nombre;
     $correo_empresa=$empresa->correo;
     $contraseña_empresa=$empresa->contrasena;
     $encryption=$empresa->encryption;
     $smpt=$empresa->smpt;
     $puerto=$empresa->puerto;
     /* Fin config mensaje gmail*/

     $boton=$request->get('boton_conf');
     $user=auth()->user()->id;
     $email=$request->get('email_actual');
     $usuario=User::where('id',$user)->first();
     $email_registrado=User::where('email',$usuario->email2)->first();

     if (isset($email_registrado)) {
        $usuarios=User::find($user);
        $usuarios->email2=NULL;
        $usuarios->estado_confirmado='1';
        $usuarios->codigo_confirmacion=NULL;
        $usuarios->save();
        $this->validate($request,['email' => ['required','email','unique:users,email'],],
            ['email.unique' => 'El correo ya esta Registrado, Intenta con otro correo.',]);

        return redirect()->route('usuario.edit',$user);

    }

    if ($boton=='confirmar') {

        /*Recibiendo Datos*/
        $codigo=$request->get('codigo');
        $codigo_usuario=$usuario->codigo_confirmacion;

        if ($codigo == $codigo_usuario) {
           $usuarios=User::find($user);
           $usuarios->email=$usuario->email2;
           $usuarios->email2=NULL;
           $usuarios->estado_confirmado='1';
           $usuarios->codigo_confirmacion=NULL;
           $usuarios->save();

           /*Envio de Correo de codigo*/
           $mensaje=  view('html_sms.sms_bienvenida',compact('empresa','usuarios'));
           $transport=(new Swift_SmtpTransport( $smpt ,$puerto,$encryption))->setUsername($correo_empresa)->setPassword($contraseña_empresa);
           $mailer = new Swift_Mailer($transport);
           $message = (new Swift_Message($asunto_mensaje))->setFrom([$correo_empresa=> $nombre_empresa])->setTo([$usuarios->email])->setBody($mensaje, 'text/html');
           $result = $mailer->send($message);
           /*Fin Envio de Correo de codigo*/

           return redirect()->route('usuario.edit',$user);
       }


   }elseif ($boton=='restaurar') {
      $usuarios=User::find($user);
      $usuarios->email2=NULL;
      $usuarios->estado_confirmado='1';
      $usuarios->codigo_confirmacion=NULL;
      $usuarios->save();
      return redirect()->route('usuario.edit',$user);
  }
}

}
