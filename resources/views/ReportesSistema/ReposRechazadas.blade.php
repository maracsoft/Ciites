@extends('Layout.Plantilla') 

@section('titulo')
    Reportes estadísticos del sistema
@endsection

@section('contenido')
    <br>

    @include('Layout.MensajeEmergenteDatos')
     

 

    <table class="table table-hover">
        <thead class="text-center">
            <th>
                Año
            </th>
            @foreach ($listaAños as $año)
                
                <th colspan="24"  style="background-color: rgb({{100 + fmod($año*500,150)}},150,100)">
                    {{$año}}
                </th>
                
            @endforeach
        </thead>


        <thead class="text-center">
            <th>
                Mes
            </th>

            @foreach ($listaAños as $año)
                
                @foreach ($listaMeses as $mes)
                    <th colspan="2"  style="background-color: rgb({{100 + fmod($año*500,150)}},150,100)">
                        {{$mes->nombre}}
                    </th>
                @endforeach
                
            @endforeach
        </thead>
        <thead>
            <th>
                Proyecto
            </th>

            @foreach ($listaAños as $año)
                
                @foreach ($listaMeses as $mes)
                    <th  style="background-color: rgb({{100 + fmod($año*500,150)}},150,100)">
                        Emi
                    </th>
                    <th  style="background-color: rgb({{100 + fmod($año*500,150)}},150,100)">
                        Rec
                    </th>
                @endforeach
                
            @endforeach
        </thead>

        <tbody>

            @foreach ($listaProyectos as $proyecto)
                <tr>
                    <td> 
                        {{$proyecto->nombre}}
                    </td>
                    @foreach ($listaAños as $año)
              
                        @foreach ($listaMeses as $mes)
                            <td style="background-color: rgb({{100 + fmod($año*500,150)}},150,100)"> {{-- EMITIDAS --}}
                                {{$proyecto->calcularReposicionesEmitidasEnMesAño($mes->codMes,$año)}}
                            </td>

                            <td style="background-color: rgb({{100 + fmod($año*500,150)}},150,150)"> {{-- RECHAZADAS --}}
                                {{$proyecto->calcularReposicionesRechazadasEnMesAño($mes->codMes,$año)}}
                            </td>
                        @endforeach
                    @endforeach

                </tr>
            
            @endforeach
        </tbody>
    </table>


@endsection


 