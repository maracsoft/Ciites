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





  </div>

  <div class="row">
    <div class="col-12 col-xl-9 text-left">

      <a class="btn btn-info" href="{{ route('ViajeVehiculo.Contador.Listar') }}">
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
    $(document).ready(function() {



      $(".loader").fadeOut("slow");
    });
  </script>
  <script></script>
@endsection

@section('estilos')
  <style>

  </style>
  @include('CSS.RemoveInputNumberArrows')
@endsection
