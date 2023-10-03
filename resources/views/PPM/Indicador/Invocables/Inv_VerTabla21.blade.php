<div class="table-responsive">
    
  <table class="table table-bordered table-hover datatable fontSize10" id="table-3">
    <thead class="table-marac-header">
        <tr>
          <th class="align-middle text-center" rowspan="2">Semestre</th>
          <th class="align-middle text-center" rowspan="2">DNI</th>
          <th class="align-middle text-center" rowspan="2">Nombres y Apellidos</th>
 
          <th class="align-middle text-center" rowspan="2" class="text-center">
            Organización/Espacio de articulación
          </th>
         
          <th class="align-middle" rowspan="2">
            Realizaron mecanismos para la adaptación para la gestión de riesgos y efectos del cambio climático.
          </th>
          <th class="align-middle" rowspan="2">
            Describir Mecanismos para la adaptación para la gestión de riesgos y efectos del cambio climático.
          </th>
          <th class="align-middle" rowspan="2">
            Estado de implementación 
          </th>
          <th class="align-middle" rowspan="2">
            Beneficarios/as del mecanismo
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

          $activar_campos = $relacion->ind21_realizaron_mecanismos == 1
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
            <input type="checkbox" id="ind21_realizaron_mecanismos-{{$id}}" onchange="change21RealizoMecanismos(this.checked,{{$id}})" class="cb_big cursor-pointer" @if($activar_campos) checked @endif >
          </td>
          
          <td>
            <input type="text" class="form-control" id="ind21_descripcion_mecanismos-{{$id}}" @if(!$activar_campos) readonly @endif placeholder="Descripción" value="{{$relacion->ind21_descripcion_mecanismos}}">
          </td>
          <td>
            <input type="text" class="form-control" id="ind21_estado_implementacion-{{$id}}" @if(!$activar_campos) readonly @endif placeholder="Estado Imp" value="{{$relacion->ind21_estado_implementacion}}">
          </td>
          <td>
            <input type="text" class="form-control" id="ind21_beneficiarios-{{$id}}" @if(!$activar_campos) readonly @endif placeholder="Beneficiarios" value="{{$relacion->ind21_beneficiarios}}">
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
  <button class="ml-auto btn btn-success" onclick="clickGuardarIndicadores21({{json_encode($codsRelaciones)}})">
    <i class="fas fa-save"></i>
    Guardar
  </button>
</div>