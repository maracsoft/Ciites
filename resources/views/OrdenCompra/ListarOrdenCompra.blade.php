@extends ('Layout.Plantilla')
@section('titulo')
  Listar Ordenes de Compra
@endsection
@section('contenido')
<style>

.col{
  margin-top: 15px;

  }

.colLabel{
  width: 13%;
  margin-top: 18px;


}

.letraRuc{
  color:rgb(80, 83, 233)
}

</style>



<div style="text-align: center">
  <h2> Listar Ordenes de Compra </h2>



  <br>
    <form  >
        <div class="row text-left">

            <div class="">
                <a href="{{route('OrdenCompra.Empleado.Crear')}}" class = "btn btn-primary m-2" style="">
                <i class="fas fa-plus"> </i>
                    Registrar nueva Orden
                </a>
            </div>


        </div>


        <label for="">
            Filtros de búsqueda:
        </label>
        <div class="row">



            <select class="col m-1 form-control select2"  id="codEmpleadoBuscar" name="codEmpleadoBuscar">
                <option value="-1">- Seleccione Colaborador emisor -</option>
                @foreach($listaEmpleados as $itemempleado)
                <option value="{{$itemempleado->codEmpleado}}" {{$itemempleado->codEmpleado==$codEmpleadoBuscar ? 'selected':''}}>
                    {{$itemempleado->getNombreCompleto()}}
                    </option>
                @endforeach
            </select>

            <input type="text" class="col  m-1 form-control" id="buscarPorCodigo" name="buscarPorCodigo"
                    placeholder="Código de orden" value="{{$buscarPorCodigo}}">

            <input type="text" class="col m-1 form-control" id="buscarPorRuc" name="buscarPorRuc"
                    placeholder="RUC" value="{{$buscarPorRuc}}">





            <div class="col  m-1 input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker"  >
                <input type="text"  class="form-control" name="fechaInicio" id="fechaInicio" style="text-align: center"
                    value="{{$fechaInicio==null ? Carbon\Carbon::now()->format('d/m/Y') : $fechaInicio}}" style="text-align:center;font-size: 10pt;">
                <div class="input-group-btn">
                    <button class="btn btn-primary date-set" type="button">
                    <i class="fa fa-calendar"></i>
                    </button>
                </div>
            </div>

            <div class="col m-1 input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker" >
                <input type="text"  class="form-control" name="fechaFin" id="fechaFin" style="text-align: center"
                    value="{{$fechaFin==null ? Carbon\Carbon::now()->format('d/m/Y') : $fechaFin}}" style="text-align:center;font-size: 10pt;">
                <div class="input-group-btn">
                    <button class="btn btn-primary date-set" type="button">
                    <i class="fa fa-calendar"></i>
                    </button>
                </div>
            </div>


            <button class="col m-1 btn btn-success btn-sm" type="submit">
                <i class="fas fa-search"></i>
                Buscar
            </button>

        </div>

    </form>


    @include('Layout.MensajeEmergenteDatos')
    <div class="table-container">

    <table class="table table-sm" style="font-size: 10pt; margin-top:10px;">
      <thead class="thead-dark">
        <tr>
          <th>Código</th>
          <th style="text-align: center">
            Fecha Creación
          </th>
          <th>
            Emisor
          </th>
          <th>Proyecto</th>
          <th>Proveedor y RUC</th>
          <th>Observación</th>
          <th>Detalles</th>

          <th>Importe Total</th>

          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>

        @foreach($ordenes as $itemorden)
            <tr>
                <td style = "padding: 0.40rem">
                  {{$itemorden->codigoCedepas}}
                </td>

                <td style = "padding: 0.40rem; text-align: center">
                  {{$itemorden->getFechaHoraCreacion()}}
                </td>
                <td style = "padding: 0.40rem; text-align: center">
                  {{$itemorden->getEmpleadoCreador()->getNombreCompleto()}}
                </td>



                <td style = "padding: 0.40rem">
                  [{{$itemorden->getProyecto()->codigoPresupuestal}}] {{$itemorden->getProyecto()->nombre}}
                </td>

                <td style = "padding: 0.40rem">
                  {{$itemorden->señores}}
                  <span class="fontSize9 letraRuc">
                      [{{$itemorden->ruc}}]
                  </span>
                </td>

                <td>
                  {{$itemorden->observacion}}
                </td>

                <td style = "padding: 0.40rem">
                  {{$itemorden->getResumenDetalles()}}
                </td>


                <td style = "padding: 0.40rem">
                  {{$itemorden->getMoneda()->simbolo}} {{number_format($itemorden->total,2)}}
                </td>


                <td>

                  @if($itemorden->sePuedeEditar() && $itemorden->codEmpleadoCreador == App\Empleado::getEmpleadoLogeado()->codEmpleado)
                    <a href="{{route('OrdenCompra.Empleado.Editar',$itemorden->codOrdenCompra)}}"
                      class="btn btn-warning btn-xs" title="Editar Requerimiento">
                      <i class="fas fa-edit"></i>
                    </a>
                  @endif

                  <a href="{{route('OrdenCompra.Empleado.Ver',$itemorden->codOrdenCompra)}}"
                    class="btn btn-info btn-xs" title="Ver Orden Compra">
                    <i class="fas fa-eye"></i>
                  </a>

                  <a href="{{route('OrdenCompra.descargarPDF',$itemorden->codOrdenCompra)}}"
                    class='btn btn-info btn-xs' title="Descargar PDF">
                    <i class="fas fa-file-download"></i>
                  </a>

                  <a target="pdf_ordenCompra_{{$itemorden->codOrdenCompra}}" href="{{route('OrdenCompra.verPDF',$itemorden->codOrdenCompra)}}"
                    class='btn btn-info btn-xs'  title="Ver PDF">
                    <i class="fas fa-file-pdf"></i>
                  </a>

                </td>
            </tr>
        @endforeach
      </tbody>
    </table>
    {{$ordenes->appends(['fechaInicio'=>$fechaInicio,'fechaFin'=>$fechaFin])->links()}}

    </div>

</div>
@endsection
