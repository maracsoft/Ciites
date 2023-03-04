<script>
    
    function validarFormulario(){
        msj='';
        var conConvenio = document.getElementById('codModalidad').value == 1;


        limpiarEstilos(['codUnidadProductiva','codTipoServicio','codModalidad','codTipoAcceso','cantidadServicio','totalParticipantes',
            'nroHorasEfectivas','descripcion','codMesAño','fechaInicio','fechaTermino',
            'codTipoCDP','baseImponible','igv','total','nroComprobante','codActividad'])
        
        msj = validarSelect(msj,'codUnidadProductiva',-1,'Unidad Productiva');
        msj = validarSelect(msj,'codTipoServicio',-1,'Tipo Servicio');
        msj = validarSelect(msj,'codActividad',-1,'Actividad del Servicio');

        
        msj = validarSelect(msj,'codModalidad',-1,'Modalidad');
        msj = validarSelect(msj,'codTipoAcceso',-1,'Tipo Acceso');
        msj = validarSelect(msj,'codMesAño',-1,'Mes');
        //msj = validarSelect(msj,'ComboBoxDistrito',-1,'Distrito');
        //msj = validarSelect(msj,'ComboBoxDepartamento',-1,'Departamento');
        //msj = validarSelect(msj,'ComboBoxProvincia',-1,'Provincia');
        msj = validarLugarSelector_ComboBoxDistrito(msj);


        if(conConvenio){
            msj = validarSelect(msj,'codTipoCDP',-1,'Tipo de comprobante de pago');
            msj = validarPositividadYNulidad(msj,'baseImponible','Base imponible');
            msj = validarPositividadYNulidad(msj,'igv','IGV');
            msj = validarPositividadYNulidad(msj,'total','Total');
            msj = validarNulidad(msj,'nroComprobante','Número de comprobante');
        }
                
        msj = validarTamañoMaximoYNulidad(msj,'descripcion',500,'Descripcion');

        msj = validarPositividadYNulidad(msj,'cantidadServicio','Cantidad Servicio');
        msj = validarPositividadYNulidad(msj,'totalParticipantes','Total Participantes');
        msj = validarPositividadYNulidad(msj,'nroHorasEfectivas','Nro horas efectivas');
        
        msj = validarNulidad(msj,'fechaInicio','Fecha Inicio');
        msj = validarNulidad(msj,'fechaTermino','Fecha Termino');
                        
        return msj;
    }

    
     
        









    
    function actualizarModalidad(codModalidad){
        if(codModalidad == 1){ //CON CONVENIO, MOSTRAR EL DIV
            document.getElementById('divConvenio').classList.remove('hidden')
        }else{
            document.getElementById('divConvenio').classList.add('hidden')
        }

    }

    var listaActividades = @php echo $listaActividades @endphp 
    function actualizarTipo(codTipoServicio){

        var listaDisponible = listaActividades.filter(e=>e.codTipoServicio == codTipoServicio);
        console.log("listaDisponible",listaDisponible)
        
        cadenaHTML = `<option value="-1" selected> - Actividad - </option>`;
        for (let index = 0; index < listaDisponible.length; index++) {
            const actividad = listaDisponible[index];
            
            cadenaHTML = cadenaHTML + 
            `
            <option value="`+actividad.codActividad+`">
                `+actividad.indice + " "  + actividad.nombre +`
            </option>   
            `;
        }
        ComboActividad = document.getElementById('codActividad')
        ComboActividad.innerHTML = cadenaHTML;    
         


    }
        
 
 

        /* FORMULAS 
            base + igv = total
            base + base*0.18 = total
            base*1.18 = total
        
        */
        const InputBaseImponible = document.getElementById('baseImponible')
        const InputIGV = document.getElementById('igv') 
        const InputTotal = document.getElementById('total')
        
        function cambioBaseImponible(){
            InputIGV.value = number_format(parseFloat(InputBaseImponible.value)*0.18 , 2);
            InputTotal.value = number_format(parseFloat(InputBaseImponible.value)*1.18 , 2);
        }

        function cambioTotal(){
            InputIGV.value = number_format(parseFloat(InputTotal.value)*0.18/1.18,2);
            InputBaseImponible.value =number_format(parseFloat(InputTotal.value)/1.18,2 );

        }

</script>