<?php 

$descargarExcel = true;
$fondoPlomo = "background-color: #D0CECE;";

$filename = "Reporte de Unidades Productivas CITE .xls";

if($descargarExcel){
  header("Pragma: public");
  header("Expires: 0");
  
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=$filename");
  header("Pragma: no-cache");
  
}
?>
<meta charset="utf-8">

<table>
<thead>
    <tr>
        <th colspan="6" style="font-size: large">Reporte de Unidades Productivas:</th>
    </tr>
</thead>
<tbody>
     
</tbody>
</table>

 
 

  

<table  border="1">
    <thead>                  
    <tr>
        <th style="{{$fondoPlomo}}">N°</th>
        <th style="{{$fondoPlomo}}">RAZÓN SOCIAL</th>
        <th style="{{$fondoPlomo}}">RUC</th>
        
        <th style="{{$fondoPlomo}}">REGIÓN</th>
         
        <th style="{{$fondoPlomo}}">SERVICIOS BRINDADOS</th>
        
        
  
    </tr>
    </thead>
    <tbody>
    @php
        $i=1;
    @endphp
    @foreach($listaUnidadesProductivas as $unidadProductiva)
        <tr>
            <td>
                {{$i}}
            </td>
            <td>
                {{mb_strtoupper($unidadProductiva->getDenominacion())}}
            </td>
            <td>
                {{$unidadProductiva->getRucODNI()}}  
            </td>
 
           
            <td>
                {{$unidadProductiva->getNombreDepartamento()}}
            </td>
           
            <td>
                
                {{$unidadProductiva->nroServiciosHistorico}}
                
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
        <tr></tr>
        <tr>
            Reporte generado por el sistema gestion.cedepas.org el 
            {{App\Fecha::getFechaHoraActual()}} por
            {{App\Empleado::getEmpleadoLogeado()->getNombreCompleto()}}
        </tr>
    </tbody>
</table>
