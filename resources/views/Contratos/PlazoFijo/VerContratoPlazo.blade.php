@extends('Layout.Plantilla')

@section('titulo')
    Contrato Plazo Fijo
@endsection

@section('contenido')
<div class="m-1">
    <h3  style="text-align: center">
        Ver Contrato Plazo Fijo {{$contrato->codigoCedepas}}
    </h3>
</div>



    <div class="card">
        <div class="card-header">
            Datos del contratado:
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-12 col-md-3 p-1">
                    <label for="">
                        DNI
                    </label>
                    <input type="number" class="form-control" name="dni" readonly
                        id="dni" value="{{$contrato->dni}}" placeholder="DNI">

                </div>




                <div class="col-12 col-md-3 p-1">
                    <label for="">
                        Nombres
                    </label>
                    <input type="text" class="form-control" name="nombres" readonly
                    id="nombres" value="{{$contrato->nombres}}" placeholder="Nombres">

                </div>


                <div class="col-12 col-md-3 p-1">
                    <label for="">
                        Apellidos
                    </label>
                    <input type="text" class="form-control" name="apellidos" readonly
                    id="apellidos" value="{{$contrato->apellidos}}" placeholder="Apellidos">

                </div>
                <div class="col-12 col-md-3 p-1">
                    <label for="">
                        Sexo
                    </label>
                    <input type="text" class="form-control" value="{{$contrato->getSexo()}}" readonly>


                </div>



                <div class="w-100"></div>
                <div class="col-12 col-md-4 p-1">
                    <label for="">
                        Dirección
                    </label>
                    <input type="text" class="form-control" name="direccion" readonly
                    id="direccion" value="{{$contrato->direccion}}" placeholder="Domicilio">

                </div>

                <div class="col-12 col-md-4 p-1">
                    <label for="">
                        Provincia y Departamento
                    </label>
                    <input type="text" class="form-control" name="provinciaYDepartamento" readonly
                    id="provinciaYDepartamento" value="{{$contrato->provinciaYDepartamento}}" placeholder="Provincia y Departamento">


                </div>
                {{-- remplazar por checkbox --}}
                <div class="col-12 col-md-4 p-1 text-center">
                    <div class="mt-4 form-check">
                        <input style="" class="form-check-input" type="checkbox" onclick="return false;"
                        @if($contrato->tieneAsignacionFamiliar())
                            checked
                        @endif
                            >
                        <label class="form-check-label" for="">
                            Asignación familiar
                        </label>
                    </div>


                </div>
            </div>
        </div>
    </div>



    <div class="card">
        <div class="card-header">
            Datos del Contrato
        </div>
        <div class="card-body">

            <div class="row">




                <div class="col">
                    <label for="">
                        Cargo
                    </label>
                    <input class="form-control" value="{{$contrato->nombrePuesto}}" readonly>

                </div>

                <div class="w-100"></div>
                <div class="col-12 col-md-3 p-1">
                    <label for="">
                        Fecha de inicio
                    </label>
                    <input class="form-control" value="{{$contrato->getFechaInicio()}}" readonly>

                </div>
                <div class="col-12 col-md-3 p-1">
                    <label for="">
                        Fecha de fin
                    </label>
                    <input class="form-control" value="{{$contrato->getFechaFin()}}" readonly>


                </div>

                <div class="col-12 col-md-3 p-1">
                    <label for="">
                        Sueldo bruto
                    </label>
                    <input type="number" class="form-control" value="{{$contrato->sueldoBruto}}" readonly>
                </div>





                <div class="col-12 col-md-3 p-1">
                    <label for="">
                        Moneda
                    </label>
                    <input type="text" class="form-control" value="{{$contrato->getMoneda()->nombre}}" readonly>



                </div>
                <div class="w-100"></div>
                <div class="col-12 col-md-3 p-1">
                    <label for="">
                        Sede
                    </label>
                    <input type="text" class="form-control"  placeholder="Proyecto" value="{{$contrato->getSede()->nombre}}" readonly>


                </div>
                <div class="col-12 col-md-3 p-1">
                    <label for="">
                        Proyecto
                    </label>
                    <input type="text" class="form-control"  placeholder="Proyecto" value="{{$contrato->nombreProyecto}}" readonly>

                </div>
                <div class="col-12 col-md-3 p-1">
                    <label for="">
                        Financiera
                    </label>
                    <input type="text" class="form-control"  placeholder="Entidad Financiera" value="{{$contrato->nombreFinanciera}}" readonly>

                </div>


            </div>
        </div>
    </div>









    <div class="row m-3">
        <div class="col text-left">

            <a href="{{route('ContratosPlazo.Listar')}}" class='btn btn-info '>
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
