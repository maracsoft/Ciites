@extends('Layout.Plantilla') 

@section('titulo')
    Reportes estadísticos del sistema
@endsection

@section('contenido')
    <br>

    @include('Layout.MensajeEmergenteDatos')
    <div class="text-center">

        <a class="btn btn-primary m-1" href="{{route('Reportes.Ver.ReporteTesis')}}">
            POST TEST Tiempo Generación- TESIS
        </a>

        <a class="btn btn-primary m-1" href="{{route('Reportes.Ver.ListarTiemposBusqueda')}}">
            POST TEST Tiempo Busqueda - TESIS
        </a>

        
        
        <br>

        <a class="btn btn-info m-1" href="{{route('Reportes.Ver.ImportesREPporProyectos')}}">
            Importes de reposiciones por Proyectos
        </a>

        <br>

        <a class="btn btn-info m-1" href="{{route('Reportes.Ver.ImportesREPyREN')}}">
            Importes de reposiciones por meses
        </a>

        <br>


        <a class="btn btn-secondary m-1" href="{{route('Reportes.Ver.ReposRechazadas')}}">
            Reposiciones rechazadas
        </a>
        <br>

        <a class="btn btn-secondary m-1" href="{{route('Reportes.Ver.Importe')}}">
            Importe
        </a>
        <br>
        <a class="btn btn-secondary m-1" href="{{route('Reportes.Ver.Observaciones')}}">
            Observaciones
        </a>
        

    </div>
    


@endsection


 