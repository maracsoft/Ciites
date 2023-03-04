@extends('Layout.Plantilla')
@section('titulo')
    Contadores del proyecto
@endsection
@section('contenido')

<div class="card-body">
    
    <div class="well">
      <H3 style="text-align: center;">
        <strong>
          Contadores del proyecto
        </strong>
        <br>
        {{$proyecto->nombre}}
      </H3>
      
    </div>
    @include('Layout.MensajeEmergenteDatos')

    <form id="frmContador" name="frmContador" role="form" action="{{route('GestiónProyectos.agregarContador')}}" method="post">
      @csrf 
      <input type="hidden" id="codProyecto" name="codProyecto" value="{{$proyecto->codProyecto}}">
      <div class="row">
          <div class="col-md-1"><label>Contador:</label></div>
          <div class="col-md-3">
              <select class="form-control"  id="codEmpleadoConta" name="codEmpleadoConta" >
                  <option value="-1">Seleccionar</option>
                  @foreach($contadoresFaltantes as $itemcontador)
                  <option value="{{$itemcontador->codEmpleado}}">{{$itemcontador->getNombreCompleto()}} </option>
                  @endforeach
              </select>
          </div>
          <div class="col-md-1">
            <button class="btn btn-success">Agregar</button>
            </div>
      </div>
    </form>
    <br/> 

    <table class="table table-bordered table-hover datatable" id="table-3">
      <thead>                  
        <tr>
          <th>CÓDIGO</th>
          <th>NOMBRES Y APELLIDOS</th>
          <th>OPCIONES</th>
        </tr>
      </thead>
      <tbody>
        @foreach($listaRelaciones as $item_relacion)
        @php
          $itemcontador = $item_relacion->getContador();
          

        @endphp
          <tr>
            <td>{{$itemcontador->codEmpleado}}</td>
            <td>{{$itemcontador->getNombreCompleto()}}</td>
            <td>
              <a href="#" class="btn btn-danger btn-sm btn-icon icon-left" title="Eliminar registro" onclick="clickEliminar({{$item_relacion->getId()}},'{{$itemcontador->getNombreCompleto()}}','{{$proyecto->nombre}}')">
                Eliminar
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    
    <div class="d-flex m-2">
      
      <a href="{{route('GestiónProyectos.AdminSistema.Listar')}}" class="btn btn-primary icon-left" style="">
        Regresar
      </a>  
    </div>

  </div>
@endsection
@section('script')
<script>
  function clickEliminar(codProyectoContador,nombre,proyecto){
      confirmarConMensaje("Confirmación","¿Seguro que desea eliminar al contador "+nombre+" del proyecto "+proyecto+"?","warning",function(){
        location.href = "/GestiónProyectos/"+codProyectoContador+"/eliminarContador";
      })


  }
  
</script>
@endsection