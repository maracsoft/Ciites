<script>
    
    function validarFormulario(){
        msj='';
        var es_pagado = document.getElementById('codTipoAcceso').value == 2;


        limpiarEstilos(['codUnidadProductiva','codTipoServicio','codModalidad','codTipoAcceso','cantidadServicio',
            'nroHorasEfectivas','descripcion','fechaInicio','fechaTermino',
            'codTipoCDP','baseImponible','igv','total','nroComprobante','codActividad'])
        
        msj = validarSelect(msj,'codUnidadProductiva',-1,'Unidad Productiva');
        msj = validarSelect(msj,'codTipoServicio',-1,'Tipo Servicio');
        msj = validarSelect(msj,'codActividad',-1,'Actividad del Servicio');

        
        msj = validarSelect(msj,'codModalidad',-1,'Modalidad');
        msj = validarSelect(msj,'codTipoAcceso',-1,'Tipo Acceso');

        msj = validarLugarSelector_ComboBoxDistrito(msj);


        if(es_pagado){

            //msj = validarSelect(msj,'codTipoCDP',"",'Tipo de comprobante de pago');
            //msj = validarPositividadYNulidad(msj,'baseImponible','Base imponible');
            //msj = validarPositividadYNulidad(msj,'igv','IGV');
            //msj = validarPositividadYNulidad(msj,'total','Total');
            //msj = validarNulidad(msj,'nroComprobante','Número de comprobante');
        }
                
        msj = validarTamañoMaximoYNulidad(msj,'descripcion',500,'Descripcion');

        msj = validarPositividadYNulidad(msj,'cantidadServicio','Cantidad Servicio');
        
        msj = validarPositividadYNulidad(msj,'nroHorasEfectivas','Nro horas efectivas');
        
        msj = validarNulidad(msj,'fechaInicio','Fecha Inicio');
        msj = validarNulidad(msj,'fechaTermino','Fecha Termino');
                        
        return msj;
    }

    
    const ListaModalidades = @json($listaModalidades);
    const ListaTiposServicio = @json($listaTipoServicio);

    const SelectTipoServicio = document.getElementById("codTipoServicio");
    
    function changeModalidad(codModalidadSeleccionada){
      
      var tipos_servicio = ListaTiposServicio.filter(e => e.codModalidad == codModalidadSeleccionada)    
      console.log("tipos_servicio",tipos_servicio)

      const plantilla_html = `
        <option value="[ID]">
          [LABEL]
        </option>
      `;

      var hidration_data = {
        ID:"-1",
        LABEL:"- Seleccionar -"
      };
      var html_string = "";
      html_string += hidrateHtmlString(plantilla_html,hidration_data);

      
      for (let index = 0; index < tipos_servicio.length; index++) {
        const tipo_serv = tipos_servicio[index];        
        
        hidration_data = {
          ID:tipo_serv.codTipoServicio,
          LABEL:tipo_serv.nombre
        };
        html_string += hidrateHtmlString(plantilla_html,hidration_data);

      }
      SelectTipoServicio.innerHTML = html_string;
    }
  





    
    function actualizarTipoAcceso(codModalidad){
        if(codModalidad == 2){ //PAGADO, MOSTRAR EL DIV
            document.getElementById('divConvenio').classList.remove('hidden')
        }else{
            document.getElementById('divConvenio').classList.add('hidden')
        }

    }

    var listaActividades = @php echo $listaActividades @endphp 
    function actualizarTipoServicio(codTipoServicio){

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