@extends ('Layout.Plantilla')
@section('titulo')
  Ver Viaje
@endsection

@section('contenido')
  @include('Layout.Loader')

  <div class="p-1 mb-2">
    <div class="page-title">
      Ver Viaje
    </div>
  </div>

  @include('Layout.MensajeEmergenteDatos')

  <div class="row">
    <div class="col-xl-12">

      @include('ViajeVehiculo.PlantillaViaje')

    </div>



    <div class="col-12 text-right p-2">
      @if ($viaje->sePuedeEditar())
        <div id="div_bloqueo_edicion">

        </div>

        <button data-toggle="modal" data-target="#ModalEditarViaje" class="btn btn-sm btn-warning" id="boton_editar">
          <i class="fas fa-pen mr-1"></i>
          Editar datos salida
        </button>
      @endif

      @if ($viaje->sePuedeFinalizarPorLogeado($empLogeado))
        <button data-toggle="modal" data-target="#ModalFinalizarViaje" class="btn btn-sm btn-info">
          <i class="fas fa-check mr-1"></i>
          Finalizar viaje
        </button>
      @endif
    </div>




  </div>

  <div class="row">
    <div class="col-12 col-xl-9 text-left">

      <a class="btn btn-info" href="{{ route('ViajeVehiculo.Conductor.Listar') }}">
        <i class="fas fa-arrow-left mr-1"></i>
        Volver
      </a>

    </div>

  </div>


  <div class="modal fade" id="ModalEditarViaje" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Editar datos de salida
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form action="{{ route('ViajeVehiculo.Conductor.ActualizarDatosSalida') }}" id="frmEditarViaje" name="frmEditarViaje"
            method="POST">
            <input type="hidden" name="codViaje" value="{{ $viaje->codViaje }}">
            @csrf
            <div class="row">


              <div class="col-12 col-sm-4">
                <label class="mb-0" for="">
                  Vehículo
                </label>
                <input type="text" class="form-control text-center" value="{{ $vehiculo->getDescripcion() }}" readonly>
              </div>


              <div class="col-12 col-xl-8  mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Aprobado por:
                </label>
                <select id="codEmpleadoAprobador" name="codEmpleadoAprobador" data-select2-id="1" tabindex="-1"
                  class="fondoBlanco form-control select2 select2-hidden-accessible selectpicker" aria-hidden="true" data-live-search="true">
                  <option value="">
                    - Aprobador -
                  </option>
                  @foreach ($listaAprobadores as $empleado)
                    <option value="{{ $empleado->getId() }}" @if ($empleado->getId() == $viaje->codEmpleadoAprobador) selected @endif>
                      {{ $empleado->getNombreCompleto() }}
                    </option>
                  @endforeach
                </select>
              </div>


              <div class="col-12 col-xl-3 mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Km. Salida
                </label>
                <input type="number" class="form-control text-right" id="kilometraje_salida" name="kilometraje_salida"
                  value="{{ $viaje->kilometraje_salida }}">
              </div>


              <div class="col-12 col-xl-4  mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  F. Salida
                </label>
                <input type="text" class="form-control text-center px-1" id="fecha_salida" name="fecha_salida"
                  value="{{ $viaje->getFechaSalida() }}" placeholder="dd/mm/aaaa" autocomplete="off">
              </div>


              <div class="col-12 col-xl-5  mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Hora Salida
                </label>
                @include('ComponentesUI.HourSelector', ['name' => 'hora_salida'])
              </div>

              <div class="col-12 mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Motivo
                </label>
                <textarea class="form-control" rows="2" id="motivo" name="motivo" autocomplete="off">{{ $viaje->motivo }}</textarea>
              </div>

              <div class="col-12  mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Observaciones salida
                </label>
                <textarea class="form-control" rows="2" id="observaciones_salida" name="observaciones_salida">{{ $viaje->observaciones_salida }}</textarea>
              </div>

              <div class="col-12 col-sm-4  mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Lugar de origen
                </label>
                <input class="form-control" id="lugar_origen" name="lugar_origen" value="{{ $viaje->lugar_origen }}" />
              </div>


              <div class="col-12 col-sm-4  mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Lugar de destino
                </label>
                <input class="form-control" id="lugar_destino" name="lugar_destino" value="{{ $viaje->lugar_destino }}" />
              </div>



            </div>



          </form>




        </div>

        <div class="modal-footer">

          <button type="button" onclick="clickActualizarViaje()" class="btn btn-success">
            <i class="fas fa-save mr-1"></i>

            Guardar

          </button>
        </div>

      </div>
    </div>
  </div>


  <div class="modal fade" id="ModalFinalizarViaje" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Finalizar viaje
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form action="{{ route('ViajeVehiculo.Conductor.Finalizar') }}" id="frmFinalizarViaje" name="frmFinalizarViaje" method="POST">
            <input type="hidden" name="codViaje" value="{{ $viaje->codViaje }}">
            @csrf
            <div class="row">

              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <label class="mb-0" for="">
                  Kilometraje Llegada
                </label>
                <input type="number" class="form-control text-right" id="kilometraje_llegada" name="kilometraje_llegada"
                  value="{{ $viaje->kilometraje_llegada }}">
              </div>

              <div class="col-12  col-sm-6 mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Factura Combustible
                  {{--  <span class="fontSize8">(Serie y Monto)</span> --}}
                </label>
                <div class="d-flex flex-row">
                  <input type="text" class="form-control text-center" id="codigo_factura_combustible" name="codigo_factura_combustible"
                    value="{{ $viaje->codigo_factura_combustible }}" placeholder="N° Serie">
                  <input type="number" class="ml-2 form-control text-right" id="monto_factura_combustible"
                    name="monto_factura_combustible" value="{{ $viaje->monto_factura_combustible }}" placeholder="Monto Soles">
                </div>
              </div>


              <div class="col-12   mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Fecha Llegada
                </label>
                <input type="text" class="form-control text-center px-1" id="fecha_llegada" name="fecha_llegada"
                  value="{{ $viaje->getFechaLlegada() }}" placeholder="dd/mm/aaaa" autocomplete="off">

              </div>

              <div class="col-12 mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Hora Llegada
                </label>
                @include('ComponentesUI.HourSelector', ['name' => 'hora_llegada'])

              </div>

              <div class="col-12   mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Observaciones Llegada
                </label>
                <textarea class="form-control" rows="2" id="observaciones_llegada" name="observaciones_llegada"></textarea>

              </div>



            </div>



          </form>




        </div>

        <div class="modal-footer">

          <button type="button" onclick="clickFinalizarViaje()" class="btn btn-success">
            <i class="fas fa-save mr-1"></i>

            Guardar

          </button>
        </div>

      </div>
    </div>
  </div>
@endsection

@section('script')
  @include('Layout.ValidatorJS')
  <script>
    @include('ComponentesUI.HourSelectorJS')
  </script>

  <script>
    const SePuedeEditar = {{ $viaje->sePuedeEditar() ? 'true' : 'false' }};
    const SegundosFaltantesParaBloqueoEdicion = {{ $viaje->getSegundosFaltantesParaBloqueoEdicion() }};

    $(document).ready(function() {

      iniciarHourSelector()
      $('#fecha_llegada').datepicker(date_config)
      $('#fecha_salida').datepicker(date_config)

      if (SePuedeEditar) {
        const countdown = new Countdown('div_bloqueo_edicion', 'Tiempo restante para editar el viaje: ');
        countdown.init(SegundosFaltantesParaBloqueoEdicion, () => {

          //eliminamos el boton de edición
          $('#boton_editar').remove();

        });
      }

      $(".loader").fadeOut("slow");
    });
  </script>
  <script>
    var hour_selector_llegada;


    function clickFinalizarViaje() {
      let error = validarFinalizarViaje();
      if (error != "") {
        alerta(error);
        return;
      }


      $(".loader").fadeIn("slow");
      document.frmFinalizarViaje.submit();
    }

    function validarFinalizarViaje() {
      limpiarEstilos([
        'kilometraje_llegada',
        'fecha_llegada',
        'codigo_factura_combustible',
        'monto_factura_combustible',
      ]);

      let msj = "";
      msj = validarTamañoMaximoYNulidad(msj, "codigo_factura_combustible", 100, "Código Factura Combustible");
      msj = validarPositividadYNulidad(msj, "monto_factura_combustible", "Monto Factura Combustible");
      msj = validarNulidad(msj, "fecha_llegada", "Fecha Llegada");
      msj = validarPositividadYNulidad(msj, "kilometraje_llegada", "Kilometraje Llegada");
      msj = hour_selector_llegada.validar(msj);


      let km_llegada = parseFloat(getVal("kilometraje_llegada"));
      let km_salida = parseFloat("{{ $viaje->kilometraje_salida }}");

      if (km_llegada < km_salida) {
        msj = "El kilometraje de llegada debe ser mayor o igual al kilometraje de salida";
      }


      let fecha_salida = "{{ $viaje->getFechaSalida() }}";
      let fecha_llegada = getVal("fecha_llegada");
      if (!compararFechas(fecha_salida, fecha_llegada)) {
        msj = "La fecha de salida no puede ser mayor a la fecha de llegada";
      }

      return msj;
    }

    function iniciarHourSelector() {

      hour_selector_salida = new HourSelector('hora_salida');
      hour_selector_llegada = new HourSelector('hora_llegada');

      let hora_llegada = "{{ $viaje->getHoraLlegada() }}";;
      let hora_salida = "{{ $viaje->getHoraSalida_HourSelector() }}";;

      if (hora_llegada) {
        hour_selector_llegada.setHoraFormatoSql(hora_llegada);
      }
      if (hora_salida) {
        hour_selector_salida.setHoraFormatoSql(hora_salida);
      }

    }


    function clickActualizarViaje() {
      var msj = validarFormViaje();
      if (msj != "") {
        alerta(msj)
        return;
      }

      confirmarConMensaje("Confirmación", "Seguro de actualizar los datos?", 'warning', function() {
        $(".loader").fadeIn("slow");
        document.frmEditarViaje.submit();
      });

    }
  </script>
  <script>
    @include('ViajeVehiculo.ViajeJS')

    @include('ComponentesUI.CuentaRegresivaJS')
  </script>
  <script></script>
@endsection

@section('estilos')
  <style>

  </style>
  @include('CSS.RemoveInputNumberArrows')
@endsection
