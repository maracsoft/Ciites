@extends ('Layout.Plantilla')
@section('titulo')
Listar Solicitudes
@endsection
@section('contenido')
@php


  $rendida_options = [
    ['value'=>1,"label"=>"Sí"],
    ['value'=>0,"label"=>"No"]
  ];
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
    'placeholder'=>'Buscar por código (SOL)',
    'type'=>'text',
    'function'=>'contains',
    'options'=>[],
    'options_label_field'=>'nombreYcod',
    'options_id_field'=>null,
    'size'=>'sm',
    'max_width'=>'250px',
      
  ]); 
  $comp_filtros->añadirFiltro([
      'name'=>'justificacion',
      'label'=>'Justificación:',
      'show_label'=>true,
      'placeholder'=>'Buscar por justificación',
      'type'=>'text',
      'function'=>'contains',
      'options'=>[],
      'options_label_field'=>'',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'250px',
  ]); 

  $comp_filtros->añadirFiltro([
    'name'=>'codEmpleadoSolicitante',
    'label'=>'Solicitante:',
    'show_label'=>true,
    'placeholder'=>'Buscar por solicitante',
    'type'=>'select2',
    'function'=>'equals',
    'options'=>$empleados,
    'options_label_field'=>'nombreCompleto',
    'options_id_field'=>null,
    'size'=>'sm',
    'max_width'=>'',
  ]); 
  $comp_filtros->añadirFiltro([
    'name'=>'fechaHoraEmision',
    'label'=>'Fecha emisión (rango)',
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
  $comp_filtros->añadirFiltro([
    'name'=>'estaRendida',
    'label'=>'Rendida',
    'show_label'=>true,
    'placeholder'=>'- Rendida -',
    'type'=>'select',
    'function'=>'equals',
    'options'=>$rendida_options,
    'options_id_field'=>'value',
    'options_label_field'=>'label',

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
  
<div style="">
  <h3> Solicitudes para abonar </h3>
  
  <br>
  <div class="row">
    <div class="col-md-12">
      {{$comp_filtros->render()}}
    
    </div>
  </div>
  
    @include('Layout.MensajeEmergenteDatos')

    <div class="table-container">

      <table class="table table-hover" style="font-size: 10pt; margin-top:10px; ">
              <thead class="thead-dark">
                <tr >
                  <th width="8%" scope="col">Código Sol</th>
                  <th width="7%"  scope="col" style="text-align: center">F. Emisión</th>
                
                  <th width="7%"  scope="col" style="text-align: center">F. Aprobación</th>
                  <th width="10%"  scope="col">Colaborador </th>
                  <th>Origen & Proyecto</th>
          
                  <th width="10%"  scope="col">Gerente/Director/a</th>
                  <th>
                    Justificación
                  </th>
                  <th width="8%"  scope="col" style="text-align: center">Total Solicitado</th>
                  
                  <th width="4%"  scope="col" style="text-align: center">Rendida</th>
                  
                  <th width="11%"  scope="col" style="text-align: center">Estado</th>
                  <th width="7%"  scope="col" style="text-align: center">F. Desembolso</th>
                  
                  <th width="9%"  scope="col">Opciones Solicitud</th>
                  <th width="9%"  scope="col">Opciones Rendición</th>
                  
                </tr>
              </thead>
        <tbody>

          {{--     varQuePasamos  nuevoNombre                        --}}
          @foreach($listaSolicitudesFondos as $itemSolicitud)

        
              <tr class="filaPr">
                  <td style = "padding: 0.40rem">{{$itemSolicitud->codigoCedepas  }}</td>
                  <td style = "padding: 0.40rem; text-align: center">{{$itemSolicitud->formatoFechaHoraEmision()}}</td>
                
                  <td style = "padding: 0.40rem; text-align: center">{{$itemSolicitud->formatoFechaHoraRevisado()}}</td>
                  <td style = "padding: 0.40rem"> {{$itemSolicitud->getNombreSolicitante()}} </td>
                  <td style = "padding: 0.40rem">{{$itemSolicitud->getProyecto()->getOrigenYNombre()  }}</td>
                  
                  <td style = "padding: 0.40rem"> {{$itemSolicitud->getNombreEvaluador()}} </td>
                  <td>
                    {{$itemSolicitud->getJustificacionAbreviada()}}
                  </td>
                  <td style = "padding: 0.40rem; text-align: right">{{$itemSolicitud->getMoneda()->simbolo}}  {{number_format($itemSolicitud->totalSolicitado,2)  }}</td>
                  

                  <td style="text-align: center">{{$itemSolicitud->estaRendidaSIoNo()}}</td>

                  <td style = "padding: 0.40rem; text-align: center">
                    <input type="text" value="{{$itemSolicitud->getNombreEstado()}}" class="form-control" readonly 
                      style="background-color: {{$itemSolicitud->getColorEstado()}};
                              height: 26px;
                              text-align:center;
                              color: {{$itemSolicitud->getColorLetrasEstado()}} ;
                      "  title="{{$itemSolicitud->getMensajeEstado()}}">
                  </td>

                  <td style = "padding: 0.40rem; text-align: center">{{$itemSolicitud->formatoFechaHoraDesembolso()}}</td>
                

                  <td style = "padding: 0.40rem">        {{-- OPCIONES SOLICITUD--}}
                    @if($itemSolicitud->verificarEstado('Aprobada')) {{-- Si está aprobada (pa abonar) --}}   
                      <a class='btn btn-warning btn-sm' href="{{route('SolicitudFondos.Administracion.verAbonar',$itemSolicitud->codSolicitud)}}" 
                          title="Abonar Solicitud">
                          <i class="fas fa-hand-holding-usd"></i>
                      </a>
                    @else{{-- si está rendida (pa verla nomas ) --}}
                  
                        <a href="{{route('SolicitudFondos.Administracion.verAbonar',$itemSolicitud->codSolicitud)}}" class='btn btn-info btn-sm' title="Ver Solicitud">
                          <i class="fas fa-eye"></i>
                        </a>
                        
                      
                    @endif

                      <a href="{{route('solicitudFondos.descargarPDF',$itemSolicitud->codSolicitud)}}" class='btn btn-info btn-sm'  title="Descargar PDF">
                        <i class="fas fa-file-download"></i>
                      </a>
                      <a target="pdf_solicitud_{{$itemSolicitud->codSolicitud}}" href="{{route('solicitudFondos.verPDF',$itemSolicitud->codSolicitud)}}"
                        class='btn btn-info btn-sm'  title="Ver PDF">
                        <i class="fas fa-file-pdf"></i>
                      </a>


                  </td>






                  <td style = "padding: 0.40rem">        {{-- OPCIONES --}}
                    @if($itemSolicitud->estaRendida())
                          <a href="{{route('RendicionGastos.Administracion.Ver',$itemSolicitud->getRendicion()->codRendicionGastos)}}" class='btn btn-info btn-sm' title="Ver Rendición"><i class="fas fa-eye"></i></a>
                          <a href="{{route('rendicionGastos.descargarPDF',$itemSolicitud->getRendicion()->codRendicionGastos)}}" class='btn btn-info btn-sm' title="Descargar PDF"><i class="fas fa-file-download"></i></a>
                          <a target="pdf_rendicion_{{$itemSolicitud->getRendicion()->codRendicionGastos}}" href="{{route('rendicionGastos.verPDF',$itemSolicitud->getRendicion()->codRendicionGastos)}}" class='btn btn-info btn-sm'  title="Ver PDF"><i class="fas fa-file-pdf"></i></a>
                    @endif
                  </td>

              </tr>
          @endforeach
        </tbody>
      </table>

      {{$listaSolicitudesFondos->appends($filtros_usados_paginacion)->links()}}

    </div>
</div>
@endsection


<?php 
  $fontSize = '14pt';
?>
 