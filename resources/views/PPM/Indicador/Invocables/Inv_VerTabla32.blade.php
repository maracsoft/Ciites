<div class="table-responsive">

  
  <table class="table table-bordered table-hover datatable fontSize10" id="table-3">
    <thead class="table-marac-header">
        <tr>
          <th class="align-middle text-center" rowspan="2">
            Semestre
          </th>
          <th class="align-middle text-center" rowspan="2">
            DNI
          </th>
          <th class="align-middle text-center" rowspan="2">
            Nombres y Apellidos
          </th>
          
          <th class="align-middle text-center" rowspan="2" class="text-center">
            Tiempo dedicado al trabajo de cuidado
          </th>
          <th class="align-middle text-center" rowspan="2" class="text-center">
            Tiempo destinado a trabajo remunerado

          </th>
          <th class="align-middle text-center" rowspan="2" class="text-center">
            Actividad económica generadora de ingresos
          </th>
          <th class="align-middle text-center" rowspan="2" class="text-center">
            Manejo de registro de ingresos
          </th>
          <th class="align-middle text-center" rowspan="2" class="text-center">
            Manera en el que hacen registros
          </th>
          <th class="align-middle text-center" rowspan="2" class="text-center">
            Inversiones realizadas
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

            $activar_campos = $relacion->ind32_tiene_manejo_registros == 1
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
              <input type="text" class="form-control" id="ind32_tiempo_cuidado-{{$id}}" placeholder="Descripción" value="{{$relacion->ind32_tiempo_cuidado}}">
            </td>
            <td>
              <input type="text" class="form-control" id="ind32_tiempo_remunerado-{{$id}}" placeholder="Descripción" value="{{$relacion->ind32_tiempo_remunerado}}">
            </td>
            <td>
              <input type="text" class="form-control" id="ind32_actividad_economica-{{$id}}" placeholder="Descripción" value="{{$relacion->ind32_actividad_economica}}">
            </td>

            
            <td class="text-center">
              <input type="checkbox" id="ind32_tiene_manejo_registros-{{$id}}" onchange="change32TieneManejo(this.checked,{{$id}})" class="cb_big cursor-pointer" @if($activar_campos) checked @endif >
            </td>
            
            <td>
              <input type="text" class="form-control" id="ind32_manera_registros-{{$id}}" placeholder="Descripción" value="{{$relacion->ind32_manera_registros}}" @if(!$activar_campos) readonly @endif  >
            </td>
            
            <td>
              <input type="text" class="form-control" id="ind32_inversiones-{{$id}}" placeholder="Descripción" value="{{$relacion->ind32_inversiones}}">
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
  <button class="ml-auto btn btn-success" onclick="clickGuardarIndicadores32({{json_encode($codsRelaciones)}})">
    <i class="fas fa-save"></i>
    Guardar
  </button>
</div>
