@extends('Layout.Plantilla')
@section('titulo')
  @if($solicitud->verificarEstado('Contabilizada'))
    Ver
  @else
    Contabilizar
  @endif
    Solicitud
@endsection

@section('contenido')

  {{-- ESTA VISTA SE USA PARA VER Y PARA CONTABILIZAR --}}
  <div >
      
      <p class="h1" style="text-align: center"> 
          @if($solicitud->verificarEstado('Contabilizada'))
          Ver
          @else
          Contabilizar
          @endif
          Solicitud de Fondos
      </p>
  </div>

      
  {{-- CODIGO DEL EMPLEADO --}}
  <input type="hidden" name="codigoCedepas" id="codigoCedepas" value="{{ $empleadoLogeado->codigoCedepas }}">

  @csrf
  @include('SolicitudFondos.Plantillas.VerSOF')

  <div class="row" id="divTotal" name="divTotal">                       
      <div class="col-md-8">
      </div>   
      <div class="col-md-2">                        
          <label for="">Total : </label>    
      </div>   
      <div class="col-md-2">
          {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
          <input type="hidden" name="cantElementos" id="cantElementos">                              
          <input type="text" class="form-control text-right" name="total" 
              value="{{number_format($solicitud->totalSolicitado,2)}}" id="total" readonly>                              
      </div>   
  </div>

  
  

  <div class="row mt-2">
    <div class="col-12 col-md-6">
        @include('SolicitudFondos.Plantillas.DesplegableDescargarArchivosSoli')
        

    </div>
      
    
    
    @if($solicitud->verificarEstado('Abonada') )
          
      <div class="col-12 col-md-6 text-right">
          <a href="#" id="botonContabilizar" onclick="clickOnContabilizar()" class='btn btn-success'>
              <i class="fas fa-check"></i>
              Marcar como contabilizada
          </a>    
      </div>
    
    @endif
  </div>
  <div class="row mt-5">
    <a href="{{route('SolicitudFondos.Contador.Listar')}}" class='btn btn-primary m-2'>
      <i class="fas fa-undo"></i>
      Regresar al menú
    </a>

  </div>

  @csrf     
  <input type="hidden" value="{{$solicitud->codSolicitud}}" name="codSolicitud" id="codSolicitud">
    
      
                    
              
                          
              
               
     

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

<style>
    
    
    </style>


@section('script')
     <script src="/public/select2/bootstrap-select.min.js"></script>     
     <script>
       
        $(document).ready(function(){
            
    
        });

        function clickOnContabilizar(){
            confirmarConMensaje("Confirmar","¿Desea marcar como contabilizada la solicitud?","info",contabilizar);
        }

        function contabilizar(){
            location.href = "{{route('SolicitudFondos.Contador.Contabilizar',$solicitud->codSolicitud)}}";
        }
       
    
       
    
    
    
    </script>
     










@endsection
