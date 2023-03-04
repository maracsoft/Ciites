@extends('Layout.Plantilla')

@section('titulo')
    CITE Servicios brindados
@endsection

@section('contenido')

<style>
    .celdaPloma{
        background-color: rgb(204, 204, 204);
    }
     
</style>
<div class="row">
    <div class="col-12">

        <div class="card m-3">
            <div class="card-header d-flex flex-row">

                <div class="">
                    <h3 class="m-1">
                        Mis Reportes mensuales de CITE
                    </h3>
                </div>


            </div>

            <div class="card-body">
                @include('Layout.MensajeEmergenteDatos')

                <table class="table table-bordered table-hover datatable" id="">
                    <thead>
                        <tr>
                            <th class="text-center">
                                Mes
                            </th>
                            <th class="text-center">
                                ¿Debe reportar?
                            </th>
                            <th class="text-center">
                                Estado  
                            </th>
                            <th class="text-center">
                                Descripción Estado
                            </th>
                            <th class="text-center">
                                Opciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listaReportes as $reporte)
                            <tr>
                                <td class="text-center p-0">
                                    {{$reporte->getMes()->nombre}} {{$reporte->año}}
                                </td>
                                @if($reporte->getDebeReportar())
                                    <td class="text-center p-0"> {{-- Debe reportar? esta fijo pq ya pasó el if --}}
                                        SÍ
                                    </td>
                                    
                                    <td class="text-center p-0">{{-- Estado de revision --}}
                                        {{$reporte->getEstado()->nombre}}
                                        <br>
                                        
                                        @if($reporte->estaObservado())
                                            <button type="button" class="btn btn-xs btn-info" onclick="abrirMensajeObservacion(`{{$reporte->observacion}}`)">
                                                Ver observación
                                            </button>   
                                        @endif
                                    </td>
                                    <td class="text-center p-0">
                                        <span class="fontSize9">
                                            {{$reporte->getEstado()->explicacion}}
                                        </span>
                                    </td>
                                    
                                    <td class="text-center p-0">
                                        @if($reporte->puedeParcarComoListo())
                                        
                                        
                                            @if($reporte->estaObservado())
                                                <button class="m-2 btn btn-xs btn-primary" onclick="clickSubsanarReporte({{$reporte->getId()}})">
                                                    Marcar como subsanado
                                                </button>
                                            @endif
                                            @if($reporte->estaProgramado())
                                                <button class="m-2 btn btn-xs btn-primary" onclick="clickMarcarReporte({{$reporte->getId()}})">    
                                                Marcar como listo
                                                </button>
                                            @endif
                                            
                                            
                                        @endif
                                    </td>
                                @else
                                    <td class="celdaPloma text-center p-0">
                                        NO
                                    </td>
                                    <td class="celdaPloma text-center p-0">
                                        No programado
                                    </td>
                                    <td class="celdaPloma text-center p-0">
                                        -
                                    </td>
                                    <td class="celdaPloma text-center p-0">
                                        -
                                    </td>
                                    
                                @endif
                                
                            </tr>
                        @endforeach

                    </tbody>
                </table>



            </div>
        </div>



    </div>
</div>
 

@endsection
@section('script')
@include('Layout.ValidatorJS')
<script>
 

    function clickSubsanarReporte(codReporte){
        confirmarConMensaje(
                "Confirmación",
                "¿Desea marcar el reporte como subsanado? <br> Se enviará una notificación a Articuladores y UGE para revisarlo.",
                'warning',
                function(){ location.href = "/Cite/ReporteMensual/MarcarReporteComoListo/" + codReporte; }
        )

    }
    function clickMarcarReporte(codReporte){
        confirmarConMensaje(
                "Confirmación",
                "¿Desea marcar el reporte como realizado? <br> Se enviará una notificación a Articuladores y UGE para revisarlo.",
                'warning',
                function(){ location.href = "/Cite/ReporteMensual/MarcarReporteComoListo/" + codReporte; }
        )
        
    }

    function abrirMensajeObservacion(msj){
        alertaMensaje("Observación:", msj,"info");
    }

</script>
@endsection
