@extends('Layout.Plantilla')

@section('titulo')
  Editar Servicio
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')
@php
  $file_uploader = new App\UI\FileUploader("nombresArchivos","filenames",10,true,"Subir archivos");
  

@endphp
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div >
    <p class="h1" style="text-align: center">
        Editar Servicio
    </p>
</div>
<style>
  .pequeñaRow{
    padding:0px !important; 
    
  }

  .specialCB{
    width:20px;
    height: 20px;
  }

  .pequeñaRow label{
    font-weight: 400 !important;
    cursor:pointer 
  }

  .link-drive{
    background-color: rgb(236, 253, 255);
    padding: 15px 10px;
    font-size: 15pt;
  }
  .link-drive-img{
    width: 33px;
    height: 33px;

  }
  .link-drive-span{

  }

</style>
@include('Layout.MensajeEmergenteDatos')
<form method = "POST" action = "{{route('CITE.Servicios.Actualizar')}}" id="frmrepo" name="frmrepo"  enctype="multipart/form-data">
    <input type="hidden" name="codServicio" value="{{$servicio->getId()}}">

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
                        (Servicio registrado el
                        <b>
                            {{$servicio->getFechaHoraCreacion()}}
                        </b>
                            por
                        <b>
                            {{$servicio->getEmpleadoCreador()->getNombreCompleto()}}</b>)
                    </span>
                </div>

            </div>
        </div>
        <div class="card-body">

            <div class="row  internalPadding-1  ">
                <div  class="col-12 col-sm-6">
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







                <div class="col-12 col-sm-6">
                    <label for="codModalidad" id="" class="">
                        Modalidad:
                    </label>

                    <select class="form-control"  id="codModalidad" name="codModalidad"  onchange="actualizarModalidad(this.value)">
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


                <div class="col-12 row fondoPlomoCircular p-3 my-1 hidden" id="divConvenio">

                    <div  class="col-12 col-sm-2">
                        <label for="descripcion" id="" class="">
                            Comprobante:
                        </label>
                        <select class="form-control"  id="codTipoCDP" name="codTipoCDP"  >
                            <option value="-1">- Tipo Comprobante -</option>
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
                    <div  class="col-12 col-sm-4">
                        <label for="descripcion" id="" class="">
                            Nro comprobante:
                        </label>

                        <input type="text" class="form-control" id="nroComprobante" name="nroComprobante"  value="{{$servicio->nroComprobante}}"/>

                    </div>
                    <div  class="col-12 col-sm-2">
                        <label for="descripcion" id="" class="">
                            Base imponible:
                        </label>

                        <input type="number" class="form-control" id="baseImponible" name="baseImponible"  value="{{$servicio->baseImponible}}" onchange="cambioBaseImponible()"/>

                    </div>
                    <div  class="col-12 col-sm-2">
                        <label for="descripcion" id="" class="">
                            IGV:
                        </label>

                        <input type="number" class="form-control" id="igv" name="igv"  value="{{$servicio->igv}}"  readonly/>

                    </div>
                    <div  class="col-12 col-sm-2">
                        <label for="descripcion" id="" class="">
                            Total:
                        </label>

                        <input type="number" class="form-control" id="total" name="total"  value="{{$servicio->total}}"  onchange="cambioTotal()"/>

                    </div>
                </div>















                <div class="col-12 col-sm-2">
                    <label for="descripcion" id="" class="">
                        Cantidad Servicios:
                    </label>

                    <input type="number" class="form-control" id="cantidadServicio" name="cantidadServicio" value="{{$servicio->cantidadServicio}}"/>

                </div>



                <div class="col-12 col-sm-2">
                    <label for="descripcion" id="" class="">
                        Total Participantes:
                    </label>

                    <input type="number" class="form-control" id="totalParticipantes" name="totalParticipantes" value="{{$servicio->totalParticipantes}}"/>

                </div>


                <div class="col-12 col-sm-2">
                    <label for="descripcion" id="" class="">
                        Nro Horas efectivas:
                    </label>

                    <input type="number" class="form-control" id="nroHorasEfectivas" name="nroHorasEfectivas" value="{{$servicio->nroHorasEfectivas}}"/>
                </div>



                <div class="col-12 col-sm-6">
                    <label for="descripcion" id="" class="">
                        Descripción:
                    </label>

                    <textarea class="form-control" id="descripcion" name="descripcion" rows="1"
                    >{{$servicio->descripcion}}</textarea>

                </div>

                <div class="col-12 col-sm-4">
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

                <div class="col-12 col-sm-4">
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




                <div  class="col-12 col-sm-4">
                    <label for="codTipoAcceso" id="" class="">
                        Tipo Acceso:
                    </label>

                    <select class="form-control"  id="codTipoAcceso" name="codTipoAcceso">
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

                <div  class="col-12 col-sm-4">
                    <label for="codMesAño" id="" class="">
                        Mes:
                    </label>

                    <select class="form-control"  id="codMesAño" name="codMesAño">
                        <option value="-1">-- Mes --</option>
                        @foreach($listaMesesAño as $mesAño)
                            <option value="{{$mesAño->getId()}}"
                                @if($mesAño->getId() == $servicio->codMesAño)
                                    selected
                                @endif
                                >
                                {{$mesAño->getTexto()}}
                            </option>
                        @endforeach

                    </select>
                </div>


                <div class="col-12 col-sm-4">
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

                <div class="col-12 col-sm-4">
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



                {{App\ComponentRenderizer::LugarSelector('ComboBoxDistrito',$servicio->codDistrito)}}
                
            </div>



            <div class="row mt-2"> {{-- ARCHIVOS --}}
                <div class="col-6">
                    {{$servicio->html_getArchivosDelServicio(true)}}
                    {{$file_uploader->render()}}
                    <div class="mt-2">
                      <div class="d-flex">
                          
                        <a target="_blank" href="{{$linkDrive}}" class="link-drive d-flex">
                          <div class="d-flex flex-column mr-2">
                            <img src="/img/icono-drive.png" alt="" class="my-auto link-drive-img">
                          </div>
                          <div class="d-flex flex-column">
                            <div>
                              Subir archivos al drive
                            </div>
                            <div class=" fontSize10 mt-n1">
                              (Subir a la carpeta de tu unidad técnica)
                            </div>
                          </div>
                            
                            
                          
                        </a>
                        
                      </div>
                      
                    </div>


                </div>
                <div class="col-6">

                </div>

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


<div class="card mx-2">
    <div class="card-header ui-sortable-handle" style="cursor: move;">
        <h3 class="card-title">
           {{--  <i class="fas fa-chart-pie"></i> --}}
            <b>Asistencia de usuarios</b>
        </h3>
    </div>
    <div class="card-body">
        <div class="row">

            <div class="col-12 row">
                <div class="col-6 align-self-end">
                    <label class="d-flex" for="">
                        Usuarios del servicio:
                    </label>
                </div>
                <div class="col-6 text-right">
                    <div class="mr-1 my-2 text-right">


                        <button type="button" id="botonModalListaAsistencia" class="btn btn-sm btn-success m-2"
                            data-toggle="modal" data-target="#ModalListaAsistencia">
                            Editar Asistencia
                            <i class="fas fa-pen"></i>
                        </button>


                        <button type="button" id="botonModalAgregarExterno" class="btn btn-sm btn-success m-2"
                            data-toggle="modal" data-target="#ModalAgregarExterno">
                            Agregar Participante
                            <i class="fas fa-plus"></i>
                        </button>


                    </div>
                </div>

            </div>
            <div class="table-responsive">
                
              <table class="table table-striped table-bordered table-condensed table-hover tabla-detalles" >
                  <thead  class="thead-default">
                      <tr>
                          <th class="text-center">
                              #
                          </th>
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
                          <th class="text-center">
                              Externo?
                          </th>
                          <th class="text-center">
                              Opciones
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      @php
                          $i=1;
                      @endphp
                      @foreach($servicio->getUsuarios() as $usuario )
                          @php
                              $relaAsistenciaServicio = $servicio->getAsistenciaDeUsuario($usuario->getId());
                          @endphp
                          <tr>
                              <td class="text-center">
                                  {{$i}}
                              </td>
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
                                  @if($relaAsistenciaServicio->esExterno())
                                      SÍ
                                  @else
                                      NO
                                  @endif
                              </td>
                              <td class="text-center">
                                  <a href="{{route('CITE.Usuarios.Ver',$usuario->getId())}}" class='btn btn-info btn-sm' title="Ver Usuarios">
                                      <i class="fas fa-eye"></i>
                                  </a>

                                  <button onclick="clickEliminarUsuarioDelServicio({{$relaAsistenciaServicio->getId()}})" type="button" class="btn btn-danger btn-sm" title="Eliminar usuario del servicio">
                                      <i class="fas fa-ban"></i>
                                  </button>
                              </td>

                          </tr>
                      @php
                          $i++;
                      @endphp
                      @endforeach
                      @if(count($servicio->getRelaAsistenciaServicio()) == 0)
                          <tr>
                              <td class="text-center" colspan="7">
                                  No hay usuarios registrados en este servicio
                              </td>
                          </tr>
                      @endif

                  </tbody>
              </table>

            </div>
        </div>



    </div>
</div>



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






{{-- MODAL DE AGREGAR ASOCIADOS --}}
<div class="modal  fade" id="ModalListaAsistencia" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">


                <div class="modal-header">
                    <h5 class="modal-title" id="">
                        Asistencia de usuarios al servicio
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="col-12 row">
                        <div class="col-10">

                            @php
                                $i=1;
                            @endphp
                            <select id="codUsuarioBusquedaRapida" data-select2-id="1" tabindex="-1" onchange="cambioUsuarioBuscado(this.value)"
                                class="fondoBlanco form-control form-control-sm select2-hidden-accessible selectpicker"   aria-hidden="true"  data-live-search="true">

                                <option value="-1" class="fontSize9">- Buscar Usuario -</option>
                                @foreach($listaUsuariosYAsistencia as $usuario)
                                    
                                    <option value="{{$usuario->getId()}}" class="fontSize9">
                                        {{$i}}. {{$usuario->getNombreCompleto()}} {{$usuario->dni}}
                                    </option>
                                @php
                                    $i++;
                                @endphp
                                @endforeach

                            </select>


                        </div>
                        <div class="col-2">
                            <button id="botonBusqueda" class="btn btn-success btn-sm" type="button" onclick="clickMarcarAsistenciaBusquedaRapida()">
                                <span id="msjBusqueda">Marcar asistencia</span>
                                <i id="iconoBusqueda" class="fa fa-check"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-12 row mt-2">
                        <div class="col-12 align-self-end">
                            <label class="d-flex" for="">
                                Usuarios de la unidad productiva
                            </label>
                        </div>


                    </div>


                    {{-- TABLA --}}
                    <div class="col-12">
                        <table class="table table-striped table-bordered table-condensed table-hover" >
                            <thead  class="thead-default">
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th class="text-left">
                                      Nombres
                                    </th>
                                    <th class="text-center">
                                      DNI
                                    </th>
                                    <th class="text-center">
                                        Asistencia
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="modal_AsistenciaUsuarios">
                                @php
                                    $i=1;
                                @endphp
                                @foreach($listaUsuariosYAsistencia as $usuario)
                                    <tr>
                                        <td class="pequeñaRow text-center">
                                          {{$i}}
                                        </td>
                                        <td class="pequeñaRow">
                                          <label for="CB_Asistencia_{{$usuario->codUsuario}}">
                                            {{$usuario->getNombreCompleto()}}
                                          </label>
                                        </td>
                                        <td class="pequeñaRow text-center">
                                            <label for="CB_Asistencia_{{$usuario->codUsuario}}">
                                                {{$usuario->dni}}
                                            </label>
                                        </td>
                                        <td class="pequeñaRow text-center">
                                            <input type="checkbox" class="specialCB" value="1" id="CB_Asistencia_{{$usuario->codUsuario}}"
                                            {{$usuario->asistencia ? 'checked' : ''}}

                                                onchange="clickCambiarAsistencia({{$usuario->getId()}},this.checked)">

                                        </td>
                                    </tr>
                                @php
                                  $i++;
                                @endphp
                                @endforeach

                            </tbody>
                        </table>

                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Salir
                    </button>

                    <button type="button" class="m-1 btn btn-primary" onclick="clickGuardarNuevaAsistencia()">
                        Guardar
                        <i class="fas fa-save"></i>
                    </button>
                </div>


        </div>
    </div>
</div>


{{-- MODAL DE AGREGAR EXTERNOS --}}
<div class="modal  fade" id="ModalAgregarExterno" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">


                <div class="modal-header">
                    <h5 class="modal-title" id="">
                        Agregar participantes al servicio
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">



                        <form action="{{route('CITE.Servicios.agregarAsistenciaExterna')}}" id="frmAgregarAsistenciaExterna" name="frmAgregarAsistenciaExterna"  method="POST">
                            @csrf
                            <input type="hidden" name="codServicio" value="{{$servicio->codServicio}}">
                           {{--  <div class="fontSize10 ">
                                Entiendase como usuario externo, quien no pertenece aún a la unidad productiva del servicio.
                            </div> --}}
                            <div class="mr-1 my-2 row">


                                <div class="col-4">
                                    <div>
                                        <label for="">DNI:</label>
                                    </div>
                                    <div class="d-flex">


                                        <div>
                                            <input type="number" class="form-control" id="dni" name="dni" value="">
                                        </div>
                                        <div>
                                            <button type="button" title="Buscar por DNI en la base de datos de Sunat"
                                                class="btn-sm btn btn-info d-flex align-items-center m-1" id="botonBuscarPorRUC" onclick="consultarPorDNI()" >
                                                <i class="fas fa-search m-1"></i>

                                            </button>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="">Teléfono:</label>
                                    <input type="number" class="form-control" id="telefono" name="telefono" value="">


                                </div>
                                <div class="col-4">
                                    <label for="">Correo:</label>
                                    <input type="email" class="form-control" id="correo" name="correo" value="">

                                </div>
                                <div class="col-4">
                                    <label for="">Nombres:</label>
                                    <input type="text" class="form-control" id="nombres" name="nombres" value="">

                                </div>
                                <div class="col-4">

                                    <label for="">Apellido Paterno:</label>
                                    <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" value="">


                                </div>
                                <div class="col-4">

                                    <label for="">Apellido Materno:</label>
                                    <input type="text"  class="form-control" id="apellidoMaterno" name="apellidoMaterno" value="">

                                </div>




                            </div>
                            <div>
                                <input type="checkbox" value="1" id="inscribirEnUnidad" name="inscribirEnUnidad">
                                <label class="" for="inscribirEnUnidad">
                                    Inscribir en la unidad(como socio)
                                </label>
                            </div>
                            
                        </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Salir
                    </button>

                    <button type="button" class="m-1 btn btn-primary" onclick="agregarAsistenciaExterna()">
                        Guardar
                        <i class="fas fa-save"></i>
                    </button>
                </div>


        </div>
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
        actualizarModalidad({{$servicio->codModalidad}})

        //contadorCaracteres('ruc','contadorRUC',11);
        //contadorCaracteres('observacion','contadorObservacion',{{App\Configuracion::tamañoObservacionOC}});

    });


    /* FORMULARIO PRINCIPAL DE DATOS SERVICIO */
    function registrar(){
        msje = validarFormulario();
        if(msje!="")
            {
                alerta(msje);
                return false;
            }

        confirmar('¿Está seguro de actualizar el servicio?','info','frmrepo');

    }






    /* AGREGAR USUARIOS EXTERNOS EN MODAL */
    function agregarAsistenciaExterna(){

        msjError = validarUsuarioExterno();
        if(msjError!=""){
            alerta(msjError);
            return;
        }

        document.frmAgregarAsistenciaExterna.submit();
    }


    function validarUsuarioExterno(){

        msj = "";
        limpiarEstilos(['dni','nombres','telefono','apellidoMaterno','correo','apellidoPaterno',])

        msj = validarTamañoExacto(msj,'dni',8,'DNI')
        //msj = validarTamañoMaximoYNulidad(msj,'telefono',200,'telefono')
        //msj = validarTamañoMaximoYNulidad(msj,'correo',200,'correo')
        msj = validarTamañoMaximoYNulidad(msj,'nombres',200,'nombres')
        msj = validarTamañoMaximoYNulidad(msj,'apellidoPaterno',200,'apellidoPaterno')
        msj = validarTamañoMaximoYNulidad(msj,'apellidoMaterno',200,'apellidoMaterno')

        if(validarQueYaEsteEnElServicio() !="" )
            msj = validarQueYaEsteEnElServicio();


        return msj;
    }


    var usuariosDelServicio = @php echo $servicio->getUsuarios()  @endphp


    function validarQueYaEsteEnElServicio(){
        //verificamos que no esté ya en el servicio
        var dni = document.getElementById('dni').value;
        var listaDNIiguales = usuariosDelServicio.filter(e => e.dni == dni);
        if(listaDNIiguales.length!=0)
            return "El usuario de DNI " + dni +" ya se encuentra en el servicio actual"
        return "";
    }



    async function consultarPorDNI(){

        msjError="";

        msjError = validarTamañoExacto(msjError,'dni',8,'DNI');
        msjError = validarNulidad(msjError,'dni','DNI');
        dni = document.getElementById('dni').value;
        if(validarQueYaEsteEnElServicio() !="" )
            msjError = validarQueYaEsteEnElServicio();



        if(msjError!=""){
            alerta(msjError);
            return;
        }

        //Primero consultamos en la base de datos interna

        $(".loader").show();//para mostrar la pantalla de carga
        var encontrado = false;
        var data = await $.get('/Cite/buscarUsuarioCite/'+dni).promise();

        console.log(data);
        if(data.encontrado){
            var usuario = data.usuario;
            $(".loader").fadeOut("slow");
            alertaExitosa("Encontrado","Usuario " + usuario.nombres + " encontrado en la base de datos.");

            document.getElementById('nombres').value =  usuario.nombres;
            document.getElementById('apellidoPaterno').value =  usuario.apellidoPaterno;
            document.getElementById('apellidoMaterno').value =  usuario.apellidoMaterno;
            document.getElementById('telefono').value =  usuario.telefono;
            document.getElementById('correo').value =  usuario.correo;


            encontrado = true;
        }


        console.log("encontrado",encontrado)
        if(encontrado) return;

        $.get('/ConsultarAPISunat/dni/'+dni,
            function(data)
            {
                console.log("IMPRIMIENDO DATA como llegó:");

                data = JSON.parse(data);

                console.log(data);
                persona = data.datos;

                alertaMensaje(data.mensaje,data.titulo,data.tipoWarning);
                if(data.ok==1){
                    document.getElementById('nombres').value =  persona.nombres;
                    document.getElementById('apellidoPaterno').value =  persona.apellidoPaterno;
                    document.getElementById('apellidoMaterno').value =  persona.apellidoMaterno;


                }

                $(".loader").fadeOut("slow");
            }
        );
    }










    /* MODAL LISTA DE ASISTENCIAS DE USUARIOS INTERNOS */

    function clickGuardarNuevaAsistencia(){
        url = "/Cite/Servicios/GuardarAsistencias";
        formData = {
            listaUsuariosYAsistencia,
            codServicio : "{{$servicio->codServicio}}",
            _token	 	: "{{ csrf_token() }}"
        }
        request =  {
            method: "POST",
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(formData)
        }

        maracFetch(url,request,function(objetoRespuesta){

            console.log(objetoRespuesta);
            $(".loader").show();
            alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);


            setTimeout(function(){
                location.href = "{{route('CITE.Servicios.Editar',$servicio->codServicio)}}"
            }, 1500);

        })

    }

    var listaUsuariosYAsistencia = @php echo $listaUsuariosYAsistencia @endphp

    function clickCambiarAsistencia(codUsuario,nuevoValor){
        console.log('(clickCambiarAsistencia) codUsuario',codUsuario)
        console.log('(clickCambiarAsistencia) nuevoValor',nuevoValor)

        for (let index = 0; index < listaUsuariosYAsistencia.length; index++) {
            const element = listaUsuariosYAsistencia[index];
            if(element.codUsuario == codUsuario)
                listaUsuariosYAsistencia[index].nuevaAsistencia = nuevoValor;

        }

        console.log('listaUsuariosYAsistencia',listaUsuariosYAsistencia)
        actualizarBotonBusqueda();

    }






    /* CRUD USUARIOS DEL SERVICIO PERO RENDERIZADO EN EL SERV POR PHP */

    var codRelacionAEliminar = 0;
    function clickEliminarUsuarioDelServicio(codRelacion){
        codRelacionAEliminar = codRelacion;
        confirmarConMensaje("Confirmación","¿Desea eliminar el usuario del servicio?","warning",ejecutarEliminacionUsuarioDelServicio)
    }

    function ejecutarEliminacionUsuarioDelServicio(){
        location.href ="/Cite/Servicios/EliminarRelacionUsuario/" + codRelacionAEliminar;
    }


    /* Busqueda rapida x nombre y dni */

    function cambioUsuarioBuscado(newValue){
        

        codUsuarioSeleccionado = newValue;
        actualizarBotonBusqueda();
    }

    var codUsuarioSeleccionado = 0;

    function actualizarBotonBusqueda(){
        var relacion = listaUsuariosYAsistencia.find(e => e.codUsuario == codUsuarioSeleccionado);
        console.log("nuevaAsistencia de: " + codUsuarioSeleccionado ,relacion.nuevaAsistencia);
        if(relacion.nuevaAsistencia){
            claseIcono = "fa fa-trash";
            claseBoton = "btn btn-danger btn-sm";
            msjBusqueda = "Eliminar asistencia";
        }else{
            claseIcono = "fa fa-check";
            claseBoton = "btn btn-success btn-sm";
            msjBusqueda = "Marcar asistencia";
        }

        document.getElementById("msjBusqueda").innerHTML = msjBusqueda;
        document.getElementById("botonBusqueda").className = claseBoton
        document.getElementById("iconoBusqueda").className = claseIcono

    }



    function clickMarcarAsistenciaBusquedaRapida(){
        

        codUsuarioSeleccionado = document.getElementById('codUsuarioBusquedaRapida').value

        if(codUsuarioSeleccionado=="-1"){
          alerta("Seleccione un usuario válido")
          return;
        }


        var comboBox = document.getElementById('CB_Asistencia_'+codUsuarioSeleccionado) //hacemos click
        comboBox.checked = !comboBox.checked;

        clickCambiarAsistencia(codUsuarioSeleccionado,comboBox.checked);
        actualizarBotonBusqueda();

    }


</script>

@include('CITE.Servicios.ServicioJS')

@endsection
