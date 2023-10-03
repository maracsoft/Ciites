@extends('Layout.Plantilla')

@section('titulo')
  Ver Servicio
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div >
    <p class="h1" style="text-align: center">
        Ver Servicio
    </p>
</div>


 

@csrf
@include('Layout.MensajeEmergenteDatos')



<div class="card mx-2">
    <div class="card-header ui-sortable-handle" style="cursor: move;">
        <div class="d-flex flex-row">
            <div class="">
                <h3 class="card-title">
                    {{--  <i class="fas fa-chart-pie"></i> --}}
                    <b>Información General</b>
                </h3>

            </div>
           
            <div class="ml-1 mt-1">
                <span class="fontSize10">
                    (Servicio registrado el 
                    <b>
                        {{$servicio->getFechaHoraCreacion()}}
                    </b>
                        por 
                    <b>
                        {{$servicio->getEmpleadoCreador()->getNombreCompleto()}}</b>)
                </span>    
            </div>

        </div>
    </div> 
    <div class="card-body">

        <div class="row  internalPadding-1">
            <div  class="col-12">
                <label for="codUnidadProductiva" id="" class="">
                    Unidad Productiva:
                </label>
                <div class="d-flex">
                    
                        <input type="text" class="form-control" 
                            value="{{$servicio->getUnidadProductiva()->getDenominacion()}}  {{$servicio->getUnidadProductiva()->getRucODNI()}}" readonly /> 
                    
                        <a href="{{route('CITE.UnidadesProductivas.Ver',$servicio->codUnidadProductiva)}}" class="btn btn-primary btn-sm d-flex m-1">
                            <i class="fas fa-eye my-auto"></i>
                        </a>
                    
                </div>
                
            </div>
            



            <div  class="col-6">
                <label for="codTipoServicio" id="" class="">
                    Tipo Servicio:
                </label>
                <input type="text" class="form-control" value="{{$servicio->getTipoServicio()->nombre}}" readonly /> 

                
            </div>
            


            <div  class="col-6">
                <label for="codModalidad" id="" class="">
                    Modalidad:
                </label>
                <input type="text" class="form-control" value="{{$servicio->getModalidad()->nombre}}" readonly /> 
    
            </div>

            @if($servicio->codModalidad==1)
                    
                <div  class="col-2">
                    <label for="descripcion" id="" class="">
                        Comprobante:
                    </label>
                    <input type="text" class="form-control" value="{{$servicio->getTipoCDP()->nombreCDP}}" readonly/> 

                    
                </div>
                <div  class="col-4">
                    <label for="descripcion" id="" class="">
                        Nro comprobante:
                    </label>
                
                    <input type="text" class="form-control" id="nroComprobante" name="nroComprobante" value="{{$servicio->nroComprobante}}" readonly/> 

                </div>
                <div  class="col-2">
                    <label for="descripcion" id="" class="">
                        Base imponible:
                    </label>
                
                    <input type="number" class="form-control" id="baseImponible" name="baseImponible" value="{{$servicio->baseImponible}}" readonly/> 

                </div>
                <div  class="col-2">
                    <label for="descripcion" id="" class="">
                        IGV:
                    </label>
                
                    <input type="number" class="form-control" id="igv" name="igv" value="{{$servicio->igv}}" readonly/> 

                </div>
                <div  class="col-2">
                    <label for="descripcion" id="" class="">
                        Total:
                    </label>
                
                    <input type="number" class="form-control" id="total" name="total" value="{{$servicio->total}}" readonly/> 

                </div>
        
                
            @endif

            <div class="col-2"></div>


            <div  class="col-2">
                <label for="codTipoAcceso" id="" class="">
                    Tipo Acceso:
                </label>
                <input type="text" class="form-control" value="{{$servicio->getTipoAcceso()->nombre}}" readonly /> 
    
            </div>
            

            


            
            <div  class="col-2">
                <label for="descripcion" id="" class="">
                    Cantidad Servicios:
                </label>
                <input type="text" class="form-control" value="{{$servicio->cantidadServicio}}" readonly /> 
    

            </div>
            


            <div  class="col-2">
                <label for="descripcion" id="" class="">
                    Total Participantes:
                </label>
                <input type="text" class="form-control" value="{{$servicio->totalParticipantes}}" readonly /> 
    

            </div>
            

            <div  class="col-2">
                <label for="descripcion" id="" class="">
                    Nro Horas efectivas:
                </label>
                <input type="text" class="form-control" value="{{$servicio->nroHorasEfectivas}}" readonly /> 
        
            </div>
            


            <div  class="col-12">
                <label for="descripcion" id="" class="">
                    Descripción:
                </label>
            
                <textarea class="form-control" id="descripcion" name="descripcion" rows="1" readonly
                >{{$servicio->descripcion}}</textarea>

            </div>


            
            <div  class="col-3">
                <label for="codMes" id="" class="">
                    Mes:
                </label>
                <input type="text" class="form-control" value="{{$servicio->getMesAño()->getTexto()}}"  readonly/> 
        
                
            </div>


            <div class="col-3">
                <label for="">Fecha Inicio:</label>
                <input type="text" class="form-control" value="{{$servicio->getFechaInicio()}}" readonly /> 
        

            </div>

            <div class="col-3">
                <label for="">Fecha Fin:</label>
                <input type="text" class="form-control" value="{{$servicio->getFechaTermino()}}"  readonly/> 
        

            </div>
            
            <div class="col-3  centerLabels">
                <label for="">
                    Región // Prov // Dist:
                </label>
        
                <input type="text" class="form-control" value="{{$servicio->getTextoLugar()}}" readonly>
                
            </div>
            



        </div>

            

        <div class="row mt-2">
            <div class="col-6">
                {{$servicio->html_getArchivosDelServicio(false)}}
            </div>
            <div class="col-6">

            </div>
            
        </div>

    </div>
</div>



<div class="card mx-2">
    <div class="card-header ui-sortable-handle" style="cursor: move;">
        <h3 class="card-title">
           {{--  <i class="fas fa-chart-pie"></i> --}}
            <b>Asistencia de usuarios</b>
        </h3>
    </div> 
    <div class="card-body">

        <div class="row">
            

            <div class="col-12 row mt-2">
                <div class="col-6 align-self-end">
                    <label class="d-flex" for="">
                        Usuarios del servicio:
                    </label>
                </div>
                <div class="col-6 text-right">
                    
                </div>
            
            </div>


            <table class="table table-striped table-bordered table-condensed table-hover" >
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
                    @endphp
                    @foreach($servicio->getUsuarios() as $usuario )
                        @php
                            $relaAsistenciaServicio = $servicio->getAsistenciaDeUsuario($usuario->getId());
                        @endphp
                        <tr>
                            <td class="text-center">
                                {{$i}}
                            </td>
                            <td class="text-right">
                                {{$usuario->dni}}
                            </td>
                            <td class="text-left">
                                {{$usuario->getNombreCompleto()}}
                            </td>
                            <td class="text-right">
                                {{$usuario->telefono}}
                            </td>
                            <td class="text-right">
                                {{$usuario->correo}}
                            </td>
                            <td class="text-center">
                                @if($relaAsistenciaServicio->esExterno())
                                    SÍ
                                @else
                                    NO
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{route('CITE.Usuarios.Ver',$usuario->getId())}}" class='btn btn-info btn-sm' title="Ver Usuarios">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                            </td>
                            
                        </tr>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                    @if(count($servicio->getRelaAsistenciaServicio()) == 0)
                        <tr>
                            <td class="text-center" colspan="6">
                                No hay usuarios registrados en este servicio
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>

        </div>
    </div>
</div>

 

      
    <div class="d-flex flex-row m-4">
        <div class="">

            <a href="{{route('CITE.Servicios.Listar')}}" class='btn btn-info '>
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

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

@include('Layout.EstilosPegados')
@include('Layout.ValidatorJS')
@section('script')
  
<script type="application/javascript">
    //se ejecuta cada vez que escogewmos un file
        
        $(document).ready(function(){
            $(".loader").fadeOut("slow");
            
            
        });
        
    </script>
     


@endsection
 