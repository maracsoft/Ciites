<script>
  const Select2UnidadEnlazada = document.getElementById("codUnidadProductivaEnlazadaCITE"); 
 
  const divRUC = document.getElementById('divRUC');
 
  const BotonIrUnidad = document.getElementById("boton_ir_unidadproductiva"); 
  const InputRUC = document.getElementById("ruc");

  function actualizarTieneEnlaceCite(checked){
    var select2 = document.querySelector('[data-id="codUnidadProductivaEnlazadaCITE"]');
    select2.disabled = !checked;
    if(checked && Select2UnidadEnlazada.value != "-1"){
      mostrarBotonIrUnidad();
    }else{
      ocultarBotonIrUnidad();
    }
  }


  function actualizarTieneActividadEconomica(checked) {

    if (checked) {
      newVal = 1;
      document.getElementById('codActividadEconomica').readonly = false;
      document.getElementById('codActividadEconomica').disabled = false;
      BotonActividad.disabled = false;
      
    } else {
      document.getElementById('codActividadEconomica').value = -1;
      document.getElementById('codActividadEconomica').disabled = true;
      BotonActividad.disabled = true;
      
      newVal = 0;

    }

  }

  function validarForm() {
    msj = '';

    limpiarEstilos([
      'codTipoOrganizacion', 
      'codActividadEconomica',
       
      'ruc',
      'razon_social',
      'direccion',
      'input_nueva_actividad',
      'codUnidadProductivaEnlazadaCITE'

    ]);



    msj = validarSelect(msj, 'codTipoOrganizacion', -1, 'Tipo Organización');

    msj = validarLugarSelector_ComboBoxDistrito(msj);


    if (document.getElementById('tiene_act_economica').checked){
      if(añadir_nueva_actividad){
        msj = validarTamañoMaximoYNulidad(msj, 'input_nueva_actividad',100, 'input_nueva_actividad');
      }else{
        msj = validarSelect(msj, 'codActividadEconomica', -1, 'Actividad Económica');
      }
      
    }

    if(document.getElementById("activar_enlace_cite").checked){
      msj = validarSelect(msj, 'codUnidadProductivaEnlazadaCITE', -1, 'Unidad productiva Enlazada del CITE');

      if(msj == ""){
        //verificamos que la organizacion enlazada tenga el mismo RUC

        var unidad = ListaUnidadesProductivas.find(e => e.codUnidadProductiva == Select2UnidadEnlazada.value); //obtenemos la unidad seleccionada por el select2
        console.log("unidad",unidad)
        var organizacion_ruc = InputRUC.value; 

        if(unidad.ruc != organizacion_ruc){
          ponerEnRojo("codUnidadProductivaEnlazadaCITE");
          msj = "La unidad productiva enlazada debe tener el mismo RUC que la organización actual ("+ organizacion_ruc +")";
        }
      }

 
    }
      

    var enTramite = document.getElementById('documento_en_tramite').checked;
  
    if (estadoDocumentoSeleccionado.nombre == "RUC") {
      if (!enTramite) //solo valida que no esté vacío si el ya está formalizada
      msj = validarNulidad(msj, 'ruc', 'RUC');
      msj = validarTamañoExactoONulidad(msj, 'ruc', 11, 'RUC');
    }
    msj = validarTamañoMaximoYNulidad(msj, 'razon_social',200, 'Razón Social');





    msj = validarTamañoMaximoYNulidad(msj, 'direccion', {{App\Configuracion::tamañoSeñoresOC}}, 'Dirección');

    return msj;

  }

  /* llama a mi api que se conecta  con la api de la sunat
	  si encuentra, llena con los datos que encontró
	  si no tira mensaje de error
  */
  function consultarPorRuc() {

    msjError = "";
    ruc = $("#ruc").val();
    if (ruc == '')
      msjError = ("Por favor ingrese el ruc");


    if (ruc.length != 11)
      msjError = ("Por favor ingrese el ruc completo. Solo 11 digitos.");


    if (msjError != "") {
      alerta(msjError);
      return;
    }

    $(".loader").show(); //para mostrar la pantalla de carga

    $.get('/ConsultarAPISunat/ruc/' + ruc
      , function(data) {
      console.log("IMPRIMIENDO DATA como llegó:");
      console.log(data);

      if (data == 1) {
        alerta("Persona juridica no encontrada.");

      } else {
        console.log('DATA PARSEADA A JSON:')
        personaJuridicaEncontrada = JSON.parse(data)
        console.log(personaJuridicaEncontrada);


        document.getElementById('razon_social').value = personaJuridicaEncontrada.razonSocial;


        //document.getElementById('actividadPrincipal').value = personaJuridicaEncontrada.actEconomicas;
        if (personaJuridicaEncontrada.direccion != "")
        document.getElementById('direccion').value = personaJuridicaEncontrada.direccion;

      }

      $(".loader").fadeOut("slow");
      }
    );
  }


   




  var listaTipoDocumento = @php echo $listaTipoDocumento @endphp

  var estadoDocumentoSeleccionado = {};

  function actualizarTipoDocumento(codEstado) {
    ocultarDivRUC();
     
    estadoDocumentoSeleccionado = listaTipoDocumento.find(e => e.codTipoDocumento == codEstado)
    codeTipoDocumento = estadoDocumentoSeleccionado.code;
    
    if(codeTipoDocumento == "ruc"){
      mostrarDivRUC();
    }

  }

  function ocultarDivRUC() {
	  divRUC.classList.add("hidden")
  }

  function mostrarDivRUC() {
	  divRUC.classList.remove("hidden")
  }

 
 
  

  function ocultarBotonIrUnidad() {
	  BotonIrUnidad.classList.add("hidden")
  }

  function mostrarBotonIrUnidad() {
	  BotonIrUnidad.classList.remove("hidden")
  }


  

  function actualizarDocumentoTramite(CheckBox) {
    var enTramite = CheckBox.checked;
    if (enTramite)
      document.getElementById('ruc').value = "";

    document.getElementById('ruc').readOnly = enTramite;
  }

  

  /* MINICRUD PARA NUEVA ACTIVIDAD ECONOMICA */
  var añadir_nueva_actividad = false;

  const IconoActividad = document.getElementById("icono_actividad");
  const BotonActividad = document.getElementById("boton_actividad");

  const InputNuevaActividad = document.getElementById("input_nueva_actividad");
  const SelectActividad = document.getElementById("codActividadEconomica");
  const InputAñadirNuevaActividadBoolean = document.getElementById("input_nueva_actividad_boolean");

  function showListIcon(){
    IconoActividad.className = "fas fa-list-ol";
    BotonActividad.title = "Mostrar listado de actividades predefinidas";
    BotonActividad.className = "btn btn-primary ml-1";
    
  }

  function showPlusIcon(){
    IconoActividad.className = "fas fa-plus";
    BotonActividad.title = "Añadir nueva actividad";
    BotonActividad.className = "btn btn-success ml-1";
    
  }

  function showActividadSelect(){
    SelectActividad.classList.remove("hidden");

  }
  function hideActividadSelect(){
    SelectActividad.classList.add("hidden");
  }

  function showActividadInput(){
    InputNuevaActividad.classList.remove("hidden");

  }
  function hideActividadInput(){
    InputNuevaActividad.classList.add("hidden");
  }

  function toggleActividadButton(){
    

    añadir_nueva_actividad = !añadir_nueva_actividad;
    actualizarEstados();
  }

  function actualizarEstados(){
    if(añadir_nueva_actividad){
      showActividadInput();
      hideActividadSelect();
      showListIcon();
      InputAñadirNuevaActividadBoolean.value = 1;

    }else{
      showActividadSelect();
      hideActividadInput();
      showPlusIcon();
      InputAñadirNuevaActividadBoolean.value = 0;
      
    }
  }



  function changedUnidadProductivaEnlazada(){
    if(Select2UnidadEnlazada.value == "-1"){
        ocultarBotonIrUnidad();
        return;
      }
    mostrarBotonIrUnidad();
    
    var unidad = ListaUnidadesProductivas.find(e => e.codUnidadProductiva ==  Select2UnidadEnlazada.value);
    BotonIrUnidad.title = "Ir a la Unidad Productiva enlazada " + unidad.label_front;
  }

  function clickIrAUnidadEnlazada(){
    if(Select2UnidadEnlazada.value == -1){
      alerta("Debe enlazar una unidad productiva primero");
      return;
    }

    var ruta = "/Cite/UnidadesProductivas/Editar/" + Select2UnidadEnlazada.value;
    window.open(ruta, "_blank");
  }




  function clickSincronizarIntegrantes(){
    confirmarConMensaje("¿Desea sincronizar los integrantes con la unidad productiva del CITE?",
                        "Después de realizar esta sincronización, la organización y la unidad productiva enlazada tendrán los mismos integrantes/socios","warning",
                        function(){
                          document.formSincronizarCITE.submit(); 
                        }
    )
  }

</script>
<style>
  .msj_activarsi{
    color:rgb(41, 41, 41);
    font-size: 10pt;
  }
</style>