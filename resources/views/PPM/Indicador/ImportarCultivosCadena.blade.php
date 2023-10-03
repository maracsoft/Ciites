@extends('Layout.Plantilla')

@section('titulo')
  Importar Cultivos/Cadena
@endsection

@section('tiempoEspera')
<div class="loader" id="pantallaCarga"></div>
@endsection

@section('contenido')
@include('Layout.MensajeEmergenteDatos')

@php
  $file_uploader = new App\UI\FileUploader("nombresArchivos","filenames",10,true,"Seleccione archivo");
@endphp

<div class="row">
 

  <div class="col-12 py-2">
    <div class="page-title">
      Importar Cultivos Cadena
    </div>
  </div>

  <div class="col-sm-8">
    <div class="card">
      <div class="card-body">
        <div class="row">


          <div class="col-sm-9">
            <label for="">
              Organización:
            </label>
            <input type="text" class="form-control" value="{{$organizacion->razon_social}}" readonly>
          </div>
          <div class="col-sm-3">
            <label for="">
              RUC:
            </label>
            <input type="text" class="form-control" value="{{$organizacion->ruc}}" readonly>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">

        
          <label for="">
            Semestre:
          </label>
          <input type="text" class="form-control text-center" value="{{$semestre->getTexto()}}" readonly>
 

      </div>
    </div>
  </div>

  
  <div class="col-sm-2"></div>

  <div class="col-sm-8">

    



  </div>

  <div class="col-sm-2"></div>
</div>


<div class="card">
  <div class="card-header ui-sortable-handle cursor-move">
    <div class="d-flex flex-row">
      <div class="">
          <h3 class="card-title">
              <b>Cultivos/Cadena Actuales</b>
          </h3>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-sm-12 text-right">

        <button data-toggle="modal" data-target="#ModalImportacion" type="button" class="btn btn-success">
          <i class="fas fa-file-excel mr-1"></i>
          Importar Datos
        </button>

      </div>
    </div>
    <div id="">

    
      <div class="table-responsive my-2">
              
        <table class="table table-bordered datatable fontSize10" id="tabla_productos">
          <thead class="table-marac-header">
              <tr class="desktop_tr">
                <th class="align-middle text-center" rowspan="1" colspan="4">
                  Datos del Productor
                </th>
                <th class="align-middle text-center" rowspan="2">
                  Cultivo/producto
                </th>
                <th class="align-middle text-center" rowspan="2">
                  Edad del cultivo/producto
                </th>
                
                <th class="align-middle text-center" rowspan="1" colspan="2">
                  Numero de unidades de producción por productor/a
                </th>
                <th class="align-middle text-center"  colspan="2" class="text-center">
                  Producción total por productor
                </th>
                <th class="align-middle" colspan="2">
                  Producción total comercializada
                </th>
                <th class="align-middle" rowspan="2">
                  Precio de venta por unidad en soles
                </th>
                <th class="align-middle" rowspan="2">
                  Costo de producción por unidad en soles
                </th>
                <th class="align-middle" rowspan="2">
                  Ingreso neto obtenido por cada productor/a en junio 2022 (soles)
                </th>
                <th class="align-middle" rowspan="1" colspan="3">
                  Rendimiento promedio de la zona 
                </th>
                <th class="align-middle" rowspan="2">
                  Ingreso neto obtenido por cada productor/a en el semestre (soles)
                </th>
                <th class="align-middle" colspan="2">
                  Rendimiento alcanzado el semestre
                </th>
                
                
                <th class="align-middle" rowspan="2">
                  Opciones
                </th>
                
                
              </tr>
              
              <tr class="desktop_tr">
                <th class="align-middle">
                  DNI
                </th>
                <th class="align-middle"h>
                  Nombres
                </th>
                <th class="align-middle">
                  Ap. Paterno
                </th>
                <th class="align-middle">
                  Ap. Materno
                </th>
                <th class="align-middle">
                  Nro
                </th>
                <th class="align-middle">
                  Unid Medida
                </th>
                <th class="align-middle">
                  Cant
                </th>
                <th class="align-middle">
                  Unid Medida
                </th>
                <th class="align-middle">
                  Cant
                </th>
                <th class="align-middle">
                  Unid Medida
                </th>
                <th class="align-middle">
                  Rendimiento
                </th>
                <th class="align-middle">
                  Unid Medida
                </th>
                <th class="align-middle">
                  Fuente
                </th>
                <th class="align-middle">
                  Rendimiento
                </th>
                
                <th class="align-middle">
                  Unid Medida
                </th>
              </tr>

          </thead>
          <tbody>
            @forelse($listaDetalleProducto as $detalle)
              @php
                $persona = $detalle->getPersona();
              @endphp
              <tr class="fila_responsive mb-5 mb-sm-0">
                
                <td>
                  <label class="aparecer_en_mobile" for="">
                    DNI:
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size" value="{{$persona->dni}}" readonly>
                </td>
                <td class="">
                  <label class="aparecer_en_mobile" for="">
                    Datos del productor - Nombres:
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size" value="{{$persona->nombres}}" readonly>
                </td>
                <td class="">
                  <label class="aparecer_en_mobile" for="">
                    Datos del productor - Apellido Paterno:
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size" value="{{$persona->apellido_paterno}}" readonly>
                </td>
                <td class="">
                  <label class="aparecer_en_mobile" for="">
                    Datos del productor - Apellido Materno:
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size" value="{{$persona->apellido_materno}}" readonly>
                </td>
                <td>
                  <label class="aparecer_en_mobile" for="">
                    Producto:
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size" value="{{$detalle->getProducto()->nombre}}" readonly>
                </td>
                <td>
                  <label class="aparecer_en_mobile" for="">
                    Edad del cultivo/producto:
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size text-right" value="{{$detalle->edad_cultivo}}" readonly>
                </td>
               
                
                
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Número de Unidades de producción por productor/a - Número
                  </label>  
                  <input type="text" class="form-control form-control-sm  text-right" value="{{$detalle->NUPP_numero}}" readonly>
                </td>
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Número de Unidades de producción por productor/a - Unid Medida
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size" value="{{$detalle->getUnidadMedida_NUPP()->nombre}}" readonly >
                  
                </td>
                 
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Producción total por productor - Cantidad
                  </label>
                  <input type="text" class="form-control form-control-sm text-right"  value="{{$detalle->PTP_cantidad}}" readonly>
          
                </td>
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Producción total por productor - Unid Medida
                  </label>
                  <input type="text" class="form-control form-control-sm" value="{{$detalle->getUnidadMedida_PTP()->nombre}}" readonly>
          
                  
                </td>
                <td class="bg_naranja_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Producción total comercializada - Cantidad
                  </label>
                  <input type="text" class="form-control form-control-sm text-right " value="{{$detalle->PTC_cantidad}}"  readonly>
          
                </td>
                <td class="bg_naranja_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Producción total comercializada - Unid Medida
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size" readonly value="{{$detalle->getUnidadMedida_PTC()->nombre}}">
          
                </td>
                <td>
                  <label class="aparecer_en_mobile" for="">
                    P. Venta x Unid (Soles)
                  </label>
                  <input type="text" class="form-control form-control-sm text-right" placeholder="Precio de Venta" value="{{number_format($detalle->pventa_unidad,2)}}"   readonly>
          
                </td>
                <td>
                  <label class="aparecer_en_mobile" for="">
                    Costo de producción Unitario (Soles)
                  </label>
                  <input type="text" class="form-control form-control-sm text-right" placeholder="Costo de prod" value="{{number_format($detalle->costo_prod_unidad,2)}}" readonly>
          
                </td>
                <td>
                  <label class="aparecer_en_mobile" for="">
                    Ingreso Neto JUN-22
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_size text-right" placeholder="Ingreso de la org en JUN22" value="{{number_format($detalle->ingreso_neto22,2)}}" readonly>
                </td>
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Rendimiento Promedio de la Zona
                  </label>
                  <input type="text" class="form-control form-control-sm text-right" placeholder="Rendimiento" value="{{$detalle->RZ_rendimiento}}"  readonly>
                </td>
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Rendimiento Promedio de la Zona - Unid Medida:
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_2size "  value="{{$detalle->RZ_unidad_medida}}" readonly> 
          
                </td>
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Rendimiento Promedio de la Zona - Fuente:
                  </label>
                  <input type="text" class="form-control form-control-sm unidad_medida_2size text-right" placeholder="Fuente" value="{{$detalle->RZ_fuente}}" readonly>
                </td>
                <td>
                  <label class="aparecer_en_mobile" for="">
                    Ingreso de la org en este semestre
                  </label>
                  <input type="text" class="form-control form-control-sm text-right " placeholder="Ingreso en este semestre" value="{{number_format($detalle->ingreso_semestre,2)}}" readonly>
                </td>
                <td class="bg_celeste_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Rendimiento
                  </label>
                  <input type="text" class="form-control form-control-sm text-right" placeholder="Rendimiento" value="{{$detalle->RS_rendimiento}}" readonly>
                </td>
                <td class="bg_celeste_mobile_mobile">
                  <label class="aparecer_en_mobile" for="">
                    Unid Medida
                  </label>
          
                  <input type="text" class="form-control form-control-sm unidad_medida_2size" placeholder="Rendimiento"  value="{{$detalle->RS_unidad_medida}}" readonly>
                  
                </td>

                
                
                <td>
                  <button data-toggle="modal" data-target="#ModalDetalleProducto" type="button" class="btn btn-sm btn-info" onclick="clickEditarProducto({{$detalle->getId()}})">
                    <i class="fas fa-pen"></i>
                  </button>
                  <button  class="btn btn-danger btn-sm" onclick="clickEliminarDetalleCultivoCadena({{$detalle->getId()}})">
                    <i class="fas fa-trash"></i>
                  </button>

                </td>
              </tr>
            @empty
              <tr>
                <td colspan="19" class="text-center">
                  No hay registros
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>  

      </div>
    

    </div>

    
  </div>
</div>
 

<div class="d-flex">
  <a class="btn btn-info" href="{{route('PPM.SemestreOrganizacion.VerAñadirProductos',$relacion->getId())}}">
    <i class="fas fa-arrow-left mr-1"></i>
    Ir a Añadir Productos
  </a>
</div>







<div class="modal  fade" id="ModalDetalleProducto" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" id="content_modal_productos">
    
    </div>
  </div>
</div>


<div class="modal  fade" id="ModalImportacion" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">


      <div class="modal-header">
        <h5 class="modal-title" id="">
          <b>Importar cultivos/cadena</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        


        <form action="{{route('PPM.SemestreOrganizacion.ImportarArchivo')}}" method="POST" name="formImportar" enctype="multipart/form-data">
          <input type="hidden" name="codRelacion" value="{{$relacion->codRelacion}}">
          @csrf

          
          <div class="row">
           
            <div class="col-sm-4">
              <label for="codTipoProducto" id="" class="">
                  Tipo Producto:
              </label>
              <input type="text" class="form-control" value="Cultivo/Cadena" readonly>
            </div>
            <div class="col-sm-4">

              <label for="">
                Producto:
              </label>
              <select class="form-control" name="codProductoSeleccionado" id="codProductoSeleccionado">
                <option value="">
                  - Producto -
                </option>
                @foreach($listaProductos as $prod)
                  <option value="{{$prod->getId()}}" {{$prod->isThisSelected($codProductoSeleccionado)}}>
                    {{$prod->nombre}}
                  </option>
                @endforeach
    
              </select>


            </div>
            <div class="col-sm-4">
              <label for="edad_cultivoproducto" id="" class="">
                  Edad del cultivo/producto:
              </label>
              <input type="number" class="form-control" id="edad_cultivo" name="edad_cultivo" placeholder="Edad del cultivo/producto:" value="">
              
            </div>

            
            
          </div>

          <div class="row mt-3">
            <div class="col-sm-6">
              <div>
                {{$file_uploader->render()}}
              </div>

              
            </div>
            <div class="col-sm-6 text-right">
              
            </div>
            
          </div>
          
           
           
        </form>
      
      </div>
      <div class="modal-footer">
        <a class="btn-sm btn btn-primary" href="/estaticos/PlantillaImportacionCultivos.xlsx">
          <i class="fas fa-file-download mr-1"></i>
          Descargar Plantilla de importación
        </a>

        <button onclick="clickImportar()" type="button" class="ml-auto btn btn-success">
          <i class="fas fa-save mr-1"></i>
          Importar
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Salir
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
 
 
@include('Layout.ValidatorJS')
@section('script') 
<script>


  const MostrarMensajeConfirmacion = @if (session('mostrar_confirmacion')) true @else false @endif

  const AbrirModalAlIniciar = @if (session('abrir_modal_inicial')) true @else false @endif
    

  @php
    session(['mostrar_confirmacion' => null]);
    session(['abrir_modal_inicial' => null]);
    
  @endphp


  const ListaTipoProducto = @json($listaTipoProducto);

  const codTipoProducto_Producto = {{$codTipoProducto_Producto}};
  const codTipoProducto_CultivoCadena = {{$codTipoProducto_CultivoCadena}};

  var ModalImportacion = new bootstrap.Modal(document.getElementById("ModalImportacion"), {});
  


  $(document).ready(function(){
    
    if(AbrirModalAlIniciar){
        ModalImportacion.show();
    }else{
      if(MostrarMensajeConfirmacion){
        confirmarConMensajeYCancelar("¿Desea seguir importando cultivos/cadena?","Aún puede seguir importando excel's","info",function(){
        
          ModalImportacion.show();
        },function(){
          
        })
      }
    }
  

    $(".loader").fadeOut("slow");
  });

  

  function clickImportar(){
    var msj = validarFormImportar();
    if(msj){
      alerta(msj);
      return;
    }

    document.formImportar.submit();
  }

  const FileSelect = document.getElementsByName("filenames[]")[0]
  function validarFormImportar(){
    var msj = "";
    limpiarEstilos(["codProductoSeleccionado","edad_cultivo"]);
     
    msj = validarSelect(msj,"codProductoSeleccionado","","Producto");
    msj = validarNulidad(msj,"edad_cultivo","Edad del cultivo");
    
    if(FileSelect.files.length == 0){
      msj = "Debe seleccionar un archivo para ser importado";
    }else{
      var first_file = FileSelect.files[0];
      var nombre_archivo = first_file.name;

      if(!nombre_archivo.includes(".xlsx")){
        msj = "El archivo debe ser del formato .xlsx Por favor use la plantilla descargable"
      }
    }

    return msj;

  }
   
 

</script>

{{-- MODAL DE EDITAR PRODUCTO --}}
<script>

  const ListaUnidadesMedida = @json($listaUnidadesMedida);

  async function clickEditarProducto(codDetalleProducto){

    var ruta = "/PPM/SemestreOrganizacion/InvModalDetalleProducto/" + codDetalleProducto;
    
    $(".loader").show();
    await Async_InvocarHtmlEnID(ruta,'content_modal_productos')

    $(".loader").hide();
  }


  function onChangeNUPP_Modal(nuevo_codUnidadMedida){
    
    updateRS_unidad();
    
  }

  function onChangePTP_Modal(nuevo_codUnidadMedida){
    
    var unidad = ListaUnidadesMedida.find(e => e.codUnidadMedida == nuevo_codUnidadMedida);
    if(unidad){
      const LabelPTC_unidad = document.getElementById("PTC_codUnidadMedida");
      LabelPTC_unidad.value = unidad.nombre;
    }else{
      console.log("updatePTC_unidadMedida Unidad no encontrada, " + nuevo_codUnidadMedida);
    }
    updateRS_unidad();


  }


  function updateRS_unidad(){
    const NUPP_Unidad = document.getElementById("NUPP_codUnidadMedida");
    const PTP_Unidad = document.getElementById("PTP_codUnidadMedida");
    const RZ_Unidad = document.getElementById("RZ_unidad_medida");
    const RS_Unidad = document.getElementById("RS_unidad_medida");
    
    var unidad_nupp = ListaUnidadesMedida.find(e => e.codUnidadMedida == NUPP_Unidad.value);
    var unidad_ptp = ListaUnidadesMedida.find(e => e.codUnidadMedida == PTP_Unidad.value);



    RZ_Unidad.value = unidad_ptp.nombre + "/" +unidad_nupp.nombre
    RS_Unidad.value = RZ_Unidad.value;

  }

  function clickModalDetalle(){
    var msj = validarFormModal();
    console.log("msj",msj)
    if(msj != ""){
      alerta(msj);
      return;
    }

    document.form_modal_detalle.submit();

  }
  function validarFormModal(){

    limpiarEstilos([
      'ingreso_neto22',
      'NUPP_numero',      
      'PTP_cantidad',
      'PTC_cantidad',
      'pventa_unidad',
      'costo_prod_unidad',
      'RZ_rendimiento',
      'RZ_unidad_medida',
      'RZ_fuente',
      'ingreso_semestre',
      'RS_rendimiento',
      'RS_unidad_medida',
      
      'PTP_codUnidadMedida',
      'NUPP_codUnidadMedida',
      'PTC_codUnidadMedida',
      'codProducto',
      'edad_cultivo_modal',
    ])
   
    var msj = "";

    msj = validarSelect(msj,'PTP_codUnidadMedida',"","Unidad de Medida");
    msj = validarSelect(msj,'NUPP_codUnidadMedida',"","Unidad de Medida");
    msj = validarSelect(msj,'PTC_codUnidadMedida',"","Unidad de Medida");
    msj = validarSelect(msj,'codProducto',"","Producto");
 
    
    msj = validarNumero(msj,'edad_cultivo_modal',"Edad del cultivo");
    msj = validarNumero(msj,'ingreso_neto22',"Ingreso neto");
    msj = validarNumero(msj,'NUPP_numero',"Número");
    msj = validarNumero(msj,'PTP_cantidad',"Cantidad");
    msj = validarNumero(msj,'PTC_cantidad',"Cantidad");
    msj = validarNumero(msj,'pventa_unidad',"Precio de venta");
    msj = validarNumero(msj,'costo_prod_unidad',"Costo de producción unitario");
    msj = validarNumero(msj,'RZ_rendimiento',"Rendimiento");

    msj = validarNumero(msj,'ingreso_semestre',"Ingreso en el semestre actual");
    msj = validarNumero(msj,'RS_rendimiento',"Rendimiento en el semestre");
    
    msj = validarNulidad(msj,'RS_unidad_medida',"Unidad de medida del semestre");
    msj = validarNulidad(msj,'RZ_unidad_medida',"Unidad de medida");
    msj = validarNulidad(msj,'RZ_fuente',"Fuente");

    return msj;

  }

  function actualizarIngresoNetoSemestreModal(){
 
    const Input_PTC_cantidad = document.getElementById("PTC_cantidad");
    const Input_pventa_unidad = document.getElementById("pventa_unidad");
    const Input_costo_prod_unidad = document.getElementById("costo_prod_unidad");
    const InputIngresoSemestre = document.getElementById("ingreso_semestre");

    var cantidad = parseFloat(Input_PTC_cantidad.value);
    var precio_venta = parseFloat(Input_pventa_unidad.value);
    var costo_produccion = parseFloat(Input_costo_prod_unidad.value);

    var ingreso = cantidad*(precio_venta-costo_produccion);

    InputIngresoSemestre.value = ingreso.toFixed(2);

  }

  function clickEliminarDetalleCultivoCadena(codDetalleProducto){

    confirmarConMensaje("Confirmación","¿Desea eliminar el registro cultivo/cadena?",'warning',function(){
      location.href = "/PPM/SemestreOrganizacion/EliminarDetalleProducto/" + codDetalleProducto
    })

  }
  


</script>

@endsection
 
@section('estilos')
<style>
  .cb_cosecha{
    width: 23px;
    height: 23px;
  }

  

  .unidad_medida_size{
    min-width: 130px;
  }
  .unidad_medida_2size{
    min-width: 160px;
  }
  
  .input_producto{
    min-width:160px;
  }

  #tabla_productos th{
      padding: 10px 10px;
  }
    

  @media(max-width:500px){ /* MOBILE */
    #tabla_productos thead .desktop_tr{
      display:none;
    }
    .fila_responsive{
      display: grid;
    }

    #tabla_productos td{
      padding: 7px 15px;
    }

    .aparecer_en_mobile{
      display: block;
    }

    .bg_celeste_mobile{
      background-color: rgb(143 236 243);
    }
    .bg_naranja_mobile{
      background-color: rgb(255 207 179)
    }

    .bg_new_color{
      background-color:#ebffe7;
    }

  }

  @media(min-width:500px){ /* DESKTOP */
    #tabla_productos thead .desktop_tr{
      display:table-row;
    }

    #tabla_productos td{
      padding: 0px;
    }
   
    .aparecer_en_mobile{
      display: none;
    }

    .bg_new_color{
      background-color:#ebffe7;
    }
  }

  

  
  
    .aviso_fondo{
      padding: 5 10px;
      border-radius: 2px;
      color: #939393;
      margin-left: auto;
    }
 
    .form-control-sm{
      padding: 4px;
    }

    
    .agrupador_modal{
      border-width: 1px;
      border-style: solid;
      background-color: #e9e9e9;
      border-color: #b5b5b5;
      border-radius: 5px;
      
      padding-bottom: 10px;
      margin-bottom: 5px;
      margin-top: 5px;
 
    }

     

    .agrupador_modal .title_seccion{
      font-size: 14pt;
      background-color: #9b9bc5;
      color: white;
    }

    .agrupador_modal .row{
      margin-right: 0px;
      margin-left: 0px;
    }

</style>
@endsection