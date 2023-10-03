@extends('Layout.Plantilla')

@section('titulo')
    CITE - Listar UnidadesProductivas
@endsection
@section('tiempoEspera')
    <div class="loader" id="pantallaCarga"></div>
@endsection
@section('contenido')
@php

  
  $comp_filtros = new App\UI\UIFiltros(false,$filtros_usados);

  $comp_filtros->añadirFiltro([
      'name'=>'codCadena',
      'label'=>':',
      'show_label'=>false,
      'placeholder'=>'Buscar por cadena',
      'type'=>'multiple_select',
      'function'=>'in',
      'options'=>$listaCadenas,
      'options_label_field'=>'nombre',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'',
  ]);
  $comp_filtros->añadirFiltro([
      'name'=>'codUnidadProductiva',
      'label'=>'Unidad productiva',
      'show_label'=>false,
      'placeholder'=>'- Buscar por razón social / RUC -',
      'type'=>'select2',
      'function'=>'equals',
      'options'=>$todasLasUnidadesProduc,
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
  
  
@endphp

<div class="card-body">

  <div class="well">
    <H3 style="text-align: center;">
        <strong>
            Unidades Productivas 

        </strong>
    </H3>
  </div>
  <div class="row d-flex flex-row">


    <a href="{{route('CITE.UnidadesProductivas.Crear')}}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Nueva Unidad Productiva
    </a>


    @if(App\Empleado::getEmpleadoLogeado()->puedeGenerarReportesCITE())
        <a class="btn btn-success ml-auto" href="{{route('CITE.UnidadesProductivas.Reporte')}}">
            <i class="fas fa-file-excel"></i>
            Descargar Reporte
        </a>
       
    @endif



  </div>
 
    {{$comp_filtros->render()}}
    
    @include('Layout.MensajeEmergenteDatos')

    <table class="table table-bordered table-hover datatable tablaPaddingReducido" id="table-3">
      <thead>
        <tr>
          <th>Cod</th>
          <th>Razón Social</th>
          <th>RUC/DNI</th>

          <th>Cadena</th>
          <th>Lugar</th>
          <th>Tipo Personeria</th>
          <th>#Servicios en el sistema</th>

          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
       
        @foreach($listaUnidadesProductivas as $unidadProductiva)
            <tr class="FilaPaddingReducido">
                <td>
                    {{$unidadProductiva->getId()}} 
                     
                     
                </td>
                <td class="fontSize11">
                    {{$unidadProductiva->getDenominacion()}}
                </td>
                <td>
                    {{$unidadProductiva->getRucODNI()}}
                </td>

                <td class="fontSize11">
                    {{$unidadProductiva->getNombreCadena()}}
                </td>
                <td class="fontSize11">
                    {{$unidadProductiva->getTextoLugar()}}
                </td>
                <td class="fontSize11">
                    {{$unidadProductiva->getTipoPersoneria()->nombre}}
                </td>
                <td>
                    {{$unidadProductiva->getNroServicios()}}
                </td>

                <td class="d-flex flex-row">

                    <a href="{{route('CITE.UnidadesProductivas.Ver',$unidadProductiva->getId())}}" class='btn btn-info btn-xs mr-1' title="Ver Unidad Productiva">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{route('CITE.UnidadesProductivas.Editar',$unidadProductiva->getId())}}" class='btn btn-warning btn-xs' title="Editar UnidadProductiva">
                        <i class="fas fa-pen"></i>
                    </a>

                    @if($unidadProductiva->usuarioLogeadoPuedeEliminar())
                      <button @if($unidadProductiva->apareceEnOtrasTablas()) disabled title="La unidad productiva aparece en otras tablas" @endif type="button" class="ml-1 btn btn-danger btn-xs" onclick="clickEliminar({{$unidadProductiva->getId()}},'{{$unidadProductiva->getDenominacion()}}')">
                        <i class="fas fa-trash"></i>
                      </button>
                    @endif

                </td>
            </tr>
        @endforeach
        
      </tbody>
    </table>
    <div class="m-1">
       
        {{$listaUnidadesProductivas->appends($filtros_usados_paginacion)->links()}}

    </div>


  </div>


@endsection
@section('script')
<script>


    $(document).ready(function(){
      $(".loader").fadeOut("slow");
    });

  @if($unidadProductiva->usuarioLogeadoPuedeEliminar())
    var codUnidadProductivaEliminar = 0;
    function clickEliminar(codUnidadProductiva,nombre){
      codUnidadProductivaEliminar = codUnidadProductiva;
      confirmarConMensaje("Confirmación","¿Desea eliminar a la unidad productiva "+nombre+" de la base de datos?",'warning',ejecutarEliminar)
    }

    function ejecutarEliminar(){
      //llamamos a un endpoint modo API y luego recargamos la página (para no perder la busqueda y paginacion actual)
      $(".loader").show();
      $.get('/Cite/UnidadesProductivas/Eliminar/'+codUnidadProductivaEliminar,function(data){
         
        data = JSON.parse(data);

        alertaMensaje(data.titulo,data.mensaje,data.tipoWarning);
       
        setTimeout(function(){
          location.reload();
        }, 3000);


        
      });

    }

  @endif


</script>

@endsection