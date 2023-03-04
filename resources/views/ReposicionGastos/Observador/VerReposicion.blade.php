@extends('Layout.Plantilla')

@section('titulo')
   
  Ver Reposición de Gastos
@endsection
@section('contenido')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div class="text-center">
    <p class="h1">
      Ver Reposición de Gastos
    </p>
</div>


<form method = "POST" action = "{{route('ReposicionGastos.Empleado.store')}}" onsubmit="return validarTextos()"  enctype="multipart/form-data">
    
    {{-- CODIGO DEL EMPLEADO --}}
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="codEmpleado" id="codEmpleado" value="{{$reposicion->codEmpleadoSolicitante}}">
    <input type="hidden" name="codReposicionGastos" id="codReposicionGastos" value="{{$reposicion->codReposicionGastos}}">
    
    @csrf
    
    
    
    @include('ReposicionGastos.PlantillaVerREP')



    {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
    <input type="hidden" name="cantElementos" id="cantElementos">
    <input type="hidden" name="codigoCedepas" id="codigoCedepas">                          
    <input type="hidden" name="totalRendido" id="totalRendido">

                
    <div class="row" id="divTotal" name="divTotal">                       
        <div class="col-12 col-md-6"  style="">

            @include('ReposicionGastos.DesplegableDescargarArchivosRepo')
            
        </div>   
        <div class="col-12 col-md-2">
          <a href="{{route('ReposicionGastos.exportarPDF',$reposicion->codReposicionGastos)}}" class="btn btn-warning btn-sm">
              <i class="fas fa-download"></i>
              PDF
            </a>
          <a target="blank" href="{{route('ReposicionGastos.verPDF',$reposicion->codReposicionGastos)}}" class="btn btn-warning btn-sm">
              <i class="fas fa-eye"></i>
              verPDF
          </a>
        </div>
        <div class="col-12 col-md-4 row mt-1" style="text-align:center">    
          <div class="col">
            <label for="">Total Gastado: </label>    

          </div>
          <div class="col">
            <input type="text" class="form-control text-right" name="total" 
                id="total" readonly value="{{number_format($reposicion->totalImporte,2)}}">   

          </div>
            
        </div>   
          

        

    </div>
               
        
         

      

    <div class="row p-3">

      <a href="{{route('ReposicionGastos.Observador.Listar')}}" class='btn btn-info'>
        <i class="fas fa-arrow-left"></i> 
        Regresar al Menú
      </a>  
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

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<style>

    .hovered:hover{
        background-color:rgb(97, 170, 170);
    }


    </style>

@section('script')

 




@endsection
