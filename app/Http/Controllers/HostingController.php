<?php
namespace App\Http\Controllers;
use App\AlertasCorreo;
use App\Dominios;
use App\Empresa;
use App\Hosting;
use App\Moneda;
use App\Motivo;
use App\PlanHosting;
use App\ProveedorDominios;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Swift_Attachment;
use Swift_MailTransport;
use Swift_Mailer;
use Swift_Message;
use Swift_Preferences;
use Swift_SmtpTransport;
class HostingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // if (auth()->user()->roles_id == 3){return back();}/*Clientes no entran*/
      $user_logeado=auth()->user();

      $hosting_cliente=Hosting::where('cliente',$user_logeado->id)->where('estado_anulado',0)->get();
      $hosting=Hosting::all();
      $plan_hosting=PlanHosting::where('estado',1)->get();

      $dominios=Dominios::where('estado',0)->get();
      $clientes=User::orderBy('name')->where('roles_id','3')->get();

      foreach ($hosting as $hostings) {
        $date = $hostings->fecha_vencimiento."+ 1 days";
        $datework = Carbon::createFromDate($date);
        $now = Carbon::now();
        if ($datework>$now) {$testdate=$now->diffInDays($datework);}
        else{$testdate= 0;}

        if ($testdate<1){$estado='1';}
        else{$estado='0';}

            //Cambio de Estado
        if ($hostings->estado_anulado=='0') {
          $hostings=Hosting::find($hostings->id);
          $hostings->estado=$estado;
          $hostings-> save();
        }

      }
      /*Clientes*/
      if ($user_logeado->roles_id==3) {
        return view('productos.hosting.hosting.index_cliente',compact('clientes','hosting_cliente','plan_hosting','dominios'));
      }else{
        return view('productos.hosting.hosting.index',compact('clientes','hosting','plan_hosting','dominios'));
      }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user_logeado=auth()->user()->id;
      $dominio=$request->get('dominio');
      $dominio_recortado=substr($dominio, 0, 4);


      if ($dominio_recortado=='www.') {
        $nombre_dominio=$dominio;
      }else{
        $nombre_dominio='www.'.$dominio;
      }
      $hosting_existente=Hosting::where('dominio',$nombre_dominio)->first();

      if (isset($hosting_existente)) {
        return Redirect::to('/hosting')->withErrors(['El Dominio ya esta registrado']);
      }

      $num_anos=$request->get('fecha_vencimiento');
      $fecha_inicio=$request->get('fecha_inicio');
      $date = $fecha_inicio."+ ".$num_anos." years";
      $fecha_vencimiento = Carbon::createFromDate($date);
      $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

      $plan_hosting=PlanHosting::where('id',$request->get('plan_hosting'))->first();
      $precio=$plan_hosting->precio*$num_anos;
      $moneda=$plan_hosting->moneda;

      $hosting= new Hosting;
      $hosting->cliente=$request->get('cliente');
      $hosting->plan_hosting=$request->get('plan_hosting');
      $hosting->fecha_inicio=$request->get('fecha_inicio');
      $hosting->fecha_vencimiento=$fecha_vencimiento;
      $hosting->dominio=$nombre_dominio;
      $hosting->cpanel_usuario=$request->get('cpanel_usuario');
      $hosting->cpanel_password=$request->get('cpanel_password');
      $hosting->cpanel_ip_publica=$request->get('cpanel_ip_publica');
      $hosting->moneda=$moneda;
      $hosting->precio=$precio;
      $hosting->anos=$num_anos;
      $hosting->user_registrado=$user_logeado;
      $hosting-> save();

      /*config mensaje gmail*/
      $empresa=Empresa::first();
      $asunto_mensaje='NOTA DEUDA HOSTING';
      $nombre_empresa=$empresa->nombre;
      $correo_empresa=$empresa->correo;
      $contraseña_empresa=$empresa->contrasena;
      $encryption=$empresa->encryption;
      $smpt=$empresa->smpt;
      $puerto=$empresa->puerto;

      $cliente=User::where('id',$hosting->cliente)->first();

      /* Fin config mensaje gmail*/

       /*Guardando su proximas Notificaciones*/
     $date1 = $fecha_vencimiento."- 15 days";
     $fecha_vencimiento1 = Carbon::createFromDate($date1);
     $fecha_vencimiento1=substr($fecha_vencimiento1, 0, -8);

     $date2 = $fecha_vencimiento."- 7 days";
     $fecha_vencimiento2 = Carbon::createFromDate($date2);
     $fecha_vencimiento2=substr($fecha_vencimiento2, 0, -8);

     $alertas_correo= new AlertasCorreo;
     $alertas_correo->usuario=$hosting->cliente;
     $alertas_correo->fecha1=$fecha_vencimiento1;
     $alertas_correo->fecha2=$fecha_vencimiento2;
     $alertas_correo->fecha3=$hosting->fecha_vencimiento;
     $alertas_correo->nombre_html_sms='sms_nota_deuda_producto';
     $alertas_correo->nombre_modelo='Hosting';
     $alertas_correo->id_registro=$hosting->id;
     $alertas_correo->save();

     /*Guardando su proximas Notificaciones*/


      $email_envio=$request->get('email_envio');
      if ($email_envio==0) {
        /*Envio de Correo de codigo*/
        $mensaje=  view('html_sms.sms_nota_deuda_producto',compact('empresa','hosting','cliente'));
        $transport=(new Swift_SmtpTransport( $smpt ,$puerto,$encryption))->setUsername($correo_empresa)->setPassword($contraseña_empresa);
        $mailer = new Swift_Mailer($transport);
        $message = (new Swift_Message($asunto_mensaje))->setFrom([$correo_empresa=> $nombre_empresa])->setTo([$cliente->email])->setBody($mensaje, 'text/html');
        $result = $mailer->send($message);
      // return response()->json(['mensaje'=>'Se envio biewn']);

        /*Fin Envio de Correo de codigo*/
      }


      return redirect()->route('hosting.index');

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
      $boton=$request->get('boton');

      if ($boton=='Actualizar') {
        $num_anos=$request->get('fecha_vencimiento');
        $fecha_inicio=$request->get('fecha_inicio');
        $date = $fecha_inicio."+ ".$num_anos." years";
        $fecha_vencimiento = Carbon::createFromDate($date);
        $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

        $plan_hosting=PlanHosting::where('id',$request->get('plan_hosting'))->first();
        $hosting_registro=Hosting::where('id',$id)->first();
        $precio=$plan_hosting->precio*$num_anos;
        $plan_hosting_id=$request->get('plan_hosting');

        $hosting=Hosting::find($id);
        $hosting->plan_hosting=$plan_hosting_id;
        $hosting->fecha_vencimiento=$fecha_vencimiento;
        $hosting->cpanel_usuario=$request->get('cpanel_usuario');
        $hosting->cpanel_password=$request->get('cpanel_password');
        $hosting->cpanel_ip_publica=$request->get('cpanel_ip_publica');
        if ($hosting_registro->plan_hosting!=$plan_hosting_id or $hosting_registro->anos!=$num_anos) {
          $hosting->estado_pagado=0;
        }
        $hosting->precio=$precio;
        $hosting->anos=$num_anos;
        $hosting->save();
      }
      elseif ($boton=='Anulado') {
        $dominio=$request->get('dominio');

        $hosting=Hosting::find($id);
        $hosting->dominio=$dominio.'(ANULADO)';
        $hosting->estado='1';
        $hosting->estado_anulado='1';
        $hosting->save();

      }

      elseif ($boton=='Renovar') {
        $plan_hosting=$request->get('plan_hosting');

        $hosting = Hosting::where('id',$id)->first();
        $plan_hosting=PlanHosting::where('id',$plan_hosting)->first();

        $num_años=$request->get('fecha_vencimiento');
        $date = $hosting->fecha_vencimiento."+ ".$num_años." years";
        $fecha_vencimiento = Carbon::createFromDate($date);
        $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

        $hosting_edit=Hosting::find($id);
        $hosting_edit->plan_hosting=$plan_hosting->id;
        $hosting_edit->fecha_inicio=$hosting->fecha_vencimiento;
        $hosting_edit->fecha_vencimiento=$fecha_vencimiento;
        $hosting_edit->anos=$num_años;
        $hosting_edit->precio=$num_años*$plan_hosting->precio;
        $hosting_edit->estado_pagado=0;
        $hosting_edit->save();

      }
      return redirect()->route('hosting.index');

       // $fecha_vencimiento=$request->get('fecha_vencimiento');
       // $num_anos=$request->get('renovar_fecha');
       // $date = $fecha_vencimiento."+ ".$num_anos." years";
       // $fecha_vencimiento = Carbon::createFromDate($date);
       // $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

       // $dominios=Dominios::find($id);
       // $dominios->fecha_vencimiento=$fecha_vencimiento;
       // $dominios->save();
       // return redirect()->route('dominios.index');

    }

  }
