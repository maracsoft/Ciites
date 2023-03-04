<!DOCTYPE html>
<html lang="es" >
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
                    CONTRATO DE TRABAJO SUJETO A MODALIDAD
                </b>
            </u>
        </p>
        <p style="text-align: justify;">




            Conste por el presente documento el CONTRATO SUJETO A MODALIDAD ,que celebran de una parte el Centro
            Ecuménico de Promoción y Acción Social Norte - CEDEPAS Norte, con domicilio legal en Calle Los Corales N° 289
            Urb. Santa Inés de la ciudad de Trujillo, con RUC N° 20481234574, representado por su Directora General,
            ANA CECILIA ANGULO ALVA, identificada con DNI. N° 26682689, a quien en adelante se le denominará 
            <b>EL EMPLEADOR</b>; y de la otra parte
            <b>{{$contrato->getNombreCompleto()}}</b>, identificado con DNI N° 
            <b>{{$contrato->dni}}</b>, con domicilio legal en 
            <b>{{$contrato->direccion}}</b> provincia de <b>{{$contrato->provinciaYDepartamento}}</b>, a quien en adelante se le denominará 
            <b>{{$contrato->getTrabajadore()}}</b>; bajo las cláusulas siguientes:
        </p>
        <p>
            <u>
                <b>
                    PRIMERO
                </b>
            </u>
        </p>

        <p style="text-align: justify;">
            <b>
                EL EMPLEADOR
            </b> 
            se dedica a “Fortalecer las capacidades de varones y mujeres: líderes de sociedad civil,
            pequeños y medianos productores emprendedores, funcionarios y autoridades de gobiernos regionales y
            locales, a través de: La consolidación de la gobernabilidad local, la institucionalidad democrática y el capital
            social. La gestión sostenible de los recursos naturales y el ambiente, con énfasis en el agua. El desarrollo de
            iniciativas sostenibles y rentables de sectores económicos que dinamicen la macro región norte del Perú”.
            Acorde con su objeto social, CEDEPAS Norte ejecuta proyectos en diferentes zonas de acción.
            
            <br>
            <br>
            @if($contrato->esDeCedepas())
                
                EL CEDEPAS Norte tiene la calificación de CITE Agropecuario, el mismo que tiene como objetivo: “Fortalecer
                capacidades de innovación tecnológica, gestión organizacional y comercial de las empresas asociativas y
                MIPYMEs del sector agroindustrial; contribuyendo a mejorar la calidad del empleo y los ingresos económicos;
                como resultado del incremento de la competitividad con enfoque inclusivo en las líneas de negocio: frutales,
                productos derivados pecuarios y hortalizas”.



            @else
                CEDEPAS Norte forma parte del Grupo Propuesta Ciudadana - GPC; consorcio integrado por 10 organizaciones no 
                gubernamentales,  con presencia en 16 regiones del país que contribuye con la formulación de propuestas de política
                para una reforma inclusiva del Estado y una adecuada gestión de los recursos públicos. Además, promueve y apoya el
                fortalecimiento de diversos mecanismos de asociación nacional e interregional entre actores de la sociedad civil,
                las sub instancias del Estado y de las organizaciones que forman parte de él. GPC reconoce la importancia del desarrollo
                y la democracia desde los territorios, ya que solo así será posible retomar el impulso del proceso de descentralización. 
                Por ello, viene construyendo una visión propia de la Gobernanza Territorial, partiendo de identificar y respetar las
                diversidades y particularidades de los actores múltiples en los territorios para la promoción del desarrollo democrático como componente
                clave de la cohesión territorial.
                <br><br>
                <i>
                    Con fecha 02 de octubre del 2017 el Grupo Propuesta Ciudadana - GPC y CEDEPAS Norte, celebraron un Convenio para la Administración
                    de Fondos generado por GPC, asumiendo CEDEPAS Norte la representación legal, laboral y tributaria para la ejecución
                    de sus proyectos. En virtud del mismo, el personal para dicha ejecución, viene siendo contratado directamente por CEDEPAS Norte, con
                    dedicación exclusiva a los proyectos de GPC, no constituyendo personal del staff de CEDEPAS Norte, sino de la 
                    entidad patrocinada: Grupo Propuesta Ciudadana - GPC.
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
            Para el cumplimiento de su objeto social, 
            <b>
                EL EMPLEADOR
            </b> 
            ha obtenido financiamiento de 
            <b>{{$contrato->nombreFinanciera}}</b> 
            para implementar el proyecto denominado: 
            <b>“{{$contrato->nombreProyecto}}”.</b> En virtud del mismo, 
            <b>
                EL EMPLEADOR
            </b>contrata a 
            <b>{{$contrato->getTrabajadore()}}</b>, para desempeñar el cargo de 
            <b>{{$contrato->nombrePuesto}}</b>
            dentro del proyecto. 
            <b>
                {{$contrato->getTrabajadore()}}</b> se obliga a cumplir con las actividades descritas en los Términos de Referencia que dieron origen a su
            contratación, el cual forma parte del presente contrato. La descripción de las tareas y funciones es simplemente
            enunciativa y no limitativa. 
            <b>EL EMPLEADOR</b> puede disponer que 
            <b>{{$contrato->getTrabajadore()}}</b> realice cualquier función
            siempre que sea análoga o similar a las descritas para la ejecución del proyecto en mención.
        </p>







        <p>
            <u>
                <b>
                    TERCERO
                </b>
            </u>
        </p>
        <p style="text-align: justify;">
            El presente Contrato se celebra a plazo determinado, el mismo que se inicia el 
            <b>{{$contrato->getFechaInicioEscrita()}}</b>
            
            @if($contrato->fechaFin!=null)
                y concluye el <b>{{$contrato->getFechaFinEscrita()}}.</b>
            @else
                y sin conclusion definida.
            @endif En todo caso, el Contrato se entenderá concluido en la fecha de su vencimiento, sin
            necesidad de comunicación alguna a 
            <b>
                {{$contrato->getTrabajadore()}}
            </b> por parte de 
            <b>
                EL EMPLEADOR.
            </b>El Contrato se celebra al amparo de artículo 63º del Decreto Supremo 003-97–TR- Ley de Productividad y Competitividad Laboral, bajo la
            modalidad de “Contrato para Obra y Servicio” y la submodalidad de “Contrato para Servicio Específico”,
            teniendo en cuenta el carácter temporal de las labores a realizar por 
            <b>
                {{$contrato->getTrabajadore()}}</b>, para encargarse de las labores descritas en razón de las causas objetivas que en ella se precisan.
        </p>






        <p>
            <u>
                <b>
                    CUARTO
                </b>
            </u>
        </p>
        <p style="text-align: justify;">
            <b>
                {{$contrato->getTrabajadore()}}
            </b> 
            percibirá como contraprestación por sus labores una remuneración mensual bruta equivalente a 
            <b>
                {{$contrato->getMoneda()->simbolo}} {{number_format($contrato->sueldoBruto,2)}}

                ({{$contrato->getSueldoBrutoEscrito()}}),
            </b>más
            @if($contrato->tieneAsignacionFamiliar())
                la asignación familiar equivalente a S/ 102.50 (Ciento Dos con 50/100 Soles), y
            @endif

            los aumentos de Ley y aquellos otros que voluntaria y unilateralmente decida 
            <b>
                EL EMPLEADOR.
            </b>
            
        </p>










        <p>
            <u>
                <b>
                    QUINTO
                </b>
            </u>
        </p>
        <p style="text-align: justify;">

             <b>
                 {{$contrato->getTrabajadore()}}
             </b>
             @if($contrato->esContratoNormal())
                se encuentra obligado a cumplir con una jornada de cuarenta (40) horas semanales en la sede
                asignada, de lunes a viernes, de acuerdo al horario que establezca
                <b>
                    EL EMPLEADOR,</b> 
                    el mismo que eventualmente incluye el desplazamiento a las zonas de los proyectos que ejecute
                <b>
                    EL EMPLEADOR.
                </b>
             @else {{-- ESPECIAL --}}
                se obliga a cumplir el horario que establezca
                <b>
                    EL EMPLEADOR,
                </b>
                
                el mismo que se precisa en los Términos de Referencia Adjuntos que forman parte del presente contrato.
             @endif



             <br>
            En razón de la naturaleza de sus obligaciones, 
            <b>EL EMPLEADOR</b> reconoce que 
            <b>
                {{$contrato->getTrabajadore()}}
            </b> 
            desempeñará sus labores parcialmente fuera del centro de trabajo, no encontrándose sujeto a fiscalización inmediata, ni
            obligado a registrarse en el Registro de Control de Asistencia.
        </p>





        <p>
            <u>
                <b>
                    SEXTO
                </b>
            </u>
        </p>
        <p style="text-align: justify;">
            <b>{{$contrato->getTrabajadore()}}</b> 
            y 
            <b>EL EMPLEADOR</b>, pactan las siguientes condiciones especiales, que regularán la ejecución del presente contrato: 
            <br>


            <b>
                a) {{$contrato->getTrabajadore()}}
            </b> se compromete a cumplir los reglamentos internos, normas y procedimientos establecidos por 
            <b>EL EMPLEADOR,</b> así como el Código de Ética que forma parte del presente contrato. 
            <br>

            <b>
                b) {{$contrato->getTrabajadore()}}
            </b> 
            se compromete a no brindar servicios similares a los contratados por 
            <b>
                EL EMPLEADOR
            </b>
            a terceras personas, sin autorización expresa de 
            <b>EL EMPLEADOR.</b> 
            <br>

            <b>
                c) EL EMPLEADOR
            </b> 
            tendrá la titularidad de los derechos de autor de todos los reportes, propuestas,
            compilaciones, sistematizaciones, investigaciones, materiales educativos e información que se obtenga o
            elabore en virtud de la ejecución del presente contrato. 
            <b>
                EL EMPLEADOR
            </b> 
            reconocerá la autoría y derechos morales de 
            <b>
                {{$contrato->getTrabajadore()}}
            </b> 
            en todo trabajo o investigación donde haya participado 
            <b>
                {{$contrato->getTrabajadore()}}.
            </b>
            <br>
            
            
            <b>
                d) {{$contrato->getTrabajadore()}},
            </b>se compromete a guardar confidencialidad y reserva de la información a la que acceda en virtud del presente contrato. 
            <br>

            <b>
                e) {{$contrato->getTrabajadore()}}
            </b> no podrá ofrecer o brindar declaraciones a los medios de comunicación sobre
            asuntos institucionales, sin la autorización expresa de 
            <b>
                EL EMPLEADOR.
            </b>
            <br>
            
            <b>
                f) {{$contrato->getTrabajadore()}}
            </b> 
            se compromete a realizar los exámenes médicos que resulten necesarios para
            verificar su buen estado de salud, de conformidad con el inciso c) del artículo 23º del Decreto Supremo
            003-97-TR, que aprueba el Texto Único Ordenado de la Ley de Productividad y Competitividad Laboral. 
            <br>

            <b>
                g) {{$contrato->getTrabajadore()}}
            </b>
            se compromete a no establecer relaciones personales de negocios o profesionales
            con las instituciones, organizaciones sociales y beneficiarios, relacionadas con los programas a su cargo. 
            <br>
            
            <b>
                h) {{$contrato->getTrabajadore()}}
            </b> 
            se compromete a proporcionar información fidedigna y oportuna sobre las
            actividades realizadas, resultados obtenidos y recursos utilizados en el desempeño de su cargo. 
            <br>

            <b>
                i) EL EMPLEADOR
            </b> 
            reconoce la vigencia del principio de igualdad de trato y no discriminación por razón del
            género, y declara que los trabajadores de uno u otro sexo en las Organizaciones No Gubernamentales
            tienen los mismos derechos y obligaciones. 
            
            <br>
            <b>
                j) EL EMPLEADOR
            </b> 
            declara que la presente relación contractual se formaliza dentro de un marco contrario
            a toda practica de corrupción y se inspira en el enfoque de integridad, contenido en la Política Nacional de
            Integridad y Lucha contra la Corrupción, aprobado mediante Decreto Supremo N 092-2017-PCM. En tal
            sentido
            <b>{{$contrato->getTrabajadore()}}</b> se compromete a cumplir las políticas y normas institucionales para la
            transparencia y administración de los recursos a su cargo. 
            <br>
            <b>
                k) EL EMPLEADOR
            </b> 
            declara que las prácticas de contratación empleadas se encuentran alineadas al
            enfoque de protección y salvaguarda de los niños, niñas y adolescentes, siendo contrarios a toda forma
            de trabajo y explotación infantil o posición de dominio sobre los derechos de los jóvenes.
        </p>




        <p>
            <u>
                <b>
                    SEPTIMO
                </b>
            </u>
        </p>
        <p style="text-align: justify;">
            El presente contrato puede ser modificado por acuerdo de las partes y le son aplicables las normas
            fundamentales en materia de trabajo, seguridad y salud en el trabajo, y seguridad social establecidas en el Perú
            para todos los trabajadores del régimen laboral de la actividad privada.
        </p>






        <p>
            <u>
                <b>
                    OCTAVO
                </b>
            </u>
        </p>
        <p style="text-align: justify;">
            En caso de alguna diferencia sobre cualquier aspecto derivado o vinculado a la ejecución del presente contrato
            las partes buscarán y propiciarán una solución conciliada y directa, en su defecto expresamente se someten a
            las autoridades de la Corte Superior de Justicia de Trujillo.
            <br>
            Se firma en la ciudad de <b>{{$contrato->getSede()->nombre}}</b> el <b>{{$contrato->getFechaGeneracionEscrita()}}</b>.
        </p>


        

        <table id="TablaFirmas" style="width: 100%; text-align:center; margin-top:90pt; font-size:11pt;">
            <tbody>
                <tr>
                    <td>
                        <b>
                            _______________________________<br>
                            ANA CECILIA ANGULO ALVA<br>
                            DNI: 26682689<br>
                            DIRECTORA GENERAL
                        </b>
                    </td>
                    <td>
                        <b>
                            _______________________________<br>
                            {{strtoupper($contrato->getNombreCompleto())}}<br>
                            DNI: {{$contrato->dni}}<br>
                            {{$contrato->getTrabajadore()}}
                        </b>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


   

    <div class="page_break"></div>


    <div class="contenidoContrato">
         @include('Contratos.PlazoFijo.pdfCodigoEtica')
    </div>

</body>
<style>
    .page_break { 
        page-break-before: always; 
    }


</style>
</html>