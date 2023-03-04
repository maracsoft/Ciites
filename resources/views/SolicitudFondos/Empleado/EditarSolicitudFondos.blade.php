@extends('Layout.Plantilla')

@section('titulo')
Editar Solicitud
@endsection

@section('contenido')

<div class="text-center">


  <h1> 
      @if($solicitud->verificarEstado('Observada'))
          Subsanar Solicitud de Fondos        
      @else
          Editar Solicitud de Fondos
      @endif
  </h1>

</div>
@include('Layout.MensajeEmergenteDatos')
<form method = "POST" onsubmit="" action = "{{ route('SolicitudFondos.Empleado.update',$solicitud->codSolicitud) }}" 
        id="frmsoli" name="frmsoli"  enctype="multipart/form-data">
        
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepas" id="codigoCedepas" value="{{ $empleadoLogeado->codigoCedepas }}">

    @csrf
    <div class="mx-3" >
        <div class="row">           
            <div class="col-md" > {{-- COLUMNA IZQUIERDA 1 --}}
                <div class=""> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                      <div class="colLabel">
                            <label for="fecha">Fecha emisión</label>
                      </div>
                      <div class="col">
                                         
                        <input type="text"  class="form-control" name="fecha" id="fecha" disabled
                            value="{{$solicitud->formatoFechaHoraEmision()}}" >     
                      </div>

                      <div class="col">
                        <button type="button" class="btn btn-primary btn-sm fontSize8" style=""  
                            data-toggle="modal" data-target="#ModalHistorial">
                            Ver Historial  
                        </button>
                      </div>
                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="fecha">Girar a la orden de</label>

                      </div>
                      <div class="col">
                            <input type="text" class="form-control" name="girarAOrden" id="girarAOrden" value="{{$solicitud->girarAOrdenDe}}">    

                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div class="colLabel">
                            <label for="fecha">Nro Cuenta</label>

                      </div>
                      <div class="col">
                            <input type="text" class="form-control" name="nroCuenta" id="nroCuenta" value="{{$solicitud->numeroCuentaBanco}}">    
                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div class="colLabel">
                            <label for="fecha">Banco</label>

                      </div>
                      <div class="col"> {{-- Combo box de banco --}}
                            <select class="form-control"  id="ComboBoxBanco" name="ComboBoxBanco" >
                                {{-- <option value="0">-- Seleccionar -- </option> --}}
                                @foreach($listaBancos as $itemBanco)

                                    <option value="{{$itemBanco['codBanco']}}" 
                                    @if($solicitud->codBanco== $itemBanco->codBanco)
                                        selected
                                    @endif
                                    >
                                        {{$itemBanco->nombreBanco}}
                                    </option>                                 
                                
                                    @endforeach 
                            </select>      
                      </div>
                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div class="colLabel">
                            <label for="codSolicitud">Código Solicitud</label>

                      </div>
                      <div class="col"> {{-- Combo box de empleado --}}
                            <input type="text" class="form-control" name="codSolicitud" id="codSolicitud" readonly value="{{$solicitud->codigoCedepas}}">     
                      </div>



                    </div>


                </div>
                
                
                
                
            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
              <div class="row">
                <div class="col-sm-12">
                  <label for="">
                    Justificación 
                    <b id="contador" style="color: rgba(0, 0, 0, 0.548)"></b>
                  </label>
                  <textarea class="form-control" name="justificacion" id="justificacion" aria-label="With textarea" rows="4">{{$solicitud->justificacion}}</textarea>
                </div>
              </div>
              
            
              <div class="row mt-1">
        
                  <div  class="col-sm-3 d-flex">
                      <label class="my-auto" for="ComboBoxProyecto">Proyecto y Cod</label>

                  </div>
                  <div class="col-sm-9"> {{-- Combo box de proyecto --}}
                      <select class="form-control"  id="ComboBoxProyecto" name="ComboBoxProyecto" onchange="actualizarCodPresupProyecto()">
                          {{-- <option value="0">-- Seleccionar -- </option> --}}
                          @foreach($listaProyectos as $itemProyecto)
                              <option value="{{$itemProyecto['codProyecto']}}" 
                              @if($solicitud->codProyecto== $itemProyecto->codProyecto)
                                  selected
                              @endif
                              >
                                  [{{$itemProyecto->codigoPresupuestal}}] {{$itemProyecto->nombre}}
                              </option>                                 
                          @endforeach 
                      </select>      
                  </div>


                  









              </div>
              
              <div class="row mt-1">
                <div class="col-sm-2 d-flex">
                  <label class="my-auto" for="ComboBoxMoneda">Moneda:</label>
                </div>
                <div class="col-sm-4"> {{-- Combo box de monedas --}}
                    <select class="form-control"  id="ComboBoxMoneda" name="ComboBoxMoneda" >
                        
                        @foreach($listaMonedas as $itemMoneda)
                            <option value="{{$itemMoneda->codMoneda}}" 
                                @if($solicitud->codMoneda== $itemMoneda->codMoneda)
                                    selected
                                @endif
                                >
                                {{$itemMoneda->nombre}}
                            </option>                                 
                        @endforeach 
                    </select>      
                </div>


                <div class="col-sm-2 d-flex">
                    <label class="my-auto" for="codigoContrapartida">Cod Contrapartida:</label>
                </div>
                <div class="col-sm-4"> {{-- Combo box de monedas --}}
                    <input class="form-control" id="codigoContrapartida" name="codigoContrapartida" value="{{$solicitud->codigoContrapartida}}">        
                </div>


              </div>
              <div class="row">

                <div class="col-sm-3 d-flex">
                        <label for="estado">
                          Estado 
                          @if($solicitud->verificarEstado('Observada'))
                            & Obs 
                          @endif
                          :
                        </label>
                </div>
                <div class="col"> {{-- Combo box de estado --}}
                    <textarea readonly type="text" class="form-control" name="estado" id="estado"
                    style="background-color: {{$solicitud->getColorEstado()}} ;
                        color:{{$solicitud->getColorLetrasEstado()}};
                    "
                    readonly rows="3">{{$solicitud->getNombreEstado()}}{{$solicitud->getObservacionONull()}}</textarea>
                            
                </div>

                

              </div>

            </div>
        </div>
    </div>
    
       
         


        {{-- LISTADO DE DETALLES  --}}
        <div class="col-md-12 pt-3">     
            <div class="table-responsive">                           
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover tabla-detalles" style='background-color:#FFFFFF;'> 
                    <thead >
                        <th width="6%" class="text-center">
                            <div> {{-- INPUT PARA ITEM --}}
                                <input type="text" style="text-align: center" class="form-control" readonly  id="item" value="1">     
                            </div>    
                        </th>                                        
                        <th width="40%"> 
                            <div> {{-- INPUT PARA CONCEPTO--}}
                                <input type="text" class="form-control"  id="concepto">     
                            </div>
                            
                        </th>                                 
                        <th width="10%">
                            <div  > {{-- INPUT PARA importe--}}
                                <input type="number" min="0" class="form-control"  id="importe">     
                            </div>
                        </th>
                        <th width="15%" class="text-center">
                            <div > {{-- INPUT PARA codigo presup--}}
                                <input type="text" class="form-control" id="codigoPresupuestal">     
                            </div>

                        </th>
                        <th width="10%" class="text-center">
                            <div>
                                <button type="button" id="btnadddet"  
                                    class="btn btn-success" onclick="agregarDetalle()" >
                                    <i class="fas fa-plus"></i>
                                    <span class="d-none d-sm-inline">
                                      Agregar
                                    </span>

                                </button>
                            </div>    
                        
                        </th>                                            
                     
                    </thead>
                    
                    
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th class="text-center">Ítem</th>                                        
                        <th >Concepto</th>                                 
                        <th > Importe</th>
                        <th  class="text-center">Código Presupuestal</th>
                        <th  class="text-center">Opciones</th>                                            
                        
                    </thead>
                    <tfoot>

                                                                                        
                    </tfoot>
                    <tbody>
                    


                    </tbody>
                </table>
            </div> 
                
                <div class="row" id="divTotal" name="divTotal">                       
                    <div class="col-md-8">
                    </div>   
                    <div class="col-md-2">                        
                        <label for="">Total : </label>    
                    </div>   
                    <div class="col-md-2">
                        {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                        <input type="hidden" name="cantElementos" id="cantElementos">                              
                        <input type="hidden" class="form-control text-right" name="total" id="total" readonly>   
                        <input type="text" class="form-control text-right" name="totalMostrado" id="totalMostrado" readonly>   

                    </div>   
                </div>
                    

                
        </div> 
        

        <div class="col-md-12 mt-2">  
            <div id="guardar">
                <div class="form-group">
                    
                    <div class="row">
                        <div class="col-12 col-md-6">
                            @include('SolicitudFondos.Plantillas.DesplegableDescargarYEliminarArchivosSoli')
                        </div>
                        <div class="col-12 col-md-2"></div>
                        <div class="col-12 col-md-4">

                                                
                            {{-- Este es para subir todos los archivos x.x  --}}
                            <div class="col BordeCircular" id="divEnteroArchivo">    
                                <div class="row">
                                    <div class="col ">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipoIngresoArchivos" id="ar_noSubir" value="0" checked>
                                            <label class="form-check-label" for="ar_noSubir">
                                            No subir archivos
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipoIngresoArchivos" id="ar_añadir" value="1">
                                            <label class="form-check-label" for="ar_añadir">
                                            Añadir Archivos
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipoIngresoArchivos" id="ar_sobrescribir" value="2">
                                            <label class="form-check-label" for="ar_sobrescribir">
                                            Sobrescribir archivos
                                            </label>
                                        </div>
                                

                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col">
                                        <input type="{{App\Configuracion::getInputTextOHidden()}}" name="nombresArchivos" id="nombresArchivos" value="">
                                        <input type="file" multiple class="btn btn-primary" name="filenames[]" id="filenames"        
                                                style="display: none" onchange="cambio()">  
                                                        <input type="hidden" name="nombreImgImagenEnvio" id="nombreImgImagenEnvio">                 
                                        <label class="label" for="filenames" style="font-size: 12pt;">       
                                                <div id="divFileImagenEnvio" class="hovered">       
                                                Seleccionar Archivos 
                                                <i class="fas fa-upload"></i>        
                                            </div>       
                                        </label>  

                                    </div>
                                </div>
                                
                                    
                            </div>    
                           
                       

                        </div>
                        
                    </div>
                    <div class="row" >
                      <div class="col text-right">
                        <button class="btn btn-primary" type="button"  onclick="guardarActualizacion()" id="btnRegistrar" >
                          <i class='fas fa-save'></i> 
                          Actualizar
                        </button>  
                      </div>
                    

                    </div>
                    <div class="row">
                      <a href="{{route('SolicitudFondos.Empleado.Listar')}}" class='btn btn-info'>
                        <i class='fas fa-arrow-left'></i> 
                        Regresar al Menu
                      </a>          

                    </div>
                       

                </div>    
            </div>
        </div>
    
</form>

@php
    $listaOperaciones =  $solicitud->getListaOperaciones();
@endphp
@include('Operaciones.ModalHistorialOperaciones')

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

@include('Layout.ValidatorJS')
@include('Layout.EstilosPegados')
@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('script')
    <style>
        .BordeCircular{
            border-radius: 10px;
            background-color:rgb(190, 190, 190)
        }
    </style>
     <script>
        var cont=0;
        var detalleSol=[];
        
        $(window).load(function(){

            //cuando apenas carga la pagina, se debe copiar el contenido de la tabla a detalleSol
            cargarADetallesSol();
            actualizarCodPresupProyecto();
            $(".loader").fadeOut("slow");
            contadorCaracteres('justificacion','contador','{{App\Configuracion::tamañoMaximoJustificacion}}');
        });
        
        
        function guardarActualizacion(){
            msj=validarFormEdit();
            if(msj!=''){
                alerta(msj);
                return false;
            }

            confirmar('¿Seguro de actualizar la solicitud?','info','frmsoli');//[success,error,warning,info]
        }
        
        

        function cargarADetallesSol(){
            
            //obtenemos los detalles de una ruta GET 
            $.get('/listarDetallesDeSolicitud/'+{{$solicitud->codSolicitud}}, function(data)
            {      
                    listaDetalles = data;
                    for (let index = 0; index < listaDetalles.length; index++) {
                        console.log('Cargando detalle de solicitud:'+index);
                        
                        detalleSol.push({
                            item:               listaDetalles[index].nroItem,
                            concepto:           listaDetalles[index].concepto,
                            importe:            listaDetalles[index].importe,            
                            codigoPresupuestal: listaDetalles[index].codigoPresupuestal
                        });   
                    }
                    actualizarTabla();                

            });
        }

    

    //Retorna '' si es que todo esta OK y el STRING mensaje de error si no
    function validarFormEdit(){ //Retorna TRUE si es que todo esta OK y se puede hacer el submit
        msj='';
        limpiarEstilos(  ['justificacion','ComboBoxProyecto','ComboBoxMoneda','ComboBoxBanco','girarAOrden','nroCuenta','codigoContrapartida']);
        msj = validarTamañoMaximoYNulidad(msj,'justificacion',{{App\Configuracion::tamañoMaximoJustificacion}},'Justificación')
        msj = validarSelect(msj,'ComboBoxProyecto','-1','Proyecto');
        msj = validarSelect(msj,'ComboBoxMoneda','-1','Moneda');
        msj = validarSelect(msj,'ComboBoxBanco','-1','Banco');
        msj = validarTamañoMaximoYNulidad(msj,'girarAOrden',{{App\Configuracion::tamañoMaximoGiraraAOrdenDe}},'Girar a orden de');
        msj = validarTamañoMaximoYNulidad(msj,'nroCuenta',{{App\Configuracion::tamañoMaximoNroCuentaBanco}},'Número de Cuenta');
        msj = validarTamañoMaximo(msj,'codigoContrapartida',{{App\Configuracion::tamañoMaximoCodigoContrapartida}},'Código Contrapartida');
            
        msj = validarCantidadMaximaYNulidadDetalles(msj,'cantElementos',{{App\Configuracion::valorMaximoNroItem}});
            
        for (let index = 0; index < detalleSol.length; index++) {
            console.log('Comparando  ' +codPresupProyecto+' empiezaCon ' + codPresupProyecto.startsWith( detalleSol[index].codigoPresupuestal) )
            msj = validarCodigoPresupuestal(msj,"colCodigoPresupuestal"+index, codPresupProyecto,"Código presupuestal del Ítem N°" + (index+1))
        }

        return msj;
    }



    </script>
    @include('SolicitudFondos.Plantillas.CrearEditarSOF-JS')     










@endsection
