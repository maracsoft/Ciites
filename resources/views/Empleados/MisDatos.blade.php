@extends('Layout.Plantilla')
@section('titulo')
  Mis Datos
@endsection
@section('contenido')
  <div class="p-1">
    <div class="page-title">
      Mis datos personales
    </div>
  </div>

  @include('Layout.MensajeEmergenteDatos')

  <form id="frmEmpleado" name="frmEmpleado" action="{{ route('GestionUsuarios.updateDPersonales') }}" method="post">
    @csrf
    <input type="text" id="codEmpleado" name="codEmpleado" placeholder="Codigo" value="{{ $empleado->codEmpleado }}" hidden>

    <div class="row">
      <div class="col-12 col-sm-2"></div>
      <div class="col-12 col-sm-8">
        <div class="card">
          <div class="card-header font-weight-bold">
            <i class="fas fa-user-circle"></i>
            Datos Personales

          </div>
          <div class="card-body">

            <div class="row">
              <div class="col-12 col-sm-3">
                <label class="mb-0">Nombres:</label>
                <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres..."
                  value="{{ $empleado->nombres }}" readonly>
              </div>
              <div class="col-12 col-sm-3">
                <label class="mb-0">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos..."
                  value="{{ $empleado->apellidos }}" readonly>
              </div>
              <div class="col-12 col-sm-3">
                <label class="mb-0">DNI:</label>
                <input type="number" class="form-control" id="DNI" name="DNI" placeholder="DNI..." value="{{ $empleado->dni }}"
                  readonly>
              </div>
              <div class="col-12 col-sm-3">
                <label class="mb-0">Correo:</label>
                <input type="text" class="form-control" id="correo" name="correo" placeholder="correo..."
                  value="{{ $empleado->correo }}">
              </div>
              <div class="col-12 col-sm-3">
                <label class="mb-0">Sexo:</label>
                <select class="form-control" name="sexo" id="sexo">
                  <option value="-1">- Sexo -</option>
                  <option value="M" {{ 'M' == $empleado->sexo ? 'selected' : '' }}>Mujer</option>
                  <option value="H" {{ 'H' == $empleado->sexo ? 'selected' : '' }}>Hombre</option>
                </select>
              </div>
              <div class="col-12 col-sm-3">
                <label class="mb-0">Fecha Nacimiento:</label>
                <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                  {{-- INPUT PARA EL CBTE DE LA FECHA --}}
                  <input type="text" style="text-align: center" class="form-control" name="fechaNacimiento" id="fechaNacimiento"
                    value="{{ $empleado->getFechaNacimiento() }}">

                  <div class="input-group-btn">
                    <button class="btn btn-primary date-set" type="button" onclick="">
                      <i class="fas fa-calendar fa-xs"></i>
                    </button>
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-6">
                <label class="mb-0">Nombre del cargo:</label>
                <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo..."
                  value="{{ $empleado->nombreCargo }}">
              </div>
              <div class="col-12 col-sm-6">
                <label class="mb-0">Direccion:</label>
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion..."
                  value="{{ $empleado->direccion }}">
              </div>
              <div class="col-12 col-sm-3">
                <label class="mb-0">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono..."
                  value="{{ $empleado->nroTelefono }}">
              </div>




            </div>



          </div>

        </div>


        <div class="card">
          <div class="card-header font-weight-bold">
            <i class="fas fa-cog"></i>
            Preferencias

          </div>
          <div class="card-body">

            <div class="row">
              <div class="col-12 col-sm-4">
                <label class="mb-0">Tipo de menu lateral:</label>
                <select class="form-control" name="tipo_menu_lateral" id="tipo_menu_lateral">
                  <option value="-1">- Tipo -</option>
                  <option value="agrupado" {{ 'agrupado' == $empleado->tipo_menu_lateral ? 'selected' : '' }}>
                    Agrupado
                  </option>
                  <option value="desagrupado" {{ 'desagrupado' == $empleado->tipo_menu_lateral ? 'selected' : '' }}>
                    Desagrupado
                  </option>
                </select>
                <div class="explicacion">
                  Determina si el menú lateral izquierdo se muestra agrupado o se muestra de forma desagregada. Es especialmente útil si tiene
                  muchos roles en el sistema.
                </div>
              </div>


            </div>



          </div>

        </div>


        <div class="card">
          <div class="card-header text-right">
            <button type="button" class="btn btn-success" onclick="validarCambioDatos()">
              Guardar
              <i class='ml-1 fas fa-save'></i>
            </button>

          </div>
        </div>



      </div>
      <div class="col-12 col-sm-2"></div>

    </div>
  </form>
@endsection
@section('script')
  @include('Layout.ValidatorJS')

  <script>
    function validarFormulario() {
      limpiarEstilos(
        ['correo', 'sexo', 'fechaNacimiento', 'cargo', 'direccion', 'telefono']);
      msj = "";
      msj = validarTamañoMaximoYNulidad(msj, 'correo', 60, 'correo');
      msj = validarNulidad(msj, 'fechaNacimiento', 'Fecha de Nacimiento');
      msj = validarTamañoMaximoYNulidad(msj, 'cargo', 100, 'Nombre del Cargo');
      msj = validarTamañoMaximoYNulidad(msj, 'direccion', 300, 'Direccion');
      msj = validarTamañoMaximoYNulidad(msj, 'telefono', 20, 'Telefono');
      msj = validarSelect(msj, 'sexo', -1, 'Sexo');
      msj = validarSelect(msj, 'tipo_menu_lateral', -1, 'Tipo de menu lateral');



      return msj;
    }

    function validarCambioDatos() {
      msj = validarFormulario();
      if (msj != '') {
        alerta(msj);
        return;
      }
      confirmarConMensaje('Confirmacion', '¿Seguro de guardar los cambios?', 'warning', ejecutarSubmit);
    }

    function ejecutarSubmit() {

      document.frmEmpleado.submit(); // enviamos el formulario

    }
  </script>
@endsection

@section('estilos')
  <style>

  </style>
@endsection
