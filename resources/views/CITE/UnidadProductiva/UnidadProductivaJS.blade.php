<script>

    function actualizarTieneCadena(checked){
        console.log("checked",checked);
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
        console.log(newVal);
    }

    function validarForm(){
        msj='';
        limpiarEstilos(['codTipoPersoneria','ruc','razonSocial','dni','nombrePersona','direccion','codClasificacion',
            'codCadena','codEstadoDocumento']);



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


    function actualizarDocumentoTramite(CheckBox){

        var enTramite = CheckBox.checked;
        if(enTramite)
            document.getElementById('ruc').value="";


        document.getElementById('ruc').readOnly = enTramite;

    }

</script>
