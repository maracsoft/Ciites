@extends('Layout.Plantilla')

@section('titulo')
@if($solicitud->verificarEstado('Aprobada'))
    Abonar Solicitud
@else 
    Ver Solicitud
@endif
@endsection

@section('contenido')

<div>
    <p class="h1" style="text-align: center">
        Ver Solicitud de Fondos
    </p>
</div>

<form method="POST" action="{{route('SolicitudFondos.Administracion.Abonar')}}" id="frmsoli" enctype="multipart/form-data">
    {{-- Para saber en el post cual solicitud es  --}}    
    <input type="hidden" value="{{$solicitud->codSolicitud}}" name="codSolicitud" id="codSolicitud">
   
    @csrf
        
        @include('SolicitudFondos.Plantillas.VerSOF')
   
                
        <div class="row" id="divTotal" name="divTotal">                       
            <div class="col-12 col-md-6">
              @include('SolicitudFondos.Plantillas.DesplegableDescargarArchivosSoli')
            </div>
            <div class="col-12 col-md-2">
              <a href="{{route('solicitudFondos.descargarPDF',$solicitud->codSolicitud)}}" class='btn btn-info m-1'  title="Descargar PDF">
                  Descargar PDF 
                  <i class="fas fa-file-download"></i>
              </a>
              <a target="pdf_solicitud_{{$solicitud->codSolicitud}}" href="{{route('solicitudFondos.verPDF',$solicitud->codSolicitud)}}" class='btn btn-info m-1'  title="Ver PDF">
                  Ver PDF 
                  <i class="fas fa-file-pdf"></i>
              </a>
            </div>
            <div class="col-md-4 row mt-2">
              <div class="col">
                <label for="">
                  Total : 
                </label> 
              </div>                        
              <div class="col">
                <input type="hidden" name="cantElementos" id="cantElementos">                              
                <input type="text" class="form-control text-right" name="total" id="total" value="{{number_format($solicitud->totalSolicitado,2)}}" readonly>    
              </div>
            </div>   
        </div>
                    


    
             



 


        <div class="row">
          <div class="col-12">

            <a href="{{route('SolicitudFondos.Observador.Listar')}}" class='btn btn-primary'>
              <i class="fas fa-undo"></i>
              Regresar al menú
            </a>
            
          </div>
        </div>
      
                    
                          
                    
                               
                    
                    
                 
  
</form>

    
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


<style>
    
    .hovered:hover{
    background-color:rgb(97, 170, 170);
}

    </style>

@include('Layout.EstilosPegados')
@section('script')

    
 
     










@endsection
