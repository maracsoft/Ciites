<div class="table-responsive">
  <table class="table table-bordered table-hover datatable fontSize10" id="table-3">
    <thead class="table-marac-header">
        <tr>
          <th class="align-middle" rowspan="2">Semestre</th>
          <th class="align-middle" rowspan="2">DNI</th>
          <th class="align-middle" rowspan="2">Nombres y Apellidos</th>
       
          <th class="align-middle"  rowspan="2" class="text-center">
            Organización/Espacio de articulación asociado
          </th>
       
          <th class="align-middle" rowspan="2">Temas de capacitacion</th>
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
         
          <td>
            <input type="text" class="form-control" id="ind12_temas_capacitacion-{{$id}}" placeholder="Temas" value="{{$relacion->ind12_temas_capacitacion}}">
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
  <button class="ml-auto btn btn-success" onclick="clickGuardarIndicadores12({{json_encode($codsRelaciones)}})">
    <i class="fas fa-save"></i>
    Guardar
  </button>
</div>