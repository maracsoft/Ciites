@extends('Layout.Plantilla')

@section('titulo')
    Formatos del CITE
@endsection

@section('contenido')
<div class="col-12 py-2">
  <div class="page-title">
    Formatos de archivos del CITE
  </div>
</div>


<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6">

      <div class="card">


        <div class="card-body">
          <div class="row">
            
              <table class="table table-bordered table-hover datatable table-sm">
                <thead>                  
                  <tr>
                    <th>
                      Formato
                    </th>
                    
                    <th class="text-center">
                      Opciones
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($listaTipos as $tipo_medio)
                      <tr>
                        <td>
                          {{$tipo_medio->getLabel()}}
                        </td>
                        <td class="text-center">
                          @if($tipo_medio->tieneArchivoGeneral())
                            @php
                              $archivo = $tipo_medio->getArchivoGeneral();
                            @endphp  

                            <a class="btn btn-success btn-sm" href="{{route('CITE.TiposMediosVerificacion.DescargarArchivo',$archivo->getId())}}">
                              Descargar 
                              <i class="fas fa-file-download"></i>
                            </a>

                          @endif
                        </td>
                      </tr>
                  @endforeach
                </tbody>
              </table>
              

          </div>


        </div>

      </div>


  </div>
  <div class="col-md-3"></div>

</div>
@endsection
 