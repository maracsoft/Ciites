<script>
  function validarFormulario(creando){
    limpiarEstilos([
      'nombres',
      'apellido_paterno',
      'apellido_materno',
      'sexo',

      'dni',
      'telefono',
      'correo',
      'fecha_nacimiento'
	  ]);

    msj = "";

 
    //obligatorios nombres y apellidos
    msj = validarTamañoMaximoYNulidad(msj,'nombres',200,'Nombres');
    msj = validarTamañoMaximoYNulidad(msj,'apellido_paterno',200,'Apellido Paterno');
    msj = validarTamañoMaximoYNulidad(msj,'apellido_materno',200,'Apellido Materno');
    msj = validarTamañoMaximoYNulidad(msj,'fecha_nacimiento',15,'Fecha de Nacimiento');
    msj = validarSelect(msj,'sexo',"",'Sexo');
    // opcionales
    msj = validarTamañoExactoONulidad(msj,'dni',8,"DNI");
    
    msj = validarTamañoMaximo(msj,'telefono',20,"Teléfono");
    msj = validarTamañoMaximo(msj,'correo',30,"Correo");
    
    if(creando){
      limpiarEstilos([
        'codOrganizacion',
        'cargo'
      ]);
      msj = validarSelect(msj,'codOrganizacion',-1,'Organización a la que pertenece');
      msj = validarTamañoMaximoYNulidad(msj,'cargo',100,"Cargo en la organización");
    
    }else{

    }
  

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
                document.getElementById('apellido_paterno').value = persona.apellidoPaterno;
                document.getElementById('apellido_materno').value = persona.apellidoMaterno;
            
            
            }

            $(".loader").fadeOut("slow");
        }
    );
  }

</script>