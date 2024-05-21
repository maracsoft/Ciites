
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reporte de Proyectos</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   
    <style>
        .notaDeGeneracion { 
            font-size: 12px;
            color: rgb(168, 168, 168);
        } 
        
        html {
            /* Arriba | Derecha | Abajo | Izquierda */
            margin: 50pt 60pt 50pt 69pt;
            font-family: Candara, Calibri, Segoe, "Segoe UI", Optima, Arial, sans-serif;
        }
        #principal { 
            /*background-color: rgb(161, 51, 51);*/
            word-wrap: break-word;/* para que el texto no salga del div*/
        }
        thead {
            font-size: large;
        }
        tbody{
            font-size: 13px;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 3px;  
        }
    </style>
    
</head>
<body>
    <div id="principal" style="width: 635px; height: 750px">
        <table style="width:100%">
            <thead style="width:100%">
                <tr>
                    <th style="height: 70px;  "  >
                        <div style="height: 5px"></div>
                        
                        <img src="{{App\Configuracion::getRutaImagenCedepasPNG()}}" height="100%">
                    </th>
                    <th style="text-align: center"  ></th>
                </tr>

                <tr>
                    <th colspan="2" style="text-align: center; background-color: rgb(0, 102, 205); color: white">
                        Reporte de Proyectos
                    </th>
                </tr>
            </thead>
            

        </table>
        <div style="width: 100%; height: 8px;"></div>
        <table style="width:100%">
            <tbody style="width:100%; font-size: 11px;">
                <tr style="font-weight: bold">
                    <td style="text-align: center;">Proyecto</td>
                    <td style="text-align: center;">Total</td>
                    
                </tr>

                 
                            
                @foreach($listaProyectos as $proyecto)
                    <tr>
                        <td>
                            {{$proyecto->Proyecto}}
                        </td>
                        <td style="text-align: right">
                            {{number_format($proyecto->Total,2)}}
                        </td>
                    </tr>

                @endforeach
                            
                            
                <tr>
                    <td style="text-align: right">Total</td>
                    
                    <td style="text-align: right">{{$total}}</td>
                    
                </tr>



            </tbody>
        </table>
        <div style="width: 100%; height: 8px;"></div>
      
        <div style="width: 100%; height: 8px;"></div>
        
        <div class="notaDeGeneracion">
            *Reporte PDF generado por el sistema gestion.ciites.com el {{App\Fecha::getFechaHoraActual()}} por {{App\Empleado::getEmpleadoLogeado()->getNombreCompleto()}}
        </div>
        <div style="width: 100%; height: 70px;"></div>
 

    </div>
      
    
</body>

</html>
 