@extends('Layout.Plantilla')

@section('titulo')
    Editar Unidad
@endsection
@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')

    
<script type="text/javascript"> 
          
    function validarregistro() 
        {


            if (document.getElementById("nombre").value == ""){
                alerta("Ingrese el nombre del proyecto");
                $("#nombre").focus();
            }

            else{
                document.frmempresa.submit(); // enviamos el formulario	
            }
        }
    
</script>

<form id="frmempresa" name="frmempresa" role="form" action="{{route('GestiónUnidadMedida.update')}}" 
class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">

@csrf 


<div class="well"><H3 style="text-align: center;">CREAR UNIDAD</H3></div>
<br>
<div class="container">
    <div class="row">
        <div class="col-2" style="">
            
        
        </div>
        

        <div class="col" style="">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <label class="" style="">Código:</label>
                        <div class="">
                            <input type="text" class="form-control" id="codUnidadMedida" name="codUnidadMedida"
                            value="{{$unidad->codUnidadMedida}}"  placeholder="..." readonly>
                        </div>
                    </div>

                    <div class="w-100"></div>

                    <div class="col">

                        
                        <label class="" style="">Nombre:</label>
                        
                        
                        <div class="">
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                value="{{$unidad->nombre}}" placeholder="Nombre..." >
                        </div>
                    </div>
                    
                    
                    
                    <div class="w-100"></div>
                    <br>
                    <div class="col" style=" text-align:center">
                       
                        <button type="button" class="btn btn-primary float-right"  onclick="validarregistro()">
                          <i class='fas fa-save'></i> 
                          Registrar
                        </button> 
                        
                        <a href="{{route('GestiónUnidadMedida.listar')}}" class='btn btn-info float-left'><i class="fas fa-arrow-left"></i> Regresar al Menu</a>
    
                    </div>

                </div>

            </div>
               
        </div>
        <div class="col-2" >
         
        
        </div>


    </div>


</div>

</form>
@endsection


@section('script')  
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
     <script src="/select2/bootstrap-select.min.js"></script> 
@endsection
