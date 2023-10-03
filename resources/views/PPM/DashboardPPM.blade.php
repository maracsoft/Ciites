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
      Dashboard PPM
    </b>
  </div>

</div>
<div class="row">
  <div class="col-lg-6 col-12 d-flex">
      
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
  <div class="col-lg-6 col-12">
    <div class="card">
      <form action="{{route('PPM.Dashboard.Ver')}}" method="GET" name="formFiltros">

        <div class="card-body p-2">
          <div class=" d-flex flex-wrap">
            
            <div class="d-flex flex-column mx-3" title="Aplique filtros para mejorar la presición de su información">
              <i class="my-auto fas fa-filter fa-2x"></i>
            </div>

            <div>
              <b for="">
                Filtros:
              </b>
                    
              <div class="d-flex flex-row">

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

                <div class="px-1">
                  <select class="form-control form-control-sm" name="codActividadEconomica" id="codActividadEconomica">
                    <option value="">- Actividad Económica -</option>
                    @foreach($listaActividadesEcon as $activ)
                      <option value="{{$activ->getId()}}" {{$activ->isThisSelected($codActividadEconomica)}}>
                        {{$activ->nombre}}
                      </option>
                    @endforeach
                  </select>
                </div>

                    
                <div class="ml-3 d-flex flex-column">
                  <button type="button" class="ml-1 mt-auto btn btn-success btn-sm mb-1 d-flex" onclick="clickBuscar()">
                    <i class="fas fa-search my-auto mr-1"></i>
                    Buscar
                  </button>
                  
                </div>
                <a class="ml-1 btn btn-success btn-sm d-flex" href="{{route('PPM.Dashboard.Ver')}}">
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
                      Ejecuciones por Actividad
                  </h3>
              </div>


          </div>
          <div class="card-body">

              <canvas id="ejecucionesPorActividad" style="{{$estilosGrafico}}" class="chartjs-render-monitor">
              </canvas>

              <div class="mt-2">

                  @php $desplegable = new App\UI\UIDesplegable('Ver Datos',false);  @endphp
                  {{$desplegable->renderOpen()}}

                  <div class="m-2">
                      <table class="table hable-hover table-sm">
                          <thead class="thead-dark">
                              <tr>
                                  <th class="text-center" scope="col">Actividad</th>
                                  <th class="text-center" scope="col">Cantidad de Ejecuciones</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($ejecucionesPorActividad_obj['listaActividades'] as $actividad)
                              <tr>
                                  <td class="text-center">
                                      {{$actividad->actividad}}
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
                      Ejecuciones por Objetivo
                  </h3>
              </div>


          </div>
          <div class="card-body">

              <canvas id="ejecucionesPorObjetivo" style="{{$estilosGrafico}}" class="chartjs-render-monitor">
              </canvas>

              <div class="mt-2">

                  @php $desplegable = new App\UI\UIDesplegable('Ver Datos',false);  @endphp
                  {{$desplegable->renderOpen()}}

                  <div class="m-2">
                      <table class="table hable-hover table-sm">
                          <thead class="thead-dark">
                              <tr>
                                  <th class="text-center" scope="col">Objetivo</th>
                                  <th class="text-center" scope="col">Cantidad de Ejecuciones</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($ejecucionesPorObjetivo_obj['listaObjetivos'] as $objetivo)
                              <tr>
                                  <td class="text-center">
                                      {{$objetivo->indice}}. {{$objetivo->objetivo_completo}}
                                  </td>
                                  <td class="text-center">
                                      {{$objetivo->cantidad}}
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
                        Ejecuciones por Región
                    </h3>
                </div>


            </div>
            <div class="card-body">

                <canvas id="ejecucionesPorRegion" style="{{$estilosGrafico}}" class="chartjs-render-monitor">
                </canvas>

                <div class="mt-2">

                    @php $desplegable = new App\UI\UIDesplegable('Ver Datos',false);  @endphp
                    {{$desplegable->renderOpen()}}

                    <div class="m-2">
                        <table class="table hable-hover table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" scope="col">Región</th>
                                    <th class="text-center" scope="col">Cantidad de Ejecuciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ejecucionesPorRegion_obj['listaRegiones'] as $region)
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
                        Ejecuciones por Provincia
                    </h3>
                </div>

            </div>
            <div class="card-body">
               
                   
                <canvas id="ejecucionesPorProvincia" style="{{$estilosGrafico}}" class="chartjs-render-monitor">
                </canvas>

                 
                <div class="mt-2">

                    @php $desplegable = new App\UI\UIDesplegable('Ver Datos',false);  @endphp
                    {{$desplegable->renderOpen()}}

                    <div class="m-2">
                        <table class="table hable-hover table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" scope="col">Region / Provincia</th>
                                    <th class="text-center" scope="col">Cantidad de Ejecuciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($ejecucionesPorProvincia_obj['listaProvincias'] as $provincia)
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

    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex flex-row">

                <div class="">
                    <h3 class="m-1">
                        Ejecuciones por Organización
                    </h3>
                </div>

            </div>
            <div class="card-body">
                <div class="text-center">
                    <canvas id="ejecucionesPorUnidad"  style="" class="chartjs-render-monitor text-center"></canvas>

                </div>
                <div class="mt-2">

                    @php $desplegable = new App\UI\UIDesplegable('Ver Datos',false);  @endphp
                    {{$desplegable->renderOpen()}}

                    <div class="m-2">
                        <table class="table hable-hover table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" scope="col">Razón Social</th>
                                    <th class="text-center" scope="col">Cantidad de Ejecuciones</th>
                                    


                                </tr>
                            </thead>
                            <tbody>

                                @foreach($ejecucionesPorUnidad_obj['listaUnidades'] as $unid)
                                <tr>
                                    <td class="text-center">

                                        
                                            {{$unid->razon_social}}
                                        

                                    </td>
                                    <td class="text-center">
                                        {{$unid->CantidadEjecuciones}}
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


    ejecucionesPorRegion_obj = @php echo json_encode($ejecucionesPorRegion_obj); @endphp

    var pieData_ejecucionesPorRegion = buildDataForPie(   ejecucionesPorRegion_obj.labels,
                                        ejecucionesPorRegion_obj.valores,
                                        ejecucionesPorRegion_obj.colores
                                    )

    var ejecucionesPorRegion = $('#ejecucionesPorRegion').get(0).getContext('2d')
    new Chart(ejecucionesPorRegion, {
        type: 'pie',
        data: pieData_ejecucionesPorRegion,
        options: pieOptions
    })



    ejecucionesPorActividad_obj = @php echo json_encode($ejecucionesPorActividad_obj); @endphp

    var pieData_ejecucionesPorActividad = buildDataForPie(   ejecucionesPorActividad_obj.labels,
                                        ejecucionesPorActividad_obj.valores,
                                        ejecucionesPorActividad_obj.colores
                                    )

    var ejecucionesPorActividad = $('#ejecucionesPorActividad').get(0).getContext('2d')
    new Chart(ejecucionesPorActividad, {
        type: 'pie',
        data: pieData_ejecucionesPorActividad,
        options: pieOptions
    })




    


    ejecucionesPorObjetivo_obj = @php echo json_encode($ejecucionesPorObjetivo_obj); @endphp
    
    var pieData_ejecucionesPorObjetivo = buildDataForPie(   ejecucionesPorObjetivo_obj.labels,
                                        ejecucionesPorObjetivo_obj.valores,
                                        ejecucionesPorObjetivo_obj.colores
                                    )

    var ejecucionesPorObjetivo = $('#ejecucionesPorObjetivo').get(0).getContext('2d')
    new Chart(ejecucionesPorObjetivo, {
        type: 'pie',
        data: pieData_ejecucionesPorObjetivo,
        options: pieOptions
    })
    ejecucionesPorObjetivo_obj






    ejecucionesPorProvincia = @php echo json_encode($ejecucionesPorProvincia_obj); @endphp

    var pieData_ejecucionesPorProvincia = buildDataForPie( ejecucionesPorProvincia.labels,
                                            ejecucionesPorProvincia.valores,
                                            ejecucionesPorProvincia.colores
                                        )

    var ejecucionesPorProvincia = $('#ejecucionesPorProvincia').get(0).getContext('2d')
    new Chart(ejecucionesPorProvincia, {
        type: 'pie',
        data: pieData_ejecucionesPorProvincia,
        options: pieOptions
    })




    ejecucionesPorUnidad_obj = @php echo json_encode($ejecucionesPorUnidad_obj); @endphp


    var data_ejecucionesPorUnidad = buildDataForPie( ejecucionesPorUnidad_obj.labels,
                                                    ejecucionesPorUnidad_obj.valores_CantidadEjecuciones,
                                                    ejecucionesPorUnidad_obj.colores,
                                                )

    var ejecucionesPorUnidad = document.getElementById("ejecucionesPorUnidad");
    var barChart = new Chart(ejecucionesPorUnidad, {
        type: 'horizontalBar',
        data: data_ejecucionesPorUnidad,
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
                        fontSize:5,
                        min:0
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
