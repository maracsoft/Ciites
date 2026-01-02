@extends('Layout.Plantilla')

@section('titulo')
  @if ($reposicion->verificarEstado('Abonada'))
    Contabilizar
  @else
    Ver
  @endif
  Reposición
@endsection

@section('contenido')
  @include('Layout.EstilosPegados')

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <div class="text-center">
    <p class="h1" style="text-align:center">
      @if ($reposicion->verificarEstado('Abonada'))
        Contabilizar
      @else
        Ver
      @endif

      Reposición de Gastos
    </p>



  </div>



  <form method = "POST" action = "{{ route('ReposicionGastos.Empleado.store') }}" onsubmit="return validarTextos()" enctype="multipart/form-data">

    {{-- CODIGO DEL EMPLEADO --}}
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="codEmpleado" id="codEmpleado" value="{{ $reposicion->codEmpleadoSolicitante }}">
    <input type="hidden" name="codReposicionGastos" id="codReposicionGastos" value="{{ $reposicion->codReposicionGastos }}">

    @csrf


    <div class="container">
      <div class="row">
        <div class="col-md"> {{-- COLUMNA IZQUIERDA 1 --}}
          <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

            <div class="row">
              <div class="colLabel">
                <label for="fecha">Fecha</label>
              </div>
              <div class="col">

                <input type="text" class="form-control" name="fechaHoy" id="fechaHoy" disabled
                  value="{{ $reposicion->getFechaHoraEmision() }}">

              </div>

              <div class="col">
                <button type="button" class="btn btn-primary btn-sm fontSize8" style="" data-toggle="modal"
                  data-target="#ModalHistorial">
                  Ver Historial
                </button>
              </div>

              <div class="w-100"></div> {{-- SALTO LINEA --}}
              <div class="colLabel">
                <label for="ComboBoxProyecto">Proyecto</label>

              </div>
              <div class="col"> {{-- input de proyecto --}}
                <input type="text" class="form-control" name="codProyecto" id="codProyecto"
                  value="{{ $reposicion->getProyecto()->nombre }}" disabled>
              </div>

              <div class="w-100"></div> {{-- SALTO LINEA --}}
              <div class="colLabel">
                <label for="fecha">Moneda</label>

              </div>

              <div class="col">
                <input type="text" class="form-control" name="codMoneda" id="codMoneda" value="{{ $reposicion->getMoneda()->nombre }}"
                  disabled>
              </div>


              <div class="w-100"></div> {{-- SALTO LINEA --}}
              <div class="colLabel">
                <label for="fecha">Banco</label>

              </div>

              <div class="col">
                <input type="text" class="form-control" name="codBanco" id="codBanco" value="{{ $reposicion->getBanco()->nombreBanco }}"
                  disabled>
              </div>



              <div class="w-100"></div> {{-- SALTO LINEA --}}
              <div class="colLabel">
                <label for="fecha">Código Cedepas</label>

              </div>

              <div class="col">
                <input type="text" class="form-control" name="" id="" value="{{ $reposicion->codigoCedepas }}" disabled>
              </div>
            </div>
          </div>
        </div>


        <div class="col-md"> {{-- COLUMNA DERECHA --}}
          <div class="container">
            <div class="row">
              <div class="col">
                <label for="fecha">Resumen de la actividad</label>
                <textarea class="form-control" name="resumen" id="resumen" aria-label="With textarea" style="height:50px;" disabled>{{ $reposicion->resumen }}</textarea>

              </div>
            </div>

            <div class="container row"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}
              <div class="colLabel2">
                <label for="fecha">CuentaBancaria</label>

              </div>
              <div class="col">
                <input type="text" class="form-control" name="numeroCuentaBanco" id="numeroCuentaBanco"
                  value="{{ $reposicion->numeroCuentaBanco }}" readonly>
              </div>

              <div class="w-100"></div> {{-- SALTO LINEA --}}
              <div class="colLabel2">
                <label for="fecha">Girar a Orden de </label>

              </div>
              <div class="col">
                <input type="text" class="form-control" name="girarAOrdenDe" id="girarAOrdenDe" value="{{ $reposicion->girarAOrdenDe }}"
                  readonly>
              </div>


              <div class="w-100"></div> {{-- SALTO LINEA --}}
              <div class="colLabel2">
                <label for="fecha">Cod Contrapartida </label>

              </div>
              <div class="col">
                <input type="text" class="form-control" name="codigoContrapartida" id="codigoContrapartida"
                  value="{{ $reposicion->codigoContrapartida }}" readonly>
              </div>



              <div class="w-100"></div>
              <div class="colLabel2">
                <label for="">Estado:</label>
              </div>

              <div class="col">
                <input type="text" value="{{ $reposicion->getNombreEstado() }}" class="form-control" readonly
                  style="background-color: {{ $reposicion->getColorEstado() }};
                                    width:95%;
                                    color: {{ $reposicion->getColorLetrasEstado() }} ;
                            ">
              </div>





            </div>

          </div>



        </div>
      </div>
    </div>
    <br>

    <div class="table-responsive">
      <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'>

        <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
          <th width="11%" class="text-center">Fecha Cbte</th>
          <th width="14%">Tipo</th>
          <th width="11%"> N° Cbte</th>
          <th width="26%" class="text-center">Concepto </th>

          <th width="11%" class="text-center">Importe </th>
          <th width="11%" class="text-center">Cod Presup </th>
          <th>
            <div>
              Contabilizar
            </div>
            @if (!$reposicion->verificarEstado('Contabilizada'))
              <div class="marcar_todos">
                <label for="checkBoxMarcarTodos" class="fontSize8 mb-0 cursor-pointer mr-1">
                  Marcar todos
                </label>
                <input id="checkBoxMarcarTodos" type="checkbox" onclick="togleMarcarTodos()">
              </div>
            @endif

          </th>
        </thead>
        <tfoot>


        </tfoot>
        <tbody>

          @foreach ($detalles as $itemdetalle)
            <tr>
              <td>{{ $itemdetalle->fechaComprobante }}</td>
              <td>{{ $itemdetalle->getNombreTipoCDP() }}</td>
              <td>{{ $itemdetalle->nroComprobante }}</td>
              <td>{{ $itemdetalle->concepto }}</td>

              <td style="text-align: right">{{ number_format($itemdetalle->importe, 2) }}</td>

              <td style="text-align: center"> {{ $itemdetalle->codigoPresupuestal }}</td>
              <td style="text-align:center;">
                <input id="checkBoxContabilizarItem{{ $itemdetalle->codDetalleReposicion }}" type="checkbox" readonly
                  @if ($reposicion->verificarEstado('Contabilizada')) {{-- Ya está contabilizada --}}
                                @if ($itemdetalle->contabilizado == '1')
                                    checked @endif
                onclick="return false;" @else {{-- Caso normal cuando se está contabilizando --}} onclick="contabilizarItem({{ $itemdetalle->codDetalleReposicion }})"
                  @endif

                >
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>



    <input type="{{ App\Utils\Configuracion::getInputTextOHidden() }}" id="listaContabilizados" name = "listaContabilizados"
      value="">

    <div class="row" id="divTotal" name="divTotal">
      <div class="col-12 col-md-6">
        @include('ReposicionGastos.DesplegableDescargarArchivosRepo')

      </div>
      <div class="col-12 col-md-2">

        <a href="{{ route('ReposicionGastos.exportarPDF', $reposicion->codReposicionGastos) }}" class="btn btn-warning btn-sm m-1"
          style="">
          <i class="entypo-pencil"></i>
          Descargar PDF
        </a>
        <a target="blank" href="{{ route('ReposicionGastos.verPDF', $reposicion->codReposicionGastos) }}"
          class="btn btn-warning btn-sm m-1">
          <i class="entypo-pencil"></i>
          Ver PDF
        </a>



      </div>
      {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
      <input type="hidden" name="cantElementos" id="cantElementos">
      <input type="hidden" name="codigoCedepas" id="codigoCedepas">
      <input type="hidden" name="totalRendido" id="totalRendido">

      <div class="col-12 col-md-4">
        <div class="row">

          <div class="col">
            <label for="">Total Gastado: </label>
          </div>
          <div class="col">

            <input type="text" class="form-control text-right" name="total" id="total" readonly
              value="{{ $reposicion->getMoneda()->simbolo }} {{ number_format($reposicion->totalImporte, 2) }}">

          </div>
        </div>
      </div>

    </div>

    <div class="row my-1">
      @if ($reposicion->listaParaContabilizar())
        <div class="col">
          <button id="botonContabilizar" type="button" onclick="guardarContabilizar()" class='btn btn-success' style="float:right;">
            <i class="fas fa-check"></i>
            Guardar como Contabilizado
          </button>
        </div>
      @endif
    </div>

    <div class="row p-3">
      <a href="{{ route('ReposicionGastos.Contador.Listar') }}" class='btn btn-info'>
        <i class="fas fa-arrow-left"></i>
        Regresar al Menú
      </a>
    </div>



  </form>

  @php
    $listaOperaciones = $reposicion->getListaOperaciones();
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

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<style>
  .marcar_todos {

    display: flex;
    align-items: center;
    justify-content: center
  }

  .cursor-pointer {
    cursor: pointer !important;
  }

  .marcar_todos label:hover {
    color: white
  }

  .marcar_todos label {
    color: black
  }

  .hovered:hover {
    background-color: rgb(97, 170, 170);

  }

  input[type='checkbox'] {
    /* -webkit-appearance:none; */
    width: 25px;
    height: 25px;
    background: white;
    border-radius: 15px;
    border: 2px solid #555;
  }

  input[type='checkbox']:checked {
    background: #abd;
  }
</style>

@section('script')
  {{-- PARA EL FILE  --}}
  <script type="application/javascript">
        @if (App\Utils\Configuracion::enProduccion())
            document.getElementById('listaContabilizados').type = "hidden"
        @endif


        var itemsExistentes =  @php echo $detalles @endphp


        var listaItems = [];//para contabilizar
        function contabilizarItem(item){

            if( listaItems.indexOf(item)==-1  )
            { //no lo tiene
                listaItems.push(item);
            }
            else
            { //ya lo tiene, lo quitamos
                let pos = listaItems.indexOf(item);
                listaItems.splice(pos,1);

            }
            document.getElementById('checkBoxMarcarTodos').checked = verificarSiTodosEstanMarcados();

            $('#listaContabilizados').val(listaItems);

        }


        function verificarSiTodosEstanMarcados(){

          for (let index = 0; index < itemsExistentes.length; index++) {
            const element = itemsExistentes[index];
            var i = listaItems.findIndex( e => e == element.codDetalleReposicion )

            if(i == -1){
              return false;
            }
          }
          return true;
        }

        function togleMarcarTodos(){
          var todosMarcados = verificarSiTodosEstanMarcados();

          if(todosMarcados){
            desmarcarTodos();
          }else{
            marcarTodos();
          }

          document.getElementById('checkBoxMarcarTodos').checked = verificarSiTodosEstanMarcados();

        }

        function marcarTodos(){
          listaItems = [];
          itemsExistentes.forEach(element => {
            document.getElementById('checkBoxContabilizarItem' + element.codDetalleReposicion).checked = true;
            listaItems.push(element.codDetalleReposicion);

          })

          $('#listaContabilizados').val(listaItems);
        }
        function desmarcarTodos(){
          listaItems = [];
          itemsExistentes.forEach(element => {
            document.getElementById('checkBoxContabilizarItem' + element.codDetalleReposicion).checked = false;

          })

          $('#listaContabilizados').val(listaItems);

        }

        function guardarContabilizar() {
            codReposicion = {{$reposicion->codReposicionGastos}};

            msjExtra = "";
            if(listaItems.length==0){
                alerta('No ha marcado ningún Item... ');
                msjExtra = "No ha marcado ningún Item... ";
                return false;
            }
            confirmarConMensaje('¿Seguro de contabilizar la reposicion?','','warning',ejecutarContabilizar);
        }
        function ejecutarContabilizar() {
            codReposicion = {{$reposicion->codReposicionGastos}};
            location.href = '/ReposicionGastos/'+ codReposicion +'*' +listaItems+'/Contabilizar';
        }




    </script>
@endsection
