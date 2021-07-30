           <div style="padding-left: 80px;padding-right: 80px;">

            <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
              <tbody>

                <tr>
                  <td align="left">
                    <img  style="width: 50%;height:auto;background-size: contain;border-radius: 5px; padding: 10px;" name="foto"  src="{{ asset('/multimedia/empresa/')}}/{{$empresa->foto}}"  />
                  </td>
                  <td align="right">
                    <div class="form-control" align="center" style="color: grey;background-color: #def7e8;padding:5px;width:200px;border-radius: 10px" >
                      <b><h2>Nota de Venta <br><span style="color: red; font-size: 13px">No Pagado</span></h2></b>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td align="left" >
                    <b>Facturado a</b> <br>
                    {{$cliente->empresa}}<br>
                    Sr(a): {{$cliente->name}} {{$cliente->last_name}} <br>
                    {{$empresa->ruc}}<br>
                    {{$cliente->pais}}<br>
                  </td>

                  <td align="right" >
                   {{$empresa->nombre}} <br>
                   {{$empresa->pais}}-{{$empresa->departamento}}-{{$empresa->distrito}} <br>
                   ID: {{$empresa->ruc}}
                 </td>
               </tr>

               <tr> <td height="5"></td> </tr>
               <tr><td style="width:50%;text-align:left;font-weight:bold">Descripcion</td><td style="width:50%;text-align:right;font-weight:bold">Total</td></tr>
               <tr><td style="background: #00000045;height:2px;margin:8px 0;" colspan="3"></td></tr>
               <tr> <td width="1" height="10"></td></tr>
               {{-- Ticket  --}}
               @if(isset($ticket))
               <tr >
                 <td style="width:50%;text-align:left;padding-left:15px">
                   <b>Motivo:</b> {{$ticket->motivo->nombre}}<br>
                   <b>Asunto:</b> {{$ticket->asunto}}<br>
                   @if(isset($ticket->equipo))
                   <b>Equipo en Soporte:</b> {{$ticket->equipos->marcas->nombre}} / {{$ticket->equipos->tipoequipo->nombre}} / {{$ticket->equipos->usuario}}
                   @endif
                 </td>
                 <td style="width:50%;text-align:right;font-weight:bold">{{$ticket->moneda}}{{$ticket->precio}}</td>
               </tr>
               @endif
               {{--Fin Ticket  --}}

               <tr><td style="height:15px"></td></tr>
               <tr><td style="background: #00000045;height:2px;margin:8px 0;" colspan="3"></td></tr>

               <tr> <td width="1" height="15"></td></tr>
               <tr>
                <td align="left" style="width:50%;text-align:left;padding-left:15px" > Total: </td>
                <td style="text-align:right">
                  @if(isset($ticket)){{$ticket->moneda}}{{$ticket->precio}}@endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>


        <style>
        .form-control, .single-line {
          background-color: #FFFFFF;
          background-image: none;
          border: 1px solid #e5e6e7;
          border-radius: 1px;
          color: inherit;
          display: block;
          padding: 6px 12px;
          transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
          width: 100%;
        }
      </style>