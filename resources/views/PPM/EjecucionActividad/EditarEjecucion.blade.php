@extends('Layout.Plantilla')

@section('titulo')
  Editar Actividad
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')
@php
  $file_uploader = new App\UI\FileUploader("nombresArchivos","filenames",10,true,"Subir archivos");
@endphp
<div class="col-12 py-2">
  <div class="page-title">
    Editar Actividad
  </div>
</div>
@include('Layout.MensajeEmergenteDatos')
<div class="card ">
    <div class="card-header">
        <div class="d-flex flex-row">
            <div class="">
                <h3 class="card-title">
                    <b>Información General</b>
                </h3>
            </div>
        </div>
    
    </div>
    <div class="card-body">

   
        <form method = "POST" action = "{{route('PPM.Actividad.Actualizar')}}" id="frmActividad" name="frmActividad"  enctype="multipart/form-data">
            <input type="hidden" name="codEjecucionActividad" id="codEjecucionActividad" value="{{$ejecucion->codEjecucionActividad}}">
            {{-- CODIGO DEL EMPLEADO --}}
            
            @csrf
            
            <div class="row  internalPadding-1 mx-2">
                <div class="col-sm-12">
                    <label for="codOrganizacion" id="" class="">
                        Organización:
                    </label>
                    
                    <input type="text" class="form-control" value=" {{$organizacion->getDenominacion()}} {{$organizacion->getRucODNI()}}" readonly>
                     
                </div>
                
                <div class="col-12">
                    <label for="codObjetivo" id="" class="">
                        Objetivo:
                    </label>
                   
                    <input type="text" class="form-control" value="{{$objetivo->indice}})  {{$objetivo->nombre}}" readonly>
                    
                </div>

                <div class="col-12">
                  <label for="codIndicador" id="" class="">
                      Indicador:
                  </label>
                  
                  <input type="text" class="form-control" value="{{$indicador->indice}}) {{$indicador->nombre}}" readonly>
                   
                </div>

                 
                <div class="col-12">
                  <label for="codActividad" id="" class="">
                      Cod Presupuestal y Actividad:
                  </label>

                  <select class="form-control"  id="codActividad" name="codActividad">
                    <option value="-1">- Actividad -</option>
                    @foreach($ejecucion->getActividad()->getIndicador()->getActividades() as $actividad)
                      <option value="{{$actividad->codActividad}}"  {{$actividad->isThisSelected($ejecucion->getActividad()->codActividad)}}>
                        {{$actividad->codigo_presupuestal}}) {{$actividad->descripcion_corta}}
                      </option>
                    @endforeach
                  </select>   
                    
                </div>
              
                 
                <div class="col-sm-12">
                    <label for="descripcion" id="" class="">
                        Descripción de la actividad:
                    </label>
                
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="2"
                    >{{$ejecucion->descripcion}}</textarea>

                </div>
 

  
               

                <div class="col-12 col-sm-4">
                    <label for="">Fecha Inicio:</label>
                    <input type="text" class="form-control text-center" value="{{$ejecucion->getFechaInicio()}}" readonly>
                    
                    
                    
                </div>

                <div class="col-12 col-sm-4">
                    <label for="">Fecha Fin:</label>
                    <input type="text" class="form-control text-center" value="{{$ejecucion->getFechaFin()}}" readonly>

                     

                </div>
                 
                <div class="col-sm-4">
                  <label for="">
                    Semestres:
                  </label>
                  <input type="text" class="form-control text-center" readonly value="{{$ejecucion->getResumenSemestres()}}">
                </div>

                {{App\ComponentRenderizer::LugarSelector('ComboBoxDistrito',$ejecucion->codDistrito)}}

            </div>

            

            
            <div class="row mt-2"> {{-- ARCHIVOS --}}
              <div class="col-sm-6">
                  {{$ejecucion->html_getArchivosDelServicio(true)}}
                  


              </div>
              <div class="col-sm-6">
                {{$file_uploader->render()}}
                <div class="">
                  <div class="d-flex">
                      
                    <a target="_blank" href="{{$link_drive}}" class="link-drive d-flex">
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
            </div>

            

            
            <div class="d-flex flex-row m-4">
               
                <div class="ml-auto">

                    <button type="button" class="btn btn-primary" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                        onclick="registrar()">
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
          <b>Lista de participantes</b>
      </h3>
  </div>
  <div class="card-body">
      <div class="row">

          <div class="col-12 row">
              <div class="col-6 align-self-end">
                  <label class="d-flex" for="">
                      Participantes:
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
                <thead class="table-marac-header">
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
                        <th class="text-left">
                            Correo
                        </th>
                        <th class="text-center">
                            Sexo
                        </th>
                        <th class="text-center">
                            Fecha Nacimiento
                        </th>
                        <th class="text-center">
                            ¿Externo?
                        </th>
                        <th class="text-center">
                            Opciones
                        </th>
                    </tr>
                </thead>
                <tbody id="container_participaciones">
                    

                </tbody>
            </table>

          </div>
      </div>



  </div>
</div>

  


<div class="row">
  <div class="col px-3">
    <a href="{{route('PPM.Actividad.Listar')}}" class='btn btn-info '>
      <i class="fas fa-arrow-left"></i> 
      Regresar al Menú
    </a>  
  </div>

</div>
 




{{-- MODAL DE AGREGAR ASOCIADOS --}}
<div class="modal  fade" id="ModalListaAsistencia" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">


              <div class="modal-header">
                  <h5 class="modal-title" id="">
                      Asistencia de socios / integrantes a la actividad
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body row">
                  <div class="col-12 row">
                      <div class="col-10">

                          
                          <input type="text" id="" title="Al escribir la tabla se actualiza" class="form-control" value="" placeholder="Buscar por nombre o dni"  oninput="updateBusquedaAsistencia(this.value)"> 

                      </div>
                       
                  </div>
                  <div class="col-12 row mt-2">
                      <div class="col-12 align-self-end">
                          <label class="d-flex" for="">
                              Personas pertenecientes a la org
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
                              @foreach($listaUsuariosYAsistencia as $persona)
                              
                                  <tr class="busqueda_personas" data-nombre="{{$persona->nombrecompleto_busqueda}} {{$persona->dni}}">
                                      <td class="pequeñaRow text-center">
                                        {{$i}}
                                      </td>
                                      <td class="pequeñaRow">
                                        <label for="CB_Asistencia_{{$persona->codPersona}}">
                                          {{$persona->getNombreCompleto()}}
                                        </label>
                                      </td>
                                      <td class="pequeñaRow text-center">
                                          <label for="CB_Asistencia_{{$persona->codPersona}}">
                                              {{$persona->dni}}
                                          </label>
                                      </td>
                                      <td class="pequeñaRow text-center">
                                          <input type="checkbox" class="cb_big cursor-pointer" id="CB_Asistencia_{{$persona->codPersona}}" {{$persona->asistencia ? 'checked' : ''}}

                                              onchange="clickCambiarAsistencia({{$persona->getId()}},this.checked)">

                                      </td>
                                  </tr>
                              @php
                                $i++;
                              @endphp
                              @endforeach

                                    
                              <tr>
                                <td id="noresultados" class="hidden text-center" colspan="4">
                                  No hay resultados
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
                      Agregar participantes a la ejecución de actividad
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">

                <div class="row px-2">


                    <form action="{{route('PPM.Actividad.AgregarAsistenciaExterna')}}" id="frmAgregarAsistenciaExterna" name="frmAgregarAsistenciaExterna"  method="POST">
                        @csrf
                        <input type="hidden" name="codEjecucionActividad" value="{{$ejecucion->codEjecucionActividad}}">
                        {{--  <div class="fontSize10 ">
                            Entiendase como usuario externo, quien no pertenece aún a la unidad productiva del servicio.
                        </div> --}}
                        <div class="mr-1 my-2 row">


                            <div class="col-sm-4">
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


                        </div>
                        <div class="mt-4">
                            <input class="cursor-pointer" type="checkbox" value="1" id="inscribirEnUnidad" name="inscribirEnUnidad" onchange="changeInscribirEnUnidad(this.checked)">
                            <label class="cursor-pointer" for="inscribirEnUnidad">
                                Inscribir en la organizacion/espacio como integrante
                            </label>
                        </div>

                        <div class="col-12 hidden" id="div_cargo">
                          <label for="">
                            Cargo en la organización
                          </label>
                          <input type="text" class="form-control" id="cargo_organizacion" placeholder="Cargo en la organización" name="cargo_organizacion" value="">

                        </div>
                        
                    </form>

                </div>
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
 
@include('Layout.EstilosPegados')
@include('Layout.ValidatorJS')
@section('script')
 
<script type="application/javascript">
  //se ejecuta cada vez que escogewmos un file
  var codPresupProyecto = -1;


  $(document).ready(function(){
      $(".loader").fadeOut("slow");

      actualizarTablaAsistencias({{$ejecucion->getId()}});



  });

  function registrar(){
      msje = validarFormulario('editar');
      if(msje!=""){
          alerta(msje);
          return false;
      }
      
      confirmar('¿Está seguro de actualizar la actividad?','info','frmActividad');
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
        limpiarEstilos(['dni','nombres','telefono','apellido_materno','correo','apellido_paterno','fecha_nacimiento','sexo'])

        msj = validarTamañoExacto(msj,'dni',8,'DNI')
        
        msj = validarTamañoMaximoYNulidad(msj,'nombres',200,'nombres')
        msj = validarTamañoMaximoYNulidad(msj,'apellido_paterno',200,'apellido_paterno')
        msj = validarTamañoMaximoYNulidad(msj,'apellido_materno',200,'apellido_materno')
        msj = validarTamañoMaximoYNulidad(msj,'fecha_nacimiento',15,'Fecha de nacimiento')
        msj = validarSelect(msj,'sexo',"",'Sexo');
       
        
        if(validarQueYaEsteEnElServicio() !="" )
            msj = validarQueYaEsteEnElServicio();


        return msj;
    }


    var usuariosDelServicio = @php echo $ejecucion->getPersonasQueAsistieron()  @endphp


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
        var data = await $.get('/PPM/Personas/BuscarPorDni/'+dni).promise();

        console.log(data);
        if(data.encontrado){
            var persona = data.persona;
            console.log("persona",persona)
            $(".loader").fadeOut("slow");
            alertaExitosa("Encontrado","Persona " + persona.nombres + " encontrado en la base de datos.");

            document.getElementById('nombres').value =  persona.nombres;
            document.getElementById('apellido_paterno').value =  persona.apellido_paterno;
            document.getElementById('apellido_materno').value =  persona.apellido_materno;
            document.getElementById('telefono').value =  persona.telefono;
            document.getElementById('correo').value =  persona.correo;


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
                    document.getElementById('apellido_paterno').value =  persona.apellidoPaterno;
                    document.getElementById('apellido_materno').value =  persona.apellidoMaterno;


                }

                $(".loader").fadeOut("slow");
            }
        );
    }










    /* MODAL LISTA DE ASISTENCIAS DE USUARIOS INTERNOS */
 
    var listaUsuariosYAsistencia = @php echo $listaUsuariosYAsistencia @endphp
 

  /* MODAL DE ASISTENCIA */
 

  function clickCambiarAsistencia(codPersona,new_value_asistencia){
    

    var ruta_update = "{{route('PPM.Actividad.GuardarAsistenciaInterna')}}";
    var datos = {
      codPersona:codPersona,
      codEjecucionActividad:{{$ejecucion->getId()}},
      new_value_asistencia:new_value_asistencia,
    };
    console.log("datos",datos)
     
    
    $(".loader").show();
    
    
    $.post(ruta_update, datos, function(dataRecibida){
      $(".loader").hide();
      
      
      var OBJ = JSON.parse(dataRecibida);
      if(OBJ.ok == "1"){
        mostrarNotificacion(OBJ.tipoWarning,OBJ.mensaje);
      }else{
        alertaMensaje(OBJ.titulo,OBJ.mensaje,OBJ.tipoWarning);

      }
      actualizarTablaAsistencias();
      
    });

    
  }

  function actualizarTablaAsistencias(){
    var ruta = "/PPM/Actividad/Inv_Participaciones/{{$ejecucion->getId()}}";
    Async_InvocarHtmlEnID(ruta,"container_participaciones");
    
  }


  function updateBusquedaAsistencia(string_busqueda){

    var ListaFilasPersonas = document.getElementsByClassName("busqueda_personas");

    string_busqueda = string_busqueda.toUpperCase();

    var hay_resultados = false;

    for (let index = 0; index < ListaFilasPersonas.length; index++) {
      const Fila = ListaFilasPersonas[index];
      var nombre_busqueda = Fila.getAttribute("data-nombre").toUpperCase();

      if(nombre_busqueda.includes(string_busqueda)){ //
        Fila.classList.remove("hidden");
        hay_resultados = true;
      }else{
        Fila.classList.add("hidden");
      }

    }

    const FilaNoResultados = document.getElementById("noresultados");
    if(hay_resultados){
      FilaNoResultados.classList.add("hidden");
    }else{
      FilaNoResultados.classList.remove("hidden");
    }


  }






    /* CRUD USUARIOS DEL SERVICIO PERO RENDERIZADO EN EL SERV POR PHP */

    var codParticipacionAEliminar = 0;
    function clickEliminarParticipacion(codRelacion){
        codParticipacionAEliminar = codRelacion;
        confirmarConMensaje("Confirmación","¿Desea eliminar la participación?","warning",ejecutarEliminacionParticipacion)
    }

    function ejecutarEliminacionParticipacion(){
        location.href ="/PPM/Actividad/EliminarParticipacion/" + codParticipacionAEliminar;
    }


    /* Busqueda rapida x nombre y dni */

    function cambioUsuarioBuscado(newValue){
        

        codPersonaSeleccionado = newValue;
        actualizarBotonBusqueda();
    }

    var codPersonaSeleccionado = 0;

    function actualizarBotonBusqueda(){
        if(codPersonaSeleccionado == 0 || codPersonaSeleccionado == -1){
          return;
        }
        var relacion = listaUsuariosYAsistencia.find(e => e.codPersona == codPersonaSeleccionado);

        console.log("nuevaAsistencia de: " + codPersonaSeleccionado ,relacion.nuevaAsistencia);
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

 

      

</script>
  
 
@include('PPM.EjecucionActividad.EjecucionReusableJS')

@endsection
 
@section('estilos')
<style>
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
@endsection