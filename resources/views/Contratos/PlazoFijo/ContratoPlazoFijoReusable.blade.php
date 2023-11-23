<div class="modal fade" id="ModalBorrador" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-2xl modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          Ver Borrador
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="semuestra">
          Se muestra de color
          <span class="campo_editable">
            AZUL
          </span>
          el contenido que varía en función a los datos que ingresó en el formulario.
        </div>
        <iframe id="iframe_borrador" src=""></iframe>

      </div>

    </div>
  </div>
</div>


<script>
  function validarForm() { //Retorna TRUE si es que todo esta OK y se puede hacer el submit
    msj = '';
    limpiarEstilos(['domicilio', 'puesto', 'tipo_adenda_financiera', 'nombre_financiera', 'duracion_convenio_numero',
      'duracion_convenio_unidad_temporal', 'nombre_contrato_locacion', 'fecha_inicio_prueba', 'fecha_fin_prueba',
      'fecha_inicio_contrato', 'fecha_fin_contrato', 'cantidad_dias_labor', 'cantidad_dias_descanso',
      'remuneracion_mensual', 'codMoneda', 'nombres', 'dni', 'apellidos', 'sexo', 'domicilio', 'provincia',
      'departamento'
    ]);

    /* Card 1 */
    msj = validarTamañoExacto(msj, 'dni', '8', 'DNI');
    msj = validarTamañoMaximoYNulidad(msj, 'nombres', 100, 'Nombres');
    msj = validarTamañoMaximoYNulidad(msj, 'apellidos', 100, 'Apellidos');
    msj = validarSelect(msj, 'sexo', '-1', 'Sexo');
    msj = validarTamañoMaximoYNulidad(msj, 'domicilio', 100, 'Domicilio');
    msj = validarTamañoMaximoYNulidad(msj, 'provincia', 100, 'Provincia');
    msj = validarTamañoMaximoYNulidad(msj, 'departamento', 100, 'epartamento');

    /* Card 2 */
    msj = validarSelect(msj, 'tipo_adenda_financiera', '-1', 'Tipo de Adenda financiera');
    msj = validarTamañoMaximoYNulidad(msj, 'nombre_contrato_locacion', 300, 'Nombre del Contrato de Locación');
    msj = validarPositividadYNulidad(msj, 'duracion_convenio_numero', 'Duración del convenio (Número)');
    msj = validarSelect(msj, 'duracion_convenio_unidad_temporal', '-1', 'Duración del Convenio (Unidad de Tiempo)');
    msj = validarTamañoMaximoYNulidad(msj, 'nombre_financiera', 100, 'Financiera');

    /* CARD 3 */

    msj = validarTamañoMaximoYNulidad(msj, 'puesto', 200, 'Nombre del Puesto');
    msj = validarTamañoMaximoYNulidad(msj, 'fecha_inicio_prueba', 500, 'Fecha de Inicio del periodo de Prueba');
    msj = validarTamañoMaximoYNulidad(msj, 'fecha_fin_prueba', 500, 'Fecha de Fin del periodo de Prueba');
    msj = validarTamañoMaximoYNulidad(msj, 'fecha_inicio_contrato', 500, 'Fecha de inicio del contrato');
    msj = validarTamañoMaximoYNulidad(msj, 'fecha_fin_contrato', 500, 'Fecha de fin del contrato');
    msj = validarPositividadYNulidad(msj, 'remuneracion_mensual', 'Remuneración Mensual');
    msj = validarSelect(msj, 'codMoneda', '-1', 'Moneda');
    msj = validarPositividadYNulidad(msj, 'cantidad_dias_labor', 'Cantida de días de labor');
    msj = validarPositividadYNulidad(msj, 'cantidad_dias_descanso', 'Cantidad de días de descanso');

    return msj;
  }

  function GenerarBorrador() {

    var msj = validarForm();
    if (msj != "") {
      alerta(msj)
      return;
    }

    var datosAEnviar = {
      _token: "{{ csrf_token() }}",

      domicilio: document.getElementById("domicilio").value,
      provincia: document.getElementById("provincia").value,
      departamento: document.getElementById("departamento").value,

      puesto: document.getElementById("puesto").value,
      tipo_adenda_financiera: document.getElementById("tipo_adenda_financiera").value,
      nombre_financiera: document.getElementById("nombre_financiera").value,
      duracion_convenio_numero: document.getElementById("duracion_convenio_numero").value,
      duracion_convenio_unidad_temporal: document.getElementById("duracion_convenio_unidad_temporal").value,
      nombre_contrato_locacion: document.getElementById("nombre_contrato_locacion").value,
      fecha_inicio_prueba: document.getElementById("fecha_inicio_prueba").value,
      fecha_fin_prueba: document.getElementById("fecha_fin_prueba").value,
      fecha_inicio_contrato: document.getElementById("fecha_inicio_contrato").value,
      fecha_fin_contrato: document.getElementById("fecha_fin_contrato").value,
      cantidad_dias_labor: document.getElementById("cantidad_dias_labor").value,
      cantidad_dias_descanso: document.getElementById("cantidad_dias_descanso").value,
      remuneracion_mensual: document.getElementById("remuneracion_mensual").value,
      codMoneda: document.getElementById("codMoneda").value,
      nombres: document.getElementById("nombres").value,
      dni: document.getElementById("dni").value,
      apellidos: document.getElementById("apellidos").value,
      sexo: document.getElementById("sexo").value,
      domicilio: document.getElementById("domicilio").value,

    };

    ruta = "{{ route('ContratosPlazo.GenerarBorrador') }}";
    $(".loader").show();

    $.post(ruta, datosAEnviar, function(dataRecibida) {
      $(".loader").hide();

      ModalBorrador.show()
      objetoRespuesta = JSON.parse(dataRecibida);

      var filename = objetoRespuesta.datos
      iframe_borrador.src = "/Contratos/Borradores/Ver/" + filename;
    });

  }



  /* llama a mi api que se conecta  con la api de la sunat
      si encuentra, llena con los datos que encontró
      si no tira mensaje de error
  */
  function consultarPorDNI() {

    msjError = "";

    msjError = validarTamañoExacto(msjError, 'dni', 8, 'DNI');
    msjError = validarNulidad(msjError, 'dni', 'DNI');

    if (msjError != "") {
      alerta(msjError);
      return;
    }

    $(".loader").show(); //para mostrar la pantalla de carga
    dni = document.getElementById('dni').value;

    $.get('/ConsultarAPISunat/dni/' + dni,
      function(data) {
        console.log("IMPRIMIENDO DATA como llegó:");

        data = JSON.parse(data);

        console.log(data);
        persona = data.datos;

        alertaMensaje(data.mensaje, data.titulo, data.tipoWarning);

        if (data.ok == 1) {
          document.getElementById('nombres').value = persona.nombres;
          document.getElementById('apellidos').value = persona.apellidoPaterno + " " + persona.apellidoMaterno;
        }

        $(".loader").fadeOut("slow");
      }
    );
  }
</script>
<style>
  #iframe_borrador {
    width: 100%;
    height: 700px;
  }

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
@include('CSS.RemoveInputNumberArrows')
