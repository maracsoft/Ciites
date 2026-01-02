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


  function validarPuntoDecimal(msjError, id, nombreReferencial) {
    mensaje = "";

    cantidad = document.getElementById(id).value;
    var amount_parts = cantidad.split(',');
    console.log('enhorabuean');
    console.log(amount_parts);
    if (amount_parts.length > 1) {
      ponerEnRojo(id);
      mensaje = "En el campo '" + nombreReferencial +
        "' no se permiten comas, solo puntos para separar la parte decimal de la entera."
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



  function limpiarEstilosFormulario(formId) {
    const form = document.getElementById(formId);
    if (!form) {
      throw new Error("No se encontró el formulario con ID: " + formId);
    }

    const childrens = form.querySelectorAll('.form-control');

    childrens.forEach(child => {
      child.classList.remove('form-control-undefined');
    });
  }


  function quitarElRojo(id) {
    const element = document.getElementById(id);
    if (element) {
      element.classList.remove("form-control-undefined");
    } else {
      throw new Error("No existe ningun elemento con id " + id);
    }

  }


  function ponerEnRojo(id) {
    const elem = document.getElementById(id);
    listaDeClases = elem.classList

    if (!elem.classList.contains('form-control-undefined')) //si no está ya en ROJO
    {
      elem.classList.add("form-control-undefined");
    }
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
        mensaje = 'No se puede ingresar mas de ' + cantidadMax + ' Items. La cantidad actual es de ' + cantidad +
        ' Items';
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
    verificarExistenciaElementoYTirarError(id);

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



  function validarValorMinimo(msjError, id, valor_minimo, nombreReferencial) {
    mensaje = "";

    cantidad = document.getElementById(id).value;
    cantidad = parseFloat(cantidad);

    if (cantidad < valor_minimo) {
      ponerEnRojo(id);
      mensaje = "El valor del campo '" + nombreReferencial + "' debe ser mayor que " + valor_minimo + ".";
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }


  function validarValorMaximo(msjError, id, valor_maximo, nombreReferencial) {
    mensaje = "";

    cantidad = document.getElementById(id).value;
    cantidad = parseFloat(cantidad);

    if (cantidad > valor_maximo) {
      ponerEnRojo(id);
      mensaje = "El valor del campo '" + nombreReferencial + "' debe ser menor que " + valor_maximo + ".";
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }


  function validarValorRangoNumeros(msjError, id, valor_minimo, valor_maximo, nombreReferencial) {
    mensaje = "";

    cantidad = document.getElementById(id).value;
    cantidad = parseFloat(cantidad);

    if (valor_maximo < cantidad || cantidad < valor_minimo) {
      ponerEnRojo(id);
      mensaje = "El valor del campo '" + nombreReferencial + "' debe ser menor que " + valor_maximo + " y mayor que " +
        valor_minimo + ".";
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }



  function validarNoNegatividad(msjError, id, nombreReferencial) {
    verificarExistenciaElementoYTirarError(id);

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
    verificarExistenciaElementoYTirarError(id);

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
    verificarExistenciaElementoYTirarError(id);

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
    verificarExistenciaElementoYTirarError(id);

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
    verificarExistenciaElementoYTirarError(id);

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


  function validarEmail(msjError, id, nombreReferencial) {
    mensaje = "";

    contenido = document.getElementById(id).value;

    if (contenido != "") {
      if (!validateEmail(contenido)) {
        ponerEnRojo(id);
        mensaje = "El email " + nombreReferencial + " es inválido";
      }

    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }

  const validateEmail = (email) => {
    return email.match(
      /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
  };


  function validarTamañoMinimo(msjError, id, tamañoMinimo, nombreReferencial) {
    verificarExistenciaElementoYTirarError(id);

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
    verificarExistenciaElementoYTirarError(id);
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


  /* Validar combo box (select) para que se haya escogido uno  */
  function validarSelect2Multiple(msjError, id, nombreReferencial) {
    verificarExistenciaElementoYTirarError(id);
    var mensaje = "";

    var value = $('#' + id).val();
    if (!value) {
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
      mensaje = "El " + nombreReferencial + " debe coincidir con el código presupuestal del proyecto [" +
        codPresupProyecto + "]. ";
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




  /* Se le pasa un vector de Strings, cada elemento es una id de un radio button */
  function validarGroupButtonConName(msjError, name, nombreReferencial) {
    mensaje = "";

    let selected_element = document.querySelector('input[name="' + name + '"]:checked')
    if (!selected_element)
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


  /* le entran 2 fechas en formato dd/mm/yyyy y sale boolean
  sale true si la fecha 1 es menor que la 2
  */
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

  async function invocarHtmlEnID_async(ruta, idElemento) {

    var data = await $.get(ruta).promise();
    console.log('Se ha actualizado el objeto de id ' + idElemento + ' con contenido invocado de  ' + ruta);
    var objeto = document.getElementById(idElemento);
    objeto.innerHTML = data;

    return data;
  }

  function parseBytesToMb(bytes) {
    return bytes / 1024 / 1024;
  }



  /* Valida existencia de archivo */
  function validarNulidadArchivo(msjError, id, nombreReferencial, es_multiple) {
    verificarExistenciaElementoYTirarError(id);

    var mensaje = "";

    const FileElement = document.getElementById(id);
    if (FileElement.files.length == 0) {
      ponerEnRojo(id);

      if (es_multiple) {
        mensaje = "Se debe añadir los archivos \"" + nombreReferencial + "\".";
      } else {
        mensaje = "Se debe añadir el archivo \"" + nombreReferencial + "\".";
      }
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }


  /* valida peso de los archivos */
  function validarPesoArchivos(msjError, id, tamaño_maximo_mb, nombreReferencial, es_multiple) {
    verificarExistenciaElementoYTirarError(id);

    var mensaje = "";

    const FileElement = document.getElementById(id);
    var files = FileElement.files;
    for (let index = 0; index < files.length; index++) {
      const file_element = files[index];
      //console.log("file_element", file_element);

      var size_bytes = file_element.size;
      var size_kb = size_bytes / 1024;
      var size_mb = size_kb / 1024;

      if (size_mb > tamaño_maximo_mb) {
        if (es_multiple) {
          mensaje = "El tamaño máximo permitido para los archivos \"" + nombreReferencial + "\" es de " +
            tamaño_maximo_mb + " MB.";
        } else {
          mensaje = "El tamaño máximo permitido para el archivo \"" + nombreReferencial + "\" es de " +
            tamaño_maximo_mb + " MB.";
        }
      }

    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }


  /* valida peso de los archivos */
  function validarPesoArchivosConName(msjError, name, tamaño_maximo_mb, nombreReferencial, es_multiple) {

    var id = verificarExistenciaNameElementoYTirarError(name);
    var mensaje = validarPesoArchivos(msjError, id, tamaño_maximo_mb, nombreReferencial, es_multiple);

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }

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


  /* entra 2022-11-25 sale 25/11/2022 */
  function formatearFechaParaVistas(fecha_sql) {

    var dateParts1 = fecha_sql.split("-");
    var año = dateParts1[0];
    var mes = dateParts1[1];
    var dia = dateParts1[2];

    return dia + "/" + mes + "/" + año;
  }

  function formatearFechaParaSql(fecha_front) {

    var dateParts1 = fecha_front.split("/");
    var año = dateParts1[2];
    var mes = dateParts1[1];
    var dia = dateParts1[0];

    return año + "-" + mes + "-" + dia;
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


  /*
    ruta : la ruta a la que se hace el post multipart
    data : datos adicionales que se mandan aparte del file
    file_form_id : id del formulario que contiene al file input, siempre debe existir y tener el enctype="multipart/form-data"

  */
  function sendPostFileRequest(ruta, data, file_form_id, onSuccessFunction) {
    var formulario_archivos = document.getElementById(file_form_id);
    var formData = new FormData(formulario_archivos);

    for (const key in data) {
      var value = data[key];
      formData.append(key, value);
    }

    $.ajax({
      type: "POST",
      enctype: 'multipart/form-data',
      url: ruta,
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      timeout: 600000,
      success: onSuccessFunction
    });


  }



  function async_sendPostWithFiles(ruta, data, name, files) {

    let formData = new FormData();

    for (let index = 0; index < files.length; index++) {
      const file = files[index];
      formData.append(name, file, file.name)
    }


    for (const key in data) {
      let value = data[key];
      formData.append(key, value);
    }

    return new Promise((resolve, reject) => {
      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: ruta,
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function(data_response) {
          resolve(data_response)
        },
        error: function(error) {
          reject(error)
        },
      })
    })

  }


  function parseArrayElementsToString(array) {
    var new_array = [];
    for (let index = 0; index < array.length; index++) {
      const element = array[index];
      new_array.push(element.toString());
    }
    return new_array;
  }



  //deja pasar la validacion correctamente si es una cadena vacía
  function validarCantidadPalabrasMinimas(msjError, id, cantidad_palabras, nombreReferencial) {
    mensaje = "";

    contenido = document.getElementById(id).value;
    if (contenido != "") {
      var cant = contenido.split(" ").length;
      if (cant < cantidad_palabras) {
        ponerEnRojo(id);
        mensaje = "El campo '" + nombreReferencial + "' debe tener al menos " +
          cantidad_palabras + " palabras.";
      }
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;


  }

  const PlantillaOptionSelectGenerico = "<option value='[Id]'>[Label]</option>"


  /*
  llena las opciones de un select normal

  	select_id : el id del select
  	options_array : el array con las opciones a iterar
  	value_fieldname : el nombre del campo que será puesto como value
  	label_fieldname : el nombre del campo que será puesto como label (lo que se imprimirá)
  	placeholder : el placeholder (primera opcion que sale)
  	valor_seleccion_nula : el valor de la primera opcion que sale
  */
  function hidrateSelect(select_id, options_array, value_fieldname, label_fieldname, placeholder, valor_seleccion_nula, añadir_fila_vacia) {

    verificarExistenciaElementoYTirarError(select_id);
    const SelectAHidratar = document.getElementById(select_id);


    var html = "";
    if (añadir_fila_vacia)
      html += "<option disabled selected value='" + valor_seleccion_nula + "'> - " + placeholder + " - </option>";

    for (let index = 0; index < options_array.length; index++) {
      const option_ = options_array[index];

      var hidr = {
        Label: option_[label_fieldname],
        Id: option_[value_fieldname]
      }

      html += hidrateHtmlString(PlantillaOptionSelectGenerico, hidr);
    }

    SelectAHidratar.innerHTML = html;
  }

  /* Se llena un select con un solo elemento que es un mensaje para cuando el padre no se seleccionó */
  function llenarSelectNulo(select_id, placeholder, valor_seleccion_nula) {
    const SelectAHidratar = document.getElementById(select_id);
    SelectAHidratar.innerHTML = "<option value='" + valor_seleccion_nula + "'>" + placeholder + "</option>";;
  }

  function verificarExistenciaElementoYTirarError(element_id) {
    var el = document.getElementById(element_id);
    if (el == null) {
      throw new Error("No existe ningun elemento con el id '" + element_id + "'");
    }
  }

  function getFechasFuturas(cantidad_años) {

    var fechas = [];

    var cantidad_dias = 365 * cantidad_años;

    var hoy = new Date();
    for (let index = 0; index < cantidad_dias; index++) {
      var timestamp = hoy.setDate(hoy.getDate() + 1);
      var new_date = new Date(timestamp);

      const yyyy = new_date.getFullYear();
      let mm = new_date.getMonth() + 1; // Months start at 0!
      let dd = new_date.getDate();

      if (dd < 10) dd = '0' + dd;
      if (mm < 10) mm = '0' + mm;

      const formatted_day = dd + '/' + mm + '/' + yyyy;
      fechas.push(formatted_day);
    }

    return fechas;
  }

  function getFechasPasadas(cantidad_años) {

    var fechas = [];

    var cantidad_dias = 365 * cantidad_años;

    var hoy = new Date();
    for (let index = 0; index < cantidad_dias; index++) {
      var timestamp = hoy.setDate(hoy.getDate() - 1);
      var new_date = new Date(timestamp);

      const yyyy = new_date.getFullYear();
      let mm = new_date.getMonth() + 1; // Months start at 0!
      let dd = new_date.getDate();

      if (dd < 10) dd = '0' + dd;
      if (mm < 10) mm = '0' + mm;

      const formatted_day = dd + '/' + mm + '/' + yyyy;
      fechas.push(formatted_day);
    }

    return fechas;
  }

  const GenerateUniqueId = function() {
    return Date.now().toString(36) + Math.random().toString(36).substr(2);
  }

  function verificarExistenciaElemento(element_id) {
    return document.getElementById(element_id) != null;
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

  //retorna un string con los values seleccionados unidos por comas
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

  const FormatearMesAEspañolParaMorris = function(año_mes) {
    let IndexToMonth = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dic"];
    let month = IndexToMonth[año_mes.getMonth()];
    let year = año_mes.getFullYear();
    return month + '-' + year;
  }

  const FormatearFechaAEspañolParaEjeX = function(date_object) {

    let resp = date_object.toLocaleDateString();


    return resp;
  }

  const FormateoFechaEspañolParaMorrisHover = function(timestamp) {

    return new Date(timestamp).toLocaleDateString();
  }

  const NombresMeses_ = [
    "Mes no valido",
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre"
  ]
  const getNombreMes = (codMes) => {
    return NombresMeses_[codMes];
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


  /* ambas entran en formato 15:00:33 */
  function esHoraFinMayor(hora_inicio, hora_fin) {
    const [h1, m1, s1] = hora_inicio.split(':').map(Number);
    const [h2, m2, s2] = hora_fin.split(':').map(Number);

    const segundos_inicio = h1 * 3600 + m1 * 60 + s1;
    const segundos_fin = h2 * 3600 + m2 * 60 + s2;

    return segundos_fin > segundos_inicio;
  }





  /**
   * Genera un UUID versión 4 (UUIDv4).
   * El formato es: xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx
   * Donde:
   * - x es cualquier dígito hexadecimal (0-9 o a-f)
   * - y es 8, 9, a o b (según el estándar UUIDv4)
   *
   * @returns {string} UUID generado
   */
  function generarUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      const r = Math.random() * 16 | 0;
      const v = c === 'x' ? r : (r & 0x3 | 0x8); // y = 8, 9, a o b
      return v.toString(16);
    });
  }

  function generarMaracUUID() {
    return 'xxxxxxxxxxxx4xxxyxxxxxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      const r = Math.random() * 16 | 0;
      const v = c === 'x' ? r : (r & 0x3 | 0x8); // y = 8, 9, a o b
      return v.toString(16);
    });
  }

  function lanzarEventoChange(id) {
    verificarExistenciaElementoYTirarError(id);

    const elem = document.getElementById(id);

    elem.dispatchEvent(new Event('change'));

  }

  function lanzarEventoInput(id) {
    verificarExistenciaElementoYTirarError(id);

    const elem = document.getElementById(id);

    elem.dispatchEvent(new Event('input'));

  }




  /**
   * Valida un valor en base a un conjunto de reglas al estilo Laravel.
   *
   * @param {*} valor - El valor a validar (puede ser string, number, array, file simulado con {size}).
   * @param {string} reglas_validacion_string - Cadena con las reglas, separadas por "|".
   *        Ejemplo: "required|string|min:3"
   *
   * @returns {string[]} - Array de errores encontrados. Si no hay, retorna [].
   */
  function validar_valor(valor, reglas_validacion_string, label) {
    const errores = [];

    // Separar y limpiar reglas
    const reglas = reglas_validacion_string
      .split("|")
      .map(r => r.trim())
      .filter(r => r.length > 0);

    // Detectar tipo declarado en las reglas
    const esString = reglas.includes("string");
    const esNumeric = reglas.includes("numeric") || reglas.includes("integer");
    const esArray = reglas.includes("array");


    for (let regla of reglas) {
      let [nombreRegla, parametro = null] = regla.split(":");
      parametro = parametro !== null ? parseInt(parametro, 10) : null;

      switch (nombreRegla) {
        case "required":
          if (valor === null || valor === undefined || valor === "") {
            errores.push(`El campo "${label}" es obligatorio.`);
          }
          break;

        case "string":
          if (valor !== null && valor !== undefined && typeof valor !== "string") {
            errores.push(`El campo "${label}" debe ser una cadena de texto.`);
          }
          break;

        case `numeric`:
          if (valor === `` || isNaN(Number(valor))) {
            errores.push(`El campo "${label}" debe ser un número.`);
          }
          break;

        case `integer`:
          if (!Number.isInteger(Number(valor))) {
            errores.push(`El campo "${label}" debe ser un número entero.`);
          }
          break;

        case `array`:
          if (!Array.isArray(valor)) {
            errores.push(`El campo "${label}" debe ser un array.`);
          }
          break;

        case `file`:
          if (!valor || typeof valor !== `object` || !(`size` in valor)) {
            errores.push(`El campo "${label}" debe ser un archivo con propiedad size en bytes.`);
          }
          break;

        case `min`:
          if (parametro !== null && valor !== null && valor !== undefined) {
            if (esString && String(valor).length < parametro) {
              errores.push(`El campo "${label}" debe tener al menos ${parametro} caracteres.`);
            } else if (esNumeric && Number(valor) < parametro) {
              errores.push(`El campo "${label}" debe ser mayor que ${parametro}.`);
            } else if (esArray && Array.isArray(valor) && valor.length < parametro) {
              errores.push(`El array "${label}" debe tener al menos ${parametro} elementos.`);
            }
          }
          break;

        case `size`:
          if (parametro !== null && valor !== null && valor !== undefined) {
            if (esString && String(valor).length != parametro) {
              errores.push(`El campo "${label}" debe tener ${parametro} caracteres.`);
            } else if (esArray && Array.isArray(valor) && valor.length == parametro) {
              errores.push(`El array "${label}" debe tener  ${parametro} elementos.`);
            }
          }
          break;

        case `digits`:
          if (parametro !== null && valor !== null && valor !== undefined) {
            if (String(valor).length != parametro) {
              errores.push(`El campo "${label}" debe tener ${parametro} digitos. (actualmente tiene ${String(valor).length})`);
            }
          }
          break;



        case `max`:
          if (parametro !== null && valor !== null && valor !== undefined) {
            if (esString && String(valor).length > parametro) {
              errores.push(
                `El campo "${label}" debe tener como máximo ${parametro} caracteres (actualmente tiene ${String(valor).length}).`);
            } else if (esNumeric && Number(valor) > parametro) {
              errores.push(`El valor "${label}" numérico debe ser menor que ${parametro}.`);
            } else if (esArray && Array.isArray(valor) && valor.length > parametro) {
              errores.push(`El array "${label}" no debe tener más de ${parametro} elementos. (actualmente tiene ${String(valor).length})`);
            }
          }
          break;

        case `email`:
          const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (valor && !regexEmail.test(String(valor))) {
            errores.push(`El campo "${label}" debe ser un correo electrónico válido.`);
          }
          break;

        case 'nullable':
          break;



        default:
          // ignoramos las reglas ya interpretadas como tipos
          if (![`string`, `numeric`, `integer`, `array`, `file`].includes(nombreRegla)) {
            errores.push(`Regla desconocida: ${nombreRegla}`);
          }
      }
    }

    return errores;
  }




  /*
  Valida el valor del input con las reglas de validacion que se le de como parametro
  */
  function validarValorInputSegunReglasValidacion(msjError, id, reglas_string, nombre_referencial) {
    verificarExistenciaElementoYTirarError(id);
    mensaje = "";

    if (!reglas_string) {
      return msjError;
    }

    const value = getVal(id);
    const errores = validar_valor(value, reglas_string);
    if (errores.length > 0) {
      ponerEnRojo(id);
      mensaje = "Error en " + nombre_referencial + ": " + errores[0];
    }


    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }



  /*
  en datos viene un objeto asi (con los valores)
  {
    nombre: "diego",
    apellidos: "vigo"
  }

  */
  function validar_datos(datos, reglas_validacion) {
    //iteramos el objeto de reglas
    let errores = [];
    Object.keys(reglas_validacion).forEach(function(column) {
      const reglas_validacion_str = reglas_validacion[column];
      const valor = datos[column];
      const errores_generados = validar_valor(valor, reglas_validacion_str, column);
      if (errores_generados.length > 0) {
        ponerEnRojo(column);
      }
      errores = errores.concat(errores_generados);
    });

    return errores;
  }


  /*
  Valida el input en elque se escriben las reglas de validación
  */
  function validarInputReglasValidacion(msjError, id) {
    verificarExistenciaElementoYTirarError(id);
    mensaje = "";

    const reglas_str = getVal(id);
    const error = validar_reglas_string(reglas_str);
    if (error != "") {
      ponerEnRojo(id);
      mensaje = "ERROR VALIDANDO LAS REGLAS DE VALIDACIÓN: " + error;
    }

    if (msjError != "") //significa que ya hay un error en el flujo de validaciones
      return msjError;
    else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
      return mensaje;
  }






  /**
   * Valida que la cadena de reglas sea correcta.
   *
   * @param {string} reglas_validacion_string - Cadena con las reglas, separadas por "|".
   * @returns {string} - "" si está bien, o mensaje de error si está mal.
   */
  function validar_reglas_string(reglas_validacion_string) {
    // Lista de reglas válidas y si requieren parámetro
    const reglasDisponibles = {
      "obligatorio": false,
      "longitud_maxima": true,
      "longitud_minima": true,
      "numero": false,
      "mayor_que": true,
      "menor_que": true,
      "correo": false,
      "positivo": false,
      "negativo": false,
      "entero": false
    };

    if (typeof reglas_validacion_string !== "string") {
      return "La definición de reglas debe ser un string.";
    }

    // Si viene vacío, es válido
    if (reglas_validacion_string === "") {
      return "";
    }

    // No se permiten espacios en ningún punto
    if (/\s/.test(reglas_validacion_string)) {
      return "La cadena de reglas no debe contener espacios.";
    }

    // Dividir y recorrer
    const reglas = reglas_validacion_string.split("|");

    for (let regla of reglas) {
      let [nombreRegla, parametro = null] = regla.split(":");

      if (!(nombreRegla in reglasDisponibles)) {
        return `Regla desconocida: ${nombreRegla}`;
      }

      // Validar parámetros requeridos
      if (reglasDisponibles[nombreRegla]) {
        if (parametro === null || parametro === "") {
          return `La regla "${nombreRegla}" requiere un parámetro.`;
        } else if (isNaN(Number(parametro))) {
          return `El parámetro de la regla "${nombreRegla}" debe ser numérico.`;
        }
      }
    }

    return ""; // todo correcto
  }



  /**
   * Convierte un texto a formato snake_case limpio.
   *
   * - Elimina tildes y caracteres con acentos.
   * - Reemplaza todos los símbolos y signos de puntuación por "_".
   * - Convierte todo a minúsculas.
   * - Reduce múltiples "_" consecutivos a uno solo.
   * - Elimina "_" al inicio o final del texto.
   *
   * @param {string} texto - Texto de entrada que se desea transformar.
   * @returns {string} Texto convertido a snake_case.
   */
  function codificar_texto(texto) {
    if (typeof texto !== "string") return "";

    // 1. Normalizar y quitar tildes (NFD separa base + diacrítico, luego removemos los diacríticos)
    let resultado = texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

    // 2. Reemplazar cualquier carácter que no sea alfanumérico por "_"
    resultado = resultado.replace(/[^a-zA-Z0-9]+/g, "_");

    // 3. Convertir a minúsculas
    resultado = resultado.toLowerCase();

    // 4. Eliminar guiones bajos repetidos
    resultado = resultado.replace(/_+/g, "_");

    // 5. Quitar "_" del inicio o final
    resultado = resultado.replace(/^_+|_+$/g, "");

    return resultado;
  }



  function esperar(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  }
</script>
