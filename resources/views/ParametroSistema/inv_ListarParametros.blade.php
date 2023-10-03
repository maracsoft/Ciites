

@foreach($modulos as $nombre_modulo => $parametros)
<div class="listar-parametros ">
  <div class="page-title mb-2">
    {{$nombre_modulo}}
  </div>
  <div class="row">

      @foreach ($parametros as $parametro)
        <div class="col-sm-4">

          <div class="card">
            <div class="card-body">

              <span class="fontSize16">
                {{$parametro->getId()}}. {{$parametro->nombre}}
              </span>

              <div class="d-flex flex-wrap">
                <div class="mx-1">
                  <b>
                    Valor:
                  </b>
                  <input type="text" class="form-control form-control-sm" value="{{$parametro->valor}}" readonly>

                </div>

                <div class="mx-1">
                  <b>
                    Tipo:
                  </b>
                  <input type="text" class="form-control form-control-sm" value="{{$parametro->getTipo()->nombre}}" readonly>

                </div>


                <div class="mx-1">
                  <b>
                    Módulo:
                  </b>
                  <input type="text" class="form-control form-control-sm" value="{{$parametro->modulo}}" readonly>

                </div>


              </div>






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

        </div>
      @endforeach
  </div>
</div>

@endforeach
<style>
.listar-parametros .valor{
  background-color: #dce1f1;
  border-radius: 5px;
}
.fontSize16{
  font-size: 16pt;
}
</style>
