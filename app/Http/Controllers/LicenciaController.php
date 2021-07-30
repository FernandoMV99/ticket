<?php
namespace App\Http\Controllers;
use App\AlertasCorreo;
use App\Categoria;
use App\Empresa;
use App\Equipos;
use App\Licencia;
use App\Moneda;
use App\SoftwareEquipo;
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
class LicenciaController extends Controller
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

      $licencia_cliente=Licencia::where('cliente',$user_logeado->id)->where('estado_anulado',0)->get();
      $licencia=Licencia::all();
      $categoria=Categoria::where('estado',0)->get();

      $clientes=User::orderBy('name')->where('roles_id','3')->get();

      foreach ($licencia as $licencias) {
        $date = $licencias->fecha_vencimiento."+ 1 days";
        $datework = Carbon::createFromDate($date);
        $now = Carbon::now();
        if ($datework>$now) {$testdate=$now->diffInDays($datework);}
        else{$testdate= 0;}

        if ($testdate<1){$estado='1';}
        else{$estado='0';}

            //Cambio de Estado
        if ($licencias->estado_anulado=='0') {
          $licencias=licencia::find($licencias->id);
          $licencias->estado=$estado;
          $licencias-> save();
        }

      }
      /*Clientes*/
      if ($user_logeado->roles_id==3) {
        return view('productos.licencia.licencia.index_cliente',compact('clientes','licencia_cliente'));
      }else{
        return view('productos.licencia.licencia.index',compact('clientes','licencia','categoria'));
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

      $num_anos=$request->get('fecha_vencimiento');
      $fecha_inicio=$request->get('fecha_inicio');
      $date = $fecha_inicio."+ ".$num_anos." years";
      $fecha_vencimiento = Carbon::createFromDate($date);
      $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

      $categoria=Categoria::where('id',$request->get('categoria'))->first();
      $precio=$categoria->precio*$num_anos;
      $moneda=$categoria->moneda;

      $licencia= new Licencia;
      $licencia->cliente=$request->get('cliente_id');
      $licencia->equipo=$request->get('equipos_cliente');
      $licencia->categoria_licencia=$request->get('categoria');
      $licencia->fecha_inicio=$fecha_inicio;
      $licencia->fecha_vencimiento=$fecha_vencimiento;
      $licencia->nombre=$request->get('nombre_licencia');
      $licencia->codigo_licencia=$request->get('cod_licencia');
      $licencia->descripcion=$request->get('descripcion');
      $licencia->user_registrado=$user_logeado;
      $licencia->precio=$precio;
      $licencia->moneda=$moneda;
      $licencia->anos=$num_anos;
      $licencia->save();

      $soft_equipo= new SoftwareEquipo;
      $soft_equipo->nombre_programa=$categoria->nombre;
      $soft_equipo->cod_licencia=$request->get('cod_licencia');
      $soft_equipo->equipos=$request->get('equipos_cliente');
      $soft_equipo->id_licencia=$licencia->id;
      $soft_equipo->user_registrado=$user_logeado;
      $soft_equipo->comprado_aqui='1';
      $soft_equipo->save();

      /*config mensaje gmail*/
      $empresa=Empresa::first();
      $asunto_mensaje='NOTA DEUDA LICENCIA';
      $nombre_empresa=$empresa->nombre;
      $correo_empresa=$empresa->correo;
      $contraseña_empresa=$empresa->contrasena;
      $encryption=$empresa->encryption;
      $smpt=$empresa->smpt;
      $puerto=$empresa->puerto;

      $cliente=User::where('id',$licencia->cliente)->first();

      /* Fin config mensaje gmail*/

        /*Guardando su proximas Notificaciones*/
     $date1 = $fecha_vencimiento."- 15 days";
     $fecha_vencimiento1 = Carbon::createFromDate($date1);
     $fecha_vencimiento1=substr($fecha_vencimiento1, 0, -8);

     $date2 = $fecha_vencimiento."- 7 days";
     $fecha_vencimiento2 = Carbon::createFromDate($date2);
     $fecha_vencimiento2=substr($fecha_vencimiento2, 0, -8);

     $alertas_correo= new AlertasCorreo;
     $alertas_correo->usuario=$licencia->cliente;
     $alertas_correo->fecha1=$fecha_vencimiento1;
     $alertas_correo->fecha2=$fecha_vencimiento2;
     $alertas_correo->fecha3=$licencia->fecha_vencimiento;
     $alertas_correo->nombre_html_sms='sms_nota_deuda_producto';
     $alertas_correo->nombre_modelo='Licencia';
     $alertas_correo->id_registro=$licencia->id;
     $alertas_correo->save();

     /*Guardando su proximas Notificaciones*/


      $email_envio=$request->get('email_envio');
      if ($email_envio==0) {
        /*Envio de Correo de codigo*/
        $mensaje=  view('html_sms.sms_nota_deuda_producto',compact('empresa','licencia','cliente'));
        $transport=(new Swift_SmtpTransport( $smpt ,$puerto,$encryption))->setUsername($correo_empresa)->setPassword($contraseña_empresa);
        $mailer = new Swift_Mailer($transport);
        $message = (new Swift_Message($asunto_mensaje))->setFrom([$correo_empresa=> $nombre_empresa])->setTo([$cliente->email])->setBody($mensaje, 'text/html');
        $result = $mailer->send($message);
        /*Fin Envio de Correo de codigo*/
      }


      return redirect()->route('licencia.index');

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

        $licencia=Licencia::where('id',$id)->first();

        $categoria=Categoria::where('id',$licencia->categoria_licencia)->first();
        $precio=$categoria->precio*$num_anos;

        $licencia=Licencia::find($id);
        $licencia->fecha_inicio=$fecha_inicio;
        $licencia->fecha_vencimiento=$fecha_vencimiento;
        $licencia->descripcion=$request->get('descripcion');
        if ($licencia->anos!=$num_anos) {
          $licencia->estado_pagado=0;
        }
        $licencia->precio=$precio;
        $licencia->anos=$num_anos;
        $licencia->save();
      }
      elseif ($boton=='Anulado') {
        $soft_equipo=SoftwareEquipo::where('id_licencia',$id)->first();

        $licencia=Licencia::find($id);
        $licencia->estado='1';
        $licencia->estado_anulado='1';
        $licencia->save();

        $soft_equipos=SoftwareEquipo::find($soft_equipo->id);
        $soft_equipos->estado='1';
        $soft_equipos->save();

      }

      elseif ($boton=='Renovar') {

        $licencia=Licencia::where('id',$id)->first();
        $categoria=Categoria::where('id',$licencia->categoria_licencia)->first();

        $num_años=$request->get('fecha_vencimiento');
        $date = $licencia->fecha_vencimiento."+ ".$num_años." years";
        $fecha_vencimiento = Carbon::createFromDate($date);
        $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

        $licencia=Licencia::find($id);
        $licencia->fecha_inicio=$licencia->fecha_vencimiento;
        $licencia->fecha_vencimiento=$fecha_vencimiento;
        $licencia->anos=$num_años;
        $licencia->precio=$num_años*$categoria->precio;
        $licencia->estado_pagado=0;
        $licencia->save();

      }
      return redirect()->route('licencia.index');
    }

    public function equipo_cliente(Request $request){
      $output="";
      if($request->ajax()){

        $cliente=$request->get('cliente_id');
        $equipo=Equipos::where('cliente',$cliente)->get();

        if($equipo){
          foreach ($equipo as $key => $equipos) {
            $output.='<option value="'.$equipos->id.'">'.$equipos->marcas->nombre.' / '.$equipos->codigo_equipo.' / '.$equipos->usuario.'</option>';
          }
          return Response($output);
        }
      }
    }


  }
