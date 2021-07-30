<?php
namespace App\Http\Controllers;
use App\Hosting;
use App\HostingCorreos;
use App\Motivo;
use App\SoftwareEquipo;
use Illuminate\Http\Request;

class SoftwareEquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (auth()->user()->roles_id == 3){return back();}/*Clientes no entran*/
      $motivos=Motivo::all();
      return view('tickets.motivos.index',compact('motivos'));
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

      $nombre_programa=$request->get('nombre_programa');

      $cod_licencia=$request->get('cod_licencia');
      $comprado_aqui=$request->get('comprado_aqui');

      for($i=0; $i<count($nombre_programa); $i++){

        $soft_equipo= new SoftwareEquipo;
        $soft_equipo->equipos=$request->get('id_equipo');
        $soft_equipo->nombre_programa=$nombre_programa[$i];
        $soft_equipo->cod_licencia=$cod_licencia[$i];
        $soft_equipo->comprado_aqui=$comprado_aqui[$i];
        $soft_equipo->user_registrado=$usuario_logeado;
        $soft_equipo-> save();
      }
      return redirect()->route('equipos.show',$soft_equipo->equipos);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     // $tickets_agregado=TicketsAgregado::find($id);
     // $tickets_agregado->estado_id='2';
     // $tickets_agregado->save();
     // $tickets_agregado=TicketsAgregado::where('id',$id)->first();
     // $tickets_respuesta=TicketsRespuesta::where('ticket_agregado_id',$id)->get();
     // $archivos_agregados=Archivos::where('tabla_id_bd',$id)->where('tabla_bd','tickets_agregado')->get();
     // $archivos_respuesta=Archivos::where('tabla_bd','tickets_respuesta')->get();
     // return view('tickets.show',compact('tickets_agregado','tickets_respuesta','archivos_agregados','archivos_respuesta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
     $usuario_logeado=auth()->user()->id;

     $id_software=$request->get('id_software');

     $nombre_programa=$request->get('nombre_programa');
     $cod_licencia=$request->get('cod_licencia');
     $comprado_aqui=$request->get('comprado_aqui');
     for($i=0; $i<count($id_software); $i++){

       $soft_equipo=SoftwareEquipo::find($id_software[$i]);
       $soft_equipo->nombre_programa=$nombre_programa[$i];
       $soft_equipo->cod_licencia=$cod_licencia[$i];
       $soft_equipo->comprado_aqui=$comprado_aqui[$i];
       $soft_equipo->save();
     }
     return redirect()->route('equipos.show',2);
   }


 }
