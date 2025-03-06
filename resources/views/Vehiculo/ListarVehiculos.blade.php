@extends ('Layout.Plantilla')
@section('titulo')
  Vehículos
@endsection

@php
  $comp_filtros = new App\UI\UIFiltros(false, $filtros_usados);

  $comp_filtros->añadirFiltro([
      'name' => 'codSede',
      'label' => 'Sede:',
      'show_label' => true,
      'placeholder' => '- Sede -',
      'type' => 'select',
      'function' => 'equals',
      'options' => $listaSedes,
      'options_label_field' => 'nombre',
      'options_id_field' => null,
      'size' => 'sm',
      'max_width' => '250px',
  ]);

  $comp_filtros->añadirFiltro([
      'name' => 'placa',
      'label' => 'Placa:',
      'show_label' => true,
      'placeholder' => 'Placa',
      'type' => 'text',
      'function' => 'contains',
      'options' => '',
      'options_label_field' => 'nombre',
      'options_id_field' => null,
      'size' => 'sm',
      'max_width' => '250px',
  ]);

  $comp_filtros->añadirFiltro([
      'name' => 'modelo',
      'label' => 'Modelo:',
      'show_label' => true,
      'placeholder' => 'Modelo',
      'type' => 'text',
      'function' => 'contains',
      'options' => '',
      'options_label_field' => 'nombre',
      'options_id_field' => null,
      'size' => 'sm',
      'max_width' => '250px',
  ]);

  $comp_filtros->añadirFiltro([
      'name' => 'color',
      'label' => 'Color:',
      'show_label' => true,
      'placeholder' => 'Color',
      'type' => 'text',
      'function' => 'contains',
      'options' => '',
      'options_label_field' => 'nombre',
      'options_id_field' => null,
      'size' => 'sm',
      'max_width' => '250px',
  ]);
@endphp


@section('contenido')
  <div>
    <div class="p-1">
      <div class="page-title">
        Vehículos
      </div>
    </div>


    <div class="row">
      <div class="col-12">
        <a class="btn btn-primary" href="{{ route('Vehiculo.Crear') }}">
          Registrar
          <i class="fas fa-plus"></i>
        </a>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        {{ $comp_filtros->render() }}
      </div>
    </div>


    @include('Layout.MensajeEmergenteDatos')

    <table class="table table-hover table-bordered celdas_sin_padding">
      <thead class="thead-dark">
        <tr>
          <th>
            Placa
          </th>

          <th>
            Modelo
          </th>
          <th>
            Color
          </th>
          <th>
            Factura
          </th>

          <th>
            Fecha compra
          </th>
          <th>
            Sede
          </th>
          <th>
            KM Actual
          </th>
          <th>
            Rendimiento
          </th>

          <th>
            QR Imprimible
          </th>
          <th>
            Opciones
          </th>
        </tr>
      </thead>
      <tbody>

        @foreach ($listaVehiculos as $vehiculo)
          <tr>
            <td>
              {{ $vehiculo->placa }}
            </td>

            <td>
              {{ $vehiculo->modelo }}
            </td>
            <td>
              {{ $vehiculo->color }}
            </td>
            <td>
              {{ $vehiculo->codigo_factura }}
            </td>
            <td>
              {{ $vehiculo->getFechaCompra() }}
            </td>
            <td>
              {{ $vehiculo->getSede()->nombre }}
            </td>
            <td>
              {{ $vehiculo->kilometraje_actual }}

              @if ($vehiculo->seDebeMostrarAlertaKilometraje())
                <span class="badge badge-danger" title="">
                  Alerta mantenimiento
                  <i class="fas fa-exclamation-triangle"></i>
                </span>
              @endif
            </td>
            <td>
              {{ $vehiculo->getRendimiento() }}
            </td>

            <td class="text-center">

              <a class="btn btn-primary" target="_blank" href="{{ route('Vehiculo.PDF.Ver', $vehiculo->getId()) }}"
                title="Ver PDF con el QR">
                <i class="fas fa-file-pdf"></i>
              </a>

              <a class="btn btn-primary" target="_blank" href="{{ route('Vehiculo.PDF.Descargar', $vehiculo->getId()) }}"
                title="Descargar PDF con el QR">
                <i class="fas fa-file-download"></i>
              </a>
            </td>

            <td class="text-center">
              <a class="btn btn-warning" href="{{ route('Vehiculo.Editar', $vehiculo->getId()) }}">
                <i class="fas fa-pen"></i>
              </a>


              @if ($vehiculo->sePuedeEliminar())
                <button class="btn btn-danger" type="button"
                  onclick="clickEliminarVehiculo({{ $vehiculo->getId() }},'{{ $vehiculo->placa }}')">
                  <i class="fas fa-trash"></i>
                </button>
              @endif


            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </div>

  {{ $listaVehiculos->appends($filtros_usados_paginacion)->links() }}
@endsection

@section('script')
  <script>
    function clickEliminarVehiculo(codVehiculo, placa) {
      confirmarConMensaje("Confirmación", "¿Desea eliminar el vehículo " + placa + "?", "warning", function() {
        let ruta = "/Vehiculo/Eliminar/" + codVehiculo;
        $(".loader").show();
        location.href = ruta;


      });
    }
  </script>
@endsection
@section('estilos')
  <style>

  </style>
@endsection
