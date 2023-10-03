@extends('Layout.Plantilla')

@section('titulo')
    Editar Actividad
@endsection

@section('tiempoEspera')
    <div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

@include('Layout.MensajeEmergenteDatos')

<div >
    <p class="h1" style="text-align: center">
        Editar Actividad
    </p>
</div>




   
    <div class="card mx-2">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <div class="d-flex flex-row">
                <div class="">
                    <h3 class="card-title">
                        {{--  <i class="fas fa-chart-pie"></i> --}}
                        <b>Información General</b>
                    </h3>
    
                </div>
               
             
    
            </div>
        </div> 
        <div class="card-body">
          <form method = "POST" action = "{{route('CITE.Actividades.Actualizar')}}" id="frmActividad" name="frmActividad"  enctype="multipart/form-data">
    
            <input type="hidden" name="codActividad" value="{{$actividad->getId()}}">
            
            @csrf

            <div class="row">
                                

                <div class="col-sm-6">
                    <label for="">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{$actividad->nombre}}">

                </div>
               
                
                <div class="col-sm-5">
                  <label for="">
                    Tipo de Servicio
                  </label>
                  <select class="form-control" name="codTipoServicio" id="codTipoServicio">
                    <option value="">- Seleccionar -</option>
                    @foreach ($listaTiposServicio as $tipo_serv)
                      <option value="{{$tipo_serv->getId()}}" {{$tipo_serv->isThisSelected($actividad->codTipoServicio)}}>
                         {{$tipo_serv->getModalidad()->nombre}} - {{$tipo_serv->nombre}}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-1">
                  <label for="">Indice:</label>
                  <input type="text" class="form-control" id="indice" name="indice" value="{{$actividad->indice}}">

                </div>
                <div class="col-sm-12">
                    <label for="">Descripcion:</label>
                    <textarea type="text" class="form-control" id="descripcion" rows="4" name="descripcion">{{$actividad->descripcion}}</textarea>
                
                </div>
                 
                    

            </div>
            
            <div class="row">
                <div class="ml-auto m-2">

                    <button type="button" class="btn btn-primary" onclick="clickGuardar()">
                        <i class='fas fa-save'></i> 
                        Guardar
                    </button> 
                    
                </div>

            </div>
          </form>

        </div>
    </div>


    <div class="card mx-2">
      <div class="card-header ui-sortable-handle" style="cursor: move;">
          <div class="d-flex flex-row">
              <div class="">
                  <h3 class="card-title">
                      <b>
                        Formatos vinculados a esta actividad
                      </b>
                  </h3>
  
              </div>
             
           
  
          </div>
      </div> 
      <div class="card-body">
        <form action="{{route('CITE.Actividades.AñadirFormatos')}}" name="formAñadirFormato" method="POST">
          @csrf
          <input type="hidden" name="codActividad" value="{{$actividad->codActividad}}">

          <div class="row">
            <div class="col-sm-10">
  
              <label for="">
                Añadir nuevo formato:
              </label>
              
              @php
                
                $selectMult = new App\UI\UISelectMultiple([],"",'codsTipoMedioVerificacion',"Añadir Formato",false,30,12);
                $selectMult->setOptionsWithModel($tipos_medios,'nombre_front');
              @endphp

              {{$selectMult->render()}}

               
            
            </div>
            <div class="col-sm-2">
              <button type="submit"  class="btn btn-primary">
                Añadir
              </button>
            </div>
          </div>

        </form>
        
        
        <div class="row">
          <table class="table table-striped table-bordered table-condensed table-hover" >
            <thead  class="thead-default">
                <tr>
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-left">
                        Nombre
                    </th>
                    <th class="text-center">
                        Indice
                    </th>
                    <th>
                      N° Orden del archivo en la actividad
                    </th>
                    <th>
                        Opciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($actividad->getRelacionesTipoMedioVerificacion() as $relacion_tipo_medio )
                @php
                  $tipo_medio = $relacion_tipo_medio->getTipoMedioVerificacion();
                @endphp
                  <tr class="FilaPaddingReducido">
                      <td class="text-center">
                          {{$tipo_medio->getId()}}
                      </td>
                      <td class="text-left">
                          {{$tipo_medio->nombre}}
                      </td>
                      <td class="text-center">
                          {{$tipo_medio->indice_formato}}
                      </td>
                      <td>
                        <div class="d-flex flex-row">
                          <input type="number" class="form-control" id="nro_orden_{{$relacion_tipo_medio->getId()}}" value="{{$relacion_tipo_medio->nro_orden}}">
                          <button class="btn btn-primary" type="button" onclick="clickGuardarNumeroOrden({{$relacion_tipo_medio->getId()}})">
                            <i class="fas fa-save"></i>
                          </button>
                        </div>
                          
                      </td>
                      <td class="text-center">
                        <a class="btn btn-danger btn-xs" href="{{route('CITE.Actividades.QuitarFormatoDeActividad',$relacion_tipo_medio->getId())}}">
                          <i class="fas fa-trash"></i>
                        </a>
                      </td>
                  </tr>
                @endforeach
                

            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="card mx-2">
      <div class="card-header ui-sortable-handle" style="cursor: move;">
          <div class="d-flex flex-row">
              <div class="">
                  <h3 class="card-title">
                      <b>
                        Indicadores
                      </b>
                  </h3>
              </div>
          </div>
      </div> 
      <div class="card-body">
        <form action="{{route('CITE.Actividades.GuardarActualizarIndicador')}}" name="formAñadirFormato" method="POST">
          @csrf
          <input type="hidden" name="codActividad" value="{{$actividad->codActividad}}">

          <div class="row">
            <div class="col-sm-4">
  
              <label for="">
                Añadir nuevo formato:
              </label>
              <textarea class="form-control" name="descripcion" id="descripcion" rows="2"></textarea>
            </div>
            <div class="col-sm-2">
              <label for="">
                Orden:
              </label>
              <input type="text" class="form-control" name="orden" id="orden" value="">
            </div>
            <div class="col-sm-4">
              <label for="">
                Tipo de Reporte
              </label>
              <select class="form-control" name="tipo_reporte" id="tipo_reporte">
                <option value="">- Seleccionar -</option>
                <option value="servicios">Servicios</option>
                <option value="unidades">Unidades</option>
                <option value="usuarios">Usuarios</option>
              </select>
            </div>

            <div class="col-sm-2">
              <div class="d-flex justify-content-end align-items-end align-content-end h-100">
                <button type="submit" class="mt-auto btn btn-success" onclick="clickGuardarNuevaActividad()">
                  Guardar
                </button>
              </div>
              
            </div>
          </div>

        </form>
        
        
        <div class="row">

          @foreach($actividad->getIndicadores() as $indicador )
            <div class="col-sm-4 p-1">
              <div class="recuadro_indicador">


                <form method="POST" action="{{route('CITE.Actividades.GuardarActualizarIndicador')}}">
                  <input type="hidden" name="codIndicador" value="{{$indicador->codIndicador}}">
                  <input type="hidden" name="codActividad" value="{{$actividad->codActividad}}">
                    
                    @csrf

                    <div>
                      id:{{$indicador->getId()}}
                      
                    </div>
                    <div class="">
                      <label for="">
                        Descripción
                      </label>
                      <textarea class="form-control" name="descripcion" id="" rows="3">{{$indicador->descripcion}}</textarea>

                    </div>
                    <div>
                      <label for="">
                        Orden
                      </label>
                      <input type="text" class="form-control" name="orden" value="{{$indicador->orden}}">

                    </div>
                    <div>
                      <label for="">
                        Tipo de Reporte
                      </label>
                      <select class="form-control" name="tipo_reporte" id="tipo_reporte">
                        <option value="">- Seleccionar -</option>
                        <option @if($indicador->tipo_reporte == 'servicios') selected @endif value="servicios">Servicios</option>
                        <option @if($indicador->tipo_reporte == 'unidades') selected @endif value="unidades">Unidades</option>
                        <option @if($indicador->tipo_reporte == 'usuarios') selected @endif value="usuarios">Usuarios</option>
                      </select>
                    </div>
                    <div>

                      <a class="btn btn-danger btn-xs" href="{{route('CITE.Actividades.EliminarIndicador',$indicador->getId())}}">
                        <i class="fas fa-trash"></i>
                      </a>
                      <button class="btn btn-primary" type="submit" >
                        <i class="fas fa-save"></i>
                      </button>
                    </div>
                            
                </form>
              </div>
            </div>
          @endforeach

          
        </div>
      </div>
    </div>


    <div class="d-flex flex-row m-4">
        <div class="">

            <a href="{{route('CITE.Actividades.Listar')}}" class='btn btn-info '>
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

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

@include('Layout.EstilosPegados')
@include('Layout.ValidatorJS')
@section('script')
  
<script type="application/javascript">
  
  $(document).ready(function(){
      $(".loader").fadeOut("slow");
      
      
  });
  
  function clickGuardar(){
      msjError = validarForm();
      if(msjError!= ""){
          alerta(msjError);
          return;
      }

      confirmarConMensaje('Confirmación','¿Desea actualizar la actividad?','warning',function(){            
          document.frmActividad.submit();
      })
  }

  function validarForm(){

      msj = "";
      
      limpiarEstilos(['nombre','indice','codTipoServicio','descripcion'])

      
      msj = validarTamañoMaximoYNulidad(msj,'nombre',200,'Nombre')
      msj = validarTamañoMaximoYNulidad(msj,'indice',20,'Indice')
      msj = validarTamañoMaximoYNulidad(msj,'descripcion',1000,'Indice')
      
      msj = validarSelect(msj,'codTipoServicio',"-1",'Tipo de Servicio')

      return msj;
  }

  
  function clickGuardarNumeroOrden(codRelacion){
    const InputNro = document.getElementById("nro_orden_" + codRelacion);
    var nro_orden = InputNro.value;
    var ruta = "/Cite/Actividades/ActualizarNumeroOrden";

    var datosAEnviar = {
      nro_orden:nro_orden,
      codRelacion:codRelacion,
      _token: '{{csrf_token()}}',
    }


    $.post(ruta, datosAEnviar, function(dataRecibida){
      
      console.log(dataRecibida);
      
      OBJ = JSON.parse(dataRecibida);
      if(OBJ.ok == "1"){
        mostrarNotificacion(OBJ.tipoWarning,OBJ.mensaje);
      }else{
        alertaMensaje(OBJ.titulo,OBJ.mensaje,OBJ.tipoWarning);
      }

    });


  }



</script>
{{-- CRUD DE ACTIVIDADES --}}
<script>
  function clickGuardarNuevaActividad(){


  }

</script>  


@endsection
@section('estilos')
<style>
  .recuadro_indicador{
    background-color: rgb(228, 228, 228);
    border-style: solid;
    border-width: 1px;
    border-color: rgb(150, 150, 150);
    border-radius: 10px;
    padding: 15px;
    
  }

</style>
@endsection