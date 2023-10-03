@extends('Layout.Plantilla')

@section('titulo')
    Listar Formatos
@endsection

@section('contenido')

<div class="card-body">
  
  <div class="row">
   
    <div class="col">
      <a href="" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Nuevo Formato
      </a>
    </div>
     
  </div>
 
    @include('Layout.MensajeEmergenteDatos')

    <table class="table table-bordered table-hover datatable table-sm" id="table-3">
      <thead>                  
        <tr>
          <th>Cod</th>
          <th>Nombre</th>
          <th>Indice Formato</th>
          <th>
            Tiene archivo?
          </th>
          <th >
            Opc
          </th >
        </tr >
      </thead>
      <tbody>
        @foreach($listaTipos as $tipo_medio)
            <tr>
              <td>
                {{$tipo_medio->getId()}}
              </td>
              <td>
                {{$tipo_medio->nombre}}
              </td>
              <td>
                {{$tipo_medio->indice_formato}}
              </td>
              <td>
                @if($tipo_medio->tieneArchivoGeneral())
                  SÍ
                @else
                  NO
                @endif
              </td>
              <td>
                <a class="btn btn-primary btn-sm" href="{{route('CITE.TiposMediosVerificacion.Editar',$tipo_medio->getId())}}">
                  <i class="fas fa-edit"></i>
                </a>
                <button class="btn btn-danger btn-sm" onclick="clickEliminar({{$tipo_medio->getId()}})">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
        @endforeach
      </tbody>
    </table>
    
  

  </div>


@endsection
@section('script')
  <script>
      

      idAnular = 0;
      function clickEliminar(id){
        idAnular = id;
        confirmarConMensaje("Confirmar","¿Desea anular el contrato?","warning",ejecutarAnular);
      }
      function ejecutarAnular(){
        location.href ="/Cite/TiposMediosVerificacion/Eliminar"+idAnular;
      }


  </script>


@endsection