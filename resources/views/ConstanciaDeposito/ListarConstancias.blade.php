@extends ('Layout.Plantilla')
@section('titulo')
  Constancias
@endsection


@php

  $comp_filtros = new App\UI\UIFiltros(false,$filtros_usados);
 
 

@endphp


@section('contenido')
  <div>
    <div class="p-1">
      <div class="page-title">
        Constancias de Deposito
      </div>
    </div>


    <div class="row">
      <div class="col-12">
        <a class="btn btn-primary" href="{{route('ConstanciaDepositoCTS.Crear')}}">
          Registrar
          <i class="fas fa-plus"></i>
        </a>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        {{$comp_filtros->render()}}
      </div>
    </div>


    @include('Layout.MensajeEmergenteDatos')

    <table class="table table-hover table-bordered celdas_sin_padding">
      <thead class="thead-dark">
        <tr>
          <th>
            Código
          </th>
          <th>
            Registrado por
          </th>
          <th>
            Beneficiario
          </th>
          <th>
            Fecha depósito
          </th>
          <th>
            Banco y Cuenta
          </th>
          <th>
            Monto Total CTS
          </th>
          <th>
            Opciones
          </th>
        </tr>
      </thead>
      <tbody>

        @foreach ($listaConstancias as $constancia)
           
          <tr>
            <td>
              {{$constancia->codigo_unico}}
            </td>
            <td>  
              {{$constancia->getEmpleadoCreador()->getNombreCompleto()}}
              <br>
              <span class="fontSize10">
                {{$constancia->getFechaEscrita()}}
              </span>
            </td>
            <td class="">
              {{$constancia->nombres}} {{$constancia->apellidos}} {{$constancia->dni}}
            </td>
            <td>
              {{$constancia->getFechaDeposito()}} 
            </td>
            <td>
              {{$constancia->nombre_banco}}
              <br>
              {{$constancia->nro_cuenta}}
            </td>
            <td class="text-right">
              S/ {{$constancia->getTotalCTS(true)}}
            </td>
            <td>
              <a class="btn btn-warning" href="{{route('ConstanciaDepositoCTS.Editar',$constancia->getId())}}">
                <i class="fas fa-pen"></i>
              </a>
              <a class="btn btn-info" href="{{route('ConstanciaDepositoCTS.DescargarPdf',$constancia->getId())}}">
                <i class="fas fa-download"></i>
              </a>
              <a target="_blank" class="btn btn-info" href="{{route('ConstanciaDepositoCTS.VerPdf',$constancia->getId())}}">
                <i class="fas fa-file-pdf"></i>
              </a>
              
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </div>

  {{$listaConstancias->appends($filtros_usados_paginacion)->links()}}

@endsection

@section('script')

@endsection
@section('estilos')
<style>
   
</style>
 
@endsection
