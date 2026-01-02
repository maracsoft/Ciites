@extends('Layout.Plantilla')

@section('titulo')
  Crear Proyecto
@endsection
@section('contenido')
  <div class="pt-2">


    <form id="frmUpdateInfoProyecto" name="frmUpdateInfoProyecto" role="form" action="{{ $action }}" method="post"
      enctype="multipart/form-data">

      @csrf

      @include('Layout.MensajeEmergenteDatos')

      <div class="card">
        <div class="card-header font-weight-bold">
          Información del proyecto
        </div>
        <div class="card-body">

          <div class="row">

            <div class="col-12 col-sm-4">
              <label class="">Nombre del Proyecto (corto):</label>
              <div class="">
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $proyecto->nombre }}"
                  placeholder="Nombre...">
              </div>
            </div>

            <div class="col-12 col-sm-2">

              <label class="">Codigo presupuestal:</label>
              <input type="text" class="form-control" id="codigoPresupuestal" name="codigoPresupuestal"
                value="{{ $proyecto->codigoPresupuestal }}" placeholder="...">
            </div>


            <div class="col-12 col-sm-2">
              <label class="">Sede Principal:</label>
              <div class="">
                <select class="form-control" name="codSedePrincipal" id="codSedePrincipal">
                  <option value="" selected>-- Seleccionar --</option>
                  @foreach ($listaSedes as $itemsede)
                    <option value="{{ $itemsede->codSede }}" {{ $itemsede->isThisSelected($proyecto->codSedePrincipal) }}>
                      {{ $itemsede->nombre }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-12 col-sm-2">
              <label for="">Gerente</label>
              <select class="form-control" name="codEmpleadoDirector" id="codEmpleadoDirector">
                <option value="">-- Seleccionar --</option>
                @foreach ($listaGerentes as $itemGerente)
                  <option value="{{ $itemGerente->codEmpleado }}" {{ $itemGerente->isThisSelected($proyecto->codEmpleadoDirector) }}>
                    {{ $itemGerente->getNombreCompleto() }}
                  </option>
                @endforeach
              </select>


            </div>









            <div class="col-12 ">
              <label class="">Nombre del proyecto (Completo):</label>
              <div class="">
                <textarea class="form-control" name="nombreLargo" id="nombreLargo" rows="2">{{ $proyecto->nombreLargo }}</textarea>
              </div>
            </div>










            <div class="col">




            </div>

          </div>

        </div>
        <div class="card-footer text-right">

          <button type="button" class="btn btn-success" onclick="clickActualizar()">
            <i class='fas fa-save'></i>
            Guardar
          </button>
        </div>
      </div>




      <a href="{{ route('GestionProyectos.Listar') }}" class='btn btn-info '>
        <i class="fas fa-arrow-left"></i>
        Regresar al Menu
      </a>

    </form>
  </div>
@endsection

@include('Layout.ValidatorJS')
@section('script')
  <script>
    const ListaProyectos = @json($listaProyectos);


    const Existe = {{ $proyecto->existe() ? 'true' : 'false' }}

    function clickActualizar() {
      msjError = validarActualizacion();
      if (msjError != "") {
        alerta(msjError);
        return;
      }

      confirmarConMensaje("Confirmacion", "¿Desea crer el proyecto con la información ingresada?", "warning",
        submitearActualizacionInfoProyecto);
    }

    function submitearActualizacionInfoProyecto() {
      document.frmUpdateInfoProyecto.submit(); // enviamos el formulario
    }

    function validarActualizacion() {
      msjError = "";
      limpiarEstilos(['codigoPresupuestal', 'nombre', 'nombreLargo', 'codEmpleadoDirector', 'codSedePrincipal']);


      msjError = validarTamañoMaximoYNulidad(msjError, 'nombre', 100, 'Nombre');
      msjError = validarTamañoMaximoYNulidad(msjError, 'codigoPresupuestal', 5, 'Codigo Presupuestal');
      msjError = validarTamañoMaximoYNulidad(msjError, 'nombreLargo', 300, 'Nombre Largo');


      msjError = validarSelect(msjError, 'codEmpleadoDirector', "", 'Gerente');
      msjError = validarSelect(msjError, 'codSedePrincipal', "", 'Sede');


      const codigo = getVal('codigoPresupuestal');
      const codProyecto = "{{ $proyecto->codProyecto }}";
      //validamos si el codigo presupuestal ya esta siendo usado por otro proyecto
      const coincidentes = ListaProyectos.filter(p => p.codigoPresupuestal == codigo && p.codProyecto != codProyecto);
      if (coincidentes.length > 0) {
        ponerEnRojo('codigoPresupuestal')
        const pr = coincidentes[0];
        msjError = "El código presupuestal ya está siendo usado por el proyecto " + pr.nombre;
      }




      return msjError;

    }
  </script>
@endsection
@section('estilos')
@endsection
