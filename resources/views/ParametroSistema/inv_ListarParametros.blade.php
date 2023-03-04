

<table class="table table-sm table-hover d-none d-lg-table">
    <thead>
        <tr>
            <th>
                id
            </th>
            <th>
                Nombre
            </th>
            <th>
              Tipo
            </th>
            <th>
                Valor
            </th>
            <th class="" >
                Descripción
            </th>
          

            
            <th>
                Opciones
            </th>
            
        </tr>

    </thead>
    
    <tbody>
        @foreach ($lista as $parametro)
            <tr>

                <td>
                    {{$parametro->getId()}}
                </td>
                <td>
                    {{$parametro->nombre}}
                </td>
                <td>
                  {{$parametro->getTipo()->nombre}}
                </td>
                <td class="parametro_descripcion">
                    {{$parametro->valor}}
                </td>

                <td class="fontSize11 parametro_descripcion"  >
                    {{$parametro->getDescripcionAcortada()}}
                </td>
               
                
               


                <td>
                    <button onclick="clickEditarParametro({{$parametro->getId()}})" class="btn btn-info btn-sm"
                        data-toggle="modal" data-target="#ModalParametro">
                        <i class="fas fa-pen  fa-sm"></i>   
                    </button>
                    <button onclick="clickEliminarParametro({{$parametro->getId()}})" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash  fa-sm"></i>   
                    </button>
                </td>
            </tr>
            
        @endforeach
       

    </tbody>
</table>

<div class="listar-parametros d-lg-none d-block">
  
  @foreach ($lista as $parametro)
  <div class="card">
    <div class="card-body">

      <span class="fontSize16">
        {{$parametro->getId()}}. {{$parametro->nombre}}
      </span>
      
      <div class=" ">
          Valor: 
          <span class="valor px-2">
            {{$parametro->valor}}
          </span>
      </div>

      <span class="fontSize10 parametro_descripcion"  >
         {{$parametro->getDescripcionAcortada()}}
      </span>
     
      
     

      <div class=" p-1 d-flex">
        <div class="ml-auto">
          <button onclick="clickEditarParametro({{$parametro->getId()}})" class="btn btn-info btn-sm"
            data-toggle="modal" data-target="#ModalParametro">
            <i class="fas fa-pen  fa-sm"></i>   
          </button>
          <button onclick="clickEliminarParametro({{$parametro->getId()}})" class="btn btn-danger btn-sm">
              <i class="fas fa-trash  fa-sm"></i>   
          </button>
        </div>
       
      </div>
         
       
    </div>
  </div>
  
@endforeach

</div>

<style>
  .listar-parametros .valor{
    background-color: #dce1f1;
    border-radius: 5px;
  }
  .fontSize16{
    font-size: 16pt;
  }
</style>