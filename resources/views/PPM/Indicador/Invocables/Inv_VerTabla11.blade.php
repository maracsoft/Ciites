<div class="table-responsive">
  <table class="table table-bordered table-hover datatable fontSize10" id="table-3">
    <thead class="table-marac-header">
        <tr>
          <th rowspan="2">Semestre</th>
          <th rowspan="2">DNI</th>
          <th rowspan="2">Nombres y Apellidos</th>
           
          <th  rowspan="2" class="text-center">
            Organización/Espacio de articulación
          </th>
          
          <th rowspan="2">Realizó actividad de incidencia</th>
          <th rowspan="2">Describir actividad/es de incidencia</th>
          <th rowspan="2">
            Describir resultado/s de incidencia (Política aprobada, proyecto aprobado, financiamiento, intervención, otro)
          </th>
        </tr>
        
    </thead>
    <tbody>
      @php
        $codsRelaciones = [];
      @endphp
      @forelse($listaRelaciones as $relacion)
        @php
          $persona = $relacion->getPersona();
          
          
          $codsRelaciones[] = $relacion->getId();
          $id = $relacion->getId();
          $i = 1;

          $activar_campos = $relacion->ind11_realizo_actividad_incidencia == 1
        @endphp
        <tr>
          <td class="text-center">
            {{$relacion->getSemestre()->getTexto()}}
          </td>
          <td>
            {{$persona->dni}}
          </td>
          <td>
            {{$persona->getNombreCompleto()}}
          </td>
          <td>
            {{$persona->getResumenOrganizacionesAsociadas()}}
          </td>
          <td class="text-center">
            <input type="checkbox" id="ind11_realizo_actividad_incidencia-{{$id}}" onchange="change11RealizoActividadIncidencia(this.checked,{{$id}})" class="cb_big cursor-pointer" @if($activar_campos) checked @endif >
          </td>
          
          <td>
            <input type="text" class="form-control" id="ind11_descripcion_actividad-{{$id}}" @if(!$activar_campos) readonly @endif placeholder="Desc. Actividad" value="{{$relacion->ind11_descripcion_actividad}}">
          </td>
          <td>
            <input type="text" class="form-control" id="ind11_descripcion_resultado-{{$id}}" @if(!$activar_campos) readonly @endif placeholder="Desc. Resultado" value="{{$relacion->ind11_descripcion_resultado}}">
            
          </td>
          

        </tr>
        @php
          $i++;
        @endphp
      @empty
        <tr>
          <td class="text-center" colspan="11">
            No hay resultados
          </td>
        </tr>
      @endforelse
      

    </tbody>
  </table>  
</div>

<div class="d-flex flex-row">
  <button class="ml-auto btn btn-success" onclick="clickGuardarIndicadores11({{json_encode($codsRelaciones)}})">
    <i class="fas fa-save"></i>
    Guardar
  </button>
</div>