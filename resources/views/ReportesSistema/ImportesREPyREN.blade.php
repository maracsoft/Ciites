@extends('Layout.Plantilla') 

@section('titulo')
    Reporte Importes de Reposicion por Meses
@endsection

@section('contenido')
<style>
    .proyectado{
        background-color: rgb(255, 233, 233);
    }
</style>

    <br>

    @include('Layout.MensajeEmergenteDatos')
    


    <a class="btn btn-primary" onclick="imprimir()">
        Exportar a PDF
    </a>

    <form id="formBuscar" name="formBuscar" action="" method="GET">


        <div class="row m-2">
            <div class="col"></div>
            <div class="col">
                <label for="">Fecha inicio</label>
            </div>
            
            
            
            
            <div class="col">
                
                <select class="form-control" name="inicio_año" id="inicio_año">
                    <option value="-1">- Año -</option>
                    @foreach ($listaAños as $año)

                        <option value="{{$año}}"
                        @if($inicio_año == $año) selected @endif
                        >
                            {{$año}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <select class="form-control" name="inicio_mes" id="inicio_mes">
                    <option value="-1">- Mes -</option>
                    @foreach ($listaMeses as $mes)
                        <option value="{{$mes->codDosDig}}"
                            @if($mes->codDosDig == $inicio_mes) selected @endif
                            >
                            {{$mes->nombre}}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="col"></div>

        </div>
 


        <div class="row m-2">
            <div class="col"></div>
            <div class="col">
                <label for="">Fecha Fin</label>
            </div>
           
            <div class="col">
                
                <select class="form-control" name="fin_año" id="fin_año">
                    <option value="-1">- Año -</option>
                    @foreach ($listaAños as $año)
                        <option value="{{$año}}"
                        
                        @if($fin_año == $año) selected @endif
                        >
                            {{$año}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <select class="form-control" name="fin_mes" id="fin_mes">
                    <option value="-1">- Mes -</option>
                    @foreach ($listaMeses as $mes)
                        <option value="{{$mes->codDosDig}}"
                            @if($mes->codDosDig == $fin_mes) selected @endif
                            >
                            {{$mes->nombre}}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="col">
                <button class="btn btn-primary btn-sm" type="button" onclick="clickBuscar()">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
                <a class="btn btn-primary btn-sm" href="{{route('Reportes.Ver.ImportesREPyREN')}}">
                    <i class="fas fa-search"></i>
                    Sin filtros
                </a>
            </div>

        </div>
 

    </form>


    <div class="row"> {{-- GRAFICO --}}

        <div class="col-md">
    
          <div id="table1"></div>  
    
        </div>
    
    
      </div>

    <table  class="table table-hover">
        <thead>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Año Mes
                </th>
                <th>
                    REP
                </th>
                <th>
                    REN
                </th>
                <th>
                    Total
                </th>
                <th>
                    Total proyectado
                </th>
                
            </tr>
        </thead>

        <tbody>
            @foreach ($vectorAImprimir as $dato)


                <tr class='@if($dato['Total']==0 )proyectado @endif'>
                    <td>
                        
                        {{$dato['index']}}
                    </td>
                    <td>
                        {{$dato['mes-anio']}}
                    </td>
                    <td>
                        {{$dato['REP']}}
                    </td>
                   
                    <td>
                        {{$dato['REN']}}
                    </td>
                   
                    <td>
                        {{$dato['Total']}}
                    </td>
                   
                    <td>
                        {{$dato['TotalProyectado']}}
                    </td>
                   
                    
                    
                </tr>
            @endforeach
           
        </tbody>
    </table>
    

 

@endsection


@section('script')
@include('Layout.ValidatorJS')

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

<link rel="stylesheet" href="/libs/morris.css">
<script src="/libs/morris.min.js" charset="utf-8"></script>


<script>

    datosArray = <?php echo json_encode($vectorAImprimir); ?>

    $(document).ready(function(){
        
        new Morris.Line({//META - EJECUTADA
            element: 'table1',
            data: datosArray,
            xkey: 'mes-anio',
            ykeys: ['REN','REP','Total','TotalProyectado'],
            labels: ['REN','REP','Total','Total Proyectado'],
            resize: true,
            lineColors: ['#C14D9F','#FF1510','#B1FF33','FFAF52'],
            lineWidth: 1
        });  
    });

    function clickBuscar(){

        msj = validarBusqueda();
        if(msj!=""){
            alerta(msj);
            return;
        }


        document.formBuscar.submit();



    }

    function validarBusqueda(){
        msj ="";

        msj = validarSelect(msj,"inicio_año","-1","Año inicio");
        msj = validarSelect(msj,"inicio_mes","-1","Mes inicio");
        msj = validarSelect(msj,"fin_año","-1","Año final");
        msj = validarSelect(msj,"fin_mes","-1","Mes final");
        
        return msj;


    }



    function imprimir(){
        console.log("Imprimiendo");
        window.print();

    }


</script>
@endsection
