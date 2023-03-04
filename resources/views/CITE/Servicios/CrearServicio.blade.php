@extends('Layout.Plantilla')

@section('titulo')
  Registrar Servicio
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div >
    <p class="h2" style="text-align: center">
        Registrar Servicio
    </p>
</div>
<div class="card m-3">
    <div class="card-header">
        <div class="d-flex flex-row">
            <div class="">
                <h3 class="card-title">
                    {{--  <i class="fas fa-chart-pie"></i> --}}
                    <b>Información General</b>
                </h3>
            </div>
        </div>
    
    </div>
    <div class="card-body">

   
        <form method = "POST" action = "{{route('CITE.Servicios.Guardar')}}" id="frmrepo" name="frmrepo"  enctype="multipart/form-data">
            
            {{-- CODIGO DEL EMPLEADO --}}
            
            @csrf
            
            <div class="row  internalPadding-1 mx-2">
                <div  class="col-6">
                    <label for="codUnidadProductiva" id="" class="">
                        Unidad Productiva:
                    </label>
                    
                    <select id="codUnidadProductiva" name="codUnidadProductiva" data-select2-id="1" tabindex="-1"  
                        class="fondoBlanco form-control select2 select2-hidden-accessible selectpicker"   aria-hidden="true"  data-live-search="true">
                    
                        
                        <option value="-1">-- Seleccione Unidad Productiva --</option>
                        @foreach($listaUnidadesProductivas as $unidadProductiva)
                            <option value="{{$unidadProductiva->getId()}}">
                                {{$unidadProductiva->getDenominacion()}} {{$unidadProductiva->getRucODNI()}}
                            </option>
                        @endforeach
                        
                    </select>   
                </div>
                





                
                


                <div  class="col-6">
                    <label for="codModalidad" id="" class="">
                        Modalidad:
                    </label>
                
                    <select class="form-control"  id="codModalidad" name="codModalidad" onchange="actualizarModalidad(this.value)">
                        <option value="-1">-- Modalidad --</option>
                        @foreach($listaModalidades as $modalidad)
                            <option value="{{$modalidad->getId()}}">
                                {{$modalidad->nombre}}
                            </option>
                        @endforeach
                        
                    </select>   
                </div>
                

                <div class="col-12 row fondoPlomoCircular p-3 my-1 hidden" id="divConvenio">

                    <div  class="col-2">
                        <label for="codTipoCDP" id="" class="">
                            Comprobante:
                        </label>
                        <select class="form-control"  id="codTipoCDP" name="codTipoCDP"  >
                            <option value="-1">- Tipo Comprobante -</option>
                            @foreach($listaTipoCDP as $cdp)
                                <option value="{{$cdp->getId()}}">
                                    {{$cdp->nombreCDP}}
                                </option>
                            @endforeach
                        </select>

                        
                    </div>
                    <div  class="col-4">
                        <label for="nroComprobante" id="" class="">
                            Nro comprobante:
                        </label>
                    
                        <input type="text" class="form-control" id="nroComprobante" name="nroComprobante"/> 

                    </div>
                    <div  class="col-2">
                        <label for="baseImponible" id="" class="">
                            Base imponible:
                        </label>
                        <input type="number" class="form-control" id="baseImponible" name="baseImponible" onchange="cambioBaseImponible()"/> 
                    </div>
                    <div  class="col-2">
                        <label for="igv" id="" class="">
                            IGV:
                        </label>
                    
                        <input type="number" class="form-control" id="igv" name="igv" readonly/> 

                    </div>
                    <div  class="col-2">
                        <label for="total" id="" class="">
                            Total:
                        </label>
                    
                        <input type="number" class="form-control" id="total" name="total" onchange="cambioTotal()" /> 

                    </div>
                </div>
                


                

                


                
                <div  class="col-2">
                    <label for="cantidadServicio" id="" class="">
                        Cantidad Servicios:
                    </label>
                
                    <input type="number" class="form-control" id="cantidadServicio" name="cantidadServicio"/> 

                </div>
                


                <div  class="col-2">
                    <label for="totalParticipantes" id="" class="">
                        Total Participantes:
                    </label>
                    
                    <input type="number" class="form-control" id="totalParticipantes" name="totalParticipantes"/> 

                </div>
                

                <div  class="col-2">
                    <label for="nroHorasEfectivas" id="" class="">
                        Nro Horas efectivas:
                    </label>
                
                    <input type="number" class="form-control" id="nroHorasEfectivas" name="nroHorasEfectivas"/> 
                </div>
                


                <div  class="col-6">
                    <label for="descripcion" id="" class="">
                        Descripción del servicio:
                    </label>
                
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="2"
                    ></textarea>

                </div>

                
                <div  class="col-4">
                    <label for="codTipoServicio" id="" class="">
                        Tipo Servicio:
                    </label>
                    
                    <select class="form-control"  id="codTipoServicio" name="codTipoServicio" onchange="actualizarTipo(this.value)">
                        <option value="-1">-- Tipo Servicio --</option>
                        @foreach($listaTipoServicio as $tipoServ)
                            <option value="{{$tipoServ->getId()}}">
                                {{$tipoServ->nombre}}
                            </option>
                        @endforeach
                        
                    </select>   
                </div>

                
                <div  class="col-4">
                    <label for="codActividad" id="" class="">
                        Actividad :
                    </label>
                    
                    <select class="form-control"  id="codActividad" name="codActividad">
                        <option value="-1">-- Actividad --</option>
                        
                        
                    </select>   
                </div>
                
                <div  class="col-4">
                    <label for="codTipoAcceso" id="" class="">
                        Tipo Acceso:
                    </label>
                
                    <select class="form-control"  id="codTipoAcceso" name="codTipoAcceso">
                        <option value="-1">-- Tipo Acceso --</option>
                        @foreach($listaTipoAcceso as $tipoAcceso)
                            <option value="{{$tipoAcceso->getId()}}">
                                {{$tipoAcceso->nombre}}
                            </option>
                        @endforeach
                        
                    </select>   
                </div>

                
                <div  class="col-4">
                    <label for="codMesAño" id="" class="">
                        Mes:
                    </label>
                
                    <select class="form-control"  id="codMesAño" name="codMesAño">
                        <option value="-1">-- Mes --</option>
                        @foreach($listaMesesAño as $mesAño)
                            <option value="{{$mesAño->getId()}}"
                                @if($mesAño->getId() == $codMesAñoActual )
                                    selected
                                @endif
                                
                                >
                                {{$mesAño->getTexto()}}
                            </option>
                        @endforeach
                        
                    </select>   
                </div>


                <div class="col-4">
                    <label for="">Fecha Inicio:</label>

                    <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                        {{-- INPUT PARA LA FECHA --}}
                        <input type="text" style="text-align: center" class="form-control" name="fechaInicio" id="fechaInicio"
                                value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" style="font-size: 10pt;"> 
                        
                        <div class="input-group-btn">                                        
                            <button class="btn btn-primary date-set btn-sm" type="button" style="display: none">
                                <i class="fas fa-calendar fa-xs"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="col-4">
                    <label for="">Fecha Fin:</label>

                    <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                        {{-- INPUT PARA  FECHA --}}
                        <input type="text" style="text-align: center" class="form-control" name="fechaTermino" id="fechaTermino"
                                value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" style="font-size: 10pt;"> 
                        <div class="input-group-btn">                                        
                            <button class="btn btn-primary date-set btn-sm" type="button" style="display: none">
                                <i class="fas fa-calendar fa-xs"></i>
                            </button>
                        </div>
                    </div>

                </div>
                

        
                
                {{App\ComponentRenderizer::LugarSelector('ComboBoxDistrito',-1)}}


            </div>

            <div class="row p-2 mt-2">
                <div class="col-8"></div>
                <div class="col-4" >            
                    {{App\ComponentRenderizer::subirArchivos()}}

                </div>  
            </div>

            
            <div class="d-flex flex-row m-4">
                <div class="">

                    <a href="{{route('CITE.Servicios.Listar')}}" class='btn btn-info '>
                        <i class="fas fa-arrow-left"></i> 
                        Regresar al Menú
                    </a>  

                </div>
                <div class="ml-auto">

                    <button type="button" class="btn btn-primary" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                        onclick="registrar()">
                        <i class='fas fa-save'></i> 
                        Guardar
                    </button> 
                    
                </div>
            
            </div>
        
            
        </form>
            
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
        var codPresupProyecto = -1;
        
        
        $(document).ready(function(){
            $(".loader").fadeOut("slow");

            //contadorCaracteres('ruc','contadorRUC',11);
            //contadorCaracteres('observacion','contadorObservacion',{{App\Configuracion::tamañoObservacionOC}});
            
        });
        
        function registrar(){
            msje = validarFormulario();
            if(msje!="")
                {
                    alerta(msje);
                    return false;
                }
            
            confirmar('¿Está seguro de crear el servicio?','info','frmrepo');
            
        }


          

    </script>
     

    @include('CITE.Servicios.ServicioJS')
@endsection
 