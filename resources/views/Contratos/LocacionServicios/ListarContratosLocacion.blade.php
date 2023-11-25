@extends('Layout.Plantilla')

@section('titulo')
    Contratos de locación
@endsection

@section('contenido')


@php


$tipos_contrato = [
  [
    "id" => 1,
    "nombre" => "CEDEPAS",
  ],
  [
    "id" => 0,
    "nombre" => "GPC",
  ]
];


$tipos_personas = [
  [
    "id" => 1,
    "nombre" => "Persona Natural",
  ],
  [
    "id" => 0,
    "nombre" => "Persona Jurídica",
  ]
];



$comp_filtros = new App\UI\UIFiltros(false,$filtros_usados);


$comp_filtros->añadirFiltro([
  'name'=>'codEmpleadoCreador',
  'label'=>'Creador:',
  'show_label'=>true,
  'placeholder'=>'- Creador -',
  'type'=>'select2',
  'function'=>'equals',
  'options'=>$listaEmpleadosQueGeneraronContratosLocacion,
  'options_label_field'=>'getNombreCompleto',
  'options_id_field'=>null,
  'size'=>'',
  'max_width'=>'450px',
]);




$comp_filtros->añadirFiltro([
  'name'=>'esPersonaNatural',
  'label'=>'Tipo Persona:',
  'show_label'=>true,
  'placeholder'=>'- Tipo Persona -',
  'type'=>'select',
  'function'=>'equals',
  'options'=>$tipos_personas,
  'options_label_field'=>'nombre',
  'options_id_field'=>'id',
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
  'name'=>'ruc',
  'label'=>'Razón Social:',
  'show_label'=>true,
  'placeholder'=>'- Razón Social y RUC -',
  'type'=>'select2',
  'function'=>'equals',
  'options'=>$listaRazonesSociales,
  'options_label_field'=>'nombre_ruc',
  'options_id_field'=>'ruc',
  'size'=>'',
  'max_width'=>'450px',
]);




$comp_filtros->añadirFiltro([
  'name'=>'codMoneda',
  'label'=>'Moneda:',
  'show_label'=>true,
  'placeholder'=>'- Moneda -',
  'type'=>'select',
  'function'=>'equals',
  'options'=>$listaMonedas,
  'options_label_field'=>'nombre',
  'options_id_field'=>null,
  'size'=>'',
  'max_width'=>'450px',
]);

@endphp

<div class="card-body">
  <div class="well">
        <H3 style="text-align: center;">
            <strong>
                Contratos de locación
            </strong>
        </H3>
  </div>
  <div class="row">

    <div class="col">
      <a href="{{route('ContratosLocacion.Crear')}}" class="btn btn-primary">
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
          <th>Fecha emisión</th>
          <th>Duración contrato</th>
          <th>Tipo</th>
          <th>
            Retribución total
          </th>
          <th >
            Opc
          </th >
        </tr >
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
                </td>

                <td>
                    @if($contrato->esDeNatural())
                      {{$contrato->getNombreCompleto()}}
                      <span class="fontSize10">

                          DNI[{{$contrato->dni}}]
                          (P.Nat)
                      </span>

                    @else
                      {{$contrato->razonSocialPJ}}
                      <span class="fontSize10">
                        RUC[{{$contrato->ruc}}]
                        (P.Jur)
                      </span>

                    @endif


                </td>
                <td>
                    {{$contrato->getFechaHoraEmision()}}
                </td>
                <td>
                    {{$contrato->getFechaInicioEscrita()}}
                    //
                    {{$contrato->getFechaFin()}}
                </td>
                <td>

                </td>
                <td class="text-right">
                    {{$contrato->getMoneda()->simbolo}}
                    {{$contrato->getRetribucionTotal()}}
                </td>

                <td>

                  <a class="btn btn-primary btn-sm" href="{{route('ContratosLocacion.Ver',$contrato->getId())}}">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a class="btn btn-warning btn-sm" href="{{route('ContratosLocacion.Editar',$contrato->getId())}}">
                    <i class="fas fa-pen"></i>
                  </a>

                  <a href="{{route('ContratosLocacion.descargarPDF',$contrato->getId())}}" class='btn btn-info btn-sm'  title="Descargar PDF">
                    <i class="fas fa-file-download"></i>
                  </a>
                  <a target="pdf_CL_{{$contrato->getId()}}" href="{{route('ContratosLocacion.verPDF',$contrato->getId())}}"
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
          location.href ="/ContratosLocacion/Anular/"+idAnular;
        }


    </script>


@endsection
