@extends('Layout.Plantilla')

@section('titulo')
  Añadir productos
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')
@include('Layout.MensajeEmergenteDatos')

@php
  $file_uploader = new App\UI\FileUploader("nombresArchivos","filenames",10,true,"Seleccione archivos");
@endphp

<div class="row">
 

  <div class="col-12 py-2">
    <div class="page-title">
      Añadir productos
    </div>
  </div>

  <div class="col-sm-8">
    <div class="card">
      <div class="card-body">
        <div class="row">


          <div class="col-sm-9">
            <label for="">
              Organización:
            </label>
            <input type="text" class="form-control" value="{{$organizacion->razon_social}}" readonly>
          </div>
          <div class="col-sm-3">
            <label for="">
              RUC:
            </label>
            <input type="text" class="form-control" value="{{$organizacion->ruc}}" readonly>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">

        
          <label for="">
            Semestre:
          </label>
          <input type="text" class="form-control text-center" value="{{$semestre->getTexto()}}" readonly>
 

      </div>
    </div>
  </div>
 
  
  
</div>


 
 
<div class="card">
  <div class="card-header ui-sortable-handle cursor-move">
    <div class="d-flex flex-row">
      <div class="">
          <h3 class="card-title">
              <b>Productos Actuales</b>
          </h3>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div id="">

      <div class="row">
        <div class="col-sm-12 text-right">
          <button class="btn btn-success" data-toggle="modal" data-target="#ModalAgregarProductos">
            <i class="fas fa-plus mr-1"></i>
            Añadir Productos
          </button>
        </div>
      </div>
      <div class="table-responsive my-2">
              
        <table class="table table-bordered datatable fontSize10" id="tabla_productos">
          <thead class="table-marac-header">
              <tr class="desktop_tr">
                
                <th class="align-middle text-center" rowspan="2">
                  Producto
                  
                </th>
                <th class="align-middle text-center" rowspan="1" colspan="2">Numero de unidades de producción</th>
                <th class="align-middle text-center" rowspan="2">Personas directamente involucradas (socios que procesan o trabajadores/as)</th>
      
                <th class="align-middle text-center"  colspan="2" class="text-center">
                  Producción total por unidad de producción
                </th>
              
                <th class="align-middle" colspan="2">
                  Producción total comercializada
                </th>
                <th class="align-middle" rowspan="2">
                  Precio de venta por unidad en soles
                </th>
                <th class="align-middle" rowspan="2">
                  Costo de producción por unidad en soles
                </th>
                <th class="align-middle" rowspan="2">
                  Ingreso neto de la organización en junio 2022 (soles)
                </th>
                <th class="align-middle" rowspan="1" colspan="3">
                  Rendimiento promedio de la zona 
                </th>
                <th class="align-middle" rowspan="2">
                  Ingreso neto obtenido por la organización en el semestre (soles)
                </th>
                <th class="align-middle" colspan="2">
                  Rendimiento alcanzado el semestre
                </th>
               
                
                <th class="align-middle" rowspan="2">
                  Opciones
                </th>
                
              </tr>
              
              <tr class="desktop_tr">
                 
                <th class="align-middle">
                  Cant
                </th>
                <th class="align-middle">
                  Unid Medida
                </th>
                <th class="align-middle">
                  Cant
                </th>
                <th class="align-middle">
                  Unid Medida
                </th>
                <th class="align-middle">
                  Cant
                </th>
                <th class="align-middle">
                  Unid Medida
                </th>
                <th class="align-middle">
                  Rendimiento
                </th>
                <th class="align-middle">
                  Unid Medida
                </th>
                <th class="align-middle">
                  Fuente
                </th>
                <th class="align-middle">
                  Rendimiento
                </th>
                <th class="align-middle">
                  Unid Medida
                </th>
              </tr>

          </thead>
          <tbody>
            @forelse($listaDetalleProducto as $detalle)

              <tr class="fila_responsive mb-5 mb-sm-0">
                 
                <td class="">
                  <label class="aparecer_en_mobile" for="">
                    Producto:
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size" value="{{$detalle->getProducto()->nombre}}" readonly>
          
                 
          
                </td>
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Unidades de Producción - Cantidad
                  </label>  
                  <input type="text" class="form-control form-control-sm unidad_medida_size text-right" value="{{$detalle->NUP_cantidad}}" readonly>
                </td>
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Unidades de Producción - Unid Medida
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size" value="{{$detalle->NUP_unidad_medida}}" readonly >
                  
                </td>
                <td class="text-center">
                  <button  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalListaAsistencia_{{$detalle->getId()}}">
                    Ingresar
                  </button>
                </td>
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Prod total por unidad de producción - Cantidad
                  </label>
                  <input type="text" class="text-right form-control form-control-sm text-right"  value="{{$detalle->PTUP_cantidad}}" readonly>
          
                </td>
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Prod total por unidad de producción - Unid Medida
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size" value="{{$detalle->getUnidadMedida_PTUP()->nombre}}" readonly>
          
                  
                </td>
                <td class="bg_naranja_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Producción total comercializada - Cantidad
                  </label>
                  <input type="text" class="text-right form-control form-control-sm text-right" value="{{$detalle->PTC_cantidad}}"  readonly>
          
                </td>
                <td class="bg_naranja_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Producción total comercializada - Unid Medida
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size" readonly value="{{$detalle->getUnidadMedida_PTC()->nombre}}">
          
                </td>
                <td>
                  <label class="aparecer_en_mobile" for="">
                    P. Venta x Unid (Soles)
                  </label>
                  <input type="text" class="text-right form-control form-control-sm text-right" placeholder="Precio de Venta" value="{{number_format($detalle->pventa_unidad,2)}}"   readonly>
          
                </td>
                <td>
                  <label class="aparecer_en_mobile" for="">
                    Costo de producción Unitario (Soles)
                  </label>
                  <input type="text" class="text-right form-control form-control-sm text-right" placeholder="Costo de prod" value="{{number_format($detalle->costo_prod_unidad,2)}}" readonly>
          
                </td>
                <td>
                  <label class="aparecer_en_mobile" for="">
                    Ingreso Neto JUN-22
                  </label>
                  <input type="text" class="text-right form-control form-control-sm unidad_medida_size text-right" placeholder="Ingreso de la org en JUN22" value="{{number_format($detalle->ingreso_neto22,2)}}" readonly>
                </td>
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Rendimiento Promedio de la Zona
                  </label>
                  <input type="text" class="text-right form-control form-control-sm" placeholder="Rendimiento" value="{{$detalle->RZ_rendimiento}}"  readonly>
                </td>
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Rendimiento Promedio de la Zona - Unid Medida:
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size "  value="{{$detalle->RZ_unidad_medida}}" readonly> 
          
                </td>
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Rendimiento Promedio de la Zona - Fuente:
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size text-right" placeholder="Fuente" value="{{$detalle->RZ_fuente}}" readonly>
                </td>
                <td>
                  <label class="aparecer_en_mobile" for="">
                    Ingreso de la org en este semestre
                  </label>
                  <input type="text" class="text-right form-control form-control-sm text-right " placeholder="Ingreso en este semestre" value="{{number_format($detalle->ingreso_semestre,2)}}" readonly>
                </td>
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Rendimiento
                  </label>
                  <input type="text" class="text-right form-control form-control-sm text-right" placeholder="Rendimiento" value="{{$detalle->RS_rendimiento}}" readonly>
                </td>
                <td class="bg_celeste_mobile_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Unid Medida
                  </label>
          
                  <input type="text" class="form-control form-control-sm text-left"  placeholder="Rendimiento"  value="{{$detalle->RS_unidad_medida}}" readonly>
                  
                </td>

                
                

                <td class="text-center">
                  <button data-toggle="modal" data-target="#ModalDetalleProducto" type="button" class="btn btn-sm btn-info" onclick="clickEditarProducto({{$detalle->getId()}})">
                    <i class="fas fa-pen"></i>
                  </button>
                  <button  class="btn btn-danger btn-sm" onclick="clickEliminarProducto({{$detalle->getId()}})">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td class="text-center" colspan="18">
                  No hay productos
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>  

      </div>
    

    </div>

    
  </div>
</div>

 
<div class="d-flex">
  <a class="btn btn-info" href="{{route('PPM.SemestreOrganizacion.VerAñadirCultivoCadena',$relacion->getId())}}">
    <i class="fas fa-arrow-left mr-1"></i>
    Ir a Añadir Cultivo/Cadena
  </a>
</div>


{{-- PLANTILLAS PARA JS --}} 
<table class="hidden">
  <tbody id="plantilla_fila">
    <tr class="fila_responsive mb-5 mb-sm-0" id="fila_[codDetalleProducto]">
      <td class="table-marac-header text-center aparecer_en_mobile">
        #[codDetalleProducto]
      </td>
      <td class="text-right text-sm-center">
        <button class="btn btn-sm btn-danger" onclick="eliminarFila('[codDetalleProducto]')">
 
          <i class="fas fa-trash"></i>
        </button>
      </td>
      <td class="">
        <label class="aparecer_en_mobile" for="">
          Producto:
        </label>

 
        <input type="text" class="form-control form-control-sm unidad_medida_size producto_name" value="" readonly>
        
      </td>
      <td class="bg_celeste_mobile">
        <label class="aparecer_en_mobile" for="">
          Unidades de Producción - Cantidad
        </label>  
        <input type="number" class="text-right form-control form-control-sm" id="NUP_cantidad_[codDetalleProducto]" placeholder="Cantidad" value="[NUP_cantidad_value]">
      </td>
      <td class="bg_celeste_mobile">
        <label class="aparecer_en_mobile" for="">
          Unidades de Producción - Unid Medida
        </label>
        <input type="text" class="form-control form-control-sm unidad_medida_size" id="NUP_unidad_medida_[codDetalleProducto]">
         
      </td>
      
      <td class="bg_celeste_mobile">
        <label class="aparecer_en_mobile" for="">
          Prod total por unidad de producción - Cantidad
        </label>
        <input type="number" class="text-right form-control form-control-sm" id="PTUP_cantidad_[codDetalleProducto]" value="[PTUP_cantidad_value]">

      </td>
      <td class="bg_celeste_mobile">
        <label class="aparecer_en_mobile" for="">
          Prod total por unidad de producción - Unid Medida
        </label>
        <select class="form-control form-control-sm unidad_medida_size" id="PTUP_codUnidadMedida_[codDetalleProducto]" onchange="updatePTC_unidadMedida(this.value,'[codDetalleProducto]')" name="" id="">
          <option value="">- Unid Medida -</option>
          @foreach($listaUnidadesMedida as $unidad)
            <option value="{{$unidad->getId()}}">
              {{$unidad->nombre}}
            </option>
          @endforeach
        </select>
      </td>
      <td class="bg_naranja_mobile">
        <label class="aparecer_en_mobile" for="">
          Producción total comercializada - Cantidad
        </label>
        <input type="number" class="text-right form-control form-control-sm" id="PTC_cantidad_[codDetalleProducto]" value="[PTC_cantidad_value]" oninput="actualizarIngresoNetoSemestre('[codDetalleProducto]')">

      </td>
      <td class="bg_naranja_mobile">
        <label class="aparecer_en_mobile" for="">
          Producción total comercializada - Unid Medida
        </label>
        <input type="text" class="form-control form-control-sm unidad_medida_size" id="PTC_codUnidadMedida_[codDetalleProducto]"  readonly>
 
      </td>
      <td>
        <label class="aparecer_en_mobile" for="">
          P. Venta x Unid (Soles)
        </label>
        <input type="number" class="text-right form-control form-control-sm" placeholder="Precio de Venta" id="pventa_unidad_[codDetalleProducto]" value="[pventa_unidad_value]"  oninput="actualizarIngresoNetoSemestre('[codDetalleProducto]')">

      </td>
      <td>
        <label class="aparecer_en_mobile" for="">
          Costo de producción Unitario (Soles)
        </label>
        <input type="number" class="text-right form-control form-control-sm" placeholder="Costo de prod" id="costo_prod_unidad_[codDetalleProducto]" value="[costo_prod_unidad_value]" oninput="actualizarIngresoNetoSemestre('[codDetalleProducto]')">

      </td>
      <td>
        <label class="aparecer_en_mobile" for="">
          Ingreso Neto JUN-22
        </label>
        <input type="number" class="text-right form-control form-control-sm unidad_medida_size" id="ingreso_neto22_[codDetalleProducto]" placeholder="Ingreso de la org en JUN22" value="[ingreso_neto22_value]">
      </td>
      <td class="bg_celeste_mobile">
        <label class="aparecer_en_mobile" for="">
          Rendimiento Promedio de la Zona
        </label>
        <input type="number" class="text-right form-control form-control-sm" placeholder="Rendimiento" id="RZ_rendimiento_[codDetalleProducto]" value="[RZ_rendimiento_value]" >
      </td>
      <td class="bg_celeste_mobile">
        <label class="aparecer_en_mobile" for="">
          Rendimiento Promedio de la Zona - Unid Medida:
        </label>
        <input type="text" class="form-control form-control-sm unidad_medida_size "  id="RZ_unidad_medida_[codDetalleProducto]" value=""> 
 
      </td>
      <td class="bg_celeste_mobile">
        <label class="aparecer_en_mobile" for="">
          Rendimiento Promedio de la Zona - Fuente:
        </label>
        <input type="text" class="form-control form-control-sm unidad_medida_size" id="RZ_fuente_[codDetalleProducto]" placeholder="Fuente" value="[RZ_fuente_value]">
      </td>
      <td>
        <label class="aparecer_en_mobile" for="">
          Ingreso de la org en este semestre
        </label>
        <input type="number" class="text-right form-control form-control-sm text-right" placeholder="Ingreso en este semestre" id="ingreso_semestre_[codDetalleProducto]" value="[ingreso_semestre_value]" readonly>
      </td>
      <td class="bg_celeste_mobile">
        <label class="aparecer_en_mobile" for="">
          Rendimiento
        </label>
        <input type="number" class="text-right form-control form-control-sm" placeholder="Rendimiento" id="RS_rendimiento_[codDetalleProducto]" value="[RS_rendimiento_value]">
      </td>
      <td class="bg_celeste_mobile_mobile">
        <label class="aparecer_en_mobile" for="">
          Unid Medida
        </label>

        <input type="text" class="form-control form-control-sm" placeholder="Rendimiento" id="RS_unidad_medida_[codDetalleProducto]" value="[RS_unidad_medida_value]">
         
      </td>
    </tr>
  </tbody>
  <tfoot id="plantilla_fila_vacia">
    <tr id="fila_vacia_[codDetalleProducto]">
      <td class="text-center" colspan="18">
        Ingrese registros
      </td>
    </tr>
  </tfoot>
</table>


{{-- MODAL DE AGREGAR ASOCIADOS --}}
{{-- ES UNO POR CADA DETALLE_PRODUCTO --}}
@foreach($listaDetalleProducto as $detalle)
  @php
    $id = $detalle->getId();
    $listaUsuariosYAsistencia = $detalle->getSociosYAsistencia();
    $producto = $detalle->getProducto();

  @endphp
  <div class="modal  fade" id="ModalListaAsistencia_{{$id}}" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="">
              Personas directamente involucradas
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body row">
            <div class="row">
              <div class="col-sm-10">
                <label for="">
                  Organización:
                </label>  
                <input type="text" class="form-control" value="{{$organizacion->razon_social}}" readonly>
              </div>
              
              <div class="col-sm-2">
                <label for="">
                  Semestre:
                </label>  
                <input type="text" class="form-control" value="{{$semestre->getTexto()}}" readonly>
              </div>
              

              <div class="col-sm-6">
                <label for="">
                  Producto:
                </label>  
                <input type="text" class="form-control" value="{{$producto->nombre}}" readonly>
              </div>
              
              
              <div class="col-12">
                <div class="p-3">
               
                    <label for="">
                      Buscar por nombres o DNI
                    </label>
                    <input type="text" id="" class="form-control" title="Al escribir la tabla se actualiza" placeholder="Buscar por nombres o DNI" oninput="updateBusquedaAsistencia(this.value,{{$id}})">

                </div>
                <div class="col-2">
                
                </div>
              </div>
              
            
              
              <div class="col-12">
                <table class="table table-striped table-bordered table-condensed table-hover" >
                    <thead class="thead-default marac-header">
                        <tr>
                          <th class="text-center" colspan="4">
                            Usuarios de la organización
                          </th>
                        </tr>
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
                            <tr class="busqueda_personas_{{$id}}" data-nombre="{{$persona->nombrecompleto_busqueda}} {{$persona->dni}}">
                                <td class="pequeñaRow text-center">
                                  {{$i}}
                                </td>
                                <td class="pequeñaRow">
                                  <label >
                                    {{$persona->getNombreCompleto()}}
                                  </label>
                                </td>
                                <td class="pequeñaRow text-center">
                                    <label >
                                        {{$persona->dni}}
                                    </label>
                                </td>
                                <td class="pequeñaRow text-center">
                                    <input type="checkbox" class="cb_big cursor-pointer" {{$persona->asistencia ? 'checked' : ''}}
              
                                        onchange="clickCambiarAsistencia({{$persona->getId()}},{{$detalle->getId()}},this.checked)">
                                </td>
                            </tr>
                        @php
                          $i++;
                        @endphp
                        @endforeach
                          
                        <tr>
                          <td id="noresultados_{{$id}}" class="hidden text-center" colspan="4">
                            No hay resultados
                          </td>
                        </tr>
                    </tbody>
                </table>
              
              </div>

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

@endforeach


{{-- FORM INVISIBLE PARA ENVIAR --}}
<div class="hidden">

  <form action="{{route('PPM.SemestreOrganizacion.GuardarProductosDetalle')}}" method="POST" name="formGuardarDetalles">
    @csrf
    <input name="codRelacion" value="{{$relacion->codRelacion}}" type="text">
    <input name="lista_detalles_front" id="lista_detalles_front" type="text">
    <input name="lista_ids_detalles_eliminados" id="lista_ids_detalles_eliminados" type="text">
    <input type="text" name="codProductoSeleccionadoEnviar" id="codProductoSeleccionadoEnviar" value="{{$codProductoSeleccionado}}">

  </form>

</div>


<div class="modal  fade" id="ModalDetalleProducto" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" id="content_modal_productos">
    </div>
  </div>
</div>



<div class="modal fade " id="ModalAgregarProductos" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-2xl modal-dialog-centered">
    <div class="modal-content">


      <div class="modal-header">
        <h5 class="modal-title" id="">
          <b>Ingresar nuevos productos</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">




  
          
            <div id="">
              <div class="row">
                <div class="col-sm-4">
                  <label for="">
                    Producto:
                  </label>
        
                  <select class="form-control" name="codProductoSeleccionado" id="codProductoSeleccionado" onchange="actualizarNombreProductos()">
                    <option value="">
                      - Producto -
                    </option>
                    @foreach($listaProductos as $prod)
                      <option value="{{$prod->getId()}}" {{$prod->isThisSelected($codProductoSeleccionado)}}>
                        {{$prod->nombre}}
                      </option>
                    @endforeach
        
                  </select>
         
        
                </div>
        
                <div class="col-sm-8">
        
                  <div class="d-flex h-100">
                    <div class="ml-auto d-flex flex-column">
                      <button type="button" class="mt-auto btn btn-primary" onclick="clickNuevaFilaVacia()">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                    
                   
                  </div>
                </div>
        
              </div>
              
              <div class="table-responsive my-2">
                      
                <table class="table table-bordered datatable fontSize10" id="tabla_productos">
                  <thead class="table-marac-header">
                      <tr class="desktop_tr">
                        
                        <th class="align-middle text-center" rowspan="2">Eliminar</th>
        
                        <th class="align-middle text-center" rowspan="2">
                          Producto
                          
                        </th>
                        <th class="align-middle text-center" rowspan="1" colspan="2">Numero de unidades de producción</th>
                        
                        <th class="align-middle text-center"  colspan="2" class="text-center">
                          Producción total por unidad de producción
                        </th>
                      
                        <th class="align-middle" colspan="2">
                          Producción total comercializada
                        </th>
                        <th class="align-middle" rowspan="2">
                          Precio de venta por unidad en soles
                        </th>
                        <th class="align-middle" rowspan="2">
                          Costo de producción por unidad en soles
                        </th>
                        <th class="align-middle" rowspan="2">
                          Ingreso neto de la organización en junio 2022 (soles)
                        </th>
                        <th class="align-middle" rowspan="1" colspan="3">
                          Rendimiento promedio de la zona 
                        </th>
                        <th class="align-middle" rowspan="2">
                          Ingreso neto obtenido por la organización en el semestre (soles)
                        </th>
                        <th class="align-middle" colspan="2">
                          Rendimiento alcanzado el semestre
                        </th>
                        
                      </tr>
                      
                      <tr class="desktop_tr">
                         
                        <th class="align-middle">
                          Cant
                        </th>
                        <th class="align-middle">
                          Unid Medida
                        </th>
                        <th class="align-middle">
                          Cant
                        </th>
                        <th class="align-middle">
                          Unid Medida
                        </th>
                        <th class="align-middle">
                          Cant
                        </th>
                        <th class="align-middle">
                          Unid Medida
                        </th>
                        <th class="align-middle">
                          Rendimiento
                        </th>
                        <th class="align-middle">
                          Unid Medida
                        </th>
                        <th class="align-middle">
                          Fuente
                        </th>
                        <th class="align-middle">
                          Rendimiento
                        </th>
                        <th class="align-middle">
                          Unid Medida
                        </th>
                      </tr>
        
                  </thead>
                  <tbody id="tabla_body">
                    
                  </tbody>
                </table>  
        
              </div>
             
        
            </div>
        
             
        






      </div>
      <div class="modal-footer">
        <button type="button" class="ml-auto btn btn-success" onclick="clickGuardar()">
          <i class="fas fa-save mr-1"></i>
          Guardar
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Salir
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
 
 
@include('Layout.ValidatorJS')
@section('script') 

 
<script>


  const MostrarMensajeConfirmacion = @if (session('mostrar_confirmacion')) true @else false @endif
  
  const AbrirModalAlIniciar = @if (session('abrir_modal_inicial')) true @else false @endif
    
  @php
    session(['mostrar_confirmacion' => null]);
    session(['abrir_modal_inicial' => null]);
      
  @endphp


  const ListaProductos = @json($listaProductos);

  const ListaTipoProducto = @json($listaTipoProducto);

  const codTipoProducto_Producto = {{$codTipoProducto_Producto}};
  const codTipoProducto_CultivoCadena = {{$codTipoProducto_CultivoCadena}};
  

  var ModalAgregarProductos = new bootstrap.Modal(document.getElementById("ModalAgregarProductos"), {});
  
  $(document).ready(function(){
      
      updateMensajeTablaVacia();
      
      if(AbrirModalAlIniciar){
        ModalAgregarProductos.show();
      }else{
        if(MostrarMensajeConfirmacion){
          confirmarConMensajeYCancelar("¿Desea seguir añadiendo productos?","Marque SÍ para seguir añadiendo","info",function(){
          
            ModalAgregarProductos.show();
          },function(){
            
          })
        }
      }



      $(".loader").fadeOut("slow");
  });

 
 
 

  const TablaBody = document.getElementById("tabla_body"); 
  const PlantillaFila = document.getElementById("plantilla_fila");
  const PlantillaFilaVacia = document.getElementById("plantilla_fila_vacia");

  

  var cantidad_filas = 0;
  var filas_ids = [];

  function añadirFila(hidration_data){

    var html_string = hidrateHtmlString(PlantillaFila.innerHTML,hidration_data);
    TablaBody.insertAdjacentHTML('afterend', html_string);
    
    
    document.getElementById('NUP_unidad_medida_' + hidration_data.codDetalleProducto).value = hidration_data.NUP_unidad_medida_value; 
    document.getElementById('PTUP_codUnidadMedida_' + hidration_data.codDetalleProducto).value = hidration_data.PTUP_codUnidadMedida_value; 

    document.getElementById('RZ_unidad_medida_' + hidration_data.codDetalleProducto).value = hidration_data.RZ_unidad_medida_value; 
    document.getElementById('RS_unidad_medida_' + hidration_data.codDetalleProducto).value = hidration_data.RS_unidad_medida_value; 
    

    filas_ids.push(hidration_data.codDetalleProducto);
    cantidad_filas++;
    
    updateMensajeTablaVacia();
    

  }
  
  const ListaUnidadesMedida = @json($listaUnidadesMedida);


  function updatePTC_unidadMedida(nuevo_codUnidadMedida,codDetalleProducto){
    
    var unidad = ListaUnidadesMedida.find(e => e.codUnidadMedida == nuevo_codUnidadMedida);
    if(unidad){
      const LabelPTC_unidad = document.getElementById("PTC_codUnidadMedida_" + codDetalleProducto);
      LabelPTC_unidad.value = unidad.nombre;
    }else{
      console.log("updatePTC_unidadMedida Unidad no encontrada, " + nuevo_codUnidadMedida);
    }

    
  }

  
 
 
 

  function clickNuevaFilaVacia(){

    var new_id = "new_" + generateRandomStringDiferentID();

    

    var hidration_data = {
      codDetalleProducto: new_id,
      
      NUP_cantidad_value:"",
      PTUP_cantidad_value:"",
      PTC_cantidad_value:"",
      pventa_unidad_value:"",
      costo_prod_unidad_value:"",
      ingreso_neto22_value:"",
      RZ_rendimiento_value:"",
      RZ_fuente_value:"",
      
      NUP_unidad_medida_value:"",
      PTUP_codUnidadMedida_value:"",
      
      /* MODIFICADOS */

      PTC_codUnidadMedida_value:"",
      RZ_unidad_medida_value:"",
      RS_unidad_medida_value:"",
      ingreso_semestre_value:"",
      RS_rendimiento_value:"",


     
    };

    añadirFila(hidration_data);

    actualizarNombreProductos();
  }

  var ListaIdsEliminar = [];


  function eliminarFila(id){
    var elem = document.getElementById("fila_" + id);
    if(!id.includes("new")){
      ListaIdsEliminar.push(id);
    }

    elem.remove();
    
    cantidad_filas--;
    
    filas_ids = removeFromArray(filas_ids,id)

    updateMensajeTablaVacia();
    
  }




  function updateMensajeTablaVacia(){
    if(cantidad_filas == 0){
      var data = {
        codDetalleProducto:"renderized"
      };
      var html_string = hidrateHtmlString(PlantillaFilaVacia.innerHTML,data);
      
      TablaBody.insertAdjacentHTML('beforeend', html_string);
    }else{

      try {
        var elem = document.getElementById("fila_vacia_renderized");
        elem.remove();
      } catch (error) {
        
      }
    }
  }


  const Producto = document.getElementById("codTipoProducto");

  


  function getFinalData(){

    var final_data_array = [];

    for (let index = 0; index < filas_ids.length; index++) {
      const id = filas_ids[index];
      
      var NUP_cantidad_id =  "NUP_cantidad_" + id;
      var NUP_unidad_medida_id =  "NUP_unidad_medida_" + id;
      var PTUP_cantidad_id =  "PTUP_cantidad_" + id;
      var PTUP_codUnidadMedida_id =  "PTUP_codUnidadMedida_" + id;
      var PTC_cantidad_id =  "PTC_cantidad_" + id;
      var PTC_codUnidadMedida_id =  "PTC_codUnidadMedida_" + id;
      var pventa_unidad_id =  "pventa_unidad_" + id;
      var costo_prod_unidad_id =  "costo_prod_unidad_" + id;
      var ingreso_neto22_id =  "ingreso_neto22_" + id;
      var RZ_rendimiento_id =  "RZ_rendimiento_" + id;
      var RZ_unidad_medida_id =  "RZ_unidad_medida_" + id;
      var RZ_fuente_id =  "RZ_fuente_" + id;
      var ingreso_semestre_id =  "ingreso_semestre_" + id;
      var RS_rendimiento_id =  "RS_rendimiento_" + id;
      var RS_unidad_medida_id =  "RS_unidad_medida_" + id;

     

      const Field_NUP_Cantidad = document.getElementById(NUP_cantidad_id);
      const Field_NUP_UnidadMedida = document.getElementById(NUP_unidad_medida_id);
      const Field_PTUP_Cantidad = document.getElementById(PTUP_cantidad_id);
      const Field_PTUP_CodUnidadMedida = document.getElementById(PTUP_codUnidadMedida_id);
      const Field_PTC_Cantidad = document.getElementById(PTC_cantidad_id);
      const Field_PTC_CodUnidadMedida = document.getElementById(PTC_codUnidadMedida_id);
      const Field_PventaUnidad = document.getElementById(pventa_unidad_id);
      const Field_CostoProdUnidad = document.getElementById(costo_prod_unidad_id);
      const Field_IngresoNeto22 = document.getElementById(ingreso_neto22_id);
      const Field_RZ_Rendimiento = document.getElementById(RZ_rendimiento_id);
      const Field_RZ_UnidadMedida = document.getElementById(RZ_unidad_medida_id);
      const Field_RZFuente = document.getElementById(RZ_fuente_id);
      const Field_IngresoSemestre = document.getElementById(ingreso_semestre_id);
      const Field_RS_Rendimiento = document.getElementById(RS_rendimiento_id);
      const Field_RS_UnidadMedida = document.getElementById(RS_unidad_medida_id);
      
      var data_row = {
        codDetalleProducto : id,
        

        NUP_cantidad:Field_NUP_Cantidad.value,
        
        PTUP_cantidad:Field_PTUP_Cantidad.value,
        PTUP_codUnidadMedida:Field_PTUP_CodUnidadMedida.value,
        PTC_cantidad:Field_PTC_Cantidad.value,
        PTC_codUnidadMedida:Field_PTC_CodUnidadMedida.value,
        pventa_unidad:Field_PventaUnidad.value,
        costo_prod_unidad:Field_CostoProdUnidad.value,
        ingreso_neto22:Field_IngresoNeto22.value,
        RZ_rendimiento:Field_RZ_Rendimiento.value,
        RZ_fuente:Field_RZFuente.value,
        ingreso_semestre:Field_IngresoSemestre.value,
        RS_rendimiento:Field_RS_Rendimiento.value,

        RS_unidad_medida:Field_RS_UnidadMedida.value,
        NUP_unidad_medida:Field_NUP_UnidadMedida.value,
        RZ_unidad_medida:Field_RZ_UnidadMedida.value,
      }


      final_data_array.push(data_row);
    }


    return final_data_array;
  }


  const ListaDetalleProducto = @json($listaDetalleProducto);

  function añadirFilasExistentes(){
    
    for (let index = 0; index < ListaDetalleProducto.length; index++) {
      const detalle_prod = ListaDetalleProducto[index];
 
      var hidration_data = {
        codDetalleProducto: detalle_prod.codDetalleProducto.toString(),
        

        NUP_cantidad_value: detalle_prod.NUP_cantidad,
        PTUP_cantidad_value: detalle_prod.PTUP_cantidad,
        PTC_cantidad_value: detalle_prod.PTC_cantidad,
        pventa_unidad_value: detalle_prod.pventa_unidad,
        costo_prod_unidad_value: detalle_prod.costo_prod_unidad,
        ingreso_neto22_value: detalle_prod.ingreso_neto22,
        RZ_rendimiento_value: detalle_prod.RZ_rendimiento,
        RZ_fuente_value: detalle_prod.RZ_fuente,
        
        
        NUP_unidad_medida_value:detalle_prod.NUP_unidad_medida,
        PTUP_codUnidadMedida_value:detalle_prod.PTUP_codUnidadMedida,
        
        //se va a borrar
        PTC_codUnidadMedida_value:detalle_prod.PTC_codUnidadMedida,
        RZ_unidad_medida_value:detalle_prod.RZ_unidad_medida,
        RS_unidad_medida_value:detalle_prod.RS_unidad_medida,
        
        RS_rendimiento_value: detalle_prod.RS_rendimiento,

      };
      añadirFila(hidration_data);

      
 

    }


    for (let index = 0; index < ListaDetalleProducto.length; index++) {
      const detalle_prod = ListaDetalleProducto[index];

      updatePTC_unidadMedida(detalle_prod.PTUP_codUnidadMedida,detalle_prod.codDetalleProducto.toString());
      actualizarIngresoNetoSemestre(detalle_prod.codDetalleProducto.toString())
    }


  }

  
  const InputListaDetallesFront = document.getElementById("lista_detalles_front");
  const InputListaIdsDetallesEliminados = document.getElementById("lista_ids_detalles_eliminados");
  

  function clickGuardar(){
    var msj = "";
    msj = validarFilas();
    if(msj){
      alerta(msj);
      return;
    }

    confirmarConMensaje("Confirmación","¿Desea guardar?",'warning',ejecutarGuardado)

  }

  function ejecutarGuardado(){
    var final_data = getFinalData();
    InputListaDetallesFront.value = JSON.stringify(final_data);
    InputListaIdsDetallesEliminados.value = JSON.stringify(ListaIdsEliminar);

    document.formGuardarDetalles.submit();
  }

  function validarFilas(){
    msj = "";
    limpiarEstilos(["codProductoSeleccionado"]);
     
    msj = validarSelect(msj,"codProductoSeleccionado","","Producto");

    for (let index = 0; index < filas_ids.length; index++) {
      const id = filas_ids[index];

      var NUP_cantidad_id =  "NUP_cantidad_" + id;
      var NUP_unidad_medida_id =  "NUP_unidad_medida_" + id;
      var PTUP_cantidad_id =  "PTUP_cantidad_" + id;
      var PTUP_codUnidadMedida_id =  "PTUP_codUnidadMedida_" + id;
      var PTC_cantidad_id =  "PTC_cantidad_" + id;
      var PTC_codUnidadMedida_id =  "PTC_codUnidadMedida_" + id;
      var pventa_unidad_id =  "pventa_unidad_" + id;
      var costo_prod_unidad_id =  "costo_prod_unidad_" + id;
      var ingreso_neto22_id =  "ingreso_neto22_" + id;
      var RZ_rendimiento_id =  "RZ_rendimiento_" + id;
      var RZ_unidad_medida_id =  "RZ_unidad_medida_" + id;
      var RZ_fuente_id =  "RZ_fuente_" + id;
      var ingreso_semestre_id =  "ingreso_semestre_" + id;
      var RS_rendimiento_id =  "RS_rendimiento_" + id;
      var RS_unidad_medida_id =  "RS_unidad_medida_" + id;

      limpiarEstilos([
        NUP_cantidad_id,
        NUP_unidad_medida_id,
        PTUP_cantidad_id,
        PTUP_codUnidadMedida_id,
        PTC_cantidad_id,
        PTC_codUnidadMedida_id,
        pventa_unidad_id,
        costo_prod_unidad_id,
        ingreso_neto22_id,
        RZ_rendimiento_id,
        RZ_unidad_medida_id,
        RZ_fuente_id,
        ingreso_semestre_id,
        RS_rendimiento_id,
        RS_unidad_medida_id,
        
      ])

      

      msj = validarSelect(msj,NUP_unidad_medida_id,"","Unidad de Medida");
      msj = validarSelect(msj,PTUP_codUnidadMedida_id,"","Unidad de Medida");
      msj = validarSelect(msj,PTC_codUnidadMedida_id,"","Unidad de Medida");
      msj = validarSelect(msj,RZ_unidad_medida_id,"","Unidad de Medida");
      msj = validarSelect(msj,RS_unidad_medida_id,"","Unidad de Medida");
     

      msj = validarNumero(msj,NUP_cantidad_id,"Cantidad");
      msj = validarNumero(msj,PTUP_cantidad_id,"Cantidad");
      msj = validarNumero(msj,PTC_cantidad_id,"Cantidad");
      msj = validarNumero(msj,pventa_unidad_id,"Precio de Venta");
      msj = validarNumero(msj,costo_prod_unidad_id,"Costo de Producción Unitario");
      msj = validarNumero(msj,ingreso_neto22_id,"Ingreso Neto en Junio 2022");
      msj = validarNumero(msj,RZ_rendimiento_id,"Rendimiento");
      msj = validarNumero(msj,ingreso_semestre_id,"Ingreso en el semestre actual");
      msj = validarNumero(msj,RS_rendimiento_id,"Rendimiento alcanzado en el semestre");

      msj = validarNulidad(msj,RZ_fuente_id,"");
    
    }

    if(filas_ids.length == 0){
      msj = "Debe añadir productos";
    }
    
    return msj;
  }

  function actualizarIngresoNetoSemestre(codDetalleProducto){
    console.log("actualizando actualizarIngresoNetoSemestre" + codDetalleProducto);

    var PTC_cantidad_id =  "PTC_cantidad_" + codDetalleProducto;
    var pventa_unidad_id =  "pventa_unidad_" + codDetalleProducto;
    var costo_prod_unidad_id =  "costo_prod_unidad_" + codDetalleProducto;
    var ingreso_semestre_id =  "ingreso_semestre_" + codDetalleProducto;

    const Input_PTC_cantidad = document.getElementById(PTC_cantidad_id);
    const Input_pventa_unidad = document.getElementById(pventa_unidad_id);
    const Input_costo_prod_unidad = document.getElementById(costo_prod_unidad_id);
    const InputIngresoSemestre = document.getElementById(ingreso_semestre_id);

    var cantidad = parseFloat(Input_PTC_cantidad.value);
    var precio_venta = parseFloat(Input_pventa_unidad.value);
    var costo_produccion = parseFloat(Input_costo_prod_unidad.value);

    var ingreso = cantidad*(precio_venta-costo_produccion);

    InputIngresoSemestre.value = ingreso.toFixed(2);


    
  }


  function actualizarNombreProductos(){
    var codProducto = document.getElementById("codProductoSeleccionado").value;
    //encontramos el nombre del producto 
    var prod = ListaProductos.find(e => e.codProducto == codProducto);
    
    var nombre_prod = "";
    if(prod){
      nombre_prod = prod.nombre;
    }else{
      nombre_prod = "";
    }
    


    var list = document.getElementsByClassName("producto_name");
    for (let index = 0; index < list.length; index++) {
      const element = list[index];
      element.value = nombre_prod;
    }
    
    document.getElementById("codProductoSeleccionadoEnviar").value = codProducto;
  }





  /* MODAL DE ASISTENCIA */
 

  function clickCambiarAsistencia(codPersona,codDetalleProducto,new_value_asistencia){
    var ruta_update = "{{route('PPM.SemestreOrganizacion.GuardarAsistenciaDetalleProd')}}";
    var datos = {
      codPersona:codPersona,
      codDetalleProducto:codDetalleProducto,
      new_value_asistencia:new_value_asistencia,
    };
     
    $(".loader").show();

    $.post(ruta_update, datos, function(dataRecibida){
      $(".loader").hide();
    
      
      var OBJ = JSON.parse(dataRecibida);
      if(OBJ.ok == "1"){
        mostrarNotificacion(OBJ.tipoWarning,OBJ.mensaje);
      }else{
        alertaMensaje(OBJ.titulo,OBJ.mensaje,OBJ.tipoWarning);

      }
      
    });

    
  }


  function updateBusquedaAsistencia(string_busqueda,codDetalleProducto){

    var ListaFilasPersonas = document.getElementsByClassName("busqueda_personas_" + codDetalleProducto);

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

    const FilaNoResultados = document.getElementById("noresultados_" + codDetalleProducto);
    if(hay_resultados){
      FilaNoResultados.classList.add("hidden");
    }else{
      FilaNoResultados.classList.remove("hidden");
    }


  }




  /* UTILS */
  function removeFromArray(array,element){
    const index = array.indexOf(element);
    if (index > -1) { // only splice array when item is found
      array.splice(index, 1); // 2nd parameter means remove one item only
    }
    return array;
  }

  const RandomStringLength = 8;
  function generateRandomString(){
    let result = '';
    const characters = '123456789';

    const charactersLength = characters.length;
    let counter = 0;
    while (counter < RandomStringLength) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
      counter += 1;
    }
    return result;
  }

  function generateRandomStringDiferentID(){
    var rand = generateRandomString();


    while (filas_ids.indexOf(rand) != -1) { //si lo encontró en los ids actuales, que genere uno distinto
      console.log(rand + " ya existe en el filas_ids, generando uno nuevo");
      rand = generateRandomString();
    }

    return rand
  }

</script>

{{-- MODAL DE EDITAR PRODUCTO --}}
<script>

  async function clickEditarProducto(codDetalleProducto){

    var ruta = "/PPM/SemestreOrganizacion/InvModalDetalleProducto/" + codDetalleProducto;
    
    $(".loader").show();
    await Async_InvocarHtmlEnID(ruta,'content_modal_productos')

    $(".loader").hide();
  }


  function onChangePTUP_Modal(nuevo_codUnidadMedida){
    
    var unidad = ListaUnidadesMedida.find(e => e.codUnidadMedida == nuevo_codUnidadMedida);
    if(unidad){
      const LabelPTC_unidad = document.getElementById("PTC_codUnidadMedida");
      LabelPTC_unidad.value = unidad.nombre;
    }else{
      console.log("updatePTC_unidadMedida Unidad no encontrada, " + nuevo_codUnidadMedida);
    }

  }

  function clickModalDetalle(){
    var msj = validarFormModal();
    console.log("msj",msj)
    if(msj != ""){
      alerta(msj);
      return;
    }

    document.form_modal_detalle.submit();

  }
  function validarFormModal(){

    limpiarEstilos([
      'NUP_cantidad',
      'NUP_unidad_medida',
      'PTUP_cantidad',
      'PTUP_codUnidadMedida',
      'PTC_cantidad',
      'PTC_codUnidadMedida',
      'pventa_unidad',
      'costo_prod_unidad',
      'ingreso_neto22',
      'RZ_rendimiento',
      'RZ_unidad_medida',
      'RZ_fuente',
      'ingreso_semestre',
      'RS_rendimiento',
      'RS_unidad_medida',
      'codProducto'
    ])
    var msj = "";

    msj = validarSelect(msj,'NUP_unidad_medida',"","Unidad de Medida");
    msj = validarSelect(msj,'PTUP_codUnidadMedida',"","Unidad de Medida");
    msj = validarSelect(msj,'PTC_codUnidadMedida',"","Unidad de Medida");
    msj = validarSelect(msj,'RZ_unidad_medida',"","Unidad de Medida");
    msj = validarSelect(msj,'RS_unidad_medida',"","Unidad de Medida");
    msj = validarSelect(msj,'codProducto',"","Producto");


    msj = validarNumero(msj,'NUP_cantidad',"Cantidad");
    msj = validarNumero(msj,'PTUP_cantidad',"Cantidad");
    msj = validarNumero(msj,'PTC_cantidad',"Cantidad");
    msj = validarNumero(msj,'pventa_unidad',"Precio de Venta");
    msj = validarNumero(msj,'costo_prod_unidad',"Costo de Producción Unitario");
    msj = validarNumero(msj,'ingreso_neto22',"Ingreso Neto en Junio 2022");
    msj = validarNumero(msj,'RZ_rendimiento',"Rendimiento");
    msj = validarNumero(msj,'ingreso_semestre',"Ingreso en el semestre actual");
    msj = validarNumero(msj,'RS_rendimiento',"Rendimiento alcanzado en el semestre");

    msj = validarNulidad(msj,'RZ_fuente',"");
    return msj;

  }

  function actualizarIngresoNetoSemestreModal(){
 
    const Input_PTC_cantidad = document.getElementById("PTC_cantidad");
    const Input_pventa_unidad = document.getElementById("pventa_unidad");
    const Input_costo_prod_unidad = document.getElementById("costo_prod_unidad");
    const InputIngresoSemestre = document.getElementById("ingreso_semestre");

    var cantidad = parseFloat(Input_PTC_cantidad.value);
    var precio_venta = parseFloat(Input_pventa_unidad.value);
    var costo_produccion = parseFloat(Input_costo_prod_unidad.value);

    var ingreso = cantidad*(precio_venta-costo_produccion);

    InputIngresoSemestre.value = ingreso.toFixed(2);

  }

  function clickEliminarProducto(codDetalleProducto){

    confirmarConMensaje("Confirmación","¿Desea eliminar el producto? Se eliminarán también las asistencias.",'warning',function(){
      location.href = "/PPM/SemestreOrganizacion/EliminarDetalleProducto/" + codDetalleProducto
    })

  }
  


</script>
@endsection
 
@section('estilos')
<style>
  .cb_cosecha{
    width: 23px;
    height: 23px;
  }

  

  .unidad_medida_size{
    min-width: 130px;
  }
  .input_producto{
    min-width:160px;
  }

  #tabla_productos th{
      padding: 10px 10px;
  }
    

  @media(max-width:500px){ /* MOBILE */
    #tabla_productos thead .desktop_tr{
      display:none;
    }
    .fila_responsive{
      display: grid;
    }

    #tabla_productos td{
      padding: 7px 15px;
    }

    .aparecer_en_mobile{
      display: block;
    }

    .bg_celeste_mobile{
      background-color: rgb(143 236 243);
    }
    .bg_naranja_mobile{
      background-color: rgb(255 207 179)
    }

     

  }

  @media(min-width:500px){ /* DESKTOP */
    #tabla_productos thead .desktop_tr{
      display:table-row;
    }

    #tabla_productos td{
      padding: 1px;
    }
   
    .aparecer_en_mobile{
      display: none;
    }

    
  }

  

  
  
    .aviso_fondo{
      padding: 5 10px;
      border-radius: 2px;
      color: #939393;
      margin-left: auto;
    }
    
    .span_cambio_masivo{
      font-size: 10pt;
      color: #e9e9e9;

    }

    #tabla_productos .form-control{
      padding: 2px !important;
    }

    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }


    .agrupador_modal{
      border-width: 1px;
      border-style: solid;
      background-color: #e9e9e9;
      border-color: #b5b5b5;
      border-radius: 5px;
      
      padding-bottom: 10px;
      margin-bottom: 5px;
      margin-top: 5px;
 
    }

     

    .agrupador_modal .title_seccion{
      font-size: 14pt;
      background-color: #9b9bc5;
      color: white;
    }
    .agrupador_modal .row{
      margin-right: 0px;
      margin-left: 0px;
    }
 
</style>
@endsection