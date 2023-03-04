@extends('Layout.Plantilla')

@section('titulo')
    Contratos de Plazo Fijo
@endsection

@section('contenido')

<div class="card-body">
  <div class="well">
        <H3 style="text-align: center;">
            <strong>
                Contratos de Plazo Fijo
            </strong>
        </H3>
  </div>
  <div class="row">
      <div class="col m-2">
        <a href="{{route('ContratosPlazo.Crear')}}" class="btn btn-primary">
          <i class="fas fa-plus"></i>
          Nuevo Registro
        </a>
      </div>
  </div>
  
  <form action="">

    <div class="row m-1">


      <div class="col">
        
        <select class="form-control" name="codEmpleadoCreador" id="codEmpleadoCreador">
          <option value="-1">- Creador -</option>

          @foreach ($listaEmpleadosQueGeneraronContratos as $emp)
            <option value="{{$emp->getId()}}"
              @if($codEmpleadoCreador==$emp->getId())
                  selected
              @endif
              >
              {{$emp->getNombreCompleto()}}
            </option>
            
          @endforeach

        </select>
      </div>

      <div class="col">
        
        <input class="form-control" type="text" id="dni" name="dni" placeholder="DNI contratado" value="{{$dni}}">  
      </div>
 
 

      <div class="col">
        <select class="form-control select2 select2-hidden-accessible selectpicker" data-select2-id="1" tabindex="-1" aria-hidden="true" name="buscarPorNombreYapellido" id="buscarPorNombreYapellido" data-live-search="true">
         
          <option value="">- Buscar Contratado -</option>
          @foreach ($listaNombresDeContratados as $nombre)
            <option value="{{$nombre}}"
            @if($buscarPorNombreYapellido == $nombre)
              selected
            @endif
            >{{$nombre}}</option>
          @endforeach
          

        
        </select>
       
  

      </div>

      {{-- Nombre del contratado pero en select --}}
      {{-- Quitar tipo de contrato --}}
      <div class="col">
        <button class="btn btn-success " type="submit">
          <i class="fas fa-search"></i>
          Buscar
        </button>

      </div>
        
    </div>

  </form>


    @include('Layout.MensajeEmergenteDatos')

    <table class="table table-bordered table-hover datatable table-sm" id="table-3">
      <thead>                  
        <tr>
          <th>Cod</th>
          <th>Creador</th>
          <th>Contratado</th>
          <th>Fecha emisión</th>
          <th>Duración contrato</th>
          <th>Nombre puesto</th>
          <th>Proyecto</th>
          <th>TipoContrato</th>
          <th>
            Sueldo Bruto
          </th>
          <th>
            Opc
          </th>
        </tr>
      </thead>
      <tbody>

        @foreach($listaContratos as $contrato)
            <tr @if($contrato->estaAnulado()) style="background-color: rgba(255, 143, 143, 0.801)" @endif>
                <td>
                  
                  <span class="fontSize10">
                    {{$contrato->codigoCedepas}}
                  </span>
                   
                    @if($contrato->estaAnulado())
                      <span class="fontSize8">
                        ANULADO
                      </span>
                    @endif
                </td>
                <td>
                    {{$contrato->getEmpleadoCreador()->getNombreCompleto()}}
                </td>
                
                <td>
                    {{$contrato->getNombreCompleto()}}
                    <span class="fontSize10">
                        [{{$contrato->dni}}]
                    </span>
                </td>
                <td>
                    {{$contrato->getFechaHoraEmision()}}
                </td>
                <td>
                    {{$contrato->getFechaInicio()}}
                    //
                    {{$contrato->getFechaFin()}}
                </td>
                <td>
                    {{$contrato->nombrePuesto}}
                </td>
                <td>
                    {{$contrato->nombreProyecto}}
                </td>
                <td>
                  {{$contrato->getTipoContrato()->nombre}}
                </td>
                <td class="text-right">
                  {{$contrato->sueldoBruto}}

                  
                </td>
                <td>
                  
                  <a class="btn btn-primary btn-sm" href="{{route('ContratosPlazo.Ver',$contrato->getId())}}">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{route('ContratosPlazo.descargarPDF',$contrato->getId())}}" class='btn btn-info btn-sm'  title="Descargar PDF">
                    <i class="fas fa-file-download"></i>
                  </a>
                  <a target="pdf_solicitud_{{$contrato->getId()}}" href="{{route('ContratosPlazo.verPDF',$contrato->getId())}}"
                     class='btn btn-info btn-sm'  title="Ver PDF">
                    <i class="fas fa-file-pdf"></i>
                  </a>

                  @if($contrato->sePuedeAnular())
                      
                    
                    <button type="button" onclick="clickEliminar({{$contrato->getId()}})" 
                      class='btn btn-danger btn-xs' title="Anular">
                      <i class="fas fa-trash"></i>
                    </button>
                  @endif
                </td>

            </tr>
        @endforeach
        
      </tbody>
    </table>
    
  

  </div>


@endsection
@section('script')
    <script>
        
      idAnular = 0;

      function clickEliminar(id){
        idAnular = id;
        confirmarConMensaje("Confirmar","¿Desea anular el contrato?","warning",ejecutarAnular);
      }
      function ejecutarAnular(){
        location.href ="/ContratosPlazo/Anular/"+idAnular;
      }



    </script>


@endsection