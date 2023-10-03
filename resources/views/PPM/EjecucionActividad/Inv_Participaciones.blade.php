@php
    $i=1;
@endphp
@foreach($participaciones as $participacion)
    @php
        $persona = $participacion->getPersona();
    @endphp
    <tr>
        <td class="text-center">
            {{$i}}
        </td>
        <td class="text-right">
            {{$persona->dni}}
        </td>
        <td class="text-left">
            {{$persona->getNombreCompleto()}}
        </td>
        <td class="text-right">
            {{$persona->telefono}}
        </td>
        <td class="text-left">
            {{$persona->correo}}
        </td>
        <td class="text-center">
            {{$persona->getSexoLabel()}}
        </td>
        <td class="text-center">
            {{$persona->getFechaNacimiento()}}
        </td>
        <td class="text-center">
            @if($participacion->esExterno())
                SÍ
            @else
                NO
            @endif
        </td>
        <td class="text-center">
            <a href="{{route('PPM.Persona.Editar',$persona->getId())}}" target="_blank" class='btn btn-info btn-sm' title="Editar Persona">
                <i class="fas fa-edit"></i>
            </a>

            <button onclick="clickEliminarParticipacion({{$participacion->getId()}})" type="button" class="btn btn-danger btn-sm" title="Eliminar usuario de la actividad">
                <i class="fas fa-ban"></i>
            </button>
        </td>

    </tr>
@php
    $i++;
@endphp
@endforeach
@if(count($participaciones) == 0)
    <tr>
        <td class="text-center" colspan="9">
            No hay personas registradas en esta ejecucion de actividad
        </td>
    </tr>
@endif