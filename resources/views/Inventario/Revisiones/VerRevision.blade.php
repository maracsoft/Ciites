@extends('Layout.Plantilla')

@section('titulo')
    Ver Revisión
@endsection

@section('contenido')

  <div class="well">
    <H3 style="text-align: center;">
      <strong>
        Revisión de inventario {{$revision->año}}
      </strong>
    </H3>
  </div>
  @include('Layout.MensajeEmergenteDatos')
      
  <div class="card">
    <div class="card-body">

      <div class="row">
        <div class="col">
          <label for="">
            Empleado responsable: 
          </label>
          <br>
          {{$revision->getResponsable()->getNombreCompleto()}}
      </div>
      <div class="col">
        <label for="">
          Fecha inicio: 
        </label>
        <br>
        {{$revision->getFechaHoraInicio()}}
      </div>
      <div class="col">
        <label for="">
          Fecha Cierre: 
        </label>
        <br>
        {{$revision->getFechaHoraCierre()}}
      </div>
      
      <div class="col">
        <label for="">
          Descripción: 
        </label>
        <br>
        {{$revision->descripcion}}
      </div>
      <div class="col">
        <label for="">
          Estado: 
        </label>
        <br>
        <div class="btn   {{$revision->getClaseBotonSegunEstado()}}" onclick="alertaMensaje('Estado de la revisión','{{$revision->getMsjAlerta()}}','info')">
          {{$revision->getNombreEstado()}}
        </div>
      </div>

      </div>
      






    </div>
  </div>


  <div class="card">
      <div class="card-header row">
        <div class="col">
          <h3>
            Lista de revisores
            
            <button type="button" class="btn btn-warning btn-xs" onclick="mostrarMsjExplicacion()">
              <i class="fas fa-question fa-xs"> </i>
            </button>
  
            
          </h3>
        </div>
      </div>
    {{-- -------------------------------------------------------------------------------------  --}}
    <div class="card-body">

      @if($revision->estaAbierta())
        
        <div class="row mb-1 "> {{-- Form añadir revisor --}}
          <div class="col">
            <select class="form-control" id="codRevisorNuevo" name="codRevisorNuevo">
                <option value="-1" selected>- Seleccione Empleado -</option>          
                @foreach($empleados as $itemempleado)
                    <option value="{{ $itemempleado->codEmpleado }}" >
                      {{ $itemempleado->getNombreCompleto()}}
                    </option>                                 
                @endforeach            
            </select>
          </div>
          <div class="col">
            <select class="form-control" id="codSede" name="codSede" onchange="">
              <option value="-1" selected>- Seleccione Sede -</option>          
              @foreach($sedes as $sede)
                  <option value="{{ $sede->codSede}}" >{{ $sede->nombre}}</option>                                 
              @endforeach            
            </select>
          </div>
          <div class="col">
            <button class="btn btn-primary" onclick="clickAñadirRevisor()">
              <i class="fas fa-plus"></i>
              Añadir
            </button>
          </div>

        </div>
      @endif
        

      <div id="contenedorRevisores">


      </div>

      


    </div>
  </div>


  <div class="card">
    <div class="card-header">
      <h4>
        Lista de Activos:
        @if($revision->estaAbierta())
        <button type="button" onclick="regenerarActivos()" class="btn btn-primary btn-xs" alt="Regenerar activos">
          <i class="fas fa-redo-alt"></i>
        </button>
        @endif

      </h4>

    </div>

    <div class="card-body">


      
      <table class="table table-sm table-bordered table-hover datatable" id="table-3">
        <thead>                  
          <tr>
            <th class="text-center">CodActivo</th>
            <th class="text-center">QR</th>
            <th>Nombre</th>
            <th>Características</th>
            <th>Categoría</th>
            <th>Placa</th>
            <th>Estado</th>
            
          </tr>
        </thead>
        <tbody>

          @foreach($listaDetalles as $detalle)
            @php
              $activo = $detalle->getActivo();
            @endphp  
            <tr>
                <td class="text-center">
                  {{$activo->codigoAparente}}
                  {{-- 
                  <button type="button" onclick="probarFuncionQR('{{$activo->codigoAparente}}')" >
                    probarQR
                  </button>
                    --}}
                   
                </td>

                <td class="text-center p-3">
                    {{QrCode::generate($activo->codigoAparente)}}
                </td>
                <td>
                  {{$activo->nombre}}
                </td>
                <td>
                  {{$activo->caracteristicas}}
                </td>
                <td>
                  {{$activo->getCategoria()->nombre}}
                </td>
                <td>
                  {{$activo->placa}}
                </td>
                <td>
                  @if($revision->estaAbierta())
                    <select class="form-control" id="codEstado" name="codEstado" onchange="cambiarEstadoActivoEnRevision({{$detalle->codDetalleRevision}},this)">
                       
                      @foreach($estadosActivo as $estado)
                          <option value="{{$estado->codEstado}}"
                              @if($estado->codEstado == $detalle->codEstado)
                                  selected
                              @endif
                              
                              >
                              {{$estado->nombre}}
                          </option>
                      @endforeach
                  </select>
                  @else 
                    {{$activo->getEstado()->nombre}}
                  @endif
                </td>
            
              </tr>
          @endforeach
          
        </tbody>
      </table>



    </div>

  </div>



  <div class="row m-2">
    <div class="col">
      <a class="btn btn-primary" href="{{route('RevisionInventario.Listar')}}">
        <i class="fas fa-backward"></i>
        Volver al menú
      </a>
    </div>
   
    <div class="col text-right">
      @if($revision->estaAbierta())
      
     
        <button type="button" onclick="clickCerrarRevision()"  class="btn btn-danger">
          Cerrar revisión
        </button>
      @endif
    </div>
  </div>
@endsection

@section('script')
  @include('Layout.ValidatorJS')

  <script>
    
      $(document).ready(function(){
          recargarRevisores();
      });



      function recargarRevisores(){
        invocarHtmlEnID(
            "{{route('RevisionInventario.ObtenerHTMLRevisores',$revision->codRevision)}}",
            'contenedorRevisores'
            )
      }

      function clickAñadirRevisor(){
        msj = validarAñadirRevisor();
        if(msj!=""){
          alerta(msj);
          return;
        }

        ejecutarAñadirRevisor();

      }

      function ejecutarAñadirRevisor(){

        
        ruta = "/RevisionesInventario/Revisores/AñadirARevision";
        codEmpleado = document.getElementById('codRevisorNuevo').value;
        codSede = document.getElementById('codSede').value;
       
        datosEnvio = 
        {
            _token: "{{csrf_token()}}",
            codRevision: "{{$revision->codRevision}}",
            codEmpleado :  codEmpleado,
            codSede : codSede
        };

        $.get(ruta,datosEnvio ,function(dataRecibida){
            console.log('DATA RECIBIDA:');
            console.log(dataRecibida);
            
            objetoRespuesta = JSON.parse(dataRecibida);
            alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);
            
            limpiarSelects()
            recargarRevisores();
        });
         
      }

      function validarAñadirRevisor(){
        limpiarEstilos(['codSede','codRevisorNuevo']);
        msj = "";
        msj = validarSelect(msj,'codRevisorNuevo','-1',"Empleado revisor");
        msj = validarSelect(msj,'codSede','-1',"Sede");
        
        return msj;

      }

      
      codEmpleadoRevisorAEliminar = 0;
      function clickQuitarRevisor(codEmpleadoRevisor){
        
        codEmpleadoRevisorAEliminar = codEmpleadoRevisor;
        confirmarConMensaje("Confirmación","¿Desea quitar a esta persona de la revisión? <br> Perderá acceso al sistema de revisiones","warning",ejecutarQuitarRevisor);
      }

      function ejecutarQuitarRevisor(){

        ruta = "/RevisionesInventario/Revisores/QuitarRevisor/" + codEmpleadoRevisorAEliminar;

        $.get(ruta ,function(dataRecibida){
            console.log('DATA RECIBIDA:');
            console.log(dataRecibida);
            
            objetoRespuesta = JSON.parse(dataRecibida);
            alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);
            
            recargarRevisores();
        });


      }
    

      function limpiarSelects(){
        document.getElementById('codRevisorNuevo').value = '-1';
        document.getElementById('codSede').value = '-1';
       
      }

      function mostrarMsjExplicacion(){
        alertaMensaje(
          "Lista de revisores",
          /* html */
          `Estos colaboradores podrán marcar los activos como habidos / no habidos.
          <br>
          Es decir, tendrán acceso a modificar la revisión actual del inventario.
          
          `
          ,"info"
        );

      }

      function cambiarEstadoActivoEnRevision(codDetalleRevision,select){

        codEstado = select.value;

        ruta = "/RevisionesInventario/CambiarEstadoDetalle";

        datosEnvio = 
        {
            _token: "{{csrf_token()}}",
            codDetalleRevision: codDetalleRevision,
            codEstado :  codEstado  
        };


        $.get(ruta,datosEnvio ,function(dataRecibida){
            console.log('DATA RECIBIDA:');
            console.log(dataRecibida);
            
            objetoRespuesta = JSON.parse(dataRecibida);
            alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);
            
            recargarRevisores();
        });



      }



      function clickCerrarRevision(){

        confirmarConMensaje("Cerrar revisión","¿Desea cerrar la revisión del año {{$revision->año}}? <br> Esta acción no se puede deshacer" ,"warning",ejecutarCerrarRevision);
      }
      function ejecutarCerrarRevision(){

        location.href = "{{route('RevisionInventario.Cerrar',$revision->codRevision)}}";

      }



      function regenerarActivos(){
          ruta = '/RevisionesInventario/regenerarActivos/{{$revision->codRevision}}'        
          $.get(ruta ,function(dataRecibida){
            console.log('DATA RECIBIDA:');
            console.log(dataRecibida);
              
            objetoRespuesta = JSON.parse(dataRecibida);
            alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);
            
            recargarRevisores();

            location.reload();

          });


      }


      function probarFuncionQR(codigoAparente){

        ruta = '/api/Revisiones/MarcarComoHabido'        
        datos = {
          codigoAparente: codigoAparente
        };

          $.get(ruta ,datos,function(dataRecibida){
            console.log('DATA RECIBIDA:');
            console.log(dataRecibida);
              
            objetoRespuesta = JSON.parse(dataRecibida);
            alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);
            
            recargarRevisores();

            location.reload();

          });


      }


  </script>

@endsection