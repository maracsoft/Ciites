@php

  $fondoPlomo = "background-color: #D0CECE;";
  $textLeft = "text-align:left;";
  $textCenter = "text-align:center;";
  $textoRojo = "color:red;";

  if($descargarExcel){
    header("Pragma: public");
    header("Expires: 0");
    
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Reporte de Indicador 3.2 .xls");
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
        SOSTENIBILIDAD Y FORTALECIMIENTO EMPRESARIAL DE LA AGRICULTURA FAMILIAR
      </td>
    </tr>
  </tbody>
</table>
<br>

<table border="1" style="{{$subtitulo}}">
  <tbody>
    <tr>
      <td style="{{$textCenter}}" colspan="12">  
        Indicador 3.2: 490 de 700 mujeres rurales controlan el uso de los ingresos percibidos por su propia actividad económica.
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
 

<table  border="1">
  <thead style="{{$fondoPlomo}}">
      <tr style="{{$fondo_celeste}}">
        <th rowspan="2">
          #
        </th>
        <th rowspan="2">
          DNI
        </th>
        <th rowspan="2">
          Nombres y Apellidos
        </th>
        <th colspan="3">
          Sexo
        </th>

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
          Tiempo dedicado al trabajo de cuidado
        </th>
        <th rowspan="2">
          Tiempo destinado a trabajo remunerado

        </th>
        <th rowspan="2">
          Actividad económica generadora de ingresos
        </th>
        <th rowspan="2">
          Manejo de registro de ingresos
        </th>
        <th rowspan="2">
          Manera en el que hacen registros
        </th>
        <th rowspan="2">
          Inversiones realizadas
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

          $activar_campos = $relacion->ind32_tiene_manejo_registros == 1
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
            {{$relacion->ind32_tiempo_cuidado}}
          </td>
          <td>
            {{$relacion->ind32_tiempo_remunerado}}
          </td>
          <td>
            {{$relacion->ind32_actividad_economica}}
          </td>

          
          <td>
            @if($activar_campos) 
              Sí 
            @endif
          </td>
          
          <td>
            {{$relacion->ind32_manera_registros}}
          </td>
          
          <td>
            {{$relacion->ind32_inversiones}}
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
