

<div id="divEnteroArchivo">            

    {{-- Contiene los nombres de los archivos listados en formato json, OCULTO --}}
    <input type="{{App\Configuracion::getInputTextOHidden()}}" name="nombresArchivos" id="nombresArchivos" value="">
    
    {{-- El input real que es un FILE y contiene las referencias a los archivos, OCULTO --}}
    <input type="file" multiple class="" name="filenames[]" id="filenames"        
            style="{{App\Configuracion::getDisplayNone()}}" onchange="cambio()">  
                             
    {{-- Esto es lo que se muestra, es un label que contiene los nombres de los archivos a enviar  --}}
    <label class="label" for="filenames" style="font-size: 12pt;">       
            <div id="divFileImagenEnvio" class="hovered p-2">       
            {{$textoPorDefecto}}
            <i class="fas fa-upload"></i>        
        </div>       
    </label>       
</div>  



<script>
    function cambio(){
        msjError = validarPesoArchivos();
        if(msjError!=""){
            alerta(msjError);
            document.getElementById('filenames').value = null
            return;
        }
    
        listaArchivos="";
        vectorNombresArchivos = [];

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


    
    function validarPesoArchivos(){
        cantidadArchivos = document.getElementById('filenames').files.length;
        
        msj="";
        for (let index = 0; index < cantidadArchivos; index++) {
            var imgsize = document.getElementById('filenames').files[index].size;
            nombre = document.getElementById('filenames').files[index].name;

            if(imgsize > {{$tamañoMaximo}}*1000*1000 ){
                msj=('El archivo '+nombre+' supera los  {{$tamañoMaximo}}Mb, porfavor ingrese uno más liviano o comprima.');
            }
        }
        
        if(cantidadArchivos == 0){
            msj = "No se ha seleccionado ningún archivo.";
            document.getElementById("nombresArchivos").value = null;
            document.getElementById("divFileImagenEnvio").innerHTML = "{{$textoPorDefecto}}";
        }
    

    
        return msj;
    
    }


</script>