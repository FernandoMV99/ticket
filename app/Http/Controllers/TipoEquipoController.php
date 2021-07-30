<?php
namespace App\Http\Controllers;
use App\Archivos;
use App\Motivo;
use App\TicketsAgregado;
use App\TicketsRespuesta;
use App\TipoEquipo;
use App\User;
use Illuminate\Http\Request;

class TipoEquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (auth()->user()->roles_id == 3){return back();}/*Clientes no entran*/
      $tipo_equipo=TipoEquipo::all();
      return view('equipos.tipo_equipo.index',compact('tipo_equipo'));
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
        if($request->hasfile('foto')){
            $image1 =$request->file('foto');
            $nombre_foto =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/multimedia/tipo_equipo/');
            $image1->move($destinationPath,$nombre_foto);
        }else{
            $nombre_foto='equipos.svg';
        }
        $tipo_equipo = new TipoEquipo;
        $tipo_equipo->nombre =$request->get('nombre');;
        $tipo_equipo->imagen=$nombre_foto;
        $tipo_equipo->estado=0;
        $tipo_equipo-> save();
        return redirect()->route('tipo_equipo.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        if($request->hasfile('foto')){
            $image1 =$request->file('foto');
            $nombre_foto =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/multimedia/tipo_equipo/');
            $image1->move($destinationPath,$nombre_foto);
        }else{
            $nombre_foto=$request->get('foto_original');
        }
        $estado=$request->get('estado');
        if (empty($estado)){$estado=1;}else{$estado=0;}
        $tipo_equipo=TipoEquipo::find($id);
        $tipo_equipo->nombre=$request->get('nombre');
        $tipo_equipo->estado=$estado;
        $tipo_equipo->imagen=$nombre_foto;
        $tipo_equipo->save();
        return redirect()->route('tipo_equipo.index');
    }

}
