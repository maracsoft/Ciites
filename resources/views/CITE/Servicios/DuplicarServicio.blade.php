@extends('Layout.Plantilla')

@section('titulo')
  Crear servicio en base a otro
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection
{{--
  Funcionalidad a pedido del cliente,
  la idea es que se entre a esta vista con un serviciio plantilla para no tener que setear todo desde cero
  Realmente es como si se estuviera creando un nuevo servicio desde 0

  Solo se copian los datos de informacion general
  No se copia la lista de asistencia

  La ruta de guardado es la misma de cuando se crea uno nuevo de 0 normalmente
  --}}
@section('contenido')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div class="col-12 py-2">
  <div class="page-title">
    Crear servicio en base a otro
  </div>
</div>

@include('Layout.MensajeEmergenteDatos')
<form method = "POST" action = "{{route('CITE.Servicios.Guardar')}}" id="frmServicio" name="frmServicio"  enctype="multipart/form-data">
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

            <div class="row internalPadding-1  ">
                <div class="col-sm-6">
                    <label for="codUnidadProductiva" id="" class="">
                        Unidad Productiva:
                    </label>

                    <select id="codUnidadProductiva" name="codUnidadProductiva" data-select2-id="1" tabindex="-1"
                        class="fondoBlanco form-control select2 select2-hidden-accessible selectpicker"   aria-hidden="true"  data-live-search="true">


                        <option value="-1">-- Unidad Productiva y RUC --</option>
                        @foreach($listaUnidadesProductivas as $unidadProductiva)
                            <option value="{{$unidadProductiva->getId()}}"
                                @if($unidadProductiva->getId() == $servicio->codUnidadProductiva)
                                    selected
                                @endif
                                >
                                {{$unidadProductiva->getDenominacion()}} {{$unidadProductiva->getRucODNI()}}
                            </option>
                        @endforeach

                    </select>
                </div>



                <div class="col-sm-6">
                  <label for="codTipoAcceso" id="" class="">
                      Tipo Acceso:
                  </label>

                  <select class="form-control"  id="codTipoAcceso" name="codTipoAcceso" onchange="actualizarTipoAcceso(this.value)">
                      <option value="-1">-- Tipo Acceso --</option>
                      @foreach($listaTipoAcceso as $tipoAcceso)
                          <option value="{{$tipoAcceso->getId()}}"
                              @if($tipoAcceso->getId() == $servicio->codTipoAcceso)
                                  selected
                              @endif
                              >
                              {{$tipoAcceso->nombre}}
                          </option>
                      @endforeach

                  </select>
                </div>

                <div class="col-sm-12 row fondoPlomoCircular p-3 my-1 hidden" id="divConvenio">

                    <div class="col-sm-2">
                        <label for="descripcion" id="" class="">
                            Comprobante:
                        </label>
                        <select class="form-control"  id="codTipoCDP" name="codTipoCDP"  >
                            <option value="">- Tipo Comprobante -</option>
                            @foreach($listaTipoCDP as $cdp)
                                <option value="{{$cdp->getId()}}"
                                    @if($cdp->getId() == $servicio->codTipoCDP)
                                        selected
                                    @endif
                                    >
                                    {{$cdp->nombreCDP}}
                                </option>
                            @endforeach
                        </select>


                    </div>
                    <div class="col-sm-4">
                        <label for="descripcion" id="" class="">
                            Nro comprobante:
                        </label>

                        <input type="text" class="form-control" id="nroComprobante" name="nroComprobante"  value="{{$servicio->nroComprobante}}"/>

                    </div>
                    <div  class="col-sm-2">
                        <label for="descripcion" id="" class="">
                            Base imponible:
                        </label>

                        <input type="number" class="form-control" id="baseImponible" name="baseImponible"  value="{{$servicio->baseImponible}}" onchange="cambioBaseImponible()"/>

                    </div>
                    <div  class="col-sm-2">
                        <label for="descripcion" id="" class="">
                            IGV:
                        </label>

                        <input type="number" class="form-control" id="igv" name="igv"  value="{{$servicio->igv}}"  readonly/>

                    </div>
                    <div  class="col-sm-2">
                        <label for="descripcion" id="" class="">
                            Total:
                        </label>

                        <input type="number" class="form-control" id="total" name="total"  value="{{$servicio->total}}"  onchange="cambioTotal()"/>

                    </div>
                </div>

                <div class="col-sm-2">
                    <label for="descripcion" id="" class="">
                        Cantidad Servicios:
                    </label>

                    <input type="number" class="form-control" id="cantidadServicio" name="cantidadServicio" value="{{$servicio->cantidadServicio}}"/>

                </div>

               

                <div class="col-sm-2">
                    <label for="descripcion" id="" class="">
                        Nro Horas efectivas:
                    </label>

                    <input type="number" class="form-control" id="nroHorasEfectivas" name="nroHorasEfectivas" value="{{$servicio->nroHorasEfectivas}}"/>
                </div>

                <div class="col-sm-8">
                    <label for="descripcion" id="" class="">
                        Descripción:
                    </label>

                    <textarea class="form-control" id="descripcion" name="descripcion" rows="1"
                    >{{$servicio->descripcion}}</textarea>

                </div>


                
                <div class="col-12 col-sm-3">
                  <label for="codModalidad" id="" class="">
                      Modalidad:
                  </label>

                  <select class="form-control"  id="codModalidad" name="codModalidad">
                      <option value="-1">-- Modalidad --</option>
                      @foreach($listaModalidades as $modalidad)
                          <option value="{{$modalidad->getId()}}"
                              @if($modalidad->getId() == $servicio->codModalidad)
                                  selected
                              @endif

                              >
                              {{$modalidad->nombre}}
                          </option>
                      @endforeach

                  </select>
                </div>

                <div class="col-sm-3">
                    <label for="codTipoServicio" id="" class="">
                        Tipo Servicio:
                    </label>

                    <select class="form-control"  id="codTipoServicio" name="codTipoServicio" onchange="actualizarTipo(this.value)">
                        <option value="-1">-- Tipo Servicio --</option>
                        @foreach($listaTipoServicio as $tipoServ)
                            <option value="{{$tipoServ->getId()}}"
                                @if($tipoServ->getId() == $servicio->codTipoServicio)
                                    selected
                                @endif

                                >
                                {{$tipoServ->nombre}}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-sm-6">
                    <label for="codActividad" id="" class="">
                        Actividad :
                    </label>
                    <select class="form-control"  id="codActividad" name="codActividad">
                        <option value="-1">-- Actividad --</option>
                        @foreach($servicio->getTipoServicio()->getActividades() as $actividad)
                            <option value="{{$actividad->getId()}}"
                                @if($actividad->getId() == $servicio->codActividad)
                                    selected
                                @endif
                                >
                                {{$actividad->getTexto()}}
                            </option>
                        @endforeach
                    </select>
                </div>


 

                <div class="col-sm-2"></div>

                <div class="col-sm-4">
                    <label for="">Fecha Inicio:</label>

                    <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                        {{-- INPUT PARA LA FECHA --}}
                        <input type="text" style="text-align: center" class="form-control" name="fechaInicio" id="fechaInicio"
                                value="{{$servicio->getFechaInicio()}}" style="font-size: 10pt;">

                        <div class="input-group-btn">
                            <button class="btn btn-primary date-set btn-sm" type="button" style="display: none">
                                <i class="fas fa-calendar fa-xs"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="col-sm-4">
                    <label for="">Fecha Fin:</label>

                    <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                        {{-- INPUT PARA  FECHA --}}
                        <input type="text" style="text-align: center" class="form-control" name="fechaTermino" id="fechaTermino"
                                value="{{$servicio->getFechaTermino()}}" style="font-size: 10pt;" >
                        <div class="input-group-btn">
                            <button class="btn btn-primary date-set btn-sm" type="button" style="display: none">
                                <i class="fas fa-calendar fa-xs"></i>
                            </button>
                        </div>
                    </div>

                </div>
                <div class="col-sm-2"></div>



                {{App\ComponentRenderizer::LugarSelector('ComboBoxDistrito',$servicio->codDistrito)}}



            </div>


            <div class="row">
                <div class="col-6"></div>
                <div class="col-6 row">
                    <div class="ml-auto">

                        <button type="button" class="btn btn-primary" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando"
                            onclick="registrar()">
                            <i class='fas fa-save'></i>
                            Guardar
                        </button>

                    </div>
                </div>

            </div>


        </div>
    </div>
</form>




    <div class="d-flex flex-row m-4">
        <div class="">

            <a href="{{route('CITE.Servicios.Listar')}}" class='btn btn-info '>
                <i class="fas fa-arrow-left"></i>
                Regresar al Menú
            </a>

        </div>
        <div class="ml-auto">


        </div>

    </div>





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


    $(document).ready(function(){
        $(".loader").fadeOut("slow");
        actualizarTipoAcceso({{$servicio->codTipoAcceso}})
        
    });


    /* FORMULARIO PRINCIPAL DE DATOS SERVICIO */
    function registrar(){
        msje = validarFormulario();
        if(msje!="")
            {
                alerta(msje);
                return false;
            }

        confirmar('¿Está seguro de crear el nuevo servicio?','info','frmServicio');

    }


</script>

@include('CITE.Servicios.ServicioJS')

@endsection
