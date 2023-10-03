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
  <div class="text-center">
    <h3>
      Mis Reposiciones de Gastos 
    </h3>
    
  </div>
  
  <div class="row">
    <div class="col-md-2">
      <a href="{{route('ReposicionGastos.Empleado.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i>Nuevo Registro</a>
    </div>
  </div>
  <div class="row">
    <div class="col">
      {{$comp_filtros->render()}}
    </div>
  </div>
  
  
    

{{-- AQUI FALTA EL CODIGO SESSION DATOS ENDIF xdd --}}
    @include('Layout.MensajeEmergenteDatos')
    <div class="table-container">

      <table class="table table-hover" style="font-size: 10pt">
              <thead class="thead-dark">
                <tr>
                  <th width="9%" scope="col">Cod. Reposición</th> {{-- COD CEDEPAS --}}
                  <th width="9%"  scope="col" style="text-align: center">F. Emisión</th>
                  <th width="9%"  scope="col" style="text-align: center">F. Aprobación</th>
                  
                  <th width="9%"  scope="col" style="text-align: center">Gerente/Director/a por</th>
                  
                  <th  scope="col">Origen & Proyecto</th>              
                  <th>
                    Resumen actividad
                  </th>
                
                  <th width="6%"  scope="col">Banco</th>
                  <th width="8%"  scope="col" style="text-align: center">Total</th>
                  <th width="11%"  scope="col" style="text-align: center">Estado</th>
                  <th width="9%"  scope="col">Opciones</th>
                  
                </tr>
              </thead>
        <tbody>

          {{--     varQuePasamos  nuevoNombre                        --}}
          @foreach($listaReposiciones as $itemreposicion)

        
              <tr>
                <td style = "padding: 0.40rem">{{$itemreposicion->codigoCedepas  }}</td>
                <td style = "padding: 0.40rem; text-align: center">{{$itemreposicion->formatoFechaHoraEmision()}}</td>
                <td style = "padding: 0.40rem; text-align: center">{{$itemreposicion->formatoFechaHoraRevisionGerente()}}</td>

                
                <td style = "padding: 0.40rem; text-align: center">{{$itemreposicion->getNombreGerente()}}</td>
                

                <td style = "padding: 0.40rem">{{$itemreposicion->getProyecto()->getOrigenYNombre()  }}</td>
                <td>
                  {{$itemreposicion->getResumenAbreviado()}}
                </td>
              
                <td style = "padding: 0.40rem">{{$itemreposicion->getBanco()->nombreBanco  }}</td>
                <td style="text-align: right; padding: 0.40rem">{{$itemreposicion->getMoneda()->simbolo}} {{number_format($itemreposicion->monto(),2)}}</td>
                
          
                <td style="text-align: center; padding: 0.40rem">
                  
                  <input type="text" value="{{$itemreposicion->getNombreEstado()}}" class="form-control" readonly 
                  style="background-color: {{$itemreposicion->getColorEstado()}};
                          height: 26px;
                          text-align:center;
                          color: {{$itemreposicion->getColorLetrasEstado()}} ;
                  "  title="{{$itemreposicion->getMensajeEstado()}}">
                </td>
                <td style = "padding: 0.40rem">       
                  <a href="{{route('ReposicionGastos.Empleado.ver',$itemreposicion->codReposicionGastos)}}" 
                      class="btn btn-info btn-sm" title="Ver Reposición" ><i class="fas fa-eye"></i></a>
                  @if($itemreposicion->codEstadoReposicion==5 || $itemreposicion->codEstadoReposicion==1 || $itemreposicion->codEstadoReposicion==6)
                    <a href="{{route('ReposicionGastos.Empleado.editar',$itemreposicion->codReposicionGastos)}}" class="btn btn-warning btn-sm" title="Editar Reposición">
                      <i class="fas fa-edit"></i>
                    </a>
                  @endif
                  @if($itemreposicion->codEstadoReposicion<3)
                      <a href="#" class="btn btn-sm btn-danger" title="Cancelar Reposición" onclick="swal({//sweetalert
                          title:'¿Está seguro de cancelar la reposicion: {{$itemreposicion->codigoCedepas}} ?',
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
                        window.location.href='{{route('ReposicionGastos.cancelar',$itemreposicion->codReposicionGastos)}}';
                      });">
                        <i class="fas fa-trash-alt"> </i>
                    </a>
                  @endif
                  <a  href="{{route('ReposicionGastos.exportarPDF',$itemreposicion->codReposicionGastos)}}" 
                    class="btn btn-info btn-sm" title="Descargar PDF">
                    <i class="fas fa-file-download"></i>
                  </a>

                  <a target="pdf_reposicion_{{$itemreposicion->codReposicionGastos}}" href="{{route('ReposicionGastos.verPDF',$itemreposicion->codReposicionGastos)}}" 
                    class="btn btn-info btn-sm" title="Ver PDF">
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
 