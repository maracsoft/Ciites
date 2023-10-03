@extends('Layout.Plantilla')

@section('titulo')
  PPM - Editar Organización
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')


<div class="col-12 py-2">
  <div class="page-title">
    Editar Organización
  </div>
</div>
@include('Layout.MensajeEmergenteDatos')
<form method="POST" action="{{route('PPM.Organizacion.Actualizar')}}" id="frmOrganizacion" name="frmOrganizacion"  enctype="multipart/form-data">
    <input type="hidden" name="codOrganizacion" value="{{$organizacion->codOrganizacion}}">
    

    @csrf

    <div class="card mx-2">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <div class="d-flex flex-row">
                <div class="">
                    <h3 class="card-title">
                        <b>Información General</b>
                    </h3>
                </div>
            </div>
        </div>
        <div class="card-body">


            <div class="row">
                <div class="col-md"> {{-- COLUMNA IZQUIERDA 1 --}}

                    <div class="row internalPadding-1 mx-2">

                      
                        <div class="col-sm-2">
                          <label for="codTipoDocumento" id="lvlProyecto" class="">
                              Documento:
                          </label>
                          <select class="form-control"  id="codTipoDocumento" name="codTipoDocumento" onchange="actualizarTipoDocumento(this.value)">
                            @foreach($listaTipoDocumento as $tipo_documento)
                                <option value="{{$tipo_documento->getId()}}" {{$tipo_documento->isThisSelected($organizacion->codTipoDocumento)}} >
                                    {{$tipo_documento->nombre}}
                                </option>
                            @endforeach

                          </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="codTipoOrganizacion" class="">
                                Tipo de organización:
                            </label>
                            <select class="form-control" id="codTipoOrganizacion" name="codTipoOrganizacion">
                              <option value="-1">-- Tipo Organización --</option>
                              @foreach($listaTipoOrganizacion as $tipo)
                                  <option value="{{$tipo->getId()}}" {{$tipo->isThisSelected($organizacion->codTipoOrganizacion)}} >
                                      {{$tipo->nombre}}
                                  </option>

                              @endforeach

                            </select>
                        </div>
                      



                     
                        <div class="col-sm-6">

                            <input class="cursor-pointer" type="checkbox" value="1" id="tiene_act_economica" name="tiene_act_economica" @if($organizacion->tieneActividadEconomica()) checked @endif onclick="actualizarTieneActividadEconomica(this.checked)">
                            <label class="cursor-pointer" for="tiene_act_economica">
                                Tiene Actividad:
                            </label>

                            <div class="d-flex">

                              <select class="form-control" id="codActividadEconomica" name="codActividadEconomica" @if(!$organizacion->tieneActividadEconomica()) disabled @endif>
                                <option value="-1">- Actividad  -</option>
                                @foreach($listaActividadEconomica as $act)
                                    <option value="{{$act->getId()}}"  {{$act->isThisSelected($organizacion->codActividadEconomica)}} >
                                        {{$act->nombre}}
                                    </option>
                                @endforeach
                                
                              </select>
                              
                              <input class="form-control hidden" type="text" placeholder="Escriba nueva actividad" id="input_nueva_actividad" name="input_nueva_actividad">
                              <input type="" class="hidden" id="input_nueva_actividad_boolean" name="input_nueva_actividad_boolean" value="0">
                              <button id="boton_actividad" type="button" class="btn btn-success ml-1" onclick="toggleActividadButton()" title="Añadir nueva actividad"  @if(!$organizacion->tieneActividadEconomica()) disabled @endif>
                                <i id="icono_actividad" class="fas fa-plus"></i>
                              </button>

                            </div>

                        </div>
                       


                        <div class="col-12 row">

                            <div class="col-sm-4" id="divRUC">
                                <div class="d-flex ">
                                  <label>
                                    RUC: 
                                  </label>

                                  <div class="ml-auto form-check fontSize10 pr-4">
                                    <input class="form-check-input cursor-pointer" type="checkbox" @if($organizacion->documentoEnTramite()) checked @endif id="documento_en_tramite" name="documento_en_tramite" onclick="actualizarDocumentoTramite(this)">
                                    <label class="form-check-label cursor-pointer" for="documento_en_tramite">
                                        RUC En trámite
                                    </label>
                                  </div>

                                </div>
                               

                                <div class="d-flex flex-col">
                                  <input type="number" class="form-control" placeholder="RUC" name="ruc" id="ruc" value="{{$organizacion->ruc}}" @if($organizacion->documentoEnTramite()) readonly @endif>  
                                  <div class="d-flex mr-auto">
                                      <button type="button" title="Buscar por RUC en la base de datos de Sunat" class="btn-sm btn btn-info d-flex align-items-center" id="botonBuscarPorRUC" onclick="consultarPorRuc()" >
                                          <i class="fas fa-search mr-1"></i>
                                      </button>
                                  </div>
                              </div>
                            </div>
                         
                            <div  class="col-sm-5">
                                <label for="razon_social">Razón Social</label>
                                <input type="text" class="form-control" placeholder="Razón Social" name="razon_social" id="razon_social" value="{{$organizacion->razon_social}}">
                            </div>   

                        </div>
 
                        

                        <div class="col-sm-12">
                            <label for="" id="">Dirección:</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" value="{{$organizacion->direccion}}" placeholder="Dirección">
                        </div> 



                        {{App\ComponentRenderizer::LugarSelector('ComboBoxDistrito',$organizacion->codDistrito)}}

                        
                        <div class="col-sm-6"  title="Activando esta opción, al editar los miembros de esta organización, se editarán también en la unidad productiva enlazada del CITE">
                           

                          <div class="d-flex flex-row mt-1">
                            <input class="cursor-pointer" type="checkbox" value="1" id="activar_enlace_cite" name="activar_enlace_cite" 
                                @if($organizacion->tieneEnlaceCite()) checked @endif onclick="actualizarTieneEnlaceCite(this.checked)">

                                
                              <label class="ml-1 cursor-pointer" for="activar_enlace_cite">
                                  Activar enlace CITE:
                              </label>
                              <div class="ml-auto msj_activarsi">
                                (Activar si la organización ya existe en el CITE)
                              </div>    
                          </div>
                          
                          
                          <div class="d-flex flex-row">
                            <select id="codUnidadProductivaEnlazadaCITE" name="codUnidadProductivaEnlazadaCITE" data-select2-id="1" tabindex="-1" onchange="changedUnidadProductivaEnlazada()"
                                class="fondoBlanco form-control select2 select2-hidden-accessible selectpicker"   aria-hidden="true"  data-live-search="true">
                                <option value="-1">
                                  - Unidad Productiva CITE Enlazada -
                                </option>
                                @foreach($listaUnidadesProductivas as $unidad_prod)
                                  <option value="{{$unidad_prod->getId()}}" {{$unidad_prod->isThisSelected($organizacion->codUnidadProductivaEnlazadaCITE)}}>
                                    {{$unidad_prod['label_front']}}
                                  </option>
                                @endforeach
                            </select>
                            
                            
                            @php
                              $hidden_class = "hidden";
                              if($organizacion->codUnidadProductivaEnlazadaCITE){
                                $hidden_class = "";
                              }
                            @endphp
                          
                            
                            <button id="boton_ir_unidadproductiva" type="button" class="ml-1 btn btn-primary {{$hidden_class}}" title="Ir a la Unidad Productiva enlazada " onclick="clickIrAUnidadEnlazada()">
                              <i class="fas fa-edit"></i>
                            </button>
                            
                            

                          </div>

                          <div class="msj_activarsi">
                            Activar si la organización ya existe en el CITE
                          </div>

                        </div>


                    </div>


                </div>


            </div>

        </div>
        <div class="card-footer">
          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando"
              onclick="registrar()">
              <i class='fas fa-save'></i>
              Guardar
            </button>
          </div>
          
        </div>
    </div>
   


</form>


<div class="card">
  <div class="card-header ui-sortable-handle cursor-move" >
    <div class="d-flex flex-row">
        <div class="">
            <h3 class="card-title">
                <b>Actividades de la Organización</b>
            </h3>
        </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">

      <table class="table table-bordered table-hover datatable fontSize10" id="table-3">
        <thead class="table-marac-header">
            <tr>
              <th>Cod</th>
              <th>Descripcion</th>
              <th>Semestre</th>
              <th class="text-center">
                Lugar
              </th>
              <th>Actividad</th>
              <th>Creado por</th>
              <th>Opciones</th>
            </tr>
        </thead>
        <tbody>

            @foreach($listaActividades as $actividad)
                <tr class="FilaPaddingReducido">
                    <td>
                        {{$actividad->getId()}}
                    </td>
                    <td class="fontSize9">
                        {{$actividad->descripcion}}
                    </td>
                    <td>
                        {{$actividad->getResumenSemestres()}}
                    </td>
                    <td class="text-center">
                        {{$actividad->getTextoLugar()}}
                    </td>
                    
                    <td>
                      [{{$actividad->getActividad()->codigo_presupuestal}}]
                      {{$actividad->getActividad()->descripcion}}
                    </td>
                    
                    <td class="fontSize9">
                      {{$actividad->getEmpleadoCreador()->getNombreCompleto()}}
                      <br>
                      <span class="fontSize7">
                          {{$actividad->getFechaHoraCreacion()}}
                      </span>
                    </td>
                    <td>
                        <a href="{{route('PPM.Actividad.Ver',$actividad->getId())}}" class='btn btn-info btn-sm' title="Ver Unidad Productiva">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{route('PPM.Actividad.Editar',$actividad->getId())}}" class = "btn btn-sm btn-warning"
                          title="Editar Actividad">
                          <i class="fas fa-edit"></i>
                        </a>
  

                    </td>


                </tr>

            @endforeach
            @if(count($listaActividades)==0)
                <tr>
                    <td colspan="10" class="text-center">
                        No hay resultados
                    </td>
                </tr>
            @endif

        </tbody>
      </table>  

    </div>

  </div>

</div>


<div class="card">
  <div class="card-header ui-sortable-handle cursor-move" >
    <div class="d-flex flex-row">
        <div class="">
            <h3 class="card-title">
                <b>Integrantes de la Organización</b>
            </h3>
        </div>
    </div>
  </div>
  <div class="card-body">
    <div class="d-flex  pr-2">
      
      @if($organizacion->tieneEnlaceCite())
        <form method="POST" name="formSincronizarCITE" action="{{route('PPM.Organizacion.SincronizarConCITE')}}" >
          @csrf
          <input type="hidden" name="codOrganizacion" value="{{$organizacion->codOrganizacion}}">
          <button type="button" onclick="clickSincronizarIntegrantes()" class="btn btn-sm btn-success">
            <i class="mr-1 fas fa-sync"></i>  
            Sincronizar Integrantes con Unidad productiva
          </button>

        </form>
      @endif
      
      <div class="ml-auto">
        <button type="button" id="" class=" btn btn-sm btn-success"
          data-toggle="modal" data-target="#ModalAgregarSocio">
          <i class="mr-1 fas fa-plus"></i>
          Añadir integrante
            
        </button>
      </div>
      
      
    </div>
    <div class="table-responsive">

      <table class="table table-bordered table-hover datatable ">
        <thead class="table-marac-header">
          <tr>
            <th colspan="7" class="text-center p-1">
              Persona
            </th>
            <th colspan="2" class="text-center p-1">
              Relación con la Organización
            </th>
          </tr>
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
            <th class="text-left">
                Correo
            </th>
            <th class="text-center"> 
                Sexo
            </th>
            <th class="text-center">
                F. Nacimiento
            </th>
            <th class="text-center">
              Opciones
            </th>
            <th class="text-center">
                Cargo
            </th>
            <th class="text-center">
                Opciones
            </th>
          </tr>
        </thead>
        <tbody>
          @forelse($relaciones_personas_asociadas as $rela_persona_asociada )

            @php  
                $persona = $rela_persona_asociada->getPersona();
            @endphp
            <tr>
                <td class="text-right">
                    {{$persona->dni}}
                </td>
                <td class="text-left">
                    <div class="d-flex flex-row">
                        <div>
                            {{$persona->getNombreCompleto()}}
                        </div>
                        <div class="ml-auto">

                          
                        </div>
                    </div>
                </td>
                <td class="text-right">
                    {{$persona->telefono}}
                </td>
                <td class="text-left">
                    {{$persona->correo}}
                </td>
                <td class="text-center">
                    {{$persona->getSexoLabel()}}
                </td>
                <td class="text-center">
                    {{$persona->getFechaNacimiento()}}
                </td>
                <td class="text-center">
                   
                  <a href="{{route('PPM.Persona.Editar',$persona->getId())}}" class='btn btn-info btn-sm' title="Editar Usuario" target="_blank">
                      <i class="fas fa-pen"></i>
                  </a>

                </td>
                <td class="text-left">
                  <div class="d-flex flex-row">
                    <div class="mr-1">
                      {{$rela_persona_asociada->cargo}}

                    </div>
                    <div class="ml-auto">
                     
                    </div>
                    

                  </div>
                    
                   
                </td>
                <td class="text-center">
                    
                    <button type="button" title="Editar cargo" class="btn btn-primary btn-sm m-1" data-toggle="modal" data-target="#ModalEditarCargo" onclick="clickEditarCargo({{$rela_persona_asociada->getId()}},'{{$persona->getNombreCompleto()}}','{{$rela_persona_asociada->cargo}}')">
                      Cargo
                      <i class="fas fa-pen"></i>
                    </button>
                    
                    <button onclick="clickEliminarPersonaDeLaOrg({{$rela_persona_asociada->getId()}})" type="button" class="btn btn-danger btn-sm" title="Eliminar persona de la organización">
                         
                      <i class="fas fa-trash"></i>
                    </button>


                </td>

            </tr>
          @empty

            <tr>
              <td class="text-center" colspan="9">
                  No hay personas asociadas en esta organización
              </td>
            </tr>
          @endforelse
        
            
          

        </tbody>
      </table>  

    </div>

  </div>

</div>



<div class="card">
  <div class="card-header ui-sortable-handle cursor-move" >
    <div class="d-flex flex-row">
        <div class="">
            <h3 class="card-title">
              <b>Semestres de Actividad</b>
            </h3>
        </div>
    </div>
  </div>
  <div class="card-body">
    <div class="d-flex  pr-2">
      
      
      
      
    </div>
    <div class="table-responsive">

      <table class="table table-bordered table-hover datatable fontSize10">
        <thead class="table-marac-header">
          
          <tr>
            <th class="text-right">
                Semestre
            </th>
             
            <th class="text-left">
                Ejecuciones de actividades involucradas
            </th>
            <th>
                Nivel de Gestión Empresarial
            </th>
            <th>
                Empleados Creadores
            </th>
            <th>
                Departamentos
            </th>
            <th>
                Nivel Productivo
            </th>
          </tr>
        </thead>
        <tbody>
          @forelse($relaciones_org_semestre as $rela )
          @php
            $semestre = $rela->getSemestre();
          @endphp
            <tr>
                <td class="text-right">
                  {{$semestre->getTexto()}}
                </td>
                 
                <td class="text-center">
                  @foreach($rela->getEjecucionesQueSustentan() as $ejecucion)
                    <a class="btn btn-primary" href="{{route('PPM.Actividad.Editar',$ejecucion->getId())}}">
                      Ejecución {{$ejecucion->getId()}}
                    </a>    
                  @endforeach
                </td>
                <td class="text-right">

                </td>
                <td class="text-left">
                  {{$rela->getEmpleadosCreadoresLabel()}}
                </td>
                <td class="text-center">
                  {{$rela->getDepartamentosLabel()}}
                </td>
                <td>
                 
                    <a target="_blank" class="btn btn-primary" href="{{route('PPM.SemestreOrganizacion.VerAñadirCultivoCadena',$rela->getId())}}">
                      Cultivo/Cadena
                    </a>  
                    <a target="_blank" class="btn btn-primary" href="{{route('PPM.SemestreOrganizacion.VerAñadirProductos',$rela->getId())}}">
                      Productos
                    </a>
                    
                </td>
                 

            </tr>
          @empty

            <tr>
              <td class="text-center" colspan="7">
                  No hay actividad en ningún semestre.
              </td>
            </tr>
          @endforelse
        
            
          

        </tbody>
      </table>  

    </div>

  </div>

</div>


<div class="d-flex flex-row m-4">
  <div class="">

      <a href="{{route('PPM.Organizacion.Listar')}}" class='btn btn-info '>
          <i class="fas fa-arrow-left"></i>
          Regresar al Menú
      </a>

  </div>
  <div class="ml-auto">

    

  </div>

</div>






<div class="modal fade" id="ModalAgregarSocio" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
          <form action="" id="frmAgregarLugar" name="frmAgregarLugar"  method="POST">
              @csrf
              <input type="hidden" name="codOrganizacion" value="{{$organizacion->getId()}}">

              <div class="modal-header">
                  <h5 class="modal-title" id="">Agregar integrantes a la organización / espacio</h5>
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
                      <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="">


                  </div>
                  <div class="col-sm-4">

                      <label for="">Apellido Materno:</label>
                      <input type="text"  class="form-control" id="apellido_materno" name="apellido_materno" value="">

                  </div>

                      
                    

                  <div class="col-sm-4">
                    <label for="">Fecha Nacimiento:</label>
                    <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                      {{-- INPUT PARA LA FECHA --}}
                      <input type="text" class="form-control text-center" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="dd/mm/yyyy" value=""> 
                      
                      <div class="input-group-btn d-flex flex-column">                                        
                          <button class="btn btn-primary date-set my-auto mx-1" type="button" style="">
                              <i class="fas fa-calendar"></i>
                          </button>
                      </div>
                    </div>
                  </div>
                                  
                  <div class="col-sm-4">
                      
                    <label for="">Sexo:</label>
                    <select class="form-control" name="sexo" id="sexo">
                      <option value="">
                        - Sexo -
                      </option>
                      @foreach($listaSexos as $sexo)
                        <option value="{{$sexo['id']}}">
                          {{$sexo['nombre']}}
                        </option>  
                      @endforeach
                      
                    </select>
                    
                    
                  </div>
                      
                  <div class="col-sm-4">
                    
                    <label for="">Cargo en la Organización:</label>
                    <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo en la organización" value="">

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
                          <thead  class="thead-default table-marac-header">
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
                                      Sexo
                                  </th>
                                  <th>
                                      F. Nacimiento
                                  </th>
                                  <th>
                                    Cargo en la Org
                                  </th>
                                  <th>
                                      Opciones
                                  </th>
                              </tr>
                          </thead>
                          <tbody id="modal_UsersToAddList">
                            <tr>
                              <td colspan="8" class="text-center">
                                Agregue usuarios
                              </td>
                            </tr>
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


<div class="modal fade" id="ModalEditarCargo" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
             
              <div class="modal-header">
                  <h5 class="modal-title" id="">Actualizar Cargo en la organización</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-12">
                    <label for="">
                      Organización:
                    </label>
                    <input type="text" class="form-control" value="{{$organizacion->razon_social}} {{$organizacion->ruc}}" readonly>
                  </div>

                  <div class="col-12">
                    <label for="">
                      Persona:
                    </label>
                    <input id="editarcargo_nombrepersona" type="text" class="form-control" value="" readonly>
                  </div>
                  
                  <div class="col-12">
                    <label for="">
                      Nombre del cargo:
                    </label>
                    <input id="editarcargo_cargo" type="text" class="form-control" value="">
                  </div>
                  
                </div>


              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">
                      Salir
                  </button>
                  <button type="button" class="m-1 btn btn-primary" onclick="clickActualizarCargo()">
                      Guardar
                      <i class="fas fa-save"></i>
                  </button>
              </div>
 
      </div>
  </div>
</div>





{{-- PLANTILLAS PARA JAVASCRIPT --}}
<div class="hidden">

  <table>
    <tbody id="plantilla_usuario_agregar">
      
      <tr class="selected">
        <td class="text-center">
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
        <td class="text-right">
          [Sexo]
        </td>
        <td class="text-center">
          [FechaNacimiento]
        </td>
        <td>
          [Cargo]
        </td>
        
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-xs" onclick="clickEliminarUsuario([DNI]);">
                <i class="fa fa-times" ></i>
            </button>
            <button type="button" class="btn btn-xs" onclick="clickEditarUsuario([DNI]);">
                <i class="fas fa-pen"></i>
            </button>
        </td> 
      </tr>

    </tbody>
  </table>
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

 
@include('Layout.EstilosPegados')
@include('Layout.ValidatorJS')
@section('script')

<script type="application/javascript">
    //se ejecuta cada vez que escogewmos un file
  var codPresupProyecto = -1;

  var tiene_enlace = {{$organizacion->activar_enlace_cite}};

  var ListaUnidadesProductivas = @json($listaUnidadesProductivas); 


  const PersonasAsociadas = @json($organizacion->getPersonasAsociadas());


  var tipoPersoneriaSeleccionada = {};
  $(document).ready(function(){
      $(".loader").fadeOut("slow");
      mostrarDivRUC();
      actualizarTipoDocumento({{$organizacion->codTipoDocumento}});

      actualizarTieneActividadEconomica({{$organizacion->tiene_act_economica}});
      
      if(tiene_enlace)
        changedUnidadProductivaEnlazada();
      /* Para darle tiempo al navegador que renderice el Select2 de bootstrap */
      setTimeout(() => {

        
        actualizarTieneEnlaceCite(tiene_enlace);
        
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

      confirmar('¿Está seguro de actualizar la Organización?','info','frmOrganizacion');

  }











  var usuariosAsociados = @php echo $organizacion->getPersonasAsociadas() @endphp

  /* MINICRUD EN MODAL PARA AGREGAR SOCIOS */

  var listaPersonasAAgregar = [];

  function agregarUsuario(){

      msjError = validarPersona();
      if(msjError!=""){
          alerta(msjError);
          return;
      }


      dni = document.getElementById('usuario_dni').value;
      telefono = document.getElementById('telefono').value;
      correo = document.getElementById('correo').value;
      nombres = document.getElementById('nombres').value;
      apellido_paterno = document.getElementById('apellido_paterno').value;
      apellido_materno = document.getElementById('apellido_materno').value;
      fecha_nacimiento = document.getElementById('fecha_nacimiento').value;
      sexo = document.getElementById('sexo').value;
      cargo = document.getElementById('cargo').value;

     
      var persona = {
          dni,telefono,correo,nombres,apellido_paterno,apellido_materno,
          fecha_nacimiento,sexo,cargo
      };
      agregarObjPersona(persona);
  }

  function agregarObjPersona(persona){

      listaPersonasAAgregar.push(persona);
      limpiarFormModal();
      paintUserListOnTable();
  }

  function validarPersona(){

      msj = "";
      limpiarEstilos(['usuario_dni','nombres','telefono','apellido_materno','correo','apellido_paterno','fecha_nacimiento','sexo','cargo'])

      msj = validarTamañoExacto(msj,'usuario_dni',8,'DNI')

      msj = validarTamañoMaximoYNulidad(msj,'nombres',200,'nombres')
      msj = validarTamañoMaximoYNulidad(msj,'apellido_paterno',200,'apellido_paterno')
      msj = validarTamañoMaximoYNulidad(msj,'apellido_materno',200,'apellido_materno')

      msj = validarTamañoMaximoYNulidad(msj,'fecha_nacimiento',200,'Fecha de Nacimiento')
      msj = validarTamañoMaximoYNulidad(msj,'cargo',200,'Cargo en la organización')
      msj = validarSelect(msj,'sexo',"",'Sexo');
       
      msj = validarTamañoMaximo(msj,'telefono',20,"Teléfono");
      msj = validarTamañoMaximo(msj,'correo',30,"Correo");
      

      msj = validarQueYaEstaEnLaOrg(msj);

      return msj;
  }

  function validarQueYaEstaEnLaOrg(msj_error){
      if(msj_error!="")
        return msj_error;

      
      //verificamos que no esté ya en la org
      var dni = document.getElementById('usuario_dni').value;
      var listaDNIiguales = PersonasAsociadas.filter(e => e.dni == dni);
      console.log(listaDNIiguales);

      if(listaDNIiguales.length!=0)
          return "La persona de DNI " + dni +" ya se encuentra en organización actual, no es necesario añadir."

      
      return "";
  }

  function limpiarFormModal(){
      document.getElementById('usuario_dni').value = "";
      document.getElementById('telefono').value = "";
      document.getElementById('correo').value = "";
      document.getElementById('nombres').value = "";
      document.getElementById('apellido_paterno').value = "";
      document.getElementById('apellido_materno').value = "";

      document.getElementById('fecha_nacimiento').value = "";
      document.getElementById('sexo').value = "";
      document.getElementById('cargo').value = "";

  }

  function clickEditarUsuario(dni){
      var selectedUser = listaPersonasAAgregar.filter(e => e.dni == dni)[0]
      document.getElementById('usuario_dni').value = selectedUser.dni ;
      document.getElementById('telefono').value = selectedUser.telefono ;
      document.getElementById('correo').value = selectedUser.correo ;
      document.getElementById('nombres').value = selectedUser.nombres ;
      document.getElementById('apellido_paterno').value = selectedUser.apellido_paterno ;
      document.getElementById('apellido_materno').value = selectedUser.apellido_materno ;


      document.getElementById('fecha_nacimiento').value = selectedUser.fecha_nacimiento;
      document.getElementById('sexo').value = selectedUser.sexo;
      document.getElementById('cargo').value = selectedUser.cargo;

      //now we delete the user from the list
      listaPersonasAAgregar = listaPersonasAAgregar.filter(e => e.dni != dni)
      paintUserListOnTable();
  }

  var ListaSexos = @json($listaSexos)

  

  const PlantillaUsuarioAgregar = document.getElementById("plantilla_usuario_agregar");


  function paintUserListOnTable(){

      const tbody = document.getElementById('modal_UsersToAddList');
      var htmlTotal = "";
      for (let index = 0; index < listaPersonasAAgregar.length; index++) {
          const user = listaPersonasAAgregar[index];
          var nombreComp = user.nombres + " "+  user.apellido_paterno  + " "+ user.apellido_materno;

          var sexo_label = (ListaSexos.find(e => e.id  == user.sexo)).nombre;

           
          var htmlFila= PlantillaUsuarioAgregar.innerHTML;
          

          var hidrate_object = {
            DNI:user.dni,
            NombreCompleto:nombreComp,
            Correo:user.correo,
            Telefono:user.telefono,
            Sexo:sexo_label,
            FechaNacimiento:user.fecha_nacimiento,
            Cargo:user.cargo
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

      listaPersonasAAgregar = listaPersonasAAgregar.filter(e => e.dni != dniAEliminar)
      paintUserListOnTable();
  }
  

  function clickGuardarNuevosSocios(){
      if(listaPersonasAAgregar.length == 0){
        alerta("No ha insertado personas para agregar");
        return;
      }

      url = "/PPM/Organizacion/AñadirGrupoDeSocios";
      
      formData = {
          listaPersonasAAgregar,
          codOrganizacion : "{{$organizacion->getId()}}",
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
              console.log("redirigiendo")
              location.href = "{{route('PPM.Organizacion.Editar',$organizacion->getId())}}"
          }, 2500);

      })


  }









  async function consultarUsuarioPorDNI(){

    msjError="";

    msjError = validarTamañoExacto(msjError,'usuario_dni',8,'DNI');
    msjError = validarNulidad(msjError,'usuario_dni','DNI');


    if(msjError!=""){
        alerta(msjError);
        return;
    }


    dni = document.getElementById('usuario_dni').value;
    $(".loader").show();

    var response_persona = await $.get('/PPM/Personas/BuscarPorDni/'+dni).promise();

    console.log(response_persona);
    if(response_persona.encontrado){
        var persona = response_persona.persona;
         
        alertaExitosa("Encontrado","Persona '" + persona.nombres + "' encontrado en la base de datos de PPM.");

        document.getElementById('nombres').value =  persona.nombres;
        document.getElementById('apellido_paterno').value =  persona.apellido_paterno;
        document.getElementById('apellido_materno').value =  persona.apellido_materno;
        document.getElementById('telefono').value =  persona.telefono;
        document.getElementById('correo').value =  persona.correo;
        document.getElementById('fecha_nacimiento').value =  persona.fecha_nacimiento_formateada;
        
        

        $(".loader").fadeOut("slow");

        return;
    }

    var response_reniec = await $.get('/ConsultarAPISunat/dni/'+dni).promise();
    response_reniec = JSON.parse(response_reniec);

    console.log(response_reniec);
    persona = response_reniec.datos;

    alertaMensaje(response_reniec.mensaje,response_reniec.titulo,response_reniec.tipoWarning);
    if(response_reniec.ok==1){
        document.getElementById('nombres').value = persona.nombres;
        document.getElementById('apellido_paterno').value = persona.apellidoPaterno;
        document.getElementById('apellido_materno').value = persona.apellidoMaterno;
    }

    $(".loader").fadeOut("slow");

  }


  var codRelacionAEliminar = 0;
  function clickEliminarPersonaDeLaOrg(codRelacion){
      codRelacionAEliminar = codRelacion;
      confirmarConMensaje("Confirmación","¿Desea eliminar a la persona de la organización? (No se eliminará a la persona de la base de datos)","warning",ejecutarEliminacionPersonaDeOrganizacion)
  }

  function ejecutarEliminacionPersonaDeOrganizacion(){
      location.href ="/PPM/Organizacion/EliminarRelacionPersonaOrganizacion/" + codRelacionAEliminar;
  }


  /* 
    MODAL EIDTAR CARGO
  */

  const CARGO_NombrePersona = document.getElementById("editarcargo_nombrepersona"); 
  const CARGO_Cargo = document.getElementById("editarcargo_cargo"); 
  var codRelacionEditar = null;
 

  function clickEditarCargo(codRelacion,nombre_persona,cargo){
    CARGO_NombrePersona.value = nombre_persona;
    codRelacionEditar = codRelacion;
    CARGO_Cargo.value = cargo;
  }

  async function clickActualizarCargo(){

    if(CARGO_Cargo.value == ""){
      ponerEnRojo("editarcargo_cargo");
      alerta("Ingrese el nombre del cargo");
      return;
    }

    var datosAEnviar = {
      codRelacion:codRelacionEditar,
      cargo:CARGO_Cargo.value
    };

    var ruta = "/PPM/Organizacion/ActualizarCargo";
    $(".loader").show();



    var data = await $.post(ruta, datosAEnviar).promise();
    var objetoRespuesta = JSON.parse(data);

    alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);

    setTimeout(function(){
        $(".loader").fadeOut("slow");
        location.href = "{{route('PPM.Organizacion.Editar',$organizacion->getId())}}"
    }, 2500);
  }


</script>
  
  @include('PPM.Organizacion.OrganizacionReusableJS')

@endsection
