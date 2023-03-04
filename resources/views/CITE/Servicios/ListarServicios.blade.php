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

  $comp_filtros->añadirFiltro([
      'name'=>'codMesAño',
      'label'=>':',
      'show_label'=>false,
      'placeholder'=>'Buscar por mes',
      'type'=>'select',
      'function'=>'equals',
      'options'=>$listaMesAño,
      'options_label_field'=>'texto',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'',
  ]);
  

@endphp

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

            <button type="button" id="" class="btn btn-sm btn-success ml-auto" data-toggle="modal" data-target="#ModalExportarExcel">
                <i class="fas fa-file-excel"></i>
                Exportar
            </button>
        @endif

    </div>
        @include('Layout.MensajeEmergenteDatos')

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
                <tr class="FilaPaddingReducido">
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
                        {{-- {{$servicio->getFechaInicio()}} // {{$servicio->getFechaTermino()}} --}}
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
@include('Layout.ValidatorJS')
<script>


    function clickEliminarTotalmente(codServicio,nombre){
        confirmarConMensaje("Confirmación","¿Desea eliminar el servicio "+nombre+" ?",'warning',function(){
            location.href = "/CITE/eliminarTotalmente/" + codServicio;
        })
    }



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


        var url = "/Cite/Servicios/ExportarExcel?"
            +"codModalidad="+codModalidad

        url +=  "&fechaInicio="+fechaInicio+
                "&fechaFin="+fechaFin;


        console.log("Link consulta:",url)
        var link = document.getElementById("botonDescarga");
        link.setAttribute("href", url);
        link.click();
    }




</script>
@endsection
