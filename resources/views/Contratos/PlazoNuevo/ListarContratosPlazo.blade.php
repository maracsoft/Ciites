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

$comp_filtros->añadirFiltro([
  'name'=>'tipo_contrato',
  'label'=>'Tipo Contrato:',
  'show_label'=>true,
  'placeholder'=>'- Tipo Contrato -',
  'type'=>'select',
  'function'=>'equals',
  'options'=>$listaTiposContrato,
  'options_label_field'=>'nombre',
  'options_id_field'=>'id',
  'size'=>'',
  'max_width'=>'450px',
]);


@endphp


  <div class="p-2">
    <div class="page-title">
      Contratos de Plazo Fijo 2024
    </div>
  </div>
  <div class="row">
      <div class="col m-2">
        <a href="{{route('ContratosPlazoNuevo.Crear')}}" class="btn btn-primary">
          <i class="fas fa-plus"></i>
          Nuevo Registro
        </a>
      </div>
  </div>

  <div class="row">
    {{$comp_filtros->render()}}
  </div>

  @include('Layout.MensajeEmergenteDatos')

  <table class="table table-bordered table-hover datatable table-sm">
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
          Tipo de Contrato
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
                  {{$contrato->codigo_unico}}
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
                  {{$contrato->getFechaInicioEscrita()}}
                  al
                  {{$contrato->getFechaFinEscrita()}}
              </td>
              <td>
                  {{$contrato->puesto}}
              </td>
              <td class="text-right">
                {{$contrato->getMoneda()->simbolo}} {{$contrato->remuneracion_mensual}}
              </td>
              <td class="text-center">
                {{$contrato->getTipoContratoLabel()}}
              </td>
              <td>

                @if ($contrato->sePuedeEditar())
                  <a class="btn btn-warning btn-sm" href="{{route('ContratosPlazoNuevo.Editar',$contrato->getId())}}">
                    <i class="fas fa-pen"></i>
                  </a>
                @endif


                <a class="btn btn-primary btn-sm" href="{{route('ContratosPlazoNuevo.Ver',$contrato->getId())}}">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="{{route('ContratosPlazoNuevo.descargarPDF',$contrato->getId())}}" class='btn btn-info btn-sm'  title="Descargar PDF">
                  <i class="fas fa-file-download"></i>
                </a>
                <a target="pdf_solicitud_{{$contrato->getId()}}" href="{{route('ContratosPlazoNuevo.verPDF',$contrato->getId())}}"
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



@endsection
@section('script')
<script>

  idAnular = 0;

  function clickEliminar(id){
    idAnular = id;
    confirmarConMensaje("Confirmar","¿Desea anular el contrato?","warning",ejecutarAnular);
  }
  function ejecutarAnular(){
    location.href ="/ContratosPlazoNuevo/Anular/"+idAnular;
  }



</script>


@endsection
