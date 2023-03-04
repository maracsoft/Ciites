@extends('layout.plantilla') 
@section('contenido')


<link rel="stylesheet" href="/select2/bootstrap-select.min.css">


<div class="container">
    <form method="POST" action="{{ route('RevisionInventario.Guardar')}}" id="frmRevision" name="frmRevision">
        @csrf
        <h1>
            Nueva revisión de inventario
        </h1>
    
        <div class="col-6">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Responsable</label>
                <select class="col-sm-6 form-control select2 select2-hidden-accessible selectpicker" data-select2-id="1" tabindex="-1" aria-hidden="true" id="codEmpleadoResponsable" name="codEmpleadoResponsable" data-live-search="true" onchange="">
                    <option value="0" selected>- Seleccione Empleado -</option>          
                    @foreach($empleados as $itemempleado)
                        <option value="{{ $itemempleado->codEmpleado }}" >{{ $itemempleado->apellidos}}, {{ $itemempleado->nombres}}</option>                                 
                    @endforeach            
                </select>    
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Descripcion:</label>
                <div class="col-sm-6">
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Año:</label>
                <div class="col-sm-6">
                    <input type="number" min="2000" max="2200" class="form-control" id="año" name="año" value="{{$añoActual}}">
                </div>
            </div>
            
        
        </div>
        <div>
            <a href="{{route('RevisionInventario.Listar')}}" class="btn btn-danger">
                <i class="fas fa-ban"></i>
                Regresar
        
            </a>
            <button type="button" class="btn btn-primary"  onclick="clickGuardar()">
                <i class="fas fa-save"></i>
                Registrar
            </button>
        </div>
        
    </form>

</div>
    
    

    <script src="/select2/bootstrap-select.min.js"></script> 
@endsection

@section('script')
@include('Layout.ValidatorJS')

<script type="text/javascript">
    function clickGuardar() {
        msj = validarForm();
        if(msj!=""){
            alerta(msj);
            return;
        }

        document.frmRevision.submit();
    }     

    function validarForm(){
        msj = "";

        msj = validarSelect(msj,'codEmpleadoResponsable','-1','Empleado responsable');
        msj = validarNulidad(msj,'descripcion','Descripción de la revisión');
        msj = validarPositividadYNulidad(msj,'año','Año');
        return msj;

    }
    </script>
@endsection