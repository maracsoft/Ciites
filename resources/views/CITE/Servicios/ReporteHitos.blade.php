
@php
  

  $fondoPlomo = "background-color: #D0CECE;";
  $textLeft = "text-align:left";
  $textCenter = "text-align:center";
  $textoRojo = "color:red";
  $fonto_amarillo = "background-color:#ffff00";

  if($descargarExcel){
    header("Pragma: public");
    header("Expires: 0");
    
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$filename");
    header("Pragma: no-cache");
    
  }

  $br ="<br style='mso-data-placement:same-cell;'/>";

@endphp

<meta charset="utf-8">

<table border="1">
  <tbody>
    <tr>
      <td colspan="10">
        REPORTE DE HITOS CITE
      </td>
    </tr>
    <tr>
      <td colspan="2">
        Filtros:
      </td>
    </tr>
    <tr>
      <td style="">
        Fecha Inicio:
      </td>
      <td>
        {{$fechaInicio}}
      </td>
    </tr>
    <tr>
      <td style="">
        Fecha Fin:
      </td>
      <td>
        {{$fechaFin}}
      </td>
    </tr>
    
  </tbody>
</table>

<br>

<table border="1" class="">
  <thead>
    <tr>
      <td rowspan="2">
        Modalidad de Intervención
      </td>
      <td rowspan="2">
        Número de servicios realizados
      </td>
      <td colspan="5">
        Número de clientes atendidos
      </td>
      <td rowspan="2">
        Número de servicios pagados
      </td>
      <td rowspan="2">
        Número de servicios gratuitos
      </td>
      <td rowspan="2">
        Ingresos percibidos
      </td>
    </tr>
    <tr>
      <td>
        MIPYME
      </td>
      <td>
        Gran Empresa
      </td>
      <td>
        Asociaciones
      </td>
      <td>
        Productores
      </td>
      <td>
        Otros
      </td>
    </tr>
  </thead>
  <tbody>
    @foreach($listaTipoServicio as $tipo_servicio)
      <tr>
        <td>
          {{$tipo_servicio->nombre}}
        </td>
        <td>
          {{$tipo_servicio->getCantServicios($fechaInicio,$fechaFin)}}
        </td>
        <td>
          {{$tipo_servicio->getCantUnidades("MIPYME",$fechaInicio,$fechaFin)}}
        </td>
        <td>
          {{$tipo_servicio->getCantUnidades("GRAN EMPRESA",$fechaInicio,$fechaFin)}}
        </td>
        <td>
          {{$tipo_servicio->getCantUnidades("ASOCIACIÓN",$fechaInicio,$fechaFin)}}
        </td>
        <td>
          {{$tipo_servicio->getCantUnidades("PRODUCTORES",$fechaInicio,$fechaFin)}}
        </td>
        <td>
          {{$tipo_servicio->getCantUnidades("OTROS",$fechaInicio,$fechaFin)}}
        </td>
        <td>
          {{$tipo_servicio->getCantServiciosPagados($fechaInicio,$fechaFin)}}
        </td>
        <td>
          {{$tipo_servicio->getCantServiciosGratuitos($fechaInicio,$fechaFin)}}
        </td>
        <td>
          {{$tipo_servicio->getTotalPagadoServicios($fechaInicio,$fechaFin)}}
        </td>
      </tr>  
    @endforeach

  </tbody>
</table>