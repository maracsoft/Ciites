@extends('Layout.Plantilla')

@section('titulo')
  Editar Unidad Productiva
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div >
    <p class="h2" style="text-align: center">
        Editar Unidad Productiva
    </p>
</div>

@include('Layout.MensajeEmergenteDatos')



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
          <form method = "POST" action = "{{route('CITE.UnidadesProductivas.Actualizar')}}" id="frmUnidadProd" name="frmUnidadProd"  enctype="multipart/form-data">
            <input type="hidden" name="codUnidadProductiva" value="{{$unidadProductiva->getId()}}">
            @csrf
          
              <div class="row  internalPadding-1">
                  <div  class="col-sm-2">
                      <label for="codTipoPersoneria" id="lvlProyecto" class="">
                          Tipo Personería:
                      </label>
                  </div>
                  <div class="col-sm-10">
                      <select class="form-control"  id="codTipoPersoneria" name="codTipoPersoneria">
                          <option value="-1">-- Tipo Personeria --</option>
                          @foreach($listaTipoPersoneria as $tipoPersoneria)
                              <option value="{{$tipoPersoneria->getId()}}"
                                  @if($tipoPersoneria->getId() == $unidadProductiva->codTipoPersoneria)
                                      selected
                                  @endif
                                  >
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
                              <option value="{{$estadoUnidad->getId()}}"
                                  @if($estadoUnidad->getId() == $unidadProductiva->codEstadoDocumento)
                                      selected
                                  @endif
                                  >
                                  {{$estadoUnidad->nombre}}
                              </option>

                          @endforeach

                      </select>
                  </div>
                  <div  class="col-sm-2">
                      <input type="checkbox" value="1" id="tieneCadena" name="tieneCadena"
                          @if ($unidadProductiva->getTieneCadena()) checked @endif
                          onclick="actualizarTieneCadena(this.checked)">
                      <label class="" for="tieneCadena">
                          Tiene Cadena:
                      </label>
                  </div>
                  <div class="col-sm-4">
                      <select class="form-control"  id="codCadena" name="codCadena"
                      @if (!$unidadProductiva->getTieneCadena()) disabled @endif >
                          <option value="-1">- Cadena -</option>
                          @foreach($listaCadenas as $cadena)
                              <option value="{{$cadena->getId()}}"
                                  @if($cadena->getId() == $unidadProductiva->codCadena)
                                      selected
                                  @endif
                                  >
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

                              <input type="number" class="form-control" name="ruc" id="ruc" value="{{$unidadProductiva->ruc}}"
                              @if($unidadProductiva->estaEnTramite())
                                  readonly
                              @endif
                              >

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
                          <input type="text" class="form-control" name="razonSocial" id="razonSocial" value="{{$unidadProductiva->razonSocial}}">
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

                              <input type="number" class="form-control" name="dni" id="dni" value="{{$unidadProductiva->dni}}">

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
                          <input type="text" class="form-control" name="nombrePersona" id="nombrePersona" value="{{$unidadProductiva->nombrePersona}}">
                      </div>

                  </div>


                  <div class="col-sm-6">
                      <div class="form-check">
                          <input style="" class="form-check-input" type="checkbox" value="1" id="enTramite" name="enTramite" onclick="actualizarDocumentoTramite(this)"
                          @if($unidadProductiva->estaEnTramite())
                              checked
                          @endif
                          >
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
                      <select class="form-control"  id="codClasificacion" name="codClasificacion" >
                          <option value="-1">-- Clasificación  --</option>
                          @foreach($listaRangos as $rango)
                              <option value="{{$rango->getId()}}"
                                  @if($rango->getId() == $unidadProductiva->codClasificacion)
                                      selected
                                  @endif
                                  >
                                  {{$rango->nombre}} [{{$rango->minimo}}-{{$rango->maximo}}]
                              </option>
                          @endforeach

                      </select>
                  </div>



                  <div  class="col-sm-2">
                      <label for="" id="">Dirección:</label>
                  </div>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" name="direccion" id="direccion" value="{{$unidadProductiva->direccion}}">
                  </div>


                  {{App\ComponentRenderizer::LugarSelector('ComboBoxDistrito',$unidadProductiva->codDistrito)}}


                  <div class="col-sm-6" title="Activando esta opción, al editar los miembros de esta unidad productiva, se editarán también en la organización enlazada del PPM">
                            
                    <input class="cursor-pointer" type="checkbox" value="1" id="activar_enlace_ppm" name="activar_enlace_ppm" 
                      @if($unidadProductiva->tieneEnlacePPM()) checked @endif onclick="actualizarTieneEnlacePPM(this.checked)">
                    
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
                            <option value="{{$org->getId()}}" {{$org->isThisSelected($unidadProductiva->codOrganizacionEnlazadaPPM)}}>
                              {{$org['razonYRUC']}}
                            </option>
                          @endforeach
                      </select>


                      @php
                        $hidden_class = "hidden";
                        if($unidadProductiva->codOrganizacionEnlazadaPPM){
                          $hidden_class = "";
                        }
                      @endphp
                    

                      <button id="boton_ir_organizacion" type="button" class="ml-1 btn btn-primary {{$hidden_class}}" title="Ir a la Organización enlazada " onclick="clickIrAOrganizacionEnlazada()">
                        <i class="fas fa-edit"></i>
                      </button>


                    </div>

                  </div>



              </div>


              <div class="row">
                  <div class="ml-auto m-1">

                      <button type="button" class="btn btn-primary" id="btnEditar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando"
                          onclick="clickGuardar()">
                          <i class='fas fa-save'></i>
                          Guardar
                      </button>

                  </div>

              </div>

          </form>


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
            <div class="row">
                <div class="table-responsive">
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



                        </tbody>
                    </table>
                </div>

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
            <div class="d-flex flex-row">
              @if($unidadProductiva->tieneEnlacePPM())
               
                <form method="POST" id="formSincronizarPPM" name="formSincronizarPPM" action="{{route('CITE.UnidadesProductivas.SincronizarConPPM')}}" >
                  @csrf
                   
                  <input type="hidden" name="codUnidadProductiva" value="{{$unidadProductiva->codUnidadProductiva}}">
                  <button type="button" onclick="clickSincronizarIntegrantes()" class="btn btn-sm btn-success">
                    <i class="mr-1 fas fa-sync"></i>  
                    Sincronizar Integrantes con Organización
                  </button>
        
                </form>

              @endif
            </div>
            <div class="d-flex flex-row py-3">
                

                <button type="button" id="" class="btn btn-sm btn-success "
                    data-toggle="modal" data-target="#ModalPresidenteGerente">
                    Modificar Presidente o Gerente
                    <i class="fas fa-user-circle"></i>
                </button>

                <button type="button" id="" class="ml-auto btn btn-sm btn-success "
                    data-toggle="modal" data-target="#ModalAgregarSocio">
                    Añadir Socio
                    <i class="fas fa-plus"></i>
                </button>
            </div>

            <div class="table-responsive">
              
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
                                  <div class="d-flex flex-row">
                                      <div>
                                          {{$usuario->getNombreCompleto()}}
                                      </div>
                                      <div class="ml-auto">



                                          @if($unidadProductiva->codUsuarioPresidente == $usuario->getId())
                                              (Presidente)
                                          @endif
                                          @if($unidadProductiva->codUsuarioGerente == $usuario->getId())
                                              (Gerente)
                                          @endif
                                      </div>
                                  </div>
                              </td>
                              <td class="text-right">
                                  {{$usuario->telefono}}
                              </td>
                              <td class="text-right">
                                  {{$usuario->correo}}
                              </td>
                              <td class="text-center">
                                  <a href="{{route('CITE.Usuarios.Ver',$usuario->getId())}}" class='btn btn-info btn-xs' title="Ver Usuario">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  <a href="{{route('CITE.Usuarios.Editar',$usuario->getId())}}" class='btn btn-info btn-xs' title="Editar Usuario">
                                      <i class="fas fa-pen"></i>
                                  </a>

                                  <button onclick="clickEliminarUsuarioDeLaUnidad({{$relaUsuarioAsociado->getId()}})" type="button" class="btn btn-danger btn-xs" title="Eliminar usuario del servicio">
                                      <i class="fas fa-trash"></i>
                                  </button>

                              </td>

                          </tr>
                      @endforeach
                      @if(count($unidadProductiva->getUsuariosAsociados()) == 0)
                          <tr>
                              <td class="text-center" colspan="5">
                                  No hay usuarios registrados en este servicio
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

            <button type="button" onclick="clickVolverMenu()" class='btn btn-info '>
                <i class="fas fa-arrow-left"></i>
                Regresar al Menú
            </button>

        </div>


    </div>


 



<div class="modal  fade" id="ModalAgregarSocio" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="" id="frmAgregarLugar" name="frmAgregarLugar"  method="POST">
                @csrf
                <input type="hidden" name="codUnidadProductiva" value="{{$unidadProductiva->getId()}}">

                <div class="modal-header">
                    <h5 class="modal-title" id="">Agregar nuevos socios</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">

                    <div class="col-sm-4">
                        <div>
                            <label for="">DNI:</label>
                        </div>
                        <div class="d-flex">


                            <div>
                                <input type="number" class="form-control" id="usuario_dni" name="usuario_dni" value="">
                            </div>
                            <div>
                                <button type="button" title="Buscar por DNI en la base de datos de Sunat"
                                    class="btn-sm btn btn-info d-flex align-items-center m-1" id="botonBuscarPorRUC" onclick="consultarUsuarioPorDNI()" >
                                    <i class="fas fa-search m-1"></i>

                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label for="">Teléfono:</label>
                        <input type="number" class="form-control" id="telefono" name="telefono" value="">


                    </div>
                    <div class="col-sm-4">
                        <label for="">Correo:</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="">

                    </div>
                    <div class="col-sm-4">
                        <label for="">Nombres:</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" value="">

                    </div>
                    <div class="col-sm-4">

                        <label for="">Apellido Paterno:</label>
                        <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" value="">


                    </div>
                    <div class="col-sm-4">

                        <label for="">Apellido Materno:</label>
                        <input type="text"  class="form-control" id="apellidoMaterno" name="apellidoMaterno" value="">

                    </div>

                    <div class="col-12 row mt-2">
                        <div class="col-6 align-self-end">
                            <label class="d-flex" for="">
                                Usuarios a agregar:
                            </label>
                        </div>
                        <div class="col-6 text-right">
                            <div class="mr-1 my-2">
                                <button type="button" class="btn btn-primary btn-sm" onclick="agregarUsuario()">
                                    <i class="fas fa-plus"></i>
                                    Agregar
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 table-responsive">

                      
                        <table class="table table-striped table-bordered table-condensed table-hover" >
                            <thead  class="thead-default">
                                <tr>
                                    <th>
                                        DNI
                                    </th>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Correo
                                    </th>
                                    <th>
                                        Teléfono
                                    </th>
                                    <th>
                                        Opciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="modal_UsersToAddList">

                            </tbody>
                        </table>

                    </div>





                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Salir
                    </button>

                    <button type="button" class="m-1 btn btn-primary" onclick="clickGuardarNuevosSocios()">
                        Guardar
                        <i class="fas fa-save"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


<div class="modal  fade" id="ModalPresidenteGerente" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{route('CITE.UnidadesProductivas.ConfigurarPresidenteGerente')}}" id="frmPresidenteGerente" name="frmPresidenteGerente"  method="POST">
                @csrf
                <input type="hidden" name="codUnidadProductiva" value="{{$unidadProductiva->getId()}}">

                <div class="modal-header">
                    <h5 class="modal-title" id="">Configurar presidente y gerente de la unidad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="body">
                    <div class="row p-3">
                        <div class="col-12">
                            <label for="">
                                Presidente
                            </label>
                            <select class="form-control" name="codUsuarioPresidente" id="">
                                <option value="">- Sin presidente -</option>

                                @foreach($unidadProductiva->getUsuariosAsociados() as $relaUsuarioAsociado )
                                    @php
                                        $usuario = $relaUsuarioAsociado->getUsuario();
                                    @endphp
                                    <option value="{{$usuario->getId()}}"
                                        @if($usuario->getId() == $unidadProductiva->codUsuarioPresidente)
                                            selected
                                        @endif

                                        >
                                        {{$usuario->getNombreCompleto()}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="">
                                Gerente
                            </label>
                            <select class="form-control" name="codUsuarioGerente" id="">
                                <option value="">- Sin Gerente -</option>
                                @foreach($unidadProductiva->getUsuariosAsociados() as $relaUsuarioAsociado )
                                    @php
                                        $usuario = $relaUsuarioAsociado->getUsuario();
                                    @endphp
                                    <option value="{{$usuario->getId()}}"
                                        @if($usuario->getId() == $unidadProductiva->codUsuarioGerente)
                                            selected
                                        @endif
                                        >
                                        {{$usuario->getNombreCompleto()}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Salir
                    </button>

                    <button type="button" class="m-1 btn btn-primary" onclick="clickGuardarPresidenteGerente()">
                        Guardar
                        <i class="fas fa-save"></i>
                    </button>
                </div>

            </form>
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
   
        var codPresupProyecto = -1;

        var tiene_enlace = {{$unidadProductiva->activar_enlace_ppm}};

        var ListaOrganizaciones = @json($listaOrganizaciones); 


        var listaTipoPersoneria = @php echo $listaTipoPersoneria; @endphp;
        var tipoPersoneriaSeleccionada = {};
        $(document).ready(function(){
             
            mostrarDivRUC();
            actualizarEstadoDocumento({{$unidadProductiva->codEstadoDocumento}});
            
            if(tiene_enlace)
              changedOrganizacionEnlazada();

            /* Para darle tiempo al navegador que renderice el Select2 de bootstrap */
            setTimeout(() => {
              actualizarTieneEnlacePPM(tiene_enlace);
              $(".loader").fadeOut("slow");
            }, 500);


        });


        function clickGuardarPresidenteGerente(){
            confirmar('¿Está seguro de actualizar el gerente y presidente de  la Unidad Productiva?','info','frmPresidenteGerente');

        }

        function clickGuardar(){
            msje = validarForm();
            if(msje!="")
                {
                    alerta(msje);
                    return false;
                }

            confirmar('¿Está seguro de actualizar la Unidad Productiva?','info','frmUnidadProd');

        }



        

        function clickVolverMenu(){
          var haySocios = usuariosAsociados.length!=0;

          if(!haySocios){
              confirmarConMensaje('No ha añadido socios.','¿Seguro que desea volver al listado de unidades productivas? <br> No ha añadido ningún socio.','warning',ejecutarVolverAlMenu);
          }else 
              ejecutarVolverAlMenu();
        }

        function ejecutarVolverAlMenu(){
            location.href = "{{route('CITE.UnidadesProductivas.Listar')}}";

        }





        var usuariosAsociados = @php echo $unidadProductiva->getUsuarios() @endphp

        /* MINICRUD EN MODAL PARA AGREGAR SOCIOS */

        var listaUsuariosAAgregar = [];

        function agregarUsuario(){

            msjError = validarUsuario();
            if(msjError!=""){
                alerta(msjError);
                return;
            }


            dni = document.getElementById('usuario_dni').value;
            telefono = document.getElementById('telefono').value;
            correo = document.getElementById('correo').value;
            nombres = document.getElementById('nombres').value;
            apellidoPaterno = document.getElementById('apellidoPaterno').value;
            apellidoMaterno = document.getElementById('apellidoMaterno').value;
            codUsuario = 0;

            var usuario = {
                dni,telefono,correo,nombres,apellidoPaterno,apellidoMaterno,codUsuario
            };
            agregarObjUsuario(usuario);
        }

        function agregarObjUsuario(usuario){



            listaUsuariosAAgregar.push(usuario);
            limpiarFormModal();
            paintUserListOnTable();
        }

        function validarUsuario(){

            msj = "";
            limpiarEstilos(['usuario_dni','nombres','telefono','apellidoMaterno','correo','apellidoPaterno',])

            msj = validarTamañoExacto(msj,'usuario_dni',8,'DNI')
            //msj = validarTamañoMaximoYNulidad(msj,'telefono',200,'telefono')
            //msj = validarTamañoMaximoYNulidad(msj,'correo',200,'correo')
            msj = validarTamañoMaximoYNulidad(msj,'nombres',200,'nombres')
            msj = validarTamañoMaximoYNulidad(msj,'apellidoPaterno',200,'apellidoPaterno')
            msj = validarTamañoMaximoYNulidad(msj,'apellidoMaterno',200,'apellidoMaterno')

            if(validarQueYaEsteEnElServicio() !="" )
                msj = validarQueYaEsteEnElServicio();


            return msj;
        }

        function validarQueYaEsteEnElServicio(){
            //verificamos que no esté ya en el servicio
            var dni = document.getElementById('usuario_dni').value;
            var listaDNIiguales = usuariosAsociados.filter(e => e.dni == dni);
            if(listaDNIiguales.length!=0)
                return "El usuario de DNI " + dni +" ya se encuentra en el servicio actual"
            return "";
        }

        function limpiarFormModal(){
            document.getElementById('usuario_dni').value = "";
            document.getElementById('telefono').value = "";
            document.getElementById('correo').value = "";
            document.getElementById('nombres').value = "";
            document.getElementById('apellidoPaterno').value = "";
            document.getElementById('apellidoMaterno').value = "";

        }

        function clickEditarUsuario(dni){
            var selectedUser = listaUsuariosAAgregar.filter(e => e.dni == dni)[0]
            document.getElementById('usuario_dni').value = selectedUser.dni ;
            document.getElementById('telefono').value = selectedUser.telefono ;
            document.getElementById('correo').value = selectedUser.correo ;
            document.getElementById('nombres').value = selectedUser.nombres ;
            document.getElementById('apellidoPaterno').value = selectedUser.apellidoPaterno ;
            document.getElementById('apellidoMaterno').value = selectedUser.apellidoMaterno ;


            //now we delete the user from the list
            listaUsuariosAAgregar = listaUsuariosAAgregar.filter(e => e.dni != dni)
            paintUserListOnTable();
        }


        function paintUserListOnTable(){

            const tbody = document.getElementById('modal_UsersToAddList');
            var htmlTotal = "";
            for (let index = 0; index < listaUsuariosAAgregar.length; index++) {
                const user = listaUsuariosAAgregar[index];
                var nombreComp = user.nombres + " "+  user.apellidoPaterno  + " "+ user.apellidoMaterno;
                var htmlFila=
                /* html */
                `
                  <tr class="selected">
                      <td style="text-align:center;">
                        [DNI]
                      </td>
                      <td>
                        [NombreCompleto]
                      </td>
                      <td class="text-right">
                        [Correo]
                      </td>
                      <td class="text-right">
                        [Telefono]
                      </td>
                      <td style="text-align:center;">
                          <button type="button" class="btn btn-danger btn-xs" onclick="clickEliminarUsuario([DNI]);">
                              <i class="fa fa-times" ></i>
                          </button>
                          <button type="button" class="btn btn-xs" onclick="clickEditarUsuario([DNI]);">
                              <i class="fas fa-pen"></i>
                          </button>
                      </td>
                  </tr>         
                `;

                var hidrate_object = {
                  DNI:user.dni,
                  NombreCompleto:nombreComp,
                  Correo:user.correo,
                  Telefono:user.telefono
                };
                htmlTotal += hidrateHtmlString(htmlFila,hidrate_object);

            }
            tbody.innerHTML = htmlTotal;

        }


        var dniAEliminar = 0;
        function clickEliminarUsuario(dni){
            dniAEliminar = dni;
            confirmarConMensaje("Confirmación","¿Desea eliminar el usuario?","warning",ejecutarEliminacion)

        }

        function ejecutarEliminacion(){

            listaUsuariosAAgregar = listaUsuariosAAgregar.filter(e => e.dni != dniAEliminar)
            paintUserListOnTable();
        }

        function clickGuardarNuevosSocios(){
            if(listaUsuariosAAgregar.length == 0){
              alerta("No ha insertado personas para agregar");
              return;
            }
            
            url = "/Cite/UnidadProductiva/AñadirGrupoDeSocios";
            formData = {
                listaUsuariosAAgregar,
                codUnidadProductiva : "{{$unidadProductiva->getId()}}",
                _token	 	: "{{ csrf_token() }}"
            }
            request =  {
                method: "POST",
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(formData)
            }
            $(".loader").show();
            maracFetch(url,request,function(objetoRespuesta){

                console.log(objetoRespuesta);

                alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);

                setTimeout(function(){
                    location.href = "{{route('CITE.UnidadesProductivas.Editar',$unidadProductiva->getId())}}"
                }, 1500);

            })


        }








        var codRelacionAEliminar = 0;
        function clickEliminarUsuarioDeLaUnidad(codRelacion){
            codRelacionAEliminar = codRelacion;
            confirmarConMensaje("Confirmación","¿Desea eliminar el usuario de la unidad productiva?","warning",ejecutarEliminacionUsuarioDelServicio)
        }

        function ejecutarEliminacionUsuarioDelServicio(){
            location.href ="/Cite/UnidadProductiva/EliminarRelacionUsuarioUnidad/" + codRelacionAEliminar;
        }





        function consultarUsuarioPorDNI(){

            msjError="";

            msjError = validarTamañoExacto(msjError,'usuario_dni',8,'DNI');
            msjError = validarNulidad(msjError,'usuario_dni','DNI');


            if(msjError!=""){
                alerta(msjError);
                return;
            }


            $(".loader").show();//para mostrar la pantalla de carga
            dni = document.getElementById('usuario_dni').value;

            $.get('/ConsultarAPISunat/dni/'+dni,
                function(data){
                    console.log("IMPRIMIENDO DATA como llegó:");

                    data = JSON.parse(data);

                    console.log(data);
                    persona = data.datos;

                    alertaMensaje(data.mensaje,data.titulo,data.tipoWarning);
                    if(data.ok==1){
                        document.getElementById('nombres').value = persona.nombres;
                        document.getElementById('apellidoPaterno').value = persona.apellidoPaterno;
                        document.getElementById('apellidoMaterno').value = persona.apellidoMaterno;


                    }

                    $(".loader").fadeOut("slow");
                }
            );
        }

    </script>

    @include('CITE.UnidadProductiva.UnidadProductivaJS')


@endsection
