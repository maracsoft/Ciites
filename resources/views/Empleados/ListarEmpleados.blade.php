@extends('Layout.Plantilla')

@section('titulo')
  Listar Empleados
@endsection

@section('contenido')
  @include('Layout.MensajeEmergenteDatos')
  <div class="card-body">

    <div class="well">
      <H3 style="text-align: center;">
        <strong>
          EMPLEADOS
        </strong>
      </H3>
    </div>

    <div class="row">

      <div class="col-md-2">
        <a href="{{ route('GestionUsuarios.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>Nuevo Registro</a>
      </div>
      <div class="col-md-10">
        <form class="form-inline float-right">
          <input class="form-control mr-sm-2" type="search" placeholder="Buscar por Nombres y Apellidos" aria-label="Search"
            name="nombreBuscar" id="nombreBuscar" value="{{ $nombreBuscar }}">
          <input class="form-control mr-sm-2" type="search" placeholder="Buscar por DNI" aria-label="Search" name="dniBuscar" id="dniBuscar"
            value="{{ $dniBuscar }}">
          <button class="btn btn-success " type="submit">Buscar</button>
        </form>
      </div>
    </div>

    <br>

    <div class="table-responsive">


      <table class="table table-bordered table-hover datatable table-sm fontSize8 tabla-detalles" id="table-3">
        <thead>
          <tr>
            <th>
              idBD
            </th>
            <th>
              DNI
            </th>
            <th>
              USUARIO
            </th>
            <th>
              NOMBRES Y APELLIDOS
            </th>
            <th>
              Fecha Registro
            </th>
            <th>
              SEDE Administrador
            </th>
            <th>
              Sede Contador
            </th>
            <th>
              Puesto viejo
            </th>
            <th>
              PUESTO nuevo
            </th>
            <th>
              CONTADOR
            </th>
            <th>
              OBSERVADOR
            </th>
            <th>
              OPCIONES
            </th>
          </tr>
        </thead>
        <tbody>

          @foreach ($empleados as $itemempleado)
            <tr style="background-color:{{ $itemempleado->getColorSegunActivo() }}">
              <td>
                {{ $itemempleado->codEmpleado }}
              </td>
              <td>
                {{ $itemempleado->dni }}
              </td>

              <td class="text-center">
                {{ $itemempleado->usuario()->usuario }}

                @if (!$itemempleado->estaActivo())
                  <br>
                  <span class="fontSize8">
                    Desactivado
                  </span>
                @endif
              </td>
              <td>{{ $itemempleado->getNombreCompleto() }}</td>
              <td>{{ $itemempleado->fechaRegistro }}</td>
              <td>

                @if ($itemempleado->esJefeAdmin())
                  {{ $itemempleado->getSedeQueAdministra()->nombre }}
                @endif
              </td>
              <td>


                @if ($itemempleado->esContador())
                  <select class="form-control-xs" name="" id="codSede{{ $itemempleado->codEmpleado }}"
                    onchange="cambiarSedeContador({{ $itemempleado->codEmpleado }})">
                    <option value="0">- Sede -</option>

                    @foreach ($listaSedes as $sede)
                      <option value="{{ $sede->codSede }}" @if ($itemempleado->codSedeContador == $sede->codSede) selected @endif>
                        {{ $sede->nombre }}
                      </option>
                    @endforeach

                  </select>
                @endif

              </td>

              <td>
                {{ $itemempleado->getPuestoOld() }}
              </td>
              <td>
                {{ $itemempleado->getPuestosPorComas() }}

              </td>
              <td>
                @if ($itemempleado->esContador())
                  <a href="{{ route('GestionUsuarios.verProyectosContador', $itemempleado->codEmpleado) }}"
                    class="btn btn-success btn-xs btn-icon icon-left">
                    Proyectos CONTADOR

                  </a>
                @endif
              </td>
              <td>
                @if ($itemempleado->esObservador())
                  <a href="{{ route('GestionUsuarios.verProyectosObservador', $itemempleado->codEmpleado) }}"
                    class="btn btn-success btn-xs btn-icon icon-left">
                    Proyectos OBSERVADOR
                  </a>
                @endif
              </td>
              <td>
                <a href="{{ route('GestionUsuarios.editUsuario', $itemempleado->codEmpleado) }}"
                  class="btn btn-warning btn-xs btn-icon icon-left">
                  <i class="entypo-pencil"></i>
                  Editar Usuario
                </a>
                <a href="{{ route('GestionUsuarios.editEmpleado', $itemempleado->codEmpleado) }}"
                  class="btn btn-warning btn-xs btn-icon icon-left">
                  <i class="entypo-pencil"></i>
                  Editar Empleado
                </a>

                @if ($itemempleado->estaActivo())
                  <button type="button" onclick="clickCesarEmpleado({{ $itemempleado->getId() }})"
                    class="btn btn-danger btn-xs btn-icon icon-left" title="Le quita el acceso al sistema.">
                    <i class="entypo-cancel"></i>
                    Desactivar
                  </button>
                @else
                  <button type="button" onclick="clickReactivarEmpleado({{ $itemempleado->getId() }})" class="btn btn-primary btn-xs">
                    Activar
                  </button>
                @endif



              </td>
            </tr>
          @endforeach

        </tbody>
      </table>

    </div>
    {{ $empleados->appends(['nombreBuscar' => $nombreBuscar, 'dniBuscar' => $dniBuscar])->links() }}
  </div>

  <script>
    function cambiarSedeContador(codEmpleado) {
      codSede = document.getElementById('codSede' + codEmpleado).value;

      $.get('/GestionUsuarios/ActualizarSedeContador/' + codEmpleado + '*' + codSede, function(data) {
        console.log(data);
        if (data == true)
          alertaMensaje('Enbuenahora', 'Se actualizó la sede del contador', 'success');
        else {
          alerta('No se pudo actualizar la sede del contador. Hubo un error interno. Contacte con el administrador');
        }
      });

    }




    codEmpleadoAReactivar = 0;

    function clickReactivarEmpleado(codEmpleado) {
      codEmpleadoAReactivar = codEmpleado;
      confirmarConMensaje('Reactivar usuario', '¿Seguro que desea reactivar al usuario?', 'warning', reactivarEmpleado)
    }

    function reactivarEmpleado() {
      location.href = "/GestionUsuarios/" + codEmpleadoAReactivar + "/reactivar"
    }




    codEmpleadoACesar = 0;

    function clickCesarEmpleado(codEmpleado) {
      codEmpleadoACesar = codEmpleado;
      confirmarConMensaje('Desactivar usuario', '¿Seguro que desea quitar el acceso al sistema al usuario?', 'warning', cesarEmpleado)

    }

    function cesarEmpleado() {
      location.href = "/GestionUsuarios/" + codEmpleadoACesar + "/cesar"
    }
  </script>
@endsection
