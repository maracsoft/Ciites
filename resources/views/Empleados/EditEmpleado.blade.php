@extends('Layout.Plantilla')

@section('titulo')
    Editar Datos de Empleado
@endsection
@section('tiempoEspera')

<div class="loader" id="pantallaCarga"></div>

@endsection

@section('contenido')

    
    <div class="well">
      <H3 style="text-align: center;">
        EDITAR EMPLEADO
      </H3>
    </div>
    <div class="container">

      <form id="frmempresa" name="frmempresa" role="form" action="{{route('GestionUsuarios.updateEmpleado')}}" class=""method="post" enctype="multipart/form-data">
          @csrf 
          <input type="text" class="form-control" id="codEmpleado" name="codEmpleado" placeholder="Codigo" value="{{ $empleado->codEmpleado}}" hidden>
          

          <div class="row">
              <div class="col">
                <label class="">
                  Codigo:
                </label>
                <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Codigo..." value="{{$empleado->codigoCedepas}}">
            
              </div>

              <div class="col">
                <label class="">
                  Nombres:
                </label>
                
                <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres..."  value="{{$empleado->nombres}}">
            
              </div>

              <div class="col">
                <label class="">
                  Apellidos:
                </label>
                
                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos..." value="{{$empleado->apellidos}}" >
              
              </div>
              <div class="col">
                <label class="">
                  Correo:
                </label>
                <input type="text" class="form-control" id="correo" name="correo" placeholder="example@gmail.com" value="{{$empleado->correo}}" >
              </div>
          
              <div class="w-100"></div>
               
              <div class="col">
                <label class="">
                  DNI:
                </label>
                <button type="button" onclick="consultarPorDNI()" class="btn btn-primary btn-xs" title="">
                    <i class="fas fa-search"></i>
                </button>
                
                <input type="number" class="form-control" id="DNI" name="DNI" placeholder="DNI..."  value="{{$empleado->dni}}">
            
              </div>

             
          
              <div class="col">
                <label class="">
                  Sede:
                </label>
            
                <select class="form-control" name="codSede" id="codSede" value="{{$empleado->codSede}}">
                    @foreach($sedes as $itemsede)
                    <option value="{{$itemsede->codSede}}">{{$itemsede->nombre}}</option>    
                    @endforeach
                </select>
              
              </div>

              <div class="col">
                <label class="" >
                  Mostrar en Listas:
                </label>
                
                  
                  <x-toggle-button name="mostrarEnListas" :initialValue="$empleado->mostrarEnListas"  onChangeFunctionName=""  setExternalValueFunctionName=""/>

                
                
              </div>


              
              <div class="w-100"></div>
              
              <div class="col">
                  <label class="">
                    Sexo:
                  </label>
                  @php
                    $esHombre = $empleado->sexo=="H";
                    if($esHombre){
                      $selH = "selected";
                      $selM = ""; 
                    }else{
                      $selH = "";
                      $selM = "selected";   
                    }
                  @endphp
                  <select class="form-control" name="sexo" id="sexo" value="{{$empleado->sexo}}">
                      <option value="-1">- Sexo -</option>
                      <option value="M" {{$selM}}>Mujer</option>
                      <option value="H" {{$selH}}>Hombre</option>
                  </select>
              
              </div>

              <div class="col">
                  <label class="">
                    Fecha Nacimiento:
                  </label>
                  
                  <div class="col">
                    <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                      <input type="text" style="text-align: center" class="form-control" name="fechaNacimiento" id="fechaNacimiento" 
                          value="{{$empleado->getFechaNacimiento()}}" style="font-size: 10pt;"> 
                      <div class="input-group-btn">                                        
                          <button class="btn btn-primary date-set" type="button"   onclick="">
                              <i class="fas fa-calendar fa-xs"></i>
                          </button>
                      </div>
                    </div>   
                  </div>
              
              </div>
          
              <div class="col">
                <label class="">
                  Cargo:
                </label>
                
                <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo..."  value="{{$empleado->nombreCargo}}">
            
              </div>

              <div class="col">
                <label class="">
                  Direccion:
                </label>
                
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion..."  value="{{$empleado->direccion}}">
            
              </div>

              <div class="col">
                <label class="">
                  Teléfono:
                </label>
                
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono..." value="{{$empleado->nroTelefono}}" >
            
              </div>

          </div>
          <div class="row my-2 d-flex">
            
            <button type="button" class="btn btn-primary ml-auto" onclick="validarregistro()" >
              <i class="fas fa-save"></i>
              Registrar
            </button>

          </div>

              
          <div class="card my-2 mx-1">
            <div class="card-header">
              <h4>
                Roles en el sistema
              </h4>
            </div>
            <div class="card-body">
              
              <table class="table table-bordered table-hover datatable text-center">
                <thead>
                  <tr>
                    <th>
                      ROL
                    </th>
                    <th>
                      ESTADO
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($puestos as $puesto)
                    <tr>
                      <td>
                        {{$puesto->nombreAparente}}
                      </td>
                      <td class="">
                        <input class="grande" type="checkbox" id="CB_{{$puesto->codPuesto}}" onchange="actualizarEstado({{$puesto->codPuesto}})"
                          @if($empleado->verificarPuesto($puesto->codPuesto))
                            checked
                          @endif
                        >
                      </td>
                    </tr>
                  @endforeach
                </tbody>
               
              </table>
            </div>
          </div>
            
          <div class="row d-flex flex-row mb-5 p-3">
               
            <a href="{{route('GestionUsuarios.Listar')}}" class="btn btn-info mr-auto">
                <i class="fas fa-arrow-left"></i> 
                Regresar al Menu
            </a>
      

          
          </div>
              

      </form>
    </div>

    


@endsection


@section('script')
@include('Layout.ValidatorJS')
   

<script type="text/javascript"> 
    $(window).load(function(){
        
      $(".loader").fadeOut("slow");
    });
    
    function limpiarEstilos(listaInputs){
         listaInputs.forEach(element => {
            cambiarEstilo(element,'form-control')
         });

    }
    
    function cambiarEstilo(name, clase){
        document.getElementById(name).className = clase;
    }
    function validarFormulario(){
        limpiarEstilos(
            ['nombres','apellidos','DNI','correo','codigo','sexo','fechaNacimiento','cargo','direccion','telefono']);
        msj = "";
        
       
        msj = validarTamañoMaximoYNulidad(msj,'codigo',{{App\Configuracion::tamañoMaximoCodigoCedepas}},'Código del Colaborador');
        
        msj = validarTamañoMaximoYNulidad(msj,'nombres',{{App\Configuracion::tamañoMaximoNombres}},'nombres');
        msj = validarTamañoMaximoYNulidad(msj,'correo',{{App\Configuracion::tamañoMaximoCorreo}},'correo');
        msj = validarTamañoMaximoYNulidad(msj,'apellidos',{{App\Configuracion::tamañoMaximoApellidos}},'apellidos');
        msj = validarNulidad(msj,'DNI','DNI');

        msj = validarNulidad(msj,'fechaNacimiento','Fecha de Nacimiento');
         
        msj = validarTamañoMaximoYNulidad(msj,'cargo',{{App\Configuracion::tamañoMaximoNombreCargo}},'Nombre del Cargo');
        msj = validarTamañoMaximoYNulidad(msj,'direccion',{{App\Configuracion::tamañoMaximoDireccion}},'Direccion');
        msj = validarTamañoMaximoYNulidad(msj,'telefono',{{App\Configuracion::tamañoMaximoTelefono}},'Telefono');

        msj = validarTamañoExacto(msj,'DNI',8,'DNI'); 
        msj = validarRegExpNombres(msj,'nombres');
        msj = validarRegExpApellidos(msj,'apellidos');
      
      
        msj = validarSelect(msj,'sexo',-1,'Sexo');

        return msj;

    }

    function validarregistro(){
        msj = validarFormulario();
        if(msj!=''){
            alerta(msj);
            return;
        }
        
        confirmarConMensaje('Confirmacion','¿Desea editar el empleado?','warning',ejecutarSubmit);
    }

    function ejecutarSubmit(){

        document.frmempresa.submit(); // enviamos el formulario	  

    }
    function consultarPorDNI(){

      msjError="";

      msjError = validarTamañoExacto(msjError,'DNI',8,'DNI');
      msjError = validarNulidad(msjError,'DNI','DNI');


      if(msjError!=""){
          alerta(msjError);
          return;
      }


      $(".loader").show();//para mostrar la pantalla de carga
      dni = document.getElementById('DNI').value;

      $.get('/ConsultarAPISunat/dni/'+dni,
        function(data){     
          console.log("IMPRIMIENDO DATA como llegó:");
          
          data = JSON.parse(data);
            
          console.log(data);
          persona = data.datos;

          alertaMensaje(data.mensaje,data.titulo,data.tipoWarning);

          if(data.ok==1){
              document.getElementById('nombres').value   = persona.nombres; 
              document.getElementById('apellidos').value =  persona.apellidoPaterno + " " + persona.apellidoMaterno;


              

          }
      
          $(".loader").fadeOut("slow");
        });
    }

    
    function actualizarEstado(codPuesto){
      var codEmpleado = {{$empleado->getId()}};
      var data = {
        codEmpleado:codEmpleado,
        codPuesto:codPuesto
      }

      $(".loader").show();//para mostrar la pantalla de carga
      $.get("/GestionPuestos/TogleEmpleadoPuesto/", data, function(resp){
        objetoRespuesta = JSON.parse(resp)
        console.log(resp)

        alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);

        $(".loader").fadeOut("slow");
      });


    }
</script>

 @endsection

 @section('estilos')
<style>
    .grande{
    width: 100px;
    height: 40px;

  }
</style>
 @endsection