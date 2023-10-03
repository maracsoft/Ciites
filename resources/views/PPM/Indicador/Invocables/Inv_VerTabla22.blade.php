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
            Realizó Acción conjunta, para fortalecer la gestión de riesgos y adaptación ante el cambio climático en sus territorios
          </th>
          <th class="align-middle" rowspan="2">
            Describir Acción conjunta, para fortalecer la gestión de riesgos y adaptación ante el cambio climático en sus territorios.
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

          $activar_campos = $relacion->ind22_realizo_accion == 1
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
             
          </td>
         
          <td class="text-center">
            <select name="ind22_realizo_accion_id-{{$id}}" id="ind22_realizo_accion_id-{{$id}}" class="form-control">
              <option value="">- Seleccione -</option>
              @foreach($options22 as $option)
                <option value="{{$option->id}}" {{$option->isThisSelected($relacion->ind22_realizo_accion_id)}}>
                  {{$option->nombre}}
                </option>
              @endforeach
              
            </select>
             
          </td>
          
          <td>
            <input type="text" class="form-control" id="ind22_descripcion_accion-{{$id}}" placeholder="Descripción" value="{{$relacion->ind22_descripcion_accion}}">
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
  <button class="ml-auto btn btn-success" onclick="clickGuardarIndicadores22({{json_encode($codsRelaciones)}})">
    <i class="fas fa-save"></i>
    Guardar
  </button>
</div>