@extends('Layout.Plantilla')

@section('titulo')
  Listar Parámetros del sistema
@endsection

@section('contenido')
  <style>
    .parametro_descripcion {
      max-width: 200px;
    }
  </style>
  <div class="card-body">

    <div class="well">
      <H3 style="text-align: center;">
        <strong>
          Parametros del sistema

        </strong>
      </H3>
    </div>
    <div class="row">



      <div class="col-md-2">
        <button type="button" id="" class="btn btn-primary m-2" onclick="limpiarModalparametro()" data-toggle="modal"
          data-target="#ModalParametro">
          Nuevo
          <i class="fas fa-plus"></i>
        </button>

      </div>


      <div class="col-md-10">

      </div>
    </div>
    @include('Layout.MensajeEmergenteDatos')

    <div id="contenedor" class="">
      @include('ParametroSistema.inv_ListarParametros')
    </div>



  </div>





  <div class="modal fade" id="ModalParametro" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">


        <div class="modal-header">
          <h5 class="modal-title" id="TituloModalParametro">Nuevo Parametro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


          <form id="frmParametro" name="frmParametro" action="" method="POST">
            <input type="{{ App\Utils\Configuracion::getInputTextOHidden() }}" name="codParametro" id="codParametro" value="0">

            @csrf

            <div class="row">

              <div class="col-12">
                <label for="">Tipo Parámetro</label>
                <select class="form-control" name="codTipoParametro" id="codTipoParametro" onchange="cambioTipoParametro(this.value)">
                  @foreach ($listaTipoParametro as $tipoParametro)
                    <option value="{{ $tipoParametro->getId() }}">
                      {{ $tipoParametro->nombre }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-12">
                <label for="">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre">


              </div>

              <div class="col-12">
                <label for="">Módulo</label>
                <input type="text" class="form-control" name="modulo" id="modulo">
              </div>

              <div class="col-12">
                <label for="">Valor</label>



                <input type="text" class="form-control" id="input_value_string" value="" oninput="updateValueParameter(this.value)">
                <input type="number" class="hidden form-control" id="input_value_int" value=""
                  oninput="updateValueParameter(this.value)">
                <textarea type="text" class="hidden form-control" id="input_value_large_string" oninput="updateValueParameter(this.value)"></textarea>

                <div class="hidden" id="input_value_boolean">
                  <x-toggle-button name="mostrarEnListas" :initialValue="0" onChangeFunctionName="updateValueParameterFromToggle"
                    setExternalValueFunctionName="setToggleValue" />
                </div>

                {{-- Este input tiene el valor siempre, pero está como hidden --}}
                <div class="d-flex m-1">

                  <input type="text" class="ml-auto mostrador-valor" name="valor" id="valor" readonly>

                </div>

              </div>


              <div class="col-12">
                <label for="">Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcion" cols="" rows="5"></textarea>

              </div>



              <div class="col">
                <label for="">Creacion</label>
                <input type="text" class="form-control" name="fechaHoraCreacion" id="fechaHoraCreacion" readonly>
              </div>
              <div class="w-100"></div>
              <div class="col">
                <label for="">Ultima Edición</label>
                <input type="text" class="form-control" name="fechaHoraActualizacion" id="fechaHoraActualizacion" readonly>
              </div>
              <div class="w-100"></div>
              <div class="col">
                <label for="">Fecha baja</label>
                <input type="text" class="form-control" name="fechaHoraBaja" id="fechaHoraBaja" readonly>
              </div>

            </div>

          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Salir
          </button>

          <button type="button" class="m-1 btn btn-primary" onclick="clickGuardarNuevoParametro()">
            Guardar <i class="fas fa-save"></i>
          </button>
        </div>

      </div>
    </div>
  </div>
@endsection

@section('script')
  @include('Layout.ValidatorJS')
  <script>
    var listaParametros = [];

    var listaTipoParametros = @json($listaTipoParametro);
    var tipo_parametro = {};

    $(document).ready(function() {
      actualizarTabla();
    });


    function actualizarTabla() {
      ruta = "{{ route('ParametroSistema.JSON_GetParametros') }}";

      $.get(ruta, function(dataRecibida) {
        listaParametros = JSON.parse(dataRecibida);
      });
      invocarHtmlEnID("{{ route('ParametroSistema.inv_listado') }}", 'contenedor')
    }

    const InputValor = document.getElementById('valor');

    function updateValueParameterFromToggle(value) {
      if (value == 1)
        InputValor.value = "true";
      else
        InputValor.value = "false";
    }

    function updateValueParameter(value) {
      InputValor.value = value;
    }

    const InputValueString = document.getElementById('input_value_string');
    const InputValueInt = document.getElementById('input_value_int');
    const InputValueLargeString = document.getElementById('input_value_large_string');

    function updateShowedValueParameter(value) {
      if (tipo_parametro.nombre == "boolean") {
        if (value == "true")
          setToggleValue(true);
        else
          setToggleValue(false)
      } else {
        document.getElementById('input_value_' + tipo_parametro.nombre).value = value;

      }



    }


    function cambioTipoParametro(nuevoCodTipoParametro) {
      tipo_parametro = listaTipoParametros.find(e => e.codTipoParametro == nuevoCodTipoParametro);

      document.getElementById('input_value_string').classList.add('hidden');
      document.getElementById('input_value_int').classList.add('hidden');
      document.getElementById('input_value_large_string').classList.add('hidden');
      document.getElementById('input_value_boolean').classList.add('hidden');

      document.getElementById('input_value_' + tipo_parametro.nombre).classList.remove('hidden');

      /* Valor por defecto */
      if (tipo_parametro.nombre == "boolean")
        setToggleValue(false);
      else
        InputValor.value = "";

    }


    function clickGuardarNuevoParametro() {

      msjError = validarFormParametro();
      if (msjError != "") {
        alerta(msjError);
        return;
      }

      nombre = document.getElementById('nombre').value;
      modulo = document.getElementById('modulo').value;

      descripcion = document.getElementById('descripcion').value;
      valor = document.getElementById('valor').value;
      codTipoParametro = document.getElementById('codTipoParametro').value;
      csrf = document.getElementsByName('_token')[0].value;

      codParametro = document.getElementById('codParametro').value;

      datosAEnviar = {
        _token: csrf,
        nombre: nombre,
        descripcion: descripcion,
        valor: valor,
        codTipoParametro: codTipoParametro,
        codParametro: codParametro,
        modulo: modulo
      };

      ruta = "{{ route('ParametroSistema.guardarYActualizar') }}";

      $.post(ruta, datosAEnviar, function(dataRecibida) {
        console.log('DATA RECIBIDA:');
        console.log(dataRecibida);

        objetoRespuesta = JSON.parse(dataRecibida);
        alertaMensaje(objetoRespuesta.titulo, objetoRespuesta.mensaje, objetoRespuesta.tipoWarning);

        actualizarTabla();

      });

      cerrarModal('ModalParametro');
      limpiarModalparametro();
    }


    function validarFormParametro() {

      msjError = "";
      msjError = validarTamañoMaximoYNulidad(msjError, 'nombre', 200, 'Nombre');
      msjError = validarTamañoMaximoYNulidad(msjError, 'descripcion', 200, 'Descripción');
      msjError = validarTamañoMaximoYNulidad(msjError, 'valor', 1000, 'Valor');
      msjError = validarTamañoMaximoYNulidad(msjError, 'modulo', 200, 'modulo');

      return msjError;
    }


    function clickEditarParametro(codParametro) {
      limpiarModalparametro();


      parametro = listaParametros.find(element => element.codParametro == codParametro);
      cambioTipoParametro(parametro.codTipoParametro);

      document.getElementById('descripcion').value = parametro.descripcion;
      document.getElementById('nombre').value = parametro.nombre;
      document.getElementById('valor').value = parametro.valor;
      updateShowedValueParameter(parametro.valor);
      document.getElementById('fechaHoraCreacion').value = parametro.fechaHoraCreacion;
      document.getElementById('fechaHoraActualizacion').value = parametro.fechaHoraActualizacion;
      document.getElementById('fechaHoraBaja').value = parametro.fechaHoraBaja;
      document.getElementById('codTipoParametro').value = parametro.codTipoParametro;

      document.getElementById('modulo').value = parametro.modulo;




      document.getElementById('codParametro').value = parametro.codParametro;

    }


    function limpiarModalparametro() {


      document.getElementById('descripcion').value = "";
      document.getElementById('nombre').value = "";
      document.getElementById('valor').value = "";
      document.getElementById('fechaHoraCreacion').value = "";
      document.getElementById('fechaHoraActualizacion').value = "";
      document.getElementById('fechaHoraBaja').value = "";
      document.getElementById('codTipoParametro').value = "";
      document.getElementById('modulo').value = "";


      document.getElementById('codParametro').value = "0"

      InputValueString.value = "";
      InputValueInt.value = "";
      InputValueLargeString.value = "";
      setToggleValue(false);


    }


    codParametroAEliminar = "0";

    function clickEliminarParametro(codParametro) {

      console.log('Se eliminará el ' + codParametro);
      para = listaParametros.find(element => element.codParametro == codParametro);

      codParametroAEliminar = codParametro;

      confirmarConMensaje('Confirmación', '¿Seguro de eliminar el parámetro "' + para.nombre + '" ?', 'warning',
      ejecutarEliminacionParametro);

    }

    function ejecutarEliminacionParametro() {

      ruta = "/ParametroSistema/darDeBaja/" + codParametroAEliminar;

      $.get(ruta, function(dataRecibida) {
        console.log('DATA RECIBIDA:');
        console.log(dataRecibida);

        objetoRespuesta = JSON.parse(dataRecibida);
        alertaMensaje(objetoRespuesta.titulo, objetoRespuesta.mensaje, objetoRespuesta.tipoWarning);
        actualizarTabla();
      });
    }
  </script>
  <style>
    .mostrador-valor {
      background-color: #e3e3e3;
      border: 0px;
      border-radius: 5px;
      font-size: 7pt;
      min-width: 180px;
      outline: 0;
    }
  </style>
@endsection
