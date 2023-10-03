@if($apertura)
  <div class="panel-group card">
    <div class="panel panel-default">
        <a class="titulo" onclick="girarIconoDesplegable{{$r}}()" data-toggle="collapse" href="#collapseArchivos{{$r}}"> 
            <div class="panel-heading card-header" style="">
                <h4 class="panel-title card-title" style="">
                    {{$titulo}}
                </h4>
                <i id="iconoGirador{{$r}}" class="fas fa-plus iconoGirador iconoGiradorRotado" style="float:right"></i>
            </div>
        </a>
        <div id="collapseArchivos{{$r}}" class="panel-collapse collapse card-body p-0 show">


@else

          {{-- AQUÍ VA EL CONTENIDO --}}


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
  
  {{-- Mover esto a una llamada general xd --}}
   
  <script>
      let iconoGirado{{$r}} = true;
      function girarIconoDesplegable{{$r}}(){
        const elemento = document.querySelector('#iconoGirador{{$r}}');
        const baseClass = "fas fa-plus";
  
        if(iconoGirado{{$r}})
          nombreClase = baseClass + ' iconoGirador';
        else
          nombreClase = baseClass + ' iconoGirador iconoGiradorRotado'
        elemento.className = nombreClase;
        iconoGirado{{$r}} = !iconoGirado{{$r}};
      }
  
  </script>
    

@endif
