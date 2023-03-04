@extends('Layout.Plantilla')

@section('titulo')
    Listar activos
@endsection

@section('contenido')


<div class="card-body">
      
    <div class="well">
        <H3 style="text-align: center;">
          <strong>
            Listar activos
          </strong>
        </H3>
    </div>
    <div class="row">
    


        <div class="col-md-2">
          <a href="{{route('ActivoInventario.Crear')}}" class="m-2 btn btn-primary">
            <i class="fas fa-plus"></i>
            Nuevo Activo
          </a>
        </div>
        <div class="col-md-10">
          
        </div>
    </div>
    @include('Layout.MensajeEmergenteDatos')
  

    <table class="table table-bordered table-hover datatable" id="table-3">
      <thead>                  
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Características</th>
            <th>Placa</th>
            <th>Categoría</th>
            <th>Proyecto</th>
            <th>Responsable</th>
            <th>Sede</th>
            <th>Estado</th>
            <th>
                Opciones
            </th>
        </tr>
      </thead>
      <tbody>

        @foreach($listaActivos as $activo)
            <tr>
                <td>
                  {{$activo->codigoAparente}}
                </td>
                <td>
                    {{$activo->nombre}}
                </td>
                <td>
                    {{$activo->caracteristicas}}
                </td>
                <td>
                    {{$activo->placa}}
                </td>
                <td>
                    {{$activo->getCategoria()->nombre}}
                </td>
                <td>
                    {{$activo->getProyecto()->nombre}}
                </td>
                <td>
                    {{$activo->getResponsable()->getNombreCompleto()}}
                </td>
                <td>
                    {{$activo->getSede()->nombre}}
                </td>
                <td>
                    {{$activo->getEstado()->nombre}}
                </td>
                
                <td>

                  <a class="btn btn-primary" href="{{route('ActivoInventario.VerActivo',$activo->codActivo)}}">
                    <i class="fas fa-eye"></i>
                    Ver historial
                  </a>

                </td>
            </tr>
        @endforeach
        
      </tbody>
    </table>
    


</div>


@endsection
