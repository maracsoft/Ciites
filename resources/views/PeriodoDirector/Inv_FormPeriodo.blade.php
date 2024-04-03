
<div class="modal-header">
  <h5 class="modal-title">
    {{$titulo_modal}}
  </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">

  <form id="form_invocable_periodo" action="">
    <input type="hidden" id="inv_codPeriodoDirector" name="codPeriodoDirector" value="{{$periodo->codPeriodoDirector}}">
    
    <div class="row">

      <div class="col-12">
        <label for="">
          Nombre
        </label>
        <input type="text" class="form-control" id="inv_nombres" name="nombres" value="{{$periodo->nombres}}">
      </div>

      <div class="col-12">
        <label for="">
          Apellidos
        </label>
        <input type="text" class="form-control" id="inv_apellidos" name="apellidos" value="{{$periodo->apellidos}}">
      </div>


      <div class="col-12">
        <label class="mb-0" for="">
          dni
        </label>
        <input type="number" class="form-control" id="inv_dni" name="dni" value="{{ $periodo->dni }}"/>
      </div>

      <div class="col-12">
        <label class="mb-0" for="">
          Sexo
        </label>
        <select class="form-control" id="inv_sexo" name="sexo">
          <option value="-1">- Sexo- </option>
          <option value="M" @if ($periodo->sexo == 'M') selected @endif>Masculino</option>
          <option value="F" @if ($periodo->sexo == 'F') selected @endif>Femenino</option>
        </select>
      </div>
 
      <div class="col-12">
        <label class="mb-0" for="">
          Fecha Inicio
        </label>
        
        <div class="input-group date form_date mr-1" data-date-format="dd/mm/yyyy" data-provide="datepicker">
          <input type="text" class="form-control form-controlw-date text-center" id="inv_fecha_inicio" name="fecha_inicio" value="{{$periodo->getFechaInicio()}}" placeholder="Inicio">
          <div class="input-group-btn d-flex flex-col align-items-center">
              <button class="btn btn-primary btn-sm date-set" type="button">
                <i class="fa fa-calendar"></i>
              </button>
          </div>
        </div>
      </div>


      <div class="col-12">
        <label class="mb-0" for="">
          Fecha Fin
        </label>
        
        <div class="input-group date form_date mr-1" data-date-format="dd/mm/yyyy" data-provide="datepicker">
          <input type="text" class="form-control form-controlw-date text-center" id="inv_fecha_fin" name="fecha_fin" value="{{$periodo->getFechaFin()}}" placeholder="Fin">
          <div class="input-group-btn d-flex flex-col align-items-center">
              <button class="btn btn-primary btn-sm date-set" type="button">
                <i class="fa fa-calendar"></i>
              </button>
          </div>
        </div>
      </div>


    </div>

  </form>

</div>

<div class="modal-footer">
   
  <button type="button" class="m-1 btn btn-primary" onclick="clickGuardarPeriodo()">
      Guardar <i class="fas fa-save"></i>
  </button>
</div>
