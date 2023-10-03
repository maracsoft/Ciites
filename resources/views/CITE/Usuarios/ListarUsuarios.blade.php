@extends('Layout.Plantilla')

@section('titulo')
   Usuarios del CITE
@endsection
@section('tiempoEspera')
    <div class="loader" id="pantallaCarga"></div>
@endsection
@section('contenido')

@php

  $comp_filtros = new App\UI\UIFiltros(false,$filtros_usados);

  
  $comp_filtros->añadirFiltro([
    'name'=>'dni',
    'label'=>'DNI:',
    'show_label'=>true,
    'placeholder'=>'Buscar por DNI',
    'type'=>'text',
    'function'=>'contains',
    'options'=>[],
    'options_label_field'=>'nombreCompleto',
    'options_id_field'=>null,
    'size'=>'sm',
    'max_width'=>'',
  ]);
  $comp_filtros->añadirFiltro([
    'name'=>'nombrecompleto_busqueda',
    'label'=>'Nombre',
    'show_label'=>true,
    'placeholder'=>'Buscar por nombre',
    'type'=>'text',
    'function'=>'contains',
    'options'=>[],
    'options_label_field'=>'nombre',
    'options_id_field'=>null,
    'size'=>'sm',
    'max_width'=>'250px',
  ]);
 

  

@endphp
<div class="p-2">
  
    <div class="well">
        <H3 style="text-align: center;">
            <strong>
                Usuarios del CITE  
            </strong>
        </H3>
    </div>
    @include('Layout.MensajeEmergenteDatos')
    <div class="row d-flex flex-row my-2">
        <div class="letraRoja ml-1"  >
          <b>
            El registro de usuarios se debe realizar en cada unidad productiva a la que estén asociados.
          </b>
        </div>
     
        @if(App\Empleado::getEmpleadoLogeado()->puedeGenerarReportesCITE())      
            
          <button type="button" id="" class="btn btn-sm btn-success ml-auto" data-toggle="modal" data-target="#ModalExportarExcel">
            <i class="fas fa-file-excel"></i>
            Exportar
          </button>
        @endif
        
    </div>
    {{$comp_filtros->render()}}
     

    <table class="table table-striped table-bordered table-condensed table-hover" >
        <thead  class="thead-default">
            <tr>
                <th>
                    ID
                </th>
                <th class="text-right">
                    DNI
                </th>
                <th class="text-left">
                    Nombre y Apellidos
                </th>
                <th class="text-right">
                    Teléfono
                </th>
                <th class="text-right">
                    Correo
                </th>
                <th class="text-center">
                  #Servicios
                </th>
                <th class="text-center">
                  #Unid Productivas
                </th>
            
                
                <th>
                    Opciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($listaUsuarios as $usuario )
                <tr class="FilaPaddingReducido">
                    <td>
                        {{$usuario->getId()}}
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
                        {{$usuario->getCantidadServicios()}}
                    </td>
                    <td  class="text-center">
                        {{$usuario->getCantidadUnidades()}}
                    </td>
                    <td class="text-center">
                        <a href="{{route('CITE.Usuarios.Ver',$usuario->getId())}}" class="btn btn-info btn-xs">
                            <i class="fas fa-eye"></i>
                        </a> 
                        <a href="{{route('CITE.Usuarios.Editar',$usuario->getId())}}" class="btn btn-warning btn-xs">
                            <i class="fas fa-pen"></i>
                        </a>
                        @if($usuario->usuarioLogeadoPuedeEliminar())

                          <button @if($usuario->apareceEnOtrasTablas()) disabled title="El usuario aparece en otras tablas" @endif type="button" class="btn btn-danger btn-xs" onclick="clickEliminar({{$usuario->getId()}},'{{$usuario->getNombreCompleto()}}')">
                            <i class="fas fa-trash"></i>
                          </button>
                        
                        @endif

                    </td>
                </tr>
            @endforeach
            

        </tbody>
    </table>
    
    
    
    {{$listaUsuarios->appends($filtros_usados_paginacion)->links()}}
    
    
</div>
  
 

<div class="modal  fade" id="ModalExportarExcel" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="">
                      Reporte de Usuarios - Excel
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  {{-- Filtros --}}
                  <div class="row">
                      <div  class="col-12">
                          <label for="reporte_codModalidad" id="" class="">
                              Modalidad:
                          </label>

                          <select class="form-control"  id="reporte_codModalidad" name="reporte_codModalidad">
                              <option value="-1">-- Modalidad --</option>
                              @foreach($listaModalidades as $modalidad)
                                  <option value="{{$modalidad->getId()}}">
                                      {{$modalidad->nombre}}
                                  </option>
                              @endforeach

                          </select>
                      </div>




                      <div class="col-12" id="divReporte_rango" >
                          <label for="">
                              Limite de Fechas:
                          </label>
                          <div class="d-flex flex-row">

                              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">

                                  <input type="text" class="form-control text-center " placeholder="Fecha Inicio" name="reporte_fechaInicio" id="reporte_fechaInicio">
                                  <div class="input-group-btn">
                                      <button class="btn btn-primary date-set" type="button">
                                          <i class="fa fa-calendar"></i>
                                      </button>
                                  </div>
                              </div>


                              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                                  <input type="text" class="form-control text-center" placeholder="Fecha Fin" name="reporte_fechaFin" id="reporte_fechaFin">
                                  <div class="input-group-btn">
                                      <button class="btn btn-primary date-set" type="button">
                                          <i class="fa fa-calendar"></i>
                                      </button>
                                  </div>
                              </div>

                          </div>

                      </div>
                  </div>

                  <div class="row d-flex flex-row">
                      <div class="ml-auto">
                          <button class="m-1 btn btn-success" type="button" onclick="descargarReporte()">
                              Descargar
                          </button>
                          <a id="botonDescarga" href="" class="hidden">
                              Boton real de descarga
                          </a>

                      </div>

                  </div>



              </div>
      </div>
  </div>
</div>


@endsection


@section('script')
 
<script>

    
    $(document).ready(function(){

    

      $(".loader").fadeOut("slow");
    });

    function validarReporte(){
        limpiarEstilos(['reporte_codModalidad','reporte_fechaInicio','reporte_fechaFin'])
        msj = "";

        msj = validarSelect(msj,'reporte_codModalidad',-1,'Modalidad');


        msj = validarNulidad(msj,'reporte_fechaInicio','Fecha inicial');
        msj = validarNulidad(msj,'reporte_fechaFin','Fecha Final');


        return msj;
    }

    function descargarReporte(){
        msjError = validarReporte();
        if(msjError!=""){
            alerta(msjError);
            return;
        }


        codModalidad = document.getElementById('reporte_codModalidad').value;
        fechaInicio = document.getElementById('reporte_fechaInicio').value;
        fechaFin = document.getElementById('reporte_fechaFin').value;


        var url = "/Cite/Usuarios/ExportarExcel?"
            +"codModalidad="+codModalidad

        url +=  "&fechaInicio="+fechaInicio+
                "&fechaFin="+fechaFin;


        console.log("Link consulta:",url)
        var link = document.getElementById("botonDescarga");
        link.setAttribute("href", url);
        link.click();
    }
  
  

    var codUsuarioEliminar = 0;
    function clickEliminar(codUsuario,nombre){
      codUsuarioEliminar = codUsuario;
      confirmarConMensaje("Confirmación","¿Desea eliminar al usuario "+nombre+" de la base de datos?",'warning',ejecutarEliminar)
    }

    function ejecutarEliminar(){
      //llamamos a un endpoint modo API y luego recargamos la página (para no perder la busqueda y paginacion actual)
      $(".loader").show();
      $.get('/Cite/Usuarios/'+codUsuarioEliminar+'/Eliminar',function(data){
        
        data = JSON.parse(data);

        alertaMensaje(data.titulo,data.mensaje,data.tipoWarning);
       
        setTimeout(function(){
          location.reload();
        }, 3000);


        
      });

    }
 
</script>

@endsection