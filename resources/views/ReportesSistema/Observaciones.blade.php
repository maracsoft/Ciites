@extends('Layout.Plantilla') 

@section('titulo')
    Reporte Observaciones
@endsection

@section('contenido')
    <br>

    @include('Layout.MensajeEmergenteDatos')
     

 

    <table class="table table-hover">
        <thead class="text-center">
            <th>
                Año Y MES
            </th>
            @foreach ($listaAños as $año)
                <th colspan="12"  style="background-color: rgb({{100 + fmod($año*500,150)}},150,100)">
                    {{$año}}
                </th>
            @endforeach
        </thead>

 
        <thead>
            <th>
                EMPLEADO
            </th>
            @foreach ($listaAños as $año)
                
                @foreach ($listaMeses as $mes)
                    <th  style="background-color: rgb({{100 + fmod($año*500,150)}},150,100)">
                        {{$mes->nombre}}
                    </th>
                @endforeach
                
            @endforeach
        </thead>

        <tbody>

            @foreach ($listaEmpleados as $empleado) 
                
                <tr> {{-- Fila nombre proyecto --}}
                    
                    <td style="background-color:rgb(201, 201, 201)">
                        {{$empleado->getNombreCompleto()}}
                    </td>
                    @foreach ($listaAños as $año)
                        @foreach ($listaMeses as $mes)
                            <td style="background-color: rgb({{100 + fmod($año*500,150)}},150,100)"> {{--   --}}
                                {{$empleado->getCantidadObservacionesMesAño($mes->codMes,$año)}}                                
                            </td>

                        @endforeach
                    @endforeach
                </tr>
 
            @endforeach
        </tbody>
    </table>


@endsection


 