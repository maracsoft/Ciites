@extends('Layout.Plantilla')

@section('titulo')
    Editar Formato
@endsection

@section('tiempoEspera')
    <div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

@include('Layout.MensajeEmergenteDatos')

<div >
    <p class="h1" style="text-align: center">
        Editar Formato
    </p>
</div>





<div class="card mx-2">
    <div class="card-header ui-sortable-handle" style="cursor: move;">
        <div class="d-flex flex-row">
            <div class="">
                <h3 class="card-title">
                    
                    <b>Información General</b>
                </h3>

            </div>
            
          

        </div>
    </div> 
    <div class="card-body">
      <form method = "POST" action = "{{route('CITE.TiposMediosVerificacion.Actualizar')}}" id="frmTipo" name="frmTipo"  enctype="multipart/form-data">

        <input type="hidden" name="codTipoMedioVerificacion" value="{{$tipo_medio->getId()}}">
        
        @csrf

        <div class="row">
                            

            <div class="col-sm-6">
                <label for="">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{$tipo_medio->nombre}}">
            </div>
             
            <div class="col-sm-1">
              <label for="">Indice:</label>
              <input type="text" class="form-control" id="indice_formato" name="indice_formato" value="{{$tipo_medio->indice_formato}}">
            </div>

            @php
              $file_uploader = new App\UI\FileUploader("nombreArchivo","filenames",10,false,"Subir archivos");
            @endphp
            <div class="col-sm-4">
              @if($tipo_medio->tieneArchivoGeneral())
                @php
                  $archivo_gen = $tipo_medio->getArchivoGeneral();
                @endphp
                <div>
                  <a class="btn btn-success btn-sm" href="{{route('CITE.TiposMediosVerificacion.DescargarArchivo',$archivo_gen->getId())}}">
                    Descargar
                    <i class="fas fa-file-download"></i>
                  </a>
                </div>
              @endif

              {{$file_uploader->render()}}
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

        <a href="{{route('CITE.TiposMediosVerificacion.Listar')}}" class='btn btn-info '>
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

        confirmarConMensaje('Confirmación','¿Desea actualizar el formato?','warning',function(){            
            document.frmTipo.submit();
        })
    }

    function validarForm(){

        msj = "";
        
        limpiarEstilos(['nombre','indice_formato'])

        
        msj = validarTamañoMaximoYNulidad(msj,'nombre',200,'Nombre')
        msj = validarTamañoMaximo(msj,'indice_formato','Indice')
        
        return msj;
    }

  

</script>
  


@endsection
 