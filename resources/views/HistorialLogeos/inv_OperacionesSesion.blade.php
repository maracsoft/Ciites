<label for="">
    Sesión # {{$logeo->codLogeoHistorial}} de {{$empleado->getNombreCompleto()}}
</label>

<table class="table table-hover table-sm fontSize8 text-center">
    
    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
        <th  >Item</th>            
        <th>Operacion</th>                            
        <th >Fecha hora</th>                                 
        <th >Tipo Documento</th>
        <th >Código Documento</th>
        <th>Rol</th>
        <th >Acción</th>
    </thead>

    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach($listaOperacionesDuranteSesion as $operacion)
            <tr>
                <td>
                    {{$i}}               
                </td>
                <td>
                    {{$operacion->codOperacionDocumento}}
                </td>
                <td>
                    {{$operacion->getFechaHora()}}               
                </td>
                <td>
                    {{$operacion->getTipoDocumento()->nombre}}               
                </td>
                <td>
                    {{$operacion->getDocumento()->codigoCedepas}}
                </td>
                <td>
                    {{$operacion->getPuesto()->nombre}}
                    
                </td>
                <td>
                    {{$operacion->getTipoOperacion()->nombre}}       
                    @if($operacion->getTipoOperacion()->nombre == "Observar")
                        <button type="button" class="btn btn-primary btn-xs" onclick="alertaMensaje('Observación',`{{$operacion->descripcionObservacion}}`,'info')">
                            Razón observación
                            <i class="fas fa-eye">

                            </i>
                        </button>
                        
                    @endif        
                </td>
            </tr>
        @php
            $i++;
        @endphp
        @endforeach
    </tbody>



</table>