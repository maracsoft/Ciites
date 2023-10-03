@extends('Layout.Plantilla')

@section('titulo')
    PPM Actividades
@endsection

@section('contenido')
@php

  $comp_filtros = new App\UI\UIFiltros(false,$filtros_usados);

  $comp_filtros->añadirFiltro([
      'name'=>'codEmpleadoCreador',
      'label'=>':',
      'show_label'=>false,
      'placeholder'=>'Buscar por usuario que registró',
      'type'=>'select2',
      'function'=>'equals',
      'options'=>$listaEmpleados,
      'options_label_field'=>'nombreCompleto',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'',
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
      'name'=>'codOrganizacion',
      'label'=>'Organización',
      'show_label'=>false,
      'placeholder'=>'- Buscar por organización -',
      'type'=>'select2',
      'function'=>'equals',
      'options'=>$TodasLasOrganizaciones,
      'options_label_field'=>'razonYRUC',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'250px',     
  ]);

  $comp_filtros->añadirFiltro([
      'name'=>'codMesAño',
      'label'=>':',
      'show_label'=>false,
      'placeholder'=>'Buscar por mes',
      'type'=>'select',
      'function'=>'equals',
      'options'=>$listaMesAño,
      'options_label_field'=>'texto',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'',
  ]);
  

@endphp

<div class="card-body">

    <div class="well">
        <H3 style="text-align: center;">
            <strong>
                Actividades
            </strong>
        </H3>
    </div>
    <div class="row">
        <a href="{{route('PPM.Actividad.Crear')}}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Nueva Actividad
        </a>

    </div>
    <div>
      {{$comp_filtros->render()}}
    </div>
        @include('Layout.MensajeEmergenteDatos')

        <div class="table-responsive">
          <table class="table table-bordered table-hover datatable fontSize10" id="table-3">
            <thead class="table-marac-header">
                <tr>
                  <th>Cod</th>
                  <th>Descripcion</th>
                  <th>Organización</th>
                  <th class="text-center">
                    Semestre
                  </th>
                  <th class="text-center">
                    Lugar
                  </th>
                  <th>
                    Actividad
                  </th>
                  <th>Creado por</th>
                  <th>Opciones</th>


                </tr>
            </thead>
            <tbody>

                @foreach($listaActividades as $actividad)
                    <tr class="FilaPaddingReducido">
                        <td>
                            {{$actividad->getId()}}
                        </td>
                        <td class="fontSize9">
                            {{$actividad->descripcion}}
                        </td>
                        <td class="fontSize10">
                            {{$actividad->getOrganizacion()->getDenominacion()}}
                            [{{$actividad->getOrganizacion()->getRucODNI()}}]

                        </td>
                        <td class="text-center">
                            {{$actividad->getResumenSemestres()}}
                            
                        </td>

                        <td class="text-center">
                            {{$actividad->getTextoLugar()}}
                        </td>
                        
                        <td>
                            [{{$actividad->getActividad()->codigo_presupuestal}}]
                            {{$actividad->getActividad()->descripcion}}
                        </td>
                        
                        <td class="fontSize9">
                          {{$actividad->getEmpleadoCreador()->getNombreCompleto()}}
                          <br>
                          <span class="fontSize7">
                              {{$actividad->getFechaHoraCreacion()}}
                          </span>
                        </td>
                        <td>
                           

                            <a href="{{route('PPM.Actividad.Editar',$actividad->getId())}}" class = "btn btn-sm btn-warning"
                              title="Editar Actividad">
                              <i class="fas fa-edit"></i>
                            </a>

                            <a href="{{route('PPM.Actividad.CrearEnBaseAOtro',$actividad->getId())}}" class = "btn btn-sm btn-info m-1"
                              title="Duplicar Actividad">
                              <i class="fas fa-copy"></i>
                            </a>
                            
                            <button type="button" onclick="clickEliminarTotalmente({{$actividad->getId()}},'{{$actividad->descripcion}}')"  class="btn btn-sm btn-danger"
                                title="Eliminar Actividad">
                                <i class="fas fa-trash"></i>
                            </button>

                        </td>


                    </tr>

                @endforeach
                @if(count($listaActividades)==0)
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
          {{$listaActividades->appends($filtros_usados_paginacion)->links()}}
        </div>



    </div>





 


@endsection
@section('script')
 
<script>


    function clickEliminarTotalmente(codActividad,nombre){
        confirmarConMensaje("Confirmación","¿Desea eliminar la Actividad \""+nombre+"\" ?",'warning',function(){
            location.href = "/PPM/Actividad/Eliminar/" + codActividad;
        })
    }



    function validarReporte(){
        limpiarEstilos(['reporte_codModalidad','reporte_fechaInicio','reporte_fechaFin'])
        msj = "";

        msj = validarSelect(msj,'reporte_codModalidad',-1,'Modalidad');


        msj = validarNulidad(msj,'reporte_fechaInicio','Fecha inicial');
        msj = validarNulidad(msj,'reporte_fechaFin','Fecha Final');


        return msj;
    }
 



</script>
@endsection
