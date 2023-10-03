<div class="row">


  <div class="col-sm-12">
    <label for="">
      Organización:
    </label>
    <input type="text" class="form-control" value="{{$organizacion->razon_social}}" readonly>
  </div>
  <div class="col-sm-6">
    <label for="">
      RUC:
    </label>
    <input type="text" class="form-control" value="{{$organizacion->ruc}}" readonly>
  </div>

  <div class="col-sm-6">
    <label for="">
      Semestre:
    </label>
    <input type="text" class="form-control text-center" value="{{$semestre->getTexto()}}" readonly>


  </div>


</div>



<div class="row my-2">
  <div class="col-sm-12">
    <div class="mensaje_nosabes">
      ¿Qué producto deseas ingresar?
      <div class="mensaje_selecciona">
        Busca tu producto en este formulario 
      </div>

      <div class="row mt-2 text-left">
        <div class="col-sm-1"></div>

        <div class="col-sm-5">
            <label for="codTipoProducto" id="" class="mb-0">
                Productos:
            </label>

            <select class="form-control" id="codProducto" onchange="changeTipoProducto(this.value)">
                <option value="-1">- Producto -</option>
                @foreach($listaProductos as $prod)
                  <option value="{{$prod->getId()}}">
                    {{$prod->nombre}}
                  </option>
                @endforeach
            </select>   
        </div>

        <div class="col-sm-5">
            <label class="mb-0">
              Tipo de Producto:
            </label>
            <input type="text" class="form-control" id="tipo_producto_label" value="" readonly>

        </div>
         
        <div class="col-sm-1"></div>
        <div class="col-sm-12 otro_producto_msj">
          Si se trata de otro producto, comunicarse con la UGE para que sea agregado en el sistema
        </div>
        



      </div>


    </div>
  </div>
</div>





<div class="row my-4 text-center">
  <div class="col-sm-6">
    <div class="row">
      <div class="col-12 text-center">
        
        <button disabled id="btn_ingresar_productos" onclick="clickGoToVerAñadirProductos({{$relacion->getId()}})" class="btn btn-primary mb-1">
          Ingresar clasificación productos
        </button>
      </div>
    </div>
    <div class="row">
      <div class="col-12 text-center">
        <div class="hidden" id="flecha_ingresar_productos">
          <i class="fas fa-arrow-up mt-3 fa-2x flechas_color"></i>
        </div> 
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="row">
      <div class="col-12 text-center">
        <button disabled id="btn_importar_cultivos"  onclick="clickGoToImportarCultivosCadena({{$relacion->getId()}})" class="btn btn-primary mb-1">
          Ingresar clasificación cultivos/cadena
        </button>
      </div>
    </div>

    <div class="row">
      <div class="col-12 text-center">
        <div class="hidden" id="flecha_importar_cultivos" >
          <i class="fas fa-arrow-up mt-3 fa-2x flechas_color"></i>
        </div> 
      </div>
    </div>
  </div>
 

</div>