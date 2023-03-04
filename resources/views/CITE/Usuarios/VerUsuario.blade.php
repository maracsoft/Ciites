@extends('Layout.Plantilla')

@section('titulo')
  Ver Usuario
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div >
    <p class="h1" style="text-align: center">
        Ver Usuario
    </p>
</div>

@include('Layout.MensajeEmergenteDatos')
<form method = "POST" action = "" id="" name=""  enctype="multipart/form-data">
    
    
    @csrf
    
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
                            {{$usuario->getFechaHoraCreacion()}}
                        </b>
                            por 
                        <b>
                            {{$usuario->getEmpleadoCreador()->getNombreCompleto()}}</b>)
                    </span>    
                </div>
    
            </div>
        </div> 
        <div class="card-body">


       
            

            <div class="row  internalPadding-1 mx-2">
                                
                    <div class="col-4">
                        <label for="">DNI:</label>
                        <input type="number" class="form-control" id="dni" name="dni" value="{{$usuario->dni}}" readonly>
                    </div>
                
                    <div class="col-4">
                        <label for="">Teléfono:</label>
                        <input type="number" class="form-control" id="telefono" name="telefono" value="{{$usuario->dni}}" readonly>

                        
                    </div>
                    <div class="col-4">
                        <label for="">correo:</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="{{$usuario->correo}}" readonly>

                    </div>
                    <div class="col-4">
                        <label for="">nombres:</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" value="{{$usuario->nombres}}" readonly>
                    
                    </div>
                    <div class="col-4">

                        <label for="">apellidoPaterno:</label>
                        <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" value="{{$usuario->apellidoPaterno}}" readonly>
                    

                    </div>
                    <div class="col-4">
                        
                        <label for="">apellidoMaterno:</label>
                        <input type="text"  class="form-control" id="apellidoMaterno" name="apellidoMaterno" value="{{$usuario->apellidoMaterno}}" readonly>

                    </div>
            </div>
        </div>
    </div>



    <div class="card mx-2">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <div class="d-flex flex-row">
                <div class="">
                    <h3 class="card-title">
                        {{--  <i class="fas fa-chart-pie"></i> --}}
                        <b>Servicios</b>
                    </h3>
    
                </div>
            </div>
        </div> 
        <div class="card-body">
            
                <div class="row">
                    <div class="col-6 align-self-end">
                        <label class="d-flex" for="">
                            Lista de Servicios en los que participó
                        </label>
                    </div>
                    <div class="col-6 text-right">
                        <div class="mr-1 my-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalAgregarServicio"
                                    onclick="">
                                <i class="fas fa-plus"></i>
                                Agregar Servicio
                            </button>
                        </div>
                    </div>
                
                </div>

                <table class="table table-striped table-bordered table-condensed table-hover" >
                    <thead  class="thead-default">
                        <tr>
                            <th class="text-right">
                                Descripcion
                            </th>
                        
                            <th class="text-right">
                                Fecha
                            </th>
                            <th class="text-right">
                                Unidad Productiva
                            </th>
                            <th class="text-left">
                                Lugar
                            </th>
                            <th>
                                Opciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuario->getServicios() as $servicio )
                            <tr>
                                <td class="text-right">
                                    {{$servicio->descripcion}}
                                </td>
                            
                                <td class="text-right">
                                    {{$servicio->getFechaInicio()}} // {{$servicio->getFechaTermino()}}
                                </td>
                                <td class="text-right">
                                    {{$servicio->getUnidadProductiva()->getDenominacion()}}
                                </td>
                                <td class="text-left">
                                    {{$servicio->getTextoLugar()}}
                                </td>
                                <td class="text-center">
                                    <a href="{{route('CITE.Servicios.Ver',$servicio->getId())}}" class='btn btn-info btn-sm' title="Ver Servicio">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        

                    </tbody>
                </table>
 
    

        </div>
    </div>
 



    <div class="card mx-2">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <div class="d-flex flex-row">
                <div class="">
                    <h3 class="card-title">
                        {{--  <i class="fas fa-chart-pie"></i> --}}
                        <b>Unidades Productivas</b>
                    </h3>

                </div>
            </div>
        </div> 
        <div class="card-body">
    
            <div class="col-12 row">
                <div class="col-6 align-self-end">
                    <label class="d-flex" for="">
                        Unidades productivas a las que pertenece:
                    </label>
                </div>
                <div class="col-6 text-right">
                    <div class="mr-1 my-2">
                        
                    </div>
                </div>
            
            </div>

            <table class="table table-striped table-bordered table-condensed table-hover" >
                <thead  class="thead-default">
                    <tr>
                        <th class="text-center">
                            Razón Social
                        </th>
                        <th class="text-center">
                            RUC
                        </th>
                        
                        <th class="text-center">
                            Opciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuario->getRelaUnidadProductiva() as $relaUnidadProductiva )
                        @php
                            $unidadProductiva = $relaUnidadProductiva->getUnidadProductiva();
                        @endphp
                        <tr>
                        
                            <td>
                                {{$unidadProductiva->getDenominacion()}}
                            </td>
                            <td class="text-center">
                                {{$unidadProductiva->getRucODNI()}}  
                            </td>
                        
                            
                            <td class="text-center">
                                <a href="{{route('CITE.UnidadesProductivas.Ver',$unidadProductiva->getId())}}" class='btn btn-info btn-sm' title="Ver Unidad Productiva">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    

                </tbody>
            </table>
    
        
    
        </div>
    </div>
 

      
    <div class="d-flex flex-row m-4">
        <div class="">

            <a href="{{route('CITE.Usuarios.Listar')}}" class='btn btn-info '>
                <i class="fas fa-arrow-left"></i> 
                Regresar al Menú
            </a>  

        </div>
        
    
    </div>
   
    
 

</form>



        
<div class="modal fade" id="ModalAgregarServicio" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{route('CITE.Usuarios.VincularServicio')}}" id="frmAgregarServicio" name="frmAgregarServicio"  method="POST">
                @csrf
                <input type="hidden" name="codUsuario" value="{{$usuario->codUsuario}}">
                 

                <div class="modal-header">
                    <h5 class="modal-title" id="">Vincular servicio al usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                        
                    <div class="col-12">
                        <label for="">Servicio:</label>
                        <select class="form-control form-control-sm select2 select2-hidden-accessible selectpicker" data-select2-id="1" 
                              tabindex="-1" aria-hidden="true" id="codServicio" name="codServicio" data-live-search="true">
 
                            <option value="-1">- ID Servicio -</option>
                            @foreach($listaServiciosEnQueNoParticipo as $servicio)
                                <option value="{{$servicio->getId()}}">
                                  {{$servicio->getId()}}. {{$servicio->descripcion}}   ({{$servicio->getDistrito()->nombre}})
                                </option>

                            @endforeach
                        </select>
                        
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Salir
                    </button>

                    <button type="button" class="m-1 btn btn-primary" onclick="clickVincularNuevoServicio()">
                        Guardar
                        <i class="fas fa-save"></i>
                    </button>   
                </div>
            
            </form>
        </div>
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

             
        });
         
        function clickVincularNuevoServicio(){
            msjError = validarSelect('','codServicio','-1','Servicio');
            if(msjError != ""){
                alerta(msjError);
                return;
            }
            document.frmAgregarServicio.submit();


        }
 
 

    </script>
     


@endsection
 