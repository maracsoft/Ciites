@extends('Layout.Plantilla')

@section('titulo')
  @if ($requerimiento->listaParaAprobar())
    Evaluar
  @else
    Ver
  @endif
  Requerimiento de Bienes y Servicios
@endsection

@section('contenido')
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <div>
    <p class="h1" style="text-align: center">
      @if ($requerimiento->listaParaContabilizar())
        Contabilizar
      @else
        Ver
      @endif
      Requerimiento de Bienes y Servicios

    </p>

  </div>

  @include('Layout.MensajeEmergenteDatos')



  @include('RequerimientoBS.Plantillas.SubPlantillaVerReqSuperior')
  {{--
      Esta vista no importa la @include('RequerimientoBS.Plantillas.PlantillaVerRequerimiento') porque tiene que importar el  Contador_DescargarEliminarArchivosEmp pq debe eliminar archivos de emp
    --}}

  <div class="row" id="" name="">
    <div class="col-12 col-md-4" style="">

      @if ($requerimiento->verificarEstado('Atendida'))
        @include('RequerimientoBS.Plantillas.Desplegables.Contador_DescargarEliminarArchivosEmp')
      @else
        @include('RequerimientoBS.Plantillas.Desplegables.DescargarArchivosEmp')
      @endif


    </div>
    @if ($requerimiento->tieneArchivosAdmin())
      <div class="col-12 col-md-4">
        @include('RequerimientoBS.Plantillas.Desplegables.DescargarArchivosAdm')
      </div>
    @endif
    <div class="col-12 col-md-4">
      <a href="{{ route('RequerimientoBS.exportarPDF', $requerimiento->codRequerimiento) }}" class="btn btn-primary" title="Descargar PDF">
        Descargar
        <i class="fas fa-file-download"></i>
      </a>
      <a target="pdf_reposicion_{{ $requerimiento->codRequerimiento }}"
        href="{{ route('RequerimientoBS.verPDF', $requerimiento->codRequerimiento) }}" class="btn btn-primary" title="Ver PDF">
        Ver
        <i class="fas fa-file-pdf"></i>
      </a>
    </div>

    @if ($requerimiento->verificarEstado('Atendida'))
      {{-- Si está lista para contabilizar --}}
      <div class="col-12 col-md-8">

      </div>
      <div class="col-12 col-md-4">

        <form method="POST" action = "{{ route('RequerimientoBS.Contador.Contabilizar') }}" id="frmContabilizarRequerimientoBS"
          name="frmContabilizarRequerimientoBS" enctype="multipart/form-data">
          @csrf
          <input type="{{ App\Utils\Configuracion::getInputTextOHidden() }}" name="codRequerimiento" id="codRequerimiento"
            value="{{ $requerimiento->codRequerimiento }}">

          {{-- Este es para subir todos los archivos x.x  --}}
          <div class="col fondoPlomoCircular p-2 mt-1" id="divEnteroArchivo">
            <div class="row">
              <div class="col ">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="tipoIngresoArchivos" id="ar_noSubir" value="0" checked>
                  <label class="form-check-label" for="ar_noSubir">
                    No subir archivos
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="tipoIngresoArchivos" id="ar_añadir" value="1">
                  <label class="form-check-label" for="ar_añadir">
                    Añadir Archivos
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="tipoIngresoArchivos" id="ar_sobrescribir" value="2">
                  <label class="form-check-label" for="ar_sobrescribir">
                    Sobrescribir archivos
                  </label>
                </div>


              </div>
              <div class="w-100"></div>
              <div class="col">
                <input type="{{ App\Utils\Configuracion::getInputTextOHidden() }}" name="nombresArchivos" id="nombresArchivos" value="">
                <input type="file" multiple class="btn btn-primary" name="filenames[]" id="filenames" style="display: none"
                  onchange="cambio()">
                <input type="hidden" name="nombreImgImagenEnvio" id="nombreImgImagenEnvio">
                <label class="label" for="filenames" style="font-size: 12pt;">
                  <div id="divFileImagenEnvio" class="hovered">
                    Subir archivos comprobantes (Del Colaborador)
                    <i class="fas fa-upload"></i>
                  </div>
                </label>

              </div>
            </div>


          </div>
        </form>

      </div>
    @endif


  </div>




  <div class="row px-4">

    <div class="col">
      @if ($requerimiento->sePuedeContabilizarFactura())
        <button id="botonContabilizarFactura" type="button" onclick="clickContabilizarFactura()" class="btn btn-success  ">
          Contabilizar Factura
          <i class="fas fa-file-invoice"></i>
        </button>
      @endif
    </div>

    <div class="col text-right">
      @if ($requerimiento->verificarEstado('Atendida'))
        <a id="botonContabilizarRequerimiento" href="#" class="btn btn-success" onclick="clickOnContabilizar()">
          <i class="fas fa-check"></i>
          Contabilizar
        </a>
      @endif
    </div>

  </div>

  <div class="row p-2">
    <div class="col">
      <a href="{{ route('RequerimientoBS.Contador.Listar') }}" class='btn btn-info'>
        <i class="fas fa-arrow-left"></i>
        Regresar al Menú
      </a>
    </div>
  </div>
@endsection

{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>



@include('Layout.EstilosPegados')

@section('script')
  <script>
    const justificacion = document.getElementById('justificacion');
    var codPresupProyecto = "{{ $requerimiento->getProyecto()->codigoPresupuestal }}";

    function clickOnContabilizar() {
      confirmarConMensaje("Confirmar", "¿Desea marcar como contabilizada el requerimiento?", "info", contabilizar);
    }

    function contabilizar() {

      document.frmContabilizarRequerimientoBS.submit();

    }

    function clickContabilizarFactura() {

      confirmarConMensaje("Confirmar", "¿Desea marcar como contabilizada la factura?", "info", ejecutarContabilizarFactura);

    }

    function ejecutarContabilizarFactura() {

      location.href = "{{ route('RequerimientoBS.Contador.contabilizarFactura', $requerimiento->codRequerimiento) }}";
    }

    //se ejecuta cada vez que escogewmos un file
    function cambio() {
      msjError = validarPesoArchivos();
      if (msjError != "") {
        alerta(msjError);
        return;
      }

      vectorNombresArchivos = [];
      listaArchivos = "";
      cantidadArchivos = document.getElementById('filenames').files.length;

      console.log('----- Cant archivos seleccionados:' + cantidadArchivos);
      for (let index = 0; index < cantidadArchivos; index++) {
        nombreAr = document.getElementById('filenames').files[index].name;
        console.log('Archivo ' + index + ': ' + nombreAr);
        listaArchivos = listaArchivos + ', ' + nombreAr;
        vectorNombresArchivos.push(nombreAr);

      }
      listaArchivos = listaArchivos.slice(1, listaArchivos.length);
      document.getElementById("divFileImagenEnvio").innerHTML = listaArchivos;
      //$('#nombresArchivos').val(listaArchivos);
      document.getElementById("nombresArchivos").value = JSON.stringify(vectorNombresArchivos); //input que se manda


    }

    function validarPesoArchivos() {
      cantidadArchivos = document.getElementById('filenames').files.length;

      msj = "";
      for (let index = 0; index < cantidadArchivos; index++) {
        var imgsize = document.getElementById('filenames').files[index].size;
        nombre = document.getElementById('filenames').files[index].name;
        if (imgsize > {{ App\Utils\Configuracion::pesoMaximoArchivoMB }} * 1000 * 1000) {
          msj = ('El archivo ' + nombre +
            ' supera los  {{ App\Utils\Configuracion::pesoMaximoArchivoMB }}Mb, porfavor ingrese uno más liviano o comprima.');
        }
      }

      if (cantidadArchivos == 0) {
        msj = "No se ha seleccionado ningún archivo.";
        document.getElementById("nombresArchivos").value = null;
        document.getElementById("divFileImagenEnvio").innerHTML = "Subir archivos comprobantes";
      }



      return msj;

    }
  </script>
@endsection
