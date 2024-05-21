@extends ('Layout.Plantilla')
@section('titulo')
  Listar Periodos de Directores
@endsection

@section('contenido')

@include('Layout.Loader')


  <div style="">
    <div class="p-1">
      <div class="page-title">
        Listar Periodos de Directores
      </div>
    </div>

    <div class="row col-12 text-left">
      <button class="btn btn-primary" type="button" onclick="clickAgregarPeriodo()">
        Nuevo
        <i class="fas fa-plus"></i>
      </button>

    </div>
    <div id="container_periodos">
      @include('PeriodoDirector.Inv_ListaPeriodos')
    </div>

  </div>


  
<div class="modal fade" id="ModalInvocable" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal modal-dialog-centered">
    <div class="modal-content" id="container_modal_invocable">

    </div>
  </div>
</div>




@endsection


@section('estilos')
  
<style>
  .estado_periodo{
    padding: 2px;
    border-radius: 5px;
    outline: 1px solid rgb(205, 205, 205);
    text-align: center;
  }

  .estado_periodo.ACTIVO{
    background-color: rgb(37, 187, 0);
    color:white;
  }
  .estado_periodo.INACTIVO{
    background-color: rgb(51, 51, 51);
    color:white;
  }

</style>
@endsection


@section('script')
@include('Layout.ValidatorJS')
<script>

    
  var ModalInvocable = new bootstrap.Modal(document.getElementById("ModalInvocable"), {});


  function recargarInvocables(){
    var ruta = "{{route('PeriodoDirector.Inv_Listar')}}";
    invocarHtmlEnID_async(ruta, "container_periodos");
  }

  $(document).ready(function() {
    $(".loader").fadeOut("slow");
  });

  function limpiarContenidoModal(){
    document.getElementById("container_modal_invocable").innerHTML = "";
  }



  /* ************************* CRUD PERIODOSS ***************************** */
  /* ************************* CRUD PERIODOSS ***************************** */
  /* ************************* CRUD PERIODOSS ***************************** */
  /* ************************* CRUD PERIODOSS ***************************** */
  /* ************************* CRUD PERIODOSS ***************************** */
  /* ************************* CRUD PERIODOSS ***************************** */
  /* ************************* CRUD PERIODOSS ***************************** */
  /* ************************* CRUD PERIODOSS ***************************** */
  /* ************************* CRUD PERIODOSS ***************************** */

  function clickAgregarPeriodo(){
    invocarModalPeriodo(0);
  }

  function clickEditarPeriodo(codPeriodoDirector){
    invocarModalPeriodo(codPeriodoDirector);
  }

  async function invocarModalPeriodo(codPeriodoDirector){
    limpiarContenidoModal();

    var ruta = "/PeriodoDirector/GetFormInvocable/"+codPeriodoDirector;
    $(".loader").show();
    await invocarHtmlEnID_async(ruta,"container_modal_invocable");
    $(".loader").hide();
    ModalInvocable.show();

  }

  function clickGuardarPeriodo(){
    msj = validarFormPeriodo();
    if(msj != ""){
      alerta(msj)
      return;
    }

    var data = getObjetoDatosSegunForm('form_invocable_periodo');

    var datosAEnviar = {
      ...data,
      _token : '{{csrf_token()}}'
    };

    ruta = "{{route('PeriodoDirector.GuardarActualizar')}}";

    $(".loader").show();
    $.post(ruta, datosAEnviar, function(dataRecibida){

      objetoRespuesta = JSON.parse(dataRecibida);
      console.log('objetoRespuesta:',objetoRespuesta);

      alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);
      if(objetoRespuesta.ok == '1'){
        ModalInvocable.hide();
      }
      recargarInvocables();
      $(".loader").fadeOut("slow");
    });
  }



  function validarFormPeriodo(){
    msj = "";

    msj = validarTamañoMaximoYNulidad(msj,'inv_nombres',200,"Nombre")
    msj = validarTamañoMaximoYNulidad(msj,'inv_apellidos',200,"Apellidos")
    msj = validarTamañoExacto(msj,'inv_dni',8,"Nombre")
    msj = validarSelect(msj,'inv_sexo',"-1","Sexo")
    msj = validarTamañoMaximoYNulidad(msj,'inv_fecha_inicio',400,"Fecha Inicio")
    msj = validarTamañoMaximoYNulidad(msj,'inv_fecha_fin',400,"Fecha Fin")
    
    return msj;
  }

  async function clickEliminarPeriodo(codPeriodoDirector,name){

    confirmarConMensaje("Confirmación","¿Desea eliminar el periodo \""+name+"\"?",'warning',async function(){

      $(".loader").show();
      var ruta = "/ProgramacionAsesores/Periodos/Eliminar/" + codPeriodoDirector;
      var data = await $.get(ruta).promise();
      objetoRespuesta = JSON.parse(data);
      alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);
      recargarInvocables();
      ModalInvocable.hide();
      $(".loader").fadeOut("slow");
    });

  }




</script>

@endsection
