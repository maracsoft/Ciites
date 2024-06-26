@extends('Layout.Plantilla')

@section('titulo')
  Editar Contrato Plazo Fijo
@endsection

@section('contenido')
@include('Layout.Loader')

  <div class="p-2">
    <div class="page-title">
      Editar Contrato Plazo Fijo
    </div>
  </div>

  @include('Layout.MensajeEmergenteDatos')

  <form method = "POST" action = "{{ route('ContratosPlazoNuevo.Actualizar') }}" onsubmit="" id="frmPlazoFijo" name="frmPlazoFijo">
    <input type="hidden" name="codContratoPlazo" value="{{$contrato->codContratoPlazo}}">
    @csrf

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
                    <input type="number" class="form-control" name="dni" id="dni" value="{{$contrato->dni}}" placeholder="">
                    <label for="dni" class="label_movil">dni</label>

                  </div>
                  <div class="px-1">
                    <button type="button" onclick="consultarPorDNI()" class="btn btn-success" title="">
                      <i class="fas fa-search icono_buscar"></i>
                    </button>
                  </div>

                </div>


              </div>

              <div class="col-12 col-md-4">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="nombres" id="nombres" value="{{$contrato->nombres}}" placeholder="">
                  <label for="nombres" class="label_movil">nombres</label>
                </div>
              </div>


              <div class="col-12 col-md-4">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="apellidos" id="apellidos" value="{{$contrato->apellidos}}"
                    placeholder="">
                  <label for="apellidos" class="label_movil">apellidos</label>
                </div>
              </div>
              <div class="col-12 col-md-4">
                <div class="label_movil_container">
                  <select class="form-control" name="sexo" id="sexo">
                    <option value="-1">- Seleccionar - </option>
                    <option value="M" @if ($contrato->sexo == 'M') selected @endif>Masculino</option>
                    <option value="F" @if ($contrato->sexo == 'F') selected @endif>Femenino</option>
                  </select>
                  <label for="sexo" class="label_movil">sexo</label>
                </div>
              </div>


              <div class="col-12 col-md-8">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="domicilio" id="domicilio" value="{{$contrato->domicilio}}"
                    placeholder="">
                  <label for="domicilio" class="label_movil">domicilio</label>
                </div>
              </div>

              <div class="col-12 col-md-4">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="distrito" id="distrito" value="{{$contrato->distrito}}"
                    placeholder="">
                  <label for="distrito" class="label_movil">distrito</label>
                </div>
              </div>

              <div class="col-12 col-md-4">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="provincia" id="provincia" value="{{$contrato->provincia}}"
                    placeholder="">
                  <label for="provincia" class="label_movil">Provincia</label>
                </div>
              </div>

              <div class="col-12 col-md-4">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="departamento" id="departamento" value="{{$contrato->departamento}}"
                    placeholder="">
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
                  <select class="form-control" name="tipo_adenda_financiera" id="tipo_adenda_financiera">
                    <option value="-1">- Seleccionar - </option>
                    @foreach ($listaTipoAdenda as $tipo)
                      <option value="{{ $tipo }}" @if ($contrato->tipo_adenda_financiera == $tipo) selected @endif>
                        {{ strtoupper($tipo) }}
                      </option>
                    @endforeach
                  </select>
                  <label for="tipo_adenda_financiera" class="label_movil">Tipo de Documento</label>
                </div>
              </div>

              <div class="col-12 col-md-7">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="nombre_financiera" id="nombre_financiera" value="{{$contrato->nombre_financiera}}" placeholder="">
                  <label for="nombre_financiera" class="label_movil">Financiera</label>
                </div>
              </div>


              <div class="col-12 col-md-12">
                <div class="label_movil_container">
                  <textarea type="text" class="form-control" name="nombre_proyecto" id="nombre_proyecto"
                    placeholder="" rows="3">{{$contrato->nombre_proyecto}}</textarea>
                  <label for="nombre_proyecto" class="label_movil">Nombre Proyecto</label>
                </div>
              </div>

              <div class="col-4 col-md-6">
                <div class="label_movil_container">
                  <input type="number" class="form-control text-center" name="duracion_convenio_numero" value="{{$contrato->duracion_convenio_numero}}"
                    id="duracion_convenio_numero" placeholder="">
                  <label for="duracion_convenio_numero" class="label_movil">DURACIÓN DEL PROYECTO</label>
                </div>
              </div>

              <div class="col-8 col-md-6">
                <div class="label_movil_container">
                  <select class="form-control" name="duracion_convenio_unidad_temporal"
                    id="duracion_convenio_unidad_temporal">
                    <option value="-1">- Seleccionar - </option>
                    @foreach ($tiposTiempos as $tiempo)
                      <option value="{{ $tiempo }}" @if ($contrato->duracion_convenio_unidad_temporal == $tiempo) selected @endif >
                        {{ mb_strtoupper($tiempo) }}
                      </option>
                    @endforeach
                  </select>
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
              <input type="text" class="form-control" name="puesto" id="puesto" placeholder="" value="{{$contrato->puesto}}">
              <label for="puesto" class="label_movil">Puesto</label>
            </div>
          </div>

          <div class="col-12 col-md-2">
            <div class="label_movil_container">
              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                <input type="text" class="form-control text-center" autocomplete="off" name="fecha_inicio_contrato" value="{{$contrato->getFechaInicio()}}" id="fecha_inicio_contrato" placeholder="">
                <label for="fecha_inicio_contrato" class="label_movil">Fecha Inicio Contrato</label>
                <div class="input-group-btn">
                  <button class="btn btn-primary date-set d-none" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>

            </div>


          </div>
          <div class="col-12 col-md-2">
            <div class="label_movil_container">
              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                <input type="text" class="form-control text-center" autocomplete="off" name="fecha_fin_contrato" value="{{$contrato->getFechaFin()}}" id="fecha_fin_contrato" placeholder="">
                <label for="fecha_fin_contrato" class="label_movil">Fecha Fin Contrato</label>
                <div class="input-group-btn">
                  <button class="btn btn-primary date-set d-none" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>



          <div class="col-12 col-md-2">
            <div class="label_movil_container">
              <select name="tiene_periodo_prueba" id="tiene_periodo_prueba" class="form-control" onchange="cambioPeriodoPrueba()">
                <option value="">- Seleccionar -</option>
                <option value="1" @if ($contrato->tienePeriodoPrueba()) selected @endif>SÍ</option>
                <option value="0" @if (!$contrato->tienePeriodoPrueba()) selected @endif>NO</option>
              </select>
              <label class="label_movil" for="">Activar Periodo de Prueba</label>
            </div>

          </div>

          <div class="col-12 col-md-2 ">
            <div class="label_movil_container container_fechas_prueba">
              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                <input type="text" class="form-control text-center" autocomplete="off" name="fecha_inicio_prueba" value="{{$contrato->getFechaInicioPrueba()}}" id="fecha_inicio_prueba" placeholder="">
                <label for="fecha_inicio_prueba" class="label_movil">Fecha Inicio Prueba</label>
                <div class="input-group-btn">
                  <button class="btn btn-primary date-set d-none" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>

            </div>
          </div>

          <div class="col-12 col-md-2 ">
            <div class="label_movil_container container_fechas_prueba">
              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                <input type="text" class="form-control text-center" autocomplete="off" name="fecha_fin_prueba" value="{{$contrato->getFechaFinPrueba()}}" id="fecha_fin_prueba" placeholder="">
                <label for="fecha_fin_prueba" class="label_movil">Fecha Fin Prueba</label>
                <div class="input-group-btn">
                  <button class="btn btn-primary date-set d-none" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>





          <div class="col-12 col-md-2">
            <div class="label_movil_container">
              <input type="number" min="0" class="form-control text-right" name="remuneracion_mensual" id="remuneracion_mensual" value="{{$contrato->remuneracion_mensual}}" placeholder="">
              <label for="remuneracion_mensual" class="label_movil">Remuneración Mensual</label>
            </div>
          </div>


          <div class="col-12 col-md-2">
            <div class="label_movil_container">
              <select class="form-control" name="codMoneda" id="codMoneda">
                <option value="-1">- Moneda - </option>
                @foreach ($listaMonedas as $moneda)
                  <option value="{{ $moneda->codMoneda }}" {{$moneda->isThisSelected($contrato->codMoneda)}}>
                    {{ $moneda->nombre }}
                  </option>
                @endforeach
              </select>
              <label for="codMoneda" class="label_movil">Moneda</label>
            </div>

          </div>

          <div class="col-12 col-md-2">
            <div class="label_movil_container">
              <select class="form-control" name="tipo_contrato" id="tipo_contrato" onchange="changeTipoContrato()">
                <option value="-1">- Tipo Contrato - </option>
                @foreach ($listaTiposContrato as $tipo_contrato => $label)
                  <option value="{{ $tipo_contrato }}" @if ($tipo_contrato == $contrato->tipo_contrato) selected @endif>
                    {{ $label }}
                  </option>
                @endforeach
              </select>
              <label for="tipo_contrato" class="label_movil">Tipo Contrato</label>
            </div>

          </div>




          <div class="col-12 col-md-3 ">
            <div class="label_movil_container campo_atipico">
              <input type="number" min="0" class="form-control" name="cantidad_dias_labor" id="cantidad_dias_labor" value="{{$contrato->cantidad_dias_labor}}" placeholder="">
              <label for="cantidad_dias_labor" class="label_movil">Cantidad Días de Labor</label>
            </div>
          </div>

          <div class="col-12 col-md-3 ">
            <div class="label_movil_container campo_atipico">
              <input type="number" min="0" class="form-control" name="cantidad_dias_descanso" id="cantidad_dias_descanso" value="{{$contrato->cantidad_dias_descanso}}" placeholder="">
              <label for="cantidad_dias_descanso" class="label_movil">Cantidad Días de Descanso</label>
            </div>
          </div>









        </div>
      </div>
    </div>









    <div class="row mx-2">
      <div class="col-12 col-sm-6 text-left">
        <a href="{{ route('ContratosPlazoNuevo.Listar') }}" class='btn btn-info '>
          <i class="fas fa-arrow-left"></i>
          Regresar al Menu
        </a>
      </div>

      <div class="col-12 col-sm-6 text-right">


        <button type="button" class="btn btn-success" onclick="GenerarBorrador()" title="Ver borrador con los cambios actuales">
          Ver borrador
          <i class="ml-1 fas fa-file-alt"></i>
        </button>


        <button type="button" class="btn btn-primary" onclick="clickGuardar()">
          Guardar
          <i class='ml-1 fas fa-save'></i>
        </button>
      </div>



    </div>
    <div class="row mx-2 mt-1">
      <div class="col-12 text-right">
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

  </form>



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


@include('Layout.ValidatorJS')
@section('script')

  <script>
    var ModalBorrador = new bootstrap.Modal(document.getElementById("ModalBorrador"), {});

    $(document).ready(function() {
      cambioPeriodoPrueba();
      changeTipoContrato();
      $(".loader").hide();

    });

    function clickGuardar() {

      msje = validarForm();
      if (msje != "") {
        alerta(msje);
        return false;
      }

      confirmar('¿Estás seguro de actualizar el contrato?', 'info', 'frmPlazoFijo');

    }



  </script>

@endsection
@section('estilos')

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

@endsection
