<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Constancia deposito CTS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>


      html {
        /* Arriba | Derecha | Abajo | Izquierda */
        margin: 50pt 60pt 50pt 69pt;
        font-family: Candara, Calibri, Segoe, "Segoe UI", Optima, Arial, sans-serif;
      }

      #principal {
        /*background-color: rgb(161, 51, 51);*/
        word-wrap: break-word;
        /* para que el texto no salga del div*/
      }

      thead {
        font-size: large;
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

      .imagen_logo{
        width: 210px;
      }

      .titulo_general{
        font-size: 11.5pt;
        padding-top:18px;
        padding-bottom:18px;

        background-color: rgb(0, 102, 205);
        color: white
      }

      .tabla_firmas{
        width: 100%;
        text-align:center;
        margin-top:10pt;
        border:0px solid white !important;
        font-size:11pt;
      }
      .texto_escrito{
        padding: 8px;
        text-align: justify;
      }

    </style>
    @include('CSS.PdfUtils')
  </head>

  <body>

    <div id="principal" style="">
      <table class="w-100">
        <thead >
          <tr>
            <th>
              <img class="imagen_logo" src="{{ App\Configuracion::getRutaImagenCedepasPNG() }}">
            </th>
            <th style="text-align: center">
              {{$constancia->codigo_unico}}
            </th>
          </tr>
          <tr>
            <th colspan="2" class="titulo_general">
              CONSTANCIA DE DEPÓSITO DE COMPENSACIÓN POR TIEMPO DE SERVICIOS
            </th>
          </tr>

        </thead>
        <tbody>
          <tr>
            <td colspan="2" class="texto_escrito">
              El CENTRO PARA LA INVESTIGACIÓN, INNOVACIÓN Y DESARROLLO TERRITORIAL SOSTENIBLE - CIITES,
              domiciliado en Nestor Batanero 137 Dpto. 101, distrito de Santiago de Surco, provincia y departamento de Lima, con RUC N° 20610973001, representado por
              su presidente {{$constancia->getNombreDirectorGeneral()}},

              otorga la presente constancia por el depósito de Compensación por Tiempo de Servicios a:
              {{$constancia->getNombreCompleto()}}
              identificado/a con el D.N.I
              {{$constancia->dni}},
              realizado el
              {{$constancia->getFechaDepositoEscrita()}};
              en la cuenta C.T.S Nro.
              {{$constancia->nro_cuenta}};
              en el banco
              {{$constancia->nombre_banco}}
              de acuerdo al siguiente detalle:

            </td>
          </tr>
        </tbody>

      </table>



      <table class="w-100 mt-1">
        <tbody>

          <tr>
            <td class="bold">
              1. PERIODO A DEPOSITAR
            </td>
            <td class="text-center">
              Del {{$constancia->getFechaInicioEscrita()}} al {{$constancia->getFechaFinEscrita()}}
            </td>
          </tr>




        </tbody>
      </table>

      <table class="w-100 mt-1">
        <tbody>
          <tr>
            <td class="bold">
              2. REMUNERACIÓN COMPUTABLE
            </td>
            <td  class="text-right bold">
              Importe
            </td>
          </tr>

          <tr>
            <td class="">
              Ultimo sueldo bruto percibido
            </td>
            <td class="text-right">
              S/ {{$constancia->getUltimoSueldoBruto()}}
            </td>
          </tr>

          <tr>
            <td class="">
              1/6 de la última gratificación percibida
            </td>
            <td class="text-right">
              S/ {{$constancia->getSextoUltimaGrati(true)}}
            </td>
          </tr>


          <tr>
            <td class="">
              Prom. otras remuneraciones
            </td>
            <td class="text-right">
              S/ {{$constancia->getPromedioOtrasRemuneraciones(true)}}
            </td>
          </tr>

          <tr>
            <td class="bold">
              Total remuneración computable:
            </td>
            <td class="text-right">
              S/ {{$constancia->getTotalRemuneracionComputable(true)}}
            </td>
          </tr>


          <tr>
            <td class="bold">
              Fracción de remuneración computable mensual:
            </td>
            <td class="text-right">
              S/ {{$constancia->getFraccionRemuneracionComputableMensual(true)}}
            </td>
          </tr>

          <tr>
            <td class="bold">
              Fracción de remuneración computable diaria:
            </td>
            <td class="text-right">
              S/ {{$constancia->getFraccionRemuneracionComputableDiaria(true)}}
            </td>
          </tr>


        </tbody>

      </table>


      <table class="w-100 mt-1">
        <tbody>

          <tr>
            <td class="bold">
              3. CÁLCULO DE LA CTS A DEPOSITAR
            </td>
            <td class="text-center">
              Cantidad
            </td>
            <td class="text-right bold">
              Importe
            </td>
          </tr>
          <tr>
            <td>
              Nº meses laborados
            </td>
            <td class="text-center">
              {{$constancia->nro_meses_laborados}}


            </td>
            <td class="text-right">
              S/ {{$constancia->getMontoMesesLaborados(true)}}
            </td>

          </tr>

          <tr>
            <td>
              Nº días laborados
            </td>
            <td class="text-center">
              {{$constancia->nro_dias_laborados}}
            </td>
            <td class="text-right">
              S/ {{$constancia->getMontoDiasLaborados(true)}}
            </td>

          </tr>

          <tr>
            <td colspan="2"  class="text-center">
              TOTAL CTS DEL PERIODO
            </td>

            <td class="text-right bold">
              S/ {{$constancia->getTotalCTS(true)}}
            </td>

          </tr>


        </tbody>

      </table>


      <table class="tabla_firmas">
        <tbody>
          <tr>
            <td>
              <br>
              <br>
              <br>
              <br>

              <b>
                _______________________________<br>
                {{$constancia->getNombreDirectorGeneral()}}<br>
                PRESIDENTE
              </b>
            </td>
            <td>
              <br>
              <br>
              <br>
              <br>


              <b>
                _______________________________<br>
                <span>{{strtoupper($constancia->getNombreCompleto())}}</span>
                <br>
                DNI:
                <span>{{$constancia->dni}}</span>


              </b>
            </td>
          </tr>
        </tbody>
      </table>



      <div class="notaDeGeneracion">
        *Vista PDF generada por el sistema gestion.ciites.com el {{ App\Fecha::getFechaHoraActual() }} por
        {{ App\Empleado::getEmpleadoLogeado()->getNombreCompleto() }}
      </div>



      <div class="w-100 text-right">

        <br>
        Emitido el {{$constancia->getFechaHoraEmisionEscrita()}}
      </div>

      <br>

    </div>


  </body>

</html>
