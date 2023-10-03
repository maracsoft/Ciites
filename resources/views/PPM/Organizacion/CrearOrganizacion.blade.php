@extends('Layout.Plantilla')

@section('titulo')
  PPM - Registrar Organización
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')

<div class="col-12 py-2">
  <div class="page-title">
    Crear Organización
  </div>
</div>
@include('Layout.MensajeEmergenteDatos')
<form method="POST" action="{{route('PPM.Organizacion.Guardar')}}" id="frmOrganizacion" name="frmOrganizacion"  enctype="multipart/form-data">
 
    @csrf

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
                          <select class="form-control"  id="codTipoDocumento" name="codTipoDocumento" onchange="actualizarTipoDocumento(this.value)">
                            @foreach($listaTipoDocumento as $tipo_documento)
                                <option value="{{$tipo_documento->getId()}}">
                                    {{$tipo_documento->nombre}}
                                </option>
                            @endforeach

                          </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="codTipoOrganizacion" class="">
                                Tipo de organización:
                            </label>
                            <select class="form-control" id="codTipoOrganizacion" name="codTipoOrganizacion">
                              <option value="-1">-- Tipo Organización --</option>
                              @foreach($listaTipoOrganizacion as $tipo)
                                  <option value="{{$tipo->getId()}}">
                                      {{$tipo->nombre}}
                                  </option>

                              @endforeach

                            </select>
                        </div>
                      



                     
                        <div class="col-sm-6">

                            <input class="cursor-pointer" type="checkbox" value="1" id="tiene_act_economica" name="tiene_act_economica" checked onclick="actualizarTieneActividadEconomica(this.checked)">
                            <label class="cursor-pointer" for="tiene_act_economica">
                                Tiene Actividad:
                            </label>

                            <div class="d-flex flex-row">

                              <select class="form-control" id="codActividadEconomica" name="codActividadEconomica">
                                <option value="-1">- Actividad -</option>
                                @foreach($listaActividadEconomica as $act)
                                    <option value="{{$act->getId()}}">
                                        {{$act->nombre}}
                                    </option>
                                @endforeach
                              </select>

                              <input class="form-control hidden" type="text" placeholder="Escriba nueva actividad" id="input_nueva_actividad" name="input_nueva_actividad">
                              <input type="" class="hidden" id="input_nueva_actividad_boolean" name="input_nueva_actividad_boolean" value="0">
                              <button id="boton_actividad" type="button" class="btn btn-success ml-1" onclick="toggleActividadButton()" title="Añadir nueva actividad">
                                <i id="icono_actividad" class="fas fa-plus"></i>
                              </button>
 
                            </div>
                        </div>
                       


                        <div class="col-12 row " >


                            <div class="col-sm-4" id="divRUC">
                                <div class="d-flex ">
                                  <label for="">RUC:
                                    <b id="contadorRUC" style="color: rgba(0, 0, 0, 0.548)"></b>
                                  </label>

                                  <div class="ml-auto form-check fontSize10 pr-4">
                                    <input class="form-check-input cursor-pointer" type="checkbox" value="1" id="documento_en_tramite" name="documento_en_tramite" onclick="actualizarDocumentoTramite(this)">
                                    <label class="form-check-label cursor-pointer" for="documento_en_tramite">
                                        RUC En trámite
                                    </label>
                                  </div>

                                </div>
                               

                                <div class="d-flex flex-col">

                                  <input type="number" class="form-control" placeholder="RUC" name="ruc" id="ruc" value="">

                                  <div class="d-flex mr-auto">
                                      <button type="button" title="Buscar por RUC en la base de datos de Sunat" class="btn-sm btn btn-info d-flex align-items-center" id="botonBuscarPorRUC" onclick="consultarPorRuc()" >
                                          <i class="fas fa-search mr-1"></i>
                                      </button>

                                  </div>
                              </div>
                            </div>
                         
                            <div  class="col-sm-4">
                                <label for="razon_social">Razón Social</label>
                                <input type="text" class="form-control" placeholder="Razón Social" name="razon_social" id="razon_social" value="">
                            </div>   


                        </div>
 
                        
                       


                        <div class="col-sm-12">
                            <label for="" id="">Dirección:</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" value="" placeholder="Dirección">
                        </div> 



                        {{App\ComponentRenderizer::LugarSelector('ComboBoxDistrito',-1)}}
                        <div class="col-sm-6" title="Activando esta opción, al editar los miembros de esta organización, se editarán también en la unidad productiva enlazada del CITE">
                           
                          
                          <div class="d-flex flex-row mt-1">
                            <input class="cursor-pointer" type="checkbox" value="1" id="activar_enlace_cite" name="activar_enlace_cite" onclick="actualizarTieneEnlaceCite(this.checked)">
                          
                            <label class="ml-1 mb-0 cursor-pointer" for="activar_enlace_cite">
                              Activar enlace CITE:
                            </label>
                            <div class="ml-auto msj_activarsi">
                              (Activar si la organización ya existe en el CITE)
                            </div>

                          </div>
                          
                          

                          <div class="d-flex flex-row">
                            <select id="codUnidadProductivaEnlazadaCITE" name="codUnidadProductivaEnlazadaCITE" data-select2-id="1" tabindex="-1" onchange="changedUnidadProductivaEnlazada()"
                                class="fondoBlanco form-control select2 select2-hidden-accessible selectpicker"   aria-hidden="true"  data-live-search="true">
                                <option value="-1">
                                  - Unidad Productiva CITE Enlazada -
                                </option>
                                @foreach($listaUnidadesProductivas as $unidad_prod)
                                  
                                  <option value="{{$unidad_prod->getId()}}">
                                    {{$unidad_prod->getDenominacion()}} {{$unidad_prod->getRucODNI()}}
                                  </option>
                                @endforeach
                            </select>

                             

                            <button id="boton_ir_unidadproductiva" type="button" class="ml-1 btn btn-primary" title="Ir a la Unidad Productiva enlazada " onclick="clickIrAUnidadEnlazada()">
                              <i class="fas fa-eye"></i>
                            </button>


                          </div>

                          

                        </div>
                    </div>


                </div>


            </div>

        </div>
        <div class="card-footer">

          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando"
              onclick="registrar()">
              <i class='fas fa-save'></i>
              Guardar
            </button>

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


</form>


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
@section('script')

<script type="application/javascript">
    //se ejecuta cada vez que escogewmos un file
    var codPresupProyecto = -1;

    var ListaUnidadesProductivas = @json($listaUnidadesProductivas); 

    var tipoPersoneriaSeleccionada = {};
    $(document).ready(function(){
        
        actualizarTipoDocumento(1);

        actualizarTieneActividadEconomica(true);  

        /* Para darle tiempo al navegador que renderice el Select2 de bootstrap */
        setTimeout(() => {
          actualizarTieneEnlaceCite(false);
          $(".loader").fadeOut("slow");
        
        }, 500);
      
    });

    function registrar(){
        msje = validarForm();
        if(msje!="")
            {
                alerta(msje);
                return false;
            }

        confirmar('¿Está seguro de registrar la Organización?','info','frmOrganizacion');

    }





</script>
  
@include('PPM.Organizacion.OrganizacionReusableJS')

@endsection
