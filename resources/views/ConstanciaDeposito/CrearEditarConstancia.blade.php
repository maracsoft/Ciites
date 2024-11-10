@extends ('Layout.Plantilla')
@section('titulo')
  {{ $title }}
@endsection

@section('contenido')
  @include('Layout.Loader')

  <div class="p-1 mb-2">
    <div class="page-title">
      {{ $title }}
    </div>
  </div>

  @include('Layout.MensajeEmergenteDatos')

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <label for="" class="mb-0">
            <h3 class="mb-0">
              Información General
            </h3>
          </label>
        </div>
        <div class="card-body">

          <form action="{{ $action }}" method="POST" name="formConstancia" id="formConstancia" enctype="multipart/form-data">

            <input type="hidden" name="codConstancia" value="{{ $constancia->codConstancia }}">

            @csrf

            <div class="row">


              <div class="col-12">
                <div class="row">

                  <div class="col-sm-2">
                    <label class="mb-0" for="">
                      Creador
                    </label>
                    <input type="text" class="form-control" readonly
                      value="{{ $constancia->getEmpleadoCreador()->getNombreCompleto() }}" placeholder="">
                  </div>

                  <div class="col-sm-2">
                    <label class="mb-0" for="">
                      Fecha Creación
                    </label>
                    <input type="text" class="form-control text-center"
                      value="{{ $constancia->getFechaHoraCreacion() }}" readonly placeholder="">
                  </div>





                  <div class="col-12 col-md-2">

                    <div class="d-flex align-items-center ">
                      <div class="">
                        <label for="dni" class="mb-0">
                          DNI
                        </label>
                        <div class="d-flex">
                          <input type="number" class="form-control text-center" name="dni" id="dni" value="{{$constancia->dni}}" placeholder="">
                          <button type="button" onclick="consultarPorDNI()" class="ml-1 btn btn-sm btn-success" title="">
                            <i class="fas fa-search icono_buscar"></i>
                          </button>

                        </div>

                      </div>


                    </div>


                  </div>

                  <div class="col-12 col-md-2">
                    <label for="nombres" class="mb-0">
                      Nombres
                    </label>
                    <input type="text" class="form-control" name="nombres" id="nombres" value="{{$constancia->nombres}}" placeholder="">
                  </div>


                  <div class="col-12 col-md-2">
                    <label for="apellidos" class="mb-0">
                      Apellidos
                    </label>
                    <input type="text" class="form-control" name="apellidos" id="apellidos" value="{{$constancia->apellidos}}" placeholder="">
                  </div>


                  <div class="col-12 col-md-2">
                    <label for="fecha_deposito" class="mb-0">
                      Fecha Depósito
                    </label>
                    <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                      <input type="text" class="form-control text-center" autocomplete="off" name="fecha_deposito" id="fecha_deposito" value="{{$constancia->getFechaDeposito()}}" placeholder="dd/mm/yyyy">

                      <div class="input-group-btn">
                        <button class="btn btn-primary date-set d-none" type="button">
                          <i class="fa fa-calendar"></i>
                        </button>
                      </div>
                    </div>

                  </div>


                  <div class="col-4 col-md-2">
                    <label for="nro_cuenta" class="mb-0">
                      Nro Cuenta Bancaria
                    </label>
                    <input type="number" class="form-control text-center" name="nro_cuenta" id="nro_cuenta" value="{{$constancia->nro_cuenta}}" placeholder="">
                  </div>



                  <div class="col-12 col-sm-2">
                    <label class="mb-0" for="">Banco</label>

                    <input type="text" class="form-control text-center" name="nombre_banco" id="nombre_banco" value="{{$constancia->nombre_banco}}" placeholder="">

                  </div>


                  <div class="col-12 col-md-2">
                    <label for="nro_meses_laborados" class="mb-0">Meses lab</label>
                    <input type="number" class="form-control text-center" name="nro_meses_laborados" id="nro_meses_laborados" value="{{$constancia->nro_meses_laborados}}" placeholder="# Meses">
                  </div>

                  <div class="col-12 col-md-2">
                    <label for="nro_dias_laborados" class="mb-0">Días lab</label>
                    <input type="number" class="form-control text-center" name="nro_dias_laborados" id="nro_dias_laborados" value="{{$constancia->nro_dias_laborados}}" placeholder="# Dias">
                  </div>



                  <div class="col-12 col-md-2">
                    <label for="ultimo_sueldo_bruto" class="mb-0">Último sueldo bruto</label>
                    <input type="number" class="form-control text-right" name="ultimo_sueldo_bruto" id="ultimo_sueldo_bruto" value="{{$constancia->ultimo_sueldo_bruto}}" placeholder="S/">
                  </div>

                  <div class="col-12 col-md-2">
                    <label for="monto_ultima_grati" class="mb-0">Ultima gratificación</label>
                    <input type="number" class="form-control text-right" name="monto_ultima_grati" id="monto_ultima_grati" value="{{$constancia->monto_ultima_grati}}" placeholder="S/" >
                  </div>



                  <div class="col-12 col-md-2">
                    <label for="promedio_otras_remuneraciones" class="mb-0">Prom. otras remuneraciones</label>
                    <input type="number" class="form-control text-right" name="promedio_otras_remuneraciones" id="promedio_otras_remuneraciones" value="{{$constancia->promedio_otras_remuneraciones}}" placeholder="S/" >
                  </div>



                </div>
              </div>



              <div class="col-12 col-md-2">
                <label for="fecha_deposito" class="mb-0">
                  Periodo - Fecha Inicio
                </label>
                <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                  <input type="text" class="form-control text-center" autocomplete="off" name="fecha_inicio" id="fecha_inicio" value="{{$constancia->getFechaInicio()}}" placeholder="dd/mm/yyyy">

                  <div class="input-group-btn">
                    <button class="btn btn-primary date-set d-none" type="button">
                      <i class="fa fa-calendar"></i>
                    </button>
                  </div>
                </div>

              </div>


              <div class="col-12 col-md-2">
                <label for="fecha_deposito" class="mb-0">
                  Periodo - Fecha Fin
                </label>
                <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                  <input type="text" class="form-control text-center" autocomplete="off" name="fecha_fin" id="fecha_fin" value="{{$constancia->getFechaFin()}}" placeholder="dd/mm/yyyy">

                  <div class="input-group-btn">
                    <button class="btn btn-primary date-set d-none" type="button">
                      <i class="fa fa-calendar"></i>
                    </button>
                  </div>
                </div>

              </div>



              <div class="col-12 col-md-3">
                <label for="" class="mb-0">
                  Fecha de emisión
                </label>

                <div class="d-flex">
                  <input type="text" class="form-control numero_fijo text-center" readonly value="15">
                  <select class="form-control" name="mes_emision" id="mes_emision">
                    <option value="">- Meses -</option>
                    <option value="5" @if($constancia->getCodMesEmision() == "5") selected @endif>Mayo</option>
                    <option value="11" @if($constancia->getCodMesEmision() == "11") selected @endif>Noviembre</option>
                  </select>


                  <input type="text" class="form-control text-center año_fijo" autocomplete="off" name="año_emision" id="año_emision" value="{{$constancia->getAñoEmision()}}">

                </div>


              </div>


            </div>



          </form>
        </div>
        <div class="card-footer">
          <div class="d-flex">

            <button type="button" onclick="clickGuardar()" class="ml-auto btn btn-success">
              Guardar
              <i class="fas fa-save"></i>
            </button>
          </div>
        </div>
      </div>

    </div>

    @if($constancia->existe())
      <div class="col-12 text-right">
        <a class="btn btn-info" href="{{route('ConstanciaDepositoCTS.DescargarPdf',$constancia->getId())}}">
          Descargar pdf <i class="fas fa-download"></i>
        </a>
        <a target="_blank" class="btn btn-info" href="{{route('ConstanciaDepositoCTS.VerPdf',$constancia->getId())}}">
          Ver Pdf
          <i class="fas fa-file-pdf"></i>
        </a>

      </div>
    @endif

  </div>

  <div class="row">
    <div class="col-12 col-sm-9 text-left">

      <a class="btn btn-info" href="{{ route('ConstanciaDepositoCTS.Listar') }}">
        <i class="fas fa-arrow-left mr-1"></i>
        Volver
      </a>

    </div>

  </div>
@endsection

@section('script')
  @include('Layout.ValidatorJS')


  <script>

    $(document).ready(function() {


      $(".loader").fadeOut("slow");
    });

    function clickGuardar() {
      var msj = validarForm();
      if (msj != "") {
        alerta(msj)
        return;
      }
      $(".loader").fadeIn("slow");
      document.formConstancia.submit();
    }



    function validarForm() {
      limpiarEstilos([

        'nombre_banco',
        'dni',
        'nombres',
        'apellidos',
        'nro_cuenta',
        'fecha_deposito',
        'nro_meses_laborados',
        'nro_dias_laborados',
        'ultimo_sueldo_bruto',
        'monto_ultima_grati',
        'mes_emision',
        'año_emision'
      ]);

      var msj = "";


      msj = validarSelect(msj, "nombre_banco", "", "Banco");
      msj = validarTamañoExacto(msj,'dni',8,"DNI");
      msj = validarTamañoMaximoYNulidad(msj, "nombres", 100, "Nombres");
      msj = validarTamañoMaximoYNulidad(msj, "apellidos", 100, "Apellidos");
      msj = validarTamañoMaximoYNulidad(msj, "nro_cuenta", 100, "Nro de Cuenta");
      msj = validarTamañoExacto(msj, "fecha_deposito", 10, "Fecha depósito");
      msj = validarTamañoExacto(msj, "fecha_inicio", 10, "Fecha Inicio");
      msj = validarTamañoExacto(msj, "fecha_fin", 10, "Fecha Fin");

      msj = validarNoNegatividadYNulidad(msj,'nro_meses_laborados','Nro de meses laborados')
      msj = validarNoNegatividadYNulidad(msj,'nro_dias_laborados','Nro de días laborados')

      msj = validarNoNegatividadYNulidad(msj,'ultimo_sueldo_bruto',"Ultimo sueldo bruto")
      msj = validarNoNegatividadYNulidad(msj,'monto_ultima_grati',"Ultima gratificación")
      msj = validarNoNegatividadYNulidad(msj,'promedio_otras_remuneraciones',"Promedio otras remuneraciones")

      msj = validarSelect(msj, "mes_emision", "", "Mes de emisión");
      msj = validarPositividadYNulidad(msj,'año_emision',"Año de emisión")

      return msj;
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
@endsection

@section('estilos')
  <style>
    .numero_fijo{
      width: 50px;
    }
    .año_fijo{
      width: 90px;
    }

  </style>
  @include('CSS.RemoveInputNumberArrows')
@endsection
