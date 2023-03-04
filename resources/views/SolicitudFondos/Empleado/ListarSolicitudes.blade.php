@extends ('Layout.Plantilla')
@section('titulo')
Mis Solicitudes
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



<div>
    <div class="text-center mt-2">
      <h2> 
        Mis Solicitudes de Fondos 
      </h2>
    </div>
    

 
    
    <div class="row">
      <div class="col-12 px-3">
        <a href="{{route('SolicitudFondos.Empleado.Create')}}" class = "btn btn-primary"> 
          <i class="fas fa-plus"> </i> 
            Nueva Solicitud
        </a>
      </div>
      
    </div>
    <div class="row">
      <div class="col-12">
        {{$comp_filtros->render()}}
      </div>
      
    </div>


    {{-- AQUI FALTA EL CODIGO SESSION DATOS ENDIF xdd --}}
    @include('Layout.MensajeEmergenteDatos')
    <div class="table-container">

      <table class="table table-hover" style="font-size: 10pt; margin-top:10px;">
              <thead class="thead-dark">
                <tr>
                  <th width="9%" scope="col">Código Sol</th>
                  <th width="9%" scope="col" style="text-align: center">F. Emisión</th>
                
                  <th scope="col">Origen & Proyecto</th>
                  <th>
                    Justificación
                  </th>
                  <th width="9%" scope="col" style="text-align: center">Total Solicitado // Rendido </th>
                  <th width="11%" scope="col" style="text-align: center">Estado</th>
                  <th width="5%" scope="col">Rendida</th>
                  
                  <th width="9%" scope="col" style="text-align: center">F. Revisión Gerente</th>
                  

                  <th width="7%" scope="col">Opciones</th>
                  
                </tr>
              </thead>
        <tbody>
          


          {{--     varQuePasamos  nuevoNombre                        --}}
          @foreach($listaSolicitudesFondos as $itemSolicitud)
              <tr>
                  <td style = "padding: 0.40rem">
                    {{$itemSolicitud->codigoCedepas  }}
                  </td>
                  <td style = "padding: 0.40rem; text-align: center">
                    {{$itemSolicitud->formatoFechaHoraEmision()}}
                  </td>
                  <td style = "padding: 0.40rem">
                    {{$itemSolicitud->getProyecto()->getOrigenYNombre()}}
                  </td>
                  <td>
                    {{$itemSolicitud->getJustificacionAbreviada()}}
                  </td>
                  
                  <td style = "padding: 0.40rem; text-align: right"> 
                      {{$itemSolicitud->getMoneda()->simbolo}}  {{number_format($itemSolicitud->totalSolicitado,2)  }} <br>
                      @if($itemSolicitud->estaRendida())
                        // {{$itemSolicitud->getMoneda()->simbolo}}  {{number_format( $itemSolicitud->getRendicion()->totalImporteRendido,2 )}}
                      @endif
                  </td>
                  
                  <td style = "padding: 0.40rem; text-align: center">
                    <input type="text" value="{{$itemSolicitud->getNombreEstado()}}" class="form-control" readonly 
                      style="background-color: {{$itemSolicitud->getColorEstado()}};
                              height: 26px;
                              text-align:center;
                              color: {{$itemSolicitud->getColorLetrasEstado()}} ;
                      " title="{{$itemSolicitud->getMensajeEstado()}}">
                  </td>

                  <td style = "padding: 0.40rem; text-align: center">
                    @if($itemSolicitud->estaRendida())
                      SÍ
                    @else
                      NO
                    @endif

                  </td>

                  <td style = "padding: 0.40rem; text-align: center">{{$itemSolicitud->formatoFechaHoraRevisado()}}</td>
                  <td style = "padding: 0.40rem">
                      @switch($itemSolicitud->codEstadoSolicitud)
                          @case(App\SolicitudFondos::getCodEstado('Creada'))   {{-- Si solamente está creada --}}
                          @case(App\SolicitudFondos::getCodEstado('Observada')) {{-- O si está observada --}}
                          @case(App\SolicitudFondos::getCodEstado('Subsanada')) {{-- Si ya subsano las observaciones --}}
                                  {{-- MODIFICAR RUTAS DE Delete y Edit --}}
                              <a href="{{route('SolicitudFondos.Empleado.Edit',$itemSolicitud->codSolicitud)}}" class = "btn btn-sm btn-warning" title="Editar Solicitud"><i class="fas fa-edit"></i></a>
                              


                              <a href="#" class="btn btn-sm btn-danger" title="Cancelar Solicitud" onclick="swal({//sweetalert
                                    title:'¿Está seguro de cancelar la solicitud: {{$itemSolicitud->codigoCedepas}} ?',
                                    //type: 'warning',  
                                    type: 'warning',
                                    showCancelButton: true,//para que se muestre el boton de cancelar
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText:  'SÍ',
                                    cancelButtonText:  'NO',
                                    closeOnConfirm:     true,//para mostrar el boton de confirmar
                                    html : true
                                },
                                function(){//se ejecuta cuando damos a aceptar
                                  window.location.href='{{route('SolicitudFondos.Empleado.cancelar',$itemSolicitud->codSolicitud)}}';
                                });">
                                <i class="fas fa-trash-alt"></i>
                              </a>
                                
                              @break
                          @case(App\SolicitudFondos::getCodEstado('Aprobada')) {{-- YA FUE APROBADA --}}
                            <a href="{{route('SolicitudFondos.Empleado.Ver',$itemSolicitud->codSolicitud)}}" class = "btn btn-sm btn-info" title="Ver Solicitud">
                                S
                            </a>   
                          @break
                          @case(App\SolicitudFondos::getCodEstado('Abonada') || App\SolicitudFondos::getCodEstado('Contabilizada') ) {{-- ABONADA --}}
                              <a href="{{route('SolicitudFondos.Empleado.Ver',$itemSolicitud->codSolicitud)}}" class = "btn btn-sm btn-info" title="Ver Solicitud">
                                S
                              </a>   
                          @break
                          @case(App\SolicitudFondos::getCodEstado('Rechazada')) {{-- RECHAZADA --}} 
                            <a href="{{route('SolicitudFondos.Empleado.Ver',$itemSolicitud->codSolicitud)}}" class = "btn btn-sm btn-info" title="Ver Solicitud">
                              S
                            </a>
                          @break
                          @default
                              
                      @endswitch

                      
                      <a href="{{route('solicitudFondos.descargarPDF',$itemSolicitud->codSolicitud)}}" class='btn btn-info btn-sm'  title="Descargar PDF">
                        <i class="fas fa-file-download"></i>
                      </a>
                      <a target="pdf_solicitud_{{$itemSolicitud->codSolicitud}}" href="{{route('solicitudFondos.verPDF',$itemSolicitud->codSolicitud)}}"
                        class='btn btn-info btn-sm'  title="Ver PDF">
                        <i class="fas fa-file-pdf"></i>
                      </a>
                              
                      @if($itemSolicitud->estaRendida())
                        <a href="{{route('RendicionGastos.Empleado.Ver',$itemSolicitud->getRendicion()->codRendicionGastos)}}" class = "btn btn-sm btn-info" title="Ver Rendición">
                          R
                        </a> 
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
<style>
  

</style>
