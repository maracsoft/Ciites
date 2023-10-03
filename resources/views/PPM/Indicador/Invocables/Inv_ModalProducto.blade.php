<div class="modal-header">
  <h5 class="modal-title" id="">
    Editar Detalle de producto
  </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <form method="post" action="{{route('PPM.SemestreOrganizacion.ActualizarDetalleProducto_producto')}}" name="form_modal_detalle">
    @csrf
    <input type="hidden" name="codDetalleProducto" value="{{$detalle->codDetalleProducto}}">

    <div class="row">
      <div class="col-sm-6">
        <label for="">
          Producto:
        </label>
        <select class="form-control" name="codProducto" id="codProducto">
          <option value="">
            - Producto -
          </option>
          @foreach($productos as $producto)
            <option value="{{$producto->getId()}}"  {{$producto->isThisSelected($detalle->codProducto)}}>
              {{$producto->nombre}}
            </option>
          @endforeach
        </select>
        
        
      </div>

      <div class="col-6">
        <label for="">
          Ingreso Neto JUN-22
        </label>
        <input type="text" class="form-control" id="ingreso_neto22" name="ingreso_neto22" value="{{$detalle->ingreso_neto22}}">
        
      </div>

      <div class="col-sm-6 ">
        <div class="agrupador_modal">
          <div class="text-center title_seccion">
            Unidades de Producción
          </div>
          <div class="row">
            
            <div class="col-sm-6">
              <label for="">
                Cantidad
              </label>
              <input type="text" class="form-control" id="NUP_cantidad" name="NUP_cantidad" value="{{$detalle->NUP_cantidad}}">
            </div>

            <div class="col-sm-6">
              <label for="">
                Unidad de Medida
              </label>
              <input type="text" class="form-control" id="NUP_unidad_medida" name="NUP_unidad_medida" value="{{$detalle->NUP_unidad_medida}}">
            </div>
          </div>
          
        </div>
      </div>

      <div class="col-sm-6">
        <div class="agrupador_modal">

          <div class="text-center title_seccion">
            Prod. total por unidad de producción
          </div>
          <div class="row">
            
            <div class="col-sm-6">
              <label for="">
                Cantidad
              </label>
              <input type="text" class="form-control" id="PTUP_cantidad" name="PTUP_cantidad" value="{{$detalle->PTUP_cantidad}}">
          
            </div>
            <div class="col-sm-6">
              <label for="">
                Unidad de Medida
              </label>
              <select class="form-control form-control-sm unidad_medida_size" id="PTUP_codUnidadMedida" name="PTUP_codUnidadMedida" onchange="onChangePTUP_Modal(this.value)">
                <option value="">- Unid Medida -</option>
                @foreach($listaUnidadesMedida as $unidad)
                  <option value="{{$unidad->getId()}}" {{$unidad->isThisSelected($detalle->PTUP_codUnidadMedida)}}>
                    {{$unidad->nombre}}
                  </option>
                @endforeach
              </select>
               
            </div>

          </div>
        </div>

      </div>


      <div class="col-sm-6 ">
        <div class="agrupador_modal">
          <div class="text-center title_seccion">
            Prod. total comercializada
          </div>
          <div class="row">
            
            <div class="col-sm-6">
              <label for="">
                Cantidad
              </label>
              <input type="text" class="form-control" id="PTC_cantidad" name="PTC_cantidad" value="{{$detalle->PTC_cantidad}}" oninput="actualizarIngresoNetoSemestreModal()">
          
            </div>
            <div class="col-sm-6">
              <label for="">
                Unidad de Medida
              </label>
              
              <input type="text" class="form-control" id="PTC_codUnidadMedida" name="PTC_codUnidadMedida" value="{{$detalle->getUnidadMedida_PTC()->nombre}}" readonly>
            </div>

          </div>
            
        </div>
      </div>

  
      
      <div class="col-3">
        <label class="mb-0" for="">
          Precio de Venta x Unid (Soles)
        </label>
        <input type="text" class="form-control" id="pventa_unidad" name="pventa_unidad" value="{{$detalle->pventa_unidad}}" oninput="actualizarIngresoNetoSemestreModal()">
        
      </div>
      <div class="col-3">
        <label for="">
          Costo de producción Unitario (Soles)
        </label>
        <input type="text" class="form-control" id="costo_prod_unidad" name="costo_prod_unidad" value="{{$detalle->costo_prod_unidad}}" oninput="actualizarIngresoNetoSemestreModal()">
        
      </div>



      <div class="col-sm-9 agrupador_modal">
        <div class="row">
          <div class="col-sm-12 text-center title_seccion">
            Rendimiento Promedio de la Zona
          </div>
          <div class="col-sm-4">
            <label for="">
              Rendimiento
            </label>
            <input type="text" class="form-control" id="RZ_rendimiento" name="RZ_rendimiento" value="{{$detalle->RZ_rendimiento}}">
        
          </div>
          <div class="col-sm-4">
            <label for="">
              Unidad de Medida
            </label>
            <input type="text" class="form-control" id="RZ_unidad_medida" name="RZ_unidad_medida" value="{{$detalle->RZ_unidad_medida}}">
          </div>
          <div class="col-sm-4">
            <label for="">
              Fuente
            </label>
            <input type="text" class="form-control" id="RZ_fuente" name="RZ_fuente" value="{{$detalle->RZ_fuente}}">
          </div>

        </div>
      </div>



  
      <div class="col-3">
        <label for="">
          Ingreso de la org en este semestre
        </label>
        <input type="text" class="form-control" id="ingreso_semestre" name="ingreso_semestre" value="{{$detalle->ingreso_semestre}}" readonly>
        
      </div>



      
      <div class="col-sm-6 agrupador_modal">
        <div class="row">
          <div class="col-sm-12 text-center title_seccion">
            Rendimiento alcanzado en el semestre
          </div>
          <div class="col-sm-6">
            <label for="">
              Rendimiento
            </label>
            <input type="text" class="form-control" id="RS_rendimiento" name="RS_rendimiento" value="{{$detalle->RS_rendimiento}}">
        
          </div>
          <div class="col-sm-6">
            <label for="">
              Unidad de Medida
            </label>
            <input type="text" class="form-control" id="RS_unidad_medida" name="RS_unidad_medida" value="{{$detalle->RS_unidad_medida}}">
          </div>

        </div>
      </div>

 
       
      
    </div> 


  </form>

</div>
<div class="modal-footer">
  <button class="btn btn-success" onclick="clickModalDetalle()">
    Guardar
    <i class="fas fa-save"></i>
  </button>
  <button type="button" class="btn btn-secondary" data-dismiss="modal">
      Salir
  </button>

</div>