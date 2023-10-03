
<div class="modal-header">
  <h5 class="modal-title">
    <b id="titulo_modal">
      {{$titulo_modal}}
    </b>
  </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
   
  <input type="hidden" id="codIndicador" value="{{$indicador->codIndicador}}">
  
  
  <div class="row">
    <div class="col-sm-12">
      <label class="mb-0" for="">
        Actividad:
      </label>
      <textarea class="form-control" rows="4" readonly>{{$actividad->descripcion}}</textarea>

    </div>
    <div class="col-sm-12 mb-2">
      <label class="mb-0" for="">
        Indicador:
      </label>
      <textarea class="form-control" rows="4" readonly>{{$indicador->descripcion}}</textarea>

    </div>
    
       
    
    <div class="col-sm-2">
      <label class="mb-0" for="">
        Meta Anual:
      </label>
      <input type="number" class="form-control text-center" id="meta_anual" value="{{$indicador->meta_anual}}" >
    </div>
    <div class="col-sm-10 d-flex flex-row ">
      
      <div class="d-flex">
        <button class="btn btn-success mt-auto" type="button" onclick="clickActualizarMetaAnual()">
          Guardar
          <i class="ml-1 fas fa-save"></i>
        </button>
      </div>

    </div>

     

  </div>
 
</div>