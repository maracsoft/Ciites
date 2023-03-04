@php
    $r = rand(1,9999);
@endphp
<div class="panel-group card">
    <div class="panel panel-default">
        <a id="giradorArchivos" onclick="girarIconoArch{{$r}}()" data-toggle="collapse" href="#collapseArchivos{{$r}}" style="" > 
            <div class="panel-heading card-header" style="">
                <h4 class="panel-title card-title" style="">
                    {{$titulo}}
                </h4>
                <i id="iconoGirador{{$r}}" class="fas fa-plus iconoGirador iconoGiradorRotado" style="float:right"></i>
            </div>
        </a>
        <div id="collapseArchivos{{$r}}" class="panel-collapse collapse card-body p-0">
          <table class="table table-striped table-bordered table-condensed table-hover" 
                style='background-color:#FFFFFF;'>
            <tbody>
              @foreach ($listaArchivos as $itemArchivo)
                <tr>
                    <td style = "padding: 0.50rem" class="d-flex flex-row px-2">
                        <a href="{{$itemArchivo['linkDescarga']}}">
                          <i id="" class="far fa-address-card nav-icon"></i>
                          {{$itemArchivo['nombreAparente']}}
                        </a>

                        @if($mostrarBotonesEliminacion)
                            <a style="color:red" class="ml-auto" href="#" onclick="clickEliminarArchivo('{{$itemArchivo['nombreAparente']}}','{{$itemArchivo['linkEliminar']}}')">
                                <i class="fas fa-trash" title="Eliminar Archivo"></i>
                            </a>
                        @endif

                    </td>
                     
                    
                  
                </tr>
              @endforeach
              @if(count($listaArchivos)==0)
                  <tr>
                    <td class=" px-2 text-center">
                      No hay archivos para mostrar.
                    </td>
                  </tr>
              @endif


            </tbody>
          </table>
  
        </div>
    </div>
  </div>
  
  <style>
    .iconoGirador {
        -moz-transition: all 0.25s ease-out;
        -ms-transition: all 0.25s ease-out;
        -o-transition: all 0.25s ease-out;
        -webkit-transition: all 0.25s ease-out;
    }
  
    .iconoGiradorRotado {
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
    }
  
  </style>
  
  <script>
    let iconoGirado{{$r}} = true;
    function girarIconoArch{{$r}}(){
      const elemento = document.querySelector('#iconoGirador{{$r}}');
      const baseClass = "fas fa-plus";

      if(iconoGirado{{$r}})
        nombreClase = baseClass + ' iconoGirador';
      else
        nombreClase = baseClass + ' iconoGirador iconoGiradorRotado'
      elemento.className = nombreClase;
      iconoGirado{{$r}} = !iconoGirado{{$r}};
    }



    function clickEliminarArchivo(nombre,rutaEliminacion){
        
      confirmarConMensaje("Confirmación","¿Desea eliminar el archivo "+nombre+"?","warning",function(){
        location.href = rutaEliminacion;
      });

    }


     







  </script>
  