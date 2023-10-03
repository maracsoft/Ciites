@extends('Layout.Plantilla')
@section('titulo')
    Puestos
@endsection
@section('contenido')

<div class="card-body">
    

  <div class="well"><H3 style="text-align: center;">PUESTOS</H3></div>
  <div class="row">
    <div class="col-md-2">
      <a href="{{route('GestionPuestos.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i>Nuevo Registro</a>
    </div>
    <div class="col-md-10">
      <form class="form-inline float-right">
        <input class="form-control mr-sm-2" type="search" placeholder="Buscar por nombre" aria-label="Search" name="nombreBuscar" id="nombreBuscar" value="{{$nombreBuscar}}">
        <button class="btn btn-success " type="submit">Buscar</button>
      </form>
    </div>
  </div>
  <br>

    <table class="table table-bordered table-hover datatable" id="table-3">
      <thead>                  
        <tr>
          <th>CODIGO</th>
          <th>NOMBRE</th>
          <th>ACTIVO</th>
          
          <th>OPCIONES</th>
        </tr>
      </thead>
      <tbody>
        @foreach($puestos as $itempuesto)
            <tr>
                <td>{{$itempuesto->codPuesto}}</td>
                <td>{{$itempuesto->nombre}}</td>
                <td>{{$itempuesto->getActivo()}}</td>
                
                
                <td>
                    <a href="{{route('GestionPuestos.edit',$itempuesto->codPuesto)}}" class="btn btn-warning btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Editar</a> 
                    <!-- <a href="" class="btn btn-danger btn-sm btn-icon icon-left"><i class="entypo-cancel"></i>Eliminar</a> -->

                    <a href="#" class="btn btn-danger btn-sm btn-icon icon-left" title="Eliminar registro" onclick="swal({//sweetalert
                        title:'¿Eliminar el puesto?',
                        text: '',     //mas texto
                        //type: 'warning',  
                        type: '',
                        showCancelButton: true,//para que se muestre el boton de cancelar
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText:  'SÍ',
                        cancelButtonText:  'NO',
                        closeOnConfirm:     true,//para mostrar el boton de confirmar
                        html : true
                    },
                    function(){//se ejecuta cuando damos a aceptar
                        window.location.href='{{route('GestionPuestos.delete',$itempuesto->codPuesto)}}';

                    });"><i class="entypo-cancel"></i>Eliminar</a>

                </td>
            </tr>
        @endforeach
        
      </tbody>
    </table>
    {{$puestos 
      ->links()
    }}


    <label for="">
        Relacion empleados y puestos
    </label>
    <table class="table table-bordered table-hover datatable" id="table-3">
        <thead>                  
        <tr>
            <th>CODIGO</th>
            <th>Empleado</th>
            <th>Puesto</th>
            <th>OPCIONES</th>
        </tr>
        </thead>
        <tbody>
            @php
                $i=1;
            @endphp
            @foreach($listaEmpleadosPuesto as $empPuesto)
                <tr>
                    <td>
                        {{$i}}
                    </td>
                    <td>
                        {{$empPuesto->getEmpleado()->getNombreCompleto()}}
                    </td>
                    <td>
                        {{$empPuesto->getPuesto()->nombre}}
                    </td>
                    <td>

                    </td>
                </tr>
            @php
                $i++;
            @endphp
            @endforeach
            
        </tbody>
    </table>

    
  </div>


@endsection
