@extends ('Layout.Plantilla')

@section('titulo')
  Listar Requerimientos
@endsection
@section('contenido')
@php

  
  $tieneFactura_options = [
    
    ['value'=>1,"label"=>"Sí"],
    ['value'=>0,"label"=>"No"]
  ];
  $facturaContabilizada_options = [
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
    'placeholder'=>'Buscar por código (REQ)',
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
      'placeholder'=>'Buscar por Justificación',
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
    'name'=>'tieneFactura',
    'label'=>'Tiene Factura',
    'show_label'=>true,
    'placeholder'=>'- Tiene Factura -',
    'type'=>'select',
    'function'=>'equals',
    'options'=>$tieneFactura_options,
    'options_id_field'=>'value',
    'options_label_field'=>'label',
    
    'size'=>'sm',
    'max_width'=>'250px',
  ]); 


  $comp_filtros->añadirFiltro([
    'name'=>'facturaContabilizada',
    'label'=>'Factura Contabilizada',
    'show_label'=>true,
    'placeholder'=>'- F. Contabilizada -',
    'type'=>'select',
    'function'=>'equals',
    'options'=>$facturaContabilizada_options,
    'options_id_field'=>'value',
    'options_label_field'=>'label',
    
    'size'=>'sm',
    'max_width'=>'250px',
  ]); 



@endphp

<div>
  <h3> Aprobar Requerimientos de Bienes y Servicios </h3>
  
  <br>
  <div class="row">
    <div class="col-md-12">
      {{$comp_filtros->render()}}
    </div>
  </div>
  
  
    

{{-- AQUI FALTA EL CODIGO SESSION DATOS ENDIF xdd --}}
    @include('Layout.MensajeEmergenteDatos')
    <div class="table-container">

      <table class="table table-hover" style="font-size: 10pt; margin-top:10px;">
              <thead class="thead-dark">
                <tr>
                  <th width="5%" scope="col">Cod. Requerimiento</th> {{-- COD CEDEPAS --}}
                  <th width="6%"  scope="col" style="text-align: center">F. Emisión</th>
                  <th width="6%"  scope="col" style="text-align: center">F. Aprobación</th>
                  
                  <th width="11%" scope="col">Solicitante</th>
                  
                  <th width="19%">Origen & Proyecto</th>              
                  <th width="20%">Justificacion</th>
                  <th width="13%"  scope="col" style="text-align: center">Estado</th>
                  <th width="9%"  scope="col">Opciones</th>
                  
                </tr>
              </thead>
        <tbody>

      
          @foreach($listaRequerimientos as $itemRequerimiento)

        
              <tr>
                <td style = "padding: 0.40rem">{{$itemRequerimiento->codigoCedepas  }}</td>
                <td style = "padding: 0.40rem">{{$itemRequerimiento->formatoFechaHoraEmision()}}</td>
                <td style = "padding: 0.40rem">{{$itemRequerimiento->formatoFechaHoraRevisionGerente()}}</td>
                
                <td style = "padding: 0.40rem">{{$itemRequerimiento->getEmpleadoSolicitante()->getNombreCompleto()}}</td>
                <td style = "padding: 0.40rem">{{$itemRequerimiento->getProyecto()->getOrigenYNombre()  }}</td>
                <td style = "padding: 0.40rem"> 
                  {{$itemRequerimiento->getJustificacionAbreviada()}} 
                </td>
                <td style="text-align: center; padding: 0.40rem">
                  
                  <input type="text" value="{{$itemRequerimiento->getNombreEstado()}}" class="form-control" readonly 
                  style="background-color: {{$itemRequerimiento->getColorEstado()}};
                          height: 26px;
                          text-align:center;
                          color: {{$itemRequerimiento->getColorLetrasEstado()}} ;
                  "  title="{{$itemRequerimiento->getMensajeEstado()}}">
                </td>
                
                <td style = "padding: 0.40rem">       
                  @if($itemRequerimiento->verificarEstado('Creada') || $itemRequerimiento->verificarEstado('Subsanada')  )
                  <a href="{{route('RequerimientoBS.Gerente.ver',$itemRequerimiento->codRequerimiento)}}" 
                    class="btn btn-warning btn-sm" title="Evaluar Reposición">
                    <i class="fas fa-thumbs-up"></i>
                  </a>
                  @else
                  <a href="{{route('RequerimientoBS.Gerente.ver',$itemRequerimiento->codRequerimiento)}}"
                    class="btn btn-info btn-sm" title="Ver Reposición">
                    <i class="fas fa-eye"></i>
                  </a>
                  @endif
                  <a  href="{{route('RequerimientoBS.exportarPDF',$itemRequerimiento->codRequerimiento)}}" 
                    class="btn btn-primary btn-sm" title="Descargar PDF">
                    <i class="fas fa-file-download"></i>
                  </a>

                  <a target="pdf_reposicion_{{$itemRequerimiento->codRequerimiento}}" href="{{route('RequerimientoBS.verPDF',$itemRequerimiento->codRequerimiento)}}" 
                    class="btn btn-primary btn-sm" title="Ver PDF">
                    <i class="fas fa-file-pdf"></i>
                  </a>
                </td>

              </tr>
          @endforeach
        </tbody>
      </table>
      {{$listaRequerimientos->appends($filtros_usados_paginacion)->links()}}
    </div>
</div>
@endsection


<?php 
  $fontSize = '14pt';
?>
