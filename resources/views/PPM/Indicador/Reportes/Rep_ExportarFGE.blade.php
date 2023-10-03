@php

  $fondoPlomo = "background-color: #D0CECE;";
  $textLeft = "text-align:left;";
  $textCenter = "text-align:center;";
  $textoRojo = "color:red;";

  if($descargarExcel){
    header("Pragma: public");
    header("Expires: 0");
    
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$nombre_archivo");
    header("Pragma: no-cache");
  }

  $br ="<br style='mso-data-placement:same-cell;'/>";
  
@endphp
<meta charset="utf-8">

<table border="1">
  <thead style="{{$fondoPlomo}}">
      <tr>

      </tr>
      <tr>

      </tr>
      <tr>
        <th colspan="2">
          Datos
        </th>
        @foreach ($listaSegmentos as $segmento)
          <th colspan="{{$segmento->getCantidadItems()}}">
              {{$segmento->nombre}}
          </th>
        @endforeach
      </tr>
      <tr>
        <th>
          Organización
        </th>
        <th>
          Semestre
        </th>
        
        @foreach ($listaSegmentos as $segmento)
          @foreach($segmento->getItems() as $item)
          <th>
            {{$item->descripcion}}
          </th>
          @endforeach
        @endforeach
      </tr>   
  </thead>
  <tbody>
     
      @forelse($listaRelaciones as $relacion)
        @php
          $semestre = $relacion->getSemestre();
          $organizacion = $relacion->getOrganizacion();

          $id = $relacion->getId();
          $i = 1;
        @endphp
        <tr>
          <td>
            {{$organizacion->razon_social}}
          </td>
          <td>
            {{$semestre->getTexto()}}
          </td>

          @foreach ($listaSegmentos as $segmento)
            @foreach($segmento->getItems() as $item)
              <td>
                @if($item->verificarMarcacion($relacion))
                  @php
                    $marcacion = $item->getMarcacion($relacion);
                  @endphp
                   {{$marcacion->getOptionSeleccionada()->descripcion}}
                @endif
              </td>
            @endforeach
        @endforeach
          
        </tr>
        @php
          $i++;
        @endphp
      @empty
        <tr>
          <td colspan="11">
            No hay resultados
          </td>
        </tr>
      @endforelse
    

  </tbody>
</table>  
<br><br>

<table border="1">
  <tbody>
      <tr>
          Reporte generado por el sistema gestion.cedepas.org el 
          {{App\Fecha::getFechaHoraActual()}} por
          {{App\Empleado::getEmpleadoLogeado()->getNombreCompleto()}}
      </tr>
  </tbody>
</table>
