<div class="row">
  
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header ui-sortable-handle" style="cursor: move;">

            <div class="d-flex">

              <h3 class="card-title align-self-center">
                <b>Archivos del Servicio</b>
              </h3>
              <div class="ml-auto">
                <a target="_blank" title="Click para ver los formatos" class="btn btn-primary" href="{{route('CITE.TiposMediosVerificacion.VerFormatos')}}">
                  Ver Formatos
                  <i class="ml-1 far fa-copy"></i>
                </a>
              </div>
            </div>


          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="">
                  <b>
                    Los archivos deben subirse uno por uno
                  </b>
                </div>
              </div>
              <div class="col-sm-6 d-flex">
                 
                  
                  <div class="ml-auto">
                    <div class="">
                      <div class="">
                        Para unir PDFs por favor usar
                        <a target="_blank" href="https://smallpdf.com/es/unir-pdf">
                          www.smallpdf.com/es/unir-pdf
                        </a>
                      </div>
                       
                      <div class="msj_ilovepdf text-left text-sm-right">
                        No usar ilovePDF, genera archivos incompatibles
                      </div>
                    </div>
                  </div>
                   

              </div>
              <div class="col-sm-12 mt-2">
                <div class="table-responsive">


                  <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead class="thead-default">
                      <tr>
                        <th colspan="3" class=" text-center p-2">
                          FORMATOS EXIGIDOS POR LA ACTIVIDAD
                        </th>
                      </tr>
                      <tr>
                        <th>
                          Tipo
                        </th>
                        <th class="text-left">
                          Archivo
                        </th>

                        <th class="text-center">
                          Opciones
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $codsArchivosServiciosYaMostrados = [];
                      @endphp

                      @forelse($servicio->getListaTiposMediosVerificacionNecesarios() as $tipo_medio_verificacion )
                        @php
                          $archivo_servicio = $servicio->getArchivoServicio_SegunTipoMedioVerificacion($tipo_medio_verificacion->getId());
                          $tiene_archivo_subido = $archivo_servicio != false;

                          if($tiene_archivo_subido){
                            $archivo_general = $archivo_servicio->getArchivo();
                            $codsArchivosServiciosYaMostrados[] = $archivo_servicio->getId();
                          }
                        @endphp
                        <tr>
                          <td class="">
                            <div class="d-flex">

                              <div>
                                {{$tipo_medio_verificacion->getLabel()}}
                              </div>
                              <div class="ml-auto">

                                
                                @if($tipo_medio_verificacion->tieneArchivoGeneral())
                                  <a class="d-none d-sm-block btn btn-success btn-sm" href="{{route('CITE.TiposMediosVerificacion.DescargarArchivo',$tipo_medio_verificacion->codArchivo)}}">
                                    Descargar Formato
                                    <i class="fas fa-download"></i>
                                  </a>
                                
                                @endif
                                


                              </div>

                            </div>
                          </td>
                          
                          <td class="text-center">
                            @if($tiene_archivo_subido)
                              {{$archivo_general->nombreAparente}}
                            @else
                              <button onclick="abrirModalSubirArchivo({{$tipo_medio_verificacion->getId()}},'{{$tipo_medio_verificacion->nombre}}')" data-toggle="modal" data-target="#ModalAgregarArchivo" class="btn btn-primary btn-sm">
                                Subir
                                <i class="fas  fa-upload"></i>
                              </button>
                            @endif
                          </td>


                          <td class="text-center">
                            @if($tiene_archivo_subido)

                              <a target="_blank" class="btn btn-primary btn-sm" href="{{route('CITE.Servicios.VerArchivo',[$archivo_general->getId(),$archivo_general->nombreAparente])}}" title="Ver">
                                <i class=" fas fa-eye"></i>
                              </a>
                              
                              <a class="btn btn-primary btn-sm" href="{{route('CITE.Servicios.DescargarArchivo',$archivo_general->getId())}}" title="Descargar">
                                <i class=" fas fa-download"></i>
                              </a>
                              
                              <button onclick="clickEliminarArchivoServicio({{$archivo_servicio->getId()}},'{{$archivo_general->nombreAparente}}')" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>

                              </button>
                            @else
                              
                            @endif
                          </td>
                        </tr>
                      @empty
                          <tr>
                            <td class="text-center" colspan="3">
                              No hay archivos
                            </td>
                          </tr>
                      @endforelse



                    </tbody>
                  </table>

                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="mx-3" id="mensaje_archivos_faltantes">
                      {{$servicio->getMensajeArchivosFaltantes()}}
                    </div>

                  </div>

                </div>


 
                <table class="table table-striped table-bordered table-condensed table-hover mt-4">
                  <thead class="thead-default">
                    <tr>
                      <th colspan="3" class=" text-center p-2">
                        OTROS ARCHIVOS
                      </th>
                    </tr>
                    <tr>
                      <th>
                        Tipo
                      </th>
                      <th class="text-left">
                        Archivo
                      </th>

                      <th class="text-center">
                        Opciones
                      </th>
                    </tr>
                  </thead>
                  <tbody>

                    @forelse($servicio->getListaOtrosArchivos($codsArchivosServiciosYaMostrados) as $archivo_servicio)
                      @php
                        $archivo_gen = $archivo_servicio->getArchivo();
                      @endphp
                      <tr>
                        <td>
                          @if($archivo_servicio->codTipoMedioVerificacion)
                            {{$archivo_servicio->getTipoArchivo()->nombre}}
                          @else
                            -
                          @endif
                        </td>
                        <td class="text-center">
                          {{$archivo_gen->nombreAparente}}
                        </td>


                        <td class="text-center">

                          <a class="btn btn-primary btn-sm" href="{{route('CITE.Servicios.DescargarArchivo',$archivo_gen->getId())}}" title="Descargar">
                            <i class=" fas fa-download"></i>
                          </a>
                          <button onclick="clickEliminarArchivoServicio({{$archivo_servicio->getId()}},'{{$archivo_gen->nombreAparente}}')" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                          </button>


                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td class="text-center" colspan="3">
                          No hay archivos
                        </td>
                      </tr>
                    @endforelse

                  </tbody>
                </table>

                <div class="row">
                  <div class="col-sm-6 text-center">
                     
                    <button onclick="abrirModalArchivoAparte()" data-toggle="modal" data-target="#ModalAgregarArchivo" class="btn btn-primary btn-sm">
                      Subir archivo externo 
                      <i class="fas  fa-upload"></i>
                    </button>

                  </div>


                </div>


              </div>

            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>


<div class="modal  fade" id="ModalAgregarArchivo" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">


      <div class="modal-header">
        <h5 class="modal-title" id="">
          Subir archivos
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        @php
          $file_uploader = new App\UI\FileUploader("nombreArchivo","file_serv",10,false,"Seleccionar archivo",["PDF"]);
        @endphp

        <form action="{{route('CITE.Servicios.SubirArchivos')}}" name="formSubirArchivo" id="formSubirArchivo" enctype="multipart/form-data" method="POST">
          @csrf
          <input type="hidden" name="codServicio" value="{{$servicio->codServicio}}">
          <input type="hidden" id="codTipoMedioVerificacion" name="codTipoMedioVerificacion" value="">
          <label for="">
            Tipo de Archivo:
          </label>
          <input type="text" id="label_medio_verificacion" class="form-control" value="" readonly>
          <div class="text-right">
            {{$file_uploader->render()}}
          </div>
    
        </form>


      </div>
      <div class="modal-footer">
        <div class="text-right">
          <button class="btn btn-success" type="button" onclick="clickSubirArchivo()">
            Subir archivos
          </button>

        </div>
      </div>
    </div>
  </div>
</div>



<script>

  const TipoMedioVerificacion = document.getElementById("codTipoMedioVerificacion");
  const LabelMedioVerificacion = document.getElementById("label_medio_verificacion");
    

  function abrirModalSubirArchivo(codTipoMedioVerificacion,nombre){
    TipoMedioVerificacion.value = codTipoMedioVerificacion;
    LabelMedioVerificacion.value = nombre;

  }

  function abrirModalArchivoAparte(){
    TipoMedioVerificacion.value = "";
    LabelMedioVerificacion.value = "Ningun tipo de formato especificado";

  }


  function clickSubirArchivo(codTipoMedioVerificacion) {

    const FileUploader = document.getElementsByName("file_serv[]")[0];
    console.log("FileUploader", FileUploader.files);
    if (FileUploader.files.length == 0) {
      alerta("No se ha cargado ningún archivo");
      return;
    }

    document.getElementById("formSubirArchivo").submit();

  }


  const MensajeArchivosFaltantes = document.getElementById("mensaje_archivos_faltantes");




  function clickEliminarArchivoServicio(codArchivoServicio, nombre) {

    confirmarConMensaje("Confirmación", "¿Desea eliminar el archivo \"" + nombre + "\"?", "warning", function() {
      location.href = "/Cite/Servicios/EliminarArchivo/" + codArchivoServicio;
    })
  }


  function clickSubirArchivoAparte() {
    const FileUploader = document.getElementsByName("file_serv_[]")[0];
    console.log("FileUploader", FileUploader.files);
    if (FileUploader.files.length == 0) {
      alerta("No se ha cargado ningún archivo");
      return;
    }

    document.getElementById("formArchivoAparte").submit();


  }

</script>
<style>
  
  .msj_ilovepdf{
    margin-top: -6px;
    color: #b40000;
    
  }

</style>