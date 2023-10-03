@php
  $names = $filenames_input_name."_".$r;
  $file_name = $file_input_name."_".$r;

@endphp

<div id="divEnteroArchivo">            

    {{-- Contiene los nombres de los archivos listados en formato json, OCULTO --}}
    <input type="{{App\Configuracion::getInputTextOHidden()}}" name="{{$filenames_input_name}}" id="{{$names}}" value="">
    
    {{-- El input real que es un FILE y contiene las referencias a los archivos, OCULTO --}}
    <input type="file" multiple class="" name="{{$file_input_name}}[]" id="{{$file_name}}"        
            style="{{App\Configuracion::getDisplayNone()}}" onchange="onFileInput_{{$r}}()">  
                             
    {{-- Esto es lo que se muestra, es un label que contiene los nombres de los archivos a enviar  --}}
    <label class="label" for="{{$file_name}}" style="font-size: 12pt;">       
      <div id="divFileImagenEnvio_{{$r}}" class="hovered p-2">       
        {{$showedText}}
        <i class="fas fa-upload"></i>        
      </div>       
    </label>       
</div>  



<script>
    function onFileInput_{{$r}}(){
        msjError = validarPesoArchivos_{{$r}}();
        if(msjError!=""){
            alerta(msjError);
            document.getElementById('{{$file_name}}').value = null
            return;
        }
    
        listaArchivos="";
        vectorNombresArchivos = [];

        cantidadArchivos = document.getElementById('{{$file_name}}').files.length;
    
        console.log('----- Cant archivos seleccionados:' + cantidadArchivos);
        for (let index = 0; index < cantidadArchivos; index++) {
            nombreAr = document.getElementById('{{$file_name}}').files[index].name;
            console.log('Archivo ' + index + ': '+ nombreAr);
            listaArchivos = listaArchivos +', '+  nombreAr; 
            
            vectorNombresArchivos.push(nombreAr);
        }
        listaArchivos = listaArchivos.slice(1, listaArchivos.length);
        document.getElementById("divFileImagenEnvio_{{$r}}").innerHTML= listaArchivos;
        document.getElementById("{{$names}}").value= JSON.stringify(vectorNombresArchivos); //input que se manda

    }


    
    function validarPesoArchivos_{{$r}}(){
        cantidadArchivos = document.getElementById('{{$file_name}}').files.length;
        
        msj="";
        for (let index = 0; index < cantidadArchivos; index++) {
            var imgsize = document.getElementById('{{$file_name}}').files[index].size;
            nombre = document.getElementById('{{$file_name}}').files[index].name;

            if(imgsize > {{$maxSize}}*1000*1000 ){
                msj=('El archivo '+nombre+' supera los  {{$maxSize}}Mb, porfavor ingrese uno más liviano o comprima.');
            }
        }
        
        if(cantidadArchivos == 0){
            msj = "No se ha seleccionado ningún archivo.";
            document.getElementById("{{$names}}").value = null;
            document.getElementById("divFileImagenEnvio_{{$r}}").innerHTML = "{{$showedText}}";
        }
    

    
        return msj;
    
    }


</script>