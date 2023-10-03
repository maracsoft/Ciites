@extends ('Layout.Plantilla')
@section('titulo')
Listar Solicitudes
@endsection
@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
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
    'options'=>$proyectosDelGerente,
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
  <h3> Solicitudes de mis proyectos </h3>
   
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
                  <th width="9%" scope="col">Código Sol</th>
                  <th width="9%" scope="col" style="text-align: center">F. Emisión</th>
                  
                  <th width="13%" scope="col">Colaborador</th>
                  
                  <th scope="col">Origen & Proyecto</th>
                  <th>Justificación</th>

                  <th width="9%" scope="col" style="text-align: center">Total Solicitado // Rendido</th>
                  <th width="11%" scope="col" style="text-align: center">Estado</th>
                  <th width="9%" scope="col">Cod Rendición</th>
                  <th width="9%" scope="col" style="text-align: center">F. Revisión</th>
                  

                  <th width="7%" scope="col">Opciones</th>
                  
                </tr>
              </thead>
        <tbody>

          {{--     varQuePasamos  nuevoNombre                        --}}
          @foreach($listaSolicitudesFondos as $itemSolicitud)

        
              <tr>
                  <td style = "padding: 0.40rem">{{$itemSolicitud->codigoCedepas  }}</td>
                  <td style = "padding: 0.40rem; text-align: center">{{$itemSolicitud->formatoFechaHoraEmision()}}</td>
                
                  <td style = "padding: 0.40rem"> {{$itemSolicitud->getNombreSolicitante()}} </td>
                  <td style = "padding: 0.40rem">{{$itemSolicitud->getProyecto()->getOrigenYNombre()  }}</td>
                  <td>
                    {{$itemSolicitud->getJustificacionAbreviada()}}
                  </td>
                  
                  <td style = "padding: 0.40rem; text-align: right"> 
                      {{$itemSolicitud->getMoneda()->simbolo}}  {{number_format($itemSolicitud->totalSolicitado,2)  }}<br>
                      @if($itemSolicitud->estaRendida())
                        // {{$itemSolicitud->getMoneda()->simbolo}}  {{number_format($itemSolicitud->getRendicion()->totalImporteRendido,2)}}
                      @endif
                  </td>
                  <td style = "padding: 0.40rem; text-align: center">
                    <input type="text" value="{{$itemSolicitud->getNombreEstado()}}" class="form-control" readonly 
                      style="background-color: {{$itemSolicitud->getColorEstado()}};
                              height: 26px;
                              text-align:center;
                              color: {{$itemSolicitud->getColorLetrasEstado()}} ;
                      "  title="{{$itemSolicitud->getMensajeEstado()}}">
                  </td>
                  <td style = "padding: 0.40rem">  
                    @if($itemSolicitud->estaRendida())
                      
                      {{$itemSolicitud->getRendicion()->codigoCedepas}}

                    @endif
                  </td>
                  
                  <td style = "padding: 0.40rem; text-align: center">{{$itemSolicitud->formatoFechaHoraRevisado()}}</td>
                  <td style = "padding: 0.40rem">
                        {{-- Si la tenemos que evaluar --}}  
                        @if($itemSolicitud->verificarEstado('Creada') || $itemSolicitud->verificarEstado('Subsanada') )
                            <a href="{{route('SolicitudFondos.Gerente.Revisar',$itemSolicitud->codSolicitud)}}" 
                              class='btn btn-warning btn-sm' title="Evaluar Solicitud"><i class="fas fa-thumbs-up"></i></a>    


                        @else {{-- Si ya la evaluamos y solo la vamos a  ver --}}
                              <a href="{{route('SolicitudFondos.Gerente.Revisar',$itemSolicitud->codSolicitud)}}" class='btn btn-info btn-sm' title="Ver Solicitud">S</a>
                            
                            @if($itemSolicitud->estaRendida())   
                              <a href="{{route('RendicionGastos.Gerente.Ver',$itemSolicitud->getRendicion()->codRendicionGastos)}}" class='btn btn-info btn-sm' title="Ver Rendición">R</a>

                            @endif

                          
                        @endif
                      

                        
                      <a href="{{route('solicitudFondos.descargarPDF',$itemSolicitud->codSolicitud)}}" class='btn btn-info btn-sm'  title="Descargar PDF">
                        <i class="fas fa-file-download"></i>
                      </a>
                      <a target="pdf_solicitud_{{$itemSolicitud->codSolicitud}}" href="{{route('solicitudFondos.verPDF',$itemSolicitud->codSolicitud)}}"
                        class='btn btn-info btn-sm'  title="Ver PDF">
                        <i class="fas fa-file-pdf"></i>
                      </a>
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
<style>
/* PARA COD ORDEN CON CIRCULITOS  */

  span.grey {
    background: #000000;
    border-radius: 0.8em;
    -moz-border-radius: 0.8em;
    -webkit-border-radius: 0.8em;
    color: #fff;
    display: inline-block;
    font-weight: bold;
    line-height: 1.6em;
    margin-right: 15px;
    text-align: center;
    width: 1.6em; 
    font-size : {{$fontSize}};
  }
  


  span.red {
  background:#932425;
   border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}


span.green {
  background: #5EA226;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}

span.blue {
  background: #5178D0;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}

span.pink {
  background: #EF0BD8;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}
   </style>
@section('script')  
<script src="/select2/bootstrap-select.min.js"></script>     
 <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
 <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
@endsection