@extends('Layout.Plantilla')

@section('titulo')
  Listado de Proyectos
@endsection

@section('contenido')
  <br>

  @include('Layout.MensajeEmergenteDatos')

  <div class="card">
    <div class="card-header" style=" ">
      <h2 class="card-title">Gestión de Proyectos</h2>
      <div class="card-tools">
        <ul class="nav nav-pills ml-auto">
          <li class="nav-item">
            <a href="{{ route('GestionProyectos.Crear') }}" class="nav-link active"><i class="fas fa-plus"></i> Nuevo Registro</a>
          </li>
        </ul>
      </div>

    </div>




    <!-- /.card-header -->
    <div class="card-body p-0">
      <table class="table table-sm">
        <thead>

          <tr>
            <th scope="col">IdBD</th>

            <th scope="col">Cod Proy</th>
            <th scope="col">NOMBRE PROYECTO</th>
            <th scope="col">ESTADO</th>

            <th scope="col">GERENTE</th>
            <th scope="col">CONTADOR</th>


            <th scope="col">Opciones</th>

          </tr>

        </thead>
        <tbody>

          @foreach ($listaProyectos as $itemProyecto)
            <tr>
              <td>{{ $itemProyecto->codProyecto }}</td>
              <td>{{ $itemProyecto->codigoPresupuestal }}</td>

              <td>{{ $itemProyecto->nombre }}</td>
              <td>

                {{ $itemProyecto->getEstado()->nombre }}



              </td>
              </td>
              <td> {{-- BUSCADOR DINAMICO POR NOMBRES --}}

                {{ $itemProyecto->getGerente()->getNombreCompleto() }}


              </td>
              <td>
                <a href="{{ route('GestionProyectos.Contadores', $itemProyecto->codProyecto) }}"
                  class="btn btn-success btn-sm btn-icon icon-left">
                  <i class="entypo-pencil"></i>Contadores ({{ $itemProyecto->nroContadores() }})
                </a>
              </td>
              <td>
                <a href="{{ route('GestionProyectos.Editar', $itemProyecto->codProyecto) }}" class="btn btn-info btn-sm">
                  <i class="fas fa-pen-square"></i>
                  Editar
                </a>

              </td>
            </tr>
          @endforeach

        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>


  <br>
@endsection



<script></script>
