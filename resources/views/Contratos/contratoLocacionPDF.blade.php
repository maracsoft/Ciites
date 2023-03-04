<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    
    <title>
        {{$contrato->getTituloContrato()}}
    </title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .contenidoContrato {
            /* Arriba | Derecha | Abajo | Izquierda */
            margin: 50pt 32pt 30pt 32pt;
            word-wrap: break-word;/* para que el texto no salga del div*/
        }
         
       
        #Header{
            display:flex;
            z-index: 2;
            position: absolute;
            /* Arriba | Derecha | Abajo | Izquierda */
            margin: 0 32pt 0 32pt;
        }
        .anulado{
            color:red;
        }
        .letraPequeña{
           
        }
         
    </style>
    
    
</head>
<body @if($contrato->estaAnulado()) class="anulado" @endif>

    @if($contrato->estaAnulado())
        <div style="text-align:center">
            <h1 class="">
                <b>
                    ANULADO
                </b> 
            </h1>
            <span style=" font-size: 9pt;">
                Este contrato fue anulado el {{$contrato->getFechaAnulacion()}} por
                {{$contrato->getEmpleadoCreador()->getNombreCompleto()}}.
            </span>
            <br>
        </div>
       
    @endif
   
    <div id="Header">
        <div>
            <img src="{{App\Configuracion::getRutaImagenCedepasPNG()}}" width="100px">
        </div>
        <div style="color:#817e7e; text-align: right;">
        
            {{$contrato->codigoCedepas}}
            
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


            Conste por el presente documento el CONTRATO POR SERVICIOS, que celebran de una parte el Centro 
            Ecuménico de Promoción y Acción Social Norte - CEDEPAS Norte, con domicilio legal en Calle Los Corales N° 289 
            Urb. Santa Inés de la ciudad de Trujillo, con RUC N° 20481234574, representado por su Directora General, 
            ANA CECILIA ANGULO ALVA, identificada con DNI. N° 26682689, a quien en adelante se le denominará 
            CEDEPAS Norte;

            @if($contrato->esDeNatural())
                
                y de la otra parte el señor <b>{{$contrato->getNombreCompleto()}},</b> identificado con DNI
                <b>{{$contrato->dni}},</b> y RUC  <b>{{$contrato->ruc}}</b> con domicilio
                 legal en <b>{{$contrato->direccion}},</b> provincia de <b>{{$contrato->provinciaYDepartamento}}</b>, 
                

            @else
                y de la otra parte <b>{{$contrato->razonSocialPJ}}, </b>con RUC <b>{{$contrato->ruc}}</b>
                y domicilio fiscal en <b>{{$contrato->direccion}}</b> provincia de 
                <b>{{$contrato->provinciaYDepartamento}}</b>, representada por
                 su <b>{{$contrato->nombreDelCargoPJ}}, </b><b>{{$contrato->getNombreCompleto()}},</b> identificado con DNI
                <b>{{$contrato->dni}}</b>, 
            
            @endif 
            a quien en adelante se le denominará <b>{{$contrato->getLocadore()}};</b> bajo las cláusulas siguientes:
            


        </p>
        <p>
            <u>
                <b>
                    PRIMERO</b></u></p>
        <p style="text-align: justify;">

            El Centro Ecuménico de Promoción y Acción Social Norte - CEDEPAS Norte, es una asociación civil de derecho
            privado. CEDEPAS Norte se dedica a “Fortalecer las capacidades de varones y mujeres: líderes de sociedad civil,
            pequeños y medianos productores emprendedores, funcionarios y autoridades de gobiernos regionales y
            locales, a través de: La consolidación de la gobernabilidad local, la institucionalidad democrática y el capital
            social. La gestión sostenible de los recursos naturales y el ambiente, con énfasis en el agua. El desarrollo de
            iniciativas sostenibles y rentables de sectores económicos que dinamicen la macro región norte del Perú”.
            Acorde con su objeto social, CEDEPAS Norte ejecuta proyectos en diferentes zonas del Perú.
            <br>
            <br>
            @if($contrato->esDeCedepas())
                EL CEDEPAS Norte tiene la calificación de CITE Agropecuario, el mismo que tiene como objetivo: “Fortalecer
                capacidades de innovación tecnológica, gestión organizacional y comercial de las empresas asociativas y
                MIPYMEs del sector agroindustrial; contribuyendo a mejorar la calidad del empleo y los ingresos económicos;
                como resultado del incremento de la competitividad con enfoque inclusivo en las líneas de negocio: frutales,
                productos derivados pecuarios y hortalizas”.


            @else {{-- GPC --}}
                CEDEPAS Norte forma parte del Grupo Propuesta Ciudadana - GPC; consorcio integrado por 10 organizaciones no
                gubernamentales,  con presencia en 16 regiones del país que contribuye con la formulación de propuestas
                de política para una reforma inclusiva del Estado y una adecuada gestión de los recursos públicos. 
                Además, promueve y apoya el fortalecimiento de diversos mecanismos de asociación nacional e interregional entre actores 
                de la sociedad civil, las sub instancias del Estado y de las organizaciones que forman parte de él. 
                GPC reconoce la importancia del desarrollo y la democracia desde los territorios, ya que solo así será posible
                retomar el impulso del proceso de descentralización. Por ello, viene construyendo una visión propia de la
                Gobernanza Territorial, partiendo de identificar y respetar las diversidades y particularidades de los actores 
                múltiples en los territorios para la promoción del desarrollo democrático como componente clave de la cohesión territorial.

                <br>
                <br>
                <i>
                    Con fecha 02 de octubre del 2017 el Grupo Propuesta Ciudadana - GPC y CEDEPAS Norte, celebraron un Convenio
                    para la Administración de Fondos generado por GPC, asumiendo CEDEPAS Norte la representación legal, 
                    laboral y tributaria para la ejecución de sus proyectos. En virtud del mismo, los consultores para
                    dicha ejecución, vienen siendo contratados directamente por CEDEPAS Norte.
                    
                </i>
                
            @endif
        

        </p>







        <p>
            <u>
                <b>
                    SEGUNDO
                </b>
            </u>
        </p>

        <p style="text-align: justify;">
            @if($contrato->esDeCedepas())
                En virtud a los lineamientos de su misión y para la consecución de los objetivos institucionales, LA COMITENTE: CEDEPAS Norte
            @else {{-- GPC --}}
                Según lo descrito en la clausula anterior, LA COMITENTE: CEDEPAS Norte, por encargo del Grupo Propuesta Ciudadana - GPC,
            @endif

            ejecutará el proyecto "{{$contrato->nombreProyecto}}" 
            financiado por {{$contrato->nombreFinanciera}}; por lo que
            conviene en solicitar los servicios de 
            <b>
                {{$contrato->getLocadore()}},
            </b>para
            <b>
                "{{$contrato->motivoContrato}}";
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
            <b>{{$contrato->getFechaInicioEscrita()}}</b> 
            al 
            <b>{{$contrato->getFechaFinEscrita()}}.</b>
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
            Como contraprestación por sus servicios, LA COMITENTE: CEDEPAS Norte abonará a 
            <b>
                {{$contrato->getLocadore()}}
            </b> 
            una retribución total de
            {{$contrato->getMoneda()->simbolo}} {{number_format($contrato->retribucionTotal,2)}} 
            ,que incluye todo concepto de pago, la misma que estará sujeta a
            descuentos y retenciones de acuerdo a la ley y se cancelará previa presentación de 
            @if($contrato->esDeNatural())
              recibo por honorarios
            @else
              factura
            @endif 
            de acuerdo al siguiente detalle:
        </p>
        <p>
            @foreach($contrato->getAvances() as $i => $itemavance)
                <b>
                    {{chr($i+97)}})
                </b> 
                A la presentación del Producto N°{{$i+1}}: "{{$itemavance->descripcion}}" al {{$itemavance->getFechaEntregaEscrita()}};
                el importe de 
                {{$contrato->getMoneda()->simbolo}} {{number_format($itemavance->monto,2)}} 
                correspondiente al {{$itemavance->porcentaje}} %.
                
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
                {{$contrato->getLocadore()}}
            </b>
            no está sujeto a subordinación o dependencia alguna frente a 
            <b>LA COMITENTE: CEDEPAS Norte,</b> en tal sentido, tiene plena libertad en el ejercicio de sus servicios profesionales.
            
            <br>
            Por tratarse de LOCACIÓN DE SERVICIOS, 
            <b>
                {{$contrato->getLocadore()}} NO
            </b>
            tiene relación alguna de dependencia laboral
            con LA COMITENTE: CEDEPAS Norte, en consecuencia, este contrato no otorga derecho de vacaciones, compensación por
            tiempo de servicios, ni otros beneficios sociales. 
            <b>
                {{$contrato->getLocadore()}} NO
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
            <b>{{$contrato->getLocadore()}}</b>, se obliga por el presente contrato a prestar sus servicios descritos en la cláusula segunda del
            mismo, con eficiencia, esmero y lealtad. 
            <b>
                LA COMITENTE: CEDEPAS Norte,
            </b> es propietario de toda información que se obtenga o
            elabore durante la vigencia del presente contrato. Así mismo se obliga a mantener confidencialidad y reserva
            durante y después de la vigencia del presente contrato, respecto de las informaciones que le sean
            proporcionadas para el desarrollo de la consultoría. En ese sentido 
            <b>
                {{$contrato->getLocadore()}}
            </b> 
            no deberá usar, divulgar, reproducir, compartir, aprovechar y/o trasladar a terceros cualquier documento, proyecto, método, conocimiento y 
            otros que durante la prestación de sus servicios haya tenido acceso, le hayan proporcionado o haya llegado a su poder.
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
                {{$contrato->getLocadore()}}
            </b>
            , está obligado a contar con un seguro de salud vigente durante la vigencia del contrato,
            precisando que 
            <b>
                LA COMITENTE: CEDEPAS Norte
            </b> 
            no cubrirá gastos de curación por accidentes ni enfermedades que pudieran producirse durante la prestación del servicio.
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
            
            En lo no previsto por las partes en el presente contrato, ambas se someten a lo establecido por las normas del código 
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
            <b>
                {{$contrato->getSede()->nombre}}, {{$contrato->getFechaGeneracionEscrita()}}.
            </b>
        </p>


        

        
        <table  style="width: 100%; text-align:center; margin-top:80pt">
            <tbody>
                <tr>
                    <td>
                        <b>
                            _____________________________<br>
                            ANA CECILIA ANGULO ALVA<br>
                            DNI: 26682689<br>
                            LA COMITENTE: CEDEPAS Norte
                        </b>
                    </td>
                    <td>
                        <b>
                            _____________________________<br>
                            {{strtoupper($contrato->getNombreCompleto())}}<br>
                            DNI: {{$contrato->dni}}<br>
                            {{$contrato->getLocadore()}}
                        </b>
                    </td>
                </tr>
            </tbody>
        </table>





    </div>



    
    



</body>

</html>