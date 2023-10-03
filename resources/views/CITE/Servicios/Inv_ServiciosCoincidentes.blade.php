@forelse($listaServicios as $servicio)

  <tr class="FilaPaddingReducido">
      <td>
          {{$servicio->getId()}}
      </td>
      <td class="fontSize9">
          {{$servicio->descripcion}}
      </td>
      <td class="fontSize10">
          {{$servicio->getUnidadProductiva()->getDenominacion()}}
          [{{$servicio->getUnidadProductiva()->getRucODNI()}}]

      </td>
       
      <td>
          {{$servicio->getTipoServicio()->nombre}}
      </td>
      <td class="text-center">
        @if($servicio->tieneArchivosExportables())  
          SÍ
        @else
          NO
        @endif
      </td>
          
      <td>
          <a target="_blank" href="{{route('CITE.Servicios.Ver',$servicio->getId())}}" class='btn btn-info btn-sm' title="Ver Unidad Productiva">
              <i class="fas fa-eye"></i>
          </a>

          @if($servicio->sePuedeEliminar())                 
            <a target="_blank" href="{{route('CITE.Servicios.Editar',$servicio->getId())}}" class = "btn btn-sm btn-warning"
              title="Editar Servicio">
              <i class="fas fa-edit"></i>
            </a>
          @endif


      </td>


  </tr>
  

@empty
  <tr>
    <td colspan="6" class="text-center">
        No hay resultados
    </td>
  </tr>
@endforelse
 
@if(count($listaServicios) > 0)
  <tr>
    <td class="text-center" colspan="6">
      <a target="_blank" class="btn btn-success" href="{{route('CITE.Servicios.DescargarArchivoComprimido',$nombre_comprimido)}}">
        Descargar archivos comprimidos
        <i class="fas fa-download"></i>
      </a>
    </td>
  </tr>
@endif