@extends('Layout.Plantilla')

@section('titulo')
    PPM Personas
@endsection

@section('contenido')
@php

  $comp_filtros = new App\UI\UIFiltros(false,$filtros_usados);


  $comp_filtros->añadirFiltro([
    'name'=>'dni',
    'label'=>'DNI:',
    'show_label'=>true,
    'placeholder'=>'Buscar por DNI',
    'type'=>'text',
    'function'=>'contains',
    'options'=>[],
    'options_label_field'=>'nombreCompleto',
    'options_id_field'=>null,
    'size'=>'sm',
    'max_width'=>'',
  ]);

  $comp_filtros->añadirFiltro([
    'name'=>'nombrecompleto_busqueda',
    'label'=>'Nombre',
    'show_label'=>true,
    'placeholder'=>'Buscar por nombre',
    'type'=>'text',
    'function'=>'contains',
    'options'=>[],
    'options_label_field'=>'nombre',
    'options_id_field'=>null,
    'size'=>'sm',
    'max_width'=>'250px',
  ]);




@endphp

<div class="p-3">

    <div class="well">
        <H3 style="text-align: center;">
            <strong>
                Personas
            </strong>
        </H3>
    </div>
    <div class="row">
        <a href="{{route('PPM.Persona.Crear')}}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Nueva Persona
        </a>

    </div>

    {{$comp_filtros->render()}}

    @include('Layout.MensajeEmergenteDatos')

    <div class="table-responsive">


      <table class="table table-bordered table-hover datatable fontSize10" id="table-3">
        <thead class="table-marac-header">
            <tr>
              <th>Cod</th>
              <th>Nombre</th>
              <th>DNI</th>
              <th>Telefono</th>
              <th>Correo</th>
              <th>Sexo</th>
              
              
              <th>Creado por</th>
              <th>Opciones</th>


            </tr>
        </thead>
        <tbody>

            @foreach($listaPersonas as $persona)
                <tr class="FilaPaddingReducido">
                    <td>
                        {{$persona->getId()}}
                    </td>
                    <td class="fontSize9">
                        {{$persona->getNombreCompleto()}}
                    </td>
                    <td class="fontSize10">
                        {{$persona->dni}}
                    </td>
                    <td class="text-left">
                        {{$persona->telefono}}
                    </td>

                    <td class="text-left">
                        {{$persona->correo}}
                    </td>
                    <td class="text-left">
                        {{$persona->getSexoLabel()}}
                    </td>
                     
                    <td class="fontSize9">
                      {{$persona->getEmpleadoCreador()->getNombreCompleto()}}
                      <br>
                      <span class="fontSize7">
                          {{$persona->getFechaHoraCreacion()}}
                      </span>
                    </td>
                    <td>
                       

                        <a href="{{route('PPM.Persona.Editar',$persona->getId())}}" class = "btn btn-sm btn-warning"
                          title="Editar Actividad">
                          <i class="fas fa-edit"></i>
                        </a>

                        <button @if(!$persona->sePuedeBorrar()) disabled @endif type="button"  onclick="clickEliminarTotalmente({{$persona->getId()}},'{{$persona->getNombreCompleto()}}')"  class = "btn btn-sm btn-danger"
                            title="Eliminar Actividad">
                            <i class="fas fa-trash"></i>
                        </button>

                    </td>


                </tr>

            @endforeach
            @if(count($listaPersonas)==0)
                <tr>
                    <td colspan="10" class="text-center">
                        No hay resultados
                    </td>
                </tr>
            @endif

        </tbody>
      </table>  

    </div>

    <div class="m-1">
      {{$listaPersonas->appends($filtros_usados_paginacion)->links()}}
    </div>



</div>





 


@endsection
@section('script')
@include('Layout.ValidatorJS')
<script>


    function clickEliminarTotalmente(codPersona,nombre){
        confirmarConMensaje("Confirmación","¿Desea eliminar la persona "+nombre+" ?",'warning',function(){
            location.href = "/PPM/Persona/Eliminar/" + codPersona;
        })
    }


 
 



</script>
@endsection
