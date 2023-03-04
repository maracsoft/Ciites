@extends('Layout.Plantilla') 

@section('titulo')
    Reporte Importes
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
                        S/
                    </th>
                    <th  style="background-color: rgb({{100 + fmod($año*500,150)}},150,100)">
                        $
                    </th>
                @endforeach
                
            @endforeach
        </thead>

        <tbody>

            @foreach ($listaProyectos as $proyecto) 
                
                <tr> {{-- Fila nombre proyecto --}}
                    
                    <td style="background-color:rgb(201, 201, 201)">
                        {{$proyecto->nombre}}
                    </td>
                    @foreach ($listaAños as $año)
                        @foreach ($listaMeses as $mes)
                            <td style="background-color: rgb({{100 + fmod($año*500,150)}},150,100)"> {{--   --}}
                                {{-- Aqui va el total acumulado en Soles del proyecto --}}
                            </td>

                            <td style="background-color: rgb({{100 + fmod($año*500,150)}},150,150)"> {{--   --}}
                                 {{-- Aqui va el total acumulado en Dolares del proyecto --}}
                            </td>
                        @endforeach
                    @endforeach
                </tr>

                @foreach ($listaBancos as $banco) {{-- Fila de bancos --}}
                    <tr>
                        <td> 
                            - - {{$banco->nombreBanco}}
                        </td>
                        @foreach ($listaAños as $año)
                
                            @foreach ($listaMeses as $mes)
                                <td style="background-color: rgb({{100 + fmod($año*500,150)}},150,100)"> {{-- SOLES --}}
                                    {{$proyecto->calcularImporteMesAñoBanco($mes->codMes,$año,$banco->codBanco,1)}}
                                    
                                </td>

                                <td style="background-color: rgb({{100 + fmod($año*500,150)}},150,150)"> {{-- DOLARES --}}
                                    {{$proyecto->calcularImporteMesAñoBanco($mes->codMes,$año,$banco->codBanco,2)}}
                                  
                                </td>
                            @endforeach
                        @endforeach

                    </tr>
            
                @endforeach
            @endforeach
        </tbody>
    </table>


@endsection


 