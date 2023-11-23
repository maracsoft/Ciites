@extends('Layout.Plantilla')

@section('titulo')
  Contrato Plazo Fijo
@endsection

@section('contenido')
  <div class="p-2">
    <div class="page-title">
      Crear Contrato Plazo Fijo
    </div>
  </div>

  <form method = "POST" action = "{{ route('ContratosPlazo.Guardar') }}" onsubmit="" id="frmPlazoFijo" name="frmPlazoFijo">


    @csrf

    <div class="row">
      <div class="col-12 col-md-8">


        <div class="card">
          <div class="card-header">
            <b>
              Datos del contratado:
            </b>
          </div>
          <div class="card-body">
            <div class="row">

              <div class="col-12 col-md-3">

                <div class="label_movil_container">
                  <input type="number" class="form-control" name="dni" id="dni" value="" placeholder="">
                  <label for="dni" class="label_movil">dni</label>
                </div>

              </div>

              <div class="col-12 col-md-3">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="nombres" id="nombres" value=""  placeholder="">
                  <label for="nombres" class="label_movil">nombres</label>
                </div>
              </div>


              <div class="col-12 col-md-3">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="apellidos" id="apellidos" value=""  placeholder="">
                  <label for="apellidos" class="label_movil">apellidos</label>
                </div>
              </div>
              <div class="col-12 col-md-3">
                <div class="label_movil_container">
                  <select class="form-control" name="sexo" id="sexo">
                    <option value="-1">- Seleccionar - </option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                  </select>
                  <label for="sexo" class="label_movil">sexo</label>
                </div>
              </div>


              <div class="col-12 col-md-4">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="domicilio" id="domicilio" value=""  placeholder="">
                  <label for="domicilio" class="label_movil">domicilio</label>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
      <div class="col-12 col-md-4">
        <div class="card">
          <div class="card-header">
            <b>
              Datos del convenio/adenda con financiera:
            </b>
          </div>
          <div class="card-body">
            <div class="row">


              <div class="col-12">
                <div class="label_movil_container">
                  <select class="form-control" name="tipo_adenda_financiera" id="tipo_adenda_financiera">
                    <option value="-1">- Seleccionar - </option>
                    @foreach ($listaTipoAdenda as $tipo)
                      <option value="{{ $tipo }}">
                        {{ strtoupper($tipo) }}
                      </option>
                    @endforeach
                  </select>
                  <label for="tipo_adenda_financiera" class="label_movil">Tipo adenda financiera</label>
                </div>
              </div>



              <div class="col-12 col-md-12">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="nombre_contrato_locacion" id="nombre_contrato_locacion" placeholder="">
                  <label for="nombre_contrato_locacion" class="label_movil">Nombre contrato Locación</label>
                </div>
              </div>

              <div class="col-4 col-md-4">
                <div class="label_movil_container">
                  <input type="text" class="form-control text-center" name="duracion_convenio_numero" id="duracion_convenio_numero" placeholder="">
                  <label for="duracion_convenio_numero" class="label_movil">Cantidad</label>
                </div>
              </div>

              <div class="col-8 col-md-8">
                <div class="label_movil_container">
                  <select class="form-control" name="duracion_convenio_unidad_temporal" id="duracion_convenio_unidad_temporal">
                    <option value="-1">- Seleccionar - </option>
                    @foreach ($tiposTiempos as $tiempo)
                      <option value="{{ $tiempo }}">
                        {{ mb_strtoupper($tiempo) }}
                      </option>
                    @endforeach
                  </select>
                  <label for="duracion_convenio_unidad_temporal" class="label_movil">Unidad Tiempo</label>
                </div>
              </div>


              <div class="col-12 col-md-12">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="nombre_financiera" id="nombre_financiera" placeholder="">
                  <label for="nombre_financiera" class="label_movil">Financiera</label>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>


    <div class="card">
      <div class="card-header">
        <b>
          Datos del Contrato
        </b>
      </div>
      <div class="card-body">

        <div class="row">

          <div class="col-12 col-md-4">
            <div class="label_movil_container">
              <input type="text" class="form-control" name="puesto" id="puesto" placeholder="">
              <label for="puesto" class="label_movil">Puesto</label>
            </div>
          </div>


          <div class="col-12 col-md-2">
            <div class="label_movil_container">
              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                <input type="text" class="form-control text-center" autocomplete="off" name="fecha_inicio_prueba" id="fecha_inicio_prueba" placeholder="">
                <label for="fecha_inicio_prueba" class="label_movil">Fecha Inicio Prueba</label>
                <div class="input-group-btn">
                  <button class="btn btn-primary date-set d-none" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>

            </div>


          </div>
          <div class="col-12 col-md-2">
            <div class="label_movil_container">
              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                <input type="text" class="form-control text-center" autocomplete="off" name="fecha_fin_prueba" id="fecha_fin_prueba" placeholder="">
                <label for="fecha_fin_prueba" class="label_movil">Fecha Fin Prueba</label>
                <div class="input-group-btn">
                  <button class="btn btn-primary date-set d-none" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>



          <div class="col-12 col-md-2">
            <div class="label_movil_container">
              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                <input type="text" class="form-control text-center" autocomplete="off" name="fecha_inicio_contrato" id="fecha_inicio_contrato" placeholder="">
                <label for="fecha_inicio_contrato" class="label_movil">Fecha Inicio Contrato</label>
                <div class="input-group-btn">
                  <button class="btn btn-primary date-set d-none" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>

            </div>


          </div>
          <div class="col-12 col-md-2">
            <div class="label_movil_container">
              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                <input type="text" class="form-control text-center" autocomplete="off" name="fecha_fin_contrato" id="fecha_fin_contrato" placeholder="">
                <label for="fecha_fin_contrato" class="label_movil">Fecha Fin Contrato</label>
                <div class="input-group-btn">
                  <button class="btn btn-primary date-set d-none" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-3">
            <div class="label_movil_container">
              <input type="number" min="0" class="form-control text-right" name="remuneracion_mensual" id="remuneracion_mensual" value="" placeholder="">
              <label for="remuneracion_mensual" class="label_movil">Remuneración Mensual</label>
            </div>
          </div>


          <div class="col-12 col-md-3">
            <div class="label_movil_container">
              <select class="form-control" name="codMoneda" id="codMoneda">
                <option value="-1">- Moneda - </option>
                @foreach ($listaMonedas as $moneda)
                  <option value="{{ $moneda->codMoneda }}">
                    {{ $moneda->nombre }}
                  </option>
                @endforeach
              </select>
              <label for="codMoneda" class="label_movil">Moneda</label>
            </div>

          </div>



          <div class="col-12 col-md-3">
            <div class="label_movil_container">
              <input type="number" min="0" class="form-control" name="cantidad_dias_labor" id="cantidad_dias_labor" value="" placeholder="">
              <label for="cantidad_dias_labor" class="label_movil">Cantidad Días de Labor</label>
            </div>
          </div>

          <div class="col-12 col-md-3">
            <div class="label_movil_container">
              <input type="number" min="0" class="form-control" name="cantidad_dias_descanso" id="cantidad_dias_descanso" value="" placeholder="">
              <label for="cantidad_dias_descanso" class="label_movil">Cantidad Días de Descanso</label>
            </div>
          </div>









        </div>
      </div>
    </div>









    <div class="row m-3">
      <div class="col text-left">

        <a href="{{ route('ContratosPlazo.Listar') }}" class='btn btn-info '>
          <i class="fas fa-arrow-left"></i>
          Regresar al Menu
        </a>

      </div>
      <div class="col text-right">
        <button type="button" class="btn btn-primary" id="btnRegistrar"
          data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" onclick="registrar()">

          <i class='fas fa-save'></i>
          Registrar
        </button>
      </div>



    </div>

  </form>
@endsection

{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}

@include('Layout.EstilosPegados')
@include('Layout.ValidatorJS')
@section('script')
  {{-- <script src="/public/select2/bootstrap-select.min.js"></script>      --}}
  <script>
    var cont = 0;
    var total = 0;
    var detalleAvance = [];
    var modo;

    $(document).ready(function() {

    });

    function registrar() {

      msje = validarFormCrear();
      if (msje != "") {
        alerta(msje);
        return false;
      }

      confirmar('¿Estás seguro de crear el contrato?', 'info', 'frmPlazoFijo');

    }

    var listaArchivos = '';

    function validarFormCrear() { //Retorna TRUE si es que todo esta OK y se puede hacer el submit
      msj = '';
      limpiarEstilos(['domicilio','puesto','tipo_adenda_financiera','nombre_financiera','duracion_convenio_numero','duracion_convenio_unidad_temporal','nombre_contrato_locacion','fecha_inicio_prueba','fecha_fin_prueba','fecha_inicio_contrato','fecha_fin_contrato','cantidad_dias_labor','cantidad_dias_descanso','remuneracion_mensual','codMoneda','nombres','dni','apellidos','sexo','domicilio']);

      /* Card 1 */
      msj = validarTamañoExacto(msj, 'dni', '8', 'DNI');
      msj = validarTamañoMaximoYNulidad(msj, 'nombres', 100, 'Nombres');
      msj = validarTamañoMaximoYNulidad(msj, 'apellidos', 100, 'Apellidos');
      msj = validarSelect(msj, 'sexo', '-1', 'Sexo');
      msj = validarTamañoMaximoYNulidad(msj, 'domicilio', 100, 'Domicilio');

      /* Card 2 */
      msj = validarSelect(msj, 'tipo_adenda_financiera', '-1', 'Tipo de Adenda financiera');
      msj = validarTamañoMaximoYNulidad(msj, 'nombre_contrato_locacion', 100, 'Nombre del Contrato de Locación');
      msj = validarPositividadYNulidad(msj, 'duracion_convenio_numero', 'Duración del convenio (Número)');
      msj = validarSelect(msj, 'duracion_convenio_unidad_temporal', '-1', 'Duración del Convenio (Unidad de Tiempo)');
      msj = validarTamañoMaximoYNulidad(msj, 'nombre_financiera', 100, 'Financiera');

      /* CARD 3 */

      msj = validarTamañoMaximoYNulidad(msj, 'puesto', 200, 'Nombre del Puesto');
      msj = validarTamañoMaximoYNulidad(msj, 'fecha_inicio_prueba', 500, 'Fecha de Inicio del periodo de Prueba');
      msj = validarTamañoMaximoYNulidad(msj, 'fecha_fin_prueba', 500, 'Fecha de Fin del periodo de Prueba');
      msj = validarTamañoMaximoYNulidad(msj, 'fecha_inicio_contrato', 500, 'Fecha de inicio del contrato');
      msj = validarTamañoMaximoYNulidad(msj, 'fecha_fin_contrato', 500, 'Fecha de fin del contrato');
      msj = validarPositividadYNulidad(msj, 'remuneracion_mensual', 'Remuneración Mensual');
      msj = validarSelect(msj, 'codMoneda', '-1', 'Moneda');
      msj = validarPositividadYNulidad(msj, 'cantidad_dias_labor', 'Cantida de días de labor');
      msj = validarPositividadYNulidad(msj, 'cantidad_dias_descanso', 'Cantidad de días de descanso');

      return msj;
    }
  </script>
@endsection

@section('estilos')

@include('CSS.RemoveInputNumberArrows')
<style>



</style>
@endsection
