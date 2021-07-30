<?php
namespace App\Http\Controllers;
use App\Equipos;
use App\Hosting;
use App\HostingCorreos;
use App\Marca;
use App\Marcas;
use App\Motivo;
use App\SoftwareEquipo;
use App\TipoEquipo;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Schema\date;
use Illuminate\Http\Request;

class EquiposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user_logeado=auth()->user();
      $cliente=User::where("roles_id",3)->get();
      $cliente_logeado=Equipos::where("cliente",$user_logeado->id)->get();
      $tipo_equipo=TipoEquipo::all();
      $marcas=Marcas::all();
      if ($user_logeado->roles_id==3) {
        return view('equipos.equipos.index_cliente',compact('cliente_logeado','tipo_equipo','marcas'));}
        else{
          return view('equipos.equipos.index',compact('cliente'));}
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
      $cantidad_equipo=Equipos::all()->count()+1;
      $hora=date('His');
      // for($i=0; $i<count($email); $i++){
      $equipos= new Equipos;
      $equipos->marca=$request->get('marca');
      $equipos->codigo_equipo='EQP-'.$cantidad_equipo.$request->get('id_cliente').$hora;
      $equipos->numero_serie=$request->get('numero_serie');
      $equipos->usuario=$request->get('usuario');
      $equipos->tipo_equipo=$request->get('tipo_equipo');
      $equipos->cliente=$request->get('id_cliente');
      $equipos->descripcion_hardware=$request->get('descripcion_hardware');
      $equipos->user_registrado=$usuario_logeado;
      $equipos-> save();
      // }

      return redirect()->route('equipos.show',$equipos->cliente);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      $user=User::where('id',$id)->first();
      if (empty($user)){return redirect()->route('equipos.index');}/*si el numero de REgistro existe*/
      if ($user->roles_id != 3){return back();}/*clientes-> con roles 3 pueden tener registro*/
      if (auth()->user()->roles_id == 3){return back();}/*clientes NO entran*/

      $equipo_cliente=Equipos::where('cliente',$id)->get();
      $count_equipos=Equipos::where('cliente',$id)->count();
      $tipo_equipo=TipoEquipo::all();
      $marcas=Marcas::all();

      return view('equipos.equipos.show',compact('equipo_cliente','tipo_equipo','marcas','id','user','count_equipos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {

      $equipos=Equipos::find($id);
      $equipos->tipo_equipo=$request->get('tipo_equipo');
      $equipos->marca=$request->get('marca');
      $equipos->numero_serie=$request->get('numero_serie');
      $equipos->usuario=$request->get('usuario');
      $equipos->descripcion_hardware=$request->get('descripcion_hardware');
      $equipos->save();
      return redirect()->route('equipos.show',$equipos->cliente);
    }


  }
