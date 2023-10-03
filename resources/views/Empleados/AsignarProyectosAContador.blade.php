@extends('Layout.Plantilla')

@section('titulo')
    Proyectos del Contador
@endsection
@section('estilos')
<style>
  .grande{
    width: 60px;
    height: 20px;

  }

</style>
@endsection
@section('contenido')

@include('Layout.MensajeEmergenteDatos')
<div class="card-body">

    <div class="well">
        <H3 style="text-align: center;">
            <strong>
                Asignar proyectos al contador
            </strong>
        </H3>
    </div>
    
    <div class="card mt-1">
        <div class="card-header" style=" ">
            <div class="row">
                <div class="col">
                    
                    <h3>Colaborador Contador:</h3>
                    {{$empleado->getNombreCompleto()}}
                </div>   

                <div class="col">
                  <br>
                  <button type="button" onclick="asignarTodosLosProyectos()" class="btn btn-success">
                    Asignar todos los proyectos
                  </button>
                </div>

                <div class="col">
                  <br>
                  <button type="button" onclick="quitarTodosLosProyectos()" class="btn btn-danger">
                    Quitar todos los proyectos
                  </button>
                </div>

                <div class="col">
                  <form action="{{route('GestionUsuarios.AsignarContadorAProyectosPorComas')}}" method="POST">
                    @csrf
                    <input type="hidden" name="codEmpleado" value="{{$empleado->codEmpleado}}">
                    <div class="d-flex">

                      <div>
                        <label for="">
                          Añadir en grupo por códigos presupuestales
                        </label>
                        <input class="form-control" type="text" name="array_cods_proyectos" id="array_cods_proyectos" placeholder="Separados por comas">
                        
                      </div>
                      <div class="d-flex">
                        <button class="mt-auto btn btn-success" type="submit">
                          Añadir
                        </button>
                      </div>
                 
                    </div>
                  </form>
                </div>

                <div class="col">
                  <form action="{{route('GestionUsuarios.QuitarContadorAProyectosPorComas')}}" method="POST">
                    @csrf
                    <input type="hidden" name="codEmpleado" value="{{$empleado->codEmpleado}}">
                    <div class="d-flex">

                      <div>
                        <label for="">
                          Quitar en grupo por códigos presupuestales
                        </label>
                        <input class="form-control" type="text" name="array_cods_proyectos" id="array_cods_proyectos" placeholder="Separados por comas">
                        
                      </div>
                      <div class="d-flex">
                        <button class="mt-auto btn btn-danger" type="submit">
                          Quitar
                        </button>
                      </div>
                 
                    </div>
                  </form>
                </div>
            
            </div>

        </div>
    </div>

    <table class="table table-bordered table-hover datatable table-sm" style="font-size: 10pt" id="table-3">
      <thead>                  
        <tr>
          
          
          <th>Proyecto</th>
          <th>Estado</th>
          <th>
            Código Presupuestal
          </th>
          <th>Asignado</th>
          
        </tr>
      </thead>
      <tbody>

        @foreach($listaProyectos as $proyecto)
            <tr>
                
                    
               
                <td>
                    [{{$proyecto->codigoPresupuestal}}]  {{$proyecto->nombre}}
                </td>
                <td>
                    {{$proyecto->getEstado()->nombre}}
                </td>
                <td class="text-right">
                  {{$proyecto->codigoPresupuestal}}
                </td>

                <td class="text-center">
                    <input class="grande"  type="checkbox" id="CB{{$proyecto->codProyecto}}"    {{-- Este es solo pa mostrarlo en el alert --}}
                      onchange="actualizarEstado({{$proyecto->codProyecto}},'{{$proyecto->nombre}}')" 
                      {{$proyecto->getCheckedSiTieneContador($empleado->codEmpleado)}}
                      >
                </td>
                
            </tr>
        @endforeach
        
      </tbody>
    </table>
    
  </div>


@endsection

@section('script')
<script>
  
  codEmpleado = {{$empleado->codEmpleado}};
  function actualizarEstado(codProyecto,nombreProyecto){
    chekBox = document.getElementById('CB'+codProyecto);

    variacion = "";
   
    if(!chekBox.checked)//si está solucionado, pasará a no solucionado
      variacion = " NO";
      
    //$.get('/asignarGerentesContadores/actualizar/'+codProyecto+'*'+codGerente+'*1', function(data){
    $.get("/GestiónUsuarios/asignarProyectoAContador/"+codEmpleado+"*"+codProyecto, function(data){
      if(data==1) /* Ya existia y lo destruimos */
        alertaMensaje('Enbuenahora','Se ELIMINÓ el contador {{$empleado->getNombreCompleto()}} del proyecto '+nombreProyecto+'.','success');
      
      if(data==2) /* no existia y lo creamos */
        alertaMensaje('Enbuenahora','Se AGREGÓ al contador {{$empleado->getNombreCompleto()}} al proyecto '+nombreProyecto+'.','success');
      
      if(data==0)
      {
        alerta('Hubo un error, verifique su conexión');
        chekBox.checked = !chekBox.checked;
      }
      
    });
    
  }
  
  function asignarTodosLosProyectos(){

    $.get("/GestiónUsuarios/asignarContadorATodosProyectos/"+codEmpleado, function(data){
      
      if(data==1) /* no existia y lo creamos */
        alertaMensaje('Enbuenahora','Se AGREGÓ al contador {{$empleado->getNombreCompleto()}} a todos los proyectos','success');
      
      if(data==0)
        alerta('Hubo un error, verifique su conexión');
        
      
      location.reload();
    });

  }

  function quitarTodosLosProyectos(){

    $.get("/GestiónUsuarios/quitarContadorATodosProyectos/"+codEmpleado, function(data){
      
      if(data==1) /* no existia y lo creamos */
        alertaMensaje('Enbuenahora','Se QUITÓ al contador {{$empleado->getNombreCompleto()}} de todos los proyectos','success');
      
      if(data==0)
      
        alerta('Hubo un error, verifique su conexión');
        
      
      location.reload();
    });


  }
</script>
@endsection
