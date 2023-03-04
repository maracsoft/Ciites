@extends('Layout.Plantilla')

@section('titulo')
    Contratos de locación
@endsection

@section('contenido')

<div class="card-body">
  <div class="well">
        <H3 style="text-align: center;">
            <strong>
                Contratos de locación
            </strong>
        </H3>
  </div>
  <div class="row">
   
    <div class="col">
      <a href="{{route('ContratosLocacion.Crear')}}" class="btn btn-primary">
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

          @foreach ($listaEmpleadosQueGeneraronContratosLocacion as $emp)
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
        

        <input class="form-control" type="text" id="ruc" name="ruc" placeholder="RUC contratado" value="{{$ruc}}"> 
      </div>

      <div class="col">
        <select class="form-control" name="esDeCedepas" id="esDeCedepas">
          <option value="">- Tipo Contrato -</option>
          <option value="1" @if($esDeCedepas=="1") selected @endif>CEDEPAS</option>
          <option value="0" @if($esDeCedepas=="0") selected @endif>GPC</option>
        </select>
  
      
      </div>

      <div class="col">
        
        <select class="form-control" name="esPersonaNatural" id="esPersonaNatural">
          <option value="">- Tipo Persona -</option>
          <option value="1" @if($esPersonaNatural=="1") selected @endif>P.Natural</option>
          <option value="0" @if($esPersonaNatural=="0") selected @endif>P.Juridica</option>
        </select>
  

      </div>

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
          <th>Tipo</th>
          <th>
            Retribución total
          </th>
          <th >
            Opc
          </th >
        </tr >
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
                    @if($contrato->esDeNatural())
                      {{$contrato->getNombreCompleto()}}
                      <span class="fontSize10">

                          DNI[{{$contrato->dni}}]
                          (P.Nat)
                      </span>
                      
                    @else 
                      {{$contrato->razonSocialPJ}}
                      <span class="fontSize10">
                        RUC[{{$contrato->ruc}}]
                        (P.Jur)
                      </span>
                      
                    @endif

                    
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
                    {{$contrato->getTipoContrato()}}
                </td>
                <td class="text-right">
                    {{$contrato->getMoneda()->simbolo}}
                    {{$contrato->getRetribucionTotal()}}
                </td>

                <td>

                  <a class="btn btn-primary btn-sm" href="{{route('ContratosLocacion.Ver',$contrato->getId())}}">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{route('ContratosLocacion.descargarPDF',$contrato->getId())}}" class='btn btn-info btn-sm'  title="Descargar PDF">
                    <i class="fas fa-file-download"></i>
                  </a>
                  <a target="pdf_CL_{{$contrato->getId()}}" href="{{route('ContratosLocacion.verPDF',$contrato->getId())}}"
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
          location.href ="/ContratosLocacion/Anular/"+idAnular;
        }


    </script>


@endsection