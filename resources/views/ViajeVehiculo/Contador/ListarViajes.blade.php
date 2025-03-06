@extends ('Layout.Plantilla')
@section('titulo')
  Ver Viajes
@endsection

@php
  $comp_filtros = new App\UI\UIFiltros(false, $filtros_usados);

  $comp_filtros->añadirFiltro([
      'name' => 'codSede',
      'label' => 'Sede del vehículo:',
      'show_label' => true,
      'placeholder' => '- Sede -',
      'type' => 'select',
      'function' => 'equals',
      'options' => $listaSedes,
      'options_label_field' => 'nombre',
      'options_id_field' => null,
      'size' => 'sm',
      'max_width' => '250px',
      'direct_search' => true,
  ]);

  $comp_filtros->añadirFiltro([
      'name' => 'codVehiculo',
      'label' => 'Vehículo:',
      'show_label' => true,
      'placeholder' => '- Vehículo-',
      'type' => 'select2',
      'function' => 'equals',
      'options' => $listaVehiculos,
      'options_label_field' => 'nombre_front',
      'options_id_field' => null,
      'size' => 'sm',
      'max_width' => '250px',
  ]);

  $comp_filtros->añadirFiltro([
      'name' => 'codEmpleadoRegistrador',
      'label' => 'Conductor:',
      'show_label' => true,
      'placeholder' => '- Conductor -',
      'type' => 'select2',
      'function' => 'equals',
      'options' => $listaConductores,
      'options_label_field' => 'nombreCompleto',
      'options_id_field' => null,
      'size' => 'sm',
      'max_width' => '250px',
  ]);

@endphp


@section('contenido')
  <div>
    <div class="p-1">
      <div class="page-title">
        Ver Viajes
      </div>
    </div>




    <div class="row">
      <div class="col-12 text-right">

        <a class="btn btn-success btn-sm m-1" href="{{ route('ViajeVehiculo.Exportar') }}">
          Descargar <i class="ml-1 fas fa-file-excel"></i>

        </a>

      </div>
      <div class="col-12">
        {{ $comp_filtros->render() }}
      </div>
    </div>


    @include('Layout.MensajeEmergenteDatos')

    <div class="table-container">

      <table class="table table-hover table-bordered celdas_sin_padding">
        <thead class="thead-dark">
          <tr>
            <th>
              CodViaje
            </th>
            <th>
              Conductor
            </th>
            <th>
              Vehículo
            </th>
            <th>
              Sede
            </th>
            <th>
              Aprobado por
            </th>
            <th>
              Motivo
            </th>
            <th>
              Salida
            </th>
            <th>
              Llegada
            </th>




            <th>
              Rendimiento
            </th>
            <th>
              Estado
            </th>
            <th>
              Opciones
            </th>
          </tr>
        </thead>
        <tbody>

          @foreach ($listaViajes as $viaje)
            @php
              $vehiculo = $viaje->getVehiculo();
            @endphp
            <tr>
              <td class="fontSize10">
                {{ $viaje->getIdEstandar() }}
              </td>
              <td>
                {{ $viaje->getEmpleadoRegistrador()->getNombreCompleto() }}
              </td>
              <td>
                {{ $vehiculo->placa }}
                <br>
                <span class="fontSize9">
                  {{ $vehiculo->modelo }}
                </span>
              </td>
              <td>
                {{ $vehiculo->getSede()->nombre }}
              </td>
              <td>
                {{ $viaje->getEmpleadoAprobador()->getNombreCompleto() }}
              </td>
              <td>
                {{ $viaje->renderMotivo() }}
              </td>
              <td>
                {{ $viaje->getFechaHoraSalidaEscrita() }}
              </td>
              <td>
                {{ $viaje->getFechaHoraLlegadaEscrita() }}
              </td>


              <td>
                {{ $viaje->getRendimiento() }}
              </td>
              <td>
                <div class="div_estado viaje {{ $viaje->estado }}" title="{{ $viaje->getEstado()->descripcion }}">
                  {{ $viaje->getEstado()->nombreAparente }}
                </div>

              </td>
              <td class="text-center">

                <a class="btn btn-sm btn-primary" href="{{ route('ViajeVehiculo.Contador.Ver', $viaje->getId()) }}">
                  <i class="fas fa-eye"></i>
                </a>

                <a class="btn btn-sm btn-primary" target="_blank" href="{{ route('ViajeVehiculo.Pdf.Ver', $viaje->getId()) }}">
                  <i class="fas fa-file-pdf"></i>
                </a>
                <a class="btn btn-sm btn-primary" href="{{ route('ViajeVehiculo.Pdf.Descargar', $viaje->getId()) }}">
                  <i class="fas fa-download"></i>
                </a>



              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </div>

  {{ $listaViajes->appends($filtros_usados_paginacion)->links() }}
@endsection

@section('script')
  <script></script>
@endsection
@section('estilos')
  <style>

  </style>
@endsection
