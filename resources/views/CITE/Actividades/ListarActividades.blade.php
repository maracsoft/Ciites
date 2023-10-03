@extends('Layout.Plantilla')

@section('titulo')
   Actividades del CITE
@endsection
@section('tiempoEspera')
    <div class="loader" id="pantallaCarga"></div>
@endsection
@section('contenido')
 


@php

  $comp_filtros = new App\UI\UIFiltros(false,$filtros_usados);

  $comp_filtros->añadirFiltro([
      'name'=>'codTipoServicio',
      'label'=>':',
      'show_label'=>false,
      'placeholder'=>'Tipo de servicio',
      'type'=>'select',
      'function'=>'equals',
      'options'=>$listaTiposServicio,
      'options_label_field'=>'nombre',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'',
  ]);

@endphp


<div class="p-2">
  
    <div class="well">
        <H3 style="text-align: center;">
            <strong>
                Actividades del CITE  
            </strong>
        </H3>
    </div>
    @include('Layout.MensajeEmergenteDatos')
     

    <div class="row">
        <div class="col-sm-12">
          <a class="btn btn-primary" href="{{route('CITE.Actividades.Crear')}}">
            Nueva
          </a>
        </div>
    </div>

    <div class="row">

      {{$comp_filtros->render()}}
     

    </div>

    <table class="table table-striped table-bordered table-condensed table-hover" >
        <thead  class="thead-default">
            <tr>
                <th>
                    ID
                </th>
                <th class="text-right">
                    Nombre
                </th>
                <th class="text-left">
                    Descripcion
                </th>
                <th class="text-right">
                    Índice
                </th>
                <th class="text-right">
                    Tipo de Servicio
                </th>
                <th>
                  Modalidad
                </th>
                <th>
                  # Archivos necesarios
                </th>
                <th>
                  # Indicadores
                </th>
                <th>
                    Opciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($listaActividades as $actividad )
                <tr class="FilaPaddingReducido">
                    <td>
                        {{$actividad->getId()}}
                    </td>
                    <td class="text-right">
                        {{$actividad->nombre}}
                    </td>
                    <td class="text-left">
                        {{$actividad->descripcion}}
                    </td>
                    <td class="text-right">
                        {{$actividad->indice}}
                    </td>
                    <td class="text-right">
                        {{$actividad->getTipoServicio()->nombre}}
                    </td>
                    <td>
                      {{$actividad->getTipoServicio()->getModalidad()->nombre}}
                    </td>
                    <td>
                      {{$actividad->getCantidadArchivosNecesarios()}}
                    </td>
                    <td>
                      {{$actividad->getCantidadIndicadores()}}
                    </td>
                  
                    <td class="text-center">
                        
                      <a href="{{route('CITE.Actividades.Editar',$actividad->getId())}}" class="btn btn-warning btn-xs">
                          <i class="fas fa-pen"></i>
                      </a>
                    
                      <button @if($actividad->apareceEnOtrasTablas()) disabled title="Eliminar primero los medios de verificacion vinculados" @endif type="button" class="btn btn-danger btn-xs" onclick="clickEliminar({{$actividad->getId()}},'{{$actividad->nombre}}')">
                        <i class="fas fa-trash"></i>
                      </button>
                        

                    </td>
                </tr>
            @endforeach
            

        </tbody>
    </table>
    
    
    
   
    
</div>
  
  

@endsection


@section('script')
 
<script>

    
    $(document).ready(function(){

    

      $(".loader").fadeOut("slow");
    });

 
 
  

    var codActividadEliminar = 0;
    function clickEliminar(codActividad,nombre){
      codActividadEliminar = codActividad;
      confirmarConMensaje("Confirmación","¿Desea eliminar a la actividad "+nombre+" de la base de datos?",'warning',function(){
        location.href= "/Cite/Actividades/Eliminar/" + codActividadEliminar;
      })
    }

     
 
</script>

@endsection