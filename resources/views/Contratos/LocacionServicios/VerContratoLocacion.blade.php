@extends('Layout.Plantilla')

@section('titulo')
    Contrato Locación servicios
@endsection

@section('contenido')

{{-- QUITAR LA S DE CLS21-000001
    PONER LOS CEROS EN 4 DIGITOS


    --}}
    <h3 class="text-center">
        Contrato de Locación de Servicios {{$contrato->codigo_unico}}
    </h3>

    @csrf


    <div class="card">

        <div class="card-header">
            <label for="">
                Datos del contratado
            </label>
        </div>
        <div class="card-body">

            <div class="row">

                <div class="col-6 col-md-2">
                    <label for="">
                        DNI
                    </label>
                    <input type="text" class="form-control"
                        value="{{$contrato->dni}}" readonly>

                </div>
                <div class="col-6 col-md-2">
                    <label for="">
                        RUC
                    </label>
                    <input type="text" class="form-control"
                            value="{{$contrato->ruc}}" readonly>

                </div>



                <div class="col-12 col-md-2">
                    <label for="">
                        Nombres
                    </label>
                    <input type="text" class="form-control" readonly value="{{$contrato->nombres}}">

                </div>


                <div class="col-12 col-md-2">
                    <label for="">
                        Apellidos
                    </label>
                    <input type="text" class="form-control" readonly value="{{$contrato->apellidos}}">

                </div>
                <div class="col-12 col-md-2">
                    <label for="">
                        Sexo
                    </label>
                    <input type="text" class="form-control" readonly value="{{$contrato->getSexo()}}">

                </div>
                <div class="col-2"></div>


                <div class="w-100"></div>
                <div class="col-12 col-md-6">
                    <label for="">
                        Domicilio
                    </label>
                    <input type="text" class="form-control" readonly value="{{$contrato->direccion}}">

                </div>

                <div class="col-12 col-md-6">
                    <label for="">
                      Provincia y Departamento
                    </label>
                    <input type="text" class="form-control" readonly value="{{$contrato->provinciaYDepartamento}}">


                </div>

            </div>

        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <label for="">
                Datos del contrato
            </label>

        </div>
        <div class="card-body">
            <div class="row">


                <div class="col">
                    <label for="">
                        Motivo del contrato
                    </label>
                    <textarea class="form-control" readonly
                    >{{$contrato->motivoContrato}}</textarea>

                </div>

                <div class="w-100"></div>


                <div class="col-12 col-md-2 p-1">
                    <label for="">
                        Fecha Inicio
                    </label>
                    <input type="text"  class="form-control text-center" value="{{$contrato->getFechaFin()}}"
                        readonly placeholder="Fecha Inicio">

                </div>
                <div class="col-12 col-md-2 p-1">
                    <label for="">
                        Fecha Fin
                    </label>
                    <input type="text" class="form-control text-center" value="{{$contrato->getFechaFin()}}" readonly>

                </div>

                <div class="col-12 col-md-2 p-1">
                    <label for="">
                        Retribución Total
                    </label>
                    <input type="number" class="form-control text-right" value="{{$contrato->retribucionTotal}}" readonly>

                </div>


                <div class="col-12 col-md-2 p-1">

                    <label for="">
                        Moneda
                    </label>
                    <input type="text" class="form-control" value="{{$contrato->getMoneda()->nombre}}" readonly>
                </div>
                <div class="col-12 col-md-2 p-1">
                    <label for="">
                        Sede
                    </label>
                    <input type="text" class="form-control" value="{{$contrato->getSede()->nombre}}" readonly>
                </div>

            </div>

        </div>
    </div>






    <div class="card">
        <div class="card-header">
            <label for="">
                Productos entregables
            </label>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table id="detalles" class="table-sm table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'>
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th class="text-center">Fecha Entrega</th>
                        <th > Descripción del producto entregable</th>
                        <th class="text-center">Monto</th>
                        <th class="text-center">Porcentaje</th>
                    </thead>
                    <tbody>
                        @foreach ($contrato->getAvances() as $avance)
                            <tr>
                                <td class="text-center">
                                    {{$avance->getFechaEntrega()}}
                                </td>
                                <td>
                                    {{$avance->descripcion}}
                                </td>
                                <td  class="text-right">
                                    {{number_format($avance->monto,2)}}
                                </td>
                                <td  class="text-right">
                                    {{$avance->porcentaje}} %
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <div class="m-2 row  text-center">
        <div class="col text-left">

            <a href="{{route('ContratosLocacion.Listar')}}" class='btn btn-info '>
                <i class="fas fa-arrow-left"></i>
                Regresar al Menu
            </a>

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
