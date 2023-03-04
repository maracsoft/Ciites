@extends('Layout.Plantilla')

@section('titulo')
    Grupo revision
@endsection

@section('contenido')


<div class="card-body">
      
    <div class="well">
        <H3 style="text-align: center;">
          <strong>
            Actualizar estado de activos
          </strong>
        </H3>
    </div>
    <div>
        <div class="row">
            <div class="col">
                <input placeholder="Código" class="form-control" type="text">
            </div>
            <div class="col">
                <button class="btn btn-info btn-sm">
                    <i class="fas fa-camera"></i>
                </button>
            </div>
            
           
            <div class="col text-right">
                <button class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Añadir
                </button>
            </div>
        </div>
      
        
    </div>
      
        <div class="mt-2 row fondoPlomoCircular">
            Cod: E1265AJ
            <br>
            Nombre: 
                Moto Lineal A52-251
                <br>
            Estado Anterior:
                Disponible
                <br>
            Nuevo Estado:
                <select class="form-control form-control-sm" name="" id="">
                    <option value="">
                        Deteriorado
                    </option>
                </select>
        </div>
        
        <div class="mt-2 row fondoPlomoCircular">
            Cod: AJT825J
            <br>
            Nombre: 
                Congeladora Industrial KK623
                <br>
            Estado Anterior:
                Disponible
                <br>
            Nuevo Estado:
                <select class="form-control form-control-sm" name="" id="">
                    <option value="">
                        Deteriorado
                    </option>
                </select>
        </div>
        
            
         
        <div class="mt-2 row fondoPlomoCircular">
            Cod: E1265AJ
            <br>
            Nombre: 
                Moto Lineal A52-251
                <br>
            Estado Anterior:
                Disponible
                <br>
            Nuevo Estado:
                <select class="form-control form-control-sm" name="" id="">
                    <option value="">
                        Deteriorado
                    </option>
                </select>
        </div>
        
        <div class="mt-2 row fondoPlomoCircular">
            Cod: AJT825J
            <br>
            Nombre: 
                Congeladora Industrial KK623
                <br>
            Estado Anterior:
                Disponible
                <br>
            Nuevo Estado:
                <select class="form-control form-control-sm" name="" id="">
                    <option value="">
                        Deteriorado
                    </option>
                </select>
        </div>
       
    
     
</div>

<button class="btn btn-primary">
    <i class="fas fa-save"></i>
    Guardar
</button>

@endsection
