@extends('Layout.Plantilla')

@section('titulo')
  Editar Servicio
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')
<style>
  .guia_step{
    color: #00ab00;
    font-size: 14pt;
    line-height: 22px;
    

  }

  @media(min-width:990px){ /* desktop */
    .guia_conversion{
      width: 60%;
    }
  }

  @media(max-width:990px){ /* mobile */
    .guia_conversion{
      width: 100%;
    }
  }



  .mensaje_compatibilidad{
    
    font-size: 14pt;
    line-height: 22px;
    margin-bottom: 12px;
  }

  #mensaje_archivos_faltantes{
    font-size: 12pt;
    background-color: #ededed;
    padding: 5px 10px;
    color: #ff0d0d;
    border-radius: 7px;
  }
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div class="col-12 py-2">
  <div class="page-title">
    Editar Servicio
  </div>
</div>

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
          <div>

            
            <div class="row">
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
                  <label for="codTipoAcceso" id="" class="">
                      Tipo Acceso:
                  </label>

                  <select class="form-control"  id="codTipoAcceso" name="codTipoAcceso"  onchange="actualizarTipoAcceso(this.value)">
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







                



                <div class="col-12 row fondoPlomoCircular p-3 my-1 hidden" id="divConvenio">

                    <div  class="col-12 col-sm-2">
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
                        Nro Horas efectivas:
                    </label>

                    <input type="number" class="form-control" id="nroHorasEfectivas" name="nroHorasEfectivas" value="{{$servicio->nroHorasEfectivas}}"/>
                </div>



                <div class="col-12 col-sm-8">
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

                  <select class="form-control"  id="codModalidad" name="codModalidad" onchange="changeModalidad(this.value)">
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


                <div class="col-12 col-sm-3">
                    <label for="codTipoServicio" id="" class="">
                        Tipo Servicio:
                    </label>

                    <select class="form-control"  id="codTipoServicio" name="codTipoServicio" onchange="actualizarTipoServicio(this.value)">
                        <option value="-1">-- Tipo Servicio --</option>
                        @foreach($servicio->getModalidad()->getTiposServicio() as $tipoServ)
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

                <div class="col-12 col-sm-6">
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
                <div class="col-sm-2"></div>



                {{App\ComponentRenderizer::LugarSelector('ComboBoxDistrito',$servicio->codDistrito)}}
                
            </div>




            <div class="row mt-2">
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

@include('CITE.Servicios.CardArchivos')

<div class="d-flex flex-row m-4">
    <div class="">

        <button type="button" onclick="clickRegresarMenu()" class='btn btn-info '>
            <i class="fas fa-arrow-left"></i>
            Regresar al Menú
        </button>

    </div>
    <div class="ml-auto">


    </div>

</div>





@include('CITE.Servicios.ModalAsistenciaInterna')

@include('CITE.Servicios.ModalAgregarExterno')

@include('CITE.Servicios.ModalArchivoNoCompatible')


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

    const MostrarModalArchivoNocompatible = @if (session('mostrar_modal_archivo_nocompatible')) true @else false @endif

    @php
      session(['mostrar_modal_archivo_nocompatible' => null]);
    @endphp

    var ModalArchivoNocompatible = new bootstrap.Modal(document.getElementById("ModalArchivoNocompatible"), {});
  

    $(document).ready(function(){
        $(".loader").fadeOut("slow");
        actualizarTipoAcceso({{$servicio->codTipoAcceso}})

        if(MostrarModalArchivoNocompatible){
          ModalArchivoNocompatible.show();
        }
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

    /* CRUD USUARIOS DEL SERVICIO PERO RENDERIZADO EN EL SERV POR PHP */

    var codRelacionAEliminar = 0;
    function clickEliminarUsuarioDelServicio(codRelacion){
        codRelacionAEliminar = codRelacion;
        confirmarConMensaje("Confirmación","¿Desea eliminar el usuario del servicio?","warning",ejecutarEliminacionUsuarioDelServicio)
    }

    function ejecutarEliminacionUsuarioDelServicio(){
        location.href ="/Cite/Servicios/EliminarRelacionUsuario/" + codRelacionAEliminar;
    }


    const MensajeArchivosFaltantesString = "{{$servicio->getMensajeArchivosFaltantes()}}"
    function clickRegresarMenu(){
      
      if(MensajeArchivosFaltantesString == "No falta ningún archivo."){
        location.href = "{{route('CITE.Servicios.Listar')}}";

      }else{
        confirmarConMensaje("¿Desea regresar al listado de servicios?",MensajeArchivosFaltantesString,"warning",function(){
          location.href = "{{route('CITE.Servicios.Listar')}}";
        })
      }

      
    }

 


</script>

@include('CITE.Servicios.ServicioJS')

@endsection
