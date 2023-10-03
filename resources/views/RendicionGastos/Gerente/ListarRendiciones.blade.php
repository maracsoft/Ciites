@extends ('Layout.Plantilla')
@section('titulo')
Listar Rendiciones
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
<style>

  .col{
    margin-top: 15px;
  
    }
  
  .colLabel{
  width: 13%;
  margin-top: 18px;
  
  
  }
  
  
  </style>
  
<div>
  <h3> Rendiciones de Gastos a Aprobar </h3>
 
  <br>
  <div class="row">
    <div class="col-md-12">
      {{$comp_filtros->render()}}
    </div>
  </div>
  

{{-- AQUI FALTA EL CODIGO SESSION DATOS ENDIF xdd --}}
    @include('Layout.MensajeEmergenteDatos')
    <div class="table-container">

      <table class="table table-hover" style="font-size: 10pt; margin-top:10px; ">
              <thead class="thead-dark">
                <tr>
                  <th width="9%" scope="col">Cod. Rendición</th> {{-- COD CEDEPAS --}}
                  <th width="9%"  scope="col" style="text-align: center">F. Rendición</th>
                
                  <th width="13%"  scope="col">Colaborador </th>
                
                  <th scope="col">Origen & Proyecto</th> 
                  <th>
                    Contrapartida  
                  </th>                     
                  <th>
                    Resumen actividad
                  </th>
                  <th width="9%"  scope="col" style="text-align: center">Total Recibido</th>
                  <th width="9%"  scope="col" style="text-align: center">Total Gastado</th>
                  <th width="9%"  scope="col" style="text-align: center">Saldo</th>
                  <th width="11%"  scope="col" style="text-align: center">Estado</th>
                  <th width="7%"  scope="col">Opciones</th>
                  
                </tr>
              </thead>
        <tbody>

          {{--     varQuePasamos  nuevoNombre                        --}}
          @foreach($listaRendiciones as $itemRendicion)
              <tr>
                <td style = "padding: 0.40rem">{{$itemRendicion->codigoCedepas  }}</td>
                <td style = "padding: 0.40rem; text-align: center">{{$itemRendicion->formatoFechaHoraRendicion()}}</td>
              
                <td style = "padding: 0.40rem">{{$itemRendicion->getNombreSolicitante()  }}</td>
                <td style = "padding: 0.40rem">{{$itemRendicion->getProyecto()->getOrigenYNombre()  }}</td>
                <td>
                  {{$itemRendicion->codigoContrapartida}}
                </td>
                <td>
                  {{$itemRendicion->getResumenAbreviado()}}
                </td>
          
                <td style = "padding: 0.40rem; text-align: right">{{$itemRendicion->getMoneda()->simbolo}} {{number_format($itemRendicion->totalImporteRecibido,2)  }}</td>
                <td style = "padding: 0.40rem; text-align: right">{{$itemRendicion->getMoneda()->simbolo}} {{number_format($itemRendicion->totalImporteRendido,2)  }}</td>
                <td style = "padding: 0.40rem; text-align: right;  color: {{$itemRendicion->getColorSaldo()}}">
                  {{$itemRendicion->getMoneda()->simbolo}} {{number_format($itemRendicion->getSaldoFavorCedepas(),2)  }}
                </td>
          
                <td style = "padding: 0.40rem; text-align: center">
                  <input type="text" value="{{$itemRendicion->getNombreEstado()}}" class="form-control" readonly 
                  style="background-color: {{$itemRendicion->getColorEstado()}};
                          height: 26px;
                          text-align:center;
                          color: {{$itemRendicion->getColorLetrasEstado()}} ;
                  " title="{{$itemRendicion->getMensajeEstado()}}">
                </td>
                <td style = "padding: 0.40rem">
                  @if($itemRendicion->verificarEstado('Creada') || $itemRendicion->verificarEstado('Subsanada')  )
                    <a href="{{route('RendicionGastos.Gerente.Revisar',$itemRendicion->codRendicionGastos)}}" 
                      class='btn btn-warning btn-sm' title="Evaluar Rendición"><i class="fas fa-thumbs-up"></i>
                    </a>    
                  @endif

                  <a href="{{route('SolicitudFondos.Empleado.Ver',$itemRendicion->getSolicitud()->codSolicitud)}}" class='btn btn-info btn-sm' title="Ver Solicitud">
                    S
                  </a>
                  
                  @if($itemRendicion->verificarEstado('Contabilizada')  || $itemRendicion->verificarEstado('Aprobada')|| $itemRendicion->verificarEstado('Observada')   )   
                    <a href="{{route('RendicionGastos.Gerente.Ver',$itemRendicion->codRendicionGastos)}}" class='btn btn-info btn-sm' title="Ver Rendición">
                      R
                    </a>
                  @endif 

                  
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
 