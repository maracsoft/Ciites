@extends ('Layout.Plantilla')
@section('titulo')
  Registrar Viaje
@endsection

@section('contenido')
  @include('Layout.Loader')

  <div class="pb-1"></div>
  <div class="p-1 mb-2">
    <div class="page-title">
      Registrar Viaje
    </div>
  </div>

  @include('Layout.MensajeEmergenteDatos')

  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header d-flex ">
          <div class="font-weight-bold">
            Información de salida
          </div>
        </div>
        <div class="card-body">

          <form action="{{ route('ViajeVehiculo.Conductor.Guardar') }}" method="POST" name="form_viaje" id="form_viaje"
            enctype="multipart/form-data">

            <input type="hidden" name="codVehiculo" value="{{ $viaje->codVehiculo }}">
            <input type="hidden" name="codViaje" value="{{ $viaje->codViaje }}">

            @csrf

            <div class="row">

              <div class="col-12 col-sm-3">
                <label class="mb-0" for="">
                  Vehículo
                </label>
                <input type="text" class="form-control text-center" value="{{ $vehiculo->getDescripcion() }}" readonly>
              </div>


              <div class="col-12 col-xl-3  mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Aprobado por:
                </label>
                <select id="codEmpleadoAprobador" name="codEmpleadoAprobador" data-select2-id="1" tabindex="-1"
                  class="fondoBlanco form-control select2 select2-hidden-accessible selectpicker" aria-hidden="true" data-live-search="true">
                  <option value="">
                    - Aprobador -
                  </option>
                  @foreach ($listaEmpleados as $empleado)
                    <option value="{{ $empleado->getId() }}">
                      {{ $empleado->getNombreCompleto() }}
                    </option>
                  @endforeach
                </select>
              </div>


              <div class="col-12 col-xl-2 mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Kilometraje Salida
                </label>
                <input type="number" class="form-control text-right" id="kilometraje_salida" name="kilometraje_salida" value="">
              </div>


              <div class="col-12 col-xl-2  mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  F. Salida
                </label>
                <input type="text" class="form-control text-center px-1" id="fecha_salida" name="fecha_salida"
                  value="{{ $viaje->getFechaSalida() }}" placeholder="dd/mm/aaaa" autocomplete="off">
              </div>


              <div class="col-12 col-xl-2  mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Hora Salida
                </label>
                @include('ComponentesUI.HourSelector', ['name' => 'hora_salida'])
              </div>

              <div class="col-12 col-xl-6  mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Motivo
                </label>
                <textarea class="form-control" rows="2" id="motivo" name="motivo" autocomplete="off"></textarea>
              </div>

              <div class="col-12 col-xl-6  mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Observaciones salida
                </label>
                <textarea class="form-control" rows="2" id="observaciones_salida" name="observaciones_salida"></textarea>
              </div>

              <div class="col-12 col-sm-2  mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Lugar de origen
                </label>
                <input class="form-control" id="lugar_origen" name="lugar_origen" />
              </div>


              <div class="col-12 col-sm-2  mt-1 mt-sm-0">
                <label class="mb-0" for="">
                  Lugar de destino
                </label>
                <input class="form-control" id="lugar_destino" name="lugar_destino" />
              </div>


            </div>

            <div class="row mt-2">
              <div class="col-12">
                <div class="d-flex flex-row">

                  <input type="checkbox" class="my-auto cursor-pointer" id="declaro_estar_apto" name="declaro_estar_apto">


                  <label for="declaro_estar_apto" class="cursor-pointer my-auto mx-2 font-weight-normal">
                    Declaro estar apto fisicamente
                  </label>

                </div>

              </div>


            </div>


          </form>
        </div>
        <div class="card-footer">
          <div class="d-flex">

            <button type="button" onclick="clickGuardar()" class="ml-auto btn btn-success">
              Guardar
              <i class="fas fa-save"></i>
            </button>
          </div>
        </div>
      </div>

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
@endsection

@section('script')
  @include('Layout.ValidatorJS')
  <script>
    @include('ComponentesUI.HourSelectorJS')
  </script>

  <script>
    var hour_selector_salida;

    $(document).ready(function() {

      iniciarHourSelector();

      $('#fecha_salida').datepicker(date_config)


      $(".loader").fadeOut("slow");
    });

    function iniciarHourSelector() {
      hour_selector_salida = new HourSelector('hora_salida');

      let hora_salida = "{{ $viaje->getHoraSalida_HourSelector() }}";;

      if (hora_salida) {
        hour_selector_salida.setHoraFormatoSql(hora_salida);
      }

    }

    function clickGuardar() {
      var msj = validarFormViaje();
      if (msj != "") {
        alerta(msj)
        return;
      }

      confirmarConMensaje("Confirmación", "Seguro de registrar el viaje?", 'warning', function() {
        $(".loader").fadeIn("slow");
        document.form_viaje.submit();
      });


    }
  </script>
  <script>
    @include('ViajeVehiculo.ViajeJS')
  </script>
@endsection

@section('estilos')
  <style>

  </style>
  @include('CSS.RemoveInputNumberArrows')
@endsection
