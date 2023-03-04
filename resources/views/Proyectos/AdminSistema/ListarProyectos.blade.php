@extends('Layout.Plantilla') 

@section('titulo')
    Listado de Proyectos
@endsection

@section('contenido')
<br>

@include('Layout.MensajeEmergenteDatos')

<div class="card">
    <div class="card-header" style=" ">
      <h2 class="card-title">Admin Sistema - Proyectos</h2>
      <div class="card-tools">
        <ul class="nav nav-pills ml-auto">
          <li class="nav-item">
            <a href="{{route('GestiónProyectos.crear')}}" class="nav-link active"><i class="fas fa-plus"></i> Nuevo Registro</a>
          </li>
        </ul>
      </div>
      
    </div>


    

    <!-- /.card-header -->
    <div class="card-body p-0">
      <table class="table table-sm">
        <thead>

          <tr>
            <th scope="col">IdBD</th>
            
            <th scope="col">Cod Proy</th>
            <th scope="col">NOMBRE PROYECTO</th>
            <th scope="col">ESTADO</th>
            
            <th scope="col">GERENTE</th>
            <th scope="col">CONTADOR</th>
            
            
            <th scope="col">Opciones</th>
            
          </tr>

        </thead>
        <tbody>

          @foreach($listaProyectos as $itemProyecto)
            
          
          <tr>
            <td>{{$itemProyecto->codProyecto}}</td>
            <td>{{$itemProyecto->codigoPresupuestal}}</td>
            
            <td>{{$itemProyecto->nombre}}</td>
            <td>

              <select class="form-control " 
                  onchange="actualizarEstado({{$itemProyecto->codProyecto}},'{{$itemProyecto->nombre}}')" style="width: 100%;" data-select2-id="1" 
                  tabindex="-1" aria-hidden="true" data-live-search="true" id="selectEstado">
                @foreach($listaEstados as $estado)
                  <option value="{{$estado->codEstadoProyecto}}" {{$itemProyecto->codEstadoProyecto==$estado->codEstadoProyecto ? 'selected':''}}>
                    {{$estado->nombre}}
                  </option>                                 
                @endforeach
                
              
              </select> 



            </td>
            </td>
            <td>  {{-- BUSCADOR DINAMICO POR NOMBRES --}}
               
              <select class="form-control" onchange="guardar({{$itemProyecto->codProyecto}})" id="Proyecto{{$itemProyecto->codProyecto}}" 
                name="Proyecto{{$itemProyecto->codProyecto}}"  >

                <option value="-1" 
                  @if(is_null($itemProyecto->codEmpleadoDirector))
                      selected
                  @endif>
                  - Seleccione Gerente -
                </option>          
                
                @foreach($listaGerentes as $gerente)
                  <option value="{{$gerente->codEmpleado}}" 
                    {{$itemProyecto->codEmpleadoDirector==$gerente->codEmpleado ? 'selected':''}}>
                    {{$gerente->getNombreCompleto()}}
                  </option>                                 
                @endforeach
               
              
              </select> 
                
            </td>
            <td>   
              <a href="{{route('GestiónProyectos.ListarContadores',$itemProyecto->codProyecto)}}" class="btn btn-success btn-sm btn-icon icon-left">
                <i class="entypo-pencil"></i>Contadores ({{$itemProyecto->nroContadores()}})
              </a>
            </td>
            <td>
              <a href="{{route('GestiónProyectos.editar',$itemProyecto->codProyecto)}}" class="btn btn-info btn-sm">
                <i class="fas fa-pen-square"></i>
                Editar
              </a>

            </td>
          </tr>

          @endforeach

        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <a href="#" onclick="asignarContadoresATodosProyectos()" 
      class="btn btn-success">
    <p>Asignar todos los contadores a todos los proyectos</p>
  </a>
  <!-- /.card -->
<br>

@endsection



<script>


  function asignarContadoresATodosProyectos(){

    swal(
          {//sweetalert
              title: "Confirmar",
              text: '¿Desea asignar todos los contadores activos a todos los proyectos activos?',     //mas texto
              type: "warning",//e=[success,error,warning,info]
              showCancelButton: true,//para que se muestre el boton de cancelar
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText:  'SÍ',
              cancelButtonText:  'NO',
              closeOnConfirm:     true,//para mostrar el boton de confirmar
              html : true
          },
          function(value){//se ejecuta cuando damos a aceptar
            direccion = "{{route('GestionProyectos.setearTodosLosContadoresATodosLosProyectos')}}";
            location.href = direccion;
          }
      );





    
  }

  function guardar(codProyecto){
    var codGerente=$('#Proyecto'+codProyecto).val();
    if(codGerente!="-1"){
      //$.get('/asignarGerentesContadores/actualizar/'+codProyecto+'*'+codGerente+'*1', function(data){
      $.get('/GestiónProyectos/'+codProyecto+'*'+codGerente+'*1'+'/asignarGerente', function(data){
        if(data) alertaMensaje('Enbuenahora','Se actualizó el gerente','success');
        else alerta('No se pudo actualizar el gerente');
      });
    }else{
      alerta('seleccione un Gerente');
    }
    
  }
  

  function actualizarEstado(codProyecto, nombreProyecto){
    codEstado = document.getElementById('selectEstado').value;
   
    $.get('/GestiónProyectos/ActualizarEstado/'+codProyecto+'*'+codEstado, function(data){
      console.log(data);
        if(data == true) 
          alertaMensaje('Enbuenahora','Se actualizó el estado del proyecto','success');
        else{ 
         
          alerta('No se pudo actualizar el estado del proyecto. Hubo un error interno. Contacte con el administrador');
        }
      });

  }
</script>
