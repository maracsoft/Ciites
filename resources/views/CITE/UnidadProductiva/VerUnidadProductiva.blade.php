@extends('Layout.Plantilla')

@section('titulo')
  Ver UnidadProductiva
@endsection

@section('tiempoEspera')
    <div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

<div >
    <p class="h2" style="text-align: center">
        Ver UnidadProductiva
    </p>
</div>

@include('Layout.MensajeEmergenteDatos')
<form method = "POST" action = "" id="frmrepo" name="frmrepo"  enctype="multipart/form-data">

    {{-- CODIGO DEL EMPLEADO --}}

    @csrf

    <div class="card mx-2">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <div class="d-flex flex-row">
                <div class="">
                    <h3 class="card-title">
                        {{--  <i class="fas fa-chart-pie"></i> --}}
                        <b>Información General</b>
                    </h3>

                </div>

                <div class="ml-1 mt-1">
                    <span class="fontSize10">
                        (Unidad productiva registrada el
                        <b>
                            {{$unidadProductiva->getFechaHoraCreacion()}}
                        </b>
                            por
                        <b>
                            {{$unidadProductiva->getEmpleadoCreador()->getNombreCompleto()}}</b>)
                    </span>
                </div>

            </div>
        </div>
        <div class="card-body">

            <div class="row  internalPadding-1 mx-2">
                <div  class="col-2 centerLabels">
                    <label  class="">
                        Tipo Personería:
                    </label>


                </div>
                <div class="col-10">
                    <input type="text" class="form-control" value="{{$unidadProductiva->getTipoPersoneria()->nombre}}" readonly>

                </div>


                <div  class="col-2">
                    <label for="codTipoPersoneria" id="lvlProyecto" class="">
                        Documento:
                    </label>
                </div>
                <div class="col-4">
                     <input type="text" class="form-control" value="{{$unidadProductiva->getEstadoDocumento()->nombre}}" readonly>
                </div>
                <div  class="col-2">
                    <label for="codCadena" class="">
                        Cadena:
                    </label>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" value="{{$unidadProductiva->getNombreCadena()}}" readonly>
                </div>

                @if($unidadProductiva->getEstadoDocumento()->nombre=="RUC")
                    <div  class="col-2  centerLabels">
                        <label >RUC:
                            <b id="contadorRUC" style="color: rgba(0, 0, 0, 0.548)"></b>

                        </label>
                    </div>
                    <div class="col-4">

                        <div class="d-flex flex-col">

                            <input type="text" class="form-control" value="{{$unidadProductiva->ruc}}" readonly>


                        </div>

                    </div>

                    <div  class="col-2  centerLabels">
                        <label for="razonSocial" id="">Razón Social</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" value="{{$unidadProductiva->razonSocial}}" readonly>

                    </div>

                @endif

                @if($unidadProductiva->getEstadoDocumento()->nombre=="DNI")
                    <div  class="col-2  centerLabels">
                        <label for="dni" id="">DNI:
                            <b id="contadordni" style="color: rgba(0, 0, 0, 0.548)"></b>

                        </label>
                    </div>

                    <div class="col-4">

                        <input type="text" class="form-control" value="{{$unidadProductiva->dni}}" readonly>


                    </div>


                    <div  class="col-2  centerLabels">
                        <label for="" id="">Nombre persona:</label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" value="{{$unidadProductiva->nombrePersona}}" readonly>

                    </div>
                @endif


                <div class="col-6">
                    <div class="form-check">
                        <input style="" class="form-check-input" type="checkbox" value="1"
                            id="enTramite" name="enTramite" onclick="return false;">
                        <label class="form-check-label" for="enTramite">
                            Documento En trámite
                        </label>
                    </div>
                </div>
                <div  class="col-2">
                    <label for="" id="">Rango ventas:</label>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" value="{{$unidadProductiva->getClasificacionRangoVentas()->nombre}}" readonly>

                </div>

                <div  class="col-2  centerLabels">
                    <label for="" id="">Dirección:</label>
                </div>
                <div class="col-10">
                    <input type="text" class="form-control" value="{{$unidadProductiva->direccion}}" readonly>

                </div>



                <div class="col-4">
                    <label for="">
                        Departamento:
                    </label>
                    <input type="text" class="form-control" value="{{$unidadProductiva->getNombreDepartamento()}}" readonly>
                </div>
                <div class="col-4">
                    <label for="">
                        Provincia:
                    </label>
                    <input type="text" class="form-control" value="{{$unidadProductiva->getNombreProvincia()}}"  readonly>
                </div>
                <div class="col-4">
                    <label for="">
                        Distrito:
                    </label>
                    <input type="text" class="form-control" value="{{$unidadProductiva->getNombreDistrito()}}" readonly>
                </div>

                <div class="col-12 text-right">

                </div>



            </div>

        </div>
    </div>

    <div class="card mx-2">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
               {{--  <i class="fas fa-chart-pie"></i> --}}
                <b>Servicios:</b>
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive mx-2">
                <label for="">
                    Lista de servicios:
                </label>
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'>



                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th>Id</th>
                        <th>Descripcion</th>
                        <th>Fechas</th>
                        <th>Cantidad</th>
                        <th>Lugar</th>
                        <th>Tipo acceso</th>
                        <th>Tipo Servicio</th>
                        <th>Modalidad</th>
                        <th>Opciones</th>

                    </thead>

                    <tbody>
                        @foreach($unidadProductiva->getServicios() as $servicio)
                            <tr>
                                <td>
                                    {{$servicio->getId()}}
                                </td>
                                <td>
                                    {{$servicio->descripcion}}
                                </td>

                                <td>
                                    {{$servicio->getFechaInicio()}} a {{$servicio->getFechaTermino()}}
                                </td>
                                <td>
                                    {{$servicio->cantidadServicio}}
                                </td>
                                <td>
                                    {{$servicio->getTextoLugar()}}
                                </td>
                                <td>
                                    {{$servicio->getTipoAcceso()->nombre}}
                                </td>
                                <td>
                                    {{$servicio->getTipoServicio()->nombre}}
                                </td>
                                <td>
                                    {{$servicio->getModalidad()->nombre}}
                                </td>

                                <td>
                                    <a href="{{route('CITE.Servicios.Ver',$servicio->getId())}}" class='btn btn-info btn-sm' title="Ver Servicio">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @if(count($unidadProductiva->getServicios() ) == 0)
                            <tr>
                                <td colspan="9" class="text-center">
                                    No hay servicios registrados
                                </td>
                            </tr>
                        @endif



                    </tbody>
                </table>
            </div>


        </div>
    </div>


    <div class="card mx-2">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
               {{--  <i class="fas fa-chart-pie"></i> --}}
                <b>Lista de socios:</b>
            </h3>
        </div>
        <div class="card-body">




            <div class="row m-2">





                <table class="table table-striped table-bordered table-condensed table-hover" >
                    <thead  class="thead-default">
                        <tr>
                            <th class="text-right">
                                DNI
                            </th>
                            <th class="text-left">
                                Nombre
                            </th>
                            <th class="text-right">
                                Teléfono
                            </th>
                            <th class="text-right">
                                Correo
                            </th>
                            <th>
                                Opciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unidadProductiva->getUsuariosAsociados() as $relaUsuarioAsociado )
                            @php
                                $usuario = $relaUsuarioAsociado->getUsuario();
                            @endphp
                            <tr>
                                <td class="text-right">
                                    {{$usuario->dni}}
                                </td>
                                <td class="text-left">
                                    {{$usuario->getNombreCompleto()}}
                                </td>
                                <td class="text-right">
                                    {{$usuario->telefono}}
                                </td>
                                <td class="text-right">
                                    {{$usuario->correo}}
                                </td>
                                <td class="text-center">
                                    <a href="{{route('CITE.Usuarios.Ver',$usuario->getId())}}" class='btn btn-info btn-sm' title="Ver Usuarios">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                </td>

                            </tr>
                        @endforeach
                        @if(count($unidadProductiva->getUsuariosAsociados()) == 0)
                            <tr>
                                <td class="text-center" colspan="5">
                                    No hay usuarios registrados
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>

            </div>



        </div>
    </div>

    <div class="d-flex flex-row m-4">
        <div class="">

            <a href="{{route('CITE.UnidadesProductivas.Listar')}}" class='btn btn-info '>
                <i class="fas fa-arrow-left"></i>
                Regresar al Menú
            </a>

        </div>
        <div class="ml-auto">

        </div>

    </div>





</form>


@endsection

{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

@include('Layout.EstilosPegados')
@include('Layout.ValidatorJS')
@section('script')

<script type="application/javascript">
    //se ejecuta cada vez que escogewmos un file
        var codPresupProyecto = -1;


        $(document).ready(function(){
            $(".loader").fadeOut("slow");

            //contadorCaracteres('ruc','contadorRUC',11);
            //contadorCaracteres('observacion','contadorObservacion',{{App\Configuracion::tamañoObservacionOC}});

        });

        function registrar(){
            msje = validarFormularioCrear();
            if(msje!="")
                {
                    alerta(msje);
                    return false;
                }

            confirmar('¿Está seguro de crear la orden de compra?','info','frmrepo');

        }

        function validarFormularioCrear(){
            msj='';
            limpiarEstilos(['codTipoPersoneria','ruc','razonSocial','dni','nombrePersona','direccion','codClasificacion',
                'ComboBoxDistrito']);


            msj = validarSelect(msj,'codTipoPersoneria',-1,'Tipo Personeria');
            msj = validarSelect(msj,'ComboBoxDistrito',-1,'Distrito');


            msj = validarTamañoExacto(msj,'ruc',11,'RUC');
            msj = validarTamañoExacto(msj,'dni',8,'DNI');

            msj = validarTamañoMaximoYNulidad(msj,'direccion',{{App\Configuracion::tamañoSeñoresOC}},'Dirección');
            msj = validarTamañoMaximoYNulidad(msj,'razonSocial',{{App\Configuracion::tamañoAtencionOC}},'Razón Social');
            msj = validarTamañoMaximoYNulidad(msj,'nombrePersona',200,'referencia');
            msj = validarTamañoMaximoYNulidad(msj,'codClasificacion',20,'Clasificación Rango de ventas');

            return msj;

        }

        function clickSelectDepartamento(){
            departamento = document.getElementById('ComboBoxDepartamento');
            ComboBoxProvincia =  document.getElementById('ComboBoxProvincia');
            ComboBoxDistrito =  document.getElementById('ComboBoxDistrito');
            console.log('el codigo del dep seleccionado es ='+departamento.value);

            $.get('/listarProvinciasDeDepartamento/'+departamento.value,
                function(data)
                {

                    cadenaHTML = `
                        <option value="-1" selected>
                            - Provincia -
                        </option>
                    `;
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];

                        cadenaHTML = cadenaHTML +
                        `
                        <option value="`+element.codProvincia+`">
                            `+ element.nombre +`
                        </option>
                        `;
                    }
                    ComboBoxProvincia.innerHTML = cadenaHTML;
                    ComboBoxDistrito.innerHTML =
                    `
                        <option value="-1" selected>
                            - Distrito -
                        </option>
                    `;
                }
            );

        }

        function clickSelectProvincia(){
            ComboBoxProvincia = document.getElementById('ComboBoxProvincia');
            ComboBoxDistrito =  document.getElementById('ComboBoxDistrito');
            console.log('el codigo de provincia seleccionada es ='+ComboBoxProvincia.value);

            $.get('/listarDistritosDeProvincia/'+ComboBoxProvincia.value,
                function(data)
                {

                    cadenaHTML = `
                        <option value="-1" selected>
                            - Distrito -
                        </option>
                    `;
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];

                        cadenaHTML = cadenaHTML +
                        `
                        <option value="`+element.codDistrito+`">
                            `+ element.nombre +`
                        </option>
                        `;
                    }
                    ComboBoxDistrito.innerHTML = cadenaHTML;
                }
            );

        }







    </script>



@endsection
@section('estilos')

<style>
     .centerLabels{
        display: flex!important;
     }

     .centerLabels > label{
         margin-bottom: auto;
         margin-top: auto;
     }


</style>
@endsection
