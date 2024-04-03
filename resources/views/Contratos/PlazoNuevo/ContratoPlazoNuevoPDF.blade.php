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

      </div>
    @endif

    {{-- esto es pos: absolute --}}
    <div class="Header">
      <img class="logo" src="{{ App\Configuracion::getRutaImagenCedepasPNG(200) }}">
      @if ($contrato->esBorrador())
        <div class="borrador">
          ESTE ES UN BORRADOR SIN VALOR
        </div>
      @endif

      <div class="codigo_contrato">
        {{ $contrato->codigo_unico }}
      </div>
    </div>
    <br>

    <div class="contenidoContrato">
      <p style="text-align: center;">
        <u>
          <b>
            CONTRATO DE TRABAJO A PLAZO FIJO POR SERVICIO ESPECÍFICO
          </b>
        </u>
      </p>

      <p>
        Conste por el presente documento que se extiende por duplicado,
        <b>EL CONTRATO INDIVIDUAL DE TRABAJO A PLAZO FIJO PARA SERVICIO ESPECÍFICO,</b>
        que celebran, de conformidad con lo dispuesto por el artículo 63° del Decreto Supremo 003-97-TR, Ley de Productividad y Competitividad Laboral; de una parte,
        <b>CENTRO PARA LA INVESTIGACIÓN, INNOVACIÓN Y DESARROLLO TERRITORIAL SOSTENIBLE - CIITES;</b>
        con RUC. N°20610973001, con domicilio legal en Nestor Batanero 137 Dpto. 101, distrito de Santiago de Surco, provincia y departamento de Lima  debidamente representado por su
        {{$contrato->getTextoDirector()}}, cuyas facultades se encuentran inscritas en la partida N° 15266204 del Registro De Personas Jurídicas de la Zona Registral N°IX sede Lima, a quien en adelante se le denominará CIITES; y de la otra parte

        <b class="{{$campo_editable}}">{{$contrato->getNombreCompleto()}}</b>
        identificado con DNI Nº
        <b class="{{$campo_editable}}">{{$contrato->dni}},</b>
        con domicilio en
        <b class="{{$campo_editable}}">{{$contrato->domicilio}}</b>,
        distrito de
        <b class="{{$campo_editable}}">{{$contrato->distrito}}</b>,
        provincia de
        <b class="{{$campo_editable}}">{{$contrato->provincia}}</b>,
        departamento de
        <b class="{{$campo_editable}}">{{$contrato->departamento}}</b>;
        a quien en adelante se le denominará
        <b>{{$contrato->getTrabajadore()}},</b>
        en los términos y condiciones siguientes:

        <br>
        <br>

        <b>
          <span class="subrayado">PRIMERA</span>
          .-	ANTECEDENTES. -
          El Centro para la Investigación, Innovación y Desarrollo Territorial Sostenible CIITES
        </b>;

        es una organización de desarrollo que impulsa proyectos para el incremento de los ingresos económicos de mujeres y hombres en condiciones vulnerables y promueve la innovación tecnológica y social para mejorar los ingresos y condiciones de vida de las poblaciones beneficiarias.
        La organización se dedica a la asistencia social, la educación y el desarrollo científico y cultural; orientado al fortalecimiento de capacidades de agricultores, agricultoras, autoridades municipales y regionales y lideres de la sociedad civil, que promueven el desarrollo local en el país; capacitar a hombres y mujeres de poblaciones vulnerables rurales y urbanos, mejorando su nivel educativo, sus conocimientos y habilidades para el desarrollo de innovaciones y tecnológicas, para el incremento de la productividad en las actividades económicas y mejora de condiciones de vida; capacitar a proveedores de servicios para mejorar su nivel educativo, conocimiento y habilidades para el desarrollo de innovaciones, incremento de productividades y mejoramiento de sus condiciones de vida.



        <br>
        <br>

        <b>
          <span class="subrayado">SEGUNDA</span>
          .- OBJETO DEL CONTRATO
        </b>. - CIITES suscribió

        <span class="{{$campo_editable}}">
          {{$contrato->getMensajeAdendaConvenioContrato()}}
        </span>

        <b class="{{$campo_editable}}">{{$contrato->nombre_financiera}}</b>,
        por el plazo de

        <b class="{{$campo_editable}}">{{$contrato->getTextoDuracionConvenio()}}</b>,
        con el objeto de ejecutar el proyecto:
        <b class="{{$campo_editable}}">{{$contrato->nombre_proyecto}}</b>
        En ese sentido, ante la suscripción de este convenio, no debe caber lugar a duda que, el puesto de
        <b class="{{$campo_editable}}">{{$contrato->puesto}}</b>,
        no es un puesto permanente, sino que está sujeto a la labor a desarrollar en el presente proyecto aunado a la duración del convenio antes mencionado; siendo esta la causa objetiva de la presente contratación. El carácter temporal del contrato de trabajo se funda en lo dispuesto en el artículo 63º del TUO del Decreto Legislativo 728, aprobado por Decreto Supremo 003-97-TR, de acuerdo al cual pueden celebrarse contratos de naturaleza temporal en el caso de un servicio específico. En ese contexto,
        <b>CIITES</b>

        requiere de las labores de
        <b>{{$contrato->getTrabajadore()}}</b>,
        cuya contratación se encuentra íntimamente vinculada a la circunstancia descrita precedentemente y, por ende supeditada a la necesidad y requerimiento del  servicio temporal en cuestión; proyectando su duración en los términos del plazo que se pacta para el presente contrato, el mismo que se estima razonable, necesario y suficiente para la conclusión de los servicios laborales materia del presente; todo lo cual constituye la causa objetiva de la presente contratación modal a plazo determinado, quedando plenamente justificada su temporalidad.



        <br>
        <br>


        <b><span class="subrayado">TERCERA</span>.-</b>

        <b>CARGO Y FUNCIONES</b>
        .- Por el presente documento,
        <b>CIITES</b>

        contrata temporalmente los servicios personales de
        <b>{{$contrato->getTrabajadore()}}</b>,
        quien declara estar capacitado y conocer la actividad que desarrollará y se obliga a desempeñar sus labores como
        <b class="{{$campo_editable}}">{{$contrato->puesto}}</b>,
        para que ejerza las distintas funciones relativas a su puesto, las que se desarrollaran en la zona de acción del proyecto; descritas en los
        <b>
          TÉRMINOS DE REFERENCIA
        </b>
        adjuntos que son parte del presente contrato; comprometiéndose a desarrollarlas con la mayor eficiencia y espíritu de colaboración, actuando con lealtad, responsabilidad,  honestidad, dedicación y diligencia, observando fidelidad hacia
        <b>CIITES</b>
        y de acuerdo con las instrucciones que le imparta como Empleador, en función a sus necesidades y requerimientos, los mismos que
        <b>{{$contrato->getTrabajadore()}}</b>
        reconoce de competencia de
        <b>CIITES;</b> por lo cual, se obliga a cumplir y contar con las funciones, herramientas y responsabilidades propias de dicho cargo, que a la fecha de suscripción del presente Contrato
        <b>{{$contrato->getTrabajadore()}}</b>
         declara haber conocido y recibido formalmente y a satisfacción.
        La especificación de sus funciones es enunciativa, más no limitativa, pudiendo desarrollar otras que le encomienden sus superiores. Del mismo modo la prestación de servicios deberá ser efectuada de manera personal, no pudiendo
        <b>{{$contrato->getTrabajadore()}}</b>
        ser reemplazado ni ayudado por tercera persona.
        Finalmente,
        <b>{{$contrato->getTrabajadore()}}</b>
        se compromete a realizar cualquier otra tarea asignada, inherente a su cargo, agotando con entera responsabilidad todos los mecanismos preliminares, procedimientos y formalidad que
        <b>CIITES</b>
        tiene establecidos, actuando siempre dentro de parámetros de absoluta honestidad, credibilidad, ética personal y laboral, poniendo en ello todo su esfuerzo.


        <br>
        <br>

        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}
        {{-- ******************************* CUARTA ***************************  --}}

        @if ($contrato->verificarTipo_PuestoConfianza())
          <b>
            <span class="subrayado">CUARTA</span>
            : CARGO DE CONFIANZA.
          </b>
          Considerando las labores descritas en la cláusula que antecede, de conformidad con lo dispuesto en el artículo 43º del Texto Único Ordenado de la Ley de Fomento del Empleo, aprobado por Decreto Supremo Nº 003-97-TR, Ley de Productividad y Competitividad Laboral, el cargo ocupado está calificado como PERSONAL DE DIRECCIÓN Y CONFIANZA, toda vez que de las funciones encargadas a {{$contrato->getTrabajadore()}}, el mismo tendrá acceso a información de carácter reservado y confidencial, y, además, ejercerá la representación general del empleador frente a otros trabajadores o a terceros, o lo sustituirá, y compartirá funciones de administración y control, etc. En ese sentido, la calificación del puesto antes aludida queda debidamente formalizada por medio del presente contrato, y por tanto cumplido el requisito a que se refiere el artículo 59º literal b) del Reglamento de la Ley de Fomento al Empleo
        @endif

        @if($contrato->verificarTipo_Atipico() || $contrato->verificarTipo_ConJornada() || $contrato->verificarTipo_SinJornada() || $contrato->verificarTipo_MedioTiempo())
          <b>
            <span class="subrayado">CUARTA</span>
            : PERÍODO DE PRUEBA.
          </b>

          @if ($contrato->tienePeriodoPrueba())
            -  De conformidad con lo dispuesto en el artículo 10º del TUO del D. Leg.728, las partes acuerdan que
            <b>
              {{$contrato->getTrabajadore()}}
            </b>
            se encontrará sujeto a un
            <b>período de prueba de tres (3) meses</b>,
            el cual se computará desde el
            <b class="{{$campo_editable}}">{{$contrato->getFechaInicioPruebaEscrita()}}</b> concluyendo
            <b class="{{$campo_editable}}">{{$contrato->getFechaFinPruebaEscrita()}}</b>

          @else
            - {{$contrato->getTrabajadore()}} no se encuentra sujeto a un periodo de prueba.
          @endif


        @endif




        <br>
        <br>

        {{-- ***************************** QUINTA **************************************** --}}
        {{-- ***************************** QUINTA **************************************** --}}
        {{-- ***************************** QUINTA **************************************** --}}
        {{-- ***************************** QUINTA **************************************** --}}
        {{-- ***************************** QUINTA **************************************** --}}
        {{-- ***************************** QUINTA **************************************** --}}
        {{-- ***************************** QUINTA **************************************** --}}
        {{-- ***************************** QUINTA **************************************** --}}
        {{-- ***************************** QUINTA **************************************** --}}
        {{-- ***************************** QUINTA **************************************** --}}

        @if ($contrato->verificarTipo_PuestoConfianza())
          <b>
            <span class="subrayado">QUINTA</span>
            : PLAZO Y PERIODO DE PRUEBA. -
          </b>

            El plazo del presente contrato comenzará a regir el
            <b class="{{$campo_editable}}">{{$contrato->getFechaInicioEscrita()}}</b>
            concluyendo el
            <b class="{{$campo_editable}}">{{$contrato->getFechaFinEscrita()}}</b>,
            sin necesidad de comunicación previa por parte de CIITES; salvo acuerdo escrito de las partes para la suscripción de la correspondiente prórroga, dentro de los alcances y plazos establecidos por las normas laborales vigentes, en relación con las contrataciones sujetas a modalidad.


            @if ($contrato->tienePeriodoPrueba())
              De conformidad con lo dispuesto en el artículo 10º del TUO del D. Leg.728, las partes acuerdan que {{$contrato->getTrabajadore()}} se encontrará sujeto a un período de prueba de 3 meses, el cual se computará desde el

              <b class="{{$campo_editable}}">{{$contrato->getFechaInicioPruebaEscrita()}}</b>
              , concluyendo el
              <b class="{{$campo_editable}}">{{$contrato->getFechaFinPruebaEscrita()}}</b>

              conforme a lo regulado en la segunda parte del artículo 10° del D.S. 003-97-TR. El período de prueba extendido se justifica en virtud a que el cargo para el cual está siendo contratado EL TRABAJADOR constituye PUESTO DE DIRECCIÓN Y CONFIANZA, siendo que, por la naturaleza del puesto, se requiere de un período de evaluación constante y prolongado en el tiempo, así como de un período razonable para analizar su buena adaptación en el puesto de trabajo.
            @else
              {{$contrato->getTrabajadore()}} no se encuentra sujeto a un periodo de prueba.

            @endif
        @endif


        @if($contrato->verificarTipo_Atipico() || $contrato->verificarTipo_ConJornada() || $contrato->verificarTipo_SinJornada() || $contrato->verificarTipo_MedioTiempo())

          <b>
            <span class="subrayado">QUINTA</span>
            : PLAZO. -
          </b>

          El plazo del presente contrato comenzará a regir desde el
          <b class="{{$campo_editable}}">{{$contrato->getFechaInicioEscrita()}}</b>,
          concluyendo el
          <b class="{{$campo_editable}}">{{$contrato->getFechaFinEscrita()}}</b>,
          sin necesidad de comunicación previa por parte de
          <b>CIITES</b>;
          salvo acuerdo escrito de las partes para la suscripción de la correspondiente prórroga, dentro de los alcances y plazos establecidos por las normas laborales vigentes, en relación con las contrataciones sujetas a modalidad.


        @endif



        <br>
        <br>


        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}
        {{-- ********************************* SEXTA ********************************** --}}


        @if ($contrato->verificarTipo_Atipico())

          <b>
            <span class="subrayado">SEXTA</span>
            .- JORNADA LABORAL. - {{$contrato->getTrabajadore()}},
          </b>

          se compromete a observar la jornada y el horario de trabajo que se le señale de acuerdo a las necesidades de la labor a realizar. Así, conforme a lo establecido en el artículo 4° del DS007-2022-TR (TUO de la Ley de jornada de trabajo, horario y trabajo en sobretiempo),
          <b>{{$contrato->getTrabajadore()}}</b>
          tendrá una jornada acumulativa de
          <b class="{{$campo_editable}}">{{$contrato->cantidad_dias_labor}}</b>
          días de labor por
          <b class="{{$campo_editable}}">{{$contrato->cantidad_dias_descanso}}</b>
          dias de descanso, con 10 horas de labor diaria. Queda perfectamente entendido entre las partes que las horas en sobretiempo que
          <b>{{$contrato->getTrabajadore()}}</b>
          acepte laborar, conforme a las necesidades de
          <b>CIITES</b>,
          serán compensadas conforme a la legislación vigente.
          Asimismo, ambas partes acuerdan que la modalidad de prestación del servicio será presencial.

        @endif


        @if ($contrato->verificarTipo_ConJornada())
          <b>
            <span class="subrayado">SEXTA</span>
            .- JORNADA LABORAL. - {{$contrato->getTrabajadore()}},
          </b>

          se compromete a observar el horario de trabajo que se le señale de acuerdo a las necesidades de la labor a realizar, dentro de la jornada legal semanal de 48 horas semanales. Queda perfectamente entendido entre las partes que las horas en sobretiempo que EL TRABAJADOR acepte laborar, conforme a las necesidades de CIITES, serán compensadas conforme a la legislación vigente.
          Asimismo, ambas partes acuerdan que la modalidad de prestación del servicio será presencial.
        @endif


        @if ($contrato->verificarTipo_SinJornada() || $contrato->verificarTipo_PuestoConfianza())
          <b>
            <span class="subrayado">SEXTA</span>
            .- EXCLUSIÓN DE LA JORNADA MÁXIMA LEGAL. -
          </b>

          Considerando las funciones propias del puesto de trabajo indicado en la cláusula SEGUNDA, {{$contrato->getTrabajadore()}} desarrollará sus labores sin supervisión inmediata de CIITES, a efectos del cumplimiento de metas y objetivos trazados y asociados al cargo asignado, debiendo reportarse fundamentalmente para dar cuenta de su trabajo y de los resultados del mismo, y para hacer las coordinaciones administrativas y operativas pertinentes. A partir de ello, {{$contrato->getTrabajadore()}} se encuentra calificado como “trabajador no sujeto a fiscalización inmediata”, por consiguiente, no se encontrará sujeto a la jornada máxima legal, conforme lo dispuesto en el artículo 5° del TUO del D.Leg.854, y artículo 10º de su Reglamento aprobado por D.S. Nro.008-2002-TR.  Tampoco estará obligado a firmar el Registro de Ingreso y Salida al centro de trabajo, ni le alcanzará el régimen legal de horas extras.

          No obstante, lo señalado en el párrafo que antecede, CIITES queda facultada para ejercer y exigir los controles que estime necesarios a fin de verificar el correcto y oportuno cumplimiento de todas y cada una de las obligaciones de {{$contrato->getTrabajadore()}}. Asimismo, podrá exigir la presencia y asistencia de {{$contrato->getTrabajadore()}} en sus oficinas o en el lugar que estime conveniente, en el momento y por el período de tiempo que pueda resultar necesario a efectos de constatar el cumplimiento y desarrollo de las labores para las cuales ha sido contratado.

          CIITES, en ejercicio de su poder de dirección, podrá variar los horarios fijados, estableciendo nuevos turnos y horarios de trabajo, de acuerdo a sus necesidades de operación y dentro del marco legal y parámetros establecidos en el antes citado cuerpo normativo y su Reglamento aprobado por D.S.008-2002-TR. Sin perjuicio de lo pactado en la presente cláusula, {{$contrato->getTrabajadore()}} se compromete a mantener un permanente involucramiento y disponibilidad para prestar la colaboración necesaria, y de forma voluntaria, durante la jornada de trabajo, y en los días u horas, inclusive días de descanso y feriados, que por necesidades concretas de las actividades de CIITES, o por requerimientos especiales de la misma, los cuales serán debidamente remunerados o compensados conforme a la normatividad vigente.


        @endif


        @if ($contrato->verificarTipo_MedioTiempo())
          <b>
            <span class="subrayado">SEXTA</span>
            .- JORNADA LABORAL. - {{$contrato->getTrabajadore()}},
          </b>

          se compromete a observar el horario de trabajo que se le señale de acuerdo a las necesidades de la labor a realizar, cumpliendo una jornada que no exceda de 24 horas semanales. Queda perfectamente entendido entre las partes que las horas en sobretiempo que {{$contrato->getTrabajadore()}} acepte laborar, conforme a las necesidades de CIITES, serán compensadas conforme a la legislación vigente. Asimismo, ambas partes acuerdan que la modalidad de prestación del servicio será presencial.
        @endif




        <br>
        <br>


        <b>
          <span class="subrayado">SEPTIMA</span>
          - REMUNERACIÓN Y RÉGIMEN LABORAL.-
        </b>
        Como contraprestación por sus servicios,
        <b>{{$contrato->getTrabajadore()}}</b>
        percibirá una remuneración mensual de
        <b class="{{$campo_editable}}">
          {{number_format($contrato->remuneracion_mensual,2)}} {{$contrato->getMoneda()->nombre}}
        </b>
        pagados en mensualidades vencidas, mediante planillas, y los demás beneficios que corresponden por Ley, dentro de los alcances y lineamientos del régimen laboral común, bajo los alcances del Decreto Legislativo N ° 728 y sus normas complementarias.
        El importe remunerativo estará sujeto a las deducciones y retenciones de ley, las ausencias injustificadas por parte de
        <b>{{$contrato->getTrabajadore()}}</b>
        implican la pérdida de la remuneración básica de modo proporcional a la duración de dicha ausencia, sin perjuicio del ejercicio de las facultades disciplinarias propias de
        <b>CIITES</b>,
        previsto en la legislación laboral y su Reglamento Interno. Será de cargo de
        <b>{{$contrato->getTrabajadore()}}</b>
        el pago del Impuesto a la Renta, aplicable a toda remuneración que se le abone, los aportes y contribuciones previsionales y sociales a su cargo, así como cualquier otro tributo que grave las remuneraciones del personal dependiente.
        <b>CIITES</b>
        cumplirá con efectuar las retenciones y descuentos de ley.
        <b>CIITES</b>
        se reserva el derecho de hacer las retenciones que de acuerdo a ley o mandato judicial corresponde.

        <br>

        <b>
          <span class="subrayado">OCTAVA</span>
          .- DEBERES DE {{$contrato->getTrabajadore()}}.-
        </b>
        Durante el desarrollo de las labores que le competen a
        <b>{{$contrato->getTrabajadore()}}</b>,
        éste se sujetará a las disposiciones de dirección y administración de
        <b>CIITES.</b>

        Asimismo, deberá cumplir con las normas propias de trabajo, las contenidas en el Reglamento Interno de Trabajo, de Seguridad y Salud en el Trabajo y demás normas laborales; y las que se impartan por necesidades del servicio en ejercicio de las facultades de administración de
        <b>CIITES</b>,
        de conformidad con el artículo 9 de la Ley de Productividad y Competitividad Laboral aprobado por D.S. Nº 003-97-TR; siendo alguna de estas:

        <ul>
          <li>
            A cumplir sus obligaciones con buena fe, lealtad, eficiencia y responsabilidad, velando por los intereses de
            <b>CIITES,</b>
            y cumpliendo con los estándares de asistencia laboral y ejecución de las tareas encargadas.
          </li>
          <li>
            Acatar todos los cambios de políticas y procesos que establezca
            <b>CIITES</b>
             durante el curso de la relación laboral, los mismos que se compromete a respetar, cumplir y ejecutar una vez que le sean comunicados por
             <b>CIITES.</b>
          </li>
          <li>
            Acatar las funciones, órdenes e instrucciones y directivas que imparta, señale o emita
            <b>CIITES</b>
            o sus representantes, observando los criterios de razonabilidad, proporcionalidad, claridad, transparencia y buena fe.
          </li>
          <li>
            Someterse a la normatividad legal interna, normas de Seguridad y Salud en el Empleo y demás disposiciones directivas, circulares, reglamentos, normas, Lineamientos, guías, protocolos y reglas de seguridad y afines, que emita o señale
            <b>CIITES</b>;
            todas las cuales reconoce conocer por haber tomado conocimiento de ellas.
          </li>
          <li>
            A devolver en forma inmediata todos los materiales (documentos, informes, bienes, herramientas, etc.) que se le entreguen con ocasión del trabajo prestado, si la relación laboral concluye por cualquier causa.
          </li>
          <li>
            A guardar estricta confidencialidad respecto de la información que reciba por razón de su trabajo. Por tanto, no podrá comunicar, divulgar o utilizar para beneficio propio o de cualquier otra persona, natural o jurídica, nacional o extranjera, pública o privada, la información confidencial, “Know-how”, conocimientos técnicos o similares que reciba de
            <b>CIITES</b>,
            ni podrá duplicarla, grabarla, copiarla o reproducirla de cualquier otra forma. Esta obligación será de cumplimiento obligatorio no solo durante la vigencia del presente contrato sino con posterioridad.
          </li>
        </ul>







        <b>
          <span class="subrayado">NOVENA</span>
          .-PODER DE DIRECCIÓN.-
        </b>
         En caso de incumplimiento de normas laborales y en general, frente a la comisión de faltas disciplinarias,
        <b>CIITES</b>
        ejercerá su poder disciplinario imponiendo las sanciones que correspondan, las mismas que podrán ser graduales, desde una amonestación verbal, llamada de atención por escrito, suspensión sin goce de haber, hasta la separación definitiva de
        <b>{{$contrato->getTrabajadore()}}</b>
        cuando ello corresponda, y de acuerdo al procedimiento establecido en el TUO del D.Leg.728 aprobado por D.S.003-97-TR; con excepción de los casos en que por la gravedad y taxatividad de la falta, proceda el despido como primera sanción.


        <br>


        <b>
          <span class="subrayado">DÉCIMA</span>
          .- CONFIDENCIALIDAD.- {{$contrato->getTrabajadore()}}
        </b>
        mantendrá confidencialidad absoluta durante la vigencia de este contrato, respecto de las informaciones y documentos en general proporcionados por
        <b>CIITES</b>
        o que hubiera obtenido en ejecución del mismo. Esta obligación subsistirá aún después de terminada la relación laboral y su incumplimiento genera la correspondiente responsabilidad por daños y perjuicios, sin desmedro de la persecución penal por el delito previsto en el artículo 165 del Código Penal y además por lo dispuesto por el inciso d) del artículo 25º del D.S. 003-97-TR.
        <b>{{$contrato->getTrabajadore()}}</b>
        se obliga a entregar, al término del contrato, los documentos, materiales e informes a los que hubiera tenido acceso con motivo de la ejecución del mismo.


        <br>

        <b><span class="subrayado">DÉCIMO PRIMERA</span>.- NO DISCRIMINACIÓN.- CIITES</b>,
        en observancia de lo prescrito en el artículo 2, inciso 2 de la Constitución Política del Perú y en el Convenio 111 de la Organización Internacional del Trabajo, y consciente de que todas las personas son únicas e irrepetibles y de que su identidad está formada por una diversidad de aspectos, muchos de los cuales no involucran una mayor o menor idoneidad para el puesto de trabajo que puedan ocupar; declara que en la presente contratación no ha mediado discriminación ni favoritismo sin causa objetiva, y se obliga a no efectuar distinciones, exclusiones o preferencias, respecto de
        <b>{{$contrato->getTrabajadore()}}</b>,
        basadas en motivos de raza, color, sexo, identidad de género, orientación sexual, embarazo, discapacidad, condición seropositiva, conocida o supuesta; religión, opinión política, sindicación, ascendencia, nacionalidad, origen social, lengua, condición económica ni cualquier otro motivo especificado por la legislación nacional, el Tribunal Constitucional o la Organización Internacional del Trabajo.


        <br>

        <b>
          <span class="subrayado">DÉCIMO SEGUNDA</span>
          .- SEGURIDAD Y SALUD EN EL TRABAJO.- {{$contrato->getTrabajadore()}}
        </b>
        se compromete a respetar y dar estricto cumplimiento a las normas sobre seguridad y salud en el trabajo que
        <b>CIITES</b>
        establezca como medidas de prevención de accidentes y protección de los trabajadores y de todos los bienes e instalaciones de la misma. Asimismo, deberá cooperar plenamente en casos de accidente y/o siniestros, así como en la prevención de los mismos, quedando establecido que todo accidente de trabajo acerca del cual tuviera conocimiento
        <b>{{$contrato->getTrabajadore()}}</b>,
        deberá ser reportado en forma inmediata a fin de tomar las medidas urgentes que sean necesarias. Igualmente,
        <b>{{$contrato->getTrabajadore()}}</b>
        se compromete a contribuir al desarrollo de los programas de capacitacion y entrenamiento que implemente
        <b>CIITES</b>
        en materia de seguridad y salud en el trabajo.

        <b>{{$contrato->getTrabajadore()}}</b>
        se obliga a cuidar de su persona y los bienes de su propiedad o posesión, y a no exponerse voluntaria o negligentemente a situaciones de riesgo en que pudiere contraer enfermedades o sufrir accidentes en el trabajo. Asimismo, no compartirá sus útiles personales con los demás trabajadores ni sus utensilios al consumir su refrigerio, de ser el caso. El incumplimiento de estas disposiciones da lugar a la imposición de las sanciones establecidas en los reglamentos, normas y procedimientos de
        <b>CIITES</b>
        y en los dispositivos legales vigentes, en materia de seguridad y salud en el trabajo.

        <br>

        <b>
          <span class="subrayado">DÉCIMO TERCERA</span>
          .- AUTORIZACIÓN DE DESCUENTO POR PLANILLA.-
          {{$contrato->getTrabajadore()}},
        </b>
         en caso vulnere los estándares y procedimientos establecidos por
         <b>CIITES,</b>
         y tal situación ocasionare un perjuicio económico para ésta, autoriza que la misma le descuente de su remuneración la cantidad equivalente al perjuicio o pérdida ocasionados en infracción de tales estándares.  Asimismo,
         <b>{{$contrato->getTrabajadore()}}</b>
        deberá reintegrar a
        <b>CIITES</b>
        el valor de los bienes que estando bajo su responsabilidad o custodia se perdieren o deterioraren por descuido o negligencia debidamente comprobada; así como los montos de dinero de propiedad de
        <b>CIITES,</b>
        a los que pudiere tener acceso con ocasión de sus funciones o que estén bajo su custodia; o los valores que resultaren en deudas derivadas de la ejecución del presente contrato o préstamos personales que le hubiere otorgado
        <b>CIITES</b>;
        o daños ocasionados durante la ejecución del mismo que originen un saldo deudor de cargo de
        <b>{{$contrato->getTrabajadore()}}</b>,
        para lo cual autoriza igualmente el respectivo descuento por planillas, o con cargo a su liquidación de beneficios sociales en caso de cese de la relación laboral.

        <br>


        <b>
          <span class="subrayado">DÉCIMO CUARTA</span>
          : AUTORIZACIÓN PARA RECOPILACIÓN Y TRATAMIENTO DE DATOS PERSONALES: {{$contrato->getTrabajadore()}}
        </b>
        declara:


        <ol style="margin-top:0px;" type="1">
          <li>
            Declaro expresamente, que para efectos de la suscripción del presente contrato, he suministrado mis datos personales. Asimismo, durante la ejecución del servicio
            <b>CIITES</b>
            podrá tener acceso a otros datos personales míos, suministrados o no por mí, o de ser el caso de cualquier otra persona.

          </li>

          <li>
            Declaro que
            <b>CIITES</b>
            me ha informado de manera expresa que la información que he proporcionado, como son: nombre, apellido, nacionalidad, estado civil, documento de identidad, ocupación, estudios, domicilio, correo electrónico, teléfono, estado de salud, actividades que realiza, ingresos económicos, patrimonio, gastos, entre otros, así como la referida a los rasgos físicos y/o de conducta que lo identifican o lo hacen identificable como es su huella dactilar, firma, voz, etc. (datos biométricos), conforme a Ley es considerada como Datos Personales.

          </li>
          <li>
            Doy mi consentimiento libre, previo, expreso e informado para que mis Datos Personales sean tratados por
            <b>CIITES</b>,
            es decir, que puedan ser: recopilados, registrados, organizados, almacenados, conservados, elaborados, modificados, bloqueados, suprimidos, extraídos, consultados, utilizados, transferidos o procesados de cualquier otra forma prevista por Ley. Esta autorización es indefinida y se mantendrá inclusive después de terminado el servicio y/o el presente Contrato.


          </li>
          <li>
            Autorizo que mis datos sean compartidos, transmitidos, entregados, transferidos o divulgados para las finalidades mencionadas a:

            i) Personas jurídicas que tienen la calidad de filiales, subsidiarias, contratistas o vinculadas, o de matriz de <b>CIITES,</b>
            ii) Los operadores necesarios para el cumplimiento de los servicios que presta <b>CIITES,</b>
            tales como: call centers, investigadores, compañías de asistencia, contratistas, y empresas interesadas en las labores de consultoría sobre el perfil de calidades y competencia de personal para llenar sus vacantes de trabajo, entre otros.

          </li>
          <li>
            Declaro que me han informado que tengo derecho a no proporcionar mis Datos Personales y que si no los proporciona no podrán tratar mis Datos Personales en la forma explicada en la presente cláusula, lo que no impide su uso para la ejecución y cumplimiento del Contrato.
            <br>


          </li>

          <li>
            Asimismo, declaro conocer que puedo revocar el consentimiento para tratar mis Datos Personales en cualquier momento. Para ejercer este derecho o cualquier otro que la Ley establece con relación a sus Datos Personales deberá presentar una solicitud escrita a mi empleador.

          </li>

        </ol>



        <b>
          <span class="subrayado">DÉCIMO QUINTA</span>
          .- USO Y ENTREGA DIGITAL DE DOCUMENTOS LABORALES.-
        </b>
         Al amparo de lo dispuesto en el artículo 1° del Decreto Supremo 009-2011-TR, que modificó los artículos 18, 19 y 20 del Decreto Supremo N° 001-98-TR, y dentro de los alcances de las normas de simplificación en materia laboral contenidas en el Decreto Legislativo 1310,
         <b>CIITES</b>
        se encuentra facultado a suscribir las boletas de pago de manera digital. Asimismo, podrá hacer uso del sistema digital de entrega de dichas boletas, a través de mecanismos electrónicos.

        <br>
        <br>

        De igual manera,
        <b>CIITES,</b>
        se encuentra facultado para implementar el sistema de firma y entrega digital de otros documentos (en adelante, los Documentos Laborales).
        <b>CIITES</b>,
        en virtud de lo dispuesto en el Decreto Legislativo 1310, se encuentra facultado para sustituir su firma ológrafa y el sellado manual por su firma digital, conforme lo regulado por el artículo 141-A del Código Civil; o, su firma electrónica, emitida conforme a lo regulado por la Ley número 27269, Ley de Firmas y Certificados Digitales, en todos los documentos laborales que emita. Por su parte,
        <b>{{$contrato->getTrabajadore()}}</b>
        reconoce dicha facultad del empleador, y autoriza la entrega de manera digital de sus boletas de pago de remuneraciones, y otros documentos laborales; reconociendo
        <b>{{$contrato->getTrabajadore()}}</b>
        que no se requiere firma de recepción de su parte en el supuesto que dichos documentos sean puestos a su disposición mediante el uso de tecnologías de la información y comunicación. Incluso,

        <b>{{$contrato->getTrabajadore()}}</b>
        otorgará para la comunicación vía remota (debido a estas circunstancias), el número telefónico celular y su correo electrónico; siendo estos válidos para las comunicaciones que efectuará
        <b>CIITES</b>.

        <br>


        Asimismo, a través del correo electrónico corporativo y/o cuenta de correo electrónico del trabajador,
        <b>CIITES</b>
        remitirá otros documentos de índole laboral tales como:
        Directivas, Procedimientos y demás normas conexas. Por su parte,
        <b>{{$contrato->getTrabajadore()}}</b>
        se compromete a descargar los documentos laborales, revisar su contenido, y a dar cabal cumplimiento en cuanto corresponda a sus obligaciones; declarando estar instruido que la remisión de los mismos, a través de dichos medios de tecnología de la información y comunicación, es señal de conformidad con su entrega. De igual manera,
        <b>{{$contrato->getTrabajadore()}}</b>
        se compromete a lo siguiente:

        <br>

        <ol style="margin-top:0px;" type="1">
          <li>
            Contar con una cuenta activa de correo electrónico, la cual deberá proporcionar a
            <b>CIITES</b>
            en el plazo de 5 días hábiles de iniciada la relación laboral. Mantener activo el correo electrónico y revisarlo periódicamente a fin de tomar conocimiento de los Documentos Laborales remitidos por
            <b>CIITES</b>
            .
          </li>
          <li>
            Dado que bajo este procedimiento de entrega digital de Documentos Laborales, la firma de
            <b>{{$contrato->getTrabajadore()}}</b>
            no es obligatoria, aquel deberá confirmar expresamente la recepción de cada uno de los Documentos Laborales remitidos al trabajador por parte de
            <b>CIITES</b>,
            dando conformidad de recepción de los documentos mediante el acuse de recibo a través de su cuenta de correo electrónico o a través de otro mecanismo análogo de confirmación. En caso
            <b>{{$contrato->getTrabajadore()}}</b>
            no realice el reclamo dentro del plazo establecido (3 días hábiles de remitidos los documentos laborales), se entenderá por aceptados la entrega y contenido de los documentos. En caso tuviera alguna consulta, queja, observación o detectara un error, deberá acercarse inmediatamente o enviar una comunicación escrita dentro de dicho término a fin de indicarlo y procurar resolverlo de común acuerdo entre las partes. En caso no lo hiciera, se entenderá que está conforme con su contenido.

          </li>

        </ol>


        <b>
          <span class="subrayado">DECIMO SEXTA</span>
          .- TRATAMIENTO DE DATOS PERSONALES CAPTADOS A TRAVÉS DE SISTEMAS DE VIDEOVIGILANCIA PARA EL CONTROL LABORAL.-
        </b>
         En virtud del poder de dirección de
         <b>CIITES</b>,
         este se encuentra facultado para realizar controles o tomar medidas para vigilar el ejercicio de las actividades laborales de
         <b>{{$contrato->getTrabajadore()}}</b>,
         entre las que se encuentra la captación y/o tratamiento de datos a través de sistemas de videovigilancia, de conformidad con lo establecido en los numerales 7.9 y 7.11 de la Directiva N° 01-2020-JUS/DGTAIPD, aprobada mediante Resolución Directoral N° 02-2020-JUS/DGTAIPD.

        En ese sentido,
        <b>{{$contrato->getTrabajadore()}}</b>
        reconoce que
        <b>CIITES</b>
        no necesita de su consentimiento para el tratamiento de sus datos personales, cuando la finalidad de utilizar los sistemas de videovigilancia se limita al control y supervisión de la prestación laboral.

        Sin perjuicio de lo expuesto,
        <b>CIITES</b>
        informará a
        <b>{{$contrato->getTrabajadore()}}</b>
        sobre los controles videovigilados. Asimismo,
        <b>CIITES</b>
        pondrá a disposición de
        <b>{{$contrato->getTrabajadore()}}</b>,
        el informativo adicional del sistema de videovigilancia, a través de medios informáticos, digitalizados o impresos, conforme a lo establecido en el numeral 6.12 de la mencionada Directiva; a efectos de garantizar el derecho reconocido en el artículo 18° de la Ley N° 29733, Ley de Protección de Datos Personales.

        <br>
        <br>


        <b>
          <span class="subrayado">DECIMO SEPTIMA</span>
          .- RÉGIMEN LABORAL.- {{$contrato->getTrabajadore()}}
        </b>
        estará sujeta al Régimen Laboral General de la actividad Privada, dentro de los alcances y efectos del D.S. 003-97-TR, TUO de la Ley de Productividad y Competitividad Laboral, para los trabajadores sujetos a Contratos de Trabajo bajo modalidad.

        <br>
        <br>


        <b>
          <span class="subrayado">DECIMO OCTAVA</span>
          .- EXTINCIÓN DEL CONTRATO DE TRABAJO.-
        </b>
        Queda entendido que
        <b>CIITES</b>
        no está obligado a dar aviso alguno adicional referente al término del presente contrato, operando su extinción a la expiración del tiempo comprendido en la cláusula CUARTA o la culminación del servicio que justifica la contratación; tal como lo determina el inc. c) del artículo 16º del D.S. 003-97-TR, oportunidad en la cual abonará a
        <b>{{$contrato->getTrabajadore()}}</b>
        los beneficios sociales que pudieren corresponderle. Sin perjuicio, a lo citado en el párrafo anterior, serán de aplicación al presente contrato, las demás causas generales de extinción previstas en el artículo 16º del D.S. 003-97-TR.

        <br>
        <br>


        <b>
          <span class="subrayado">DECIMO NOVENA</span>
          .- DOMICILIOS Y JURISDICCION.-
        </b>
        Las partes señalan como sus respectivos domicilios los especificados en la introducción del presente contrato, por lo que se reputarán válidas todas las comunicaciones y notificaciones dirigidas a las mismas con motivo de la ejecución del presente contrato. Todo cambio de domicilio de
        <b>{{$contrato->getTrabajadore()}}</b>
        deberá ser comunicado por escrito a
        <b>CIITES</b>
        para que surta efectos.
        Las partes contratantes se someten expresamente a la jurisdicción de las autoridades judiciales y administrativas de la ciudad de Trujillo.
        Ambas partes enteradas del contenido de todas y cada una de las cláusulas del presente documento proceden a firmar por duplicado, en señal de conformidad, en la ciudad de Trujillo, el
        <b class="{{$campo_editable}}">{{$contrato->getFechaGeneracionEscrita()}}</b>.
      </p>


      <table id="TablaFirmas" style="">
        <tbody>
          <tr>
            <td>
              <b>
                _______________________________<br>
                {{$contrato->getNombreDirector()}}<br>
                DNI: {{$contrato->getDNIDirector()}}<br>
                Presidente - CIITES
              </b>
            </td>
            <td>
              <b>
                _______________________________<br>
                <span class="{{$campo_editable}}">
                  {{ $contrato->getNombreCompleto() }}
                </span>
                <br>
                DNI:
                <span class="{{$campo_editable}}">
                  {{ $contrato->dni }}
                </span>
                <br>
                {{ $contrato->getTrabajadore() }}
              </b>
            </td>
          </tr>
        </tbody>
      </table>


      <div class="page_break"></div>


      <div>
        @include('Contratos.PlazoFijo.Anexo1pdf')
      </div>

 

    </div>




  </body>
  <style>

    /* margen por página */
    html{
      font-size: 11pt;
      text-align: justify;

      /* Arriba | Derecha | Abajo | Izquierda */

      margin-left: 88px;
      margin-right: 88px;

      margin-top: 70px;
      margin-bottom: 50px;
    }

    .codigo_contrato{
      position: absolute;
      right: 0;
      color:#817e7e;
      text-align: right;
    }

    .logo{
      position: absolute;
      width: 100px;
      left: 0px;
      top:-20px;
    }

    .borrador{

      text-align: center;
      font-size: 15pt;
      font-weight: bold;
      color:red;
    }

    .page_break {
      page-break-before: always;
    }

    .contenidoContrato {

      margin: 0px;
      margin-top: 30px; /* esto es porque el header es position absolute */
      word-wrap: break-word;
      /* para que el texto no salga del div*/
    }


    .subrayado{
      text-decoration: underline;
    }

    .Header {
      display: flex;
      z-index: 2;
      position: absolute;
      margin: 0px;
      top:-20px;
    }

    #TablaFirmas{
      width: 100%;
      text-align:center;
      margin-top:60pt;
      font-size:11pt;
    }

    .anulado {
      color: red;
    }

    .declara_container{
      margin-left: 30px;
      text-align: justify;
      border: solid 1px red;
    }

    footer .pagenum:before {
      content: counter(page);
    }

    .text-center{
      text-align: center;
    }

    .campo_editable{
      color:rgb(0, 62, 176);
    }

    .quitar_margenes{
      margin-top: 0px;
      margin-bottom: 0px;
    }
  </style>




</html>
