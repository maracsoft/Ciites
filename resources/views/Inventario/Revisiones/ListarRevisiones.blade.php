@extends('Layout.Plantilla')

@section('titulo')
    Listar Revisiones de Inventario
@endsection

@section('contenido')


<div class="card-body">
      
    <div class="well">
        <H3 style="text-align: center;">
          <strong>
            Revisiones de inventario
          </strong>
        </H3>
    </div>
    
    @if(!App\RevisionInventario::hayUnaRevisionActiva())
      <div class="row m-1">
        <div class="col-md-2">
          <a href="{{route('RevisionInventario.Crear')}}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Nuevo Registro
          </a>
        </div>
        <div class="col-md-10">
        </div>
      </div>
    @endif
    


    @include('Layout.MensajeEmergenteDatos')
  

    <table class="table table-bordered table-hover datatable" id="table-3">
      <thead>                  
        <tr>
          <th>Año</th>
          <th>Inicio/Cierre</th>
          <th>Responsable</th>
          <th>Descripcion</th>
          <th>
              Opciones
          </th>
        </tr>
      </thead>
      <tbody>

        @foreach($listaRevisiones as $revision)
            <tr>
                <td>{{$revision->año}}</td>
                <td>
                  {{$revision->fechaHoraInicio}} // {{$revision->fechaHoraCierre}} 
                </td>
                <td>{{$revision->getResponsable()->getNombreCompleto()}}</td>
                <td>
                  {{$revision->descripcion}}

                </td>
                <td>

                  <a class="btn btn-primary" href="{{route('RevisionInventario.Ver',$revision->getId())}}">
                    <i class="fas fa-eye"></i>
                    Ver
                  </a>

                </td>
            </tr>
        @endforeach
        
      </tbody>
    </table>
    


</div>


@endsection
