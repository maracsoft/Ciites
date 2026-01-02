@extends('Layout.Plantilla')

@section('titulo')
  Dashboard General
@endsection
@section('tiempoEspera')
  <div class="loader" id="pantallaCarga"></div>
@endsection
@section('contenido')

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>


  <link rel="stylesheet" href="/libs/morris.css">
  <script src="/libs/morris.min.js" charset="utf-8"></script>


  @include('Layout.MensajeEmergenteDatos')

  @php
    $estilosGrafico = "height: 250px;
                        max-height: 250px;
                        display: block; ";
    $estilosGraficoDoble = " height: 250px;
                        max-height: 300px; max-width:700px;
                        display: block;  ";

    $selectProyectos = new App\UI\UISelectMultiple([], '', 'codsProyectos', 'Proyectos', false, 30, 12);
    $selectProyectos->setOptionsWithModel($listaProyectos, 'nombreYcod');

    $desplegableSOF = new App\UI\UIDesplegable('Solicitud de Fondos');
    $desplegableREN = new App\UI\UIDesplegable('Rendición de Gastos');
    $desplegableREP = new App\UI\UIDesplegable('Reposición de Gastos');
    $desplegableREQ = new App\UI\UIDesplegable('Requerimientos de bienes y servicios');

    $empLogeado = App\Empleado::getEmpleadoLogeado();

  @endphp
@section('estilos')
  <style>
    .fondo-oscuro {
      background-color: #c7e0e9;

      border-width: 1px;
    }

    .header-card .valor {
      font-size: 17pt;
      font-weight: 900;
    }

    .value-card {

      border-radius: 9px;
      padding: 4px;
    }

    .fondo-celeste {
      background-color: rgb(218 251 255);
    }

    .fondo-verde {
      background-color: rgb(220, 245, 220)
    }


    .value-card .text-time {
      font-size: 9pt;
      margin-bottom: -5px;

    }

    .subtitulo {
      color: #09301c;
      font-size: 12pt;
    }

    .dash-perfil-img {
      max-width: 50px;
      max-height: 50px
    }

    .icono-filtro {}

    .titulo-dash {
      background-color: #e6e6e6;
      border-radius: 5px;
      padding: 5px;

    }
  </style>
@endsection

<div class="titulo-dash text-center my-1 mx-2">

  <b class="fontSize18">
    Dashboard General
  </b>


</div>

<div class="row">
  <div class="col-lg-6 col-12 d-flex">

    <img src="/img/usuario.png" class="my-auto dash-perfil-img img-circle elevation-2 ml-3" alt="User Image">
    <div class="d-flex flex-column ml-2 my-auto">

      <div class="fontSize14">
        <b>
          Bienvenid{{ $empLogeado->getLetraSegunSexo() }}, {{ $empLogeado->getNombreCompleto() }}

        </b>
      </div>

      <div class="fontSize12  mt-n1">
        Estamos felices de verte de nuevo.
      </div>

    </div>

  </div>
  <div class="col-lg-6 col-12">
    <div class="card">

      <div class="card-body p-2">
        <div class=" d-flex flex-wrap">

          <div class="d-flex flex-column mx-3" title="Aplique filtros para mejorar la presición de su información">
            <i class="my-auto fas fa-filter fa-2x"></i>
          </div>

          <div
            title="Si no se selecciona ningún proyecto, se mostrará información de todos los proyectos sobre los que tenga autorización (gerente y supervisor)">
            <b for="">
              Filtros:
            </b>
            {{ $selectProyectos->render() }}

          </div>


          <div class="d-flex flex-column">
            <button class="mt-auto btn btn-success btn-sm mb-1" onclick="loadDashboardData()">
              <i class="fas fa-search"></i>
              Buscar
            </button>
          </div>


        </div>



      </div>
    </div>

  </div>



</div>

<div class="row">
  {{-- RESUMEN --}}

  <div class="col-12 col-lg-4">
    <div class="card header-card text-center fondo-oscuro">
      <div class="card-body px-3 p-2">
        <div class="">
          <b class="fontSize14">
            Resumen
          </b>
        </div>

        <div class=""> {{-- Documentos Emitidos --}}
          <span class="subtitulo">
            Documentos Emitidos
          </span>
          <div class="row  text-center">
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Hoy
                </div>

                <div class="valor" id="RESUMEN_emitidos_hoy">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Semana
                </div>

                <div class="valor" id="RESUMEN_emitidos_semana">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Mes
                </div>

                <div class="valor" id="RESUMEN_emitidos_mes">0</div>
              </div>
            </div>


          </div>
        </div>
        <div class=""> {{-- Documentos Aprobados --}}
          <span class="subtitulo">
            Documentos Aprobados
          </span>
          <div class="row  text-center">
            <div class="col-4">
              <div class="value-card fondo-verde">
                <div class="text-time">
                  Hoy
                </div>

                <div class="valor" id="RESUMEN_aprobados_hoy">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-verde">
                <div class="text-time">
                  Semana
                </div>

                <div class="valor" id="RESUMEN_aprobados_semana">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-verde">
                <div class="text-time">
                  Mes
                </div>

                <div class="valor" id="RESUMEN_aprobados_mes">0</div>
              </div>
            </div>


          </div>
        </div>


      </div>
    </div>

  </div>




  {{-- SOF --}}
  <div class="col-12 col-lg-2">
    <div class="card header-card text-center">
      <div class="card-body px-3 p-2">
        <div class="">
          <b class="fontSize14">
            Solicitudes de Fondos
          </b>
        </div>

        <div class=""> {{-- Documentos Emitidos --}}
          <span class="subtitulo">
            Emitidas
          </span>
          <div class="row  text-center">
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Hoy
                </div>

                <div class="valor" id="SOL_emitidos_hoy">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Semana
                </div>

                <div class="valor" id="SOL_emitidos_semana">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Mes
                </div>

                <div class="valor" id="SOL_emitidos_mes">0</div>
              </div>
            </div>


          </div>
        </div>
        <div class=""> {{-- Documentos Aprobados --}}
          <span class="subtitulo">
            Aprobadas
          </span>
          <div class="row  text-center">
            <div class="col-4">
              <div class="value-card fondo-verde">
                <div class="text-time">
                  Hoy
                </div>

                <div class="valor" id="SOL_aprobados_hoy">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-verde">
                <div class="text-time">
                  Semana
                </div>

                <div class="valor" id="SOL_aprobados_semana">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-verde">
                <div class="text-time">
                  Mes
                </div>

                <div class="valor" id="SOL_aprobados_mes">0</div>
              </div>
            </div>


          </div>
        </div>


      </div>
    </div>





  </div>

  {{-- REN --}}
  <div class="col-12 col-lg-2">
    <div class="card header-card text-center">
      <div class="card-body px-3 p-2">
        <div class="">
          <b class="fontSize14">
            Rendiciones de Gastos
          </b>
        </div>

        <div class=""> {{-- Documentos Emitidos --}}
          <span class="subtitulo">
            Emitidas
          </span>
          <div class="row  text-center">
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Hoy
                </div>

                <div class="valor" id="REN_emitidos_hoy">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Semana
                </div>

                <div class="valor" id="REN_emitidos_semana">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Mes
                </div>

                <div class="valor" id="REN_emitidos_mes">0</div>
              </div>
            </div>


          </div>
        </div>



      </div>
    </div>





  </div>

  {{-- REP --}}
  <div class="col-12 col-lg-2">
    <div class="card header-card text-center">
      <div class="card-body px-3 p-2">
        <div class="">
          <b class="fontSize14">
            Reposiciones de Gastos
          </b>
        </div>

        <div class=""> {{-- Do  --}}
          <span class="subtitulo">
            Emitidas
          </span>
          <div class="row  text-center">
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Hoy
                </div>

                <div class="valor" id="REP_emitidos_hoy">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Semana
                </div>

                <div class="valor" id="REP_emitidos_semana">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Mes
                </div>

                <div class="valor" id="REP_emitidos_mes">0</div>
              </div>
            </div>


          </div>
        </div>
        <div class=""> {{--  os --}}
          <span class="subtitulo">
            Aprobadas
          </span>
          <div class="row  text-center">
            <div class="col-4">
              <div class="value-card fondo-verde">
                <div class="text-time">
                  Hoy
                </div>

                <div class="valor" id="REP_aprobados_hoy">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-verde">
                <div class="text-time">
                  Semana
                </div>

                <div class="valor" id="REP_aprobados_semana">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-verde">
                <div class="text-time">
                  Mes
                </div>

                <div class="valor" id="REP_aprobados_mes">0</div>
              </div>
            </div>


          </div>
        </div>


      </div>
    </div>





  </div>
  <div class="col-12 col-lg-2">
    <div class="card header-card text-center">
      <div class="card-body px-3 p-2">
        <div class="">
          <b class="fontSize14">
            Requerimientos de ByS
          </b>
        </div>

        <div class=""> {{-- Documentos Emitidos --}}
          <span class="subtitulo">
            Emitidos
          </span>
          <div class="row  text-center">
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Hoy
                </div>

                <div class="valor" id="REQ_emitidos_hoy">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Semana
                </div>

                <div class="valor" id="REQ_emitidos_semana">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-celeste">
                <div class="text-time">
                  Mes
                </div>

                <div class="valor" id="REQ_emitidos_mes">0</div>
              </div>
            </div>


          </div>
        </div>
        <div class=""> {{-- Documentos Aprobados --}}
          <span class="subtitulo">
            Aprobados
          </span>
          <div class="row  text-center">
            <div class="col-4">
              <div class="value-card fondo-verde">
                <div class="text-time">
                  Hoy
                </div>

                <div class="valor" id="REQ_aprobados_hoy">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-verde">
                <div class="text-time">
                  Semana
                </div>

                <div class="valor" id="REQ_aprobados_semana">0</div>
              </div>
            </div>
            <div class="col-4">
              <div class="value-card fondo-verde">
                <div class="text-time">
                  Mes
                </div>

                <div class="valor" id="REQ_aprobados_mes">0</div>
              </div>
            </div>


          </div>
        </div>


      </div>
    </div>





  </div>



</div>





{{-- HISTORICO DE EMITIDOS --}}
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex">
        <div>
          <h3 class="m-1">
            Total de documentos emitidos
          </h3>
        </div>
        <div class="d-flex flex-column">
          <span class="fontSize10 mt-auto">
            (SOF+REN+REP+REQ)
          </span>
        </div>

      </div>
      <div id="grafico_historico_emitidos"></div>
    </div>

  </div>






  <div class="col-12 col-lg-6">
    <div class="card">
      <div class="card-header">
        <b class="fontSize15">
          Solicitudes de Fondos
        </b>
      </div>


      <div class="card-body">
        <b>
          Emitidos
        </b>
        <div id="grafico_historico_sol_emitidos"></div>
        <b>
          Montos
        </b>
        <div id="grafico_historico_sol_montos"></div>

      </div>


    </div>
  </div>


  <div class="col-12 col-lg-6">
    <div class="card">
      <div class="card-header">
        <b class="fontSize15">
          Rendiciones de Gastos
        </b>
      </div>

      <div class="card-body">
        <b>
          Emitidos
        </b>
        <div id="grafico_historico_ren_emitidos"></div>
        <b>
          Montos
        </b>
        <div id="grafico_historico_ren_montos"></div>

      </div>


    </div>

  </div>


  <div class="col-12 col-lg-6">
    <div class="card">
      <div class="card-header">
        <b class="fontSize15">
          Reposiciones de Gastos
        </b>
      </div>
      <div class="card-body">
        <b>
          Emitidos
        </b>
        <div id="grafico_historico_rep_emitidos"></div>
        <b>
          Montos
        </b>
        <div id="grafico_historico_rep_montos"></div>

      </div>
    </div>

  </div>


  <div class="col-12 col-lg-6">
    <div class="card">
      <div class="card-header">
        <b class="fontSize15">
          Requerimientos de Bienes y Servicios
        </b>
      </div>
      <div class="card-body">

        <div id="grafico_historico_req"></div>
      </div>
    </div>
  </div>









</div>



<div class="ml-auto mt-2">
  <a class="btn btn-sm btn-primary text-white" onclick="imprimir()" id="download" title="Descargar Reporte en PDF">
    <i class="fas fa-download"></i>
    Descargar reporte en PDF
  </a>
</div>


@endsection

@section('script')
@include('Layout.ValidatorJS')





<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="/plugins/chart.js/Chart.min.js"></script>
<script>
  // https://www.chartjs.org/docs/2.9.4/charts/bar.html
  const pieOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: true
    },
  }

  const InputCodsProyectos = document.getElementsByName('codsProyectos')[0]

  $(document).ready(function() {

    loadDashboardData();

  });


  function loadDashboardData() {

    url = "/GestionProyectos/getDashboardInfo?codsProyectos=" + InputCodsProyectos.value;;
    formData = {
      codsProyectos: InputCodsProyectos.value
    }

    request = {
      method: "GET",
      headers: {
        'Content-Type': 'application/json'
      },

    }
    $(".loader").show();
    maracFetch(url, request, function(objetoRespuesta) {

      console.log(objetoRespuesta);
      imprimirValoresEnDashboard(objetoRespuesta);

      $(".loader").fadeOut("slow");

    })



  }

  function imprimirValoresEnDashboard(object) {



    document.getElementById('RESUMEN_emitidos_hoy').innerHTML = object.RESUMEN.cant_docs_emitidos_dia
    document.getElementById('RESUMEN_emitidos_semana').innerHTML = object.RESUMEN.cant_docs_emitidos_semana
    document.getElementById('RESUMEN_emitidos_mes').innerHTML = object.RESUMEN.cant_docs_emitidos_mes

    document.getElementById('RESUMEN_aprobados_hoy').innerHTML = object.RESUMEN.cant_docs_aprobados_dia
    document.getElementById('RESUMEN_aprobados_semana').innerHTML = object.RESUMEN.cant_docs_aprobados_semana
    document.getElementById('RESUMEN_aprobados_mes').innerHTML = object.RESUMEN.cant_docs_aprobados_mes

    document.getElementById('SOL_emitidos_hoy').innerHTML = object.SOL.cant_emitidos_dia
    document.getElementById('SOL_emitidos_semana').innerHTML = object.SOL.cant_emitidos_semana
    document.getElementById('SOL_emitidos_mes').innerHTML = object.SOL.cant_emitidos_mes
    document.getElementById('SOL_aprobados_hoy').innerHTML = object.SOL.cant_aprobados_dia
    document.getElementById('SOL_aprobados_semana').innerHTML = object.SOL.cant_aprobados_semana
    document.getElementById('SOL_aprobados_mes').innerHTML = object.SOL.cant_aprobados_mes

    document.getElementById('REN_emitidos_hoy').innerHTML = object.REN.cant_emitidos_dia
    document.getElementById('REN_emitidos_semana').innerHTML = object.REN.cant_emitidos_semana
    document.getElementById('REN_emitidos_mes').innerHTML = object.REN.cant_emitidos_mes
    //document.getElementById('REN_aprobados_hoy').innerHTML = object.REN.cant_aprobados_dia
    //document.getElementById('REN_aprobados_semana').innerHTML = object.REN.cant_aprobados_semana
    //document.getElementById('REN_aprobados_mes').innerHTML = object.REN.cant_aprobados_mes

    document.getElementById('REP_emitidos_hoy').innerHTML = object.REP.cant_emitidos_dia
    document.getElementById('REP_emitidos_semana').innerHTML = object.REP.cant_emitidos_semana
    document.getElementById('REP_emitidos_mes').innerHTML = object.REP.cant_emitidos_mes
    document.getElementById('REP_aprobados_hoy').innerHTML = object.REP.cant_aprobados_dia
    document.getElementById('REP_aprobados_semana').innerHTML = object.REP.cant_aprobados_semana
    document.getElementById('REP_aprobados_mes').innerHTML = object.REP.cant_aprobados_mes


    document.getElementById('REQ_emitidos_hoy').innerHTML = object.REQ.cant_emitidos_dia
    document.getElementById('REQ_emitidos_semana').innerHTML = object.REQ.cant_emitidos_semana
    document.getElementById('REQ_emitidos_mes').innerHTML = object.REQ.cant_emitidos_mes
    document.getElementById('REQ_aprobados_hoy').innerHTML = object.REQ.cant_aprobados_dia
    document.getElementById('REQ_aprobados_semana').innerHTML = object.REQ.cant_aprobados_semana
    document.getElementById('REQ_aprobados_mes').innerHTML = object.REQ.cant_aprobados_mes
    dibujarGraficosLineas(object);
  }






  function imprimir() {
    console.log("Imprimiendo");
    window.print();

  }

  /* FUNCIONES GRÁFICO */
  const GraficoHistoricoEmitidos = document.getElementById('grafico_historico_emitidos');
  const GraficoHistoricoSOLEmitidos = document.getElementById('grafico_historico_sol_emitidos');
  const GraficoHistoricoSOLMontos = document.getElementById('grafico_historico_sol_montos');

  const GraficoHistoricoRENMontos = document.getElementById('grafico_historico_ren_montos');
  const GraficoHistoricoRENEmitidos = document.getElementById('grafico_historico_ren_emitidos');

  const GraficoHistoricoREPEmitidos = document.getElementById('grafico_historico_rep_emitidos');
  const GraficoHistoricoREPMontos = document.getElementById('grafico_historico_rep_montos');




  const GraficoHistoricoREQ = document.getElementById('grafico_historico_req');


  function dibujarGraficosLineas(receivedData) {

    GraficoHistoricoEmitidos.innerHTML = "";
    GraficoHistoricoSOLEmitidos.innerHTML = "";
    GraficoHistoricoSOLMontos.innerHTML = "";

    GraficoHistoricoRENMontos.innerHTML = "";
    GraficoHistoricoRENEmitidos.innerHTML = "";

    GraficoHistoricoREPEmitidos.innerHTML = "";
    GraficoHistoricoREPMontos.innerHTML = "";


    GraficoHistoricoREQ.innerHTML = "";

    var dataResumen = receivedData.RESUMEN.cant_docs_historico
    new Morris.Line({
      element: 'grafico_historico_emitidos',
      data: dataResumen,
      xkey: 'fecha',
      ykeys: ['cantidad_emitidos'],
      labels: ['Documentos emitidos'],
      resize: true,
      lineColors: ['#C14D9F'],
      lineWidth: 1,
      dateFormat: formatearFechaAEspañol
    });


    /*



    #
    #
    #


    */

    var dataSOL = receivedData.SOL.cant_emitidos_historico
    new Morris.Line({
      element: 'grafico_historico_sol_emitidos',
      data: dataSOL,
      xkey: 'fecha',
      ykeys: ['cantidad_docs'],
      labels: ['Emitidos'],
      resize: true,
      lineColors: ['#28a745'],
      lineWidth: 1,
      dateFormat: formatearFechaAEspañol
    });

    new Morris.Line({
      element: 'grafico_historico_sol_montos',
      data: dataSOL,
      xkey: 'fecha',
      ykeys: ['monto_total'],
      labels: ['Monto'],
      resize: true,
      lineColors: ['#17a2b8'],
      lineWidth: 1,
      dateFormat: formatearFechaAEspañol
    });



    var dataREN = receivedData.REN.cant_emitidos_historico
    new Morris.Line({
      element: 'grafico_historico_ren_montos',
      data: dataREN,
      xkey: 'fecha',
      ykeys: ['monto_total'],
      labels: ['Monto'],
      resize: true,
      lineColors: ['#1e8bff'],
      lineWidth: 1,
      dateFormat: formatearFechaAEspañol
    });
    new Morris.Line({
      element: 'grafico_historico_ren_emitidos',
      data: dataREN,
      xkey: 'fecha',
      ykeys: ['cantidad_docs'],
      labels: ['Documentos emitidos'],
      resize: true,
      lineColors: ['#1e8bff'],
      lineWidth: 1,
      dateFormat: formatearFechaAEspañol
    });


    var dataREP = receivedData.REP.cant_emitidos_historico
    new Morris.Line({
      element: 'grafico_historico_rep_emitidos',
      data: dataREP,
      xkey: 'fecha',
      ykeys: ['cantidad_docs'],
      labels: ['Documentos emitidos'],
      resize: true,
      lineColors: ['#C14D9F'],
      lineWidth: 1,
      dateFormat: formatearFechaAEspañol
    });
    new Morris.Line({
      element: 'grafico_historico_rep_montos',
      data: dataREP,
      xkey: 'fecha',
      ykeys: ['monto_total'],
      labels: ['Monto'],
      resize: true,
      lineColors: ['#dc3545'],
      lineWidth: 1,
      dateFormat: formatearFechaAEspañol
    });


    var dataREQ = receivedData.REQ.cant_emitidos_historico
    new Morris.Line({
      element: 'grafico_historico_req',
      data: dataREQ,
      xkey: 'fecha',
      ykeys: ['cantidad_docs'],
      labels: ['Documentos emitidos'],
      resize: true,
      lineColors: ['#4b94c0'],
      lineWidth: 1,
      dateFormat: formatearFechaAEspañol
    });




  }
</script>
@endsection
