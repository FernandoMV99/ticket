<?php
namespace App\Http\Controllers;
use App\Motivo;
use Illuminate\Http\Request;

class MotivosController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return "hola0dsadsadsad";
    // }

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


      $motivos= new Motivo;
      $motivos->nombre=$request->get('motivo');
      $motivos->estado_id='1';
      $motivos->user_registrado=$usuario_logeado;
      $motivos-> save();
      return redirect()->route('motivos.index');

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
    public function editar($id_cliente)
    {
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
        $motivos=Motivo::first();
        $motivos->nombre=$request->get('motivo');
        // $motivos->estado_id='1';
        $motivos-> save();
        return redirect()->route('motivos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
    }
}
