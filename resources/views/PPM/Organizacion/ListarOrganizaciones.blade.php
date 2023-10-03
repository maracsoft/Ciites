@extends('Layout.Plantilla')

@section('titulo')
    PPM - Listar Organizaciones
@endsection

@section('contenido')
@php

  
  $comp_filtros = new App\UI\UIFiltros(false,$filtros_usados);

  $comp_filtros->añadirFiltro([
      'name'=>'codActividadEconomica',
      'label'=>':',
      'show_label'=>false,
      'placeholder'=>'Buscar por actividad económica',
      'type'=>'multiple_select',
      'function'=>'in',
      'options'=>$listaActividades,
      'options_label_field'=>'nombre',
      'options_id_field'=>null,
      'size'=>'md',
      'max_width'=>'',
  ]);
 
  $comp_filtros->añadirFiltro([
      'name'=>'codOrganizacion',
      'label'=>'Unidad productiva',
      'show_label'=>false,
      'placeholder'=>'- Buscar por razón social / RUC -',
      'type'=>'select2',
      'function'=>'equals',
      'options'=>$todasLasOrganizaciones,
      'options_label_field'=>'razonYRUC',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'250px',     
  ]); 

   $comp_filtros->añadirFiltro([
      'name'=>'codDistrito',
      'label'=>'Región',
      'show_label'=>false,
      'placeholder'=>'- Buscar por Región -',
      'type'=>'select2',
      'function'=>'in_departamento',
      'options'=>$listaDepartamentos,
      'options_label_field'=>'nombre',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'250px',
  ]); 


  
  $comp_filtros->añadirFiltro([
      'name'=>'codTipoOrganizacion',
      'label'=>'Tipo de Organización',
      'show_label'=>false,
      'placeholder'=>'- Buscar por Tipo de Org -',
      'type'=>'select2',
      'function'=>'equals',
      'options'=>$listaTiposOrganizacion,
      'options_label_field'=>'nombre',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'250px',
  ]); 


@endphp

<div class="card-body">

  <div class="well">
    <H3 style="text-align: center;">
        <strong>
            Organizaciones PPM
        </strong>
    </H3>
  </div>
  <div class="row d-flex flex-row">

    <a href="{{route('PPM.Organizacion.Crear')}}" class="btn btn-primary m-1">
        <i class="fas fa-plus"></i>
        Nueva Organización
    </a>

  </div>
  
  <div>
    {{$comp_filtros->render()}}
  </div>
    
    
    @include('Layout.MensajeEmergenteDatos')

    <div class="table-responsive">

      <table class="table table-bordered table-hover datatable tablaPaddingReducido" id="table-3">
        <thead class="table-marac-header">
          <tr>
            <th>Cod</th>
            <th>Razón Social</th>
            <th>RUC</th>
            <th class="text-center">
              Tipo
            </th>
            <th>
              Act Económica
            </th>
            <th>
              #Activ.
            </th>
            <th>
              #Socios
            </th>
            <th>Lugar</th>
          
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody>
          
          @foreach($listaOrganizaciones as $organizacion)
              <tr class="FilaPaddingReducido">
                  <td>
                      {{$organizacion->getId()}} 
                  </td>
                  <td class="fontSize11">
                      {{$organizacion->razon_social}}
                  </td>
                  <td>
                      {{$organizacion->ruc}}
                  </td>
                  <td class="text-center">
                      {{$organizacion->getTipoOrganizacion()->nombre}}
                  </td>
                  <td>
                      @if($organizacion->tieneActividadEconomica())
                        {{$organizacion->getActividadEconomica()->nombre}}
                      @else
                        <span class="no-registra">
                          No Registra
                        </span>
                        
                      @endif
                      
                  </td>
                  <td class="text-center">
                      {{$organizacion->getCantidadEjecuciones()}}
                  </td>
                  <td class="text-center">
                      {{$organizacion->getCantidadAsociados()}}
                  </td>
                  <td class="fontSize11">
                      {{$organizacion->getTextoLugar()}}
                  </td>
                  <td class="">
                    <div class="d-flex flex-row">
 
                      <a href="{{route('PPM.Organizacion.Editar',$organizacion->getId())}}" class='btn btn-warning btn-xs' title="Editar UnidadProductiva">
                          <i class="fas fa-pen"></i>
                      </a>
                    </div>




                  </td>
              </tr>
          @endforeach
          
        </tbody>
      </table>

    </div>

    <div class="m-1">
        
        {{$listaOrganizaciones->appends($filtros_usados_paginacion)->links()}}

    </div>


  </div>


@endsection
@section('estilos')

<style>
  .no-registra{
    color:red;
  }
</style>
@endsection