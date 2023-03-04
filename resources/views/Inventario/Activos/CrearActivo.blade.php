@extends('layout.plantilla') 

@section('titulo')
    Crear activo

@endsection

@section('contenido')


 
    <form class="text-center" method="POST" action="{{ route('ActivoInventario.Guardar')}}" id="frmActivo" name="frmActivo">
        @csrf
        <h1>
            REGISTRAR NUEVO ACTIVO
        </h1>
        <div class="row">
            
            <div class="col">
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Sede</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="codSede" name="codSede">
                            <option value="-1">Seleccionar Sede</option>
                            @foreach($listaSedes as $itemsede)
                                <option value="{{$itemsede->codSede}}">{{$itemsede->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-6">
                        <input
                            type="text"
                            class="form-control"
                            id="nombre"
                            name="nombre"
                            placeholder="Ingresar nombre activo"
                        />
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Proyecto:</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="codProyecto" name="codProyecto">
                            <option value="-1">Seleccionar Proyecto</option>
                            @foreach($listaProyectos as $itemproyecto)
                                <option value="{{$itemproyecto->codProyecto}}">{{$itemproyecto->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Responsable:</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="codEmpleadoResponsable" name="codEmpleadoResponsable">
                            <option value="-1">Seleccionar Responsable</option>
                            @foreach($listaEmpleados as $itemempleado)
                                <option value="{{$itemempleado->codEmpleado}}">
                                    {{$itemempleado->apellidos}}, {{$itemempleado->nombres}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Categoria</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="codCategoriaActivo" name="codCategoriaActivo">
                            <option value="-1">Seleccionar Categoría</option>
                            @foreach($listaCategorias as $itemcategoria)
                                <option value="{{$itemcategoria->codCategoriaActivo}}">{{$itemcategoria->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Características</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" id="caracteristicas" name="caracteristicas" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Placa</label>
                    <div class="col-sm-6">
                        <input
                            type="text"
                            class="form-control"
                            id="placa"
                            name="placa"
                            placeholder="Código de placa"
                        />
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="m-5 col text-left">
                <a href="{{route('ActivoInventario.Listar')}}" class="btn btn-primary">
                    <i class="fas fa-backward"></i>
                    Regresar
                </a>
            </div>
           
            <div class="m-5 col text-right" >
                <button type="button" class="btn btn-success"  onclick="clickGuardar()">
                    <i class="fas fa-save"></i>
                    Guardar
                </button>
                

            </div>
            

        </div>
            

           
         
    </form>
 

@endsection

@section('script')
    @include('Layout.ValidatorJS')

    <script type="text/javascript">
        function clickGuardar(){
            msj = validarForm();
            if(msj!=""){
                alerta(msj);
                return;
            }

            document.frmActivo.submit();
        }     


        function validarForm(){
            msj = "";

            msj = validarNulidad(msj,'caracteristicas','Características del activo');
            msj = validarNulidad(msj,'nombre','Nombre del activo');

            msj = validarSelect(msj,'codSede','-1','Sede');
            msj = validarSelect(msj,'codProyecto','-1','Proyecto');
            msj = validarSelect(msj,'codEmpleadoResponsable','-1','Responsable');
            msj = validarSelect(msj,'codCategoriaActivo','-1','Categoría del activo');
            

            return msj;



        }

    </script>
@endsection