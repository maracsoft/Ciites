@extends('Layout.Plantilla') 

@section('titulo')
    Reporte - Total por proyecto
@endsection

@section('contenido')
<br>

@include('Layout.MensajeEmergenteDatos')

<div class="card">
    <div class="card-body">
        <div class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand">
                <div class=""></div>
            </div>
            <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
            </div>
        </div>
        <canvas id="pieProyectos" style="min-height: 400px; height: 400px;  max-height: 500px; 
                                        max-width: 100%; display: block; width: 604px;" 
                                         class="chartjs-render-monitor"></canvas>
    </div>

</div>
<div class="card">
    
    <h3 class="m-1">
        Reporte - Total por proyecto
        {{-- 
        <a target="_blank" href="{{route('Reportes.PDF.ImportesREPporProyectos')}}" class="btn btn-info">
            <i class="fas fa-file-pdf"></i>
            Ver PDF
        </a>
         --}}
        <a class="btn btn-primary" onclick="imprimir()" id="download">
            Descargar en PDF
        </a>


    </h3>
    

    

    <!-- /.card-header -->
    <div class="card-body p-0">
      <table class="table table-sm">
        <thead>

          <tr>
           
            <th scope="col">Proyecto</th>
            <th scope="col">Importe</th>
          
             
          </tr>

        </thead>
        <tbody>

          @foreach($listaProyectos as $proyecto)
             <tr>
                <td>
                    {{$proyecto->Proyecto}}
                </td>
                <td>
                    {{$proyecto->Total}}
                </td>
             </tr>

          @endforeach

        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  
  <!-- /.card -->
 

@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="/plugins/chart.js/Chart.min.js"></script>
<script>

    listaLabels = @php echo json_encode($labels); @endphp 
    listaValores =  @php echo json_encode($valores); @endphp 
    listaColores =  @php echo json_encode($colores); @endphp 
 
        //-------------
        //- PIE CHART -
        //-------------
        var pieDataProyectos        = {
            labels: listaLabels,
                datasets: [
                    {
                        data: listaValores,
                        backgroundColor : listaColores ,
                    }
                ]
            }
   



    var pieOptions     = {
            maintainAspectRatio : false,
            responsive : true,
            legend: {
                display: true
            },
        }

    
    var pieProyectos = $('#pieProyectos').get(0).getContext('2d')
    new Chart(pieProyectos, {
            type: 'pie',
            data: pieDataProyectos,
            options: pieOptions
        })

  



    function imprimir(){
        console.log("Imprimiendo");
        window.print();

    }


 



</script>

@endsection
 
 