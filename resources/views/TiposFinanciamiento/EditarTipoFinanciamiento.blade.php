@extends('Layout.Plantilla')

@section('titulo')
    Editar Entidad Financiera
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
                document.frmtipoFinanciamiento.submit(); // enviamos el formulario	
            }
        }
    
</script>

<form id="frmtipoFinanciamiento" name="frmtipoFinanciamiento" role="form" 
    action="{{route('TipoFinanciamiento.actualizar')}}" 
class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">

@csrf 


<div class="well"><H3 style="text-align: center;">Actualizar Tipo de Financiamiento</H3></div>
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
                            <input type="text" class="form-control" id="codTipoFinanciamiento" name="codTipoFinanciamiento"
                            value="{{$tipoFinanciamiento->codTipoFinanciamiento}}"  placeholder="..." readonly>
                        </div>
                    </div>

                    <div class="w-100"></div>

                    <div class="col">

                        
                        <label class="" style="">Nombre:</label>
                        
                        
                        <div class="">
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                value="{{$tipoFinanciamiento->nombre}}" placeholder="Nombre..." >
                        </div>
                    </div>
                    
                    
                
                    <div class="w-100"></div>
                    <br>
                    <div class="col" style=" text-align:center">
                 
                       
                        <button type="button" class="btn btn-primary float-right" onclick="validarregistro()">
                        <i class='fas fa-save'></i> 
                        Registrar
                    </button> 
                        
                        <a href="{{route('TipoFinanciamiento.listar')}}" class='btn btn-info float-left'>
                            <i class="fas fa-arrow-left"></i> 
                            Regresar al Menu
                        </a>
    
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
