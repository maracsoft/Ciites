@extends ('Layout.Plantilla')
@section('titulo')
  Listar operaciones
@endsection
@section('contenido')
  

<div style="text-align: center">
  <h2> Listar operaciones</h2>
  <br>
   

    @include('Layout.MensajeEmergenteDatos')
    

    <form action="" method="GET">
      <div class="row m-2">

        <div style="width: 30%">
            <input type="text" class="form-control" id="buscar_codigoCedepas" name="buscar_codigoCedepas" 
                value="{{$buscar_codigoCedepas}}" placeholder="Código del documento">
        
        </div>
        <div style="width: 30%">

            @php
              $selected[0] = "selected";
              $selected[1] = "";
              $selected[2] = "";
              $selected[3] = "";
              $selected[4] = "";
              
              if($buscar_tipoDocumento){
                $selected[$buscar_tipoDocumento] = "selected"; 
                $selected[0] = "";
              }
                
            @endphp

            <select type="text" class="form-control" id="buscar_tipoDocumento" name="buscar_tipoDocumento" 
                value="" placeholder="Código del documento">
            
                <option value=""  {{$selected[0]}}>-Todos-</option>
                <option value="1" {{$selected[1]}} >Solicitudes</option>
                <option value="2" {{$selected[2]}} >Rendiciones</option>
                <option value="3" {{$selected[3]}} >Reposiciones</option>
                <option value="4" {{$selected[4]}} >Requerimientos</option>
                
            </select>
        </div>
        <div style="width: 30%">
            <select type="text" class="form-control" id="buscar_codEmpleado" name="buscar_codEmpleado" 
                value="" placeholder="Código del documento">

                <option value="">- Empleado -</option>
                @foreach($listaEmpleados as $empleado)
                    <option value="{{$empleado->codEmpleado}}"
                      @if($empleado->codEmpleado == $buscar_codEmpleado)
                        selected
                      @endif
                      
                      >
                        {{$empleado->getNombreCompleto()}}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">
                Buscar
            </button>
        </div>

      </div>

  
    
    </form>  
    
    <table class="table table-sm" style="">
      <thead class="thead-dark">
        <tr>
            <th>
                Código
            </th>
            <th style="text-align: center">
                Tipo Documento
            </th>
            <th>
                Codigo documento
            </th>
            <th>
               Fecha hora
            </th>

            <th>
              Accion
            </th>
            <th>
              Puesto
            </th>
            <th>
              Empleado
            </th>
            <th>Opciones</th>

        </tr>
      </thead>
      <tbody>
        
        @foreach($listaOperaciones as $operacion)
            <tr style="background-color: {{$operacion->getColorFondo()}}">
              <td>
                {{$operacion->codOperacionDocumento}}
              </td>
              <td>
                {{$operacion->getTipoDocumento()->abreviacion}}
              </td>
              <td>
                {{$operacion->getDocumento()->codigoCedepas}}
                <span class="fontSize8"> 
                    (id {{$operacion->getDocumento()->getId()}})
                </span>
                
              </td>
              <td>
                {{$operacion->getFechaHora()}}
              </td>
              <td>
                {{$operacion->getTipoOperacion()->nombre}}
                @if($operacion->getTipoOperacion()->nombre == "Observar")
                    <button type="button" class="btn btn-primary btn-xs" 
                      onclick="alertaMensaje('Razón de la observación',`{{$operacion->descripcionObservacion}}`,'info')">
                      <i class="fas fa-eye"></i>
                    </button>
                @endif
              </td>
              <td>
                {{$operacion->getPuesto()->nombre}}
              </td>
              <td>
                {{$operacion->getEmpleado()->getNombreCompleto()}}
              </td>
              <td>
                <button type="button" onclick="clickEliminarOperacion({{$operacion->codOperacionDocumento}})" class="btn btn-danger btn-xs">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
 
            </tr>
        @endforeach
      </tbody>
    </table>

    


                
    {{$listaOperaciones->appends(
      ['buscar_codigoCedepas'=>$buscar_codigoCedepas, 
      'buscar_tipoDocumento'=>$buscar_tipoDocumento,
      'buscar_codEmpleado'=>$buscar_codEmpleado]
                      )
      ->links()
    }}

    
</div>
@endsection

@section('script')
  <script>
    function clickEliminarOperacion(codOperacion){

      codOperacionAEliminar = codOperacion;
      confirmarConMensaje("Confirmación","¿Seguro que desea eliminar la operación? Deberá establecer el estado del documento en el buscador maestro.",'warning',ejecutarEliminacionOperacion);
    }

    codOperacionAEliminar = 0;
    function ejecutarEliminacionOperacion(){
      location.href="/Operaciones/Eliminar/" + codOperacionAEliminar;
    }
    
  </script>
@endsection