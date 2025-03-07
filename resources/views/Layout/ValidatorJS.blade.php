{{-- AQUI PONDRÉ EL CODIGO JAVASCRIPT PARA EL VALIDATOR
    LO MOVERÉ AQUÍ PARA QUE SOLO LAS PAGINAS QUE NECESITEN EL VALIDATOR LO CARGUEN.
    (antes lo tenia en un archivo javascript pero ocurren errores pq los navegadores no actualizan su cache (osea el archivo))

    --}}

<script>
  /* FUNCIONES EN JS PARA VALIDAR INPUTS
les ingresa como parametro
    - msjError: el mensaje de error que se haya acumulado hasta ahora, si tiene contenido, se retorna este mismo.
                La funcion solo se ejcuta realmente si el msjError es ""
    - id: id del elemento a validar (puede ser input o textarea)
    - nombreReferencial: nombre que aparecerá en el mensaje de retorno.

    OPCIONALES:
    - tamañoMax : tamaño maximo del elemento (en caso de validar tamaño)
    - indiceSeleccionNula : segun el caso puede ser 0 o 1, es el indice del elemento "-- Seleccione XXXXXX --" en el combo box
*/
  /*
  function deCompasAPuntos(amount) {
      var amount_parts = amount.split(',');
      if(amount_parts.length>1){
          return parseFloat(amount_parts.join('.'));
      }else{
          return parseFloat(amount);
      }
  }*/

  function validarPuntoDecimal(msjError, id, nombreReferencial) {
    mensaje = "";

    cantidad = document.getElementById(id).value;
    var amount_parts = cantidad.split(',');
    console.log('enhorabuean');
    console.log(amount_parts);
    if (amount_parts.length > 1) {
      ponerEnRojo(id);
      mensaje = "En el campo '" + nombreReferencial + "' no se permiten comas, solo puntos para separar la parte decimal de la entera."
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }



  var expRegNombres = new RegExp("^[A-Za-zÑñ À-ÿ]+$"); //para apellidos y nombres ^[a-zA-Z ]+$ ^[A-Za-zÑñ À-ÿ]$

  function limpiarEstilos(listaInputs) {
    listaInputs.forEach(element => {


      quitarElRojo(element)

    });

  }


  function quitarElRojo(id) {

    const element = document.getElementById(id);
    if (!element) {
      throw Error("No existe el elemento con id " + id);
    }
    listaDeClases = element.classList;

    listaDeClases.remove("form-control-undefined");

    element.classList = listaDeClases;


  }


  function ponerEnRojo(id) {
    listaDeClases = document.getElementById(id).classList

    if (!listaDeClases.contains('form-control-undefined')) //si no está ya en ROJO
    {
      listaDeClases.add("form-control-undefined");
      //Lo cambié pq cuando el input es Readonly y está como 'form-control', su color de fondo cambia a blanco y pareciera que se puede editar.
      //De nueva esta manera, ahora cada
    }

    document.getElementById(id).classList = listaDeClases;
  }

  /* Valida para la cantidad de elementos agregados (DETALLES)*/
  function validarCantidadMaximaYNulidadDetalles(msjError, id, cantidadMax) {
    mensaje = "";


    cantidad = document.getElementById(id).value;
    //console.log(cantidad);
    if (cantidad == 0 || cantidad == null) {
      mensaje = 'Debe ingresar Items';
    } else {
      cantidad = parseFloat(cantidad);
      if (cantidad > cantidadMax)
        mensaje = 'No se puede ingresar mas de ' + cantidadMax + ' Items. La cantidad actual es de ' + cantidad + ' Items';
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }
  /* Validar numeros para gastos, importes, etc (DETALLES)*/
  function validarPositividadYNulidad(msjError, id, nombreReferencial) {

    msjError = validarPositividad(msjError, id, nombreReferencial);
    msjError = validarNulidad(msjError, id, nombreReferencial);

    return msjError;
  }

  function validarNoNegatividadYNulidad(msjError, id, nombreReferencial) {

    msjError = validarNoNegatividad(msjError, id, nombreReferencial);
    msjError = validarNulidad(msjError, id, nombreReferencial);

    return msjError;
  }


  function validarPositividad(msjError, id, nombreReferencial) {
    mensaje = "";

    cantidad = document.getElementById(id).value;
    cantidad = parseFloat(cantidad);
    //console.log(cantidad);
    if (cantidad < 0) {
      ponerEnRojo(id);
      mensaje = "El valor del campo '" + nombreReferencial + "' debe ser positivo.";
    }
    if (cantidad == 0) {
      ponerEnRojo(id);
      mensaje = "El valor del campo '" + nombreReferencial + "' debe ser mayor a 0.";
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }

  function validarNoNegatividad(msjError, id, nombreReferencial) {
    mensaje = "";

    cantidad = document.getElementById(id).value;
    cantidad = parseFloat(cantidad);
    //console.log(cantidad);
    if (cantidad < 0) {
      ponerEnRojo(id);
      mensaje = "El valor del campo '" + nombreReferencial + "' debe ser positivo.";
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;


  }

  /* Valida si el contenido del id tiene nombres o apellidos validos */
  function validarRegExpNombres(msjError, id) {
    mensaje = "";

    contenido = document.getElementById(id).value;
    if (!expRegNombres.test(contenido)) {
      ponerEnRojo(id);

      mensaje = "Ingrese nombres válidos";

    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }

  function validarRegExpApellidos(msjError, id) {
    mensaje = "";
    contenido = document.getElementById(id).value;
    if (!expRegNombres.test(contenido)) {
      ponerEnRojo(id);

      mensaje = "Ingrese apellidos válidos";

    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }

  function validarContenidosIguales(msjError, id1, id2, mensajeAMostrar) {
    mensaje = "";
    contenido1 = document.getElementById(id1).value;
    contenido2 = document.getElementById(id2).value;

    if (contenido1 != contenido2) {
      ponerEnRojo(id1);
      ponerEnRojo(id2);
      mensaje = mensajeAMostrar;
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }

  function validarTamañoMaximoYNulidad(msjError, id, tamañoMax, nombreReferencial) {

    msjError = validarTamañoMaximo(msjError, id, tamañoMax, nombreReferencial);
    msjError = validarNulidad(msjError, id, nombreReferencial);

    return msjError;
  }

  /* Validar tamaño   */
  function validarTamañoMaximo(msjError, id, tamañoMax, nombreReferencial) {

    mensaje = "";


    contenido = document.getElementById(id).value;
    tamañoActual = contenido.length;
    if (tamañoActual > tamañoMax) {
      ponerEnRojo(id);

      mensaje = "La longitud máxima del campo '" + nombreReferencial + "' es de " +
        tamañoMax + " caracteres. El tamaño actual es de " + tamañoActual + " caracteres.";
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;

  }

  function validarNulidad(msjError, id, nombreReferencial) {
    mensaje = "";

    contenido = document.getElementById(id).value;
    if (contenido == "") {
      ponerEnRojo(id);
      mensaje = "Por favor ingrese el campo '" + nombreReferencial + "' . ";
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }


  function validarTamañoExacto(msjError, id, tamañoExacto, nombreReferencial) {
    mensaje = "";

    contenido = document.getElementById(id).value;
    tamañoActual = contenido.length;
    if (tamañoActual != tamañoExacto) {
      ponerEnRojo(id);
      mensaje = "La longitud del campo '" + nombreReferencial + "' debe ser de " +
        tamañoExacto + " caracteres. El tamaño actual es de " + tamañoActual + " caracteres.";
    }


    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;

  }

  //deja pasar la validacion correctamente si es una cadena vacía
  function validarTamañoExactoONulidad(msjError, id, tamañoExacto, nombreReferencial) {
    mensaje = "";

    contenido = document.getElementById(id).value;
    tamañoActual = contenido.length;
    if (tamañoActual != 0)
      if (tamañoActual != tamañoExacto) {
        ponerEnRojo(id);
        mensaje = "La longitud del campo '" + nombreReferencial + "' debe ser de " +
          tamañoExacto + " caracteres. El tamaño actual es de " + tamañoActual + " caracteres.";
      }




    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;


  }

  function validarTamañoMinimo(msjError, id, tamañoMinimo, nombreReferencial) {
    mensaje = "";

    contenido = document.getElementById(id).value;
    tamañoActual = contenido.length;
    if (tamañoActual < tamañoMinimo) {
      ponerEnRojo(id);
      mensaje = "La longitud mínima del campo '" + nombreReferencial + "' es de " +
        tamañoMax + " caracteres. El tamaño actual es de " + tamañoActual + " caracteres.";
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }


  /* Validar combo box (select) para que se haya escogido uno  */
  function validarSelect(msjError, id, indiceSeleccionNula, nombreReferencial) {
    mensaje = "";

    indiceSeleccionado = document.getElementById(id).value;
    if (indiceSeleccionado == indiceSeleccionNula) {
      ponerEnRojo(id);
      mensaje = "El campo '" + nombreReferencial + "' debe ser seleccionado.";
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }


  /*  */
  function validarCodigoPresupuestal(msjError, id, codPresupProyecto, nombreReferencial) {
    mensaje = "";

    codigoPresupuestal = document.getElementById(id).value;
    if (!codigoPresupuestal.startsWith(codPresupProyecto)) {
      ponerEnRojo(id);
      mensaje = "El " + nombreReferencial + " debe coincidir con el código presupuestal del proyecto [" + codPresupProyecto + "]. ";
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;

  }

  /* verifica que el origen de este proyecto nuevo ya existe */
  function validarOrigenNuevoProyecto(msjError, idNuevoCodigo, listaProyectos) {
    mensaje = "";

    codigoPresupuestalNuevo = document.getElementById(idNuevoCodigo).value;

    busqueda = listaProyectos.find(element => element.codigoPresupuestal == codigoPresupuestalNuevo);
    if (!(busqueda === undefined)) {
      msjError = "El origen " + busqueda.codigoPresupuestal + " ya está siendo usado por el proyecto " + busqueda.nombre;
      ponerEnRojo(idNuevoCodigo);
    }


    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }


  /* Se le pasa un vector de Strings, cada elemento es una id de un radio button */
  function validarGroupButton(msjError, vectorIDs, nombreReferencial) {
    mensaje = "";

    algunoSeleccionado = false;
    for (let index = 0; index < vectorIDs.length && !algunoSeleccionado; index++) {
      const element = document.getElementById(vectorIDs[index]);
      if (element.checked) algunoSeleccionado = true;
    }

    if (!algunoSeleccionado)
      mensaje = "No ha seleccionado ningún " + nombreReferencial + "."


    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;

  }


  function validarFechaAnterior(msjError, id_fechaAnterior, id_fechaPosterior, mensajeAMostrar) {
    mensaje = "";

    var dateString1 = document.getElementById(id_fechaAnterior).value
    var dateString2 = document.getElementById(id_fechaPosterior).value
    var fechasValidas = compararFechas(dateString1, dateString2);
    if (!fechasValidas) {
      mensaje = mensajeAMostrar;
      ponerEnRojo(id_fechaAnterior);
      ponerEnRojo(id_fechaPosterior)
    }



    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;


  }


  /* le entran 2 fechas en formato dd/mm/yyyy y sale boolean */
  function compararFechas(dateString1, dateString2) {

    var dateParts1 = dateString1.split("/");
    var dateParts2 = dateString2.split("/");

    var dateObject1 = new Date(dateParts1[2], dateParts1[1] - 1, dateParts1[0]);
    var dateObject2 = new Date(dateParts2[2], dateParts2[1] - 1, dateParts2[0]);


    if (dateObject1.getTime() > dateObject2.getTime()) {
      return false; //
    }

    return true;

  }



  function invocarHtmlEnID(ruta, idElemento) {

    $.get(ruta, function(data) {
      console.log('Se ha actualizado el objeto de id ' + idElemento + ' con contenido invocado de  ' + ruta
        //   + ' con el siguiente contenido: ' + data
      );
      objeto = document.getElementById(idElemento);
      objeto.innerHTML = data;
    });

  }

  async function Async_InvocarHtmlEnID(ruta, idElemento) {

    var data = await $.get(ruta).promise();

    console.log('Se ha actualizado el objeto de id ' + idElemento + ' con contenido invocado de  ' + ruta);
    objeto = document.getElementById(idElemento);
    objeto.innerHTML = data;

  }


  async function invocarHtmlEnID_async(ruta, idElemento) {
    await Async_InvocarHtmlEnID(ruta, idElemento);
  }


  //  datos = {coche: "Ford", modelo: "Focus", color: "rojo"};
  function enviarPeticionPOST(ruta, datos) {


  }

  function cerrarModal(idModal) {
    $("#" + idModal + " .close").click()

  }


  //GIRA UN ICONO 90 grados, se vale de las clases vaAGirar y rotado que están en editarProyecto
  function girarIcono(idIcono) {
    //console.log('GIRANDO EL ' + idIcono);
    elemento = document.querySelector('#' + idIcono);
    estaGirado = elemento.classList.contains('rotado'); //booleano para ver si lo contiene

    if (estaGirado)
      elemento.classList.remove('rotado')
    else
      elemento.classList.add('rotado')

  }

  /* Esta es una función personalizada para hacer los request más facilmente con JS vanilla */
  function maracFetch(url, request, callback) {

    fetch(url, request).then(function(response) {
      if (response.ok)
        return response.json();
      else
        return Promise.reject(response);

    }).then(function(data) {
      callback(data);
    });

  }


  /* fecha viene un string en formato "2022-11-25" */
  function formatearFechaAEspañol(fecha) {
    var date = new Date(fecha)
    var options = {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    };

    var formated = date.toLocaleDateString('es-ES', options);

    return formated;

  }


  /*
    No trasladar este codigo a Backend, algunas versiones de node no tienen el replaceAll, para eso se usa el replace con la regexp /g
  */
  function hidrateHtmlString(html_string, object) {

    for (let field_name in object) {
      html_string = html_string.replaceAll("[" + field_name + "]", object[field_name]);
    }
    return html_string;

  }




  /* se le manda el id de un formulario y retorna un objeto de datos asi, segun los name
  {
    nombre:"diego",
    apellidos:"vigo"
  }
  */
  function getObjetoDatosSegunForm(form_id) {
    var formulario_archivos = document.getElementById(form_id);
    var formData = new FormData(formulario_archivos);

    var data_form = {};
    for (const pair of formData.entries()) {
      var key = pair[0];
      var value = pair[1];
      data_form[key] = value;
    }

    console.log("data_form", data_form);
    return data_form;
  }




  function verificarExistenciaElementoYTirarError(element_id) {
    var el = document.getElementById(element_id);
    if (el == null) {
      throw new Error("No existe ningun elemento con el id '" + element_id + "'");
    }
  }



  // metodo abreviacion del document.getElementById().value
  function getVal(id) {
    verificarExistenciaElementoYTirarError(id);
    return document.getElementById(id).value;
  }
  // metodo abreviacion del document.getElementById().value
  function setVal(id, new_value) {
    verificarExistenciaElementoYTirarError(id);
    document.getElementById(id).value = new_value;
  }


  //metodo para select2 normal no multiple
  function getValSelect2(id) {
    verificarExistenciaElementoYTirarError(id);
    return $("#" + id).val();
  }

  // metodo alternativo al $("#id").val() porque ese cuando no hay nada retorna null y necesito que retorne un array vacio
  function getSecureArraySelect2(id) {
    verificarExistenciaElementoYTirarError(id);
    let value = $("#" + id).val();
    if (value == null) {
      return [];
    }
    return value;
  }

  //retorna un string con los values seleccionados.
  function getSecureStringValSelect2(id) {
    verificarExistenciaElementoYTirarError(id);
    let arr = getSecureArraySelect2(id);
    if (arr.length == 0) {
      return "";
    }
    return arr.join(",");
  }


  // es como el metodo split pero si la cadena origen está vacia, retorna un array vacio (la original retorna un elemento vacio xd)
  function secureSplit(str) {
    if (str == "") {
      return [];
    }
    return str.split(",");
  }

  function quitarElRojoSelect2(id) {
    verificarExistenciaElementoYTirarError(id);
    const element = document.getElementById(id);
    const parent = element.parentElement;
    parent.classList.remove("form-control-undefined");
  }

  function limpiarContenidoElemento(id) {
    verificarExistenciaElementoYTirarError(id);
    const element = document.getElementById(id);
    element.innerHTML = "";
  }



  function esPlacaValida(placa) {
    // Verificar que la placa tenga el formato correcto usando una expresión regular
    const formatoPlaca = /^[A-Z0-9]{3}-[A-Z0-9]{3}$/;

    // Si la placa es undefined o null, retornar false
    if (!placa) {
      return false;
    }

    // Convertir la placa a mayúsculas para estandarizar
    const placaUpperCase = placa.toUpperCase();

    // Verificar si cumple con el patrón
    return formatoPlaca.test(placaUpperCase);
  }
</script>
