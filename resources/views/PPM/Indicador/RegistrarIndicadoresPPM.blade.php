@extends('Layout.Plantilla')

@section('titulo')
  Registrar Indicadores
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

<div class="col-12 py-2">
  <div class="page-title">
    Registrar Indicadores
  </div>
</div>
<div class="card ">
    <div class="card-header">
        <div class="d-flex flex-row">
            <div class="">
                <h3 class="card-title">
                    <b>Filtrar</b>
                </h3>
            </div>
        </div>
    
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-sm-6">
          <label for="codObjetivo" id="" class="">
              Objetivo:
          </label>
          <select class="form-control" id="codObjetivo" onchange="changeObjetivo()">
              <option value="-1">- Objetivo -</option>
              @foreach($listaObjetivos as $objetivo)
                <option value="{{$objetivo->getId()}}">
                  {{$objetivo->indice}})  {{$objetivo->nombre}}
                </option>
              @endforeach
          </select>   
        </div>

        <div class="col-sm-6">
          <label for="codIndicador" id="" class="">
              Indicador:
          </label>
          <select class="form-control" id="codIndicador" onchange="changeIndicador()">
              <option value="-1">- Indicador -</option>
              
          </select>   
        </div>

        <div class="col-sm-6">
          @php
            $selectRegiones = new App\UI\UISelectMultiple([],"",'codsRegiones',"Regiones",false,30,13);
            $selectRegiones->setOptionsWithModel($listaRegiones,'nombre');
          @endphp
          <label for="">
            Regiones:
          </label>
          {{$selectRegiones->render()}}

        </div>


        <div class="col-sm-6">
          @php
            $selectUsuarios = new App\UI\UISelectMultiple([],"",'codsUsuarios',"Usuarios",false,30,13);
            $selectUsuarios->setOptionsWithModel($listaEmpleados,'nombreCompleto');
          @endphp
          <label for="">
            Usuario que registró:
          </label>
          {{$selectUsuarios->render()}}

        </div>

        

        <div  class="col-12 col-sm-6">
          @php
            $selectSemestre = new App\UI\UISelectMultiple([],"",'codsSemestres',"Semestres",false,30,13);
            $selectSemestre->setOptionsWithModel($listaSemestres,'getTexto');
          @endphp
          <label for="">
            Semestre
          </label>
          {{$selectSemestre->render()}}
        </div>

      </div>
      <div class="d-flex flex-row">
        <div class="ml-auto mt-4 ">
          <button type="button" class="btn btn-primary" onclick="clickBuscar()">
            Buscar
            <i class="fas fa-search"></i>
          </button>
          <button id="boton_descargar_reporte" type="button" class="btn btn-success" onclick="clickDescargarReporte()">
            Descargar Reporte
            <i class="fas fa-download"></i>
          </button>
        </div>


      </div>

    </div>
</div>


<div class="card">
  <div class="card-body">
    <div id="container_indicadores">

    </div>

    
  </div>

</div>
 



<div class="modal fade" id="ModalNivelGestion" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" id="container_ficha_gestion_empresarial">
        
          
      </div>
  </div>
</div>



<div class="modal fade" id="ModalNivelProductivo" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
          <h5 class="modal-title">
            Ver Nivel Productivo
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body" id="nivel_productivo_container">
          


      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
              Salir
          </button>

      </div>
        
    </div>
  </div>
</div>



 


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
 
<script type="application/javascript">
 

  $(document).ready(function(){
      $(".loader").fadeOut("slow");
  });

  const ActivarExportacionExcel = {{$descargarExcel}};
  


  var ListaObjetivos = @json($listaObjetivos)

  var ListaIndicadoresActual = [];


  const SelectObjetivo = document.getElementById('codObjetivo');
  const SelectIndicador = document.getElementById('codIndicador');
 

  const IndicadorEmptyRow = `<option value="-1">- Indicador -</option>`;
  
  function changeObjetivo(){
     
    limpiarListaIndicadores();

    var codObjetivo = SelectObjetivo.value;
    if(codObjetivo == -1){
      return;
    }
    var objetivo = ListaObjetivos.find(e => e.codObjetivo == codObjetivo);
    printIndicadores(objetivo.indicadores);
    ListaIndicadoresActual = objetivo.indicadores;

  }

  function printIndicadores(indicadores){

    var html = IndicadorEmptyRow;
    var plantilla_row = `<option value="[CodIndicador]">[IndiceIndicador]) [NombreIndicador]</option>`;
    for (let index = 0; index < indicadores.length; index++) {
      const indicador = indicadores[index];
      var hidrate_object = {
        CodIndicador:indicador.codIndicador,
        NombreIndicador:indicador.nombre,
        IndiceIndicador:indicador.indice
      };
      html += hidrateHtmlString(plantilla_row,hidrate_object);

    }

    SelectIndicador.innerHTML = html;

  }

  function changeIndicador(){
    
    var codIndicador = SelectIndicador.value;
    var indicador = ListaIndicadoresActual.find(e => e.codIndicador == codIndicador);
    
    if(SelectIndicador.value == 5){

    }else{

    }

  }
 

 

  function limpiarListaIndicadores(){
    SelectIndicador.innerHTML = IndicadorEmptyRow;
  }


  const ContainerIndicadores = document.getElementById("container_indicadores");

  const SelectMultipleRegion = document.getElementsByName("codsRegiones")[0];
  const SelectMultipleUsuarios = document.getElementsByName("codsUsuarios")[0];
  const IndicadorSeleccionado = document.getElementById("codIndicador");
 
 
  const SelectMultipleSemestre = document.getElementsByName("codsSemestres")[0];
  
  
  const SelectMultipleContainerRegiones = document.getElementsByName("SelectMultipleContainer_codsRegiones")[0];
  const SelectMultipleContainerUsuarios = document.getElementsByName("SelectMultipleContainer_codsUsuarios")[0];
  const SelectMultipleContainerSemestres = document.getElementsByName("SelectMultipleContainer_codsSemestres")[0];
  
  function validarFormularioBusqueda(){
    limpiarEstilos(["codObjetivo","codIndicador"]);
    SelectMultipleContainerRegiones.classList.remove("error");
    SelectMultipleContainerUsuarios.classList.remove("error");
    SelectMultipleContainerSemestres.classList.remove("error");

    
    msj = "";

    msj = validarSelect(msj,"codObjetivo","-1","Objetivo");
    msj = validarSelect(msj,"codIndicador","-1","Indicador");
    
    
    if(SelectMultipleSemestre.value == ""){
      SelectMultipleContainerSemestres.classList.add("error");
      msj = "Debe seleccionar un semestre";
    }
 

    return msj;
  }

  function clickBuscar(){ 

    var error = validarFormularioBusqueda();
    if(error){
      alerta(error);
      return;
    }

    ejecutarBusqueda();

  }

  function clickDescargarReporte(){
    var error = validarFormularioBusqueda();
    if(error){
      alerta(error);
      return;
    }

    

    ejecutarDescarga();

  }


  function ejecutarBusqueda(){
    $(".loader").fadeIn("slow");

    var ruta = "/PPM/Indicadores/Inv_VerTabla";
    var datos = {
      codIndicador:IndicadorSeleccionado.value,
      codsRegiones:SelectMultipleRegion.value,
      codsUsuarios:SelectMultipleUsuarios.value,
      
      codsSemestres:SelectMultipleSemestre.value
    };

    $.post(ruta, datos, function(dataRecibida){
      $(".loader").fadeOut("slow");
    
      ContainerIndicadores.innerHTML = dataRecibida;
    });

  }

  function ejecutarDescarga(){
    $(".loader").fadeIn("slow");
    
    var ruta = "/PPM/Indicadores/DescargarReporteIndicador";
    var datos = {
      codIndicador:IndicadorSeleccionado.value,
      codsRegiones:SelectMultipleRegion.value,
      codsUsuarios:SelectMultipleUsuarios.value,
      codsSemestres:SelectMultipleSemestre.value
    };
    
    var indicador = ListaIndicadoresActual.find(e => e.codIndicador == IndicadorSeleccionado.value);
    

    $.get(ruta, datos, function(dataRecibida){
      $(".loader").fadeOut("slow");
      var terminacion = null;
      if(ActivarExportacionExcel){
        terminacion = ".xls";
        descargarContenidoPlano("Reporte de Indicador " + indicador.getCodigo + " " +   terminacion,dataRecibida);
       
      }else{
        
        console.log("datos",datos);
        const ObjParams = new URLSearchParams(datos);
        var params_string = ObjParams.toString();
        var ruta_final = ruta + "?"+ params_string;
        console.log("ruta_final",ruta_final);
        window.open(ruta_final, '_blank');
      }

      
    });


  }

  function descargarContenidoPlano(filename,data){
    var blob = new Blob([data], {
      type: 'text/csv'
    });
    if (window.navigator.msSaveOrOpenBlob) {
      window.navigator.msSaveBlob(blob, filename);
    } else {
      var elem = window.document.createElement('a');
      elem.href = window.URL.createObjectURL(blob);
      elem.download = filename;
      document.body.appendChild(elem);
      elem.click();
      document.body.removeChild(elem);
    }
  }
  

  /* LOGICA DE GUARDADOS */


  function clickGuardarIndicadores11(codsRelaciones){
    
    var relaciones = [];
    var msj_error = "";
     
    for (const index in codsRelaciones) {
      const codRelacion = codsRelaciones[index];

      var descripcion_id = 'ind11_descripcion_actividad-' + codRelacion;
      var resultado_id = 'ind11_descripcion_resultado-' + codRelacion;

      var ind11_realizo_actividad_incidencia = document.getElementById('ind11_realizo_actividad_incidencia-' + codRelacion).checked
      var ind11_descripcion_actividad = document.getElementById(descripcion_id).value;
      var ind11_descripcion_resultado = document.getElementById(resultado_id).value;

      if(ind11_realizo_actividad_incidencia){
        limpiarEstilos([descripcion_id,resultado_id])
        if(ind11_descripcion_actividad == ""){
          msj_error = "Debe ingresar la descripción de la actividad";
          ponerEnRojo(descripcion_id);
        }
        if(ind11_descripcion_resultado == ""){
          msj_error = "Debe ingresar el resultado del resultado";
          ponerEnRojo(resultado_id);
        }
      }

      relaciones.push({
        codRelacion:codRelacion,
        ind11_realizo_actividad_incidencia:ind11_realizo_actividad_incidencia,
        ind11_descripcion_actividad:ind11_descripcion_actividad,
        ind11_descripcion_resultado:ind11_descripcion_resultado,
      });
      
    }

    if(msj_error){
      alerta(msj_error)
      return;
    }
    console.log("relaciones",relaciones);
    //ya armamos los datos
    var ruta = "/PPM/Indicadores/GuardarIndicadores11";
    var datos = {
      relaciones:relaciones,
   
    };

    $.post(ruta, datos, function(dataResponse){
      var objetoRespuesta = JSON.parse(dataResponse);
      
      alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);
      
      ejecutarBusqueda();
    });
  }


  


  function clickGuardarIndicadores12(codsRelaciones){
    
    var relaciones = [];

    var msj_error = "";
    for (const index in codsRelaciones) {
      const codRelacion = codsRelaciones[index];

      var temas_id = 'ind12_temas_capacitacion-' + codRelacion;
      limpiarEstilos([temas_id])
      var ind12_temas_capacitacion = document.getElementById(temas_id).value;

      if(ind12_temas_capacitacion == ""){
        msj_error = "Debe ingresar los temas de capacitación.";
        ponerEnRojo(temas_id);
      }

      relaciones.push({
        codRelacion:codRelacion,
        ind12_temas_capacitacion:ind12_temas_capacitacion,
      });
      
    }
    if(msj_error){
      alerta(msj_error)
      return;
    }
    console.log("relaciones",relaciones);
    //ya armamos los datos
    var ruta = "/PPM/Indicadores/GuardarIndicadores12";
    var datos = {
      relaciones:relaciones,
   
    };

    $.post(ruta, datos, function(dataResponse){
      var objetoRespuesta = JSON.parse(dataResponse);

      alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);

      ejecutarBusqueda();
    });
  }


 
  function clickGuardarIndicadores21(codsRelaciones){
    
    var relaciones = [];

    var msj_error = "";
    for (const index in codsRelaciones) {
      const codRelacion = codsRelaciones[index];


      var realizaron_id = 'ind21_realizaron_mecanismos-' + codRelacion;
      var descripcion_id = 'ind21_descripcion_mecanismos-' + codRelacion;
      var estado_id = 'ind21_estado_implementacion-' + codRelacion;
      var beneficiarios_id = 'ind21_beneficiarios-' + codRelacion;

      var ind21_realizaron_mecanismos = document.getElementById(realizaron_id).checked
      var ind21_descripcion_mecanismos = document.getElementById(descripcion_id).value;
      var ind21_estado_implementacion = document.getElementById(estado_id).value;
      var ind21_beneficiarios = document.getElementById(beneficiarios_id).value;

      if(ind21_realizaron_mecanismos){
        limpiarEstilos([descripcion_id,estado_id,beneficiarios_id])

        if(ind21_descripcion_mecanismos == ""){
          msj_error = "Debe ingresar la descripción de los mecanismos";
          ponerEnRojo(descripcion_id);
        }
        if(ind21_estado_implementacion == ""){
          msj_error = "Debe ingresar el estado de implementación";
          ponerEnRojo(estado_id);
        }
        if(ind21_beneficiarios == ""){
          msj_error = "Debe ingresar los beneficiarios";
          ponerEnRojo(beneficiarios_id);
        }
        
      }
      

      relaciones.push({
        codRelacion:codRelacion,
        ind21_realizaron_mecanismos:ind21_realizaron_mecanismos,
        ind21_descripcion_mecanismos:ind21_descripcion_mecanismos,
        ind21_estado_implementacion:ind21_estado_implementacion,
        ind21_beneficiarios:ind21_beneficiarios,
        
      });
      
    }
    if(msj_error){
      alerta(msj_error)
      return;
    }

    console.log("relaciones",relaciones);
    //ya armamos los datos
    var ruta = "/PPM/Indicadores/GuardarIndicadores21";
    var datos = {
      relaciones:relaciones,
   
    };

    $.post(ruta, datos, function(dataResponse){
      var objetoRespuesta = JSON.parse(dataResponse);
      
      alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);
      
      ejecutarBusqueda();
    });
  }

 
  function clickGuardarIndicadores22(codsRelaciones){
    
    var relaciones = [];

    var msj_error = "";
    for (const index in codsRelaciones) {
      const codRelacion = codsRelaciones[index];

      var realizo_id = 'ind22_realizo_accion_id-' + codRelacion;
      var descripcion_id = 'ind22_descripcion_accion-' + codRelacion;
      limpiarEstilos([realizo_id,descripcion_id]);

      var ind22_realizo_accion = document.getElementById(realizo_id).value
      var ind22_descripcion_accion = document.getElementById(descripcion_id).value;
      
      if(ind22_realizo_accion == ""){
        msj_error = "Falta seleccionar el item Realizo accion..."
        ponerEnRojo(realizo_id);
      }

      if(ind22_descripcion_accion == ""){
        msj_error = "Ingrese Descripción de acción conjunta..."
        ponerEnRojo(descripcion_id);
      }
      

      relaciones.push({
        codRelacion:codRelacion,
        ind22_realizo_accion_id:ind22_realizo_accion,
        ind22_descripcion_accion:ind22_descripcion_accion
      });
      
    }

    if(msj_error){
      alerta(msj_error)
      return;
    }

    console.log("relaciones",relaciones);
    //ya armamos los datos
    var ruta = "/PPM/Indicadores/GuardarIndicadores22";
    var datos = {
      relaciones:relaciones,
   
    };

    $.post(ruta, datos, function(dataResponse){
      var objetoRespuesta = JSON.parse(dataResponse);
      
      alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);
      
      ejecutarBusqueda();
    });
  }


  function clickGuardarIndicadores32(codsRelaciones){
    
    var relaciones = [];

    var msj_error = "";
    for (const index in codsRelaciones) {
      const codRelacion = codsRelaciones[index];


      var tiempo_cuidado_id = 'ind32_tiempo_cuidado-' + codRelacion
      var tiempo_rem_id = 'ind32_tiempo_remunerado-' + codRelacion
      var actividad_id = 'ind32_actividad_economica-' + codRelacion
      var inversiones_id = 'ind32_inversiones-' + codRelacion
      var tiene_id = 'ind32_tiene_manejo_registros-' + codRelacion
      var manera_id = 'ind32_manera_registros-' + codRelacion

      limpiarEstilos([tiempo_cuidado_id,tiempo_rem_id,actividad_id,inversiones_id,tiene_id,manera_id])

      var ind32_tiempo_cuidado = document.getElementById(tiempo_cuidado_id).value
      var ind32_tiempo_remunerado = document.getElementById(tiempo_rem_id).value
      var ind32_actividad_economica = document.getElementById(actividad_id).value
      var ind32_inversiones = document.getElementById(inversiones_id).value
      var ind32_tiene_manejo_registros  = document.getElementById(tiene_id).checked
      var ind32_manera_registros = document.getElementById(manera_id).value

      if(ind32_tiempo_cuidado == ""){
        msj_error = "Debe ingresar el tiempo de cuidado";
        ponerEnRojo(tiempo_cuidado_id);
      }
      if(ind32_tiempo_remunerado == ""){
        msj_error = "Debe ingresar el tiempo dedicado a trabajo remunerado";
        ponerEnRojo(tiempo_rem_id);
      }
      if(ind32_actividad_economica == ""){
        msj_error = "Debe ingresar la actividad economica";
        ponerEnRojo(actividad_id);
      }
      if(ind32_inversiones == ""){
        msj_error = "Debe ingresar las inversiones realizadas";
        ponerEnRojo(inversiones_id);
      }

      if(ind32_tiene_manejo_registros){
        if(ind32_manera_registros == ""){
          msj_error = "Debe ingresar la manera en que se realiza el registro";
          ponerEnRojo(manera_id);
        }
      }
      

    
      relaciones.push({
        codRelacion:codRelacion,
        ind32_tiempo_cuidado:ind32_tiempo_cuidado,
        ind32_tiempo_remunerado:ind32_tiempo_remunerado,
        ind32_actividad_economica:ind32_actividad_economica,
        ind32_inversiones:ind32_inversiones,
        ind32_tiene_manejo_registros:ind32_tiene_manejo_registros,
        ind32_manera_registros:ind32_manera_registros,
      });
      
    }
    if(msj_error){
      alerta(msj_error)
      return;
    }

    console.log("relaciones",relaciones);
    //ya armamos los datos
    var ruta = "/PPM/Indicadores/GuardarIndicadores32";
    var datos = {
      relaciones:relaciones,
   
    };

    $.post(ruta, datos, function(dataResponse){
      var objetoRespuesta = JSON.parse(dataResponse);
      
      alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);
      
      ejecutarBusqueda();
    });
  }

  /* FUNCIOENS DE ACTIVAR CHECKBOX */

  function change11RealizoActividadIncidencia(activado,codRelacion){
    const InputDescActividad = document.getElementById('ind11_descripcion_actividad-' + codRelacion);
    const InputDescResultado = document.getElementById('ind11_descripcion_resultado-' + codRelacion)

    if(!activado){
      InputDescActividad.value = "";
      InputDescResultado.value = "";
    }

    InputDescActividad.readOnly = !activado
    InputDescResultado.readOnly = !activado
  }

  function change21RealizoMecanismos(activado,codRelacion){
    
    const InputDescMecanismos = document.getElementById('ind21_descripcion_mecanismos-' + codRelacion);
    const InputEstadoImplementacion = document.getElementById('ind21_estado_implementacion-' + codRelacion)
    const InputBeneficiarios = document.getElementById('ind21_beneficiarios-' + codRelacion)

    if(!activado){
      InputDescMecanismos.value = "";
      InputEstadoImplementacion.value = "";
      InputBeneficiarios.value = "";
      
    }

    InputDescMecanismos.readOnly = !activado
    InputEstadoImplementacion.readOnly = !activado
    InputBeneficiarios.readOnly = !activado
    
  }

  function change22RealizoAccion(activado,codRelacion){
     

    const InputDescAccion = document.getElementById('ind22_descripcion_accion-' + codRelacion);
    
    if(!activado){
      InputDescAccion.value = "";
    }

    InputDescAccion.readOnly = !activado
  }


  
  function change32TieneManejo(activado,codRelacion){
    
    const InputManeraRegistros = document.getElementById('ind32_manera_registros-' + codRelacion);
    
    if(!activado){
      InputManeraRegistros.value = "";
    }

    InputManeraRegistros.readOnly = !activado
  }

  /* 
  MODAL DE CALCULAR NIVEL DE GESTION EMPRESARIAL
  */

  const ListaItemsFGE = @json($listaItems);

  const ListaSegmentosFGE = @json($listaSegmentos);

  const ListaOptionsExistentes = @json($listaOptions);
  
  const ContainerFichaGestionEmpresarial = document.getElementById("container_ficha_gestion_empresarial");
  var codRelacionSeleccionada = null;
  async function clickCalcularNivelGestion(codRelacion){

    codRelacionSeleccionada = codRelacion;
    var data = await $.get('/PPM/Indicadores/GetModalFichaGestionEmpresarial/'+codRelacion).promise();
    ContainerFichaGestionEmpresarial.innerHTML = data;
    actualizarPromediosFGE();

  }

  async function clickGuardarFichaGestionEmpresarial(){

    var msj_error = "";
    for (let index = 0; index < ListaItemsFGE.length; index++) {
      
      const item = ListaItemsFGE[index];
      limpiarEstilos(["fge_item_"+item.codItem])
      
      const Select = document.getElementById("fge_item_" + item.codItem);
      if(Select.value == -1){
        ponerEnRojo("fge_item_"+item.codItem)
        msj_error = "Falta ingresar el item '" + item.descripcion + "'";
      }
      ListaItemsFGE[index].codOptionSeleccionada = Select.value;
    }
    if(msj_error){
      alerta(msj_error)
      return;
    }

    var ruta = "/PPM/Indicadores/ActualizarFichaGestionEmpresarial";
    var datos = {
      codRelacion:codRelacionSeleccionada,
      ListaItems:ListaItemsFGE
    };
    $(".loader").show();
    var dataRecibido = await $.post(ruta, datos).promise();
    var objetoRespuesta = JSON.parse(dataRecibido);
       
    alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);
    
    clickBuscar();
  }

  function getValorOpcion(codOption){

    var opcion = ListaOptionsExistentes.find(e => e.codOption == codOption);
    return opcion.valor;
  }
  
  function actualizarPromediosFGE(){
    
    var sum_segmentos = 0;
    var cant_segmentos = 0;
    for (let index = 0; index < ListaSegmentosFGE.length; index++) {
      const segmento = ListaSegmentosFGE[index];
      const SegmentoValueContainer = document.getElementById("fge_segmento_promedio_" + segmento.codSegmento)
      var sum_items = 0;
      var cant_items = 0;

      for (let index = 0; index < segmento.items.length; index++) {
        const item = segmento.items[index];
        const SelectItem = document.getElementById("fge_item_" + item.codItem);
        if(SelectItem.value != -1){
          valor_item = getValorOpcion(SelectItem.value);
          
          sum_items += parseInt(valor_item);
          cant_items++;
        }
        

      }
      var promedio_segmento_actual = sum_items/cant_items;
      if(isNaN(promedio_segmento_actual)){
        promedio_segmento_actual = 0;
      }
    
      SegmentoValueContainer.innerHTML = promedio_segmento_actual.toFixed(2);
      sum_segmentos += promedio_segmento_actual;
      cant_segmentos++;

    }
    var promedio_final = sum_segmentos / cant_segmentos;

    const PromedioFinalContainer = document.getElementById("fge_promedio_final_valor")
    PromedioFinalContainer.innerHTML = promedio_final.toFixed(2);


  }



</script>
  



<script>

  //invoca al contenido del modal
  async function clickNivelProductivo(codRelacion){
    var ruta = "/PPM/SemestreOrganizacion/InvModalVerNivelProductivo/" + codRelacion;
    $(".loader").show();

    await Async_InvocarHtmlEnID(ruta,"nivel_productivo_container");
    $(".loader").hide();
    
    
    FlechaIngresarProductos = document.getElementById("flecha_ingresar_productos");
    FlechaImportarCultivos = document.getElementById("flecha_importar_cultivos");
    TipoProductoLabel = document.getElementById("tipo_producto_label");
    
    BtnIngresarProductos = document.getElementById("btn_ingresar_productos");
    BtnImportarCultivos = document.getElementById("btn_importar_cultivos");

  }


  const ListaTipoProducto = @json($listaTipoProducto);

  const codTipoProducto_Producto = {{$codTipoProducto_Producto}};
  const codTipoProducto_CultivoCadena = {{$codTipoProducto_CultivoCadena}};
  
  const ListaProductos = @json($listaProductos);

  function changeTipoProducto(codProducto_selected){
    if(codProducto_selected == -1){
      TipoProductoLabel.value = "";
      return;
    }
      

    var producto = ListaProductos.find(e => e.codProducto == codProducto_selected);
    
    if(producto.codTipoProducto == codTipoProducto_Producto){
      updateTipoProducto_Producto();
      TipoProductoLabel.value = "Producto";

    }
    if(producto.codTipoProducto == codTipoProducto_CultivoCadena){
      updateTipoProducto_CultivoCadena();
      TipoProductoLabel.value = "Cultivo/Cadena";
      
    }
    
  }


  var FlechaIngresarProductos = null;
  var FlechaImportarCultivos = null;
  var TipoProductoLabel = null;


  function updateTipoProducto_Producto(){
    FlechaIngresarProductos.classList.remove("hidden");
    FlechaImportarCultivos.classList.add("hidden");
    
    BtnIngresarProductos.disabled = false;
    BtnImportarCultivos.disabled = true;
    
  }

  function updateTipoProducto_CultivoCadena(){
    FlechaIngresarProductos.classList.add("hidden");
    FlechaImportarCultivos.classList.remove("hidden");
    BtnIngresarProductos.disabled = true;
    BtnImportarCultivos.disabled = false;

  }


  function clickGoToVerAñadirProductos(codRelacion){

    var codProducto = document.getElementById("codProducto").value;

    var ruta = "/PPM/SemestreOrganizacion/VerAñadirProductos/"+ codRelacion + "?codProductoSeleccionado=" + codProducto;
    window.open(ruta, '_blank');
  }

  function clickGoToImportarCultivosCadena(codRelacion){
    var codProducto = document.getElementById("codProducto").value;
    
    var ruta = "/PPM/SemestreOrganizacion/VerAñadirCultivoCadena/"+ codRelacion + "?codProductoSeleccionado=" + codProducto;
    window.open(ruta, '_blank');

  }
  

</script>


 
@endsection
 
@section('estilos')
<style>
  .persona_sexo{
    text-align: center;
    font-size: 20pt;
    font-weight: bold;
    color: #6b6b6b;
  }

  .fge_segmento_container{
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-width: 0px;
    border-bottom-width: 2px;
    border-style: solid;
    border-color: #c1c1c1;
  }

  .fge_segmento{
    background-color: #9d4100;
    padding: 5px 10px;
    font-size: 15pt;
    font-weight: 900;
    border-radius: 7px;
    color: white;
    display: flex;
 
  }


  .fge_segmento_items_container{
    margin-left: 20px;
 
    margin-right: 20px;
  }

  .fge_item{
    margin-bottom: 7px;
    margin-top: 7px;
  }

  .fge_segmento_promedio{
    margin-left: auto;
    background-color: white;
    padding: 0px 10px;
    color: #9d4100;
    font-weight: 900;
    font-size: 19pt;
    margin-right: -4px;
    border-radius: 9px;
  }


  .fge_promedio_final{
    background-color: #ff9244;
    padding: 5px 10px;
    font-size: 15pt;
    font-weight: 900;
    border-radius: 7px;
    color: white;
    display: flex;

  }
  .fge_promedio_final_valor{
    margin-left: auto;
    background-color: white;
    padding: 0px 10px;
    color: #9d4100;
    font-weight: 900;
    font-size: 19pt;
    margin-right: -4px;
    border-radius: 9px;
  }

  .nivel_calculado{
    padding: 0px;
    margin: 0px;
     
    position: absolute;
    font-size: 12pt;
    color: white;
    font-weight: 700;
     
    right: 3px;
    bottom: 0px;
  }

  .nivel_calculado_button{
    position: relative;
    padding-right: 38px;
  }

  .mensaje_nosabes{
    background-color: #deffff;
    padding: 20px 40px;
    text-align: center;
    font-weight: 900;
 
  }
  .mensaje_selecciona{
    color: #7b7b7b;
    font-size: 15pt;
  }

  .flechas_color{
    color:#247aff;
  }
  .otro_producto_msj{
    color: #5b5b5b;
    text-align: center;
    font-size: 11pt;
    margin-top: 5px;
  }
</style>
@endsection