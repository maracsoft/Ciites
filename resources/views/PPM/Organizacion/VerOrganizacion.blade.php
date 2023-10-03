@extends('Layout.Plantilla')

@section('titulo')
  PPM - Ver Organización
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

@php
  $readonly_cb = 'onclick="return false;"';

@endphp


<div class="col-12 py-2">
  <div class="page-title">
    Ver Organización
  </div>
</div>
@include('Layout.MensajeEmergenteDatos')
<form method="POST" action="" id="frmOrganizacion" name="frmOrganizacion"  enctype="multipart/form-data">
     
 

    <div class="card mx-2">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <div class="d-flex flex-row">
                <div class="">
                    <h3 class="card-title">
                        <b>Información General</b>
                    </h3>
                </div>
            </div>
        </div>
        <div class="card-body">


            <div class="row">
                <div class="col-md"> {{-- COLUMNA IZQUIERDA 1 --}}

                    <div class="row internalPadding-1 mx-2">

                      
                        <div class="col-sm-2">
                          <label for="codTipoDocumento" id="lvlProyecto" class="">
                              Documento:
                          </label>
                          <input type="text" class="form-control" value="{{$organizacion->getTipoDocumento()->nombre}}" readonly>
                           
                        </div>

                        <div class="col-sm-4">
                            <label for="codTipoOrganizacion" class="">
                                Tipo de organización:
                            </label>
                            <input type="text" class="form-control" value="{{$organizacion->getTipoOrganizacion()->nombre}}" readonly>
                            
                        </div>
                      



                     
                        <div class="col-sm-6">

                            <input class="cursor-pointer" type="checkbox" value="1" onclick="return false;" id="tiene_act_economica" name="tiene_act_economica" @if($organizacion->tieneActividadEconomica()) checked @endif>
                            <label class="cursor-pointer" for="tiene_act_economica">
                                Tiene Actividad Económica:
                            </label>

                            <div class="d-flex">
                              @if($organizacion->tieneActividadEconomica())
                                <input type="text" class="form-control" value="{{$organizacion->getActividadEconomica()->nombre}}" readonly>

                              @endif
                              

                            </div>

                        </div>
                       

                        @if($organizacion->getTipoDocumento()->nombre == "RUC")
                          <div class="col-12 row " id="divRUC">


                              <div  class="col-sm-4">
                                  <div class="d-flex ">
                                    <label for="" id="">RUC:
                                      
                                    </label>

                                    <div class="ml-auto form-check fontSize10 pr-4">
                                      <input class="form-check-input cursor-pointer" type="checkbox" onclick="return false;" value="1" id="documento_en_tramite" name="documento_en_tramite"  >
                                      <label class="form-check-label cursor-pointer" for="documento_en_tramite">
                                          RUC En trámite
                                      </label>
                                    </div>

                                  </div>
                                

                                  <div class="d-flex flex-col">

                                    <input type="number" class="form-control" placeholder="RUC" name="ruc" id="ruc" value="{{$organizacion->ruc}}" readonly>

                                    
                                </div>
                              </div>
                          
                              <div  class="col-sm-5">
                                  <label for="razon_social">Razón Social</label>
                                  <input type="text" class="form-control" placeholder="Razón Social" name="razon_social" id="razon_social" readonly value="{{$organizacion->razon_social}}">
                              </div>   

                          </div>                          
                        @else
                          <div class="col-12 row " id="divNoRUC">

                            <div class="col-sm-6">
                              <label for="razon_social_noruc">Razón Social:</label>
                              <input type="text" class="form-control" placeholder="Razón Social" name="razon_social_noruc" id="razon_social_noruc" value="{{$organizacion->razon_social}}">
                            </div>

                          </div>
                        @endif
                        

                        <div class="col-sm-12">
                            <label for="" id="">Dirección:</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" value="{{$organizacion->direccion}}" placeholder="Dirección" readonly>
                        </div> 



                        {{App\ComponentRenderizer::LugarSelector('ComboBoxDistrito',$organizacion->codDistrito,true)}}

                        
                        <div class="col-sm-6"  title="Activando esta opción, al editar los miembros de esta organización, se editarán también en la unidad productiva enlazada del CITE">
                           
                          <input class="cursor-pointer" type="checkbox" onclick="return false;" value="1" id="activar_enlace_cite" name="activar_enlace_cite" @if($organizacion->tieneEnlaceCite()) checked @endif>
                          
                          <label class="ml-1 cursor-pointer" for="activar_enlace_cite">
                              Activar enlace CITE:
                          </label>
                          
                          <div class="d-flex flex-row">
                          
                            <select id="codUnidadProductivaEnlazadaCITE" name="codUnidadProductivaEnlazadaCITE" disabled data-select2-id="1" tabindex="-1" onchange="changedUnidadProductivaEnlazada()"
                              class="fondoBlanco form-control select2 select2-hidden-accessible selectpicker"   aria-hidden="true"  data-live-search="true">
                              <option value="-1">
                                - Unidad Productiva CITE Enlazada -
                              </option>
                              @foreach($listaUnidadesProductivas as $unidad_prod)
                                <option value="{{$unidad_prod->getId()}}" {{$unidad_prod->isThisSelected($organizacion->codUnidadProductivaEnlazadaCITE)}}>
                                  {{$unidad_prod['label_front']}}
                                </option>
                              @endforeach
                            </select>

                            @php
                              $hidden_class = "hidden";
                              $nombre_unid = "a";
                              if($organizacion->codUnidadProductivaEnlazadaCITE){
                                $hidden_class = "";
                                $nombre = $organizacion->getUnidadProductivaEnlazada()->getDenominacion();
                              }

                            @endphp
                            

                            <button id="boton_ir_unidadproductiva" type="button" class="ml-1 btn btn-primary {{$hidden_class}}" title="Ir a la Unidad Productiva enlazada {{$nombre}}" onclick="clickIrAUnidadEnlazada()">
                              <i class="fas fa-eye"></i>
                            </button>
                            
                            

                          </div>

                        </div>


                    </div>


                </div>


            </div>

        </div>
       
    </div>
   


</form>


<div class="card">
  <div class="card-header ui-sortable-handle cursor-move" >
    <div class="d-flex flex-row">
        <div class="">
            <h3 class="card-title">
                <b>Actividades de la Organización</b>
            </h3>
        </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">

      <table class="table table-bordered table-hover datatable fontSize10" id="table-3">
        <thead class="table-marac-header">
            <tr>
              <th>Cod</th>
              <th>Descripcion</th>
              <th>Semestre</th>
              <th class="text-center">
                Lugar
              </th>
              <th>Actividad</th>
              <th>Creado por</th>
              <th>Opciones</th>
            </tr>
        </thead>
        <tbody>

            @foreach($listaActividades as $actividad)
                <tr class="FilaPaddingReducido">
                    <td>
                        {{$actividad->getId()}}
                    </td>
                    <td class="fontSize9">
                        {{$actividad->descripcion}}
                    </td>
                  
                    <td>
                        {{$actividad->getResumenSemestres()}}
                        
                    </td>

                    <td class="text-center">
                        {{$actividad->getTextoLugar()}}
                    </td>
                    
                    <td>
                      [{{$actividad->getActividad()->codigo_presupuestal}}]
                      {{$actividad->getActividad()->descripcion}}
                    </td>
                    
                    <td class="fontSize9">
                      {{$actividad->getEmpleadoCreador()->getNombreCompleto()}}
                      <br>
                      <span class="fontSize7">
                          {{$actividad->getFechaHoraCreacion()}}
                      </span>
                    </td>
                    <td>
                        <a href="{{route('PPM.Actividad.Ver',$actividad->getId())}}" class='btn btn-info btn-sm' title="Ver Unidad Productiva">
                            <i class="fas fa-eye"></i>
                        </a>
 
  

                    </td>


                </tr>

            @endforeach
            @if(count($listaActividades)==0)
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
  <div class="card-header ui-sortable-handle cursor-move" >
    <div class="d-flex flex-row">
        <div class="">
            <h3 class="card-title">
                <b>Integrantes de la Organización</b>
            </h3>
        </div>
    </div>
  </div>
  <div class="card-body">
     
    <div class="table-responsive">

      <table class="table table-bordered table-hover datatable fontSize10" id="table-3">
        <thead  class="table-marac-header">
          <tr>
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
            <th>
                Sexo
            </th>
            <th>
                Fecha Nacimiento
            </th>
            <th>
                Opciones
            </th>
          </tr>
        </thead>
        <tbody>
          @forelse($organizacion->getRelacionesPersonasAsociadas() as $rela_persona_asociada )

            @php
                $persona = $rela_persona_asociada->getPersona();
            @endphp
            <tr>
                <td class="text-right">
                    {{$persona->dni}}
                </td>
                <td class="text-left">
                    <div class="d-flex flex-row">
                        <div>
                            {{$persona->getNombreCompleto()}}
                        </div>
                        <div class="ml-auto">

                          
                        </div>
                    </div>
                </td>
                <td class="text-right">
                    {{$persona->telefono}}
                </td>
                <td class="text-right">
                    {{$persona->correo}}
                </td>
                <td>
                    {{$persona->getSexoLabel()}}
                </td>
                <td>
                    {{$persona->getFechaNacimiento()}}
                </td>
                <td class="text-center">
                    <a href="{{route('PPM.Persona.Ver',$persona->getId())}}" class='btn btn-info btn-xs' title="Ver Usuario">
                        <i class="fas fa-eye"></i>
                    </a>
                     
 

                </td>

            </tr>
          @empty

            <tr>
              <td class="text-center" colspan="9">
                  No hay usuarios registrados en este servicio
              </td>
            </tr>
          @endforelse
        
            
          

        </tbody>
      </table>  

    </div>

  </div>

</div>



<div class="d-flex flex-row m-4">
  <div class="">

      <a href="{{route('PPM.Organizacion.Listar')}}" class='btn btn-info '>
          <i class="fas fa-arrow-left"></i>
          Regresar al Menú
      </a>

  </div>
  <div class="ml-auto">

    

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
 
  
 

  var tipoPersoneriaSeleccionada = {};
  $(document).ready(function(){
      $(".loader").fadeOut("slow");
      
      actualizarTipoDocumento({{$organizacion->codTipoDocumento}});

       
      /* Para darle tiempo al navegador que renderice el Select2 de bootstrap */
      setTimeout(() => {

         
        
        $(".loader").fadeOut("slow");
      
      }, 100);

  });
 
 
 



</script>
@include('PPM.Organizacion.OrganizacionReusableJS')


@endsection
