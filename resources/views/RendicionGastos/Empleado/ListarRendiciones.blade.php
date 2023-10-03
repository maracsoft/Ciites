@extends ('Layout.Plantilla')
@section('titulo')
Mis Rendiciones
@endsection
@section('contenido')
@php

  $comp_filtros = new App\UI\UIFiltros(false,$filtros_usados);

  $comp_filtros->añadirFiltro([
    'name'=>'codProyecto',
    'label'=>'Proyectos:',
    'show_label'=>true,
    'placeholder'=>'Buscar por proyecto',
    'type'=>'multiple_select',
    'function'=>'in',
    'options'=>$proyectos,
    'options_label_field'=>'nombreYcod',
    'options_id_field'=>null,
    'size'=>'sm',
    'max_width'=>'250px',
    
  ]); 
  $comp_filtros->añadirFiltro([
    'name'=>'codigoCedepas',
    'label'=>'Código:',
    'show_label'=>true,
    'placeholder'=>'Buscar por código (REN)',
    'type'=>'text',
    'function'=>'contains',
    'options'=>[],
    'options_label_field'=>'nombreYcod',
    'options_id_field'=>null,
    'size'=>'sm',
    'max_width'=>'250px',
    
  ]); 

  
  $comp_filtros->añadirFiltro([
    'name'=>'codigoContrapartida',
    'label'=>'Contrapartida:',
    'show_label'=>true,
    'placeholder'=>'Buscar por Contrapartida',
    'type'=>'text',
    'function'=>'contains',
    'options'=>[],
    'options_label_field'=>'',
    'options_id_field'=>null,
    'size'=>'sm',
    'max_width'=>'250px',
  ]); 


  $comp_filtros->añadirFiltro([
      'name'=>'resumenDeActividad',
      'label'=>'Resumen actividad:',
      'show_label'=>true,
      'placeholder'=>'Buscar por resumen actividad',
      'type'=>'text',
      'function'=>'contains',
      'options'=>[],
      'options_label_field'=>'',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'250px',
  ]); 


  $comp_filtros->añadirFiltro([
    'name'=>'fechaHoraRendicion',
    'label'=>'Fecha rendición (rango)',
    'show_label'=>true,
    'placeholder'=>'',
    'type'=>'date_interval',
    'function'=>'between_dates',
    'options'=>[],
    'options_label_field'=>'nombre',
    'options_id_field'=>null,
    'size'=>'sm',
    'max_width'=>'250px',
  ]); 


@endphp
 
<div>
  <h3> Mis Rendiciones de Gastos </h3>
  <div class="container">
    <div class="row">
     
      
      
      <label class="colLabel">Sol. Fondos:</label>

      <div class="col" style="">
        <select class="form-control mr-sm-2" onclick="actualizarCodSolicitud()" 
          id="codSolicitudSeleccionada" name="codSolicitudSeleccionada" style="">
          <option value="-1">--Seleccionar--</option>
          @foreach($listaSolicitudesPorRendir as $itemSolicitud)
              <option value="{{$itemSolicitud->codSolicitud}}" 
                {{$itemSolicitud->codSolicitud}}>
                  {{$itemSolicitud->codigoCedepas}} por {{$itemSolicitud->getMoneda()->simbolo}} {{number_format($itemSolicitud->totalSolicitado,2)}}
              </option>                                 
          @endforeach 
        </select>
      </div>

      <div class="col">
        <button class="btn btn-success " onclick="crearRendicion()">Crear Rendición</button>
      </div>

    </div>
  </div>
  <br>
  <div class="row" >

    
    <div class="col-md-12" >
      {{$comp_filtros->render()}}
    </div>
  </div>
    

  @include('Layout.MensajeEmergenteDatos')
  <div class="table-container">

    <table class="table table-hover" style="font-size: 10pt;">
            <thead class="thead-dark">
              <tr>
                <th>Cod. Rendición</th> {{-- COD CEDEPAS --}}
                <th style="text-align: center">F. Rendición</th>
              
                <th>Origen & Proyecto</th>
                <th>
                  Contrapartida  
                </th>              
                <th>
                  Resumen Actividad
                </th>
                <th  style="text-align: center">Total Recibido</th>
                <th style="text-align: center">Total Gastado</th>
                <th style="text-align: center">Saldo fav Emp</th>
                <th style="text-align: center">Estado</th>
                <th width="10%" >Opciones</th>
                
              </tr>
            </thead>
      <tbody>

        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($listaRendiciones as $itemRendicion)

      
            <tr>
              <td style = "padding: 0.40rem">{{$itemRendicion->codigoCedepas  }}</td>
              <td style = "padding: 0.40rem; text-align: center">{{$itemRendicion->formatoFechaHoraRendicion()}}</td>
            
              <td style = "padding: 0.40rem">{{$itemRendicion->getProyecto()->getOrigenYNombre()  }}</td>
              <td>
                {{$itemRendicion->codigoContrapartida}}
              </td>
              <td>
                {{$itemRendicion->getResumenAbreviado()}}

              </td>
              
              <td style = "padding: 0.40rem; text-align: right">{{$itemRendicion->getMoneda()->simbolo}} {{number_format($itemRendicion->totalImporteRecibido,2)  }}</td>
              <td style = "padding: 0.40rem; text-align: right;">{{$itemRendicion->getMoneda()->simbolo}} {{number_format($itemRendicion->totalImporteRendido,2)  }}</td>
              <td style = "padding: 0.40rem; text-align: right;  color: {{$itemRendicion->getColorSaldo()}}">
                {{$itemRendicion->getMoneda()->simbolo}} {{number_format($itemRendicion->getSaldoFavorCedepas(),2)  }}
              </td>
        
              <td style = "padding: 0.40rem; text-align: center">
                <input  type="text" value="{{$itemRendicion->getNombreEstado()}}" class="form-control" readonly 
                style="background-color: {{$itemRendicion->getColorEstado()}};
                        height: 26px;
                        text-align:center;
                        color: {{$itemRendicion->getColorLetrasEstado()}} ;
                "  title="{{$itemRendicion->getMensajeEstado()}}">
              </td>
              <td style = "padding: 0.40rem">       
                @if($itemRendicion->verificarEstado('Creada') || 
                  $itemRendicion->verificarEstado('Subsanada') ||
                    $itemRendicion->verificarEstado('Observada') )
                  <a href="{{route('RendicionGastos.Empleado.Editar',$itemRendicion->codRendicionGastos)}}" class = "btn btn-warning btn-sm" title="Editar Rendición">
                    <i class="fas fa-edit"></i>
                  </a>
                          
                @endif
                <a href="{{route('SolicitudFondos.Empleado.Ver',$itemRendicion->getSolicitud()->codSolicitud)}}" class = "btn btn-info btn-sm" title="Ver Solicitud">
                  S
                </a>
                <a href="{{route('RendicionGastos.Empleado.Ver',$itemRendicion->codRendicionGastos)}}" class = "btn btn-info btn-sm" title="Ver Rendición">
                  R
                </a>

                
                <a class='btn btn-info btn-sm'  href="{{route('rendicionGastos.descargarPDF',$itemRendicion->codRendicionGastos)}}" title="Descargar PDF">
                  <i class="fas fa-file-download"></i>
                </a>
                <a target="pdf_rendicion_{{$itemRendicion->codRendicionGastos}}" class='btn btn-info btn-sm'  
                  href="{{route('rendicionGastos.verPDF',$itemRendicion->codRendicionGastos)}}" title="Ver PDF">
                  <i class="fas fa-file-pdf"></i>
                </a>
              </td>

            </tr>
        @endforeach
      </tbody>
    </table>
    {{$listaRendiciones->appends($filtros_usados_paginacion)->links()}}
  </div>

</div>
@endsection


<?php 
  $fontSize = '14pt';
?>
 
<script>
var codigoSolicitudSeleccionada = -1; 

function actualizarCodSolicitud(){

  codigoSolicitudSeleccionada = document.getElementById('codSolicitudSeleccionada').value;

}


function crearRendicion(){
  console.log('hola');

  if(codigoSolicitudSeleccionada == '-1'){ 
    alerta('Debe seleccionar una solicitud para rendirla.');
    return;
  }
  
  window.location.href = "/SolicitudFondos/Empleado/Rendir/"+codigoSolicitudSeleccionada;
  
}



</script>
