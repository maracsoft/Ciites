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

  $fondo_blanco = "background-color: #ffffff;";
  $fondo_amarillo = "background-color: #ffbf00;";
  $fondo_azul = "background-color: #2196f3;";

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
        Indicador 3.1: Al finalizar el proyecto, al menos el 70% de productores agropecuarios (700 mujeres y 1300 hombres), incrementan en 20% sus ingresos agrarios gracias a mejoras en las cadenas productivas.
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
 

              
<table border="1" >
  <thead >
      <tr>
        <th style="{{$textoRojo}}" rowspan="2">
          codsEjecuciones
        </th>
        <th style="{{$textoRojo}}" rowspan="2">
          Semestre
        </th>
        
        <th style="{{$textoRojo}}" rowspan="2">
          codPersona
        </th>
        <th rowspan="2">
          Nombres y apellidos
        </th>
        <th rowspan="2">
          DNI
        </th>
        <th rowspan="2">
          Fecha de Nacimiento
        </th>
        <th rowspan="1" colspan="3"  style="{{$fondo_celeste}}">
          Sexo
        </th>
        <th rowspan="2"  style="{{$fondo_amarillo}}">
          Cultivo/Producto
        </th>
        <th rowspan="2" style="{{$fondo_amarillo}}">
          Organización/Cooperativa
        </th>
        <th rowspan="2" style="{{$textoRojo}}">
          codOrganizacion
        </th>
        <th rowspan="2" style="{{$fondo_amarillo}}">
          Nivel de Gestión Empresarial
        </th>
        <th  rowspan="2" style="{{$fondo_amarillo}}">
          Edad del cultivo/producto
        </th>
        <th rowspan="1" colspan="3" style="{{$fondo_azul}}">
          Rendimiento promedio de la zona 
        </th>
        <th colspan="2" style="{{$fondo_amarillo}}">
          Rendimiento alcanzado el semestre
        </th>
        
        
        <th  rowspan="1" colspan="2" style="{{$fondo_amarillo}}">
          Numero de unidades de producción por productor/a
        </th>
        <th   colspan="2"  style="{{$fondo_amarillo}}">
          Producción total por productor
        </th>
        <th colspan="2" style="{{$fondo_amarillo}}">
          Producción total comercializada
        </th>
        <th rowspan="2" style="{{$fondo_amarillo}}">
          Precio de venta por unidad en soles
        </th>
        <th rowspan="2" style="{{$fondo_amarillo}}">
          Costo de producción por unidad en soles
        </th>
        <th rowspan="2" style="{{$fondo_amarillo}}">
          Ingreso neto obtenido por cada productor/a en junio 2022 (soles)
        </th>
        
        <th rowspan="2" style="{{$fondo_amarillo}}">
          Ingreso neto obtenido por cada productor/a en el semestre (soles)
        </th>
        <th rowspan="2" style="{{$fondo_amarillo}}">
          % de aumento de ingresos a la fecha
        </th>
        
        
      </tr>
      
      <tr >
         
        <th style="{{$fondo_celeste}}">
          H
        </th>
        <th style="{{$fondo_celeste}}">
          M
        </th>
        <th style="{{$fondo_celeste}}">
          NB
        </th>
        <th  style="{{$fondo_azul}}">
          Rendimiento
        </th>
        <th  style="{{$fondo_azul}}">
          Unid Medida
        </th>
        <th  style="{{$fondo_azul}}">
          Fuente
        </th>

        
        <th  style="{{$fondo_amarillo}}">
          Rendimiento
        </th>
        <th  style="{{$fondo_amarillo}}">
          Unid Medida
        </th>


        <th  style="{{$fondo_amarillo}}">
          Nro
        </th>
        <th  style="{{$fondo_amarillo}}">
          Unid Medida
        </th>
        <th  style="{{$fondo_amarillo}}">
          Cant
        </th>
        <th  style="{{$fondo_amarillo}}">
          Unid Medida
        </th>
        <th style="{{$fondo_amarillo}}">
          Cant
        </th>
        <th  style="{{$fondo_amarillo}}">
          Unid Medida
        </th>
        
      </tr>

  </thead>
  <tbody>
    
    @foreach($listaRelaciones as $relacion_org_semestre)
      @php
        $organizacion = $relacion_org_semestre->getOrganizacion();
      @endphp
      @foreach($relacion_org_semestre->getDetallesProducto_CultivoCadena() as $detalle)
        @php
          $persona = $detalle->getPersona();
        @endphp
        <tr class="fila_responsive mb-5 mb-sm-0">
          <td style="{{$textoRojo}}">
            {{$relacion_org_semestre->getCodsEjecucionesSinParentesis()}}
          </td>
          <td style="{{$textoRojo}}">
            {{$relacion_org_semestre->getSemestre()->getTexto()}}
          </td>
          
          <td style="{{$textoRojo}}">
            {{$persona->getId()}}
          </td>
          <td>
            {{$persona->getNombreCompleto()}}
          </td>
          <td class="">
            {{$persona->dni}}
          </td>
          <td class="">
            {{$persona->getFechaNacimiento()}}
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
            {{$detalle->getProducto()->nombre}}
          </td>
          <td>
            {{$organizacion->razon_social}}
          </td>
          <td style="{{$textoRojo}}">
            {{$organizacion->getId()}}
          </td>
          <td>
            {{$relacion_org_semestre->nivel_gestion_empresarial}}
          </td>
          <td>
            {{$detalle->edad_cultivo}}
          </td>
          <td >
            {{$detalle->RZ_rendimiento}}
          </td>
          <td >
            {{$detalle->RZ_unidad_medida}}
          </td>
          <td >
            {{$detalle->RZ_fuente}}
          </td>
          <td>
            {{$detalle->RS_rendimiento}}
          </td>
          <td>
            {{$detalle->RS_unidad_medida}}
          </td>
          <td>
            {{$detalle->NUPP_numero}}
          </td>
          <td>
            {{$detalle->getUnidadMedida_NUPP()->nombre}}
          </td>
          <td>
            {{$detalle->PTP_cantidad}}
          </td>
          <td >
            {{$detalle->getUnidadMedida_PTP()->nombre}}
          </td>
          <td>
            {{$detalle->PTC_cantidad}}
          </td>
          <td >
            {{$detalle->getUnidadMedida_PTC()->nombre}}
          </td>
          <td>
            {{number_format($detalle->pventa_unidad,2)}}
          </td>
          <td>
            {{number_format($detalle->costo_prod_unidad,2)}}
          </td>
          <td>
            {{number_format($detalle->ingreso_neto22,2)}}
          </td>
          <td>
            {{number_format($detalle->ingreso_semestre,2)}}
          </td>
          <td>
            {{$detalle->getPorcentajeAumentoIngresos()}}
          </td>
          
        </tr>
      
      @endforeach

    @endforeach

  </tbody>
</table>  



@php
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  // -----------------  PRODUCTOS
  
@endphp
<br>
<br>
<br>
<br>
 

<table border="1" style="{{$subtitulo}}">
  <tbody>
    <tr>
      <td style="{{$textCenter}}" colspan="12">  
        Indicador 3.1 - b Organizaciones incrementan en 20% sus ingresos agrarios gracias a mejoras en las cadenas productivas.
      </td>
    </tr>
  </tbody>
</table>

<br>
 

<table  border="1">
  <thead>
      <tr >
        <th rowspan="2" style="{{$fondo_celeste}}">
          Organización
        </th>
        <th rowspan="2" style="{{$fondo_celeste}}">
          RUC
        </th>
        <th  rowspan="2" style="{{$fondo_celeste}}">
          Producto
          
        </th>
        <th  rowspan="1" colspan="2" style="{{$fondo_celeste}}">
          Numero de unidades de producción
        </th>
        <th  rowspan="2" style="{{$fondo_celeste}}">
          Personas directamente involucradas (socios que procesan o trabajadores/as)
        </th>

        <th   colspan="2"  style="{{$fondo_celeste}}">
          Producción total por unidad de producción
        </th>
      
        <th  colspan="2" style="{{$fondo_celeste}}">
          Producción total comercializada
        </th>
        <th  rowspan="2" style="{{$fondo_celeste}}">
          Precio de venta por unidad en soles
        </th>
        <th  rowspan="2" style="{{$fondo_celeste}}">
          Costo de producción por unidad en soles
        </th>
        <th  rowspan="2" style="{{$fondo_celeste}}">
          Ingreso neto de la organización en junio 2022 (soles)
        </th>
        <th  rowspan="1" colspan="3" style="{{$fondo_celeste}}">
          Rendimiento promedio de la zona 
        </th>
        <th  rowspan="2" style="{{$fondoPlomo}}">
          Ingreso neto obtenido por la organización en el semestre (soles)
        </th>
        <th  colspan="2" style="{{$fondoPlomo}}">
          Rendimiento alcanzado el semestre
        </th>
        <th rowspan="2" style="{{$fondoPlomo}}">
          % de aumento de ingresos a la fecha
        </th>
        
        
      </tr>
      
      <tr >
         
        <th  style="{{$fondo_celeste}}">
          Cant
        </th>
        <th  style="{{$fondo_celeste}}">
          Unid Medida
        </th>
        <th  style="{{$fondo_celeste}}">
          Cant
        </th>
        <th  style="{{$fondo_celeste}}">
          Unid Medida
        </th>
        <th style="{{$fondo_celeste}}" >
          Cant
        </th>
        <th  style="{{$fondo_celeste}}">
          Unid Medida
        </th>
        <th  style="{{$fondo_celeste}}">
          Rendimiento
        </th>
        <th  style="{{$fondo_celeste}}">
          Unid Medida
        </th>
        <th  style="{{$fondo_celeste}}">
          Fuente
        </th>
        <th  style="{{$fondoPlomo}}">
          Rendimiento
        </th>
        <th  style="{{$fondoPlomo}}">
          Unid Medida
        </th>
      </tr>

  </thead>
  <tbody>
    @foreach($listaRelaciones as $relacion_org_semestre)
      @php
        $organizacion = $relacion_org_semestre->getOrganizacion();
      @endphp

      @foreach($relacion_org_semestre->getDetallesProducto_Producto() as $detalle)
        <tr >
          <td>
            {{$organizacion->razon_social}}
          </td>
          <td>
            {{$organizacion->ruc}}
          </td>
          <td >
            {{$detalle->getProducto()->nombre}}
          </td>
          <td >
            {{$detalle->NUP_cantidad}}
          </td>
          <td >
            {{$detalle->NUP_unidad_medida}}
          </td>
          <td>
            {{$detalle->getResumenAsistentes()}}
          </td>
          <td >
            {{$detalle->PTUP_cantidad}}
          
          </td>
          <td >
            {{$detalle->getUnidadMedida_PTUP()->nombre}}
            
            
          </td>
          <td >
            {{$detalle->PTC_cantidad}}
            
          </td>
          <td >
            {{$detalle->getUnidadMedida_PTC()->nombre}}
            
          </td>
          <td>
            {{number_format($detalle->pventa_unidad,2)}}
            
          </td>
          <td>
            {{number_format($detalle->costo_prod_unidad,2)}}
            
          </td>
          <td>
            {{number_format($detalle->ingreso_neto22,2)}}
            
          </td>
          <td >
            {{$detalle->RZ_rendimiento}}
            
          </td>
          <td >
            {{$detalle->RZ_unidad_medida}}
            
    
          </td>
          <td >
            {{$detalle->RZ_fuente}}
            
          </td>
          <td>
            {{number_format($detalle->ingreso_semestre,2)}}
            
          </td>
          <td >
            {{$detalle->RS_rendimiento}}
            
          </td>
          <td >
            
            {{$detalle->RS_unidad_medida}}
            
          </td>
          <td>
            {{$detalle->getPorcentajeAumentoIngresos()}}
          </td>
        </tr>
      @endforeach
       
    @endforeach
  </tbody>
</table>  


<br>

<table border="1">
  <tbody>
      <tr>
          Reporte generado por el sistema gestion.cedepas.org el 
          {{App\Fecha::getFechaHoraActual()}} por
          {{App\Empleado::getEmpleadoLogeado()->getNombreCompleto()}}
      </tr>
  </tbody>
</table>
