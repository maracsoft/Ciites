@extends('Layout.Plantilla') 

@section('titulo')
    Listado Busquedas
@endsection

@section('contenido')
<br>

@include('Layout.MensajeEmergenteDatos')

<div class="card">
    
    <h3 class="m-1">
        Lista de busquedas
    </h3>

    

    <!-- /.card-header -->
    <div class="card-body p-0">
      <table class="table table-sm">
        <thead>

          <tr>
            <th scope="col">id</th>
            <th scope="col">Empleado</th>
            <th scope="col">FechaHora Inicio</th>
            <th scope="col">FechaHora Fin</th>
            <th>
                Miliseg
            </th>
            <th>
                Seg
            </th>
             
          </tr>

        </thead>
        <tbody>

          @foreach($listaBusquedas as $busqueda)
             <tr>
                <td>
                    {{$busqueda->getId()}}
                </td>

                <td>
                    {{$busqueda->getEmpleado()->getNombreCompleto()}}
                </td>

                <td>
                    {{$busqueda->fechaHoraInicioBuscar}}
                </td>

                <td>
                    {{$busqueda->fechaHoraVerPDF}}
                </td>
                <td>
                    {{$busqueda->getMilisegundosGeneracion()}}
                </td>    
                <td>
                    {{$busqueda->getMilisegundosGeneracion()/1000}}
                </td>                
             </tr>

          @endforeach

        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  
  <!-- /.card -->
 

@endsection


 
 