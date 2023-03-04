

@if(count($listaEmpleadosRevisores)==0)
  <h4>
    No hay ningún empleado asignado para esta revisión
  </h4> 
@else  
  

<table class="table table-bordered table-hover datatable table-sm" id="table-3">
    <thead>                  
      <tr>
        <th>Empleado</th>
        <th class="text-center">Sede</th>
        @if($revision->estaAbierta())
          <th class="text-center">Opciones</th>
        @endif
        
      </tr>
    </thead>
    <tbody>

      @foreach($listaEmpleadosRevisores as $emp)
        <tr>
            <td>
              {{$emp->getEmpleado()->getNombreCompleto()}}
            </td>
            <td class="text-center">
              {{$emp->getSede()->nombre}}
            </td>
            @if($revision->estaAbierta())
              <td class="text-center">
                <button type="button" class="btn btn-danger btn-xs" onclick="clickQuitarRevisor({{$emp->codEmpleadoRevisador}})">
                  <i class="fas fa-trash"></i>
                </button>

              </td>
            @endif
          </tr>
      @endforeach
      
    </tbody>
</table>

  
@endif