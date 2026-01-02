@extends('Layout.Plantilla')

@section('titulo')
  Proyectos del Observador
@endsection
@section('estilos')
  <style>
    .grande {
      width: 60px;
      height: 20px;

    }
  </style>
@endsection
@section('contenido')
  <div class="card-body">

    <div class="well">
      <H3 style="text-align: center;">
        <strong>
          Asignar proyectos al Observador
        </strong>
      </H3>
    </div>

    <div class="card mt-1">
      <div class="card-header" style=" ">
        <div class="row">
          <div class="col">

            <h3>Observador:</h3>
            {{ $empleado->getNombreCompleto() }}
          </div>

          <div class="col">
            <br>
            <button type="button" onclick="asignarTodosLosProyectos()" class="btn btn-success">
              Asignar todos los proyectos
            </button>
          </div>

          <div class="col">
            <br>
            <button type="button" onclick="quitarTodosLosProyectos()" class="btn btn-danger">
              Quitar todos los proyectos
            </button>
          </div>

        </div>

      </div>
    </div>

    <table class="table table-bordered table-hover datatable table-sm" style="font-size: 10pt" id="table-3">
      <thead>
        <tr>
          <th>idBD</th>
          <th>Cod Presupuestal</th>
          <th>Nombre Proyecto</th>
          <th>Estado</th>
          <th>Asignado</th>

        </tr>
      </thead>
      <tbody>

        @foreach ($listaProyectos as $proyecto)
          <tr>
            <td>
              {{ $proyecto->codProyecto }}

            </td>
            <td>
              {{ $proyecto->codigoPresupuestal }}
            </td>
            <td>
              {{ $proyecto->nombre }}
            </td>
            <td>
              {{ $proyecto->getEstado()->nombre }}
            </td>

            <td class="text-center">
              <input class="grande" type="checkbox" id="CB{{ $proyecto->codProyecto }}" {{-- Este es solo pa mostrarlo en el alert --}}
                onchange="actualizarEstado({{ $proyecto->codProyecto }},'{{ $proyecto->nombre }}')"
                {{ $proyecto->getCheckedSiTieneObservador($empleado->codEmpleado) }}>
            </td>

          </tr>
        @endforeach

      </tbody>
    </table>

  </div>
@endsection

@section('script')
  <script>
    codEmpleado = {{ $empleado->codEmpleado }};

    function actualizarEstado(codProyecto, nombreProyecto) {
      chekBox = document.getElementById('CB' + codProyecto);

      variacion = "";

      if (!chekBox.checked) //si está solucionado, pasará a no solucionado
        variacion = " NO";

      //$.get('/asignarGerentesObservadores/actualizar/'+codProyecto+'*'+codGerente+'*1', function(data){
      $.get("/GestionUsuarios/asignarProyectoAObservador/" + codEmpleado + "*" + codProyecto, function(data) {
        if (data == 1) /* Ya existia y lo destruimos */
          alertaMensaje('Enbuenahora', 'Se ELIMINÓ el observador {{ $empleado->getNombreCompleto() }} del proyecto ' + nombreProyecto +
            '.', 'success');

        if (data == 2) /* no existia y lo creamos */
          alertaMensaje('Enbuenahora', 'Se AGREGÓ al observador {{ $empleado->getNombreCompleto() }} al proyecto ' + nombreProyecto +
            '.', 'success');

        if (data == 0) {
          alerta('Hubo un error, verifique su conexión');
          chekBox.checked = !chekBox.checked;
        }

      });

    }

    function asignarTodosLosProyectos() {

      $.get("/GestionUsuarios/asignarObservadorATodosProyectos/" + codEmpleado, function(data) {

        if (data == 1) /* no existia y lo creamos */
          alertaMensaje('Enbuenahora', 'Se AGREGÓ al observador {{ $empleado->getNombreCompleto() }} a todos los proyectos', 'success');

        if (data == 0)
          alerta('Hubo un error, verifique su conexión');


        location.reload();
      });

    }

    function quitarTodosLosProyectos() {

      $.get("/GestionUsuarios/quitarObservadorATodosProyectos/" + codEmpleado, function(data) {

        if (data == 1) /* no existia y lo creamos */
          alertaMensaje('Enbuenahora', 'Se QUITÓ al observador {{ $empleado->getNombreCompleto() }} de todos los proyectos', 'success');

        if (data == 0)

          alerta('Hubo un error, verifique su conexión');


        location.reload();
      });


    }
  </script>
@endsection
