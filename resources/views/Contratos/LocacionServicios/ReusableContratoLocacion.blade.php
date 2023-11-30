@include('Contratos.ModalBorrador')
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
      'PJ_ruc', 'PJ_razonSocialPJ', 'PJ_direccion', 'PJ_dni', 'PJ_nombres',
      'PJ_apellidos', 'PJ_nombreDelCargoPJ', /* Campos de PJ */
      'motivoContrato', 'fecha_inicio_contrato', 'fecha_fin_contrato', 'retribucionTotal', 'codMoneda', 'codSede',
      'nombreProyecto',
      'nombreFinanciera',

      'PN_provincia', 'PN_departamento', 'PN_distrito',
      'PJ_provincia', 'PJ_departamento', 'PJ_distrito'
    ]);



    msj = validarSelect(msj, 'esPersonaNatural', '-1', 'Tipo de persona');

    if (esPersonaNatural.value == '1') { //PERSONA NATURAL

      msj = validarTamañoExacto(msj, 'PN_ruc', '11', 'RUC');
      msj = validarTamañoExacto(msj, 'PN_dni', '8', 'DNI');
      msj = validarTamañoMaximoYNulidad(msj, 'PN_nombres', 300, 'Nombres');
      msj = validarTamañoMaximoYNulidad(msj, 'PN_apellidos', 300, 'Apellidos');
      msj = validarSelect(msj, 'PN_sexo', '-1', 'Sexo');
      msj = validarTamañoMaximoYNulidad(msj, 'PN_direccion', 500, 'Dirección');

      msj = validarTamañoMaximoYNulidad(msj, 'PN_provincia', 200, 'Provincia');
      msj = validarTamañoMaximoYNulidad(msj, 'PN_distrito', 200, 'Distrito');
      msj = validarTamañoMaximoYNulidad(msj, 'PN_departamento', 200, 'Departamento');

    }

    if (esPersonaNatural.value == '0') { //PERSONA JURIDICA
      msj = validarTamañoExacto(msj, 'PJ_ruc', '11', 'RUC');
      msj = validarTamañoMaximoYNulidad(msj, 'PJ_razonSocialPJ', 200, 'Razón Social');

      msj = validarTamañoMaximoYNulidad(msj, 'PJ_direccion', 500, 'Dirección');

      msj = validarTamañoMaximoYNulidad(msj, 'PJ_distrito', 200, 'Distrito');
      msj = validarTamañoMaximoYNulidad(msj, 'PJ_provincia', 200, 'Provincia');
      msj = validarTamañoMaximoYNulidad(msj, 'PJ_departamento', 200, 'Departamento');

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
    msjError = validarTamañoMaximoYNulidad(msjError, 'nuevaDescripcion', {{ App\Configuracion::tamañoMaximoLugar }},
      'Descripción');

    msjError = validarPositividadYNulidad(msjError, 'nuevoMonto', 'Monto');
    msjError = validarPositividadYNulidad(msjError, 'nuevoPorcentaje', 'Porcentaje');


    if (parseFloat(nuevoMonto) + parseFloat(totalAcumulado) > parseFloat(RetribucionTotalInput.value)) {

      msjError = "Al añadir este avance, el monto actual se excedería del pago total.";
    }

    if (msjError != "") {
      alerta(msjError);
      return false;
    }

    agregarDetalle(nuevaFecha, nuevaDescripcion, nuevoMonto, nuevoPorcentaje, 0)
  }


  function agregarDetalle(nuevaFecha, nuevaDescripcion, nuevoMonto, nuevoPorcentaje, codAvance) {

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



  function GenerarBorrador() {

    var msj = validarForm();
    if (msj != "") {
      alerta(msj)
      return;
    }



    var obj_persona = {};

    if (esPersonaNatural.value == '1') { //PERSONA NATURAL
      obj_persona = {
        PN_ruc: document.getElementById('PN_ruc').value,
        PN_dni: document.getElementById('PN_dni').value,
        PN_nombres: document.getElementById('PN_nombres').value,
        PN_apellidos: document.getElementById('PN_apellidos').value,
        PN_sexo: document.getElementById('PN_sexo').value,
        PN_direccion: document.getElementById('PN_direccion').value,

        PN_distrito: document.getElementById('PN_distrito').value,
        PN_provincia: document.getElementById('PN_provincia').value,
        PN_departamento: document.getElementById('PN_departamento').value,
      };

    }

    if (esPersonaNatural.value == '0') { //PERSONA JURIDICA
      obj_persona = {
        PJ_ruc: document.getElementById('PJ_ruc').value,
        PJ_razonSocialPJ: document.getElementById('PJ_razonSocialPJ').value,
        PJ_direccion: document.getElementById('PJ_direccion').value,

        PJ_distrito: document.getElementById('PJ_distrito').value,
        PJ_provincia: document.getElementById('PJ_provincia').value,
        PJ_departamento: document.getElementById('PJ_departamento').value,
        PJ_dni: document.getElementById('PJ_dni').value,
        PJ_nombres: document.getElementById('PJ_nombres').value,
        PJ_apellidos: document.getElementById('PJ_apellidos').value,
        PJ_nombreDelCargoPJ: document.getElementById('PJ_nombreDelCargoPJ').value,
      };

    }

    var datos_generales = {
      _token: "{{ csrf_token() }}",
      motivoContrato: document.getElementById('motivoContrato').value,
      fecha_inicio_contrato: document.getElementById('fecha_inicio_contrato').value,
      fecha_fin_contrato: document.getElementById('fecha_fin_contrato').value,
      retribucionTotal: document.getElementById('retribucionTotal').value,
      codMoneda: document.getElementById('codMoneda').value,
      codSede: document.getElementById('codSede').value,
      nombreProyecto: document.getElementById('nombreProyecto').value,
      nombreFinanciera: document.getElementById('nombreFinanciera').value,
      esPersonaNatural: document.getElementById('esPersonaNatural').value,
      json_detalles: JSON.stringify(ListaDetalles)
    }

    var data_send = {
      ...obj_persona,
      ...datos_generales
    };


    ruta = "{{ route('ContratosLocacion.GenerarBorrador') }}";
    $(".loader").show();

    $.post(ruta, data_send, function(dataRecibida) {
      $(".loader").hide();

      ModalBorrador.show()
      objetoRespuesta = JSON.parse(dataRecibida);

      var filename = objetoRespuesta.datos
      iframe_borrador.src = "/Contratos/Borradores/Ver/" + filename;
    });

  }

  /*
    llama a mi api que se conecta  con la api de la sunat
    si encuentra, llena con los datos que encontró
    si no tira mensaje de error
  */
  function consultarPorDNI_PN() {

    msjError = "";

    msjError = validarTamañoExacto(msjError, 'PN_dni', 8, 'DNI');
    msjError = validarNulidad(msjError, 'PN_dni', 'DNI');

    if (msjError != "") {
      alerta(msjError);
      return;
    }

    $(".loader").show(); //para mostrar la pantalla de carga
    dni = document.getElementById('PN_dni').value;

    $.get('/ConsultarAPISunat/dni/' + dni,
      function(data) {
        console.log("IMPRIMIENDO DATA como llegó:");

        data = JSON.parse(data);

        console.log(data);
        persona = data.datos;

        alertaMensaje(data.mensaje, data.titulo, data.tipoWarning);

        if (data.ok == 1) {
          document.getElementById('PN_nombres').value = persona.nombres;
          document.getElementById('PN_apellidos').value = persona.apellidoPaterno + " " + persona.apellidoMaterno;
        }

        $(".loader").fadeOut("slow");
      }
    );
  }



  function consultarPorDNI_Representante(){

    msjError = "";

    msjError = validarTamañoExacto(msjError, 'PJ_dni', 8, 'DNI del representante');
    msjError = validarNulidad(msjError, 'PJ_dni', 'DNI del representante');

    if (msjError != "") {
      alerta(msjError);
      return;
    }

    $(".loader").show(); //para mostrar la pantalla de carga
    dni = document.getElementById('PJ_dni').value;

    $.get('/ConsultarAPISunat/dni/' + dni,
      function(data) {
        console.log("IMPRIMIENDO DATA como llegó:");

        data = JSON.parse(data);

        console.log(data);
        persona = data.datos;

        alertaMensaje(data.mensaje, data.titulo, data.tipoWarning);

        if (data.ok == 1) {
          document.getElementById('PJ_nombres').value = persona.nombres;
          document.getElementById('PJ_apellidos').value = persona.apellidoPaterno + " " + persona.apellidoMaterno;
        }

        $(".loader").fadeOut("slow");
      }
    );
  }


  /*
    llama a mi api que se conecta  con la api de la sunat
    si encuentra, llena con los datos que encontró
    si no tira mensaje de error
  */
  function consultarPorRUC() {

    msjError = "";
    ruc = $("#PJ_ruc").val();
    if (ruc == '')
      msjError = ("Por favor ingrese el ruc");


    if (ruc.length != 11)
      msjError = ("Por favor ingrese el ruc completo. Solo 11 digitos.");


    if (msjError != "") {
      alerta(msjError);
      return;
    }

    $(".loader").show(); //para mostrar la pantalla de carga

    $.get('/ConsultarAPISunat/ruc/' + ruc,
      function(data) {


        if (data == 1) {
          alerta("Persona juridica no encontrada.");

        } else {

          personaJuridicaEncontrada = JSON.parse(data)
          console.log(personaJuridicaEncontrada);

          document.getElementById('PJ_razonSocialPJ').value = personaJuridicaEncontrada.razonSocial;
          document.getElementById('PJ_direccion').value = personaJuridicaEncontrada.direccion;

        }

        $(".loader").fadeOut("slow");
      }
    );
  }
</script>

<style>


  .campo_editable {
    color: rgb(0, 62, 176);

    font-weight: bold;
  }

  .semuestra {
    text-align: center;
    padding: 5px;
    background-color: #f1f1f1;
    margin-bottom: 10px;
    border-radius: 5px;
  }

  .flex-auto {
    flex: auto;
  }

  .icono_buscar {
    margin-top: 3px;
    margin-bottom: 3px;
  }
</style>
