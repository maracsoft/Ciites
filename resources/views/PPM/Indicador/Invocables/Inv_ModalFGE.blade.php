
<div class="modal-header">
  <h5 class="modal-title">
    Ficha de Gestión Empresarial {{$relacion->getSemestre()->getTexto()}}
  </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
    <form id="frmFichaGestionEmpresarial" name="frmFichaGestionEmpresarial" action="" method="POST">
        <input type="hidden" name="codRelacion" id="codRelacion" value="{{$relacion->codRelacion}}">
        @csrf
        
        <div class="mb-3">
          <label for="" class="mb-0">
            Organización:
          </label>
          <input type="text" class="form-control form-control-sm" value="{{$organizacion->razon_social}}" readonly>
        </div>

        @foreach($segmentos as $segmento)
          <div class="fge_segmento_container">

            <div class="fge_segmento">
              {{$segmento->nombre}}

              <div id="fge_segmento_promedio_{{$segmento->getId()}}" class="fge_segmento_promedio">
                 
              </div>
            </div>

            <div class="fge_segmento_items_container">

              
              @foreach($segmento->getItems() as $item)
                <div class="fge_item">
                  <label class="mb-0">
                    {{$item->descripcion}}
                  </label>
                  
                  @php
                    $existe = App\Models\PPM\PPM_FGE_Marcacion::existeRelacionItem($relacion,$item);
                    if($existe){
                      $marcacion = App\Models\PPM\PPM_FGE_Marcacion::getByRelacionItem($relacion,$item);
                      $codOptionSeleccionada = $marcacion->codOptionSeleccionada;
                    }else{
                      $codOptionSeleccionada = 0;
                    }

                  @endphp
                  <select class="form-control" name="" id="fge_item_{{$item->getId()}}" onchange="actualizarPromediosFGE()">
                    <option value="-1">
                      - Seleccionar -
                    </option>
                    @foreach($item->getOptions() as $option)
                    <option value="{{$option->getId()}}" 
                      @if($codOptionSeleccionada != 0)
                        @if($codOptionSeleccionada == $option->codOption)
                          selected
                        @endif
                      @endif
                      
                      >
                      {{$option->descripcion}}
                    </option>
                    @endforeach
                  </select>

                </div>
                
                
                
              @endforeach
          
            </div>
          </div>
        @endforeach
                         

        <div class="fge_promedio_final">
          PROMEDIO PUNTAJE FINAL: 
          <div class="fge_promedio_final_valor" id="fge_promedio_final_valor">

          </div>
        </div>
        
    </form>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">
        Salir
    </button>

    <button type="button" class="m-1 btn btn-primary" onclick="clickGuardarFichaGestionEmpresarial()">
        Guardar <i class="fas fa-save"></i>
    </button>   
</div>