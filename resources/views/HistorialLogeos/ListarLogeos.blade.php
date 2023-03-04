@extends('Layout.Plantilla')

@section('titulo')
    Historial de Logeos
@endsection

@section('contenido')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

<link rel="stylesheet" href="/libs/morris.css">
<script src="/libs/morris.min.js" charset="utf-8"></script>


@php

  
  $comp_filtros = new App\UI\UIFiltros(false,$filtros_usados);
 
  $comp_filtros->añadirFiltro([
    'name'=>'codEmpleado',
    'label'=>'Empleado:',
    'show_label'=>true,
    'placeholder'=>'Buscar por empleado',
    'type'=>'select2',
    'function'=>'equals',
    'options'=>$listaEmpleados,
    'options_label_field'=>'nombreCompleto',
    'options_id_field'=>null,
    'size'=>'sm',
    'max_width'=>'',
  ]);

  $comp_filtros->añadirFiltro([
    'name'=>'fechaHoraLogeo',
    'label'=>'Fecha (rango)',
    'show_label'=>true,
    'placeholder'=>'',
    'type'=>'date_interval',
    'function'=>'between_dates',
    'options'=>[],
    'options_label_field'=>'nombre',
    'options_id_field'=>null,
    'size'=>'sm',
    'max_width'=>'250px',
  ]);

@endphp


<div class="p-2">
    
   
  {{-- GRAFICO --}}
  <div class="card">
    <div class="card-header">
      <h2>
        Gráfico del último mes
      </h2>
      
    </div>
    <div class="card-body">
      <div class="row">
        <div>
          <div class="d-flex flex-row">
            
            <div>
              
                 

              <select class="fondoBlanco form-control select2 select2-hidden-accessible selectpicker" id="codEmpleado" data-select2-id="-1" tabindex="-1" aria-hidden="true" data-live-search="true">
                <option value="">- Colaborador - </option>
                @foreach($listaEmpleados as $empleado)
                <option value="{{$empleado->getId()}}">
                  {{$empleado->getNombreCompleto()}}
                </option>
                @endforeach
              </select>
            </div>
            

            <div class="input-group date form_date mr-1" data-date-format="dd/mm/yyyy" data-provide="datepicker">
              <input type="text" class="form-control form-control-sm w-date" id="fechaInicio" value="{{$grafico_fechaInicio_defecto}}" placeholder="Inicio">
              <div class="input-group-btn d-flex flex-col align-items-center">                                        
                  <button class="btn btn-primary btn-sm date-set" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
              </div>
            </div>
            
            <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
              <input type="text" class="form-control form-control-sm w-date" id="fechaFin" value="{{$grafico_fechaFin_defecto}}" placeholder="Fin">
              <div class="input-group-btn d-flex flex-col align-items-center">                                        
                  <button class="btn btn-primary btn-sm date-set" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
              </div>
            </div>
            <button class="btn btn-success btn-sm m-1" title="Buscar" type="button" onclick="clickGenerarGrafico()">
              <i class="fas fa-search"></i>
            </button>

          
          </div>

        </div>
      </div>
      <div class="row"> 
      
        <div class="col-md">
          <div id="table1"></div>  
        </div>
      </div>
    </div>
  </div>


  <div class="card">
    <div class="card-header">
      <h2>
        Historial de logeos
      </h2>
    </div>
    <div class="card-body">
  
      <div class="row">
        <div class="col-md-12">
            {{$comp_filtros->render()}}
        </div>
      </div>
      
      <div class="row"> {{-- TABLA --}}
    
    
        <div class="col-md">
          <table class="text-center table table-bordered table-hover datatable table-sm fontsize8" style="" id="table-3">
            <thead>                  
              <tr>
                <th class="">Cod</th>
                <th class="">CodEmpleado</th>
                <th class="">Empleado</th>
                <th class="">Rol</th>
                <th class="">Fecha y Hora</th>
                <th class="">IP</th>
                <th>IP Principal</th>
                <th>Actividades</th>
              </tr>
            </thead>
            <tbody>
              @foreach($listaLogeos as $itemLogeo)
              
                  <tr style="">
                      <td class="">
                        {{$itemLogeo->codLogeoHistorial}}
                      </td>
                      <td class="">
                        {{$itemLogeo->getEmpleado()->codEmpleado}}
                      </td>
                      <td class="">
                        {{$itemLogeo->getNombreEmpleado()}}
                      </td>
                      <td class="">
                        {{$itemLogeo->getEmpleado()->getPuestosPorComas()}}
                      </td>
                      <td class="">
                        {{$itemLogeo->getFechaHora()}}
                      </td>
                      <td class="">
                        {{$itemLogeo->ipLogeo}}
                      </td>
                      <td class="">
                        
                      </td>
                      <td>
    
                        @if(count($itemLogeo->getOperacionesDuranteSesion()))
                          
                          <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#ModalOperacionesLogeo"
                            onclick="clickVerOperaciones({{$itemLogeo->codLogeoHistorial}})">
                              <i class="fas fa-eye"></i>
    
                          </button>
    
                        @endif
                      </td>
                  </tr>
              @endforeach
              
            </tbody>
          </table>
          <!--SOLUCION PARA PAGINACION CON FILTROS -->
    
          {{$listaLogeos->appends($filtros_usados_paginacion)->links()}}
    
    
    
        </div>
    
      </div>
    
    </div>
  </div>



  
<style>
  #tablaOperacionesLogeo td,th{
      text-align: center
  }
</style>

{{-- MODAL PARA VER HISTORIAL --}}
<div class="modal fade" id="ModalOperacionesLogeo" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="">Operaciones durante la sesión</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiarModal()"> 
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body" id="bodyModalOperacionesSesion">
               
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="limpiarModal()">
                  Cerrar
              </button>
          </div>
      </div>
  </div>
</div>


</div>
@endsection


@section('script')
@include('Layout.ValidatorJS')
  <script>
    
    const contenedorGrafico = document.getElementById('table1');
    $(document).ready(function(){
      clickGenerarGrafico();

    });
    function clickGenerarGrafico(){
      var fechaInicio = document.getElementById("fechaInicio").value;
      var fechaFin = document.getElementById("fechaFin").value;
      var codEmpleado = document.getElementById("codEmpleado").value;

      

      var request =  {
          method: "POST",
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify({
            fechaInicio,
            fechaFin,
            _token	 	: "{{ csrf_token() }}",
            codEmpleado
          })
      }
 
      maracFetch("/HistorialLogeos/getDataGrafico",request,dibujarGrafico);

    }
    function dibujarGrafico(receivedData){

      console.log("Dibujando gráfico...",receivedData)
      contenedorGrafico.innerHTML = "";
      new Morris.Line({//META - EJECUTADA
          element: 'table1',
          data: receivedData,
          xkey: 'fecha',
          ykeys: ['cantidadLogeos'],
          labels: ['LOGEOS'],
          resize: true,
          lineColors: ['#C14D9F'],
          lineWidth: 1,
          dateFormat: function (x) {
            var date = new Date(x)
            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
   
            var formated = date.toLocaleDateString('es-ES',options);
             
            return formated;


          }
      });


    }
    
    function clickVerOperaciones(codLogeo){
      ruta = "/HistorialLogeos/OperacionesDeSesion/" + codLogeo;
      invocarHtmlEnID(ruta,'bodyModalOperacionesSesion')
    }

    function limpiarModal(){
      document.getElementById('bodyModalOperacionesSesion').innerHtml = "";


    }

  </script>
@endsection