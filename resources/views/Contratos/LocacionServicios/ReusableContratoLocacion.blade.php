<script>

  var ListaDetalles = [];
  var modo;

  var totalAcumulado = 0;
  var porcentajeAcumulado = 0;


  const NuevoMontoInput = document.getElementById('nuevoMonto')
  const NuevoPorcentajeInput = document.getElementById('nuevoPorcentaje')
  const NuevaDescripcionInput = document.getElementById('nuevaDescripcion');
  const NuevaFechaInput = document.getElementById('nuevaFecha');

  const RetribucionTotalInput = document.getElementById('retribucionTotal')

  function validarForm() { //Retorna TRUE si es que todo esta OK y se puede hacer el submit
    msj = '';

    limpiarEstilos([
      'esPersonaNatural',
      'PN_ruc', 'PN_dni', 'PN_nombres', 'PN_apellidos', 'PN_sexo', 'PN_direccion',
      'PN_provinciaYDepartamento', //campos de PN
      'PJ_ruc', 'PJ_razonSocialPJ', 'PJ_sexo', 'PJ_direccion', 'PJ_provinciaYDepartamento', 'PJ_dni', 'PJ_nombres',
      'PJ_apellidos', 'PJ_nombreDelCargoPJ', /* Campos de PJ */
      'motivoContrato', 'fecha_inicio_contrato', 'fecha_fin_contrato', 'retribucionTotal', 'codMoneda', 'codSede', 'nombreProyecto',
      'nombreFinanciera'
    ]);



    msj = validarSelect(msj, 'esPersonaNatural', '-1', 'Tipo de persona');

    if (esPersonaNatural.value == '1') { //PERSONA NATURAL

      msj = validarTamañoExacto(msj, 'PN_ruc', '11', 'RUC');
      msj = validarTamañoExacto(msj, 'PN_dni', '8', 'DNI');
      msj = validarTamañoMaximoYNulidad(msj, 'PN_nombres', 300, 'Nombres');
      msj = validarTamañoMaximoYNulidad(msj, 'PN_apellidos', 300, 'Apellidos');
      msj = validarSelect(msj, 'PN_sexo', '-1', 'Sexo');
      msj = validarTamañoMaximoYNulidad(msj, 'PN_direccion', 500, 'Dirección');
      msj = validarTamañoMaximoYNulidad(msj, 'PN_provinciaYDepartamento', 200, 'Provincia y Departamento');
    }
    if (esPersonaNatural.value == '0') { //PERSONA JURIDICA
      msj = validarTamañoExacto(msj, 'PJ_ruc', '11', 'RUC');
      msj = validarTamañoMaximoYNulidad(msj, 'PJ_razonSocialPJ', 200, 'Razón Social');
      msj = validarSelect(msj, 'PJ_sexo', '-1', 'Sexo');
      msj = validarTamañoMaximoYNulidad(msj, 'PJ_direccion', 500, 'Dirección');
      msj = validarTamañoMaximoYNulidad(msj, 'PJ_provinciaYDepartamento', 200, 'Provincia y Departamento');


      msj = validarTamañoExacto(msj, 'PJ_dni', '8', 'DNI');
      msj = validarTamañoMaximoYNulidad(msj, 'PJ_nombres', 300, 'Nombres');
      msj = validarTamañoMaximoYNulidad(msj, 'PJ_apellidos', 300, 'Apellidos');
      msj = validarTamañoMaximoYNulidad(msj, 'PJ_nombreDelCargoPJ', 200, 'Nombre del cargo');


    }



    msj = validarTamañoMaximoYNulidad(msj, 'motivoContrato', 1000, 'Motivo del Contrato');
    msj = validarNulidad(msj, 'fecha_inicio_contrato', 'Fecha de inicio');
    msj = validarNulidad(msj, 'fecha_fin_contrato', 'Fecha de fin');

    msj = validarPositividadYNulidad(msj, 'retribucionTotal', 'Monto retribución');
    msj = validarSelect(msj, 'codMoneda', '-1', 'Moneda');
    msj = validarSelect(msj, 'codSede', '-1', 'Sede');
    msj = validarTamañoMaximoYNulidad(msj, 'nombreProyecto', 300, 'Proyecto');
    msj = validarTamañoMaximoYNulidad(msj, 'nombreFinanciera', 300, 'Financiera');


    if (ListaDetalles.length == 0)
      msj = "No ha ingresado detalles";


    if (porcentajeAcumulado != 100 && totalAcumulado != RetribucionTotalInput.value)
      msj = "La suma de los porcentajes debe ser de 100. La actual es " + porcentajeAcumulado;

    return msj;
  }




  indexAEliminar = 0;

  function eliminardetalle(index) {
    indexAEliminar = index;
    confirmarConMensaje("Confirmación", "¿Desea eliminar el item N° " + (index + 1) + "?", 'warning',
      ejecutarEliminacionDetalle);
  }

  function ejecutarEliminacionDetalle() {
    ListaDetalles.splice(indexAEliminar, 1);
    actualizarTabla();
  }


  function compararFechas(fecha, fechaIngresada) { //1 si la fecha ingresada es menor (dd-mm-yyyy)
    diaActual = fechaIngresada.substring(0, 2);
    mesActual = fechaIngresada.substring(3, 5);
    anioActual = fechaIngresada.substring(6, 10);
    dia = fecha.substring(0, 2);
    mes = fecha.substring(3, 5);
    anio = fecha.substring(6, 10);


    if (parseInt(anio, 10) > parseInt(anioActual, 10)) {
      //console.log('el año ingresado es menor');
      return 1;
    } else if (parseInt(anio, 10) == parseInt(anioActual, 10)) {

      if (parseInt(mes, 10) > parseInt(mesActual, 10)) {
        //console.log('el mes ingresado es menor');
        return 1;
      } else if (parseInt(mes, 10) == parseInt(mesActual, 10)) {

        if (parseInt(dia, 10) > parseInt(diaActual, 10)) {
          //console.log('el dia ingresado es menor');
          return 1;
        } else {
          return 0;
        }

      } else return 0;

    } else return 0;

  }


  function clickAgregarDetalle() {
    limpiarEstilos(['nuevaFecha', 'nuevaDescripcion', 'nuevoMonto', 'nuevoPorcentaje']);

    nuevaFecha = NuevaFechaInput.value;
    nuevaDescripcion = NuevaDescripcionInput.value;
    nuevoMonto = NuevoMontoInput.value;
    nuevoPorcentaje = NuevoPorcentajeInput.value;

    msjError = "";

    msjError = validarNulidad(msjError, 'nuevaFecha', 'Fecha');
    msjError = validarTamañoMaximoYNulidad(msjError, 'nuevaDescripcion', {{ App\Configuracion::tamañoMaximoLugar }},'Descripción');

    msjError = validarPositividadYNulidad(msjError, 'nuevoMonto', 'Monto');
    msjError = validarPositividadYNulidad(msjError, 'nuevoPorcentaje', 'Porcentaje');


    if (parseFloat(nuevoMonto) + parseFloat(totalAcumulado) > parseFloat(RetribucionTotalInput.value)){

      msjError = "Al añadir este avance, el monto actual se excedería del pago total.";
    }

    if (msjError != "") {
      alerta(msjError);
      return false;
    }

    agregarDetalle(nuevaFecha,nuevaDescripcion,nuevoMonto,nuevoPorcentaje,0)
  }


  function agregarDetalle(nuevaFecha,nuevaDescripcion,nuevoMonto,nuevoPorcentaje,codAvance){

    posicion_insercion = 0;
    // FIN DE VALIDACIONES
    if (ListaDetalles.length > 0) {
      detener_recorrido = true;

      for (let item = 0; item < ListaDetalles.length && detener_recorrido; item++) {
        element = ListaDetalles[item];

        if (compararFechas(element.fecha, nuevaFecha) == 1) {
          posicion_insercion = item;
          detener_recorrido = false;
        } else {
          posicion_insercion = item + 1;
        }
      }


    }

    ListaDetalles.splice(posicion_insercion, 0, {
      codAvance: codAvance,
      fecha: nuevaFecha,
      descripcion: nuevaDescripcion,
      monto: nuevoMonto,
      porcentaje: nuevoPorcentaje
    });

    actualizarTabla();
    limpiarFormAgregar();

  }

  function limpiarFormAgregar() {
    NuevaFechaInput.value = "";
    NuevaDescripcionInput.value = "";
    NuevoMontoInput.value = '';
    NuevoPorcentajeInput.value = '';
  }



  const PlantillaFila = document.getElementById("plantilla_fila").innerHTML;
  const TablaDetalles = document.getElementById("tabla_detalles");

  const SpanPorcentajeAcumulado = document.getElementById("spanPorcentajeAcumulado");
  const SpanMontoAcumulado = document.getElementById("spanMontoAcumulado");

  const JsonDetallesInput = document.getElementById("json_detalles");

  function actualizarTabla() {

    importeTotalEscrito = RetribucionTotalInput.value;

    totalAcumulado = 0;
    porcentajeAcumulado = 0;

    var html_total = "";
    //insertamos en la tabla los nuevos elementos
    for (let index = 0; index < ListaDetalles.length; index++) {
      /* Actualizamos el porcentaje escrito */
      ListaDetalles[index].porcentaje = (100 * parseFloat(ListaDetalles[index].monto) / importeTotalEscrito).toFixed(2);

      element = ListaDetalles[index];



      totalAcumulado = totalAcumulado + parseFloat(element.monto);
      porcentajeAcumulado = porcentajeAcumulado + parseFloat(element.porcentaje);

      var HidrationObject = {
        Index: index,
        Fecha: element.fecha,
        Descripcion: element.descripcion,
        Monto: element.monto,
        Porcentaje: element.porcentaje,
      }

      var fila = hidrateHtmlString(PlantillaFila, HidrationObject);
      html_total += fila;
    }

    TablaDetalles.innerHTML = html_total;

    SpanPorcentajeAcumulado.innerHTML = number_format(porcentajeAcumulado, 2) + "%";
    SpanMontoAcumulado.innerHTML = number_format(totalAcumulado, 2);

    pintarColorPorcentaje(porcentajeAcumulado);

    JsonDetallesInput.value = JSON.stringify(ListaDetalles);

  }

  function pintarColorPorcentaje(porcentajeAcumulado) {
    potVerde = 255 * porcentajeAcumulado / 100;
    potRoja = 255 - potVerde;
    if (porcentajeAcumulado > 100.05) {
      potVerde = 0;
      potRoja = 255;
    }
    flagPorcentajeAcumulado.style.color = "rgb(" + potRoja + "," + potVerde + ",0)"
  }



  function editarDetalle(index) {
    const Detalle = ListaDetalles[index];

    NuevaFechaInput.value = Detalle.fecha;
    NuevaDescripcionInput.value = Detalle.descripcion;
    NuevoMontoInput.value = Detalle.monto;
    NuevoPorcentajeInput.value = Detalle.porcentaje;

    indexAEliminar = index;
    ejecutarEliminacionDetalle();

  }



  function actualizarRetribucionTotal() {
    if (!hayMontoRetribucion()) { //si es no valido, ocultamos el coso de monto y porcentaje
      NuevoMontoInput.readOnly = true;
      NuevoPorcentajeInput.readOnly = true;
    } else {
      modo = "porcentaje";
      NuevoMontoInput.readOnly = true;
      NuevoPorcentajeInput.readOnly = false;
    }

    actualizarTabla();
    cambioMonto();

  }

  const InputRetribucionTotal = document.getElementById("retribucionTotal");

  function hayMontoRetribucion() {
    valor = InputRetribucionTotal.value;
    return (valor != "" && valor != 0);
  }

  function cambiarAModoMonto() {
    if (hayMontoRetribucion()) {
      modo = "monto";
      NuevoMontoInput.readOnly = false;
      NuevoPorcentajeInput.readOnly = true;
    } else {
      alerta("Ingrese un monto de retribución para poder ingresar el monto de los avances entregables.")
      ponerEnRojo("retribucionTotal")
    }

  }


  function cambiarAModoPorcentaje() {

    if (hayMontoRetribucion()) {
      modo = "porcentaje";
      NuevoMontoInput.readOnly = true;
      NuevoPorcentajeInput.readOnly = false;
    } else {
      alerta("Ingrese un monto de retribución para poder ingresar el monto de los avances entregables.")
    }
  }


  function cambioMonto() {

    nuevoMonto = NuevoMontoInput.value;
    retribucionTotal = InputRetribucionTotal.value;
    porcentaje = (100 * nuevoMonto / retribucionTotal).toFixed(2);


    NuevoPorcentajeInput.value = (porcentaje);
  }


  function cambioPorcentaje() {

    nuevoPorcentaje = NuevoPorcentajeInput.value;
    retribucionTotal = InputRetribucionTotal.value;

    nuevoMonto = parseFloat(nuevoPorcentaje * retribucionTotal / 100).toFixed(2);

    NuevoMontoInput.value = nuevoMonto;

  }



  function cambiarTipoPersona() {

    esPN = esPersonaNatural.value;

    if (esPN == 1) { //PERSONA  NATURAL Va DNI y RUC
      FormPN.hidden = false;
      FormPJ.hidden = true;
    }
    if (esPN == 0) { //PERSONA JURIDICA SOLO RUC
      FormPN.hidden = true;
      FormPJ.hidden = false;
    }

    if (esPN == -1) { //PERSONA JURIDICA SOLO RUC
      FormPN.hidden = true;
      FormPJ.hidden = true;
    }


  }
</script>
