<!DOCTYPE html>
<html lang="en">

<head>
  <title>Viaje #{{ $viaje->getIdEstandar() }}</title>
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
      margin: 50pt 60pt 50pt 60pt;
      font-family: Candara, Calibri, Segoe, "Segoe UI", Optima, Arial, sans-serif;
    }

    #principal {
      /*background-color: rgb(161, 51, 51);*/
      word-wrap: break-word;
      /* para que el texto no salga del div*/
    }


    tbody {
      font-size: 13px;
    }

    table,
    th,
    td {
      border: 1px solid black;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 3px;
    }

    .colores_titulo {
      background-color: rgb(0, 102, 205);
      color: white
    }

    .logo {
      height: 70px;
    }

    .colores_titulo {
      background-color: rgb(0, 102, 205);
      color: white
    }
  </style>
  @include('CSS.PdfUtils')


</head>

<body>
  <div id="principal">




    <table class="w-100">
      <tbody>
        <tr>
          <th colspan="3">
            <img src="{{ App\Configuracion::getRutaImagenCedepasPNG() }}" class="logo">
          </th>
          <th class="text-center" colspan="3">
            VIAJE VEHICULAR N° {{ $viaje->getIdEstandar() }}
          </th>
        </tr>

      </tbody>
    </table>

    <table class="w-100 mt-1">

      <tbody>

        <tr>
          <td colspan="4" class="bold text-center colores_titulo">
            INFORMACIÓN GENERAL
          </td>
        </tr>

        <tr>
          <td class="bold">
            Conductor:
          </td>
          <td>
            {{ $conductor->getNombreCompleto() }}
          </td>
          <td class="bold">
            Vehículo:
          </td>
          <td>
            {{ $vehiculo->getDescripcion() }}
          </td>


        </tr>
        <tr>
          <td class="bold">
            Aprobado por:
          </td>
          <td>
            {{ $viaje->getEmpleadoAprobador()->getNombreCompleto() }}
          </td>
          <td class="bold">
            Estado:
          </td>
          <td>
            {{ $viaje->getEstado()->nombreAparente }}
          </td>


        </tr>
      </tbody>

    </table>




    <table class="w-100 mt-1">
      <tbody>
        <tr>
          <td colspan="6" class="bold text-center colores_titulo">
            INFORMACIÓN DE SALIDA
          </td>
        </tr>
        <tr>
          <td class="bold">
            Kilometraje:
          </td>
          <td>
            {{ $viaje->kilometraje_salida }}
          </td>
          <td class="bold">
            Fecha
          </td>
          <td>
            {{ $viaje->getFechaSalida() }}
          </td>
          <td class="bold">
            Hora
          </td>
          <td>
            {{ $viaje->getHoraSalida() }}
          </td>


        </tr>
        <tr>
          <td class="bold">
            Motivo
          </td>
          <td>
            {{ $viaje->motivo }}
          </td>
          <td class="bold">
            Lugar de Origen
          </td>
          <td>
            {{ $viaje->lugar_origen }}
          </td>
          <td class="bold">
            Lugar de Destino
          </td>
          <td>
            {{ $viaje->lugar_destino }}
          </td>
        </tr>
        <tr>
          <td colspan="6">
            <b>
              OBSERVACIONES:
            </b>
            <br>

            {{ $viaje->getObservacionesSalida() }}

          </td>
        </tr>
      </tbody>
    </table>






    <table class="w-100 mt-1">
      <tbody>
        <tr>
          <td colspan="6" class="bold text-center colores_titulo">
            INFORMACIÓN DE SALIDA
          </td>
        </tr>
        <tr>
          <td class="bold">
            Kilometraje:
          </td>
          <td>
            {{ $viaje->kilometraje_llegada }}
          </td>


          <td class="bold">
            Fecha:
          </td>
          <td>
            {{ $viaje->getFechaLlegada() }}
          </td>
          <td class="bold">
            Hora:
          </td>
          <td class="text-center">
            {{ $viaje->getHoraLlegada() }}
          </td>





        </tr>
        <tr>



          <td colspan="2" class="bold">
            Factura combustible:
          </td>
          <td class="text-center">
            {{ $viaje->codigo_factura_combustible }}
          </td>

          <td colspan="2" class="bold">
            Monto gastado soles:
          </td>
          <td class="text-right">
            {{ $viaje->monto_factura_combustible }}
          </td>




        </tr>
        <tr>

          <td class="bold" colspan="2">
            Kilometraje Recorrido:
          </td>
          <td class="text-center">
            {{ $viaje->kilometraje_recorrido }}
          </td>


          <td class="bold" colspan="2">
            Rendimiento:
          </td>
          <td class="text-center">
            {{ $viaje->getRendimiento() }}
          </td>

        </tr>
        <tr>
          <td colspan="6">
            <b>
              OBSERVACIONES:
            </b>
            <br>

            {{ $viaje->getObservacionesLlegada() }}

          </td>
        </tr>
      </tbody>
    </table>





    <table class="w-100 mt-1">
      <tbody>
        <tr>
          <td class="bold text-center colores_titulo">
            DECLARACIÓN JURADA
          </td>
        </tr>
        <tr>
          <td class="">
            Yo ,
            <b>{{ $conductor->getNombreCompleto() }}</b>,
            identificado con DNI
            <b>{{ $conductor->dni }}</b>,
            DECLARO BAJO JURAMENTO, Que NO PRESENTO SINTOMAS DE
            FATIGA NI SOMNOLENCIA, ya
            que he dormido mis 8 horas completas, no tengo ninguna dolencia en mi cuerpo, no presento ningún problema familiar/laboral que
            pueda afectar mi desempeño en el trabajo, no he consumido ninguna medicina el día de hoy, y tampoco he ingerido bebidas
            alcóholicas en las últimas 24 horas,.
            Para constancia ACEPTO la presente DECLARACIÓN JURADA.
          </td>
        </tr>
      </tbody>
    </table>

    <div class="notaDeGeneracion">
      *Vista PDF generada por el sistema gestion.ciites.com el {{ App\Fecha::getFechaHoraActual() }} por
      {{ App\Empleado::getEmpleadoLogeado()->getNombreCompleto() }}
    </div>



  </div>


</body>

</html>
