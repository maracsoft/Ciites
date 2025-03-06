@extends ('Layout.Plantilla')
@section('titulo')
  {{ $title }}
@endsection

@section('contenido')
  @include('Layout.Loader')

  <div class="p-1 mb-2">
    <div class="page-title">
      {{ $title }}
    </div>
  </div>

  @include('Layout.MensajeEmergenteDatos')

  <div class="row">

    <div class="col-12 col-sm-8">
      <div class="card">
        <div class="card-header d-flex ">
          <div class="font-weight-bold">
            Información General
          </div>
          @if ($vehiculo->existe())
            <div class="fontSize9 ml-auto">
              {{ $vehiculo->getMensageRegistradoPor() }}
            </div>
          @endif


        </div>
        <div class="card-body">

          <form action="{{ $action }}" method="POST" name="form_vehiculo" id="form_vehiculo" enctype="multipart/form-data">

            <input type="hidden" name="codVehiculo" value="{{ $vehiculo->codVehiculo }}">

            @csrf

            <div class="row">


              <div class="col-12 col-sm-2">
                <label class="mb-0" for="">
                  Placa
                </label>
                <input type="text" class="form-control" value="{{ $vehiculo->placa }}" id="placa" name="placa">
              </div>

              <div class="col-12 col-sm-3">
                <label class="mb-0" for="">
                  Modelo
                </label>
                <input type="text" class="form-control" value="{{ $vehiculo->modelo }}" id="modelo" name="modelo">
              </div>

              <div class="col-12 col-sm-3">
                <label class="mb-0" for="">
                  Color
                </label>
                <input type="text" class="form-control" value="{{ $vehiculo->color }}" id="color" name="color">
              </div>
              <div class="col-12 col-sm-3">
                <label class="mb-0" for="">
                  Factura
                </label>
                <input type="text" class="form-control" value="{{ $vehiculo->codigo_factura }}" id="codigo_factura" name="codigo_factura">
              </div>

              <div class="col-12 col-sm-2">
                <label class="mb-0" for="">
                  Fecha de compra
                </label>
                <input type="text" class="form-control text-center" id="fecha_compra" name="fecha_compra"
                  value="{{ $vehiculo->getFechaCompra() }}" placeholder="dd/mm/aaaa">
              </div>


              <div class="col-12 col-sm-2">
                <label class="mb-0" for="">
                  Sede
                </label>
                <select class="form-control" name="codSede" id="codSede">
                  <option value="">- Sede -</option>
                  @foreach ($listaSedes as $sede)
                    <option value="{{ $sede->getId() }}" {{ $sede->isThisSelected($vehiculo->codSede) }}>
                      {{ $sede->nombre }}
                    </option>
                  @endforeach
                </select>
              </div>







              <div class="col-12 col-sm-3">
                <label class="mb-0" for="">
                  Kilometraje Inicial
                </label>
                <input type="number" class="form-control" value="{{ $vehiculo->kilometraje_actual }}" id="kilometraje_actual"
                  name="kilometraje_actual">
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


    @if ($vehiculo->existe())
      <div class="col-12 col-sm-4">
        <div class="card">
          <div class="card-header d-flex ">
            <div class="font-weight-bold">
              QR Code
            </div>
            <div class="ml-auto">
              <a class="btn btn-primary btn-sm" target="_blank" href="{{ route('Vehiculo.PDF.Ver', $vehiculo->getId()) }}">
                <i class="fas fa-file-pdf"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                El código QR redirije al registro de viajes
                <a href="{{ $vehiculo->getUrlRegistroViaje() }}">
                  {{ $vehiculo->getUrlRegistroViaje() }}
                </a>

              </div>
              <div class="col-12 text-center">
                {{ $vehiculo->getQrSvg() }}
              </div>

            </div>

          </div>
        </div>
      </div>
    @endif


  </div>

  <div class="row">
    <div class="col-12 col-sm-9 text-left">

      <a class="btn btn-info" href="{{ route('Vehiculo.Listar') }}">
        <i class="fas fa-arrow-left mr-1"></i>
        Volver
      </a>

    </div>

  </div>
@endsection

@section('script')
  @include('Layout.ValidatorJS')


  <script>
    $(document).ready(function() {

      $("#fecha_compra").datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        calendarWeeks: false,
        todayHighlight: true,
        endDate: "0d",
      })


      $(".loader").fadeOut("slow");
    });

    function clickGuardar() {
      var msj = validarForm();
      if (msj != "") {
        alerta(msj)
        return;
      }
      $(".loader").fadeIn("slow");
      document.form_vehiculo.submit();
    }



    function validarForm() {
      let msj = "";
      limpiarEstilos([
        'placa',
        'modelo',
        'fecha_compra',
        'codSede',
        'color',
        'codigo_factura',

        'kilometraje_actual'
      ]);


      msj = validarSelect(msj, "codSede", "", "Sede");

      msj = validarTamañoMaximoYNulidad(msj, "placa", 15, "Placa");
      msj = validarTamañoMaximoYNulidad(msj, "modelo", 100, "Modelo");
      msj = validarTamañoMaximoYNulidad(msj, "color", 100, "Color");
      msj = validarTamañoMaximoYNulidad(msj, "codigo_factura", 100, "Factura");

      msj = validarNulidad(msj, "fecha_compra", "Fecha de Compra");
      msj = validarNulidad(msj, "kilometraje_actual", "Kilometraje Actual");


      let placa_ingresada = getVal("placa");
      setVal("placa", placa_ingresada.toUpperCase());

      if (!esPlacaValida(placa_ingresada)) {
        ponerEnRojo("placa");
        msj = "La placa ingresada no es válida";
      }

      return msj;
    }
  </script>
@endsection

@section('estilos')
  <style>


  </style>
  @include('CSS.RemoveInputNumberArrows')
@endsection
