@extends ('Layout.Plantilla')
@section('titulo')
  Mis Viajes
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
      'name' => 'codEmpleadoAprobador',
      'label' => 'Aprobador:',
      'show_label' => true,
      'placeholder' => '- Aprobador -',
      'type' => 'select2',
      'function' => 'equals',
      'options' => $listaAprobadores,
      'options_label_field' => 'nombreCompleto',
      'options_id_field' => null,
      'size' => 'sm',
      'max_width' => '250px',
  ]);

@endphp


@section('contenido')
  @include('Layout.Loader')
  <div>
    <div class="p-1">
      <div class="page-title">
        Mis Viajes
      </div>
    </div>


    <div class="row">
      <div class="col-12">
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#ModalCrearViaje">
          Registrar
          <i class="fas fa-plus"></i>
        </button>

      </div>
    </div>

    <div class="row">
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
              Km. Salida y Llegada
            </th>
            <th>
              Km Recorrido
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
                {{ $viaje->kilometraje_salida }} a
                <br>
                {{ $viaje->kilometraje_llegada }}
              </td>
              <td>
                {{ $viaje->kilometraje_recorrido }}
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

                @php
                  $icono = 'eye';
                  $boton = 'primary';
                  $label = '';

                  if ($viaje->sePuedeFinalizarPorLogeado($empLogeado)) {
                      $icono = 'check';
                      $boton = 'warning';
                      $label = 'Finalizar';
                  }
                @endphp

                <a class="btn btn-sm btn-{{ $boton }}" href="{{ route('ViajeVehiculo.Conductor.Ver', $viaje->getId()) }}">
                  {{ $label }}
                  <i class="fas fa-{{ $icono }}"></i>
                </a>

                @if ($viaje->sePuedeEliminar())
                  <button class="btn btn-danger btn-sm" onclick="clickEliminarViaje({{ $viaje->getId() }})">
                    <i class="fas fa-trash"></i>
                  </button>
                @endif

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

  <div class="modal fade" id="ModalCrearViaje" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">
            Registrar viaje
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col">
              <label class="mb-0" for="">
                Seleccione el vehículo:
              </label>
              <select id="placa_seleccionada" data-select2-id="1" tabindex="-1"
                class="fondoBlanco form-control select2 select2-hidden-accessible selectpicker" aria-hidden="true" data-live-search="true">
                <option value="">
                  - Vehiculo -
                </option>
                @foreach ($listaVehiculos as $vehiculo)
                  <option value="{{ $vehiculo->placa }}"
                    @if ($vehiculo->tieneViajeAbierto()) disabled style="background: #c50000; color: #fff;" @endif>
                    {{ $vehiculo->getDescripcion() }}

                    @if ($vehiculo->tieneViajeAbierto())
                      <span class="badge badge-danger">
                        (VIAJE ABIERTO)
                      </span>
                    @endif

                  </option>
                @endforeach
              </select>

            </div>
          </div>



        </div>
        <div class="modal-footer">

          <button type="button" class="m-1 btn btn-primary" onclick="clickRegistrar()">
            Registrar
            <i class="fas fa-plus"></i>
          </button>
        </div>

      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      $(".loader").hide();
    });

    function clickRegistrar() {
      let placa_seleccionada = $("#placa_seleccionada").val();
      if (placa_seleccionada == "") {
        alerta("Debe seleccionar un vehiculo");
        return;
      }

      $(".loader").show();
      location.href = "/ViajeVehiculo/Conductor/Crear/" + placa_seleccionada;
    }

    function clickEliminarViaje(codViaje) {
      confirmarConMensaje("Confirmación", "¿Desea eliminar el viaje " + codViaje + "?", "warning", function() {
        let ruta = "/ViajeVehiculo/Conductor/Eliminar/" + codViaje;
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
