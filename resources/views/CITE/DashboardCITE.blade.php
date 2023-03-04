@extends('Layout.Plantilla')

@section('titulo')
    Reporte - Total por proyecto
@endsection

@section('contenido')
<br>

@include('Layout.MensajeEmergenteDatos')

@php
    $estilosGrafico =  "height: 250px;
                        max-height: 250px;
                        display: block; ";
    $estilosGraficoDoble =  " height: 250px;
                        max-height: 300px; max-width:700px;
                        display: block;  ";


@endphp


    <div class="d-flex flex-row">

        <div class="ml-auto mb-2">
            <a class="btn btn-sm btn-primary text-white" onclick="imprimir()" id="download">
                <i class="fas fa-file-pdf"></i>
                Descargar en PDF
            </a>
        </div>


    </div>


<div class="row">
    <div class="col-6">
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

                    @php $desplegable = new App\UI\UIDesplegable('Ver Datos');  @endphp
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
    <div class="col-6">
        <div class="card">
            <div class="card-header d-flex flex-row">

                <div class="">
                    <h3 class="m-1">
                        Servicios por Provincia
                    </h3>
                </div>

            </div>
            <div class="card-body">
                <div class="px-6">
                    <form action="">
                        <div class="d-flex flex-row">


                            <div class="m-1">

                                <select id="codDepartamento" name="codDepartamento" data-select2-id="1" tabindex="-1"
                                    class="fondoBlanco form-control form-control-sm select2 select2-hidden-accessible selectpicker"   aria-hidden="true"  data-live-search="true">

                                    <option value="">- Filtro Región -</option>
                                    @foreach($listaDepartamentos as $dep)
                                        <option value="{{$dep->getId()}}"
                                            @if($codDepartamento == $dep->getId())
                                                selected
                                            @endif
                                            >
                                            {{$dep->nombre}}
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="m-1">
                                <button class="btn btn-success btn-sm" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>

                        </div>
                    </form>
                    <canvas id="serviciosPorProvincia" style="{{$estilosGrafico}}" class="chartjs-render-monitor">
                    </canvas>

                </div>
                <div class="mt-2">

                    @php $desplegable = new App\UI\UIDesplegable('Ver Datos');  @endphp
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

    <div class="col-12">
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
                    <canvas id="serviciosPorUnidad"  style="{{$estilosGraficoDoble}}" class="chartjs-render-monitor text-center"></canvas>

                </div>
                <div class="mt-2">

                    @php $desplegable = new App\UI\UIDesplegable('Ver Datos');  @endphp
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
        type: 'bar',
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






</script>

@endsection

