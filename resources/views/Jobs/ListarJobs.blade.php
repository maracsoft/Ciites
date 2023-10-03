@extends('Layout.Plantilla')

@section('titulo')
    Lista de Jobs
@endsection

@section('contenido')
 

<div class="card-body">

    <div class="well">
        <H3 style="text-align: center;">
            <strong>
                Lista de Jobs
            </strong>
        </H3>
    </div>
    <div class="row">
      <button href="#" class="btn btn-success m-1" onclick="limpiarModal()" data-toggle="modal" data-target="#ModalJob">
          <i class="fas fa-plus"></i> 
          Nuevo Registro
      </button>

    </div>
    
    @include('Layout.MensajeEmergenteDatos')

    <table class="table table-bordered table-hover datatable" id="table-3">
      <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Function Name</th>
            <th class="text-center">Creación</th>
            <th>Ejecución</th>
            <th>Opciones</th>
          </tr>
      </thead>
      <tbody>

          @foreach($listaJobs as $job)
              <tr class="FilaPaddingReducido">
                  <td>
                      {{$job->getId()}}
                  </td>
                  <td class="">
                    {{$job->nombre}}
                  </td>
                  <td class="">
                    {{$job->descripcion}}
                  </td>
                  <td class="">
                    {{$job->functionName}}
                  </td>
                  <td class="">
                    {{$job->getFechaHoraCreacion()}}
                  </td>
                  <td class="">
                    {{$job->getFechaHoraEjecucion()}}
                  </td>
                    
                  <td>
                    <button type="button"  data-toggle="modal" data-target="#ModalJob"  onclick="clickEditarJob({{$job->getId()}})" class='btn  btn-info btn-sm' title="Editar JOB">
                      <i class="fas fa-pen"></i>
                    </button>
                    @if($job->estaEjecutado())
                      <a href="{{route('Jobs.UnRunJob',$job->getId())}}" class='btn btn-info btn-sm' title="DE Ejecutar JOB">
                        <i class="fas  fa-backward"></i>
                      </a>
                    @else
                      <a href="{{route('Jobs.RunJob',$job->getId())}}" class='btn btn-info btn-sm' title="Ejecutar JOB">
                        <i class="fas fa-burn"></i>
                      </a>
                     
                      <a href="{{route('Jobs.Eliminar',$job->getId())}}" class='btn btn-danger btn-sm' title="Eliminar JOB">
                        <i class="fas fa-trash"></i>
                      </a>
                      
                    @endif

                  </td>

              </tr>
          @endforeach
          @if(count($listaJobs)==0)
              <tr>
                  <td colspan="10" class="text-center">
                      No hay resultados
                  </td>
              </tr>
          @endif

      </tbody>
    </table>  
    
</div>

<div class="modal fade" id="ModalJob" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

              <div class="modal-header">
                  <h5 class="modal-title" id="TituloModal">Crear Job</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form id="frmJob" name="frmJob" action="{{route('Jobs.GuardarEditar')}}" method="POST">
                      <input type="{{App\Configuracion::getInputTextOHidden()}}" name="codJob" id="codJob" value="-1">
                      @csrf
                      
                      <div class="row">
                        <div class="col-12">
                          <label for="">Nombre del job</label>
                          <input type="text" class="form-control" value="" name="nombre" id="nombre" >
                        </div>
                        <div class="col-12">
                          <label for="">Descripción</label>
                          <textarea type="text" class="form-control" name="descripcion" id="descripcion"></textarea>
                        </div>
                        <div class="col-12">
                          <label for="">Nombre de la función</label>
                          <input type="text" class="form-control" value="" name="functionName" id="functionName" >
                        </div>
                      </div>                            
                      
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">
                      Salir
                  </button>

                  <button type="button" class="m-1 btn btn-primary" onclick="clickGuardarJob()">
                      Guardar <i class="fas fa-save"></i>
                  </button>   
              </div>
          
      </div>
  </div>
</div>



 


@endsection
@section('script')
@include('Layout.ValidatorJS')

<script>
  
  var listaJobs = [];

  document.addEventListener('DOMContentLoaded', function () {
     cargarJobs();
  }, false);

  
  function cargarJobs(){
    listaJobs =  @json($listaJobs)
  }


  function clickEditarJob(codJob){
    job = listaJobs.find(element => element.codJob == codJob);
    console.log(job)
    document.getElementById('codJob').value = job.codJob;
    document.getElementById('nombre').value = job.nombre;
    document.getElementById('descripcion').value = job.descripcion;
    document.getElementById('functionName').value = job.functionName;
     
    document.getElementById('TituloModal').innerHTML = "Editar job";

  }

  function clickGuardarJob(){
    msjError = validarFormularioJob();
    if(msjError!=""){
      alerta(msjError);
      return;
    }
    
    document.frmJob.submit();
  }




  function validarFormularioJob(){
    msjError = "";

    msjError = validarTamañoMaximoYNulidad(msjError,"nombre",150,"Nombre")
    msjError = validarTamañoMaximoYNulidad(msjError,"descripcion",150,"Descripción")
    msjError = validarTamañoMaximoYNulidad(msjError,"functionName",150,"Nombre de la Función")
    


    return msjError;

  }

  function limpiarModal(){
    document.getElementById('codJob').value = "-1";
    document.getElementById('nombre').value = "";
    document.getElementById('descripcion').value = "";
    document.getElementById('functionName').value = "";
     
    document.getElementById('TituloModal').innerHTML = "Crear Job";

  }










 

</script>

@endsection
