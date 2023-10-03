@extends('Layout.Plantilla')

@section('titulo')
    CITE Servicios brindados
@endsection

@section('contenido')
@php

  $comp_filtros = new App\UI\UIFiltros(false,$filtros_usados);
  $comp_filtros->añadirFiltro([
      'name'=>'codEmpleadoCreador',
      'label'=>':',
      'show_label'=>false,
      'placeholder'=>'Buscar por usuario que registró',
      'type'=>'select2',
      'function'=>'equals',
      'options'=>$listaEmpleados,
      'options_label_field'=>'nombreCompleto',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'',
  ]);
  $comp_filtros->añadirFiltro([
      'name'=>'codDistrito',
      'label'=>'Región',
      'show_label'=>false,
      'placeholder'=>'- Buscar por Región -',
      'type'=>'select2',
      'function'=>'in_departamento',
      'options'=>$listaDepartamentos,
      'options_label_field'=>'nombre',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'250px',
  ]);
  $comp_filtros->añadirFiltro([
      'name'=>'codUnidadProductiva',
      'label'=>'Unidad productiva',
      'show_label'=>false,
      'placeholder'=>'- Buscar por unidad productiva -',
      'type'=>'select2',
      'function'=>'equals',
      'options'=>$todasLasUnidadesProduc,
      'options_label_field'=>'razonYRUC',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'250px',     
  ]);
 
  $servicios_pendientes = $empleadoLogeado->getServiciosPendientesDeTerminar();

@endphp

@section('tiempoEspera')
  <div class="loader" id="pantallaCarga"></div>
@endsection
<div class="card-body">

    <div class="well">
        <H3 style="text-align: center;">
            <strong>
                Servicios brindados
            </strong>
        </H3>
    </div>
    <div class="row">
        <a href="{{route('CITE.Servicios.Crear')}}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Nuevo Servicio
        </a>

    </div>
    <div class="row d-flex flex-row m-2">

        {{$comp_filtros->render()}}
     

        @if(App\Empleado::getEmpleadoLogeado()->puedeGenerarReportesCITE())
            <div class="ml-auto">
              <button type="button" id="" class="btn btn-sm btn-success " data-toggle="modal" data-target="#ModalExportarExcel">
                <i class="fas fa-file-excel"></i>
                Exportar Servicios
              </button>
            </div>

            <div class="ml-1">
              <button type="button" id="" class="btn btn-sm btn-success " data-toggle="modal" data-target="#ModalExportarHitos">
                <i class="fas fa-file-excel"></i>
                Exportar Hitos
              </button>
            </div>
            <div class="ml-1">
              <button type="button" id="" class="btn btn-sm btn-success " data-toggle="modal" data-target="#ModalArchivosActividades">
                <i class="far fa-copy"></i>
                Archivos de Actividades
              </button>
            </div>
        @endif

    </div>
        @include('Layout.MensajeEmergenteDatos')

        @php
          $i = 1;
        @endphp
        @if(count($servicios_pendientes) != 0)
          <div class="msj_alerta_servicios_pendientes">
            Tiene los siguientes servicios pendientes de completar: 
            @foreach($servicios_pendientes as $servicio)
              <a target="_blank" href="{{route('CITE.Servicios.Editar',$servicio->getId())}}">
                {{$servicio->getId()}}
              </a>
              @if(count($servicios_pendientes) != $i)
                ,
              @endif
              @php
                $i++;
              @endphp
            @endforeach
          </div>
        @endif
 
        <table class="table table-bordered table-hover datatable fontSize10" id="table-3">
          <thead>
              <tr>
              <th>Cod</th>
              <th>Descripcion</th>
              <th>Unidad Productiva</th>
              <th>Mes</th>

              <th class="text-center">Lugar</th>
              <th>Cantidad / Tipo acceso</th>
              <th>Tipo Servicio</th>
              <th>Convenio?</th>
              <th>Creado por</th>
              <th>Opciones</th>


              </tr>
          </thead>
          <tbody>

              @foreach($listaServicios as $servicio)
                @php
                  $esta_pendiente_subir_archivos = $servicio->faltanArchivosPorSubir();
                @endphp
                  <tr class="FilaPaddingReducido @if($esta_pendiente_subir_archivos) pendiente_subir_archivos @endif" @if($esta_pendiente_subir_archivos) title="{{$servicio->getMensajeArchivosFaltantes()}}" @endif>
                      <td>
                          {{$servicio->getId()}}
                      </td>
                      <td class="fontSize9">
                          {{$servicio->descripcion}}
                      </td>
                      <td class="fontSize10">
                          {{$servicio->getUnidadProductiva()->getDenominacion()}}
                          [{{$servicio->getUnidadProductiva()->getRucODNI()}}]

                      </td>
                      <td>
                          {{$servicio->getMesAño()->getTexto()}}
                        
                      </td>

                      <td class="text-center">
                          {{$servicio->getTextoLugar()}}
                      </td>
                      <td>
                          <b>
                              {{$servicio->cantidadServicio}}
                          </b>
                          /
                          {{$servicio->getTipoAcceso()->nombre}}
                      </td>
                      <td>
                          {{$servicio->getTipoServicio()->nombre}}
                      </td>
                      <td>
                          {{$servicio->getTextoModalidadConConvenio()}}
                      </td>
                      <td class="fontSize9">
                        {{$servicio->getEmpleadoCreador()->getNombreCompleto()}}
                      <br>
                      <span class="fontSize7">
                          {{$servicio->getFechaHoraCreacion()}}
                      </span>
                      </td>
                      <td>
                          <a href="{{route('CITE.Servicios.Ver',$servicio->getId())}}" class='btn btn-info btn-sm' title="Ver Unidad Productiva">
                              <i class="fas fa-eye"></i>
                          </a>




                          <a href="{{route('CITE.Servicios.Duplicar',$servicio->getId())}}" class = "btn btn-sm btn-info m-1"
                              title="Duplicar Servicio">
                              <i class="fas fa-copy"></i>
                          </a>




                          @if($servicio->sePuedeEliminar())
                              
                              <a href="{{route('CITE.Servicios.Editar',$servicio->getId())}}" class = "btn btn-sm btn-warning"
                                title="Editar Servicio">
                                <i class="fas fa-edit"></i>
                              </a>

                              <button type="button"  onclick="clickEliminarTotalmente({{$servicio->getId()}},'{{$servicio->descripcion}}')"  class = "btn btn-sm btn-danger"
                                  title="Eliminar Servicio">
                                  <i class="fas fa-trash"></i>
                              </button>


                          @endif


                      </td>


                  </tr>
              @endforeach
              @if(count($listaServicios)==0)
                  <tr>
                      <td colspan="10" class="text-center">
                          No hay resultados
                      </td>
                  </tr>
              @endif

          </tbody>
        </table>  
        <div class="m-1">
          {{$listaServicios->links()}}
        </div>



    </div>






<div class="modal  fade" id="ModalExportarExcel" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">
                        Reporte de servicios - Excel
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
                            <button class="m-1 btn btn-success" type="button" onclick="descargarReporteServicios()">
                                Descargar
                            </button>
                             

                        </div>

                    </div>



                </div>
        </div>
    </div>
</div>


<div class="modal  fade" id="ModalExportarHitos" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="">
                      Reporte de Hitos - Excel
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  {{-- Filtros --}}
                  <div class="row">
                       


                      <div class="col-12">
                          <label for="">
                              Limite de Fechas:
                          </label>
                          <div class="d-flex flex-row">

                              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">

                                  <input type="text" class="form-control text-center " placeholder="Fecha Inicio" name="reportehitos_fechaInicio" id="reportehitos_fechaInicio">
                                  <div class="input-group-btn">
                                      <button class="btn btn-primary date-set" type="button">
                                          <i class="fa fa-calendar"></i>
                                      </button>
                                  </div>
                              </div>


                              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                                  <input type="text" class="form-control text-center" placeholder="Fecha Fin" name="reportehitos_fechaFin" id="reportehitos_fechaFin">
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
                          <button class="m-1 btn btn-success" type="button" onclick="descargarReporteHitos()">
                              Descargar
                          </button>
                          

                      </div>

                  </div>



              </div>
      </div>
  </div>
</div>

<div class="modal  fade" id="ModalArchivosActividades" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="">
                      Reporte de archivos por actividades
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                   
                  <div class="row">
                    <div class="col-sm-4">
                      <label for="">
                        Modalidad
                      </label>
                      <input class="form-control" type="text" value="CON CONVENIO DE DESEMPEÑO" readonly>
                    </div>

                    <div class="col-sm-8">
                      <label for="">
                          Limite de Fechas:
                      </label>
                      <div class="d-flex flex-row">

                          <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">

                              <input type="text" class="form-control text-center " placeholder="Fecha Inicio" name="reportearchivos_fechaInicio" id="reportearchivos_fechaInicio">
                              <div class="input-group-btn">
                                  <button class="btn btn-primary date-set" type="button">
                                      <i class="fa fa-calendar"></i>
                                  </button>
                              </div>
                          </div>


                          <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                              <input type="text" class="form-control text-center" placeholder="Fecha Fin" name="reportearchivos_fechaFin" id="reportearchivos_fechaFin">
                              <div class="input-group-btn">
                                  <button class="btn btn-primary date-set" type="button">
                                      <i class="fa fa-calendar"></i>
                                  </button>
                              </div>
                          </div>

                      </div>

                    </div>

                    <div class="col-sm-6">
                      <label for="">
                        Tipo de Servicio
                      </label>
                      <select class="form-control" name="codTipoServicio" id="codTipoServicio" onchange="changeTipoServicio(this.value)">
                        <option value="-1">- Seleccionar -</option>
                        @foreach ($listaTiposServicio as $tipo_serv)
                          <option value="{{$tipo_serv->getId()}}">
                            {{$tipo_serv->nombre}}
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
                          
                      </select>
                    </div>



                    
 
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-12 text-right">
                      <button class="btn btn-sm btn-success" type="button" onclick="clickGenerarComprimido()">
                        Buscar Servicios
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>

                  <div class="row mt-4">
                    <div class="col-sm-12">
                      <label class="mb-0" for="">
                        Servicios a exportar:
                      </label>
                    </div>
                    
                    <div class="col-sm-12">
                      
                      <table class="table table-bordered table-hover datatable fontSize10">
                        <thead class="table-marac-header">
                            <tr>
                              <th>Cod</th>
                              <th>Descripcion</th>
                              <th>Unidad Productiva</th>
                              <th>Tipo Servicio</th>
                              <th>
                                Tiene Archivos Exportables
                              </th>
                              <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_servicios_coincidentes">
                          <tr>
                            <td colspan="10" class="text-center">
                                No hay resultados
                            </td>
                          </tr>
                        </tbody>
                      </table>

                    </div>

                  </div>

                  <div class="row d-flex flex-row">
                      <div class="ml-auto">
                          

                      </div>

                  </div>



              </div>
      </div>
  </div>
</div>







<a id="botonDescarga" href="" class="hidden">
  Boton real de descarga
</a>

@endsection
@section('script')
 
<script>


    $(document).ready(function(){
      $(".loader").fadeOut("slow");
        
    });

    function clickEliminarTotalmente(codServicio,nombre){
        confirmarConMensaje("Confirmación","¿Desea eliminar el servicio \""+nombre+"\" ?",'warning',function(){
            location.href = "/CITE/eliminarTotalmente/" + codServicio;
        })
    }



    function validarReporteServicios(){
        limpiarEstilos(['reporte_codModalidad','reporte_fechaInicio','reporte_fechaFin'])
        msj = "";

        msj = validarSelect(msj,'reporte_codModalidad',-1,'Modalidad');


        msj = validarNulidad(msj,'reporte_fechaInicio','Fecha inicial');
        msj = validarNulidad(msj,'reporte_fechaFin','Fecha Final');


        return msj;
    }

    function descargarReporteServicios(){
        msjError = validarReporteServicios();
        if(msjError!=""){
            alerta(msjError);
            return;
        }


        codModalidad = document.getElementById('reporte_codModalidad').value;
        fechaInicio = document.getElementById('reporte_fechaInicio').value;
        fechaFin = document.getElementById('reporte_fechaFin').value;


        var url = "/Cite/Servicios/ExportarExcel?"
            +"codModalidad="+codModalidad

        url +=  "&fechaInicio="+fechaInicio+
                "&fechaFin="+fechaFin;


        console.log("Link consulta:",url)
        var link = document.getElementById("botonDescarga");
        link.setAttribute("href", url);
        link.click();
    }


    function validarReporteHitos(){
      limpiarEstilos(['reportehitos_fechaInicio','reportehitos_fechaFin'])
        msj = "";
        msj = validarNulidad(msj,'reportehitos_fechaInicio','Fecha inicial');
        msj = validarNulidad(msj,'reportehitos_fechaFin','Fecha Final');


        return msj;
    }

    function descargarReporteHitos(){
        msjError = validarReporteHitos();
        if(msjError!=""){
            alerta(msjError);
            return;
        }

 
        fechaInicio = document.getElementById('reportehitos_fechaInicio').value;
        fechaFin = document.getElementById('reportehitos_fechaFin').value;

        var url = "/Cite/Servicios/DescargarReporteHitos?"

        url +=  "fechaInicio="+fechaInicio+
                "&fechaFin="+fechaFin;

        console.log("Link consulta:",url)
        var link = document.getElementById("botonDescarga");
        link.setAttribute("href", url);
        link.click();
    }

    const TipoMedioVerificacion = document.getElementById("codTipoMedioVerificacion");


    function validarFormArchivos(){
      limpiarEstilos(['reportearchivos_fechaInicio','reportearchivos_fechaFin','codActividad','codTipoServicio'])
      
      msj = "";
      msj = validarNulidad(msj,'reportearchivos_fechaInicio','Fecha inicial');
      msj = validarNulidad(msj,'reportearchivos_fechaFin','Fecha Final');
      msj = validarSelect(msj,'codActividad',"-1",'Actividad');
      msj = validarSelect(msj,'codTipoServicio',"-1",'Tipo de Servicio');
      

      return msj;
    }


    
    const RA_TipoServicio = document.getElementById("codTipoServicio");
    const RA_Actividad = document.getElementById("codActividad");
    
    const RA_FechaInicio = document.getElementById("reportearchivos_fechaInicio");
    const RA_FechaFin = document.getElementById("reportearchivos_fechaFin");
    
    const FilaVaciaServiciosCoincidentes = `
        <tr>
        <td colspan="6" class="text-center">
            No hay resultados
        </td>
      </tr>
    `;

    async function clickGenerarComprimido(){
      document.getElementById("tabla_servicios_coincidentes").innerHTML = FilaVaciaServiciosCoincidentes;

      msj = validarFormArchivos();
      if(msj != ""){
        alerta(msj)
        return;
      }

      $(".loader").show();
      
      var url = "/Cite/Servicios/GenerarComprimidoDeArchivos?";
      url += 
      "codActividad="+RA_Actividad.value+
      "&fecha_inicio="+RA_FechaInicio.value+
      "&fecha_fin="+RA_FechaFin.value;
      
      var data = await $.get(url).promise();
      
      
      data = JSON.parse(data);
      console.log("data",data)

      if(data.ok == 1){
        var nombre_archivo = data.mensaje;
        var tabla_servicios_html = data.datos;
        document.getElementById("tabla_servicios_coincidentes").innerHTML = tabla_servicios_html;

      }else{
        alertaMensaje(data.titulo,data.mensaje,data.tipoWarning);
      }
      $(".loader").hide("slow");
    }

    

    var listaActividades = @json($listaActividades)

    const ComboActividad = document.getElementById("codActividad");

    function changeTipoServicio(codTipoServicio){

        var listaDisponible = listaActividades.filter(e=>e.codTipoServicio == codTipoServicio);
        console.log("listaDisponible",listaDisponible)
        
        cadenaHTML = `<option value="-1" selected> - Actividad - </option>`;
        for (let index = 0; index < listaDisponible.length; index++) {
            const actividad = listaDisponible[index];
            
            cadenaHTML = cadenaHTML + 
            `
            <option value="`+actividad.codActividad+`">
                `+actividad.indice + " "  + actividad.nombre +`
            </option>   
            `;
        }
        ComboActividad.innerHTML = cadenaHTML;    
    }
        
</script>
@endsection

@section('estilos')
<style>
  .pendiente_subir_archivos{
    background-color: #ffd5d5;
  }
  .pendiente_subir_archivos:hover{
    background-color: #ffc2c2 !important;
  }

  .msj_alerta_servicios_pendientes{
    text-align: center;
    background-color: #ffb1b1;
    padding: 5px 10px;
    color: black;
    margin-bottom: 5px;
    border-radius: 5px;
  }
  .msj_alerta_servicios_pendientes a{
    text-decoration: none;
    color: black;
    font-weight: 800;
  }
  .msj_alerta_servicios_pendientes a:hover{
    
    color: rgb(0 86 152);
  
  }
  

</style>
@endsection