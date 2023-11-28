@extends('Layout.Plantilla')

@section('titulo')
  Editar Contrato Locación servicios
@endsection

@section('contenido')

@section('tiempoEspera')
  <div class="loader" id="pantallaCarga"></div>
@endsection

@include('Layout.MensajeEmergenteDatos')

  <div class="p-2">
    <div class="page-title">
      Editar Contrato Locación Servicios
    </div>
  </div>

  <form method = "POST" action = "{{ route('ContratosLocacion.Actualizar') }}" id="frmLocacionServicio" name="frmLocacionServicio">
    <input type="hidden" name="codContratoLocacion" value="{{$contrato->codContratoLocacion}}">

    @csrf
    <div class="card">
      <div class="card-header">

        <div class="row">
          <div class="col-12 col-sm-3 font-weight-bold">
            Datos del Locador:
          </div>
          <div class="col-12 col-sm-9">

            <select class="form-control" name="esPersonaNatural" id="esPersonaNatural" onchange="cambiarTipoPersona()">
              <option value="-1">- Tipo Persona -</option>
              <option value="1" @if ($contrato->esDeNatural()) selected @endif>Persona Natural</option>
              <option value="0" @if (!$contrato->esDeNatural()) selected @endif>Persona Jurídica</option>
            </select>
          </div>
        </div>
      </div>
      <div class="card-body">

        {{-- Datos del locador --}}
        <div class="">





          <div id="FormPN" @if (!$contrato->esDeNatural()) hidden @endif >
            <div class="row">

              <div class="col-12 col-md-2 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PN_ruc" id="PN_ruc" value="{{$contrato->ruc}}" placeholder="">
                  <label for="PN_ruc" class="label_movil">RUC</label>
                </div>
              </div>

              <div class="col-12 col-md-2 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PN_dni" id="PN_dni" value="{{$contrato->dni}}" placeholder="">
                  <label for="PN_dni" class="label_movil">DNI</label>
                </div>
              </div>



              <div class="col-12 col-md-2 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PN_nombres" id="PN_nombres" value="{{$contrato->nombres}}"
                    placeholder="">
                  <label for="PN_nombres" class="label_movil">Nombre</label>
                </div>
              </div>


              <div class="col-12 col-md-2 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PN_apellidos" id="PN_apellidos" value="{{$contrato->apellidos}}"
                    placeholder="">
                  <label for="PN_apellidos" class="label_movil">Apellidos</label>
                </div>
              </div>
              <div class="col-12 col-md-2 p-1">
                <div class="label_movil_container">
                  <select class="form-control" name="PN_sexo" id="PN_sexo">
                    <option value="-1">- Sexo- </option>
                    <option value="M" @if ($contrato->sexo == "M") selected @endif >Masculino</option>
                    <option value="F" @if ($contrato->sexo == "F") selected @endif >Femenino</option>
                  </select>
                  <label for="PN_sexo" class="label_movil">Sexo</label>
                </div>
              </div>


              <div class="col-12 col-md-3 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PN_direccion" id="PN_direccion" value="{{$contrato->direccion}}"
                    placeholder="">
                  <label for="PN_direccion" class="label_movil">Domicilio fiscal</label>
                </div>
              </div>


              <div class="col-12 col-md-3 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PN_distrito" id="PN_distrito" value="{{$contrato->distrito}}" placeholder="">
                  <label for="PN_distrito" class="label_movil">Distrito</label>
                </div>
              </div>

              <div class="col-12 col-md-3 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PN_provincia" id="PN_provincia" value="{{$contrato->provincia}}" placeholder="">
                  <label for="PN_provincia" class="label_movil">Provincia</label>
                </div>

              </div>

              <div class="col-12 col-md-3 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PN_departamento" id="PN_departamento" value="{{$contrato->departamento}}" placeholder="">
                  <label for="PN_departamento" class="label_movil">Departamento</label>
                </div>

              </div>

            </div>


          </div>



          <div id="FormPJ" @if ($contrato->esDeNatural()) hidden @endif >
            <div class="row">
              <div class="col-12">
                <label for="">
                  Datos de la persona jurídica:
                </label>
              </div>

            </div>
            <div class="row">


              <div class="col-12 col-md-4 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_ruc" id="PJ_ruc" value="{{$contrato->ruc}}"
                    placeholder="">
                  <label for="PJ_ruc" class="label_movil">RUC</label>
                </div>
              </div>


              <div class="col-12 col-md-4 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_razonSocialPJ" id="PJ_razonSocialPJ" value="{{$contrato->razonSocialPJ}}" placeholder="">
                  <label for="PJ_razonSocialPJ" class="label_movil">Razón Social</label>
                </div>
              </div>



              <div class="col-12 col-md-3 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_direccion" id="PJ_direccion" value="{{$contrato->direccion}}"
                    placeholder="">
                  <label for="PJ_direccion" class="label_movil">Domicilio fiscal</label>
                </div>
              </div>


              <div class="col-12 col-md-3 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_distrito" id="PJ_distrito" value="{{$contrato->distrito}}" placeholder="">
                  <label for="PJ_distrito" class="label_movil">Distrito</label>
                </div>
              </div>

              <div class="col-12 col-md-3 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_provincia" id="PJ_provincia" value="{{$contrato->provincia}}" placeholder="">
                  <label for="PJ_provincia" class="label_movil">Provincia</label>
                </div>

              </div>

              <div class="col-12 col-md-3 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_departamento" id="PJ_departamento" value="{{$contrato->departamento}}" placeholder="">
                  <label for="PJ_departamento" class="label_movil">Departamento</label>
                </div>

              </div>

            </div>
            <div class="row">
              <div class="col-12">
                <label for="">
                  Datos del representante:
                </label>
              </div>
            </div>
            <div class="row">


              <div class="col-12 col-md-6 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_dni" id="PJ_dni" value="{{$contrato->dni}}" placeholder="">
                  <label for="PJ_dni" class="label_movil">DNI</label>
                </div>
              </div>



              <div class="col-12 col-md-6 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_nombres" id="PJ_nombres" value="{{$contrato->nombres}}" placeholder="">
                  <label for="PJ_nombres" class="label_movil">Nombres</label>
                </div>

              </div>


              <div class="col-12 col-md-6 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_apellidos" id="PJ_apellidos" value="{{$contrato->apellidos}}" placeholder="">
                  <label for="PJ_apellidos" class="label_movil">Apellidos</label>
                </div>
              </div>







              <div class="col-12 col-md-6 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_nombreDelCargoPJ" id="PJ_nombreDelCargoPJ" value="{{$contrato->nombreDelCargoPJ}}" placeholder="">
                  <label for="PJ_nombreDelCargoPJ" class="label_movil">Cargo en la empresa</label>
                </div>
              </div>


            </div>
          </div>



        </div>




      </div>
    </div>




    <div class="card">
      <div class="card-header font-weight-bold">

        Datos del Contrato
      </div>
      <div class="card-body">
        {{-- DATOS DEL CONTRATO --}}

        <div class="row">

          <div class="col-12 col-md-4 p-1">
            <div class="label_movil_container">
              <textarea class="form-control" name="motivoContrato" id="motivoContrato" placeholder="">{{$contrato->motivoContrato}}</textarea>
              <label for="motivoContrato" class="label_movil">Objetivo del contrato</label>
            </div>
          </div>
          <div class="col-12 col-md-4 p-1">
            <div class="label_movil_container">
              <input type="number" min="0" class="form-control" name="retribucionTotal" id="retribucionTotal"
                value="{{$contrato->retribucionTotal}}" placeholder="" onchange="actualizarRetribucionTotal()">
              <label for="retribucionTotal" class="label_movil">Monto de honorario</label>
            </div>
          </div>

          <div class="col-12 col-md-4 p-1">
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
          <div class="w-100"></div>


          <div class="col-12 col-md-4 p-1">

            <div class="label_movil_container">

              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                <input type="text" class="form-control text-center" autocomplete="off" name="fecha_inicio_contrato" value="{{$contrato->getFechaInicio()}}"
                  id="fecha_inicio_contrato" placeholder="">
                <label for="fecha_inicio_contrato" class="label_movil">Fecha Inicio</label>
                <div class="input-group-btn">
                  <button class="btn btn-primary date-set" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>
            </div>


          </div>
          <div class="col-12 col-md-4 p-1">

            <div class="label_movil_container">

              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                <input type="text" class="form-control text-center" autocomplete="off" name="fecha_fin_contrato" value="{{$contrato->getFechaFin()}}"
                  id="fecha_fin_contrato" placeholder="">
                <label for="fecha_fin_contrato" class="label_movil">Fecha Fin</label>
                <div class="input-group-btn">
                  <button class="btn btn-primary date-set" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>

            </div>

          </div>





          <div class="col-12 col-md-4 p-1">
            <div class="label_movil_container">

              <select class="form-control" name="codSede" id="codSede">
                <option value="-1">- Sede - </option>
                @foreach ($listaSedes as $sede)
                  <option value="{{ $sede->codSede }}" {{$sede->isThisSelected($contrato->codSede)}}>
                    {{ $sede->nombre }}
                  </option>
                @endforeach
              </select>
              <label for="codSede" class="label_movil">Sede</label>
            </div>

          </div>

          <div class="w-100"></div>
          <div class="col-12 col-md-4 p-1">

            <div class="label_movil_container">
              <input type="text" class="form-control" name="nombreProyecto" id="nombreProyecto" placeholder="" value="{{$contrato->nombreProyecto}}">
              <label for="nombreProyecto" class="label_movil">Proyecto</label>
            </div>

          </div>
          <div class="col-12 col-md-4 p-1">

            <div class="label_movil_container">
              <input type="text" class="form-control" name="nombreFinanciera" id="nombreFinanciera" value="{{$contrato->nombreFinanciera}}"
                placeholder="">
              <label for="nombreFinanciera" class="label_movil">Entidad Financiera</label>
            </div>

          </div>





        </div>


      </div>
    </div>








    <div class="container">

      <label for="">
        Productos entregables
      </label>
      <div class="table-responsive">
        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover tabla-detalles"
          style='background-color:#FFFFFF;'>
          <thead>
            <th width="15%" class="text-center">

              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                {{-- INPUT PARA EL CBTE DE LA FECHA --}}
                <input type="text" class="form-control text-center" id="nuevaFecha" value=""
                  placeholder="dd/mm/yyyy">

                <div class="input-group-btn">
                  <button class="btn btn-primary date-set btn-sm" type="button" style="display: none">
                    <i class="fas fa-calendar fa-xs"></i>
                  </button>
                </div>
              </div>
            </th>
            <th width="40%">
              <div> {{-- INPUT PARA LUGAR --}}
                <input type="text" class="form-control" name="nuevaDescripcion" id="nuevaDescripcion"
                  placeholder="Descripción del producto entregable">
              </div>

            </th>

            <th width="10%" class="text-center">
              <div> {{-- INPUT IMPORTE --}}
                <input type="number" min="0" class="form-control" name="nuevoMonto" id="nuevoMonto" readonly
                  onclick="cambiarAModoMonto()" onchange="cambioMonto()">
              </div>

            </th>
            <th width="10%" class="text-center">
              <div> {{-- INPUT IMPORTE --}}
                <input type="number" min="0" class="form-control" name="nuevoPorcentaje" id="nuevoPorcentaje"
                  readonly onclick="cambiarAModoPorcentaje()" onchange="cambioPorcentaje()">
              </div>

            </th>

            <th width="5%" class="text-center">
              <div>
                <button type="button" id="btnadddet" name="btnadddet" class="btn btn-success btn-sm"
                  onclick="clickAgregarDetalle()">
                  <i class="fas fa-plus"></i>
                  Agregar
                </button>
              </div>

            </th>

          </thead>


          <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
            <th class="text-center">Fecha Entrega</th>

            <th> Descripción del producto entregable</th>
            <th class="text-center">Monto</th>
            <th class="text-center">Porcentaje</th>

            <th class="text-center">Opciones</th>

          </thead>
          <tfoot>
            <tr>
              <td class="text-right" colspan="2">
                <b>
                  Acumulados:
                </b>

              </td>

              <td class="text-right">
                <span class="col" id="spanMontoAcumulado">

                </span>


              </td>
              <td class="text-center">

                <span class="col" id="flagPorcentajeAcumulado" style="">
                  <i class="fas fa-flag"></i>
                </span>
                <span class="col" id="spanPorcentajeAcumulado">

                </span>
              </td>
              <td></td>

            </tr>

          </tfoot>
          <tbody id="tabla_detalles">

          </tbody>
        </table>
      </div>

      <div class="row">

        <div class="col-12">
          {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
          <input type="hidden" class="w-100" name="json_detalles" id="json_detalles">

        </div>
      </div>



    </div>

    <div class="m-2 row  text-center">
      <div class="col text-left">

        <a href="{{ route('ContratosLocacion.Listar') }}" class='btn btn-info '>
          <i class="fas fa-arrow-left"></i>
          Regresar al Menu
        </a>

      </div>
      <div class="col text-right">

        <button type="button" class="btn btn-success" onclick="GenerarBorrador()">
          Ver borrador
          <i class="ml-1 fas fa-file-alt"></i>
        </button>

        <button type="button" class="btn btn-primary" onclick="clickGuardar()">
          <i class='fas fa-save'></i>
          Registrar
        </button>


      </div>



    </div>

  </form>

  <div class="hidden">
    <table>
      <tbody id="plantilla_fila">

        <tr class="selected" id="fila[Index]" name="fila[Index]">

          <td style="text-align:center;">
            <input type="text" class="form-control fontSize10 text-center" value="[Fecha]" readonly>
          </td>

          <td style="text-align:center;">
            <input type="text" class="form-control fontSize10 text-center" value="[Descripcion]" readonly>
          </td>

          <td style="text-align:right;">
            <input type="text" class="form-control text-right" value="[Monto]" readonly>
            <input type="hidden" class="form-control" value="[Monto]" readonly>
          </td>

          <td style="text-align:right;">
            <input type="text" class="form-control text-right" value="[Porcentaje]%" readonly>
            <input type="hidden" class="form-control" value="[Porcentaje]" readonly>
          </td>

          <td style="text-align:center;">
            <button type="button" class="btn btn-danger btn-xs" onclick="eliminardetalle([Index]);">
              <i class="fa fa-times"></i>
            </button>
            <button type="button" class="btn btn-xs" onclick="editarDetalle([Index]);">
              <i class="fas fa-pen"></i>
            </button>

          </td>
        </tr>

      </tbody>
    </table>
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

@include('Layout.EstilosPegados')
@include('Layout.ValidatorJS')
@section('script')

  @include('Contratos.LocacionServicios.ReusableContratoLocacion')

  <script>

    var ModalBorrador = new bootstrap.Modal(document.getElementById("ModalBorrador"), {});

    $(document).ready(function() {

      var ListaDetallesExistentes = @json($contrato->getAvances())

      console.log("ListaDetallesExistentes",ListaDetallesExistentes);

      for (let index = 0; index < ListaDetallesExistentes.length; index++) {
        const avance = ListaDetallesExistentes[index];

        agregarDetalle(avance.fecha_front,avance.descripcion,avance.monto,avance.porcentaje,avance.codAvance)
      }
      $(".loader").hide();

    });

    function clickGuardar() {
      msje = validarForm();
      if (msje != "") {
        alerta(msje);
        return false;
      }

      JsonDetallesInput.value = JSON.stringify(ListaDetalles);

      confirmar('¿Estás seguro de crear el contrato?', 'info', 'frmLocacionServicio');

    }
  </script>


@endsection
