@extends('Layout.Plantilla')

@section('titulo')
  Ver Contrato Plazo Fijo
@endsection




@section('contenido')
@include('Layout.Loader')

  <div class="p-2">
    <div class="page-title">
      Ver Contrato Plazo Fijo
    </div>
  </div>

  @include('Layout.MensajeEmergenteDatos')



  <div class="row">
    <div class="col-12 col-md-6">


      <div class="card">
        <div class="card-header">
          <b>
            Datos del contratado:
          </b>
        </div>
        <div class="card-body">
          <div class="row">

            <div class="col-12 col-md-4">
              <div class="d-flex  align-items-center ">
                <div class="label_movil_container flex-auto">
                  <input type="number" class="form-control" name="dni" id="dni" value="{{ $contrato->dni }}" readonly
                    placeholder="">
                  <label for="dni" class="label_movil">dni</label>

                </div>


              </div>


            </div>

            <div class="col-12 col-md-4">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="nombres" id="nombres" value="{{ $contrato->nombres }}" readonly
                  placeholder="">
                <label for="nombres" class="label_movil">nombres</label>
              </div>
            </div>


            <div class="col-12 col-md-4">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="apellidos" id="apellidos" readonly
                  value="{{ $contrato->apellidos }}" placeholder="">
                <label for="apellidos" class="label_movil">apellidos</label>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="label_movil_container">
                <input type="text" class="form-control" readonly value="{{ $contrato->getSexo() }}" placeholder="">
                <label for="sexo" class="label_movil">sexo</label>
              </div>
            </div>


            <div class="col-12 col-md-8">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="domicilio" id="domicilio" readonly
                  value="{{ $contrato->domicilio }}" placeholder="">
                <label for="domicilio" class="label_movil">domicilio</label>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="provincia" id="provincia" readonly
                  value="{{ $contrato->provincia }}" placeholder="">
                <label for="provincia" class="label_movil">Provincia</label>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="departamento" id="departamento" readonly
                  value="{{ $contrato->departamento }}" placeholder="">
                <label for="departamento" class="label_movil">departamento</label>
              </div>
            </div>



          </div>
        </div>
      </div>

    </div>
    <div class="col-12 col-md-6">
      <div class="card">
        <div class="card-header">
          <b>
            Datos del convenio/contrato/adenda con financiera:
          </b>
        </div>
        <div class="card-body">
          <div class="row">


            <div class="col-12 col-md-5">
              <div class="label_movil_container">
                <input type="text" class="form-control  text-uppercase" name="tipo_adenda_financiera" id="tipo_adenda_financiera" readonly
                    value="{{ $contrato->tipo_adenda_financiera }}" placeholder="">
                <label for="tipo_adenda_financiera " class="label_movil">Tipo de Documento</label>
              </div>
            </div>

            <div class="col-12 col-md-7">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="nombre_financiera" id="nombre_financiera" readonly
                  value="{{ $contrato->nombre_financiera }}" placeholder="">
                <label for="nombre_financiera" class="label_movil">Financiera</label>
              </div>
            </div>


            <div class="col-12 col-md-12">
              <div class="label_movil_container">
                <textarea type="text" class="form-control" name="nombre_proyecto" id="nombre_proyecto" readonly
                  placeholder="" rows="3">{{ $contrato->nombre_proyecto }}</textarea>
                <label for="nombre_proyecto" class="label_movil">Nombre proyecto</label>
              </div>
            </div>

            <div class="col-4 col-md-6">
              <div class="label_movil_container">
                <input type="text" class="form-control text-center" name="duracion_convenio_numero" readonly
                  value="{{ $contrato->duracion_convenio_numero }}" id="duracion_convenio_numero" placeholder="">
                <label for="duracion_convenio_numero" class="label_movil">DURACIÓN DEL PROYECTO</label>
              </div>
            </div>

            <div class="col-8 col-md-6">
              <div class="label_movil_container">
                <input type="text" class="form-control text-uppercase" readonly value="{{ $contrato->duracion_convenio_unidad_temporal}}" placeholder="">

                <label for="duracion_convenio_unidad_temporal" class="label_movil">Unidad Tiempo</label>
              </div>
            </div>




          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <b>
        Datos del Contrato
      </b>
    </div>
    <div class="card-body">

      <div class="row">

        <div class="col-12 col-md-2">
          <div class="label_movil_container">
            <input type="text" class="form-control" name="puesto" id="puesto" placeholder="" readonly
              value="{{ $contrato->puesto }}">
            <label for="puesto" class="label_movil">Puesto</label>
          </div>
        </div>




        <div class="col-12 col-md-2">
          <div class="label_movil_container">

            <input type="text" class="form-control text-center" autocomplete="off" name="fecha_inicio_contrato" readonly
              value="{{ $contrato->getFechaInicio() }}" id="fecha_inicio_contrato" placeholder="">
            <label for="fecha_inicio_contrato" class="label_movil">Fecha Inicio Contrato</label>


          </div>


        </div>
        <div class="col-12 col-md-2">

          <div class="label_movil_container">
            <input type="text" class="form-control text-center" readonly value="{{ $contrato->getFechaFin() }}" placeholder="">
            <label for="fecha_fin_contrato" class="label_movil">Fecha Fin Contrato</label>
          </div>

        </div>

        <div class="col-12 col-md-2">
          <div class="label_movil_container">
            <div class="">
              <input type="text" class="form-control text-center" readonly value="{{$contrato->getLabelTienePeriodoPrueba()}}" placeholder="">
              <label for="fecha_fin_prueba" class="label_movil">Activar Periodo de Prueba</label>

            </div>
          </div>
        </div>


        <div class="col-12 col-md-2">
          <div class="label_movil_container">
            @if ($contrato->tienePeriodoPrueba())
              <input type="text" class="form-control text-center" autocomplete="off" name="fecha_inicio_prueba" readonly
                value="{{ $contrato->getFechaInicioPrueba() }}" id="fecha_inicio_prueba" placeholder="">
              <label for="fecha_inicio_prueba" class="label_movil">Fecha Inicio Prueba</label>
            @endif

          </div>


        </div>

        <div class="col-12 col-md-2">
          <div class="label_movil_container">
            @if ($contrato->tienePeriodoPrueba())
              <input type="text" class="form-control text-center" autocomplete="off" name="fecha_fin_prueba" readonly
                value="{{ $contrato->getFechaFinPrueba() }}" id="fecha_fin_prueba" placeholder="">
              <label for="fecha_fin_prueba" class="label_movil">Fecha Fin Prueba</label>

            @endif
          </div>
        </div>





        <div class="col-12 col-md-2">

          <div class="label_movil_container">
            <input type="number" min="0" class="form-control text-right" name="remuneracion_mensual" readonly
              id="remuneracion_mensual" value="{{ $contrato->remuneracion_mensual }}" placeholder="">
            <label for="remuneracion_mensual" class="label_movil">Remuneración Mensual</label>
          </div>

        </div>


        <div class="col-12 col-md-2">
          <div class="label_movil_container">
            <input type="text" class="form-control text-uppercase" readonly value="{{ $contrato->getMoneda()->nombre}}" placeholder="">

            <label for="codMoneda" class="label_movil">Moneda</label>
          </div>

        </div>


        <div class="col-12 col-md-2">
          <div class="label_movil_container">
            <input type="text" class="form-control text-center" readonly value="{{$contrato->getTipoContratoLabel()}}">
            <label class="label_movil" for="">Tipo Contrato</label>
          </div>

        </div>



        <div class="col-12 col-md-3">
          @if ($contrato->verificarTipo_Atipico())
            <div class="label_movil_container">
              <input type="number" min="0" class="form-control" name="cantidad_dias_labor"
                id="cantidad_dias_labor" value="{{ $contrato->cantidad_dias_labor }}" placeholder="" readonly>
              <label for="cantidad_dias_labor" class="label_movil">Cantidad Días de Labor</label>
            </div>
          @endif

        </div>

        <div class="col-12 col-md-3">
          @if ($contrato->verificarTipo_Atipico())
            <div class="label_movil_container">
              <input type="number" min="0" class="form-control" name="cantidad_dias_descanso" readonly
                id="cantidad_dias_descanso" value="{{ $contrato->cantidad_dias_descanso }}" placeholder="">
              <label for="cantidad_dias_descanso" class="label_movil">Cantidad Días de Descanso</label>
            </div>
          @endif
        </div>









      </div>
    </div>
  </div>

  <div class="row m-3">
    <div class="col-12 col-sm-6 text-left">
      <a href="{{ route('ContratosPlazoNuevo.Listar') }}" class='btn btn-info '>
        <i class="fas fa-arrow-left"></i>
        Regresar al Menu
      </a>
    </div>

    <div class="col-12 col-sm-6 text-right">
      <a target="_blank" class="btn btn-info btn-sm" href="{{route('ContratosPlazoNuevo.verPDF',$contrato->getId())}}">
        Ver PDF Actual
        <i class="fas fa-file-pdf"></i>
      </a>
      <a class="btn btn-info btn-sm" href="{{route('ContratosPlazoNuevo.descargarPDF',$contrato->getId())}}">
        Descargar PDF Actual
        <i class="fas fa-file-pdf"></i>
      </a>
    </div>


  </div>



  @include('Contratos.PlazoNuevo.ContratoPlazoFijoReusable')
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

@include('Layout.EstilosPegados')
@include('Layout.ValidatorJS')
@section('script')
  {{-- <script src="/public/select2/bootstrap-select.min.js"></script>      --}}
  <script>
    $(document).ready(function() {
      $(".loader").hide();

    });
  </script>
@endsection
