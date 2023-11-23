@extends('Layout.Plantilla')

@section('titulo')
    Contratos de Plazo Fijo
@endsection

@section('contenido')

@php


$rendida_options = [
  ['value'=>1,"label"=>"Sí"],
  ['value'=>0,"label"=>"No"]
];
$comp_filtros = new App\UI\UIFiltros(false,$filtros_usados);


$comp_filtros->añadirFiltro([
  'name'=>'codEmpleadoCreador',
  'label'=>'Creador:',
  'show_label'=>true,
  'placeholder'=>'- Creador -',
  'type'=>'select2',
  'function'=>'equals',
  'options'=>$listaEmpleadosQueGeneraronContratos,
  'options_label_field'=>'getNombreCompleto',
  'options_id_field'=>null,
  'size'=>'',
  'max_width'=>'450px',
]);

$comp_filtros->añadirFiltro([
  'name'=>'dni',
  'label'=>'Contratado:',
  'show_label'=>true,
  'placeholder'=>'- Nombre y DNI -',
  'type'=>'select2',
  'function'=>'equals',
  'options'=>$listaNombresDeContratados,
  'options_label_field'=>'nombre_dni',
  'options_id_field'=>'dni',
  'size'=>'',
  'max_width'=>'450px',
]);

$comp_filtros->añadirFiltro([
  'name'=>'nombrePuesto',
  'label'=>'Puesto:',
  'show_label'=>true,
  'placeholder'=>'Nombre del puesto',
  'type'=>'text',
  'function'=>'contains',
  'options'=>'',
  'options_label_field'=>'',
  'options_id_field'=>'',
  'size'=>'',
  'max_width'=>'450px',
]);

$comp_filtros->añadirFiltro([
  'name'=>'nombreProyecto',
  'label'=>'Proyecto:',
  'show_label'=>true,
  'placeholder'=>'Nombre del proyecto',
  'type'=>'text',
  'function'=>'contains',
  'options'=>'',
  'options_label_field'=>'',
  'options_id_field'=>'',
  'size'=>'',
  'max_width'=>'450px',
]);


@endphp

<div class="card-body">
  <div class="well">
        <H3 style="text-align: center;">
            <strong>
                Contratos de Plazo Fijo
            </strong>
        </H3>
  </div>
  <div class="row">
      <div class="col m-2">
        <a href="{{route('ContratosPlazo.Crear')}}" class="btn btn-primary">
          <i class="fas fa-plus"></i>
          Nuevo Registro
        </a>
      </div>
  </div>

  <div class="row">
    {{$comp_filtros->render()}}
  </div>

    @include('Layout.MensajeEmergenteDatos')

    <table class="table table-bordered table-hover datatable table-sm" id="table-3">
      <thead>
        <tr>
          <th>Cod</th>
          <th>Creador</th>
          <th>Contratado</th>

          <th>Duración contrato</th>
          <th>Puesto</th>

          <th>
            Remuneración
          </th>
          <th>
            Opc
          </th>
        </tr>
      </thead>
      <tbody>

        @foreach($listaContratos as $contrato)
            <tr @if($contrato->estaAnulado()) style="background-color: rgba(255, 143, 143, 0.801)" @endif>
                <td>

                  <span class="fontSize10">
                    {{$contrato->codigoCedepas}}
                  </span>

                    @if($contrato->estaAnulado())
                      <span class="fontSize8">
                        ANULADO
                      </span>
                    @endif
                </td>
                <td>
                    {{$contrato->getEmpleadoCreador()->getNombreCompleto()}}
                    <br>
                    <span class="fontSize9">
                      Creado el {{$contrato->getFechaHoraEmision()}}
                    </span>
                </td>

                <td>
                    {{$contrato->getNombreCompleto()}}
                    <span class="fontSize10">
                        [{{$contrato->dni}}]
                    </span>
                </td>

                <td>
                    {{$contrato->getFechaInicio()}}
                    al
                    {{$contrato->getFechaFin()}}
                </td>
                <td>
                    {{$contrato->puesto}}
                </td>
                <td class="text-right">
                  {{$contrato->getMoneda()->simbolo}} {{$contrato->remuneracion_mensual}}
                </td>
                <td>

                  <a class="btn btn-primary btn-sm" href="{{route('ContratosPlazo.Ver',$contrato->getId())}}">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{route('ContratosPlazo.descargarPDF',$contrato->getId())}}" class='btn btn-info btn-sm'  title="Descargar PDF">
                    <i class="fas fa-file-download"></i>
                  </a>
                  <a target="pdf_solicitud_{{$contrato->getId()}}" href="{{route('ContratosPlazo.verPDF',$contrato->getId())}}"
                     class='btn btn-info btn-sm'  title="Ver PDF">
                    <i class="fas fa-file-pdf"></i>
                  </a>

                  @if($contrato->sePuedeAnular())


                    <button type="button" onclick="clickEliminar({{$contrato->getId()}})"
                      class='btn btn-danger btn-xs' title="Anular">
                      <i class="fas fa-trash"></i>
                    </button>
                  @endif
                </td>

            </tr>
        @endforeach

      </tbody>
    </table>

    <div class="mt-4">
      {{$listaContratos->appends($filtros_usados_paginacion)->links()}}
    </div>

  </div>


@endsection
@section('script')
    <script>

      idAnular = 0;

      function clickEliminar(id){
        idAnular = id;
        confirmarConMensaje("Confirmar","¿Desea anular el contrato?","warning",ejecutarAnular);
      }
      function ejecutarAnular(){
        location.href ="/ContratosPlazo/Anular/"+idAnular;
      }



    </script>


@endsection
