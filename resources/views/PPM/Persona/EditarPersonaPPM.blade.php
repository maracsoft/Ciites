@extends('Layout.Plantilla')

@section('titulo')
  Editar Persona
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

<div class="col-12 py-2">
  <div class="page-title">
    Editar Persona
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

   
        <form method = "POST" action = "{{route('PPM.Persona.Actualizar')}}" id="frmPersona" name="frmPersona"  enctype="multipart/form-data">
            <input type="hidden" name="codPersona" value="{{$persona->codPersona}}">
            @csrf
            
            

            <div class="row">
                                
              <div class="col-sm-4">
                  
                  <label for="">DNI:</label>
                  
                  <div class="d-flex">
                     
                      <input type="number" class="form-control" id="dni" name="dni" placeholder="DNI" value="{{$persona->dni}}">
                       
                      <div>
                          <button type="button" title="Buscar por DNI en la base de datos de Sunat" 
                              class="btn-sm btn btn-info d-flex align-items-center m-1" id="botonBuscarPorRUC" onclick="consultarUsuarioPorDNI()" >
                              <i class="fas fa-search m-1"></i>
                              
                          </button>
                      </div>
                  
                  </div>
              </div>
          
              <div class="col-sm-4">
                  <label for="">Teléfono:</label>
                  <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" value="{{$persona->telefono}}">

                  
              </div>
              <div class="col-sm-4">
                  <label for="">Correo:</label>
                  <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo" value="{{$persona->correo}}">

              </div>
              <div class="col-sm-4">
                  <label for="">Nombres:</label>
                  <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" value="{{$persona->nombres}}">
              
              </div>
              <div class="col-sm-4">

                  <label for="">Apellido Paterno:</label>
                  <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" placeholder="Apellido Paterno" value="{{$persona->apellido_paterno}}">
              

              </div>
              <div class="col-sm-4">
                  
                  <label for="">Apellido Materno:</label>
                  <input type="text"  class="form-control" id="apellido_materno" name="apellido_materno" placeholder="Apellido Materno" value="{{$persona->apellido_materno}}">

              </div>

               
                

              <div class="col-sm-4">
                <label for="">Fecha Nacimiento:</label>
                <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                  {{-- INPUT PARA LA FECHA --}}
                  <input type="text" class="form-control text-center" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="dd/mm/yyyy" value="{{$persona->getFechaNacimiento()}}"> 
                  
                  <div class="input-group-btn d-flex flex-column">                                        
                      <button class="btn btn-primary date-set my-auto mx-1" type="button" style="">
                          <i class="fas fa-calendar"></i>
                      </button>
                  </div>
                </div>
              </div>
                               
              <div class="col-sm-4">
                  
                <label for="">Sexo:</label>
                <select class="form-control" name="sexo" id="sexo">
                  <option value="">
                    - Sexo - 
                  </option>
                  @foreach($listaSexos as $sexo)
                    <option value="{{$sexo['id']}}" @if($persona->sexo == $sexo['id']) selected @endif>
                      {{$sexo['nombre']}}
                    </option>  
                  @endforeach
                  
                </select>
                
                
              </div>
                  
              

            </div>
         

            

        
        
            
        </form>
            
    </div>
    <div class="card-footer">
    
      <div class="d-flex flex-row">
        <div class="ml-auto">

            <button type="button" class="btn btn-primary" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                onclick="registrar()">
                <i class='fas fa-save'></i> 
                Guardar
            </button> 
            
        </div>
      </div>

    </div>
</div>

<div class="card">
  <div class="card-header">
    <div class="d-flex flex-row">
      <div class="">
          <h3 class="card-title">
              <b>
                Actividades en las que participó
              </b>
          </h3>
      </div>
    </div>
  </div>
  <div class="card-body">

    <div class="table-responsive">

      <table class="table table-bordered table-hover datatable fontSize10">
        <thead class="table-marac-header">
            <tr>
              <th>Cod</th>
              <th>Descripcion</th>
              <th>Organización</th>
              <th>Semestre</th>
              <th class="text-center">
                Lugar
              </th>
              <th>
                Actividad
              </th>
              
              <th>Opciones</th>
            </tr>
        </thead>
        <tbody>

            @foreach($listaParticipaciones as $participacion)
                @php
                  $actividad = $participacion->getEjecucionActividad();
                  
                @endphp
                <tr class="FilaPaddingReducido">
                    <td>
                        {{$actividad->getId()}}
                    </td>
                    <td class="fontSize9">
                        {{$actividad->descripcion}}
                    </td>
                    <td class="fontSize10">
                        {{$actividad->getOrganizacion()->getDenominacion()}}
                        [{{$actividad->getOrganizacion()->getRucODNI()}}]

                    </td>
                    <td>
                      {{$actividad->getResumenSemestres()}}
                        
                    </td>

                    <td class="text-center">
                        {{$actividad->getTextoLugar()}}
                    </td>
                    
                    <td class="fontSize9">
                        [{{$actividad->getActividad()->codigo_presupuestal}}]
                        {{$actividad->getActividad()->descripcion}}
                    </td>
                    
                    
                    <td>
                        <a href="{{route('PPM.Actividad.Ver',$actividad->getId())}}" class='btn btn-info btn-sm' title="Ver Unidad Productiva">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{route('PPM.Actividad.Editar',$actividad->getId())}}" class = "btn btn-sm btn-warning"
                          title="Editar Actividad">
                          <i class="fas fa-edit"></i>
                        </a>
 

                    </td>


                </tr>

            @endforeach
            @if(count($listaParticipaciones)==0)
                <tr>
                    <td colspan="10" class="text-center">
                        No hay resultados
                    </td>
                </tr>
            @endif

        </tbody>
      </table>  

    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <div class="d-flex flex-row">
      <div class="">
          <h3 class="card-title">
              <b>
                Organizaciones en las que está asociado
              </b>
          </h3>
      </div>
    </div>
  </div>
  <div class="card-body">

    <div class="d-flex">

      <button type="button" id="" class="ml-auto btn btn-sm btn-success m-1"
          data-toggle="modal" data-target="#ModalAgregarAOrganizacion">
          Añadir persona a una organización
          <i class="fas fa-plus"></i>
      </button>

    </div>

    <div class="table-responsive">

      <table class="table table-bordered table-hover datatable tablaPaddingReducido" id="table-3">
        <thead class="table-marac-header">
          <tr>
            <th>Cod</th>
            <th>
              Cargo
            </th>
            <th>Razón Social</th>
            <th>RUC/DNI</th>
            <th class="text-center">
              Tipo
            </th>
            <th>
              Act Económica
            </th>
            <th>
              #Activ.
            </th>
            <th>
              #Socios
            </th>
            <th>Lugar</th>
          
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody>
          
          @forelse($listaAsociaciones as $asociacion)
              @php
                $organizacion = $asociacion->getOrganizacion();
                
              @endphp
              <tr class="FilaPaddingReducido">
                  <td>
                      {{$organizacion->getId()}} 
                  </td>
                  <td>
                      {{$asociacion->cargo}}
                  </td>
                  <td class="fontSize11">
                      {{$organizacion->getDenominacion()}}
                  </td>
                  <td>
                      {{$organizacion->getRucODNI()}}
                  </td>
                  <td class="text-center">
                      {{$organizacion->getTipoOrganizacion()->nombre}}
                  </td>
                  <td>
                      @if($organizacion->tieneActividadEconomica())
                        {{$organizacion->getActividadEconomica()->nombre}}
                      @else
                        <span class="no-registra">
                          No Registra
                        </span>
                        
                      @endif
                      
                  </td>
                  <td class="text-center">
                      {{$organizacion->getCantidadEjecuciones()}}
                  </td>
                  <td class="text-center">
                      {{$organizacion->getCantidadAsociados()}}
                  </td>
                  <td class="fontSize11">
                      {{$organizacion->getTextoLugar()}}
                  </td>
                  <td class="">
                      
                      <a href="{{route('PPM.Organizacion.Editar',$organizacion->getId())}}" class='btn btn-warning btn-xs' title="Editar UnidadProductiva">
                          <i class="fas fa-pen"></i>
                      </a>
                  </td>
              </tr>
          @empty
              <tr>
                <td colspan="10" class="text-center">
                  La persona no está asociada a ninguna organización.
                </td> 
              </tr>
          @endforelse
          
        </tbody>
      </table>

    </div>
  </div>
</div>




<div class="">

  <a href="{{route('PPM.Persona.Listar')}}" class='btn btn-info '>
      <i class="fas fa-arrow-left"></i> 
      Regresar al Menú
  </a>  

</div>



{{-- MODAL DE AGREGAR A ORGANIZACION --}}
<div class="modal  fade" id="ModalAgregarAOrganizacion" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

              <div class="modal-header">
                  <h5 class="modal-title" id="">
                      Asociar persona a una organización
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">

                <form method="POST" name="formAsociarAOrganizacion" action="{{route('PPM.Persona.AsociarAOrganizacion')}}">
                  <input type="hidden" name="codPersonaAsociar" value="{{$persona->codPersona}}">
                  @csrf
                  <div class="row">

                    <div class="col-sm-12 mb-2" >
                      <label for="" class="mb-0">
                        Nombre:
                      </label>
                      <input type="text" class="form-control" value="{{$persona->getNombreCompleto()}}" readonly>
                    </div>

                    <div class="col-sm-12 mb-2">

                      <label for="codOrganizacion" id="" class="mb-0">
                        Organización:
                      </label>
                
                  
                    
                        <select id="codOrganizacionAsociar" name="codOrganizacionAsociar" data-select2-id="1" tabindex="-1"  
                          class="fondoBlanco form-control select2 select2-hidden-accessible selectpicker"   aria-hidden="true"  data-live-search="true">
                      
                          <option value="-1">-- Seleccione Organización --</option>
                          @foreach($listaOrganizaciones as $organizacion)
                              <option value="{{$organizacion->getId()}}">
                                  {{$organizacion->getDenominacion()}} {{$organizacion->getRucODNI()}}
                              </option>
                          @endforeach
                          
                        </select>
                
                    
              
                      
                    
                    </div>    

                    <div class="col-sm-12 mb-2">
                      <label for="" class="mb-0">
                        Cargo en la organización:
                      </label>
                      <input type="text" class="form-control" id="cargo_organizacion" name="cargo_organizacion" placeholder="Cargo en la organización">
                          

                    </div>

                  </div>                    
                </form>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">
                      Salir
                  </button>

                  <button type="button" class="m-1 btn btn-primary" onclick="clickGuardarAsociacion()">
                      Guardar
                      <i class="fas fa-save"></i>
                  </button>
              </div>


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
 
@include('Layout.EstilosPegados')
@include('Layout.ValidatorJS')
@section('script')
 
<script type="application/javascript">
 

  $(document).ready(function(){
      $(".loader").fadeOut("slow");
  });

  function registrar(){
      msje = validarFormulario(false);
      if(msje!=""){
          alerta(msje);
          return false;
      }
      
      confirmar('¿Está seguro de editar la persona?','info','frmPersona');
  }


  function clickGuardarAsociacion(){
    var msj = validarFormAsociar();
    if(msj!=""){
      alerta(msj);
      return;
    }

    document.formAsociarAOrganizacion.submit();

  }
  
  function validarFormAsociar(){
    limpiarEstilos([
      'cargo_organizacion',
      'codOrganizacionAsociar'
	  ]);

    msj = "";
 
    //obligatorios nombres y apellidos
    msj = validarTamañoMaximoYNulidad(msj,'cargo_organizacion',200,'Cargo en la organización');
    msj = validarSelect(msj,'codOrganizacionAsociar',-1,'Organización a asociar');
     
    return msj;
  }

</script>
  
@include('PPM.Persona.ReusableJSPersonaPPM')
 
@endsection
 
@section('estilos')
<style>



</style>
@endsection