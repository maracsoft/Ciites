@extends('Layout.Plantilla') 

@section('titulo')
    Reporte Importes de Reposicion por Meses
@endsection

@section('contenido')
    <br>

    @include('Layout.MensajeEmergenteDatos')
    
 
    <table class="table table-hover">
        <thead>
            <tr>
                <th>
                    #
                </th>
                <th>
                    REPO
                </th>
                <th>
                    Render
                </th>
                <th>
                    Guardado
                </th>
                <th>
                    Miliseg
                </th>
                <th>
                    Segundos
                </th>
                <th>
                    Minutos
                </th>
                
            </tr>
        </thead>

        <tbody>
            @php
                $i=1;
            @endphp
            @foreach ($listaRepos as $repo)
                <tr>
                    <td>
                        {{$i}}
                    </td>
                    <td>
                        {{$repo->codigoCedepas}}
                    </td>
                    <td>
                        {{$repo->fechaHoraRenderizadoVistaCrear}}
                    </td>
                    <td>
                        {{$repo->fechaHoraEmision}}
                    </td>
                    <td>
                        {{$repo->getMilisegundosGeneracion()}}
                    </td>
                    <td>
                        {{$repo->getMilisegundosGeneracion()/1000}}
                    </td>
                    <td>
                        {{ ($repo->getMilisegundosGeneracion()/1000) / 60}}
                    </td>
                    
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
           
        </tbody>
    </table>
    

 

@endsection


@section('script')
@include('Layout.ValidatorJS')
<script>
    function clickBuscar(){

        msj = validarBusqueda();
        if(msj!=""){
            alerta(msj);
            return;
        }


        document.formBuscar.submit();



    }

    function validarBusqueda(){
        msj ="";

        msj = validarSelect(msj,"inicio_año","-1","Año inicio");
        msj = validarSelect(msj,"inicio_mes","-1","Mes inicio");
        msj = validarSelect(msj,"fin_año","-1","Año final");
        msj = validarSelect(msj,"fin_mes","-1","Mes final");
        
        return msj;


    }

</script>
@endsection
