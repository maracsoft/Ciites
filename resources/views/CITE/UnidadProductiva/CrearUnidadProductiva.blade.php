@extends('Layout.Plantilla')

@section('titulo')
  Registrar Unidad Productiva
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div >
    <p class="h2" style="text-align: center">
        Registrar Unidad Productiva
    </p>
</div>


<form method = "POST" action = "{{route('CITE.UnidadesProductivas.Guardar')}}" id="frmrepo" name="frmrepo"  enctype="multipart/form-data">

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
            </div>
        </div>
        <div class="card-body">


            <div class="row">
                <div class="col-md"> {{-- COLUMNA IZQUIERDA 1 --}}

                    <div class="row  internalPadding-1 mx-2">
                        <div class="col-sm-2">
                            <label for="codTipoPersoneria" id="lvlProyecto" class="">
                                T.P:
                            </label>
                        </div>
                        <div class="col-sm-10">
                            <select class="form-control"  id="codTipoPersoneria" name="codTipoPersoneria">
                                <option value="-1">-- Tipo Personeria --</option>
                                @foreach($listaTipoPersoneria as $tipoPersoneria)
                                    <option value="{{$tipoPersoneria->getId()}}">
                                        {{$tipoPersoneria->nombre}}
                                    </option>

                                @endforeach

                            </select>
                        </div>



                        <div  class="col-sm-2">
                            <label for="codTipoPersoneria" id="lvlProyecto" class="">
                                Documento:
                            </label>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control"  id="codEstadoDocumento" name="codEstadoDocumento"
                                    onchange="actualizarEstadoDocumento(this.value)">
                                @foreach($listaEstadosUnidad as $estadoUnidad)
                                    <option value="{{$estadoUnidad->getId()}}">
                                        {{$estadoUnidad->nombre}}
                                    </option>

                                @endforeach

                            </select>
                        </div>
                        <div  class="col-sm-2">

                            <input type="checkbox" value="1" id="tieneCadena" name="tieneCadena" checked onclick="actualizarTieneCadena(this.checked)">
                            <label class="" for="tieneCadena">
                                Tiene Cadena:
                            </label>

                        </div>
                        <div class="col-sm-4">
                            <select class="form-control"  id="codCadena" name="codCadena">
                                <option value="-1">- Cadena -</option>
                                @foreach($listaCadenas as $cadena)
                                    <option value="{{$cadena->getId()}}">
                                        {{$cadena->nombre}}
                                    </option>
                                @endforeach
                            </select>
                        </div>




                        <div class="col-12 row hidden" id="divRUC">


                            <div  class="col-sm-2">
                                <label for="" id="">RUC:
                                    <b id="contadorRUC" style="color: rgba(0, 0, 0, 0.548)"></b>

                                </label>
                            </div>
                            <div class="col-sm-4">

                                <div class="d-flex flex-col">

                                    <input type="number" class="form-control" name="ruc" id="ruc" value="">

                                    <div class="d-flex mr-auto">
                                        <button type="button" title="Buscar por RUC en la base de datos de Sunat"
                                        class="btn-sm btn btn-info d-flex align-items-center" id="botonBuscarPorRUC" onclick="consultarPorRuc()" >
                                            <i class="fas fa-search mr-1"></i>

                                        </button>

                                    </div>
                                </div>

                            </div>


                            <div  class="col-sm-2">
                                <label for="razonSocial" id="">Razón Social</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="razonSocial" id="razonSocial" value="">
                            </div>

                        </div>


                        <div class="col-12 row hidden" id="divDNI">

                            <div  class="col-sm-2">
                                <label for="dni" id="">DNI:
                                    <b id="contadordni" style="color: rgba(0, 0, 0, 0.548)"></b>

                                </label>
                            </div>

                            <div class="col-sm-4">

                                <div class="d-flex flex-col">

                                        <input type="number" class="form-control" name="dni" id="dni" value="">

                                    <div class="d-flex mr-auto">
                                        <button type="button" title="Buscar por DNI en la base de datos de Sunat"
                                        class="btn-sm btn btn-info d-flex align-items-center" id="botonBuscarPorRUC" onclick="consultarPorDNI()" >
                                            <i class="fas fa-search mr-1"></i>

                                        </button>

                                    </div>
                                </div>

                            </div>


                            <div  class="col-sm-2">
                                <label for="" id="">Nombre persona:</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nombrePersona" id="nombrePersona" value="">
                            </div>

                        </div>


                        <div class="col-sm-6">
                            <div class="form-check">
                                <input style="" class="form-check-input" type="checkbox" value="1" id="enTramite" name="enTramite" onclick="actualizarDocumentoTramite(this)">
                                <label class="form-check-label" for="enTramite">
                                    Documento En trámite
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6"></div>
                        <div  class="col-sm-2 d-none">
                            <label for="" id="">Rango ventas:</label>
                        </div>
                        <div class="col-sm-4 d-none">
                            <select class="form-control"  id="codClasificacion" name="codClasificacion"   >
                                <option value="-1">-- Clasificación  --</option>
                                @foreach($listaRangos as $rango)
                                    <option value="{{$rango->getId()}}" selected>
                                        {{$rango->nombre}} [{{$rango->minimo}}-{{$rango->maximo}}]
                                    </option>
                                @endforeach

                            </select>
                        </div>



                        <div  class="col-sm-2">
                            <label for="" id="">Dirección:</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="direccion" id="direccion" value="">
                        </div>



                        {{App\ComponentRenderizer::LugarSelector('ComboBoxDistrito',-1)}}


                        <div class="col-sm-6" title="Activando esta opción, al editar los miembros de esta unidad productiva, se editarán también en la organización enlazada del PPM">
                           
                          <input class="cursor-pointer" type="checkbox" value="1" id="activar_enlace_ppm" name="activar_enlace_ppm" 
                             onclick="actualizarTieneEnlacePPM(this.checked)">
                          
                          <label class="ml-1 cursor-pointer" for="activar_enlace_ppm">
                              Activar enlace PPM:
                          </label>
                          
                          <div class="d-flex flex-row">
                            <select id="codOrganizacionEnlazadaPPM" name="codOrganizacionEnlazadaPPM" data-select2-id="1" tabindex="-1" onchange="changedOrganizacionEnlazada()"
                                class="fondoBlanco form-control select2 select2-hidden-accessible selectpicker"   aria-hidden="true"  data-live-search="true">
                                <option value="-1">
                                  - Organización PPM Enlazada -
                                </option>
                                @foreach($listaOrganizaciones as $org)
                                  <option value="{{$org->getId()}}">
                                    {{$org['razonYRUC']}}
                                  </option>
                                @endforeach
                            </select>
                            <button id="boton_ir_organizacion" type="button" class="ml-1 btn btn-primary hidden" title="Ir a la Organización enlazada " onclick="clickIrAOrganizacionEnlazada()">
                              <i class="fas fa-eye"></i>
                            </button>
                          </div>
        
                        </div>
        




                    </div>


                </div>


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

            <button type="button" class="btn btn-primary" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando"
                onclick="registrar()">
                <i class='fas fa-save'></i>
                Guardar
            </button>

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
     
        var codPresupProyecto = -1;

        var ListaOrganizaciones = @json($listaOrganizaciones); 

        var listaTipoPersoneria = @php echo $listaTipoPersoneria; @endphp;
        var tipoPersoneriaSeleccionada = {};


        $(document).ready(function(){
            
            mostrarDivRUC();
            actualizarEstadoDocumento(1);
            
            /* Para darle tiempo al navegador que renderice el Select2 de bootstrap */
            setTimeout(() => {
              actualizarTieneEnlacePPM(false);
              $(".loader").fadeOut("slow");
            }, 500);
        });

        function registrar(){
            msje = validarForm();
            if(msje!="")
                {
                    alerta(msje);
                    return false;
                }

            confirmar('¿Está seguro de registrar la Unidad Productiva?','info','frmrepo');

        }





    </script>

    @include('CITE.UnidadProductiva.UnidadProductivaJS')

@endsection
