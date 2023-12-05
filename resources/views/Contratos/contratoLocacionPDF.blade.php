@php
  $campo_editable = "";
  if($contrato->esBorrador()){
    $campo_editable = "campo_editable";
  }
@endphp

<!DOCTYPE html>
<html lang="es">

  <head>
    <meta charset="UTF-8">

    <title>
      @if ($contrato->esBorrador())
        BORRADOR
      @endif
      {{ $contrato->getTituloContrato() }}
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
      .contenidoContrato {
        /* Arriba | Derecha | Abajo | Izquierda */
        margin: 50pt 32pt 30pt 32pt;
        word-wrap: break-word;
        /* para que el texto no salga del div*/
      }


      #Header {
        display: flex;
        z-index: 2;
        position: absolute;
        /* Arriba | Derecha | Abajo | Izquierda */
        margin: 0 32pt 0 32pt;
      }

      .anulado {
        color: red;
      }

      .letraPequeña {}
      .campo_editable{
        color:rgb(0, 62, 176);
      }

      .borrador{

        text-align: center;
        font-size: 15pt;
        font-weight: bold;
        color:red;
      }
    </style>


  </head>

  <body @if ($contrato->estaAnulado()) class="anulado" @endif>

    @if ($contrato->estaAnulado())
      <div style="text-align:center">
        <h1 class="">
          <b>
            ANULADO
          </b>
        </h1>
        <span style=" font-size: 9pt;">
          Este contrato fue anulado el {{ $contrato->getFechaAnulacion() }} por
          {{ $contrato->getEmpleadoCreador()->getNombreCompleto() }}.
        </span>
        <br>
      </div>
    @endif

    <div id="Header">
      <div>
        <img src="{{ App\Configuracion::getRutaImagenCedepasPNG() }}" width="100px">
      </div>
      @if ($contrato->esBorrador())
        <div class="borrador">
          ESTE ES UN BORRADOR SIN VALOR
        </div>
      @endif

      <div style="color:#817e7e; text-align: right;">

        {{ $contrato->codigo_unico }}

      </div>
    </div>

    <div class="contenidoContrato" style="">
      <p style="text-align: center;">
        <u>
          <b>
            CONTRATO LOCACION DE SERVICIOS
          </b>
        </u>
      </p>
      <p style="text-align: justify;">


        Conste por el presente documento el CONTRATO POR SERVICIOS, que celebran de una parte el CENTRO PARA LA
        INVESTIGACIÓN, INNOVACIÓN Y DESARROLLO TERRITORIAL SOSTENIBLE - CIITES, con domicilio legal en Nestor Batanero
        137 Dpto. 101, distrito de Santiago de Surco, provincia y departamento de Lima,

        con RUC N° 20610973001, debidamente representada por el señor Federico Bernardo Tenorio Calderón, identificado
        con DNI. N° 26716577, a quien en adelante se le denominará
        CIITES;

        @if ($contrato->esDeNatural())
          y de la otra parte el señor
          <b class="{{$campo_editable}}">{{ $contrato->getNombreCompleto() }},</b>
          identificado con DNI
          <b class="{{$campo_editable}}">{{$contrato->dni}},</b>
          y RUC
          <b class="{{$campo_editable}}">{{$contrato->ruc}}</b>
          con domicilio legal en
          <b class="{{$campo_editable}}">{{ $contrato->direccion}}</b>,
          distrito de
          <b class="{{$campo_editable}}">{{ $contrato->distrito}}</b>,
          provincia de
          <b class="{{$campo_editable}}">{{ $contrato->provincia}}</b>,
          departamento de
          <b class="{{$campo_editable}}">{{$contrato->departamento}}</b>

        @else
          y de la otra parte
          <b class="{{$campo_editable}}">{{ $contrato->razonSocialPJ }},</b>
          con RUC
          <b class="{{$campo_editable}}">{{ $contrato->ruc }}</b>
          y domicilio fiscal en
          <b class="{{$campo_editable}}">{{ $contrato->direccion }}</b>
          distrito de
          <b class="{{$campo_editable}}">{{ $contrato->distrito}}</b>,
          provincia de
          <b class="{{$campo_editable}}">{{ $contrato->provincia }}</b>,
          departamento de
          <b class="{{$campo_editable}}">{{$contrato->departamento}}</b>
          representada por su
          <b class="{{$campo_editable}}">{{$contrato->nombreDelCargoPJ}}</b>,
          <b class="{{$campo_editable}}">{{$contrato->getNombreCompleto()}}</b>,
          identificado con DNI
          <b class="{{$campo_editable}}">{{$contrato->dni}}</b>,
        @endif
        a quien en adelante se le denominará <b>{{ $contrato->getLocadore() }};</b> bajo las cláusulas siguientes:



      </p>
      <p>
        <u>
          <b>
            PRIMERO</b></u>
      </p>
      <p style="text-align: justify;">

        PRIMERO.- ANTECEDENTES. - El Centro para la Investigación, Innovación y Desarrollo Territorial Sostenible
        CIITES; es una organización de desarrollo que impulsa proyectos para el incremento de los ingresos económicos de
        mujeres y hombres en condiciones vulnerables y promueve la innovación tecnológica y social para mejorar los
        ingresos y condiciones de vida de las poblaciones beneficiarias.
        La organización se dedica a la asistencia social, la educación y el desarrollo científico y cultural; orientado
        al fortalecimiento de capacidades de agricultores, agricultoras, autoridades municipales y regionales y lideres
        de la sociedad civil, que promueven el desarrollo local en el país; capacitar a hombres y mujeres de poblaciones
        vulnerables rurales y urbanos, mejorando su nivel educativo, sus conocimientos y habilidades para el desarrollo
        de innovaciones y tecnológicas, para el incremento de la productividad en las actividades económicas y mejora de
        condiciones de vida; capacitar a proveedores de servicios para mejorar su nivel educativo, conocimiento y
        habilidades para el desarrollo de innovaciones, incremento de productividades y mejoramiento de sus condiciones
        de vida.

        <br>
        <br>





      </p>







      <p>
        <u>
          <b>
            SEGUNDO
          </b>
        </u>
      </p>

      <p style="text-align: justify;">

        En virtud a sus objetivos institucionales, LA COMITENTE: CIITES

        ejecutará el proyecto
        <b class="{{$campo_editable}}">"{{$contrato->nombreProyecto}}"</b>
        financiado por
        <b class="{{$campo_editable}}">{{$contrato->nombreFinanciera}}</b>;
        por lo que
        conviene en solicitar los servicios de
        <b class="{{$campo_editable}}">
          {{ $contrato->getLocadore() }},
        </b>para
        <b class="{{$campo_editable}}">
          "{{ $contrato->motivoContrato }}";
        </b> según los términos de referencia adjuntos, que forman parte del presente contrato.

      </p>


      <p>
        <u>
          <b>
            TERCERO
          </b>
        </u>
      </p>
      <p style="text-align: justify;">
        El tiempo asignado para el cumplimiento del contrato y entrega de los productos es del
        <b class="{{$campo_editable}}">{{ $contrato->getFechaInicioEscrita() }}</b>
        al
        <b class="{{$campo_editable}}">{{ $contrato->getFechaFinEscrita() }}.</b>
        El tiempo de contratación ha sido determinado en función al cronograma de productos.
        El presente contrato concluirá para ambas partes a la conformidad del servicio,
        la cual será expedida por el responsable de la contratación.

      </p>














      <p>
        <u>
          <b>
            CUARTO
          </b>
        </u>
      </p>
      <p style="text-align: justify;">
        Como contraprestación por sus servicios, LA COMITENTE: CIITES abonará a
        <b class="{{$campo_editable}}">
          {{ $contrato->getLocadore() }}
        </b>
        una retribución total de
        <span class="{{$campo_editable}}">
          {{ $contrato->getMoneda()->simbolo }} {{ number_format($contrato->retribucionTotal, 2) }}
        </span>

        ,que incluye todo concepto de pago, la misma que estará sujeta a
        descuentos y retenciones de acuerdo a la ley y se cancelará previa presentación de

        <span class="{{$campo_editable}}">
          @if ($contrato->esDeNatural())
            recibo por honorarios
          @else
            factura
          @endif
        </span>


        de acuerdo al siguiente detalle:
      </p>
      <p>
        @foreach ($listaItems as $i => $itemavance)
          <b>
            {{ chr($i + 97) }})
          </b>
          A la presentación del Producto N°{{ $i + 1 }}:
          <span class="{{$campo_editable}}">"{{ $itemavance->descripcion }}"</span>
          al
          <span class="{{$campo_editable}}">{{ $itemavance->getFechaEntregaEscrita() }}</span>;
          el importe de
          <span class="{{$campo_editable}}">{{$contrato->getMoneda()->simbolo}} {{ number_format($itemavance->monto, 2)}}</span>
          correspondiente al
          <span class="{{$campo_editable}}">
            {{ $itemavance->porcentaje }}
          </span> %.
          <br>
        @endforeach
      </p>









      <p>
        <u>
          <b>
            QUINTO
          </b>
        </u>
      </p>
      <p style="text-align: justify;">
        El presente contrato es de naturaleza civil, por lo tanto queda establecido que
        <b>
          {{ $contrato->getLocadore() }}
        </b>
        no está sujeto a subordinación o dependencia alguna frente a
        <b>LA COMITENTE: CIITES,</b> en tal sentido, tiene plena libertad en el ejercicio de sus servicios
        profesionales.

        <br>
        Por tratarse de LOCACIÓN DE SERVICIOS,
        <b>
          {{ $contrato->getLocadore() }} NO
        </b>
        tiene relación alguna de dependencia laboral
        con LA COMITENTE: CIITES, en consecuencia, este contrato no otorga derecho de vacaciones, compensación por
        tiempo de servicios, ni otros beneficios sociales.
        <b>
          {{ $contrato->getLocadore() }} NO
        </b>
        está sujeto a un horario de trabajo.
      </p>













      <p>
        <u>
          <b>
            SEXTO
          </b>
        </u>
      </p>
      <p style="text-align: justify;">
        <b>{{ $contrato->getLocadore() }}</b>, se obliga por el presente contrato a prestar sus servicios descritos en
        la cláusula segunda del
        mismo, con eficiencia, esmero y lealtad.
        <b>
          LA COMITENTE: CIITES,
        </b> es propietario de toda información que se obtenga o
        elabore durante la vigencia del presente contrato. Así mismo se obliga a mantener confidencialidad y reserva
        durante y después de la vigencia del presente contrato, respecto de las informaciones que le sean
        proporcionadas para el desarrollo de la consultoría. En ese sentido
        <b>
          {{ $contrato->getLocadore() }}
        </b>
        no deberá usar, divulgar, reproducir, compartir, aprovechar y/o trasladar a terceros cualquier documento,
        proyecto, método, conocimiento y
        otros que durante la prestación de sus servicios haya tenido acceso, le hayan proporcionado o haya llegado a su
        poder.
      </p>
      <p>
        <u>
          <b>
            SEPTIMO
          </b>
        </u>
      </p>
      <p style="text-align: justify;">
        <b>
          {{ $contrato->getLocadore() }}
        </b>
        , está obligado a contar con un seguro de salud vigente durante la vigencia del contrato,
        precisando que
        <b>
          LA COMITENTE: CIITES
        </b>
        no cubrirá gastos de curación por accidentes ni enfermedades que pudieran producirse durante la prestación del
        servicio.
      </p>




      <p>
        <u>
          <b>
            OCTAVO
          </b>
        </u>
      </p>
      <p style="text-align: justify;">
        Son aplicables al presente contrato, en lo que corresponda, las normas que contiene el Código Civil vigente en
        los artículos 1764 al 1770 y demás normas conexas que se dicten durante la vigencia del mismo.

        En lo no previsto por las partes en el presente contrato, ambas se someten a lo establecido por las normas del
        código
        civil y demás del sistema jurídico que les resulten aplicables.
        <br>
        Para efectos de cualquier controversia que se genere
        con motivo de la celebración y ejecución del presente contrato, las partes se someten a la competencia
        territorial de jueces y tribunales de la ciudad de Trujillo.

        <br>
        Cualquiera de las
        partes podrá resolver el presente contrato por causas justificadas.
      </p>










      <p>
        <u>
          <b>
            NOVENO
          </b>
        </u>
      </p>
      <p style="text-align: justify;">
        Los contratantes fijan como sus domicilios los indicados en la introducción del presente contrato, en donde se
        tendrán por bien efectuadas las comunicaciones y/o notificaciones que se cursen a los efectos derivados de la
        ejecución contractual. Asimismo, declaran estar plenamente de acuerdo con los términos y condiciones
        expresadas en el presente contrato, sometiéndose a la jurisdicción y competencia de los jueces y tribunales de
        ciudad de
        <b>Trujillo.</b>
      </p>
      <p>
        En señal de conformidad, ambas partes firman el presente contrato en
        <b class="{{$campo_editable}}">
          {{ $contrato->getSede()->nombre }}, {{ $contrato->getFechaGeneracionEscrita() }}.
        </b>
      </p>





      <table style="width: 100%; text-align:center; margin-top:80pt">
        <tbody>
          <tr>
            <td>
              <b>
                _____________________________<br>
                Federico Bernardo Tenorio Calderón<br>
                DNI: 26716577<br>
                LA COMITENTE: CIITES
              </b>
            </td>
            <td>
              <b>
                _____________________________<br>
                <span class="{{$campo_editable}}">
                  {{ strtoupper($contrato->getNombreCompleto()) }}
                </span>
                <br>
                DNI:
                <span class="{{$campo_editable}}">
                  {{ $contrato->dni }}
                </span>
                <br>
                <span class="{{$campo_editable}}">
                  {{ $contrato->getLocadore() }}
                </span>

              </b>
            </td>
          </tr>
        </tbody>
      </table>





    </div>








  </body>

</html>
