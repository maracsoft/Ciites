<script>

  function validarFormulario(modo){
    msj = "";

    if(modo == 'crear'){
      limpiarEstilos([
        'codOrganizacion',
        'codObjetivo',
        'codIndicador',
        'codActividad',
        'fechaInicio',
        'fechaFin',
      ]);

        
      msj = validarSelect(msj, 'codOrganizacion', -1, 'Organización');
      msj = validarSelect(msj, 'codObjetivo', -1, 'Objetivo');
      msj = validarSelect(msj, 'codIndicador', -1, 'Indicador');
      msj = validarSelect(msj, 'codActividad', -1, 'Actividad');
      msj = validarNulidad(msj, 'fechaInicio', 'Fecha de inicio');
      msj = validarNulidad(msj, 'fechaFin', 'Fecha de fin');
    
    }


    limpiarEstilos([
      'descripcion',
      'ComboBoxDistrito'
	  ]);


    msj = validarTamañoMaximoYNulidad(msj, 'descripcion', 900, 'Descripción');  
    msj = validarLugarSelector_ComboBoxDistrito(msj);

    return msj;

  }


  function changeInscribirEnUnidad(checked){
    if(checked){
      mostrarDivCargo();
    }else{
      ocultarDivCargo();
    }
  }


  const DivCargo = document.getElementById('div_cargo');
  
  function mostrarDivCargo(){
    DivCargo.classList.remove("hidden")
  }

  function ocultarDivCargo(){
    DivCargo.classList.add("hidden")
  }

 

  /* ------------------------------- LOGICA DE SELECTS ------------------------- */
  /* ------------------------------- LOGICA DE SELECTS ------------------------- */
  /* ------------------------------- LOGICA DE SELECTS ------------------------- */
  /* ------------------------------- LOGICA DE SELECTS ------------------------- */
  /* ------------------------------- LOGICA DE SELECTS ------------------------- */
  /* ------------------------------- LOGICA DE SELECTS ------------------------- */
  /* ------------------------------- LOGICA DE SELECTS ------------------------- */
  /* ------------------------------- LOGICA DE SELECTS ------------------------- */
  /* ------------------------------- LOGICA DE SELECTS ------------------------- */
  /* ------------------------------- LOGICA DE SELECTS ------------------------- */
  
  var ListaObjetivos = @json($listaObjetivos)

  var ListaIndicadoresActual = [];


  const SelectObjetivo = document.getElementById('codObjetivo');
  const SelectIndicador = document.getElementById('codIndicador');
  const SelectActividad= document.getElementById('codActividad');

  const IndicadorEmptyRow = `<option value="-1">- Indicador -</option>`;
  const ActividadEmptyRow = `<option value="-1">- Actividad -</option>`;
    
  function changeObjetivo(){
    limpiarListaActividades();
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
    limpiarListaActividades();
    var codIndicador = SelectIndicador.value;
    var indicador = ListaIndicadoresActual.find(e => e.codIndicador == codIndicador);
    printActividades(indicador.actividades);

  }

  function printActividades(actividades){

    var html = ActividadEmptyRow;
    var plantilla_row = 
      `<option value="[CodActividad]" title="[Descripcion]">
        [[CodigoPresupuestal]] [DescripcionCorta]
      </option>
    `
      ;
    for (let index = 0; index < actividades.length; index++) {
      const actividad = actividades[index];
      var hidrate_object = {
        CodActividad:actividad.codActividad,
        DescripcionCorta:actividad.descripcion_corta,
        Descripcion:actividad.descripcion,
        CodigoPresupuestal:actividad.codigo_presupuestal
      };
      html += hidrateHtmlString(plantilla_row,hidrate_object);

    }

    SelectActividad.innerHTML = html;

  }

 

  function limpiarListaIndicadores(){
    SelectIndicador.innerHTML = IndicadorEmptyRow;
  }
  function limpiarListaActividades(){
    SelectActividad.innerHTML = ActividadEmptyRow;
  }
</script>