@extends('Layout.Plantilla')

@section('titulo')
  Ver Actividad
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')
@php
  $file_uploader = new App\UI\FileUploader("nombresArchivos","filenames",10,true,"Subir archivos");
@endphp
<div class="col-12 py-2">
  <div class="page-title">
    Ver Actividad
  </div>
</div>
@include('Layout.MensajeEmergenteDatos')
<div class="card ">
    <div class="card-header">
        <div class="d-flex flex-row">
            <div class="">
                <h3 class="card-title">
                    <b>Información General</b>
                </h3>
            </div>
        </div>
    
    </div>
    <div class="card-body">

   
        <form  id="frmActividad" name="frmActividad"  enctype="multipart/form-data">
            
            <div class="row  internalPadding-1 mx-2">
                <div class="col-sm-12">
                    <label for="codOrganizacion" id="" class="">
                        Organización:
                    </label>
                    <input type="text" class="form-control" value="{{$ejecucion->getOrganizacion()->getDenominacion()}}" readonly>
                    
                </div>
                
                <div class="col-12">
                    <label for="codObjetivo" id="" class="">
                        Objetivo:
                    </label>
                    <input type="text" class="form-control" value="{{$ejecucion->getObjetivo()->indice}}) {{$ejecucion->getObjetivo()->nombre}}" readonly>
                     
                </div>

                <div class="col-12">
                  <label for="codIndicador" id="" class="">
                      Indicador:
                  </label>
                  <input type="text" class="form-control" value="{{$ejecucion->getIndicador()->indice}}) {{$ejecucion->getIndicador()->nombre}}" readonly>
                    
                 
                </div>

                 
                <div class="col-12">
                  <label for="codActividad" id="" class="">
                      Cod Presupuestal y Actividad:
                  </label>
                  
                  <input type="text" class="form-control" value="{{$ejecucion->getActividad()->codigo_presupuestal}}) {{$ejecucion->getActividad()->descripcion_corta}}" readonly>
                   
                </div>
              
                 
                <div class="col-sm-12">
                    <label for="descripcion" id="" class="">
                        Descripción de la actividad:
                    </label>
                
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="2" disabled
                    >{{$ejecucion->descripcion}}</textarea>

                </div>
 


                 


                <div class="col-12 col-sm-4">
                    <label for="">Fecha Inicio:</label>

                    <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                        {{-- INPUT PARA LA FECHA --}}
                        <input type="text" style="text-align: center" class="form-control" name="fechaInicio" id="fechaInicio" disabled
                                value="{{$ejecucion->getFechaInicio()}}" style="font-size: 10pt;"> 
                        
                        <div class="input-group-btn">                                        
                            <button class="btn btn-primary date-set btn-sm" type="button" style="display: none">
                                <i class="fas fa-calendar fa-xs"></i>
                            </button>
                        </div>
                    </div>
                    
                    
                </div>

                <div class="col-12 col-sm-4">
                    <label for="">Fecha Fin:</label>

                    <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                        {{-- INPUT PARA  FECHA --}}
                        <input type="text" style="text-align: center" class="form-control" name="fechaFin" id="fechaFin" disabled
                                value="{{$ejecucion->getFechaFin()}}" style="font-size: 10pt;"> 
                        <div class="input-group-btn">                                        
                            <button class="btn btn-primary date-set btn-sm" type="button" style="display: none">
                                <i class="fas fa-calendar fa-xs"></i>
                            </button>
                        </div>
                    </div>

                </div>
                <div class="col-sm-4">
                  <label for="">
                    Semestres:
                  </label>
                  <input type="text" class="form-control text-center" readonly value="{{$ejecucion->getResumenSemestres()}}">
                </div>

                {{App\ComponentRenderizer::LugarSelector('ComboBoxDistrito',$ejecucion->codDistrito,true)}}

            </div>

            <div class="row mt-2"> {{-- ARCHIVOS --}}
              <div class="col-sm-6">
                  {{$ejecucion->html_getArchivosDelServicio(false)}}

              </div>
              <div class="col-sm-6">
                
                <div class="">
                  <div class="d-flex">
                      
                    <a target="_blank" href="{{$link_drive}}" class="link-drive d-flex">
                      <div class="d-flex flex-column mr-2">
                        <img src="/img/icono-drive.png" alt="" class="my-auto link-drive-img">
                      </div>
                      <div class="d-flex flex-column">
                        <div>
                          Subir archivos al drive
                        </div>
                        <div class=" fontSize10 mt-n1">
                          (Subir a la carpeta de tu unidad técnica)
                        </div>
                      </div>
                        
                        
                      
                    </a>
                    
                  </div>
                  
                </div>

              </div>
            </div>

            
 
        
            
        </form>
            
    </div>
    
</div>
  
<div class="card mx-2">
  <div class="card-header ui-sortable-handle" style="cursor: move;">
      <h3 class="card-title">
         {{--  <i class="fas fa-chart-pie"></i> --}}
          <b>Lista de participantes</b>
      </h3>
  </div>
  <div class="card-body">
      <div class="row">

          <div class="col-12 row">
              <div class="col-6 align-self-end">
                  <label class="d-flex" for="">
                    Participantes:
                  </label>
              </div>
              

          </div>
          <div class="table-responsive">
              
            <table class="table table-striped table-bordered table-condensed table-hover tabla-detalles" >
                <thead  class="thead-default">
                    <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-right">
                            DNI
                        </th>
                        <th class="text-left">
                            Nombre
                        </th>
                        <th class="text-right">
                            Teléfono
                        </th>
                        <th class="text-right">
                            Correo
                        </th>
                        <th class="text-center">
                            Externo?
                        </th>
                        <th class="text-center">
                            Opciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                        $participaciones = $ejecucion->getParticipaciones();

                    @endphp
                    @foreach($participaciones as $participacion)
                        @php
                            $persona = $participacion->getPersona();
                        @endphp
                        <tr>
                            <td class="text-center">
                                {{$i}}
                            </td>
                            <td class="text-right">
                                {{$persona->dni}}
                            </td>
                            <td class="text-left">
                                {{$persona->getNombreCompleto()}}
                            </td>
                            <td class="text-right">
                                {{$persona->telefono}}
                            </td>
                            <td class="text-right">
                                {{$persona->correo}}
                            </td>
                            <td class="text-center">
                                @if($participacion->esExterno())
                                    SÍ
                                @else
                                    NO
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{route('PPM.Persona.Ver',$persona->getId())}}" class='btn btn-info btn-sm' title="Ver Usuarios">
                                    <i class="fas fa-eye"></i>
                                </a>
 
                            </td>

                        </tr>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                    @if(count($participaciones) == 0)
                        <tr>
                            <td class="text-center" colspan="7">
                                No hay usuarios registrados en este servicio
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>

          </div>
      </div>



  </div>
</div>

 
<div class="row">
  <div class="col px-3">
    <a href="{{route('PPM.Actividad.Listar')}}" class='btn btn-info '>
      <i class="fas fa-arrow-left"></i> 
      Regresar al Menú
    </a>  
  </div>

</div>
 



 
 





@endsection

{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
 
@include('Layout.EstilosPegados')
@include('Layout.ValidatorJS')
@section('script')
 
<script type="application/javascript">
  

  $(document).ready(function(){
      $(".loader").fadeOut("slow");

  });
 
   
 
</script>
  
 
@include('PPM.EjecucionActividad.EjecucionReusableJS')

@endsection
 
@section('estilos')
<style>
  .link-drive{
    background-color: rgb(236, 253, 255);
    padding: 15px 10px;
    font-size: 15pt;
  }
  .link-drive-img{
    width: 33px;
    height: 33px;

  }
  .link-drive-span{

  }


</style>
@endsection