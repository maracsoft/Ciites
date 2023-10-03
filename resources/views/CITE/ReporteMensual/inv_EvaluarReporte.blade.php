<!-- 
    Este modal invocable se usa en la Matriz, 

 -->

    <div class="modal-header">
        <h5 class="modal-title" id="ModalVerReporteTitulo">
            Reporte {{$reporte->getMes()->nombre}} - {{$reporte->año}} de {{$reporte->getEmpleado()->getNombreCompleto()}}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body row">
        <div class="col-12">
            <label for="">
                Mes:
            </label>
            <input type="text" class="form-control" value="{{$reporte->getMes()->nombre}} - {{$reporte->año}}" readonly>
        </div>
        <div class="col-12">
            <label for="">
                Persona:
            </label>
            <input type="text" class="form-control" value="{{$reporte->getEmpleado()->getNombreCompleto()}}" readonly>
        </div>
        <div class="col-12">
            <label for="">
                Estado:
            </label>
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" value="{{$reporte->getEstado()->nombre}}" readonly>
                </div>
                <div class="col text-gray">
                    <span  class="fontSize10" type="text">
                        {{$reporte->getEstado()->explicacion}}
                    </span>
                
                </div>
                
                
            </div>
            
        </div>
         
        @if($reporte->estaObservado() || $reporte->estaSubsanado() )
            <div class="col-12">
                <label for="">
                    Observacion:
                </label>
                <textarea type="text" class="form-control" readonly
                    >{{$reporte->observacion}}</textarea>
            </div>
        @endif
        
      
        <div class="col-12">
            <span class="fontSize10">
                Historial del reporte:
            </span>
            <table id="tablaHistorial" class="table table-striped table-bordered table-condensed table-hover fontSize9">
                <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                    <th class="p-1">Item</th>                                        
                    <th class="p-1">Fecha hora</th>                                 
                    <th class="p-1">Nombre</th>
                    <th class="p-1">Rol</th>
                    <th class="p-1">Acción</th>
                </thead>

                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @forelse($reporte->getOperaciones() as $operacion)
                        <tr>
                            <td class="p-1">
                                {{$i}}               
                            </td>
                            <td class="p-1">
                                {{$operacion->getFechaHora()}}               
                            </td>
                            <td class="p-1">
                                {{$operacion->getEmpleado()->getNombreCompleto()}}               
                            </td>
                            <td class="p-1">
                                {{$operacion->getPuesto()->nombre}}
                            </td>
                            <td class="p-1">
                                {{$operacion->getTipoOperacion()->nombre}}       
                                @if($operacion->getTipoOperacion()->nombre == "Observar")
                                    <button type="button" class="btn btn-primary btn-xs" onclick="alertaMensaje('Observación',`{{$operacion->descripcionObservacion}}`,'info')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                @endif        
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @empty
                        <tr>
                          <td class="text-center" colspan="5">
                            No hay acciones
                          </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
     

    </div>
    <div class="modal-footer">
        @if($reporte->sePuedeEvaluar())
            <div class="ml-auto">

                <button class=" btn btn-sm btn-warning" data-toggle="modal" data-target="#ModalObservar" onclick="abrirModalObservar({{$reporte->getId()}})" >
                    Observar
                </button>
                <a href="{{route('CITE.ReporteMensual.Aprobar',$reporte->getId())}}" class="ml-auto btn btn-sm btn-success" >
                    Aprobar
                </a>
        
            </div>
        @endif
        @if($reporte->sePuedeCancelarProgramacion())
             
            <a href="{{route('CITE.ReporteMensual.Cancelar',$reporte->getId())}}" class="ml-auto btn btn-xs btn-danger" >
                Cancelar programación de este mes
            </a>
        
        @endif
       
        
    </div>

<style>
    
    
</style>

 