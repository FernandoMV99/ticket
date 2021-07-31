<?php
namespace App\Http\Controllers;
use App\Archivos;
use App\CertificadoSsl;
use App\Dominios;
use App\Empresa;
use App\Equipos;
use App\Hosting;
use App\Moneda;
use App\Motivo;
use App\SoporteTecnico;
use App\TicketsAgregado;
use App\TicketsRespuesta;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Swift_Attachment;
use Swift_MailTransport;
use Swift_Mailer;
use Swift_Message;
use Swift_Preferences;
use Swift_SmtpTransport;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pagos_pendientes()
    {
       $user=auth()->user()->id;
       $tickets_agregados=TicketsAgregado::where('cliente',$user)->where('estado_enviado_notificacion',"1")->where('estado_pagado',"0")->get();
       // return $tickets_agregado;
       $empresa=Empresa::first();
       return view('tickets.tickets.pago_pendiente',compact('tickets_agregados','empresa'));
   }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=auth()->user()->id;
        $date_now=date('Y-m-d');

        $tickets_agregado=TicketsAgregado::all();
        $tickets_agregado_cliente=TicketsAgregado::where('cliente',$user)->get();
        // $user=User::all();
        $motivo=Motivo::where('estado_id',1)->get();
        $soporte_existe=SoporteTecnico::where('cliente',$user)->where('estado_anulado',0)->first();

        $equipo=Equipos::where("cliente",$user)->get();
        if (auth()->user()->roles_id ==3) {
            return view('tickets.tickets.index_cliente',compact('tickets_agregado','motivo','tickets_agregado_cliente','equipo','soporte_existe','date_now'));
        }
        else{
            return view('tickets.tickets.index',compact('tickets_agregado','motivo','tickets_agregado_cliente','equipo','soporte_existe','date_now'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=auth()->user()->id;

        /*Reconocer si es un equipo*/
        $equipo=$request->get('equipo_soporte');
        if (is_numeric($equipo))
            {$equipo_sp=Equipos::where('id',$equipo)->first();
        $mensaje_html=$request->get('mensaje').'<br><br><br><p> <strong>Equipo en Soporte</strong><br> Codigo Del Equipo: '.$equipo_sp->codigo_equipo.' <br> Tipo de Equipo: '.$equipo_sp->tipoequipo->nombre.'<br>usuario: '.$equipo_sp->usuario.' <br>N/S: '.$equipo_sp->numero_serie.'</p>';}
        elseif ($equipo=='new')
            {$mensaje_html=$request->get('mensaje').'<br><br><br><p><strong>Equipo en Soporte</strong><br> Equipo Por Registrar </p>';}
        else{$mensaje_html=$request->get('mensaje');}
        /*FIn Reconocer si es un equipo*/

        // $texto= strip_tags($mensaje_html);

        $cantidad_tickets=TicketsAgregado::count();
        $numero=str_pad($cantidad_tickets+1 ,8, "0", STR_PAD_LEFT);
        $codigo='T-'.$numero;

        $tickets_agregado = new TicketsAgregado;
        $tickets_agregado->codigo_ticket =$codigo;
        $tickets_agregado->asunto=$request->get('asunto');
        $tickets_agregado->mensaje=$mensaje_html;
        $tickets_agregado->estado_id='1';
        $tickets_agregado->cliente=$user;
        $tickets_agregado->motivo_id=$request->get('motivo');
        $tickets_agregado->estado_resuelto='0';
        if ($equipo!='new') {
            $tickets_agregado->equipo=$request->get('equipo_soporte');
        }
        $tickets_agregado-> save();
        return redirect()->route('tickets.show',$tickets_agregado->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user=auth()->user();
        $empresa=Empresa::first();
        $moneda=Moneda::get();

        $date_now=date('Y-m-d');
        $tickets_agregado=TicketsAgregado::where('id',$id)->first();

        /*Validacion*/
        if (empty($tickets_agregado)){  return redirect()->route('tickets.index');}
        if (auth()->user()->roles_id == 3 and $user->id!=$tickets_agregado->cliente ){return redirect()->route('tickets.index');}
        /*Fin Validacion*/

        $equipo_show=Equipos::where('id',$tickets_agregado->equipo)->first();

        /*Nota venta SI o NO*/
        /*1=Generar Nota Venta
        0=No Generar nada
        */
        $exi_soporte=SoporteTecnico::where('cliente',$tickets_agregado->cliente)->where('estado_anulado','0')->first();

        if (isset($equipo_show)) {
            $exi_equipo=$equipo_show->estado_soporte;/*Para ver si esta registrado como parte del Soporte*/
            if ($exi_equipo=='0') {
                $equipo_notaventa='0';
            }else{ $equipo_notaventa='1';}
        }else{ $equipo_notaventa='0';}

        if (isset($exi_soporte)){
            if ($exi_soporte->fecha_vencimiento>$date_now) { $soporte_notaventa='0'; }/*Para ver si su Plan aun sigue Pendiente*/
            else{ $soporte_notaventa='1'; }
        }else{ $soporte_notaventa='1'; }

        if (isset($exi_soporte)){
            if ($tickets_agregado->created_at > $exi_soporte->fecha_inicio) {
             $fecha_notaventa='0';
         }else{$fecha_notaventa='1';}
     }else{$fecha_notaventa='1';}

     $notaventa=$equipo_notaventa+$soporte_notaventa+$fecha_notaventa;
     // return $notaventa;
     /*FIN Nota venta SI o NO*/



        // return $user->id;
     $cantidad_ticket_generado_por_cliente=TicketsAgregado::where('cliente',$tickets_agregado->cliente)->count();

     /*Info del usuario*/
     $soporte=SoporteTecnico::where('cliente',$tickets_agregado->cliente)->where('estado_anulado',0)->first();
     $hosting=Hosting::where('cliente',$tickets_agregado->cliente)->where('estado_anulado',0)->get();
     $dominio=Dominios::where('cliente',$tickets_agregado->cliente)->where('estado_anulado',0)->get();
     $certificado_ssl=CertificadoSsl::where('cliente',$tickets_agregado->cliente)->where('estado_anulado',0)->get();
     /*FIN Info del usuario*/

     $tickets_respuesta=TicketsRespuesta::where('ticket_agregado_id',$id)->get();

     $archivos_agregados=Archivos::where('tabla_id_bd',$id)->where('tabla_bd','tickets_agregado')->get();
     $archivos_respuesta=Archivos::where('tabla_bd','tickets_respuesta')->get();

     $tickets_respuesta_=TicketsRespuesta::where('estado_id',1)->where('cliente', auth()->user()->id)->where('ticket_agregado_id',$id)->get();
     foreach ($tickets_respuesta_ as $tickets_respuestas ) {
        $id_respuesta=$tickets_respuestas->id;
        $t_respuesta=TicketsRespuesta::find($id_respuesta);
        $t_respuesta->estado_id=2;
        $t_respuesta->save();
    }
    if ($user->roles_id != 3) {
        $tickets_agregado_update=TicketsAgregado::find($id);
        $tickets_agregado_update->estado_id='2';
        $tickets_agregado_update->save();
    }
    if ($user->roles_id == 3) {
        $tickets_respuesta_respuesta=TicketsRespuesta::where('ticket_agregado_id',$tickets_agregado->id)->where('trabajador',true)->get();
        foreach($tickets_respuesta_respuesta as $tickets_respuesta_respuestas){
            $tickets_respuesta_update=TicketsRespuesta::find($tickets_respuesta_respuestas->id);
            $tickets_respuesta_update->estado_id='2';
            $tickets_respuesta_update->save();
        }
    }


    if (auth()->user()->roles_id ==3) {
        return view('tickets.tickets.show_cliente',compact('tickets_agregado','tickets_respuesta','archivos_agregados','archivos_respuesta','cantidad_ticket_generado_por_cliente','soporte','hosting','dominio','certificado_ssl','equipo_show','empresa','moneda','date_now','notaventa'));
    }
    else{
     return view('tickets.tickets.show',compact('tickets_agregado','tickets_respuesta','archivos_agregados','archivos_respuesta','cantidad_ticket_generado_por_cliente','soporte','hosting','dominio','certificado_ssl','equipo_show','empresa','moneda','date_now','notaventa'));
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
        $ticket=TicketsAgregado::find($id);
        $ticket->moneda=$request->get('moneda');
        $ticket->precio=$request->get('precio');
        $ticket->estado_enviado_notificacion=1;
        $ticket->save();

        /*config mensaje gmail*/
        $empresa=Empresa::first();
        $asunto_mensaje='NOTA DEUDA SOPORTE TECNICO';
        $nombre_empresa=$empresa->nombre;
        $correo_empresa=$empresa->correo;
        $contraseña_empresa=$empresa->contrasena;
        $encryption=$empresa->encryption;
        $smpt=$empresa->smpt;
        $puerto=$empresa->puerto;

        $cliente=User::where('id',$ticket->cliente)->first();

        /* Fin config mensaje gmail*/

        $email_envio=$request->get('email_envio');
        if ($email_envio==0) {
            /*Envio de Correo de codigo*/
            $mensaje=  view('html_sms.sms_nota_deuda_ticket',compact('empresa','ticket','cliente'));
            $transport=(new Swift_SmtpTransport( $smpt ,$puerto,$encryption))->setUsername($correo_empresa)->setPassword($contraseña_empresa);
            $mailer = new Swift_Mailer($transport);
            $message = (new Swift_Message($asunto_mensaje))->setFrom([$correo_empresa=> $nombre_empresa])->setTo([$cliente->email])->setBody($mensaje, 'text/html');
            $result = $mailer->send($message);
            /*Fin Envio de Correo de codigo*/
        }
        return redirect()->route('tickets.show',$ticket->id);
    }



}
