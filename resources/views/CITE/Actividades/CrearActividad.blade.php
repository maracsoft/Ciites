@extends('Layout.Plantilla')

@section('titulo')
    Crear Actividad
@endsection

@section('tiempoEspera')
    <div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

@include('Layout.MensajeEmergenteDatos')

<div >
    <p class="h1" style="text-align: center">
        Crear Actividad
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
          <form method = "POST" action = "{{route('CITE.Actividades.Guardar')}}" id="frmActividad" name="frmActividad"  enctype="multipart/form-data">
    
            
            
            @csrf

            <div class="row">
                                

                <div class="col-sm-6">
                    <label for="">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="">

                </div>
               
                
                <div class="col-sm-5">
                  <label for="">
                    Tipo de Servicio
                  </label>
                  <select class="form-control" name="codTipoServicio" id="codTipoServicio">
                    <option value="">- Seleccionar -</option>
                    @foreach ($listaTiposServicio as $tipo_serv)
                      <option value="{{$tipo_serv->getId()}}" >
                         {{$tipo_serv->getModalidad()->nombre}} - {{$tipo_serv->nombre}}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-1">
                  <label for="">Indice:</label>
                  <input type="text" class="form-control" id="indice" name="indice" value="">

                </div>
                <div class="col-sm-12">
                    <label for="">Descripcion:</label>
                    <textarea type="text" class="form-control" id="descripcion" rows="4" name="descripcion"></textarea>
                
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

            confirmarConMensaje('Confirmación','¿Desea guardar la actividad?','warning',function(){            
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
 
        

    </script>
     


@endsection
 