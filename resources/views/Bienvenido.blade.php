@extends('Layout.Plantilla')
@section('titulo')
  Flujograma
@endsection

@section('contenido')
  <div class="mx-0 mx-sm-5 my-0 pt-3">

    <div class="row">

      <div class="col-12">
        <div class="bienvenido shadow">
          <div class="titulo">
            Bienvenido al Sistema de Gestión
          </div>

        </div>

      </div>

      <div class="col-12 mt-4">
        <div class="card">
          <div class="card-header font-weight-bold">

            Novedades

          </div>
          <div class="card-body">
            <!-- Updates List -->
            <div class="updates-list">

              @php
                $items = App\Utils\Novedades::getNovedades();
              @endphp
              @foreach ($items as $item)
                <article class="@if ($loop->first && count($items) > 1) pb-3 mb-2 border-bottom @endif">
                  <div class="update-grid @if (!$loop->first) mt-3 @endif">
                    {{--
                    <div class="version-badge text-white mb-2 mb-md-0">
                      {{ $item->version }}
                    </div>
                    --}}
                    <div class="update-content">
                      <h2 class="h5 mb-0">
                        {{ $item->title }}
                      </h2>
                      <p class="text-muted small mb-1">
                        {{ $item->date }}
                      </p>
                      <ul class="list-unstyled mb-0 ml-2">
                        @foreach ($item->changes as $change)
                          <li class="d-flex align-items-start">
                            <div class="feature-icon">•</div>
                            <div class="ml-1">
                              {{ $change }}
                            </div>
                          </li>
                        @endforeach


                      </ul>
                    </div>
                  </div>
                </article>
              @endforeach

            </div>
          </div>

        </div>

      </div>

      <div class="col-12 col-sm-6">
        <div class="card">
          <div class="card-body">
            <img class="imagen_proceso" src="img/InfografiaHome SOF.png">
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6">


        <div class="card">
          <div class="card-body">
            <img class="imagen_proceso" src="img/InfografiaHome REQ.png">
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6">

        <div class="card">
          <div class="card-body">
            <img class="imagen_proceso" src="img/InfografiaHome REN.png">
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6">


        <div class="card">
          <div class="card-body">
            <img class="imagen_proceso" src="img/InfografiaHome REP.png">

          </div>
        </div>
      </div>







    </div>
  </div>
@endsection

@section('script')
  <script>
    var tooltip_micuenta;
    $(document).ready(function() {

    });

    function testTooltip() {

      let config = {
        placement: 'bottom',
        trigger: '',
        title: 'Ahora puede configurar su menú izquierdo en preferencias',
      }

      const boton = document.getElementById('boton_micuenta');
      tooltip_micuenta = new bootstrap.Tooltip(boton, config);


      tooltip_micuenta.show();

      setTimeout(() => {
        // tooltip_micuenta.dispose();
      }, 2000);

      boton.addEventListener('click', function() {
        console.log("ejecuto")
        tooltip_micuenta.hide();
        tooltip_micuenta.dispose();
      });

    }
  </script>
@endsection
@section('estilos')
  <style>
    .bienvenido {
      background-color: #fffefe;
      padding: 30px;
      border-radius: 10px;
    }

    .bienvenido .titulo {
      text-align: center;
      line-height: 30px;
      font-size: 27pt;
      font-weight: bold;
    }




    .version-badge {
      width: fit-content;
      background-color: #0d6efd;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      font-size: 0.875rem;
      font-weight: 500;
    }

    .feature-icon {
      color: #0d6efd;
      font-weight: bold;

    }

    .updates-list .card {
      border: none;
      border-radius: 1rem;
    }

    @media (min-width: 768px) {
      .update-grid {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 1.5rem;
        align-items: start;
      }
    }

    .imagen_proceso {
      width: 100%;
    }
  </style>
@endsection
