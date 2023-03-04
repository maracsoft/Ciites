@extends('Layout.Plantilla')

@section('titulo')
    Ver Activo
@endsection

@section('contenido')


<div class="card-body">
      
    <div class="well">
        <H3 style="text-align: center;">
          <strong>
            Ver Activo
          </strong>
        </H3>
    </div>
   
    @include('Layout.MensajeEmergenteDatos')
  

    <table class="table table-bordered table-hover datatable" id="table-3">
      <thead>                  
        <tr>
            <th>
                Año
            </th>
            <th>
                Fecha hora ultimo cambio
            </th>
            <th>
                Estado
            </th>
        </tr>
      </thead>
      <tbody>

        @foreach($listaRevisionesDeActivo as $detRevision)
            @php
                $revision = $detRevision->getRevision();
            @endphp
            <tr>
                <td>
                    {{$revision->año}}
                </td>
              
                
                <td>
                    {{$detRevision->fechaHoraUltimoCambio}}
                </td> 
                <td>
                    <select class="form-control" id="codEstado" name="codEstado">
                        <option value="-1">Seleccionar Categoría</option>
                        @foreach($estadosActivo as $estado)
                            <option value="{{$estado->codEstado}}"
                                @if($estado->codEstado == $detRevision->codEstado)
                                    selected
                                @endif
                                
                                >
                                {{$estado->nombre}}
                            </option>
                        @endforeach
                    </select>
                </td>
 
           </tr>
        @endforeach
        
      </tbody>
    </table>
    
    <div class="row">
        <a class="m-3 btn btn-primary" href="{{route('ActivoInventario.Listar')}}">
            <i class="fas fa-backward"></i>
            Regresar
        </a>    
    </div>

</div>


@endsection
