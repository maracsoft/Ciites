@extends('Layout.Plantilla')

@section('titulo')
    Reporte - Total por proyecto
@endsection

@section('contenido')
<br>
@section('tiempoEspera')
    <div class="loader" id="pantallaCarga"></div>
@endsection
@include('Layout.MensajeEmergenteDatos')

@php
    $estilosGrafico =  "height: 250px;
                        max-height: 250px;
                        display: block; ";
    $estilosGraficoDoble =  " height: 250px;
                        max-height: 300px; max-width:700px;
                        display: block;  ";


@endphp
<style>
    .celdaPloma{
        background-color: rgb(204, 204, 204);
    }
    .mesPintado{
        background-color: rgb(197, 211, 255);
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex flex-row">

                <div class="">
                    <h3 class="m-1">
                        Reportes mensuales del CITE
                    </h3>
                </div>


            </div>
            <div class="card-body">

                <table id="tablaDetallesLugares" class="table table-striped table-bordered table-condensed table-hover table-sm" 
                style='background-color:#FFFFFF;'> 
                    <thead class="thead-default filaFijada fondoAzul letrasBlancas" style="">
                        <tr>
                            <th rowspan="2" style="">
                                Miembro del equipo
                            </th>

                            @foreach($listaAños as $año)
                                <th colspan="12" class="text-center">
                                    {{$año}}
                                </th>    
                            @endforeach


                        </tr>
                        <tr>    
                            @foreach($listaAños as $año)
                            
                                @foreach($listaMeses as $mes)
                                    @php
                                        $añoActual = intval(date('Y'));
                                        $mesActual = intval(date('m'));
                                        $clase = "";
                                        if($añoActual > $año){
                                            $clase = "mesPintado";
                                        }else{
                                            if($añoActual == $año)
                                                if($mes->getId() <= $mesActual)
                                                    $clase = "mesPintado";    
                                        }
                                    @endphp
                                    <th class="{{$clase}}">
                                        {{$mes->abreviacion}}
                                    </th>
                                @endforeach
                                
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listaEmpleados as $empleado)
                            <tr>
                                <td>
                                    {{$empleado->getNombreCompleto()}} 
                                
                                </td>
                                @foreach($empleado->getReportesMensualesCITE($listaAños) as $reporteMensual)
                                    @php
                                      $estado = $reporteMensual->getEstado();
                                    @endphp
                                    
                                    @if($reporteMensual->getDebeReportar())
                                        <td class="text-center">
                                            <button class="btn btn-xs btn-{{$estado->claseBoton}}"
                                            data-toggle="modal" data-target="#ModalVerReporte" onclick="clickVerReporte({{$reporteMensual->getId()}})">
                                                <i class="fas fa-{{$estado->icono}}"></i>
                                            </button>    
                                        </td>
                                    @else
                                        <td class="celdaPloma text-center">
                                            <button class="btn btn-xs btn-{{$estado->claseBoton}}" onclick="programarReporte({{$reporteMensual->codReporte}},'{{$reporteMensual->getMsjInfo()}}')" >
                                                <i class="fa fa-{{$estado->icono}}"></i>
                                            </button>    
                                        </td>
                                    @endif
                                        
                                        
                                  
                                
                                @endforeach
                            </tr>
                        @endforeach

                    </tbody>
                </table>

 
            </div>

        </div>
    </div>
    
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h5 class="">
                    Leyenda
                </h5>
            </div>
            <div class="card-body p-1">



                <table class="table table-striped table-bordered table-condensed table-hover table-sm"> 
                    <thead class="thead-default filaFijada mesPintado letrasBlancas">
                        <tr>
                            <td class="text-center">
                                Botón
                            </td>
                            <td class="text-center">
                                Estado
                            </td>
                            <td class="text-center">
                                Descripción
                            </td>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listaEstados as $estado)
                    
                            <tr>
                                <td class="text-center">
                                    <button class="my-auto btn btn-xs btn-{{$estado->claseBoton}}" type="button">
                                        <i class="fa fa-{{$estado->icono}}"></i>
                                    </button>
                                </td>
                                <td class="fontSize10 text-center">
                                    {{$estado->nombre}}
                                </td>
                                <td  class="text-center">

                            
                                    <div class="fontSize9">
                                        {{$estado->explicacion}}
                                    </div>
                                </td>
                            </tr>
                             
                        @endforeach
                    </tbody>
                </table>

                
                             
            
              
                
                
                  
               
 
            </div>

        </div>
    </div>
    
    <div class="col-8"></div>
</div>

 




<div class="modal fade" id="ModalVerReporte" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="contenidoModalEvaluarReporte">
           
        </div>
    </div>
</div>



<div class="modal fade" id="ModalObservar" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TituloModalObservar">Observar Reporte </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     
                     
                    <div class="row">
                        <div class="col-5">
                            
                            <label>Observacion 
                                <b id="contador2" style="color: rgba(0, 0, 0, 0.548)"></b>
                            </label>
                        </div>
                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div class="col">
                            <textarea class="form-control" name="nuevaObservacion" id="nuevaObservacion" 
                                cols="30" rows="4"  placeholder='Ingrese observación aquí...'></textarea> 
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Salir
                    </button>

                    <button type="button" onclick="clickObservar()" class="btn btn-primary">
                        Guardar <i class="fas fa-save"></i>
                    </button>
                </div>
        </div>
    </div>
</div>

@endsection
@include('Layout.ValidatorJS')
@section('script')
  <script>
    
    $(document).ready(function(){
        $(".loader").fadeOut("slow");

    });

 
    function clickVerReporte(codReporte){
        ruta = "/Cite/ReporteMensual/"+codReporte+"/inv_EvaluarReporte";
        document.getElementById('contenidoModalEvaluarReporte').innerHTML = "";
        invocarHtmlEnID(ruta,'contenidoModalEvaluarReporte')
    }


    /* FUNCIONES PARA CREARLAS */
    function programarReporte(codReporte,msjInfo){
        confirmarConMensaje("Confirmación","¿Seguro que desea programar el reporte de "+msjInfo+"?","warning",function(){
            location.href = "/Cite/ReporteMensual/Programar/" + codReporte;
        })

    }
     


    function abrirModalObservar(codReporte){
        codReporteSeleccionado = codReporte;
    }
    /* FUNCIONES PARA EVALUARLAS */
    function clickObservar(){
        confirmarConMensaje("Confirmación","¿Seguro que desea observar el reporte?","warning",function(){
            var nuevaObservacion = document.getElementById('nuevaObservacion').value
            location.href = "/Cite/ReporteMensual/Observar?codReporte=" + codReporteSeleccionado + "&observacion=" + nuevaObservacion;
        })
    }
    

  </script>

@endsection

