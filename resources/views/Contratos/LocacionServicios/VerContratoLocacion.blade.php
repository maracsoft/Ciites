@extends('Layout.Plantilla')

@section('titulo')
Ver {{$contrato->codigo_unico}}
@endsection

@section('contenido')

  <div class="p-2">
    <div class="page-title">
      Ver Contrato Locación Servicios {{$contrato->codigo_unico}}
    </div>
  </div>

  @csrf


  <div class="card">
    <div class="card-header">

      <div class="row">
        <div class="col-12 col-sm-3 font-weight-bold">
          Datos del Locador:
        </div>
        <div class="col-12 col-sm-9">
          <div class="label_movil_container">
            <input type="text" class="form-control"   value="{{$contrato->getTextoTipoPersona()}}" placeholder="" readonly>
            <label    class="label_movil">Tipo Persona</label>
          </div>

        </div>
      </div>
    </div>
    <div class="card-body">

      {{-- Datos del locador --}}
      <div class="">

        <div id="FormPN" @if (!$contrato->esDeNatural()) hidden @endif >
          <div class="row">

            <div class="col-12 col-md-2 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PN_ruc" id="PN_ruc" value="{{$contrato->ruc}}" placeholder="" readonly>
                <label for="PN_ruc" class="label_movil">RUC</label>
              </div>
            </div>

            <div class="col-12 col-md-2 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PN_dni" id="PN_dni" value="{{$contrato->dni}}" placeholder="" readonly>
                <label for="PN_dni" class="label_movil">DNI</label>
              </div>
            </div>



            <div class="col-12 col-md-2 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PN_nombres" id="PN_nombres" value="{{$contrato->nombres}}" readonly placeholder="">
                <label for="PN_nombres" class="label_movil">Nombre</label>
              </div>
            </div>


            <div class="col-12 col-md-2 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PN_apellidos" id="PN_apellidos" value="{{$contrato->apellidos}}" readonly placeholder="">
                <label for="PN_apellidos" class="label_movil">Apellidos</label>
              </div>
            </div>
            <div class="col-12 col-md-2 p-1">

              <div class="label_movil_container">
                <input type="text" class="form-control" value="{{$contrato->getSexoLabel()}}" readonly placeholder="">
                <label class="label_movil">Sexo</label>
              </div>


            </div>


            <div class="col-12 col-md-3 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PN_direccion" id="PN_direccion" value="{{$contrato->direccion}}" readonly
                  placeholder="">
                <label for="PN_direccion" class="label_movil">Domicilio fiscal</label>
              </div>
            </div>


            <div class="col-12 col-md-3 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PN_distrito" id="PN_distrito" value="{{$contrato->distrito}}" placeholder="" readonly>
                <label for="PN_distrito" class="label_movil">Distrito</label>
              </div>
            </div>

            <div class="col-12 col-md-3 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PN_provincia" id="PN_provincia" value="{{$contrato->provincia}}" placeholder="" readonly>
                <label for="PN_provincia" class="label_movil">Provincia</label>
              </div>

            </div>

            <div class="col-12 col-md-3 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PN_departamento" id="PN_departamento" value="{{$contrato->departamento}}" placeholder="" readonly>
                <label for="PN_departamento" class="label_movil">Departamento</label>
              </div>

            </div>

          </div>


        </div>



        <div id="FormPJ" @if ($contrato->esDeNatural()) hidden @endif >
          <div class="row">
            <div class="col-12">
              <label for="">
                Datos de la persona jurídica:
              </label>
            </div>

          </div>
          <div class="row">


            <div class="col-12 col-md-2 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PJ_ruc" id="PJ_ruc" value="{{$contrato->ruc}}" readonly
                  placeholder="">
                <label for="PJ_ruc" class="label_movil">RUC</label>
              </div>
            </div>


            <div class="col-12 col-md-6 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PJ_razonSocialPJ" id="PJ_razonSocialPJ" value="{{$contrato->razonSocialPJ}}" readonly placeholder="">
                <label for="PJ_razonSocialPJ" class="label_movil">Razón Social</label>
              </div>
            </div>



            <div class="col-12 col-md-4 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PJ_direccion" id="PJ_direccion" value="{{$contrato->direccion}}" readonly
                  placeholder="">
                <label for="PJ_direccion" class="label_movil">Domicilio fiscal</label>
              </div>
            </div>


            <div class="col-12 col-md-3 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PJ_distrito" id="PJ_distrito" value="{{$contrato->distrito}}" readonly placeholder="">
                <label for="PJ_distrito" class="label_movil">Distrito</label>
              </div>
            </div>

            <div class="col-12 col-md-3 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PJ_provincia" id="PJ_provincia" value="{{$contrato->provincia}}" readonly placeholder="">
                <label for="PJ_provincia" class="label_movil">Provincia</label>
              </div>

            </div>

            <div class="col-12 col-md-3 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PJ_departamento" id="PJ_departamento" value="{{$contrato->departamento}}" readonly placeholder="">
                <label for="PJ_departamento" class="label_movil">Departamento</label>
              </div>

            </div>

          </div>
          <div class="row">
            <div class="col-12">
              <label for="">
                Datos del representante:
              </label>
            </div>
          </div>
          <div class="row">


            <div class="col-12 col-md-3 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PJ_dni" id="PJ_dni" value="{{$contrato->dni}}" placeholder="" readonly>
                <label for="PJ_dni" class="label_movil">DNI</label>
              </div>
            </div>



            <div class="col-12 col-md-3 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PJ_nombres" id="PJ_nombres" value="{{$contrato->nombres}}" placeholder="" readonly>
                <label for="PJ_nombres" class="label_movil">Nombres</label>
              </div>

            </div>


            <div class="col-12 col-md-3 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PJ_apellidos" id="PJ_apellidos" value="{{$contrato->apellidos}}" placeholder="" readonly>
                <label for="PJ_apellidos" class="label_movil">Apellidos</label>
              </div>
            </div>







            <div class="col-12 col-md-3 p-1">
              <div class="label_movil_container">
                <input type="text" class="form-control" name="PJ_nombreDelCargoPJ" id="PJ_nombreDelCargoPJ" value="{{$contrato->nombreDelCargoPJ}}" placeholder="" readonly>
                <label for="PJ_nombreDelCargoPJ" class="label_movil">Cargo en la empresa</label>
              </div>
            </div>


          </div>
        </div>

      </div>




    </div>
  </div>



  <div class="card">
    <div class="card-header font-weight-bold">

      Datos del Contrato
    </div>
    <div class="card-body">
      {{-- DATOS DEL CONTRATO --}}

      <div class="row">

        <div class="col-12 col-md-4 p-1">
          <div class="label_movil_container">
            <textarea class="form-control" name="motivoContrato" id="motivoContrato" placeholder="" readonly>{{$contrato->motivoContrato}}</textarea>
            <label for="motivoContrato" class="label_movil">Objetivo del contrato</label>
          </div>
        </div>
        <div class="col-12 col-md-4 p-1">
          <div class="label_movil_container">
            <input type="text" class="form-control" readonly value="{{$contrato->retribucionTotal}}" placeholder="">
            <label for="retribucionTotal" class="label_movil">Monto de honorario</label>
          </div>
        </div>

        <div class="col-12 col-md-4 p-1">
          <div class="label_movil_container">
            <input type="text" class="form-control" readonly value="{{$contrato->getMoneda()->nombre}}" placeholder="">
            <label for="retribucionTotal" class="label_movil">Moneda</label>
          </div>


        </div>
        <div class="w-100"></div>


        <div class="col-12 col-md-4 p-1">
          <div class="label_movil_container">
            <input type="text" class="form-control text-center" readonly value="{{$contrato->getFechaInicio()}}" placeholder="">
            <label class="label_movil">Fecha Inicio</label>
          </div>

        </div>
        <div class="col-12 col-md-4 p-1">
          <div class="label_movil_container">
            <input type="text" class="form-control text-center" readonly value="{{$contrato->getFechaFin()}}" placeholder="">
            <label class="label_movil">Fecha Inicio</label>
          </div>


        </div>





        <div class="col-12 col-md-4 p-1">
          <div class="label_movil_container">
            <input type="text" class="form-control" readonly value="{{$contrato->getSede()->nombre}}" placeholder="">
            <label for="retribucionTotal" class="label_movil">Sede</label>
          </div>


        </div>

        <div class="w-100"></div>
        <div class="col-12 col-md-4 p-1">

          <div class="label_movil_container">
            <input type="text" class="form-control"  placeholder="" readonly value="{{$contrato->nombreProyecto}}">
            <label class="label_movil">Proyecto</label>
          </div>

        </div>
        <div class="col-12 col-md-4 p-1">

          <div class="label_movil_container">
            <input type="text" class="form-control"  readonly value="{{$contrato->nombreFinanciera}}"
              placeholder="">
            <label class="label_movil">Entidad Financiera</label>
          </div>

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
        <table id="detalles" class="table-sm table table-striped table-bordered table-condensed table-hover"
          style='background-color:#FFFFFF;'>
          <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
            <th class="text-center">Fecha Entrega</th>
            <th> Descripción del producto entregable</th>
            <th class="text-center">Monto</th>
            <th class="text-center">Porcentaje</th>
          </thead>
          <tbody>
            @foreach ($contrato->getAvances() as $avance)
              <tr>
                <td class="text-center">
                  {{ $avance->getFechaEntrega() }}
                </td>
                <td>
                  {{ $avance->descripcion }}
                </td>
                <td class="text-right">
                  {{ number_format($avance->monto, 2) }}
                </td>
                <td class="text-right">
                  {{ $avance->porcentaje }} %
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

      <a href="{{ route('ContratosLocacion.Listar') }}" class='btn btn-info '>
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
