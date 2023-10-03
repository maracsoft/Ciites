@extends('Layout.Plantilla')

@section('titulo')
  Crear Actividad en base a otra
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')
 
<div class="col-12 py-2">
  <div class="page-title">
    Crear Actividad en base a otra
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

   
        <form method = "POST" action = "{{route('PPM.Actividad.Guardar')}}" id="frmActividad" name="frmActividad"  enctype="multipart/form-data">
            <input type="hidden" name="codEjecucionActividad" id="codEjecucionActividad" value="{{$ejecucion->codEjecucionActividad}}">
            {{-- CODIGO DEL EMPLEADO --}}
            
            @csrf
            
            <div class="row  internalPadding-1 mx-2">
                <div class="col-sm-12">
                    <label for="codOrganizacion" id="" class="">
                        Organización:
                    </label>
                    
                    <select id="codOrganizacion" name="codOrganizacion" data-select2-id="1" tabindex="-1"  
                        class="fondoBlanco form-control select2 select2-hidden-accessible selectpicker"   aria-hidden="true"  data-live-search="true">
                    
                        <option value="-1">-- Seleccione Organización --</option>
                        @foreach($listaOrganizaciones as $organizacion)
                            <option value="{{$organizacion->getId()}}" {{$organizacion->isThisSelected($ejecucion->codOrganizacion)}}>
                                {{$organizacion->getDenominacion()}} {{$organizacion->getRucODNI()}}
                            </option>
                        @endforeach
                        
                    </select>  
                </div>
                
                <div class="col-12">
                    <label for="codObjetivo" id="" class="">
                        Objetivo:
                    </label>
                    <select class="form-control" id="codObjetivo" onchange="changeObjetivo()">
                      <option value="-1">- Objetivo -</option>
                      @foreach($listaObjetivos as $objetivo)
                        <option value="{{$objetivo->getId()}}" {{$objetivo->isThisSelected($ejecucion->getActividad()->getIndicador()->codObjetivo)}}>
                          {{$objetivo->indice}})  {{$objetivo->nombre}}
                        </option>
                      @endforeach
                    </select>
                </div>

                <div class="col-12">
                  <label for="codIndicador" id="" class="">
                      Indicador:
                  </label>
                  <select class="form-control" id="codIndicador" onchange="changeIndicador()">
                    <option value="-1">- Indicador -</option>
                    @foreach($ejecucion->getActividad()->getIndicador()->getObjetivo()->getIndicadores() as $indicador)
                      <option value="{{$indicador->codIndicador}}"  {{$indicador->isThisSelected($ejecucion->getActividad()->codIndicador)}}>
                        {{$indicador->indice}}) {{$indicador->nombre}}
                      </option>
                    @endforeach
                  </select>   
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
                    
                    <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                      {{-- INPUT PARA LA FECHA --}}
                      <input type="text" style="text-align: center" class="form-control" name="fechaInicio" id="fechaInicio"
                              value="{{$ejecucion->getFechaInicio()}}" > 
                      
                      <div class="input-group-btn">                                        
                          <button class="btn btn-primary date-set btn-sm" type="button" style="display: none">
                              <i class="fas fa-calendar fa-xs"></i>
                          </button>
                      </div>
                    </div>
                    
                    
                </div>

                <div class="col-12 col-sm-4">
                    <label for="">Fecha Fin:</label>
                    
                    <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                      {{-- INPUT PARA  FECHA --}}
                      <input type="text" style="text-align: center" class="form-control" name="fechaFin" id="fechaFin"
                              value="{{$ejecucion->getFechaFin()}}" > 
                      <div class="input-group-btn">                                        
                          <button class="btn btn-primary date-set btn-sm" type="button" style="display: none">
                              <i class="fas fa-calendar fa-xs"></i>
                          </button>
                      </div>
                    </div>
                     

                </div>
                 
                <div class="col-sm-4">
                  <label for="">
                    Semestres:
                  </label>
                  <input type="text" class="form-control text-center" readonly value="{{$ejecucion->getResumenSemestres()}}">
                </div>

                {{App\ComponentRenderizer::LugarSelector('ComboBoxDistrito',$ejecucion->codDistrito)}}

            </div>

            
            <div class="row p-2 mt-2">
              <div class="col-sm-4" >            
                  {{App\ComponentRenderizer::subirArchivos()}}

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
   
  


<div class="row">
  <div class="col px-3">
    <a href="{{route('PPM.Actividad.Listar')}}" class='btn btn-info '>
      <i class="fas fa-arrow-left"></i> 
      Regresar al Menú
    </a>  
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

       


  });

  function registrar(){
      msje = validarFormulario('editar');
      if(msje!=""){
          alerta(msje);
          return false;
      }
      
      confirmar('¿Está seguro de guardar la nueva actividad?','info','frmActividad');
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