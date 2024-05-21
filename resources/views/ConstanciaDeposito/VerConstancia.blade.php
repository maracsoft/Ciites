@extends ('Layout.Plantilla')
@section('titulo')
  Ver Bono
@endsection

@section('contenido')
@include('Layout.Loader')

<div class="p-1 mb-2">
  <div class="page-title">
    Ver Bono
  </div>
</div>

@include('Layout.MensajeEmergenteDatos')

<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <label for="" class="mb-0">
          <h3 class="mb-0">
            Información General
          </h3>
        </label>
      </div>
      <div class="card-body">
        {{$bono->renderPlantilla()}}
      </div>
      <div class="card-footer">

      </div>
    </div>

  </div>

</div>

<div class="row">
  <div class="col-12 col-sm-9 text-left">

    <a class="btn btn-info" href="{{route('BonosVentas.CoordinadorVentas.Listar')}}">
      <i class="fas fa-arrow-left mr-1"></i>
      Volver
    </a>

  </div>

</div>



@endsection

@section('script')
@include('Layout.ValidatorJS')


<script>



  $(document).ready(function(){

    $(".loader").fadeOut("slow");
  });




</script>



@endsection

@section('estilos')
@include('CSS.RemoveInputArrows')
@endsection
