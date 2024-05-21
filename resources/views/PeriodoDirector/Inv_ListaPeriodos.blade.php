<div class="table-container">

  <table class="table table-hover table-bordered celdas_sin_padding">
    <thead class="thead-dark">
      <tr>
        <th>
          Cod
        </th>
        <th>
          Nombres
        </th>
        <th>
          Apellidos
        </th>
        <th>
          DNI
        </th>
        <th>
          Sexo
        </th>
        <th>
          Fecha Inicio
        </th>
        <th>
          Fecha Fin
        </th>
        <th>
          Estado
        </th>
        <th>
          Opciones
        </th>
      </tr>
    </thead>
    <tbody>


      @foreach ($listaPeriodos as $periodo)
        <tr>
          <td>
            {{$periodo->getId()}}
          </td>
          <td>
            {{$periodo->nombres}}
          </td>
          <td>
            {{$periodo->apellidos}}
          </td>
          <td>
            {{$periodo->dni}}
          </td>
          <td class="text-center">
            {{$periodo->getSexoEscrito()}}
          </td>
          <td class="text-center">
            {{$periodo->getFechaInicioEscrita()}}
          </td>
          <td class="text-center">
            {{$periodo->getFechaFinEscrita()}}
          </td>
          <td>

            <div class="estado_periodo {{$periodo->getActivoString()}}">
              {{$periodo->getActivoString()}}
            </div>

          </td>
          <td class="text-center">
            <button class="btn btn-warning" type="button" onclick="clickEditarPeriodo({{$periodo->getId()}})">
              
              <i class="fas fa-pen"></i>
            </button>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

</div>