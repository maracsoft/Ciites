@extends('Layout.Plantilla')

@section('titulo')
  Ver 
        Requerimiento de Bienes y Servicios
@endsection

@section('estilos')

<style>
    .BordeCircular{
        border-radius: 10px;
        background-color:rgb(190, 190, 190)
    }
    .hovered:hover{
        background-color:rgb(97, 170, 170);

    }
</style>
@endsection

@section('contenido')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div >
    <p class="h1" style="text-align: center">
        Ver Requerimiento de Bienes y Servicios
    </p>

</div>
    @include('Layout.MensajeEmergenteDatos')
    @include('RequerimientoBS.Plantillas.PlantillaVerRequerimiento')
    

    @if($requerimiento->estaContabilizada())
        <div class="row">
            
            @if($requerimiento->puedeMarcarFactura())
                <div class="col">
                    <button type="button" onclick="clickMarcarQueYaTieneFactura()" class="btn btn-success  ">
                        Factura en Sistema 
                        <i class="fas fa-check"></i>
                    </button>
                </div>
                
            @endif
                
            
            @if($requerimiento->adminPuedeSubirArchivos())
                
                <div class="col BordeCircular" id="divEnteroArchivo">    
                     
                    <form method = "POST" action = "{{route('RequerimientoBS.Empleado.SubirFactura')}}" id="frmSubirArchivosAdmin" name="frmSubirArchivosAdmin"  enctype="multipart/form-data">
                        @csrf
                        <input type="{{App\Configuracion::getInputTextOHidden()}}" id="codRequerimiento" name="codRequerimiento" value="{{$requerimiento->codRequerimiento}}">
                        
                        <div class="row">
                            <div class="col ">
                            
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipoIngresoArchivos" id="ar_añadir" value="1" checked>
                                    <label class="form-check-label" for="ar_añadir">
                                        Añadir Archivos
                                    </label>
                                </div>
                                 
                        

                            </div>
                            <div class="w-100"></div>
                            <div class="col">
                                <input type="{{App\Configuracion::getInputTextOHidden()}}" name="nombresArchivos" id="nombresArchivos" value="">
                                <input type="file" multiple class="btn btn-primary" name="filenames[]" id="filenames"        
                                        style="display: none" onchange="cambio()">  
                                                <input type="hidden" name="nombreImgImagenEnvio" id="nombreImgImagenEnvio">                 
                                <label class="label" for="filenames" style="font-size: 12pt;">       
                                        <div id="divFileImagenEnvio" class="hovered">       
                                        Seleccionar archivo(s) de factura  
                                        <i class="fas fa-upload"></i>        
                                    </div>       
                                </label>  

                            </div>
                        </div>

                        <div class="row">
                            <div class="col text-left">
                                <button type="button" class="btn btn-primary" onclick="clickSubirArchivos()">
                                    <i class="fas fa-save"></i>
                                    Guardar archivos
                                </button>
                            </div>
                        </div>
                    

                    </form>
                </div>    
            @endif

        </div>


    @endif
      



    <div class="row p-3">  

      <a href="{{route('RequerimientoBS.Empleado.Listar')}}" class='btn btn-info'>
          <i class="fas fa-arrow-left"></i> 
          Regresar al Menú
      </a>              
          
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

@section('script')

<script>
                                                        

    function clickMarcarQueYaTieneFactura(){
        confirmarConMensaje('Confirmación','¿Desea marcar la factura como HABIDA? <br> Asegúrese de que la factura se encuentre en los archivos del Colaborador/Administrador.','warning',ejecutarMarcarFacturaHabida);
    }

    function ejecutarMarcarFacturaHabida(){
        location.href = "{{route('RequerimientoBS.Empleado.marcarQueYaTieneFactura',$requerimiento->codRequerimiento)}}"
    }


    function clickSubirArchivos(){
        msjError = validarArchivos();
        if(msjError!="")
        {
            alerta(msjError);
            return ;
        }  

        confirmarConMensaje('Confirmación','¿Desea subir los archivos ingresados?','warning',ejecutarSubirArchivos);
    }

    function ejecutarSubirArchivos(){

        document.frmSubirArchivosAdmin.submit();

    }

    
    function cambio(){
        msjError = validarArchivos();
        if(msjError!=""){
            alerta(msjError);
            return;
        }
        vectorNombresArchivos = [];
        listaArchivos="";

        cantidadArchivos = document.getElementById('filenames').files.length;

        console.log('----- Cant archivos seleccionados:' + cantidadArchivos);
        for (let index = 0; index < cantidadArchivos; index++) {
            nombreAr = document.getElementById('filenames').files[index].name;
            console.log('Archivo ' + index + ': '+ nombreAr);
            listaArchivos = listaArchivos +', '+  nombreAr; 
            vectorNombresArchivos.push(nombreAr);
        }
        listaArchivos = listaArchivos.slice(1, listaArchivos.length);
        document.getElementById("divFileImagenEnvio").innerHTML= listaArchivos;
        
        document.getElementById("nombresArchivos").value= JSON.stringify(vectorNombresArchivos); //input que se manda
    }

    function validarArchivos(){
        cantidadArchivos = document.getElementById('filenames').files.length;
        
        msj="";
        for (let index = 0; index < cantidadArchivos; index++) {
            var imgsize = document.getElementById('filenames').files[index].size;
            nombre = document.getElementById('filenames').files[index].name;
            if(imgsize > {{App\Configuracion::pesoMaximoArchivoMB}}*1000*1000 ){
                msj=('El archivo '+nombre+' supera los  {{App\Configuracion::pesoMaximoArchivoMB}}Mb, porfavor ingrese uno más liviano o comprima.');
            }
        }
        
        if(cantidadArchivos=="")
            msj="Debe seleccionar archivos a subir.";

        return msj;

    }


        
</script>



@endsection
