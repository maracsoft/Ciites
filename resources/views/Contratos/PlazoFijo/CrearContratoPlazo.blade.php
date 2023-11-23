@extends('Layout.Plantilla')

@section('titulo')
  Contrato Plazo Fijo
@endsection

@section('contenido')
  <div class="p-2">
    <div class="page-title">
      Crear Contrato Plazo Fijo
    </div>
  </div>

  <form method = "POST" action = "{{ route('ContratosPlazo.Guardar') }}" onsubmit="" id="frmPlazoFijo" name="frmPlazoFijo">


    @csrf


    <div class="card">
      <div class="card-header">
        Datos del contratado:
      </div>
      <div class="card-body">
        <div class="row">

          <div class="col-12 col-md-3">

            <div class="label_movil_container">
              <input type="number" class="form-control" name="dni" id="dni" value="" placeholder="">
              <label for="dni" class="label_movil">dni</label>
            </div>

          </div>

          <div class="col-12 col-md-3">
            <div class="label_movil_container">
              <input type="text" class="form-control" name="nombres" id="nombres" value=""  placeholder="">
              <label for="nombres" class="label_movil">nombres</label>
            </div>
          </div>


          <div class="col-12 col-md-3">
            <div class="label_movil_container">
              <input type="text" class="form-control" name="apellidos" id="apellidos" value=""  placeholder="">
              <label for="apellidos" class="label_movil">apellidos</label>
            </div>
          </div>
          <div class="col-12 col-md-3">
            <div class="label_movil_container">
              <select class="form-control" name="sexo" id="sexo">
                <option value="-1">- Seleccionar - </option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
              <label for="sexo" class="label_movil">sexo</label>
            </div>
          </div>


          <div class="col-12 col-md-4">
            <div class="label_movil_container">
              <input type="text" class="form-control" name="direccion" id="direccion" value=""  placeholder="">
              <label for="direccion" class="label_movil">direccion</label>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="label_movil_container">
              <input type="text" class="form-control " name="provinciaYDepartamento" id="provinciaYDepartamento" value="a" placeholder="">
              <label for="provinciaYDepartamento" class="label_movil">Provincia y Departamento</label>
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

          <div class="col-12">
            <div class="label_movil_container">
              <input type="text" class="form-control" name="nombrePuesto" id="nombrePuesto" placeholder="">
              <label for="nombrePuesto" class="label_movil">Puesto</label>
            </div>

          </div>

          <div class="col-12 col-md-3">
            <div class="label_movil_container">
              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                <input type="text" class="form-control text-center" autocomplete="off" name="fechaInicio" id="fechaInicio" placeholder="">
                <label for="fechaInicio" class="label_movil">Fecha Inicio</label>
                <div class="input-group-btn">
                  <button class="btn btn-primary date-set d-none" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>

            </div>


          </div>
          <div class="col-12 col-md-3">
            <div class="label_movil_container">
              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                <input type="text" class="form-control text-center" autocomplete="off" name="fechaFin" id="fechaFin" placeholder="">
                <label for="fechaFin" class="label_movil">Fecha Fin</label>
                <div class="input-group-btn">
                  <button class="btn btn-primary date-set d-none" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-3">
            <div class="label_movil_container">
              <input type="number" min="0" class="form-control" name="sueldoBruto" id="sueldoBruto" value="" placeholder="">
              <label for="sueldoBruto" class="label_movil">Sueldo</label>
            </div>
          </div>





          <div class="col-12 col-md-3">
            <div class="label_movil_container">
              <select class="form-control" name="codMoneda" id="codMoneda">
                <option value="-1">- Moneda - </option>
                @foreach ($listaMonedas as $moneda)
                  <option value="{{ $moneda->codMoneda }}">
                    {{ $moneda->nombre }}
                  </option>
                @endforeach
              </select>
              <label for="codMoneda" class="label_movil">Moneda</label>
            </div>

          </div>

          <div class="col-12 col-md-3">
            <div class="label_movil_container">


              <select class="form-control" name="codSede" id="codSede">
                <option value="-1">- Sede - </option>
                @foreach ($listaSedes as $sede)
                  <option value="{{ $sede->codSede }}">
                    {{ $sede->nombre }}
                  </option>
                @endforeach
              </select>
              <label for="codSede" class="label_movil">Sede</label>
            </div>

          </div>
          <div class="col-12 col-md-3">
            <div class="label_movil_container">
              <input type="text" class="form-control" name="nombreProyecto" id="nombreProyecto" placeholder="">
              <label for="codSede" class="label_movil">Sede</label>
            </div>

          </div>

          <div class="col-12 col-md-3">
            <div class="label_movil_container">
              <input type="text" class="form-control" name="nombreFinanciera" id="nombreFinanciera" placeholder="">
              <label for="nombreFinanciera" class="label_movil">Financiera</label>
            </div>
          </div>



        </div>
      </div>
    </div>









    <div class="row m-3">
      <div class="col text-left">

        <a href="{{ route('ContratosPlazo.Listar') }}" class='btn btn-info '>
          <i class="fas fa-arrow-left"></i>
          Regresar al Menu
        </a>

      </div>
      <div class="col text-right">
        <button type="button" class="btn btn-primary" id="btnRegistrar"
          data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" onclick="registrar()">

          <i class='fas fa-save'></i>
          Registrar
        </button>
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

@include('Layout.EstilosPegados')
@include('Layout.ValidatorJS')
@section('script')
  {{-- <script src="/public/select2/bootstrap-select.min.js"></script>      --}}
  <script>
    var cont = 0;
    var total = 0;
    var detalleAvance = [];
    var modo;

    $(document).ready(function() {

    });

    function registrar() {

      msje = validarFormCrear();
      if (msje != "") {
        alerta(msje);
        return false;
      }

      confirmar('¿Estás seguro de crear el contrato?', 'info', 'frmPlazoFijo');

    }

    var listaArchivos = '';

    function validarFormCrear() { //Retorna TRUE si es que todo esta OK y se puede hacer el submit
      msj = '';
      limpiarEstilos(['dni', 'nombres', 'apellidos', 'sexo', 'nombrePuesto', 'fechaInicio', 'direccion',
        'fechaFin', 'sueldoBruto', 'nombreProyecto', 'nombreFinanciera', 'codMoneda', 'codSede', 'codTipoContrato',
        'provinciaYDepartamento'
      ]);

      msj = validarTamañoExacto(msj, 'dni', '8', 'DNI');
      msj = validarTamañoMaximoYNulidad(msj, 'nombres', 100, 'Nombres');
      msj = validarTamañoMaximoYNulidad(msj, 'apellidos', 100, 'Apellidos');
      msj = validarTamañoMaximoYNulidad(msj, 'nombrePuesto', 200, 'Nombre del cargo');

      msj = validarTamañoMaximoYNulidad(msj, 'direccion', 500, 'direccion');
      msj = validarTamañoMaximoYNulidad(msj, 'provinciaYDepartamento', 500, 'Provincia y departamento');
      msj = validarTamañoMaximoYNulidad(msj, 'nombreProyecto', 300, 'Proyecto');
      msj = validarTamañoMaximoYNulidad(msj, 'nombreFinanciera', 300, 'Financiera');

      msj = validarNulidad(msj, 'fechaInicio', 'Fecha de inicio');
      msj = validarNulidad(msj, 'fechaFin', 'Fecha de fin');


      msj = validarPositividadYNulidad(msj, 'sueldoBruto', 'Monto retribución');

      msj = validarSelect(msj, 'sexo', '-1', 'Sexo');

      msj = validarSelect(msj, 'codMoneda', '-1', 'Moneda');
      msj = validarSelect(msj, 'codSede', '-1', 'Sede');
      msj = validarSelect(msj, 'codTipoContrato', '-1', 'Tipo de Contrato');

      return msj;
    }
  </script>
@endsection

@section('estilos')
<style>



</style>
@endsection
