@extends('Layout.Plantilla')

@section('titulo')
    Matriz PAT
@endsection

@section('contenido')
 
@section('tiempoEspera')
  <div class="loader" id="pantallaCarga"></div>
@endsection
@include('Layout.MensajeEmergenteDatos')

 
<div class="row">
    <div class="col-12 py-2">
      <div class="page-title">
        Matriz PAT
      </div>
    </div>
    <div class="col-sm-8">
      <div class="card">
        <div class="card-header">
          <b>
            Filtros Para mostrar
          </b>
        </div>
        <div class="card-body">
          <div class="d-flex flex-row">
                  
            <div class="d-flex mx-2">
              <input type="checkbox" class="cb_medium cursor-pointer" checked id="cb_mes" onclick="toggleMes(this.checked)">
              <label class="mb-0 cursor-pointer ml-1" for="cb_mes">
                Mostrar Por Mes
              </label>
            </div>
            <div class="d-flex mx-2">
              <input type="checkbox" class="cb_medium cursor-pointer" checked id="cb_region" onclick="toggleRegion(this.checked)">
              <label class="mb-0 cursor-pointer ml-1" for="cb_region">
                Mostrar Por Región
              </label>
            </div>

          </div>
        </div>

      </div>
    </div>
    <div class="col-sm-4">
      <div class="card">
        <div class="card-header">
          <b>
            Leyenda
          </b>
        </div>
        <div class="card-body p-2">
          <div class="d-flex flex-row justify-content-around">

            <div>

              <button type="button" class="btn  btn-primary btn-sm" >
                <div class="d-flex flex-column">
                  <div class="">
                    <b>
                      Valor Ejecutado
                    </b>
                  </div>
                  <div class="linea_separadora">
                    <b>
                      Meta Programada
                    </b>
                  </div>
                </div>
              </button>


            </div>
            <div>
              
              <button type="button" class="btn  btn-secondary btn-sm" >
                <div class="d-flex flex-column">
                  <div class="">
                    <b>
                      Valor Ejecutado
                    </b>
                  </div>
                  <div class="linea_separadora">
                    <b>
                      ? = Meta No Programada
                    </b>
                  </div>
                </div>
              </button>
            </div>


          </div>
        </div>

      </div>


    </div>
    <div class="col-12">
        <div class="card">
            
            <div class="card-body">
                
                <div id="matriz_container">

                  @include('CITE.MatrizPat.Inv_Matriz')
 
                </div>
                
            </div>

        </div>
    </div>
     
    
    <div class="col-8"></div>
</div>

 



<div class="modal fade" id="ModalInvocado" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" id="contenido_modal">

    </div>
  </div>
</div>

 

@endsection
@include('Layout.ValidatorJS')
@section('script')
<script>

  $(document).ready(function(){
      $(".loader").fadeOut("slow");

  });

  async function actualizarMatriz(){
    var ruta = "/Cite/MatrizPat/Inv_Matriz";
    await Async_InvocarHtmlEnID(ruta,'matriz_container')
  }

  var secciones_activas = [
     
    "por_mes",
    "por_region"
  ];

  function actualizarSecciones(){
    var ListaFilasPersonas = document.getElementsByClassName("busqueda_secciones");
 
    for (let index = 0; index < ListaFilasPersonas.length; index++) {
      const Fila = ListaFilasPersonas[index];
      var seccion_actual = Fila.getAttribute("seccion_matriz");
      
      if(secciones_activas.includes(seccion_actual)){ //la mostramos
        Fila.classList.remove("hidden");
          
      }else{
        Fila.classList.add("hidden");
      }

    }
 
  }


  function activarSeccion(section_name){
    if(!secciones_activas.includes(section_name)){
      secciones_activas.push(section_name);
    }

    actualizarSecciones();
  }

  function quitarSeccion(section_name){
    var index = secciones_activas.findIndex(e => e == section_name);
    secciones_activas.splice(index,1)

    actualizarSecciones();
  }


 
  function toggleMes(new_value){
    if(new_value){
      activarSeccion("por_mes");
    }else{
      quitarSeccion("por_mes");
    }
  }
  function toggleRegion(new_value){
    if(new_value){
      activarSeccion("por_region");
    }else{
      quitarSeccion("por_region");
    }
  }

</script>
<script>
  const MatrizContent = document.getElementById("matriz_container");
  function setContenidoTabla(content_html){
    MatrizContent.innerHTML = content_html;
  }

  var ModalInvocado = new bootstrap.Modal(document.getElementById("ModalInvocado"), {});
    
  async function clickInvocarModal(codIndicador,codMes,codDepartamento){
    
    $(".loader").show();
    
    var ruta = "/Cite/MatrizPat/Inv_Modal/"+codIndicador+"/"+codMes+"/"+codDepartamento;
    await Async_InvocarHtmlEnID(ruta,'contenido_modal')

    $(".loader").hide();
    ModalInvocado.show();
  }

  
  function clickActualizarMeta(){
    
    
    var tipo_reporte = document.getElementById("tipo_reporte").value;
    var codIndicador = document.getElementById("codIndicador").value
    var valor_meta_actual = document.getElementById("valor_meta_actual").value;

    var datosAEnviar = {
      valor_meta_actual:valor_meta_actual,
      codIndicador:codIndicador,
      tipo_reporte:tipo_reporte,
      _token: '{{csrf_token()}}',
    }
    
    if(tipo_reporte == "mes"){
      var codMes = document.getElementById("codMes").value;
      datosAEnviar.codMes = codMes;
    }

    if(tipo_reporte == "region"){
      var codDepartamento = document.getElementById("codDepartamento").value;
      datosAEnviar.codDepartamento = codDepartamento;
    }

    var ruta = "{{route('CITE.MatrizPat.GuardarActualizarMeta')}}";
    $(".loader").show();
    
    $.post(ruta, datosAEnviar,function(dataRecibida){
      $(".loader").hide();
      ApiResponse = JSON.parse(dataRecibida);
      console.log("api_response",ApiResponse)

      
      if(ApiResponse.ok == "1"){
        mostrarNotificacion(ApiResponse.tipoWarning,ApiResponse.mensaje);
        ModalInvocado.hide();
      }else{
        alertaMensaje(ApiResponse.titulo,ApiResponse.mensaje,ApiResponse.tipoWarning);
      }
      
      setContenidoTabla(ApiResponse.datos);
      
    });

  }


  /* ------------------ */

  async function clickModalMeta(codIndicador){
    $(".loader").show();
    
    var ruta = "/Cite/MatrizPat/Inv_ModalMetaAnual/"+codIndicador;
    await Async_InvocarHtmlEnID(ruta,'contenido_modal')

    $(".loader").hide();
    ModalInvocado.show();
  }

  function clickActualizarMetaAnual(){

   
    var codIndicador = document.getElementById("codIndicador").value
    var meta_anual = document.getElementById("meta_anual").value;
    if(meta_anual == ""){
      alerta("Ingrese meta anual");
      return;
    }
    

    var datosAEnviar = {
      meta_anual:meta_anual,
      codIndicador:codIndicador,
      _token: '{{csrf_token()}}'
    }
    
    
    var ruta = "{{route('CITE.MatrizPat.GuardarActualizarMetaAnual')}}";
    $(".loader").show();
    
    $.post(ruta, datosAEnviar,function(dataRecibida){
      $(".loader").hide();
      ApiResponse = JSON.parse(dataRecibida);
      console.log("ApiResponse",ApiResponse)
      
      
      if(ApiResponse.ok == "1"){
        mostrarNotificacion(ApiResponse.tipoWarning,ApiResponse.mensaje);
        ModalInvocado.hide();
      }else{
        alertaMensaje(ApiResponse.titulo,ApiResponse.mensaje,ApiResponse.tipoWarning);
      }
      
      setContenidoTabla(ApiResponse.datos);
      
    });
  }

</script>
@endsection
@section('estilos')
<style>
  #matriz_pat thead th{
    background-color: #005900;
    color: white;
    text-align: center;
    font-size: 10pt;
  }

  .linea_separadora{
    border-top-style: solid;
    border-width: 1px;
    border-color: #ffffff;
    margin-left: -4px;
    margin-right: -4px;
  }
  .header_azul{
      background-color:#3c8dbc;
      color:white;
  }

  .tabla_elegida{
    background-color: #f9ffe1;
    border-style: solid;
    border-color: #bebebe;
    border-radius: 5px;
    border-width: 1px;
  }

  .btn_transition{
    transition: background-color 5s cubic-bezier(0, 0, 0.2, 1);
  }

</style>
@endsection
