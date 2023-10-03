@extends('Layout.Plantilla')

@section('titulo')
  Ver Persona
@endsection



@section('contenido')

<div class="col-12 py-2">
  <div class="page-title">
    Ver Persona
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

        <div class="row">
                            
          <div class="col-sm-4">
              
              <label for="">DNI:</label>
              
              <div class="d-flex">
                  
                  <input type="number" class="form-control" id="dni" name="dni" placeholder="DNI" value="{{$persona->dni}}" readonly>
                    
               
              
              </div>
          </div>
      
          <div class="col-sm-4">
              <label for="">Teléfono:</label>
              <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" value="{{$persona->telefono}}" readonly>

              
          </div>
          <div class="col-sm-4">
              <label for="">Correo:</label>
              <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo" value="{{$persona->correo}}" readonly>

          </div>
          <div class="col-sm-4">
              <label for="">Nombres:</label>
              <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" value="{{$persona->nombres}}" readonly>
          
          </div>
          <div class="col-sm-4">

              <label for="">Apellido Paterno:</label>
              <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" placeholder="Apellido Paterno" value="{{$persona->apellido_paterno}}" readonly>
          

          </div>
          <div class="col-sm-4">
              
              <label for="">Apellido Materno:</label>
              <input type="text"  class="form-control" id="apellido_materno" name="apellido_materno" placeholder="Apellido Materno" value="{{$persona->apellido_materno}}" readonly>

          </div>

            
            

          <div class="col-sm-4">
            <label for="">Fecha Nacimiento:</label>
            <input type="text" class="form-control" value="{{$persona->getFechaNacimiento()}}" readonly>
            
            
          </div>
                            
          <div class="col-sm-4">
              
            <label for="">Sexo:</label>
            <input type="text" class="form-control" value="{{$persona->getSexoLabel()}}" readonly>
            
            
            
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
              <th>
                Semestre
              </th>
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
                      <a href="{{route('PPM.Organizacion.Ver',$organizacion->getId())}}" class='btn btn-info btn-xs mr-1' title="Ver Unidad Productiva">
                          <i class="fas fa-eye"></i>
                      </a>
                      
                  </td>
              </tr>
          @empty
              <tr>
                <td colspan="9" class="text-center">
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
 

  

</script>
  
  
@endsection