@extends('Layout.Plantilla')

@section('titulo')
    Reporte - Total por proyecto
@endsection

@section('contenido')
 
@include('Layout.MensajeEmergenteDatos')

@php
   
    $estilosGrafico =  "
    max-height: 450px;
    display: block; ";

     

 

@endphp
<div class="pt-2">

  <div class="titulo-dash text-center my-1 mx-2">
    <b class="fontSize18">
      Dashboard CITE
    </b>
  </div>

</div>
<div class="row">
  <div class="col-lg-4 col-12 d-flex">
      
    <img src="/img/usuario.png" class="my-auto dash-perfil-img img-circle elevation-2 ml-3" alt="User Image">
    <div class="d-flex flex-column ml-2 my-auto">

      <div class="fontSize14">
        <b>
          Bienvenid{{$empLogeado->getLetraSegunSexo()}}, {{$empLogeado->getNombreCompleto()}}

        </b>
      </div>
      
      <div class="fontSize12  mt-n1">
        Estamos felices de verte de nuevo.
      </div>
    
    </div>

  </div>
  <div class="col-lg-8 col-12">
    <div class="card">
      <form action="{{route('CITE.Dashboard.Ver')}}" method="GET" name="formFiltros">

        <div class="card-body p-2">
          <div class=" d-flex flex-wrap">
            
            <div class="d-flex flex-column mx-3" title="Aplique filtros para mejorar la presición de su información">
              <i class="my-auto fas fa-filter fa-2x"></i>
            </div>

            <div>
              <b for="">
                Filtros:
              </b>

              <div class="d-flex">

                <div class="">
                  @php
                  
                    $selectMult = new App\UI\UISelectMultiple([],$codsCadena,'codsCadena',"Buscar por Cadena",false,30,12);
                    $selectMult->setOptionsWithModel($listaCadenas,'nombre');
                  @endphp

                  {{$selectMult->render()}}
                
                </div>
              </div>
              <div class="d-flex">


                <div class="input-group date form_date mr-1" data-date-format="dd/mm/yyyy" data-provide="datepicker">
                  <input type="text" class="form-control form-controlw-date text-center" id="fechaInicio" name="fechaInicio" value="{{$fechaInicio}}" placeholder="Inicio">
                  <div class="input-group-btn d-flex flex-col align-items-center">                                        
                      <button class="btn btn-primary btn-sm date-set" type="button">
                        <i class="fa fa-calendar"></i>
                      </button>
                  </div>
                </div>
                
                <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                  <input type="text" class="form-control form-control w-date text-center" id="fechaTermino" name="fechaTermino" value="{{$fechaTermino}}" placeholder="Fin">
                  <div class="input-group-btn d-flex flex-col align-items-center">                                        
                      <button class="btn btn-primary btn-sm date-set" type="button">
                        <i class="fa fa-calendar"></i>
                      </button>
                  </div>
                </div>


                    
                <div class="ml-3 d-flex flex-column">
                  <button type="button" class="ml-1 mt-auto btn btn-success btn-sm mb-1 d-flex" onclick="clickBuscar()">
                    <i class="fas fa-search my-auto mr-1"></i>
                    Buscar
                  </button>
                  
                </div>
                <a class="ml-1 btn btn-success btn-sm d-flex" href="{{route('CITE.Dashboard.Ver')}}">
                  <i class="fas fa-trash my-auto"></i>
                </a>
              
              </div>
              
            </div>

          
          
              
          </div>

      

        </div>

      </form>
    </div>

  </div>



</div>
 

<div class="d-flex flex-row">

    <div class="ml-auto mb-2">
        <a class="btn btn-sm btn-primary text-white" onclick="imprimir()" id="download">
            <i class="fas fa-file-pdf"></i>
            Descargar en PDF
        </a>
    </div>


</div>


<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header d-flex flex-row">

                <div class="">
                    <h3 class="m-1">
                        Servicios por Región
                    </h3>
                </div>


            </div>
            <div class="card-body">

                <canvas id="serviciosPorRegion" style="{{$estilosGrafico}}" class="chartjs-render-monitor">
                </canvas>

                <div class="mt-2">

                    @php $desplegable = new App\UI\UIDesplegable('Ver Datos',false);  @endphp
                    {{$desplegable->renderOpen()}}

                    <div class="m-2">
                        <table class="table hable-hover table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" scope="col">Región</th>
                                    <th class="text-center" scope="col">Cantidad de servicios</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($serviciosPorRegion_obj['listaRegiones'] as $region)
                                <tr>
                                    <td class="text-center">
                                        {{$region->region}}
                                    </td>
                                    <td class="text-center">
                                        {{$region->cantidad}}
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    {{$desplegable->renderClose()}}

                </div>
            </div>

        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header d-flex flex-row">

                <div class="">
                    <h3 class="m-1">
                        Servicios por Provincia
                    </h3>
                </div>

            </div>
            <div class="card-body">
               
                   
                <canvas id="serviciosPorProvincia" style="{{$estilosGrafico}}" class="chartjs-render-monitor">
                </canvas>

                 
                <div class="mt-2">

                    @php $desplegable = new App\UI\UIDesplegable('Ver Datos',false);  @endphp
                    {{$desplegable->renderOpen()}}

                    <div class="m-2">
                        <table class="table hable-hover table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" scope="col">Region / Provincia</th>
                                    <th class="text-center" scope="col">Cantidad de servicios</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($serviciosPorProvincia_obj['listaProvincias'] as $provincia)
                                <tr>
                                    <td class="text-center">
                                        {{$provincia->departamento}} / {{$provincia->provincia}}
                                    </td>
                                    <td class="text-center">
                                        {{$provincia->cantidad}}
                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    {{$desplegable->renderClose()}}

                </div>
            </div>

        </div>
    </div>

    <div class="col-sm-6">
      <div class="card">
          <div class="card-header d-flex flex-row">

              <div class="">
                  <h3 class="m-1">
                      Servicios por Actividad
                  </h3>
              </div>

          </div>
          <div class="card-body">
             
                 
              <canvas id="serviciosPorActividad" style="{{$estilosGrafico}}" class="chartjs-render-monitor">
              </canvas>

              <div class="mt-2">

                  @php $desplegable = new App\UI\UIDesplegable('Ver Datos',false);  @endphp
                  {{$desplegable->renderOpen()}}

                  <div class="m-2">
                      <table class="table hable-hover table-sm">
                          <thead class="thead-dark">
                              <tr>
                                  <th class="text-center" scope="col">Actividad</th>
                                  <th class="text-center" scope="col">Cantidad de servicios</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($serviciosPorActividad_obj['listaActividades'] as $actividad)
                              <tr>
                                  <td class="text-center">
                                      {{$actividad->nombre}}
                                  </td>
                                  <td class="text-center">
                                      {{$actividad->cantidad}}
                                  </td>
                              </tr>

                              @endforeach

                          </tbody>
                      </table>
                  </div>

                  {{$desplegable->renderClose()}}

              </div>
          </div>

      </div>
    </div>



    <div class="col-sm-6">
      <div class="card">
          <div class="card-header d-flex flex-row">

              <div class="">
                  <h3 class="m-1">
                      Servicios por Cadena
                  </h3>
              </div>

          </div>
          <div class="card-body">
             
                 
              <canvas id="serviciosPorCadena" style="{{$estilosGrafico}}" class="chartjs-render-monitor">
              </canvas>

              <div class="mt-2">

                  @php $desplegable = new App\UI\UIDesplegable('Ver Datos',false);  @endphp
                  {{$desplegable->renderOpen()}}

                  <div class="m-2">
                      <table class="table hable-hover table-sm">
                          <thead class="thead-dark">
                              <tr>
                                  <th class="text-center" scope="col">Actividad</th>
                                  <th class="text-center" scope="col">Cantidad de servicios</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($serviciosPorCadena_obj['listaCadenas'] as $cadena)
                              <tr>
                                  <td class="text-center">
                                      {{$cadena->nombre}}
                                  </td>
                                  <td class="text-center">
                                      {{$cadena->cantidad}}
                                  </td>
                              </tr>

                              @endforeach

                          </tbody>
                      </table>
                  </div>

                  {{$desplegable->renderClose()}}

              </div>
          </div>

      </div>
    </div>



    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex flex-row">

                <div class="">
                    <h3 class="m-1">
                        Servicios por Unidad Productiva
                    </h3>
                </div>

            </div>
            <div class="card-body">
                <div class="text-center">
                    <canvas id="serviciosPorUnidad"  style="" class="chartjs-render-monitor text-center"></canvas>

                </div>
                <div class="mt-2">

                    @php $desplegable = new App\UI\UIDesplegable('Ver Datos',false);  @endphp
                    {{$desplegable->renderOpen()}}

                    <div class="m-2">
                        <table class="table hable-hover table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" scope="col">Razón Social</th>
                                    <th class="text-center" scope="col">Cantidad de servicios</th>
                                    <th class="text-center" scope="col">Horas Acumuladas</th>


                                </tr>
                            </thead>
                            <tbody>

                                @foreach($serviciosPorUnidad_obj['listaUnidades'] as $unid)
                                <tr>
                                    <td class="text-center">

                                        @if($unid->razonSocial=="")
                                            {{$unid->nombrePersona}}
                                        @else
                                            {{$unid->razonSocial}}
                                        @endif

                                    </td>
                                    <td class="text-center">
                                        {{$unid->CantidadServicios}}
                                    </td>
                                    <td class="text-center">
                                        {{number_format($unid->HorasAcumuladas,2)}}
                                    </td>

                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    {{$desplegable->renderClose()}}

                </div>
            </div>

        </div>


    </div>
    <div class="col-6">

    </div>

</div>

@endsection

@section('script')

@include('Layout.ValidatorJS')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="/plugins/chart.js/Chart.min.js"></script>
<script>
    // https://www.chartjs.org/docs/2.9.4/charts/bar.html
    const pieOptions  = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
            display: true
        },
    }

    function buildDataForPie(labels,valores,colores){
        return {
            labels: labels,
            datasets:
                [
                    {
                        data:valores,
                        backgroundColor : colores ,
                    }
                ]
        }
    }


    serviciosPorRegion_obj = @php echo json_encode($serviciosPorRegion_obj); @endphp

    var pieData_serviciosPorRegion = buildDataForPie(   serviciosPorRegion_obj.labels,
                                        serviciosPorRegion_obj.valores,
                                        serviciosPorRegion_obj.colores
                                    )

    var serviciosPorRegion = $('#serviciosPorRegion').get(0).getContext('2d')
    new Chart(serviciosPorRegion, {
        type: 'pie',
        data: pieData_serviciosPorRegion,
        options: pieOptions
    })



    serviciosPorActividad_obj = @json($serviciosPorActividad_obj)

    var pieData_serviciosPorActividad = buildDataForPie(   serviciosPorActividad_obj.labels,serviciosPorActividad_obj.valores,serviciosPorActividad_obj.colores)

    var serviciosPorActividad = $('#serviciosPorActividad').get(0).getContext('2d')
    new Chart(serviciosPorActividad, {
        type: 'pie',
        data: pieData_serviciosPorActividad,
        options: pieOptions
    })



    
    serviciosPorCadena_obj = @json($serviciosPorCadena_obj)

    var pieData_serviciosPorCadena = buildDataForPie(serviciosPorCadena_obj.labels,serviciosPorCadena_obj.valores,serviciosPorCadena_obj.colores)
    var serviciosPorCadena = $('#serviciosPorCadena').get(0).getContext('2d')
    new Chart(serviciosPorCadena, {
        type: 'pie',
        data: pieData_serviciosPorCadena,
        options: pieOptions
    })








    serviciosPorProvincia = @php echo json_encode($serviciosPorProvincia_obj); @endphp

    var pieData_serviciosPorProvincia = buildDataForPie( serviciosPorProvincia.labels,
                                            serviciosPorProvincia.valores,
                                            serviciosPorProvincia.colores
                                        )

    var serviciosPorProvincia = $('#serviciosPorProvincia').get(0).getContext('2d')
    new Chart(serviciosPorProvincia, {
        type: 'pie',
        data: pieData_serviciosPorProvincia,
        options: pieOptions
    })




    serviciosPorUnidad_obj = @php echo json_encode($serviciosPorUnidad_obj); @endphp


    var data_serviciosPorUnidad = buildDataForPie( serviciosPorUnidad_obj.labels,
                                                    serviciosPorUnidad_obj.valores_cantidadServicios,
                                                    serviciosPorUnidad_obj.colores,
                                                )

    var serviciosPorUnidad = document.getElementById("serviciosPorUnidad");
    var barChart = new Chart(serviciosPorUnidad, {
        type: 'horizontalBar',
        data: data_serviciosPorUnidad,
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }],
                xAxes:[{
                    ticks:{
                        fontColor:'white',
                        fontSize:5
                    }
                }]

            },
            legend: {

                display: false
            },
        },
    });











    function imprimir(){
        console.log("Imprimiendo");
        window.print();

    }

    function clickBuscar(){
      var msj = validarForm();
      if(msj != ""){
        alerta(msj)
        return;
      }

      document.formFiltros.submit();
    }

    function validarForm(){
      var msjError = "";
      limpiarEstilos(["fechaInicio","fechaTermino"])

      msjError = validarNulidad(msjError,'fechaInicio','Fecha de Inicio');
      msjError = validarNulidad(msjError,'fechaTermino','Fecha de Término');
      
      msjError = validarFechaAnterior(msjError,"fechaInicio","fechaTermino","La fecha de inicio debe ser anterior a la de término");
      
      return msjError;
    }




</script>


@endsection

@section('estilos')
<style>
  .fondo-oscuro{
    background-color: #c7e0e9;
 
    border-width: 1px;
  }
  .header-card .valor{
    font-size: 17pt;
    font-weight: 900;
  }

  .value-card{
    
    border-radius: 9px;
    padding: 4px;
  }
  .fondo-celeste{
    background-color: rgb(218 251 255);
  }

  .fondo-verde{
    background-color: rgb(220, 245, 220)
  }


  .value-card .text-time{
    font-size: 9pt;
    margin-bottom: -5px;

  }

  .subtitulo{
    color:#09301c;
    font-size: 12pt;
  }

  .dash-perfil-img{
    max-width: 50px;
    max-height: 50px
    
  }

  .icono-filtro{

  }
  .titulo-dash{
    background-color: #e6e6e6;
    border-radius: 5px;
    padding: 5px;

  }

</style>

@endsection
