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
  <div class="text-center">
    <h3> Mis Requerimientos de Bienes y Servicios </h3>
  </div>
  
  <div class="row mx-2">
    <a href="{{route('RequerimientoBS.Empleado.CrearRequerimientoBS')}}" class="btn btn-primary">
      <i class="fas fa-plus"></i>
      Nuevo Registro
    </a>
  </div>
  <div class="row">
    <div class="col">
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
          <th width="6%"  scope="col" style="text-align: center">F. Revisión</th>
          
          <th width="6%"  scope="col" style="text-align: center">Gerente/Director/a</th>
            
          <th  scope="col">Origen & Proyecto</th>         
          <th>Justificacion</th>     
          <th width="11%"  scope="col" style="text-align: center">Estado</th>
          
          <th width="3%" class="text-center"  scope="col"  >
            Fact /
            <button type="button" class="btn btn-warning btn-xs" onclick="mostrarMensajeExplicativoFactura()">
              <i class="fas fa-question fa-xs"> </i>
            </button> Contabilizada
          </th>
          
          <th width="13%"  scope="col">Opciones</th>
          
        </tr>
      </thead>
      <tbody>

        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($listaRequerimientos as $itemRequerimiento)

      
            <tr>
              <td style = "padding: 0.40rem">
                  {{$itemRequerimiento->codigoCedepas  }}
              </td>
              <td style = "padding: 0.40rem">
                  {{$itemRequerimiento->formatoFechaHoraEmision()}}
              </td>
              <td style = "padding: 0.40rem">
                  {{$itemRequerimiento->formatoFechaHoraRevisionGerente()}}
              </td>
              
              <td style = "padding: 0.40rem">
                  {{$itemRequerimiento->getNombreGerente()}}
              </td>
              
              <td style = "padding: 0.40rem">
                  {{$itemRequerimiento->getProyecto()->getOrigenYNombre()}}
              </td>
              
              <td>
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

              <td style="padding:0.40rem" class="text-center">
                <b style="color: {{$itemRequerimiento->getColorSiTieneFactura()}}">
                  {{$itemRequerimiento->getSiTieneFactura()}}
                </b>
                /
                <b style="color: {{$itemRequerimiento->getColorFacturaContabilizada()}}">
                  {{$itemRequerimiento->getFacturaContabilizada()}}
                </b>
              </td>
              
              <td style = "padding: 0.40rem">       
                <a href="{{route('RequerimientoBS.Empleado.ver',$itemRequerimiento->codRequerimiento)}}" class="btn btn-info btn-sm" title="Ver Requerimiento" >
                    @if($itemRequerimiento->estaContabilizada() && $itemRequerimiento->adminPuedeSubirArchivos())
                      Subir factura
                    @endif  
                    <i class="fas fa-eye"></i>
                </a>
                @if($itemRequerimiento->listaParaEditar())
                  <a href="{{route('RequerimientoBS.Empleado.EditarRequerimientoBS',$itemRequerimiento->codRequerimiento)}}"
                    class="btn btn-warning btn-sm" title="Editar Requerimiento">
                    <i class="fas fa-edit"></i>
                  </a>
                @endif

                @if($itemRequerimiento->listaParaCancelar())
                  <a href="#" class="btn btn-sm btn-danger" title="Cancelar Requerimiento" 
                    onclick="clickCancelar({{$itemRequerimiento->codRequerimiento}})">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                @endif
              </td>

            </tr>
        @endforeach
      </tbody>
    </table>
    {{$listaRequerimientos->appends($filtros_usados_paginacion)->links()}}
  </div>
</div>
@endsection

@section('script')

<script>
  function mostrarMensajeExplicativoFactura(){

    alertaMensaje(
      "Facturas",
      /* html */
      `Ahora puede hacer seguimiento a la factura de su requerimiento, además de subirla usted mismo/a.
      <br>
      
      
      `
      ,"info"
    );

  }


  function clickCancelar(codRequerimiento){

    codRequerimientoAEliminar = codRequerimiento;
    confirmarConMensaje("Cancelar","¿Seguro que desea cancelar el requerimiento?","warning",ejecutarCancelar);

  }

  codRequerimientoAEliminar = 0;
  function ejecutarCancelar(){
    window.location.href="/RequerimientoBS/"+codRequerimientoAEliminar+"/Cancelar";
  }


</script>

@endsection
 
