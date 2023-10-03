@php

  $fondoPlomo = "background-color: #D0CECE;";
  $textLeft = "text-align:left;";
  $textCenter = "text-align:center;";
  $textoRojo = "color:red;";

  if($descargarExcel){
    header("Pragma: public");
    header("Expires: 0");
    
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Reporte de Indicador 2.2 .xls");
    header("Pragma: no-cache");
    
  }

  $br ="<br style='mso-data-placement:same-cell;'/>";
  
  $titulo = "font-size: 15pt; color: #0093ff; text-align:center; ";
  $subtitulo = "font-weight: bold; text-align:center;";
  $fondo_celeste = "background-color:#a2deff;";


@endphp
<meta charset="utf-8">



<table border="1" style="{{$titulo}}">
  <tbody>
    <tr>
      <td style="{{$textCenter}}" colspan="12">  
        GESTIÓN INTEGRADA DEL AMBIENTE Y LOS RECURSOS NATURALES
      </td>
    </tr>
  </tbody>
</table>
<br>

<table border="1" style="{{$subtitulo}}">
  <tbody>
    <tr>
      <td style="{{$textCenter}}" colspan="12">  
        Indicador 2.2: 4 de 5 espacios de articulación interinstitucional incrementan el número de acciones conjuntas, para fortalecer la gestión de riesgos y adaptación ante el cambio climático en sus territorios.
      </td>
    </tr>
  </tbody>
</table>

<br>

  
<table border="1" style="{{$subtitulo}}">
  <tbody>
    <tr>
      <td colspan="4" style="{{$textCenter}}"> 
        Filtros aplicados:
      </td>
    </tr>
    <tr>
      <td colspan="2">
        Semestres:
      </td>
      <td colspan="2">
        {{$semestre_label}}
      </td>        
    </tr>
    <tr>
      <td colspan="2">
        Regiones:
      </td>
      <td colspan="2">
        {{$regiones_label}}
      </td>        
    </tr>
    <tr>
      <td colspan="2">
        Usuarios:
      </td>
      <td colspan="2">
        {{$empleados_label}}
      </td>        
    </tr>
    
  </tbody>
</table>

<br>
 


<table  border="1" style="">
  <thead  style="{{$fondoPlomo}}">
      <tr style="{{$fondo_celeste}}">
        <th rowspan="2">#</th>
        <th rowspan="2">DNI</th>
        <th rowspan="2">Nombres y Apellidos</th>
        <th colspan="3">Sexo</th>
        <th rowspan="2">
          Organización/Espacio de articulación
        </th>
        <th rowspan="2">
          Cargo
        </th>
        <th rowspan="2" style="{{$textoRojo}}">
          codsActividades
        </th>
        <th rowspan="2">
          Realizó Acción conjunta, para fortalecer la gestión de riesgos y adaptación ante el cambio climático en sus territorios
        </th>
        <th rowspan="2">
          Describir Acción conjunta, para fortalecer la gestión de riesgos y adaptación ante el cambio climático en sus territorios.
        </th>
      </tr>
      <tr  style="{{$fondo_celeste}}">
        <th>
          H
        </th>
        <th>
          M
        </th>
        <th>
          NB
        </th>
      </tr>
  </thead>
  <tbody>
    
    @forelse($listaRelaciones as $relacion)
      @php
        $persona = $relacion->getPersona();

        $id = $relacion->getId();
        $i = 1;

        $activar_campos = $relacion->ind22_realizo_accion == 1
      @endphp
      <tr>
        <td>
          {{$i}}
        </td>
        <td>
          {{$persona->dni}}
        </td>
        <td>
          {{$persona->getNombreCompleto()}}
        </td>
        <td>
          @if($persona->sexo == 'H')
            X
          @endif
        </td>
        <td>
          @if($persona->sexo == 'M')
            X
          @endif
        </td>
        <td>
          @if($persona->sexo == 'NB')
            X
          @endif
        </td>
        <td>
          {{$persona->getResumenOrganizacionesAsociadas()}}
        </td>
        <td>
          {{$persona->getResumenCargosDeOrganizaciones()}}
        </td>
        
        <td style="{{$textoRojo}}">
          {{$relacion->getCodsEjecucionesSinParentesis()}}
        </td>
        <td>
          @if($relacion->ind22_realizo_accion_id)
            {{$relacion->getRealizoAccion22()->nombre}}
          @endif
          
        </td>
        <td>
          {{$relacion->ind22_descripcion_accion}}
        </td>
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




<table border="1">
  <tbody>
      <tr>
          Reporte generado por el sistema gestion.cedepas.org el 
          {{App\Fecha::getFechaHoraActual()}} por
          {{App\Empleado::getEmpleadoLogeado()->getNombreCompleto()}}
      </tr>
  </tbody>
</table>
