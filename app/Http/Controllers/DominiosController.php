<?php
namespace App\Http\Controllers;
use App\AlertasCorreo;
use App\Dominios;
use App\Empresa;
use App\Moneda;
use App\Motivo;
use App\PlanDominio;
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

class DominiosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $tickets_agregado=TicketsAgregado::all();
      $dominios_cliente=Dominios::where('cliente',auth()->user()->id)->get();
      $plan_dominio=PlanDominio::where('estado',0)->get();
      $dominios=Dominios::all();
      $monedas=Moneda::all();
      $clientes=User::orderBy('name')->where('roles_id','3')->get();
      $proveedores=ProveedorDominios::orderBy('nombre')->where('estado','1')->get();
      foreach ($dominios as $dominio) {
        $date = $dominio->fecha_vencimiento."+ 1 days";
        $datework = Carbon::createFromDate($date);
        $now = Carbon::now();
        if ($datework>$now) {$testdate=$now->diffInDays($datework);}
        else{$testdate= 0;}

        if ($testdate<1){$estado='1';}
        else{$estado='0';}

          //Cambio de Estado
        if ($dominio->estado_anulado=='0') {
         $dominio=Dominios::find($dominio->id);
         $dominio->estado=$estado;
         $dominio-> save();
       }

     }
     if (auth()->user()->roles_id==3) {
      return view('productos.dominios.dominios.index_cliente',compact('dominios','clientes','proveedores','monedas','dominios_cliente'));
    }else{
      return view('productos.dominios.dominios.index',compact('dominios','clientes','proveedores','monedas','dominios_cliente','plan_dominio'));
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
      $usuario_logeado=auth()->user()->id;

      $plan_dominio_id=$request->get('plan_dominio');
      $plan_dominio=PlanDominio::where('id',$plan_dominio_id)->first();

      $num_años=$request->get('fecha_vencimiento');
      $fecha_compra=$request->get('fecha_compra');
      $date = $fecha_compra."+ ".$num_años." years";
      $fecha_vencimiento = Carbon::createFromDate($date);
      $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

      $extencion=$plan_dominio->nombre;
      $nombre_dominio=$request->get('nombre_dominio');

      $nombre_dominio='www.'.$nombre_dominio.'.'.$extencion;
      $this->validate($request,[
        'nombre_dominio' => ['required','unique:dominios,nombre_dominio'],
      ],[
        'nombre_dominio.unique' => 'El Dominio ya esta registrado',
      ]);
      $dominios_existente=Dominios::where('nombre_dominio',$nombre_dominio)->first();
      if (isset($dominios_existente)) {
        return Redirect::to('/dominios')->withErrors(['El Dominio ya esta registrado']);
      }



      $dominios= new Dominios;
      $dominios->cliente=$request->get('cliente');
      $dominios->proveedor=$request->get('proveedor');
      $dominios->fecha_compra=$request->get('fecha_compra');
      $dominios->fecha_vencimiento=$fecha_vencimiento;
      $dominios->nombre_dominio=$nombre_dominio;
      $dominios->precio=$plan_dominio->precio*$num_años;
      $dominios->moneda=$plan_dominio->moneda;
      $dominios->descripcion=$request->get('descripcion');
      $dominios->anos=$num_años;
      $dominios->estado='0';
      $dominios->estado_anulado='0';
      $dominios->plan_domi=$plan_dominio->id;
      $dominios->user_registrado=$usuario_logeado;
      $dominios-> save();


      /*config mensaje gmail*/
      $empresa=Empresa::first();
      $asunto_mensaje='NOTA DEUDA DOMINIO';
      $nombre_empresa=$empresa->nombre;
      $correo_empresa=$empresa->correo;
      $contraseña_empresa=$empresa->contrasena;
      $encryption=$empresa->encryption;
      $smpt=$empresa->smpt;
      $puerto=$empresa->puerto;

      $cliente=User::where('id',$dominios->cliente)->first();

      /* Fin config mensaje gmail*/

        /*Guardando su proximas Notificaciones*/
     $date1 = $fecha_vencimiento."- 15 days";
     $fecha_vencimiento1 = Carbon::createFromDate($date1);
     $fecha_vencimiento1=substr($fecha_vencimiento1, 0, -8);

     $date2 = $fecha_vencimiento."- 7 days";
     $fecha_vencimiento2 = Carbon::createFromDate($date2);
     $fecha_vencimiento2=substr($fecha_vencimiento2, 0, -8);

     $alertas_correo= new AlertasCorreo;
     $alertas_correo->usuario=$dominios->cliente;
     $alertas_correo->fecha1=$fecha_vencimiento1;
     $alertas_correo->fecha2=$fecha_vencimiento2;
     $alertas_correo->fecha3=$dominios->fecha_vencimiento;
     $alertas_correo->nombre_html_sms='sms_nota_deuda_producto';
     $alertas_correo->nombre_modelo='Dominios';
     $alertas_correo->id_registro=$dominios->id;
     $alertas_correo->save();

     /*Guardando su proximas Notificaciones*/


      $email_envio=$request->get('email_envio');
      if ($email_envio==0) {
        /*Envio de Correo de codigo*/
        $mensaje=  view('html_sms.sms_nota_deuda_producto',compact('empresa','dominios','cliente'));
        $transport=(new Swift_SmtpTransport( $smpt ,$puerto,$encryption))->setUsername($correo_empresa)->setPassword($contraseña_empresa);
        $mailer = new Swift_Mailer($transport);
        $message = (new Swift_Message($asunto_mensaje))->setFrom([$correo_empresa=> $nombre_empresa])->setTo([$cliente->email])->setBody($mensaje, 'text/html');

        $result = $mailer->send($message);
      // return response()->json(['mensaje'=>'Se envio biewn']);

        /*Fin Envio de Correo de codigo*/
      }

      return redirect()->route('dominios.index');

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

     if ($boton=='Anulado') {
       $nombre_dominio=$request->get('nombre_dominio');

       $dominio=Dominios::find($id);
       $dominio->nombre_dominio=$nombre_dominio.'(ANULADO)';
       $dominio->estado='1';
       $dominio->estado_anulado='1';
       $dominio->save();

     }
     elseif($boton=='Guardar'){

      $dominio = Dominios::where('id',$id)->first();
      /*No permite hacer cambios si es que antes se a Anulado*/
      if ($dominio->estado_anulado==1) {
       return Redirect::to('/dominios')->withErrors(['El Registro esta Anulado']);
     }
     /*No permite hacer cambios si es que antes se a Anulado*/

     $plan_dominio=PlanDominio::where('id',$dominio->plan_domi)->first();

     $num_años=$request->get('fecha_vencimiento');
     $date = $dominio->fecha_compra."+ ".$num_años." years";
     $fecha_vencimiento = Carbon::createFromDate($date);
     $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

     $dominios=Dominios::find($id);
     $dominios->proveedor=$request->get('proveedor');
     $dominios->fecha_vencimiento=$fecha_vencimiento;
     $dominios->anos=$num_años;
     $dominios->precio=$num_años*$plan_dominio->precio;
     if ($dominio->anos!=$num_años) {
      $dominios->estado_pagado=0;
    }
    $dominios->descripcion=$request->get('descripcion');
    $dominios->save();
  }
  elseif($boton=='Renovar'){
   $dominio = Dominios::where('id',$id)->first();
   /*No permite hacer cambios si es que antes se a Anulado*/
   if ($dominio->estado_anulado==1) {
     return Redirect::to('/dominios')->withErrors(['El Registro esta Anulado']);
   }
   /*No permite hacer cambios si es que antes se a Anulado*/
   $plan_dominio=PlanDominio::where('id',$dominio->plan_domi)->first();

   $num_años=$request->get('fecha_vencimiento');
   $date = $dominio->fecha_vencimiento."+ ".$num_años." years";
   $fecha_vencimiento = Carbon::createFromDate($date);
   $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

   $dominios=Dominios::find($id);
   $dominios->proveedor=$request->get('proveedor');
   $dominios->fecha_compra=$dominio->fecha_vencimiento;
   $dominios->fecha_vencimiento=$fecha_vencimiento;
   $dominios->anos=$num_años;
   $dominios->precio=$num_años*$plan_dominio->precio;
   $dominios->estado_pagado=0;
   $dominios->estado=0;
   $dominios->save();
 }

 return redirect()->route('dominios.index');

    // $fecha_vencimiento=$request->get('fecha_vencimiento');
    // $num_años=$request->get('renovar_fecha');
    // $date = $fecha_vencimiento."+ ".$num_años." years";
    // $fecha_vencimiento = Carbon::createFromDate($date);
    // $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

     // $dominios=Dominios::find($id);
     // $dominios->fecha_vencimiento=$fecha_vencimiento;
     // $dominios->save();
     // return redirect()->route('dominios.index');

}

}
