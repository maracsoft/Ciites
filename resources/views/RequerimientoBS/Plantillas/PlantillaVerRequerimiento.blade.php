@include('RequerimientoBS.Plantillas.SubPlantillaVerReqSuperior')

<div class="row" id="" name="">                       
    <div class="col-12 col-md-4 " style="">
      @include('RequerimientoBS.Plantillas.Desplegables.DescargarArchivosEmp')
    </div> 

    
    @if($requerimiento->tieneArchivosAdmin() )
      <div class="col-12 col-md-4">
        @include('RequerimientoBS.Plantillas.Desplegables.DescargarArchivosAdm')
      </div>
    @endif

    <div class="col-12 col-md-4">
        <a  href="{{route('RequerimientoBS.exportarPDF',$requerimiento->codRequerimiento)}}" class="btn btn-primary" title="Descargar PDF">
          Descargar en PDF
          <i class="fas fa-file-download"></i>
        </a>

        <a target="pdf_reposicion_{{$requerimiento->codRequerimiento}}" href="{{route('RequerimientoBS.verPDF',$requerimiento->codRequerimiento)}}" class="btn btn-primary" title="Ver PDF">
          Ver PDF
          <i class="fas fa-file-pdf"></i>
        </a>
    </div>


</div>
        
        
 