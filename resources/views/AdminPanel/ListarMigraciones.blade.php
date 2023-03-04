
@extends('Layout.Plantilla')
@section('titulo')
    Flujograma
@endsection
@section('tiempoEspera')
    <div class="loader" id="pantallaCarga"></div>
@endsection
@section('contenido')

@include('Layout.MensajeEmergenteDatos')
     


 
<div class="row p-5">
 

  <div class="col-12">
    <div class="d-flex">
      <label for="">
        Log de migraciones:
      </label>
      <button class="ml-auto btn btn-sm btn-primary m-2" onclick="correrMigraciones()">
        Correr migraciones pendientes
      </button>
    </div>

 
    <textarea readonly id="consola" class="consola" cols="70" rows="13"></textarea>
  </div>

 

  <div class="col-12">
    <h1>
      Migraciones Existentes como archivo y DB
    </h1>


    <div id="ContenedorTablaMigraciones">

    </div>
    
 

  </div>
</div>

@endsection

@section('script')
<script>
    const Consola = document.getElementById('consola');
    const ContenedorTablaMigraciones = document.getElementById('ContenedorTablaMigraciones');
    


    $(document).ready(function(){

        recargarTablaMigraciones();


        $(".loader").fadeOut("slow");
    });
  
    function recargarTablaMigraciones(){
      $.get('/Migraciones/Inv_ListarMigraciones',function(data){
        ContenedorTablaMigraciones.innerHTML = data;
      });

    }
    
    function correrMigraciones(){
        $(".loader").show();
        $.get('/DB/CorrerMigraciones',function(data){
            $(".loader").fadeOut("slow");
            objetoRespuesta = JSON.parse(data);
            Consola.value = objetoRespuesta.datos;
            alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);

        });
        recargarTablaMigraciones();

    }

</script>
@endsection

@section('estilos')
<style>
    .card-body > .btn{
        margin:3px;
    }


    .consola{
      background-color: black;
      color:White;
      width: 100%;
      padding: 0.375rem 0.75rem;
    }
    .consola:focus{
      background-color: black;
      color:White;
    }
    
</style>
@endsection



