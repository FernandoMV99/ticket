<?php
namespace App\Http\Controllers;
use App\Archivos;
use App\Motivo;
use App\TicketsAgregado;
use App\TicketsRespuesta;
use App\User;
use Illuminate\Http\Request;

class TicketsRespuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $user=auth()->user();

        $ticket_agregado_id=$request->get('ticket_agregado_id');
        $tickets_agregado_registro=TicketsAgregado::where('id',$ticket_agregado_id)->first();
        $cliente=$request->get('cliente');

        $mensaje_html=$request->get('mensaje');
        $texto= strip_tags($mensaje_html);

        $tickets_agregado = new TicketsRespuesta;
        $tickets_agregado->mensaje=$mensaje_html;
        $tickets_agregado->ticket_agregado_id=$ticket_agregado_id;
        $tickets_agregado->estado_id=1;
        $tickets_agregado->cliente=$cliente;
        if ($user->roles_id != 3) { $tickets_agregado->trabajador=$user->id; }
        $tickets_agregado-> save();

        /*Si no es Cliente, el estado Resuelto se vera como terminado "Cerrado"*/
        if ($user->roles_id != 3) {$resuelto=1; $estado='2'; $trabajador=auth()->user()->id;} else{ $resuelto=0; $estado='1'; $trabajador=NULL;}
        $tickets_agregado=TicketsAgregado::find($ticket_agregado_id);
        $tickets_agregado->estado_id=$estado;
        $tickets_agregado->estado_resuelto=$resuelto;
        if (empty($tickets_agregado_registro->trabajador)) {
            $tickets_agregado->trabajador=$trabajador;
        }
        $tickets_agregado->save();
        return redirect()->route('tickets.show',$ticket_agregado_id);

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
