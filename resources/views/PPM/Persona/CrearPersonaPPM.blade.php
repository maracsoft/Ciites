@extends('Layout.Plantilla')

@section('titulo')
  Registrar Persona
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

<div class="col-12 py-2">
  <div class="page-title">
    Registrar Persona
  </div>
</div>
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

   
        <form method = "POST" action = "{{route('PPM.Persona.Guardar')}}" id="frmPersona" name="frmPersona"  enctype="multipart/form-data">
            
            @csrf
            
            

            <div class="row">
                                
              <div class="col-sm-4">
                  
                  <label for="">DNI:</label>
                  
                  <div class="d-flex">
                     
                      <input type="number" class="form-control" id="dni" name="dni" placeholder="DNI" value="">
                       
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
                  <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" value="">

                  
              </div>
              <div class="col-sm-4">
                  <label for="">Correo:</label>
                  <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo" value="">

              </div>
              <div class="col-sm-4">
                  <label for="">Nombres:</label>
                  <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" value="">
              
              </div>
              <div class="col-sm-4">

                  <label for="">Apellido Paterno:</label>
                  <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" placeholder="Apellido Paterno" value="">
              

              </div>
              <div class="col-sm-4">
                  
                  <label for="">Apellido Materno:</label>
                  <input type="text"  class="form-control" id="apellido_materno" name="apellido_materno" placeholder="Apellido Materno" value="">

              </div>

               
                

              <div class="col-sm-4">
                <label for="">Fecha Nacimiento:</label>
                <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                  {{-- INPUT PARA LA FECHA --}}
                  <input type="text" class="form-control text-center" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="dd/mm/yyyy" value=""> 
                  
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
                    <option value="{{$sexo['id']}}">
                      {{$sexo['nombre']}}
                    </option>  
                  @endforeach
                  
                </select>
                
                
              </div>
              <div class="col-sm-8">

                <label for="codOrganizacion" id="" class="">
                  Organización a la que pertenece:
                </label>
                
                <select id="codOrganizacion" name="codOrganizacion" data-select2-id="1" tabindex="-1"  
                    class="fondoBlanco form-control select2 select2-hidden-accessible selectpicker"   aria-hidden="true"  data-live-search="true">
                
                    <option value="-1">-- Seleccione Organización --</option>
                    @foreach($listaOrganizaciones as $organizacion)
                        <option value="{{$organizacion->getId()}}">
                            {{$organizacion->getDenominacion()}} {{$organizacion->getRucODNI()}}
                        </option>
                    @endforeach
                    
                </select>   
              
              </div>    
              <div class="col-sm-4">
                <label for="codOrganizacion" id="" class="">
                  Cargo en la organización:
                </label>
                <input type="text"  class="form-control" id="cargo" name="cargo" placeholder="Cargo en la org" value="">

              
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
 

  $(document).ready(function(){
      $(".loader").fadeOut("slow");
  });

  function registrar(){
      msje = validarFormulario(true);
      if(msje!=""){
          alerta(msje);
          return false;
      }
      
      confirmar('¿Está seguro de crear la persona?','info','frmPersona');
  }


  

</script>
  
@include('PPM.Persona.ReusableJSPersonaPPM')
 
@endsection
 
@section('estilos')
<style>



</style>
@endsection