<?php 


$fondoPlomo = "background-color: #D0CECE;";


$fondoAzulOscuro = "background-color: rgb(34,43,53);";
$fondoCrema = "background-color: rgb(255,242,204);";
$fondoAzul = "background-color: rgb(32,55,100);";
$textoRojo = "color:red";


$textoBlanco = "color:white;";
$textLeft = "text-align:left;";
$textCenter = "text-align:center;";

 
if($descargarExcel){
  header("Pragma: public");
  header("Expires: 0");
  
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=$filename");
  header("Pragma: no-cache");
  
}

$br ="<br style='mso-data-placement:same-cell;'/>";

?>
<meta charset="utf-8">
 
 
 

<table border="1">
    <tbody>
        <tr>
            <td colspan="10">
                Anexo N° 6.1: Reporte de usuarios de los servicios del CITE privado (periodo {{$rangoFechas}})
            </td>
        </tr>
        <tr>
            <td colspan="10">
                ANEXO N°3: REPORTE DE PARTICIPANTES ATENDIDOS POR EL CITE
            </td>
            
        </tr>
        <tr>
            <td style="{{$textCenter}} {{$fondoAzulOscuro}} {{$textoBlanco}}" colspan="6">
                CLIENTE
            </td>
            <td style="{{$textCenter}} {{$fondoAzulOscuro}} {{$textoBlanco}}" colspan="7">
                PARTICIPANTE
            </td>
        </tr>
        <tr>
            <td style="{{$textCenter}} {{$fondoAzul}} {{$textoBlanco}}">
              V1
            </td>
            <td style="{{$textCenter}} {{$fondoAzul}} {{$textoBlanco}}">
              X
            </td>
      
            <td style="{{$textCenter}}  {{$fondoAzul}} {{$textoBlanco}}">
                V2
            </td>
            <td style="{{$textCenter}} {{$fondoAzul}} {{$textoBlanco}}">
              X
            </td>
            <td style="{{$textCenter}}  {{$fondoAzul}} {{$textoBlanco}}">
                V3
            </td>
            <td style="{{$textCenter}}  {{$fondoAzul}} {{$textoBlanco}}">
                V4
            </td>
            <td style="{{$textCenter}} {{$fondoAzul}} {{$textoBlanco}}">
              X
            </td>
            <td style="{{$textCenter}}  {{$fondoAzul}} {{$textoBlanco}}">
                V5
            </td>
            <td style="{{$textCenter}}  {{$fondoAzul}} {{$textoBlanco}}">
                V6
            </td>
            <td style="{{$textCenter}}  {{$fondoAzul}} {{$textoBlanco}}">
                V7
            </td>
            <td style="{{$textCenter}}  {{$fondoAzul}} {{$textoBlanco}}">
                V8
            </td>
            <td style="{{$textCenter}}  {{$fondoAzul}} {{$textoBlanco}}">
                V9
            </td>
            <td style="{{$textCenter}}  {{$fondoAzul}} {{$textoBlanco}}">
                V10
            </td>
        </tr>
    </tbody>

</table>
  

<table  border="1">
    <thead>     
        {{-- ------------------------ --}}
        <tr>
            <th  style="{{$fondoPlomo}}">N°</th>
            <th style="{{$fondoPlomo}} {{$textoRojo}}">CodServicio</th>
            
            <th  style="{{$fondoPlomo}}">CÓDIGO DEL EVENTO / SERVICIO</th>
            <th  style="{{$fondoPlomo}} {{$textoRojo}}">CodUnidadProductiva</th>
            
            <th  style="{{$fondoPlomo}}">RUC</th>
            
            
            <th  style="{{$fondoPlomo}}">
                RAZÓN SOCIAL
            </th>

            <th style="{{$fondoPlomo}} {{$textoRojo}}">CodUsuario</th>
            <th  style="{{$fondoPlomo}}">
                DNI
            </th>

            
            <th style="{{$fondoPlomo}}">
                NOMBRES
            </th>
            {{-- SERVICIO --}}
            <th  style="{{$fondoPlomo}}">
                APELLIDO PATERNO
            </th>

            <th  style="{{$fondoPlomo}}">
                APELLIDO MATERNO
            </th>
            <th  style="{{$fondoPlomo}}">
                TELÉFONO
            </th>
            <th  style="{{$fondoPlomo}}">
                CORREO ELECTRÓNICO
            </th>
            
        </tr>
        
    </thead>
    <tbody>
        @php
            $i=1;
        @endphp

        @foreach($listaAsistenciasServicio as  $asistenciaServicio)
          @php
            $servicio = $asistenciaServicio->getServicio();
            $usuario = $asistenciaServicio->getUsuario();
            $unidadProductiva = $servicio->getUnidadProductiva();
          @endphp
                
                    <tr>
                        <td >
                            {{$i}}
                        </td>
                        <td  style="{{$textoRojo}}">
                          {{$servicio->getId()}}
                        </td>
                        <td >
                            {{mb_strtoupper($servicio->descripcion)}}
                        </td>
                        <td  style="{{$textoRojo}}">
                          {{$unidadProductiva->getId()}}
                        </td>
                        <td >
                            {{$unidadProductiva->getRucODNI()}}
                        </td>
            

                        <td >
                            {{mb_strtoupper($unidadProductiva->getDenominacion())}}
                        </td>
                        

                        {{-- PARTE DEL USUARIO --}}
                        <td  style="{{$textoRojo}}">
                          {{$usuario->getId()}}
                        </td>
                        <td >
                            {{$usuario->dni}}
                        </td>
                        <td>
                            {{mb_strtoupper($usuario->nombres)}}
                        </td>
                        <td>
                            {{mb_strtoupper($usuario->apellidoPaterno)}}
                        </td>
                        <td>
                            {{mb_strtoupper($usuario->apellidoMaterno)}}
                        </td>
                        <td>
                            {{$usuario->telefono}}
                        </td>

                        
                        <td >
                            {{$usuario->correo}}
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
