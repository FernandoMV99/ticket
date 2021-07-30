<?php
namespace App\Http\Controllers;
use App\Archivos;
use App\Marcas;
use App\User;
use Illuminate\Http\Request;

class MarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (auth()->user()->roles_id == 3){return back();}/*Clientes no entran*/
      $marcas=Marcas::all();
      return view('equipos.marcas.index',compact('marcas'));
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
        $this->validate($request,[
            'nombre' => ['required'],
        ],[
            'nombre.required' => 'El Nombre es Necesario',
        ]);

        $marcas = new Marcas;
        $marcas->nombre =$request->get('nombre');
        $marcas->estado=0;
        $marcas-> save();
        return redirect()->route('marcas.index');
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
        $estado=$request->get('estado');
        if (isset($estado)) {$estado=0;}
        else{$estado=1;}
        $marcas=Marcas::find($id);
        $marcas->nombre=$request->get('nombre');
        $marcas->estado=$estado;
        $marcas->save();
        return redirect()->route('marcas.index');
    }

}
