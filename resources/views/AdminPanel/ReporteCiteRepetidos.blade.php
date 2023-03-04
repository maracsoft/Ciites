
@extends('Layout.Plantilla')
@section('titulo')
    Flujograma
@endsection
@section('tiempoEspera')
    <div class="loader" id="pantallaCarga"></div>
@endsection
@section('contenido')

@include('Layout.MensajeEmergenteDatos')
     


  <div>
    <h2>
      USUARIOS REPETIDOS:
    </h2>
  </div>
  
  <div class="row">
    @foreach ($usuarios_repetidos as $usuario)
      <div class="col-12">
          DNI: {{$usuario->dni}}       
      </div>
    @endforeach
  </div>



  
  <div>
    <h2>
      Relaciones Usuario-Unidad REPETIDOS (codUsuario-codUnidadProductiva):
    </h2>
  </div>
  
  <div class="row">
    @foreach ($relaciones_usuario_unidad as $rela){{$rela->relacion}},@endforeach
  </div>
  

  
  <div>
    <h2>
      Relaciones Usuario-Servicio (asistencia) REPETIDOS:
    </h2>
  </div>
  
  <div class="row">
    @foreach ($relaciones_usuario_servicio as $rela){{$rela->relacion}},@endforeach
  </div>
  


@endsection

@section('script')
<script>
    $(document).ready(function(){
        $(".loader").fadeOut("slow");
    });

    function generarBackup(){
        $(".loader").show();
        $.get('/DB/GenerarBackup',function(data){
            $(".loader").fadeOut("slow");
            objetoRespuesta = JSON.parse(data);
            alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);

        });

    }

    function testearPOST(){
      document.formTestearPost.submit();
    }
 
    

</script>
@endsection

@section('estilos')
<style>
    .card-body > .btn{
        margin:3px;
    }
</style>
@endsection



