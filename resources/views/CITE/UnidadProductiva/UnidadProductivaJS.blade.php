<script>

    const Select2OrganizacionEnlazada = document.getElementById("codOrganizacionEnlazadaPPM"); 
    const BotonIrOrganizacion = document.getElementById("boton_ir_organizacion"); 

    function actualizarTieneEnlacePPM(checked){
      
      var select2 = document.querySelector('[data-id="codOrganizacionEnlazadaPPM"]');
      select2.disabled = !checked;

      if(checked && Select2OrganizacionEnlazada.value != "-1"){
        mostrarBotonIrOrganizacion();
      }else{
        ocultarBotonIrOrganizacion();
      }
    }


    function actualizarTieneCadena(checked){
         
        if(checked){
            newVal = 1;
            document.getElementById('codCadena').readonly = false;
            document.getElementById('codCadena').disabled = false;

        }else{
            document.getElementById('codCadena').value = -1;
            document.getElementById('codCadena').disabled = true;

            newVal = 0;

        }

        document.getElementById('tieneCadena').value = newVal;
        
    }
    const InputRUC = document.getElementById("ruc");

    function validarForm(){
        msj='';
        limpiarEstilos(['codTipoPersoneria','ruc','razonSocial','dni','nombrePersona','direccion','codClasificacion',
            'codCadena','codEstadoDocumento']);

        try {
          limpiarEstilos(["codOrganizacionEnlazadaPPM"]);
        } catch (error) {
          
        }



        msj = validarSelect(msj,'codTipoPersoneria',-1,'Tipo Personeria');

        msj = validarSelect(msj,'codClasificacion',-1,'Clasificación rango ventas');
        msj = validarLugarSelector_ComboBoxDistrito(msj);


        if(document.getElementById('tieneCadena').checked)
            msj = validarSelect(msj,'codCadena',-1,'Cadena');


        var enTramite = document.getElementById('enTramite').checked;

        if(estadoDocumentoSeleccionado.nombre == "DNI"){
            if(!enTramite) //solo valida que no esté vacío si el ya está formalizada
                msj = validarNulidad(msj,'dni','DNI');


            msj = validarTamañoExactoONulidad(msj,'dni',8,'DNI');
            msj = validarTamañoMaximoYNulidad(msj,'nombrePersona',200,'Nombre Persona');

            document.getElementById('ruc').value = "";
            document.getElementById('razonSocial').value = "";
        }

        if(estadoDocumentoSeleccionado.nombre == "RUC"){

            if(!enTramite) //solo valida que no esté vacío si el ya está formalizada
                msj = validarNulidad(msj,'ruc','RUC');


            msj = validarTamañoExactoONulidad(msj,'ruc',11,'RUC');
            msj = validarTamañoMaximoYNulidad(msj,'razonSocial',{{App\Configuracion::tamañoAtencionOC}},'Razón Social');

            document.getElementById('dni').value = "";
            document.getElementById('nombrePersona').value = "";

        }

        if(document.getElementById("activar_enlace_ppm").checked){
          
          msj = validarSelect(msj, 'codOrganizacionEnlazadaPPM', -1, 'Organización Enlazada de PPM');

          if(msj == ""){
            //verificamos que la organizacion enlazada tenga el mismo RUC
            
            var unidad = ListaOrganizaciones.find(e => e.codOrganizacion == Select2OrganizacionEnlazada.value); //obtenemos la unidad seleccionada por el select2
 
            var unidad_ruc = InputRUC.value; 

            if(unidad.ruc != unidad_ruc){
              ponerEnRojo("codOrganizacionEnlazadaPPM");
              msj = "La organización enlazada debe tener el mismo RUC que la unidad productiva actual ("+ unidad_ruc +")";
            }
          }

    
        }



        msj = validarTamañoMaximoYNulidad(msj,'direccion',{{App\Configuracion::tamañoSeñoresOC}},'Dirección');
        msj = validarTamañoMaximoYNulidad(msj,'codClasificacion',20,'Clasificación Rango de ventas');

        return msj;

    }

    /* llama a mi api que se conecta  con la api de la sunat
        si encuentra, llena con los datos que encontró
        si no tira mensaje de error
    */
    function consultarPorRuc(){

        msjError="";
        ruc=$("#ruc").val();
        if(ruc=='')
            msjError=("Por favor ingrese el ruc");


        if(ruc.length!=11)
            msjError=("Por favor ingrese el ruc completo. Solo 11 digitos.");


        if(msjError!=""){
            alerta(msjError);
            return;
        }

        $(".loader").show();//para mostrar la pantalla de carga

        $.get('/ConsultarAPISunat/ruc/'+ruc,
            function(data)
                {
                    console.log("IMPRIMIENDO DATA como llegó:");
                    console.log(data);

                    if(data==1){
                        alerta("Persona juridica no encontrada.");

                    }else{
                        console.log('DATA PARSEADA A JSON:')
                        personaJuridicaEncontrada = JSON.parse(data)
                        console.log(personaJuridicaEncontrada);


                        document.getElementById('razonSocial').value = personaJuridicaEncontrada.razonSocial;


                        //document.getElementById('actividadPrincipal').value = personaJuridicaEncontrada.actEconomicas;
                        if(personaJuridicaEncontrada.direccion!="")
                            document.getElementById('direccion').value = personaJuridicaEncontrada.direccion;

                    }

                    $(".loader").fadeOut("slow");
                }
            );
    }


    function consultarPorDNI(){

        msjError="";

        msjError = validarTamañoExacto(msjError,'dni',8,'DNI');
        msjError = validarNulidad(msjError,'dni','DNI');


        if(msjError!=""){
            alerta(msjError);
            return;
        }


        $(".loader").show();//para mostrar la pantalla de carga
        dni = document.getElementById('dni').value;

        $.get('/ConsultarAPISunat/dni/'+dni,
            function(data)
            {
                console.log("IMPRIMIENDO DATA como llegó:");

                data = JSON.parse(data);

                console.log(data);
                persona = data.datos;

                alertaMensaje(data.mensaje,data.titulo,data.tipoWarning);
                if(data.ok==1){
                    document.getElementById('nombrePersona').value = persona.nombres + " " + persona.apellidoPaterno + " " + persona.apellidoMaterno;
                }

                $(".loader").fadeOut("slow");
            }
        );
    }




    const divDNI = document.getElementById('divDNI');
    const divRUC = document.getElementById('divRUC');

    var listaEstadosUnidad = @php echo $listaEstadosUnidad @endphp

    var estadoDocumentoSeleccionado = {};
    function actualizarEstadoDocumento(codEstado){
        //console.log("actualizarEstadoDocumento," + codEstado + ",")

        //ocultamos ambos

        ocultarDivDNI();
        ocultarDivRUC();

        //mostramos el seleccionado

        estadoDocumentoSeleccionado = listaEstadosUnidad.find(e => e.codEstadoDocumento == codEstado)
        nombreEstadoSeleccionado = estadoDocumentoSeleccionado.nombre;
        //console.log("nombreEstadoSeleccionado",nombreEstadoSeleccionado)
        switch (nombreEstadoSeleccionado) {
            case "RUC":
                mostrarDivRUC();
                break;
            case "DNI":
                mostrarDivDNI();
                break;
        }

    }

    function ocultarDivRUC(){
        divRUC.classList.add("hidden")
    }
    function mostrarDivRUC(){
        divRUC.classList.remove("hidden")
    }

    function ocultarDivDNI(){
        divDNI.classList.add("hidden")
    }
    function mostrarDivDNI(){
        divDNI.classList.remove("hidden")
    }

    function ocultarBotonIrOrganizacion() {
      BotonIrOrganizacion.classList.add("hidden")
    }

    function mostrarBotonIrOrganizacion() {
      BotonIrOrganizacion.classList.remove("hidden")
    }


    function actualizarDocumentoTramite(CheckBox){

        var enTramite = CheckBox.checked;
        if(enTramite)
            document.getElementById('ruc').value="";


        document.getElementById('ruc').readOnly = enTramite;

    }


      
    function changedOrganizacionEnlazada(){
      
      if(Select2OrganizacionEnlazada.value == "-1"){
        ocultarBotonIrOrganizacion();
        return;
      }
      mostrarBotonIrOrganizacion();

      var org = ListaOrganizaciones.find(e => e.codOrganizacion ==  Select2OrganizacionEnlazada.value);
      BotonIrOrganizacion.title = "Ir a la Organización enlazada " + org.razonYRUC;
    }

    function clickIrAOrganizacionEnlazada(){
      if(Select2OrganizacionEnlazada.value == -1){
        alerta("Debe enlazar una unidad productiva primero");
        return;
      }
      var ruta = "/PPM/Organizacion/Editar/" + Select2OrganizacionEnlazada.value;
      window.open(ruta, "_blank");
    }


    function clickSincronizarIntegrantes(){
      confirmarConMensaje("¿Desea sincronizar los integrantes con la organización del PPM?",
                        "Después de realizar esta sincronización, la unidad productiva y la organización enlazada tendrán los mismos integrantes/socios","warning",
                        function(){
                          document.formSincronizarPPM.submit(); 
                        }
      );
    }

</script>
