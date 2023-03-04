@extends('Layout.Plantilla')

@section('titulo')
    Editar Usuario
@endsection

@section('tiempoEspera')
    <div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div >
    <p class="h1" style="text-align: center">
        Editar Usuario
    </p>
</div>


<form method = "POST" action = "{{route('CITE.Usuarios.Actualizar')}}" id="frmUsuarioCite" name="frmUsuarioCite"  enctype="multipart/form-data">
    
    <input type="hidden" name="codUsuario" value="{{$usuario->getId()}}">
    
    @csrf

   
    <div class="card mx-2">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <div class="d-flex flex-row">
                <div class="">
                    <h3 class="card-title">
                        {{--  <i class="fas fa-chart-pie"></i> --}}
                        <b>Información General</b>
                    </h3>
    
                </div>
               
                <div class="ml-1 mt-1">
                    <span class="fontSize10">
                        (Servicio registrado el 
                        <b>
                            {{$usuario->getFechaHoraCreacion()}}
                        </b>
                            por 
                        <b>
                            {{$usuario->getEmpleadoCreador()->getNombreCompleto()}}</b>)
                    </span>    
                </div>
    
            </div>
        </div> 
        <div class="card-body">






            <div class="row">
                                
                <div class="col-4">
                    <div>
                        <label for="">DNI:</label>
                    </div>
                    <div class="d-flex">
                        <div>
                            <input type="number" class="form-control" id="dni" name="dni" value="{{$usuario->dni}}">
                        </div>
                        <div>
                            <button type="button" title="Buscar por DNI en la base de datos de Sunat" 
                                class="btn-sm btn btn-info d-flex align-items-center m-1" id="botonBuscarPorRUC" onclick="consultarUsuarioPorDNI()" >
                                <i class="fas fa-search m-1"></i>
                                
                            </button>
                        </div>
                    
                    </div>
                </div>
            
                <div class="col-4">
                    <label for="">Teléfono:</label>
                    <input type="number" class="form-control" id="telefono" name="telefono" value="{{$usuario->telefono}}">

                    
                </div>
                <div class="col-4">
                    <label for="">Correo:</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="{{$usuario->correo}}">

                </div>
                <div class="col-4">
                    <label for="">Nombres:</label>
                    <input type="text" class="form-control" id="nombres" name="nombres" value="{{$usuario->nombres}}">
                
                </div>
                <div class="col-4">

                    <label for="">Apellido Paterno:</label>
                    <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" value="{{$usuario->apellidoPaterno}}">
                

                </div>
                <div class="col-4">
                    
                    <label for="">Apellido Materno:</label>
                    <input type="text"  class="form-control" id="apellidoMaterno" name="apellidoMaterno" value="{{$usuario->apellidoMaterno}}">

                </div>
                    
            


            </div>
            
            <div class="row">
                <div class="ml-auto m-2">

                    <button type="button" class="btn btn-primary" id="btnEditar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                        onclick="guardar()">
                        <i class='fas fa-save'></i> 
                        Guardar
                    </button> 
                    
                </div>

            </div>
        </div>
    </div>


    <div class="d-flex flex-row m-4">
        <div class="">

            <a href="{{route('CITE.Usuarios.Listar')}}" class='btn btn-info '>
                <i class="fas fa-arrow-left"></i> 
                Regresar al Menú
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

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

@include('Layout.EstilosPegados')
@include('Layout.ValidatorJS')
@section('script')
  
<script type="application/javascript">
        
        $(document).ready(function(){
            $(".loader").fadeOut("slow");
            
            
        });
        
        function guardar(){
            msjError = validarUsuario();
            if(msjError!= ""){
                alerta(msjError);
                return;
            }

            confirmarConMensaje('Confirmación','¿Desea actualizar el usuario?','warning',function(){            
                document.frmUsuarioCite.submit();

            })
        }

        function validarUsuario(){

            msj = "";
            limpiarEstilos(['dni','nombres','telefono','apellidoMaterno','correo','apellidoPaterno',])

            msj = validarTamañoExacto(msj,'dni',8,'DNI')
            //msj = validarTamañoMaximoYNulidad(msj,'telefono',200,'telefono')
            //msj = validarTamañoMaximoYNulidad(msj,'correo',200,'correo')
            msj = validarTamañoMaximoYNulidad(msj,'nombres',200,'nombres')
            msj = validarTamañoMaximoYNulidad(msj,'apellidoPaterno',200,'apellidoPaterno')
            msj = validarTamañoMaximoYNulidad(msj,'apellidoMaterno',200,'apellidoMaterno')

            

            return msj;
        }
 
        
        
        function consultarUsuarioPorDNI(){

            msjError="";

            msjError = validarTamañoExacto(msjError,'dni',8,'DNI');
            msjError = validarNulidad(msjError,'dni','DNI');


            if(msjError!=""){
                alerta(msjError);
                return;
            }


            $(".loader").show();//para mostrar la pantalla de carga
            dni = document.getElementById('dni').value;

            $.get('/ConsultarAPISunat/dni/'+dni,
                function(data){     
                    console.log("IMPRIMIENDO DATA como llegó:");
                    
                    data = JSON.parse(data);
                    
                    console.log(data);
                    persona = data.datos;

                    alertaMensaje(data.mensaje,data.titulo,data.tipoWarning);
                    if(data.ok==1){
                        document.getElementById('nombres').value = persona.nombres;
                        document.getElementById('apellidoPaterno').value = persona.apellidoPaterno;
                        document.getElementById('apellidoMaterno').value = persona.apellidoMaterno;
                    
                    
                    }

                    $(".loader").fadeOut("slow");
                }
            );
        }


    </script>
     


@endsection
 