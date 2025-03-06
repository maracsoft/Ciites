@php
  $fondoPlomo = 'background-color: #D0CECE;';
  $textLeft = 'text-align:left;';
  $textRight = 'text-align:right;';

  $textCenter = 'text-align:center;';
  $textoRojo = 'color:red; ';
  $fonto_amarillo = 'background-color:#ffff00;';

  $br = "<br style='mso-data-placement:same-cell;'/>";

@endphp

<meta charset="utf-8">


<table border="1">
  <tbody>
    <tr>
      <td colspan="6">
        Reporte generado por el sistema gestion.ciites.com el
        {{ App\Fecha::getFechaHoraActual() }} por
        {{ App\Empleado::getEmpleadoLogeado()->getNombreCompleto() }}
      </td>
    </tr>
  </tbody>

</table>



<br>

<table border="1">
  <thead>
    <tr>
      <th style="{{ $fonto_amarillo }}" colspan="4">
        Vehículo
      </th>
      <th style="{{ $fonto_amarillo }}" colspan="15">
        Viaje
      </th>
    </tr>
    <tr>
      <th style="{{ $fonto_amarillo }}">
        Placa
      </th>
      <th style="{{ $fonto_amarillo }}">
        Modelo
      </th>
      <th style="{{ $fonto_amarillo }}">
        Color
      </th>
      <th style="{{ $fonto_amarillo }}">
        Sede
      </th>


      <th style="{{ $fonto_amarillo }}">
        CodViaje
      </th>
      <th style="{{ $fonto_amarillo }}">
        Conductor solicitante
      </th>
      <th style="{{ $fonto_amarillo }}">
        Aprobado por
      </th>
      <th style="{{ $fonto_amarillo }}">
        Motivo
      </th>
      <th style="{{ $fonto_amarillo }}">
        Salida
      </th>
      <th style="{{ $fonto_amarillo }}">
        Llegada
      </th>
      <th style="{{ $fonto_amarillo }}">
        Kilometraje Salida
      </th>
      <th style="{{ $fonto_amarillo }}">
        Kilometraje llegada
      </th>
      <th style="{{ $fonto_amarillo }}">
        Km Recorrido
      </th>


      <th style="{{ $fonto_amarillo }}">
        Lugar origen
      </th>
      <th style="{{ $fonto_amarillo }}">
        Lugar destino
      </th>
      <th style="{{ $fonto_amarillo }}">
        Observaciones salida
      </th>
      <th style="{{ $fonto_amarillo }}">
        Observaciones llegada
      </th>


      <th style="{{ $fonto_amarillo }}">
        Rendimiento (Km/Sol)
      </th>
      <th style="{{ $fonto_amarillo }}">
        Estado
      </th>

    </tr>
  </thead>

  <tbody>

    @foreach ($listaViajes as $viaje)
      @php
        $vehiculo = $viaje->getVehiculo();
      @endphp
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
          {{ $vehiculo->getSede()->nombre }}
        </td>



        <td class="fontSize10">
          {{ $viaje->getIdEstandar() }}
        </td>
        <td>
          {{ $viaje->getEmpleadoRegistrador()->getNombreCompleto() }}
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
          {{ $viaje->kilometraje_salida }}


        </td>
        <td>
          {{ $viaje->kilometraje_llegada }}
        </td>
        <td>
          {{ $viaje->kilometraje_recorrido }}
        </td>




        <th>
          {{ $viaje->lugar_origen }}
        </th>
        <th>
          {{ $viaje->lugar_destino }}
        </th>
        <th>
          {{ $viaje->observaciones_salida }}
        </th>
        <th>
          {{ $viaje->observaciones_llegada }}
        </th>

        <td>
          {{ $viaje->rendimiento }}
        </td>
        <td>
          <div class="div_estado viaje {{ $viaje->estado }}" title="{{ $viaje->getEstado()->descripcion }}">
            {{ $viaje->getEstado()->nombreAparente }}
          </div>

        </td>

      </tr>
    @endforeach
  </tbody>
</table>
