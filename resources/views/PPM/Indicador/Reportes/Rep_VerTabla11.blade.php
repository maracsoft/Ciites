@php

  $fondoPlomo = "background-color: #D0CECE;";
  $textLeft = "text-align:left;";
  $textCenter = "text-align:center;";
  $textoRojo = "color:red;";

  if($descargarExcel){
    header("Pragma: public");
    header("Expires: 0");
    
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Reporte de Indicador 1.1 .xls");
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
          CIUDADANÍA Y DEMOCRACIA
        </td>
      </tr>
    </tbody>
  </table>
  <br>

  <table border="1" style="{{$subtitulo}}">
    <tbody>
      <tr>
        <td style="{{$textCenter}}" colspan="12">  
          Indicador 1: Al finalizar el proyecto, el 80% de la población meta (230 mujeres y 120 hombres) realiza actividades de incidencia en conjunto y con enfoque de género.
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

  <table border="1" style=""> 
    <thead >
        <tr  style="{{$fondo_celeste}}">
          <th rowspan="2">#</th>
          <th rowspan="2">DNI</th>
          <th rowspan="2">Nombres y Apellidos</th>
          <th colspan="3">Sexo</th>
          <th  rowspan="2">
            Organización/Espacio de articulación
          </th>
          <th rowspan="2">
            Cargo
          </th>
          <th rowspan="2" style="{{$textoRojo}}">
            codsActividades
          </th>
          <th rowspan="2">Realizó actividad de incidencia</th>
          <th rowspan="2">Describir actividad/es de incidencia</th>
          <th rowspan="2">
            Describir resultado/s de incidencia (Política aprobada, proyecto aprobado, financiamiento, intervención, otro)
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
      @php
        $codsParticipaciones = [];
      @endphp
      @forelse($listaRelaciones as $relacion)
        @php
          $persona = $relacion->getPersona();
          
          $codsParticipaciones[] = $relacion->getId();
          $id = $relacion->getId();
          $i = 1;

          $activar_campos = $relacion->ind11_realizo_actividad_incidencia == 1
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
            @if($activar_campos) 
            Sí 
            @endif
            
          </td>
          
          <td>
            {{$relacion->ind11_descripcion_actividad}}
          </td>
          <td>
            {{$relacion->ind11_descripcion_resultado}}
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
