<?php 


$fondoPlomo = "background-color: #D0CECE;";
$textLeft = "text-align:left";
$textCenter = "text-align:center";
$textoRojo = "color:red";

if($descargarExcel){
  header("Pragma: public");
  header("Expires: 0");
  
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=$filename");
  header("Pragma: no-cache");
  
}

$br ="<br style='mso-data-placement:same-cell;'/>";

if($convenio){
    $cantColumnas = 29;
    $cantColumnasServicio = 19;
}else{
    $cantColumnas = 24;
    $cantColumnasServicio = 14;
}     
    
?>
<meta charset="utf-8">
 
 

<table  border="1">
    <thead>     
        <tr>
            <th colspan="{{$cantColumnas}}">
                ANEXO N°4 Reporte mensuale de unidadProductivas y servicios del CITE
            </th>
        </tr>    
        
        <tr>
            <th style="{{$textLeft}}" colspan="{{$cantColumnas}}">
                1.- Período al que corresponde el reporte: {{$rangoFechas}}
            </th>
        </tr>    
        
        <tr>
            <th style="{{$textLeft}}"  colspan="{{$cantColumnas}}">
                2.- Nombre del CITE privado: CITE agropecuario CEDEPAS Norte
            </th>
        </tr>    
        
        <tr>
            <th style="{{$textLeft}}"  colspan="{{$cantColumnas}}">
                3.- Información de reporte de unidades Productivas y servicios brindados por el CITE privado:
            </th>
        </tr>    
        
        <tr>
            <th style="{{$textLeft}}"  colspan="{{$cantColumnas}}">
            </th>
        </tr>    
        
        <tr>
            <th style="{{$textCenter}}"  colspan="10">
                INFORMACIÓN DE LA EMPRESA BENEFICIARIA
            </th>
            <th style="{{$textCenter}}" colspan="{{$cantColumnasServicio}}">
                DATOS DEL SERVICIO
            </th>
        </tr>    
        
        {{-- ------------------------ --}}
        <tr>

            <th rowspan="2" style="{{$fondoPlomo}} {{$textoRojo}}">CodUnidadProductiva</th>
            
            <th rowspan="2" style="{{$fondoPlomo}}">N°</th>
            <th rowspan="2" style="{{$fondoPlomo}}">N° DE RUC O DNI</th>
            <th rowspan="2" style="{{$fondoPlomo}}">RAZON SOCIAL</th>
            
            
            <th rowspan="2" style="{{$fondoPlomo}}">
                TIPO DE PERSONERÍA NATURAL O JURÍDICA Y SU CONDICIÓN DE MIPYME 
                    @php echo $br @endphp A. ASOCIACIÓN
                    @php echo $br @endphp B. COOPERATIVA
                    @php echo $br @endphp C. PERSONA NATURAL CON NEGOCIO
                    @php echo $br @endphp D. PERSONA NATURAL SIN NEGOCIO
                    @php echo $br @endphp E. MIPYME
                    @php echo $br @endphp F. GRAN EMPRESA
                    @php echo $br @endphp G. OTRO
            </th>
            
            <th rowspan="2" style="{{$fondoPlomo}}">CLASIFICACIÓN DE EMPRESAS SEGÚN RANGO DE VENTAS</th>
            
            <th  colspan="4" style="{{$fondoPlomo}}">
                DIRECCIÓN DE LA EMPRESA, INSTITUCIÓN O PERSONA
 

            </th>
            {{-- SERVICIO --}}
            <th rowspan="2" style="{{$fondoPlomo}}">
                TIPO DE SERVICIO BRINDADO
                @php echo $br @endphp 1. SERVICIO DE TRANSFERENCIA TECNOLÓGICA
                @php echo $br @endphp 2. SERVICIO DE CAPACITACIÓN
                @php echo $br @endphp 3. SERVICIO DE I+D+i
                @php echo $br @endphp 4. SERVICIO DE DIFUSIÓN
                @php echo $br @endphp 5. ACTIVIDADES DE ARTICULACIÓN
            </th>
            <th rowspan="2" style="{{$fondoPlomo}} {{$textoRojo}}">
              codServicio
            </th>










            <th rowspan="2" style="{{$fondoPlomo}}">DESCRIPCIÓN DEL SERVICIO BRINDADO</th>
            <th rowspan="2" style="{{$fondoPlomo}}">MES DE SERVICIO

            </th>
            <th rowspan="2" style="{{$fondoPlomo}}">CANTIDAD DE SERVICIO BRINDADO

            </th>
            <th rowspan="2" style="{{$fondoPlomo}}">TOTAL DE PARTICIPANTES EN EL SERVICIO </th>
            <th rowspan="2" style="{{$fondoPlomo}}">N° DE HORAS EFECTIVAS DEL SERVICIO BRINDADO</th>
            <th rowspan="2" style="{{$fondoPlomo}}">FECHA DE INICIO DEL SERVICIO (DD/MM/AAAA)</th>
            <th rowspan="2" style="{{$fondoPlomo}}">FECHA DE TÉRMINO DEL SERVICIO (DD/MM/AAAA)</th>
            <th rowspan="2" style="{{$fondoPlomo}}">ACCESO AL SERVICIO
                Gratuito
                Pagado
            </th>
            
            <th  colspan="3" style="{{$fondoPlomo}}">
                UBICACIÓN (LUGAR DONDE SE REALIZÓ EL SERVICIO O ACTIVIDAD)
            </th>

            @if($convenio)
                <th colspan="5" style="{{$fondoPlomo}}">
                    INGRESOS
                </th>
            @endif

            <th rowspan="2" style="{{$fondoPlomo}}">
                EJECUCIÓN DE SERVICIOS
                MODALIDAD DEL SERVICIO
                @php echo $br @endphp 1. CON CONVENIO DE DESEMPEÑO
                @php echo $br @endphp 2. SIN CONVENIO DE DESEMPEÑO
            </th>

        </tr>
        <tr>
            <th style="{{$fondoPlomo}}">DIRECCIÓN (Calle, Av., Jr., Urb.)</th>
            <th style="{{$fondoPlomo}}">DISTRITO</th>
            <th style="{{$fondoPlomo}}">PROVINCIA</th>
            <th style="{{$fondoPlomo}}">DEPARTAMENTO</th>

            <th style="{{$fondoPlomo}}">DISTRITO</th>
            <th style="{{$fondoPlomo}}">PROVINCIA</th>
            <th style="{{$fondoPlomo}}">DEPARTAMENTO</th>

            @if($convenio)
                <th style="{{$fondoPlomo}}">TIPO DE COMPROBANTE (Factura, Boleta, otro)</th>
                <th style="{{$fondoPlomo}}">N° COMPROBANTE</th>
                <th style="{{$fondoPlomo}}">BASE IMPONIBLE</th>
                <th style="{{$fondoPlomo}}">IGV</th>
                <th style="{{$fondoPlomo}}">TOTAL</th>
            @endif
       
            
            
            
        </tr>
    </thead>
    <tbody>
        @php
            $i=1;
        @endphp
        
        @foreach($listaServicios as $servicio)
            @php
                $unidadProductiva = $servicio->getUnidadProductiva();
            @endphp
            <tr>
                <td style="{{$textoRojo}}">
                  {{$unidadProductiva->getId()}}
                </td>
                <td >
                    {{$i}}
                </td>
                <td >
                    {{$unidadProductiva->getRucODNI()}}
                </td>
                <td >
                    {{mb_strtoupper($unidadProductiva->getDenominacion())}}
                </td>
    

                <td >
                    {{$unidadProductiva->getTipoPersoneria()->letra}}
                </td>
            
                <td >
                    {{--  {{$unidadProductiva->getClasificacionRangoVentas()->nombre}} --}}
                </td>
                <td>
                    {{mb_strtoupper($unidadProductiva->direccion)}}
                </td>
                <td>
                    @if($unidadProductiva->codDistrito)
                        {{$unidadProductiva->getDistrito()->nombre}}
                    @endif
                    
                </td>
                <td>
                    @if($unidadProductiva->codDistrito)
                        {{$unidadProductiva->getDistrito()->getProvincia()->nombre}}
                    @endif
                </td>
                <td>
                    @if($unidadProductiva->codDistrito)
                        {{$unidadProductiva->getDistrito()->getProvincia()->getDepartamento()->nombre}}
                    @endif
                </td>

                {{-- SERVICIO --}}
                <td >
                    {{$servicio->getTipoServicio()->getId()}}
                </td>
                <td style="{{$textoRojo}}">
                  {{$servicio->getId()}}
                </td>
                <td >
                    {{mb_strtoupper($servicio->descripcion)}}
                </td>
                <td >
                    {{mb_strtoupper($servicio->getMesAño()->getMes()->nombre)}}
                </td>
                <td >
                    {{$servicio->cantidadServicio}}
                </td>
                <td >
                    {{$servicio->getCantidadAsistentes()}}
                </td>
                <td >
                    {{number_format($servicio->nroHorasEfectivas,2)}}
                </td>
                <td >
                    {{$servicio->getFechaInicio()}}
                </td>
                <td >
                    {{$servicio->getFechaTermino()}}
                </td>
                <td >
                    {{mb_strtoupper($servicio->getTipoAcceso()->nombre)}}
                </td>
                <td>
                    {{$servicio->getDistrito()->nombre}}
                </td>
                <td>
                    {{$servicio->getDistrito()->getProvincia()->nombre}}
                </td>
                <td>
                    {{$servicio->getDistrito()->getProvincia()->getDepartamento()->nombre}}
                </td>

                @if($convenio)
                    <td>
                        {{mb_strtoupper($servicio->getTipoCDP()->nombreCDP)}}
                    </td>
                    <td>
                        {{$servicio->nroComprobante}}
                    </td>
                    <td>
                        {{$servicio->baseImponible}}
                    </td>
                    <td>
                        {{$servicio->igv}}
                    </td>
                    <td>
                        {{$servicio->total}}
                    </td>
                @endif


                <td >
                    {{$servicio->getModalidad()->getId()}}
                </td>


            </tr>
            @php
                $i++;
            @endphp
        @endforeach
       
    
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
