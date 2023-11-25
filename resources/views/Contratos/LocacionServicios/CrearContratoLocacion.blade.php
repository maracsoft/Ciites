@extends('Layout.Plantilla')

@section('titulo')
  Crear Contrato Locación servicios
@endsection

@section('contenido')
  <div class="p-2">
    <div class="page-title">
      Crear Contrato Locación Servicios
    </div>
  </div>

  <form method = "POST" action = "{{ route('ContratosLocacion.Guardar') }}" onsubmit="" id="frmLocacionServicio"
    name="frmLocacionServicio">

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
              <option value="1">Persona Natural</option>
              <option value="0">Persona Jurídica</option>
            </select>
          </div>
        </div>
      </div>
      <div class="card-body">

        {{-- Datos del locador --}}
        <div class="">





          <div id="FormPN" hidden>
            <div class="row">

              <div class="col-12 col-md-2 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PN_ruc" id="PN_ruc" value="" placeholder="">
                  <label for="PN_ruc" class="label_movil">RUC</label>
                </div>
              </div>

              <div class="col-12 col-md-2 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PN_dni" id="PN_dni" value="" placeholder="">
                  <label for="PN_dni" class="label_movil">DNI</label>
                </div>
              </div>



              <div class="col-12 col-md-2 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PN_nombres" id="PN_nombres" value=""
                    placeholder="">
                  <label for="PN_nombres" class="label_movil">Nombre</label>
                </div>
              </div>


              <div class="col-12 col-md-2 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PN_apellidos" id="PN_apellidos" value=""
                    placeholder="">
                  <label for="PN_apellidos" class="label_movil">Apellidos</label>
                </div>
              </div>
              <div class="col-12 col-md-2 p-1">
                <div class="label_movil_container">
                  <select class="form-control" name="PN_sexo" id="PN_sexo">
                    <option value="-1">- Sexo- </option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                  </select>
                  <label for="PN_sexo" class="label_movil">Sexo</label>
                </div>
              </div>


              <div class="col-12 col-md-6 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PN_direccion" id="PN_direccion" value=""
                    placeholder="">
                  <label for="PN_direccion" class="label_movil">Domicilio fiscal</label>
                </div>
              </div>
              <div class="col-12 col-md-6 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PN_provinciaYDepartamento"
                    id="PN_provinciaYDepartamento" value="" placeholder="">
                  <label for="PN_provinciaYDepartamento" class="label_movil">Provincia y Departamento</label>
                </div>

              </div>

            </div>


          </div>



          <div id="FormPJ" hidden>
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
                  <input type="text" class="form-control" name="PJ_ruc" id="PJ_ruc" value=""
                    placeholder="">
                  <label for="PJ_ruc" class="label_movil">RUC</label>
                </div>
              </div>


              <div class="col-12 col-md-4 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_razonSocialPJ" id="PJ_razonSocialPJ"
                    value="" placeholder="">
                  <label for="PJ_razonSocialPJ" class="label_movil">Razón Social</label>
                </div>
              </div>
              <div class="col-12 col-md-4 p-1">
                <div class="label_movil_container">
                  <select class="form-control" name="PJ_sexo" id="PJ_sexo">
                    <option value="-1">- Sexo- </option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                  </select>
                  <label for="PJ_sexo" class="label_movil">Sexo</label>
                </div>
              </div>


              <div class="col-12 col-md-6 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_direccion" id="PJ_direccion" value=""
                    placeholder="">
                  <label for="PJ_direccion" class="label_movil">Domicilio fiscal</label>
                </div>
              </div>

              <div class="col-12 col-md-6 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_provinciaYDepartamento"
                    id="PJ_provinciaYDepartamento" value="" placeholder="">
                  <label for="PJ_provinciaYDepartamento" class="label_movil">Provincia y Departamento</label>
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
                  <input type="text" class="form-control" name="PJ_dni" id="PJ_dni" value=""
                    placeholder="">
                  <label for="PJ_dni" class="label_movil">DNI</label>
                </div>
              </div>



              <div class="col-12 col-md-6 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_nombres" id="PJ_nombres" value=""
                    placeholder="">
                  <label for="PJ_nombres" class="label_movil">Nombres</label>
                </div>

              </div>


              <div class="col-12 col-md-6 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_apellidos" id="PJ_apellidos" value=""
                    placeholder="">
                  <label for="PJ_apellidos" class="label_movil">Apellidos</label>
                </div>
              </div>







              <div class="col-12 col-md-6 p-1">
                <div class="label_movil_container">
                  <input type="text" class="form-control" name="PJ_nombreDelCargoPJ" id="PJ_nombreDelCargoPJ"
                    value="" placeholder="">
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
              <textarea class="form-control" name="motivoContrato" id="motivoContrato" placeholder=""></textarea>
              <label for="motivoContrato" class="label_movil">Objetivo del contrato</label>
            </div>
          </div>
          <div class="col-12 col-md-4 p-1">
            <div class="label_movil_container">
              <input type="number" min="0" class="form-control" name="retribucionTotal" id="retribucionTotal"
                value="" placeholder="" onchange="actualizarRetribucionTotal()">
              <label for="retribucionTotal" class="label_movil">Monto de honorario</label>
            </div>
          </div>

          <div class="col-12 col-md-4 p-1">
            <div class="label_movil_container">

              <select class="form-control" name="codMoneda" id="codMoneda">
                <option value="-1">- Moneda - </option>
                @foreach ($listaMonedas as $moneda)
                  <option value="{{ $moneda->codMoneda }}">
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
                <input type="text" class="form-control text-center" autocomplete="off" name="fechaInicio"
                  id="fechaInicio" placeholder="">
                <label for="fechaInicio" class="label_movil">Fecha Inicio</label>
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
                <input type="text" class="form-control text-center" autocomplete="off" name="fechaFin"
                  id="fechaFin" placeholder="">
                <label for="fechaFin" class="label_movil">Fecha Fin</label>
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
                  <option value="{{ $sede->codSede }}">
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
              <input type="text" class="form-control" name="nombreProyecto" id="nombreProyecto" placeholder="">
              <label for="nombreProyecto" class="label_movil">Proyecto</label>
            </div>

          </div>
          <div class="col-12 col-md-4 p-1">

            <div class="label_movil_container">
              <input type="text" class="form-control" name="nombreFinanciera" id="nombreFinanciera"
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
        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover tabla-detalles" style='background-color:#FFFFFF;'>
          <thead>
            <th width="15%" class="text-center">

              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                {{-- INPUT PARA EL CBTE DE LA FECHA --}}
                <input type="text" class="form-control text-center" id="nuevaFecha" value="" placeholder="dd/mm/yyyy">

                <div class="input-group-btn">
                  <button class="btn btn-primary date-set btn-sm" type="button" style="display: none">
                    <i class="fas fa-calendar fa-xs"></i>
                  </button>
                </div>
              </div>
            </th>
            <th width="40%">
              <div> {{-- INPUT PARA LUGAR --}}
                <input type="text" class="form-control" name="nuevaDescripcion" id="nuevaDescripcion" placeholder="Descripción del producto entregable">
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
                  onclick="agregarDetalle()">
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
          <input type="text" class="w-100" name="json_detalles" id="json_detalles">

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
        <button type="button" class="btn btn-primary" onclick="clickGuardar()">
          <i class='fas fa-save'></i>
          Registrar
        </button>


      </div>



    </div>

  </form>

  <div class="hidden">
    <table>
      <tbody  id="plantilla_fila">

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


    $(document).ready(function() {

    });

    function clickGuardar() {
      msje = validarFormCrear();
      if (msje != "") {
        alerta(msje);
        return false;
      }

      JsonDetallesInput.value = JSON.stringify(ListaDetalles);

      confirmar('¿Estás seguro de crear el contrato?', 'info', 'frmLocacionServicio');

    }



    function validarFormCrear() { //Retorna TRUE si es que todo esta OK y se puede hacer el submit
      msj = '';

      limpiarEstilos([
          'esPersonaNatural',
          'PN_ruc', 'PN_dni', 'PN_nombres', 'PN_apellidos', 'PN_sexo', 'PN_direccion',
          'PN_provinciaYDepartamento', //campos de PN
          'PJ_ruc', 'PJ_razonSocialPJ', 'PJ_sexo', 'PJ_direccion', 'PJ_provinciaYDepartamento', 'PJ_dni', 'PJ_nombres',
          'PJ_apellidos', 'PJ_nombreDelCargoPJ', /* Campos de PJ */
          'motivoContrato', 'fechaInicio', 'fechaFin', 'retribucionTotal', 'codMoneda', 'codSede', 'nombreProyecto',
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
      msj = validarNulidad(msj, 'fechaInicio', 'Fecha de inicio');
      msj = validarNulidad(msj, 'fechaFin', 'Fecha de fin');

      msj = validarPositividadYNulidad(msj, 'retribucionTotal', 'Monto retribución');
      msj = validarSelect(msj, 'codMoneda', '-1', 'Moneda');
      msj = validarSelect(msj, 'codSede', '-1', 'Sede');
      msj = validarTamañoMaximoYNulidad(msj, 'nombreProyecto', 300, 'Proyecto');
      msj = validarTamañoMaximoYNulidad(msj, 'nombreFinanciera', 300, 'Financiera');


      if(ListaDetalles.length == 0)
        msj = "No ha ingresado detalles";


      if (porcentajeAcumulado != 100 && totalAcumulado != RetribucionTotalInput.value)
        msj = "La suma de los porcentajes debe ser de 100. La actual es " + porcentajeAcumulado;

      return msj;
    }




    indexAEliminar = 0;
    function eliminardetalle(index) {
      indexAEliminar = index;
      confirmarConMensaje("Confirmación", "¿Desea eliminar el item N° " + (index + 1) + "?", 'warning',ejecutarEliminacionDetalle);
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


    function agregarDetalle() {
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

      if (nuevoMonto + totalAcumulado > retribucionTotal.value)
        msjError = "El monto actual se excede del pago total.";

      if (msjError != "") {
        alerta(msjError);
        return false;
      }



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
        codAvance:0,
        fecha: nuevaFecha,
        descripcion: nuevaDescripcion,
        monto: nuevoMonto,
        porcentaje: nuevoPorcentaje
      });

      actualizarTabla();
      limpiarFormAgregar();

    }

    function limpiarFormAgregar(){
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
          Index:index,
          Fecha:element.fecha,
          Descripcion:element.descripcion,
          Monto:element.monto,
          Porcentaje:element.porcentaje,
        }

        var fila = hidrateHtmlString(PlantillaFila,HidrationObject);
        html_total += fila;
      }

      TablaDetalles.innerHTML = html_total;

      SpanPorcentajeAcumulado.innerHTML = number_format(porcentajeAcumulado, 2) + "%";
      SpanMontoAcumulado.innerHTML = number_format(totalAcumulado, 2);

      pintarColorPorcentaje(porcentajeAcumulado);

      JsonDetallesInput.value = JSON.stringify(ListaDetalles);

    }

    function pintarColorPorcentaje(porcentajeAcumulado){
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
@endsection
