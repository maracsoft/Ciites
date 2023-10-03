
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
    'options'=>$proyectosDelObservador,
    'options_label_field'=>'nombreYcod',
    'options_id_field'=>null,
    'size'=>'sm',
    'max_width'=>'250px',  
  ]); 
  $comp_filtros->añadirFiltro([
    'name'=>'codEstadoRequerimiento',
    'label'=>'Estados:',
    'show_label'=>true,
    'placeholder'=>'Buscar por estados',
    'type'=>'multiple_select',
    'function'=>'in',
    'options'=>$estadosRequerimiento,
    'options_label_field'=>'nombre',
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
  <h3> Supervisar Requerimientos de Bienes y Servicios </h3>
   
  <div class="row">
    <div class="col-md-12">
      {{$comp_filtros->render()}}
    </div>
  </div>
  
  
    
 
    @include('Layout.MensajeEmergenteDatos')
    <div class="table-container">

      <table class="table table-hover" style="font-size: 10pt; margin-top:10px;">
              <thead class="thead-dark">
                <tr>
                  <th width="7%" scope="col">Cod. Requer</th> {{-- COD CEDEPAS --}}
                  <th width="5%"  scope="col" style="text-align: center">F. Emisión</th>
                  <th width="11%" scope="col">Solicitante</th>

                  <th width="5%"  scope="col" style="text-align: center">F. Aprobación</th>
                  <th width="11%" scope="col">Gerente/Director/a</th>


                  
                  <th width="3%"  scope="col" >Origen & Proyecto</th>         
                  <th>
                    Contrapartida
                  </th>
                  <th width="20%">Justificacion</th>              
                  <th width="5%"  scope="col" style="text-align: center">F. Atención</th>
                  
                  <th width="11%"  scope="col" style="text-align: center">Estado</th>
                  <th width="2%"  scope="col" style="text-align: center">Factura?</th>
                  
                  <th width="9%"  scope="col">Opciones</th>
                  
                </tr>
              </thead>
        <tbody>

          {{--     varQuePasamos  nuevoNombre                        --}}
          @foreach($listaRequerimientos as $itemRequerimiento)

        
              <tr>
                <td style = "padding: 0.40rem">{{$itemRequerimiento->codigoCedepas  }}</td>
                <td style = "padding: 0.40rem">{{$itemRequerimiento->formatoFechaHoraEmision()}}</td>
                <td style = "padding: 0.40rem">{{$itemRequerimiento->getEmpleadoSolicitante()->getNombreCompleto()}}</td>
              
                <td style = "padding: 0.40rem">{{$itemRequerimiento->formatoFechaHoraRevisionGerente()}}</td>
                <td style = "padding: 0.40rem">{{$itemRequerimiento->getNombreGerente()}}</td>
                
                
                
                <td style = "padding: 0.40rem">{{$itemRequerimiento->getProyecto()->getOrigenYNombre()}}</td>
                <td>
                  {{$itemRequerimiento->codigoContrapartida}}
                </td>
                <td style="padding:0.40rem">
                  {{$itemRequerimiento->getJustificacionAbreviada()}}
                </td>
                <td style = "padding: 0.40rem">{{$itemRequerimiento->formatoFechaHoraRevisionAdmin()}}</td>
                
                <td style="text-align: center; padding: 0.40rem">
                  
                  <input type="text" value="{{$itemRequerimiento->getNombreEstado()}}" class="form-control" readonly 
                  style="background-color: {{$itemRequerimiento->getColorEstado()}};
                          height: 26px;
                          text-align:center;
                          color: {{$itemRequerimiento->getColorLetrasEstado()}} ;
                  "  title="{{$itemRequerimiento->getMensajeEstado()}}">
                </td>
                <td style = "padding: 0.40rem;" class="text-center">
                  <b style="color:{{$itemRequerimiento->getColorSiTieneFactura()}}">
                    {{$itemRequerimiento->getSiTieneFactura()}}
                  </b>
                
                </td>
                
                <td style = "padding: 0.40rem">       
                  
                  
                  <a href="{{route('RequerimientoBS.Observador.Ver',$itemRequerimiento->getId())}}"
                    class="btn btn-info btn-sm" title="Ver Requerimiento">
                    <i class="fas fa-eye"></i>
                  </a>

              
                  <a  href="{{route('RequerimientoBS.exportarPDF',$itemRequerimiento->getId())}}" 
                    class="btn btn-primary btn-sm" title="Descargar PDF">
                    <i class="fas fa-file-download"></i>
                  </a>

                  <a target="pdf_reposicion_{{$itemRequerimiento->getId()}}" href="{{route('RequerimientoBS.verPDF',$itemRequerimiento->codRequerimiento)}}" 
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

@section('script')

<script>


    
 


</script>
@endsection