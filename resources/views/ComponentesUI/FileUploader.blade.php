@php
  $names = $filenames_input_name."_".$r;
  $file_name = $file_input_name."_".$r;

  $contenido_label_defecto = "$showedText <i class='fas fa-upload'></i>";
  if($isMultiple){
    $multiple_text = "multiple";
  }else{
    $multiple_text = "";
  }
   
@endphp

<div id="divEnteroArchivo">            

    {{-- Contiene los nombres de los archivos listados en formato json, OCULTO --}}
    <input type="{{App\Configuracion::getInputTextOHidden()}}" name="{{$filenames_input_name}}" id="{{$names}}" value="">
    
    {{-- El input real que es un FILE y contiene las referencias a los archivos, OCULTO --}}
    <input type="file" {{$multiple_text}} class="" name="{{$file_input_name}}[]" id="{{$file_name}}"        
            style="{{App\Configuracion::getDisplayNone()}}" onchange="onFileInput_{{$r}}()">  
                             
    {{-- Esto es lo que se muestra, es un label que contiene los nombres de los archivos a enviar  --}}
    <label class="label mb-0" for="{{$file_name}}" style="font-size: 12pt;">       
      <div id="divFileImagenEnvio_{{$r}}" class="cursor-pointer hovered p-2">
        @php
          echo $contenido_label_defecto 
        @endphp

      </div>       
    </label>       
</div>  



<script>


    


    function onFileInput_{{$r}}(){
        msjError = validarArchivos_{{$r}}();

        if(msjError!=""){
            alerta(msjError);
            document.getElementById('{{$file_name}}').value = null;
            document.getElementById("divFileImagenEnvio_{{$r}}").innerHTML= "@php echo $contenido_label_defecto @endphp";
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


    
    function validarArchivos_{{$r}}(){

        const ValidFileTypes = @json($file_types);

        cantidadArchivos = document.getElementById('{{$file_name}}').files.length;
        
        msj="";
        for (let index = 0; index < cantidadArchivos; index++) {
            var imgsize = document.getElementById('{{$file_name}}').files[index].size;
            nombre = document.getElementById('{{$file_name}}').files[index].name;

            if(imgsize > {{$maxSize}}*1000*1000 ){
                msj=('El archivo '+nombre+' supera los  {{$maxSize}}Mb, porfavor ingrese uno más liviano o comprima.');
            }

            //validamos terminacion
            if(ValidFileTypes){
              var nombre_mayus = nombre.toUpperCase();
              var cumple_alguna = false;
              for (let index = 0; index < ValidFileTypes.length; index++) {
                const terminacion = ValidFileTypes[index];
                if(nombre_mayus.includes(terminacion)){
                  cumple_alguna = true;
                }
              }

              if(!cumple_alguna){
                msj = "El archivo debe ser formato " + ValidFileTypes.toString();
              } 

            }

        }
        
        if(cantidadArchivos == 0){
            msj = "No se ha seleccionado ningún archivo.";
            document.getElementById("{{$names}}").value = null;
            document.getElementById("divFileImagenEnvio_{{$r}}").innerHTML = "@php echo $contenido_label_defecto @endphp";
        }
        



    
        return msj;
    
    }



</script>