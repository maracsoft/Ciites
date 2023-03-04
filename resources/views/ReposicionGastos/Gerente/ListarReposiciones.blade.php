@extends ('Layout.Plantilla')

@section('titulo')
  Listar Reposiciones
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
    'placeholder'=>'Buscar por código (REP)',
    'type'=>'text',
    'function'=>'contains',
    'options'=>[],
    'options_label_field'=>'nombreYcod',
    'options_id_field'=>null,
    'size'=>'sm',
    'max_width'=>'250px',
    
  ]); 
  $comp_filtros->añadirFiltro([
      'name'=>'resumen',
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
  
<div>
  <h3>Reposiciones para aprobar</h3>

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
                  <th width="9%" scope="col">Código</th>
                  <th width="9%" scope="col" style = "text-align: center">F. Emisión</th>
                  
                  <th width="11%" scope="col">Solicitante</th>
                
                  <th scope="col">Origen & Proyecto</th>
                  <th>
                    Resumen actividad
                  </th>
            
                  <th width="8%" scope="col" style="text-align: center">Total</th>
                  <th width="11%" scope="col" style="text-align: center">Estado</th>
                  <th width="9%" scope="col" style = "text-align: center">F. Aprobación</th>
                  

                  <th width="9%" scope="col">Opciones</th>
                  
                </tr>
              </thead>
        <tbody>

          {{--     varQuePasamos  nuevoNombre                        --}}
          @foreach($listaReposiciones as $itemreposicion)

              
              <tr>
                  <td style = "padding: 0.40rem">{{$itemreposicion->codigoCedepas  }}</td>
                  <td style = "text-align: center; padding: 0.40rem">{{$itemreposicion->formatoFechaHoraEmision()}}</td>
                  
                  <td style = "padding: 0.40rem">{{$itemreposicion->getEmpleadoSolicitante()->getNombreCompleto()}}</td>
                
                  <td style = "padding: 0.40rem">{{$itemreposicion->getProyecto()->getOrigenYNombre()  }}</td>
                  <td>
                    {{$itemreposicion->getResumenAbreviado()}}
                  </td>
          
                  <td style = "text-align: right; padding: 0.40rem">{{$itemreposicion->getMoneda()->simbolo}} {{number_format($itemreposicion->monto(),2)}}</td>
                  <td style="text-align: center; padding: 0.40rem">
                    <input type="text" value="{{$itemreposicion->getNombreEstado()}}" class="form-control" readonly 
                    style="background-color: {{$itemreposicion->getColorEstado()}};
                            height: 26px;
                            text-align:center;
                            color: {{$itemreposicion->getColorLetrasEstado()}} ;
                    "  title="{{$itemreposicion->getMensajeEstado()}}">
                  </td>
                  <td style="text-align: center; padding: 0.40rem">{{$itemreposicion->formatoFechaHoraRevisionGerente()}}</td>
                  <td style = "padding: 0.40rem">
                    @if($itemreposicion->verificarEstado('Creada') || $itemreposicion->verificarEstado('Subsanada')  )
                      <a href="{{route('ReposicionGastos.Gerente.ver',$itemreposicion->codReposicionGastos)}}" 
                        class="btn btn-warning btn-sm" title="Evaluar Reposición">
                        <i class="fas fa-thumbs-up"></i>
                      </a>
                    @else
                      <a href="{{route('ReposicionGastos.Gerente.ver',$itemreposicion->codReposicionGastos)}}"
                        class="btn btn-info btn-sm" title="Ver Reposición">
                        <i class="fas fa-eye"></i>
                      </a>
                    @endif
                    
                    <a  href="{{route('ReposicionGastos.exportarPDF',$itemreposicion->codReposicionGastos)}}" 
                      class="btn btn-primary btn-sm" title="Descargar PDF">
                      <i class="fas fa-file-download"></i>
                    </a>

                    <a target="pdf_reposicion_{{$itemreposicion->codReposicionGastos}}" href="{{route('ReposicionGastos.verPDF',$itemreposicion->codReposicionGastos)}}" 
                      class="btn btn-primary btn-sm" title="Ver PDF">
                      <i class="fas fa-file-pdf"></i>
                    </a>
                    
                  </td>

              </tr>
          @endforeach
        </tbody>
      </table>

      {{$listaReposiciones->appends($filtros_usados_paginacion)->links()}}
    </div>
</div>
@endsection


<?php 
  $fontSize = '14pt';
?>
 