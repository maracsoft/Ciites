<!DOCTYPE html>
<html lang="es" translate="no">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> @yield('titulo') </title>


  {{-- Cambiar esto por una url d --}}

  <link rel="shortcut icon" href="/img/isologo.ico" type="image/png">


  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="/css/siderbarstyle.css">
  <link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
  <link rel="stylesheet" href="/select2/bootstrap-select.min.css">

  <link rel="stylesheet" href="/plugins/fontawesome/css/all.min.css">
  <script src="/plugins/fontawesome/js/pro.min.js"></script>

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">




  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  @include('RenderedCss')


  @yield('estilos')

  @php
    $empLogeadoPlantilla = App\Empleado::getEmpleadoLogeado();

  @endphp
</head>

<body class="hold-transition sidebar-mini">
  <!--<div class="loader"></div>-->
  @yield('tiempoEspera')
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">

        <li class="nav-item">
          <a id="aRefOcultarMenuLateral" class="nav-link" data-widget="pushmenu" onclick="clicMenuLateral()" href="#" role="button">
            <i id="iconoOcultarMenuLateral" class="fas fa-chevron-left"></i>
          </a>
        </li>

        <a class="btn btn-primary hidden d-sm-block " title="Volver al Inicio" href="{{ route('user.home') }}">
          Home
        </a>
        @if ($empLogeadoPlantilla->esAdminSistema())
          <a class="btn btn-success ml-1  hidden d-sm-block " href="{{ route('AdminPanel.VerPanel') }}">
            AdminPanel
          </a>
        @endif

      </ul>


      <ul class="navbar-nav ml-auto mr-2" style="">

        @include('Layout.Notificaciones.Solicitudes')
        @include('Layout.Notificaciones.Rendiciones')
        @include('Layout.Notificaciones.Reposiciones')
        @include('Layout.Notificaciones.Requerimientos')


      </ul>





      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu --> {{-- VER CARRITO RAPIDAMENTE --}}
        @include('Layout.Notificaciones.Usuario')
      </ul>









    </nav>
    <!-- /.navbar -->
    {{--  {{route('bienvenido')}} --}}
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4">




      <!-- Sidebar -->



      <div class="sidebar">
        <div class="image-logo-container">
          <a href="{{ route('user.home') }}">
            <img src="/img/logo-ciites-w300.png" class="brand-image w-100 px-3">
          </a>

        </div>
        <!-- Sidebar user (optional) -->


        <div class="user-panel mt-3 d-flex">
          <div class="image pl-0 d-flex flex-column">
            <img src="/img/usuario.png" class="img-circle elevation-2" alt="User Image">
            <span class="mb-auto fontSize9" title="Sus roles en el sistema">
              Roles:
            </span>
          </div>


          <div class="info">
            <a href="{{ route('GestionUsuarios.verMisDatos') }}" class="d-block nombrecompleto-usuario">
              {{ $empLogeadoPlantilla->nombres }}
              <br>
              {{ $empLogeadoPlantilla->apellidos }}
            </a>

            <div class="d-flex flex-column ">

              @foreach ($empLogeadoPlantilla->getPuestos() as $puesto)
                <label class="label_puestos" style="" title="{{ $puesto->descripcion }}">
                  {{ $puesto->nombreAparente }}
                </label>
              @endforeach
            </div>

          </div>

        </div>


        @if ($empLogeadoPlantilla->esAdminSistema())

          @if (App\ParametroSistema::mostrarMsj())
            <div class="msj_parametros_faltantes">
              {{ App\ParametroSistema::getMsjFaltantes() }}
            </div>
          @endif
        @endif

        @php
          $entorno = App\ParametroSistema::getEntorno();
        @endphp
        @if ($entorno != 'produccion')
          <div class="nombre-entorno">
            Entorno: {{ $entorno }}
          </div>
        @endif



        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            @include('Layout.MenuLateral.MenuDinamico')




          </ul>
        </nav>



        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Main content -->
      <section class="content">
        @yield('contenido')

      </section>
      <!-- /.content -->
    </div>

    <footer class="main-footer" style="padding: 4px; font-size:9pt;">
      <div style="text-align:right;">
        <strong>Copyright &copy; {{ date('Y') }}

          .
        </strong>
        Powered by Maracsoft
      </div>

    </footer>


  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- AdminLTE App -->
  <script src="/adminlte/dist/js/adminlte.min.js"></script>

  <script src="/select2/bootstrap-select.min.js"></script>

  {{-- La lógica del loader show y hide depende de esta librería --}}
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>


  {{--  https://sweetalert2.github.io/#download --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="/calendario/js/bootstrap-datepicker.js"></script>




  <script>
    var menuLateralOcultado = true;


    clicMenuLateral();

    //YA FUNCIONA YA XD LE HABIA PUESTO TITLE AL icoono Y NO AL A REF
    function clicMenuLateral() {
      document.getElementById('iconoOcultarMenuLateral').classList = "";
      document.getElementById('iconoOcultarMenuLateral').classList.add('fas');

      if (menuLateralOcultado) {
        document.getElementById('aRefOcultarMenuLateral').title = "Expandir menú lateral";
        document.getElementById('iconoOcultarMenuLateral').classList.add('fa-chevron-left');
        //console.log('ENTRA 1' + menuLateralOcultado);
      } else {

        document.getElementById('aRefOcultarMenuLateral').title = "Ocultar menu lateral";
        document.getElementById('iconoOcultarMenuLateral').classList.add('fa-chevron-right');
        //console.log('ENTRA 2' + menuLateralOcultado);
      }

      menuLateralOcultado = !menuLateralOcultado;


    }


    function clickeoButton() {
      confirmarConMensaje(funcionAEjecutarSiSí);

    }


    function funcionAEjecutarSiSí() {
      console.log('oye ya estamos adentro');

    }



    function confirmarConMensaje(titulo, html, tipoMensaje, nombreFuncionAEjecutar) {


      Swal.fire({
        title: titulo,
        html: html, //mas texto
        icon: tipoMensaje, //e=[success,error,warning,info]
        showCancelButton: true, //para que se muestre el boton de cancelar
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'SÍ',
        cancelButtonText: 'NO',
        reverseButtons: true


      }).then((result) => {

        if (result.isConfirmed) {
          nombreFuncionAEjecutar();
        }
      })
    }


    Number.prototype.toFixedDown = function(digits) {
      //var re = new RegExp("([-+]?\\d+\\.\\d{"+digits+"})(\\d)"),
      var re = new RegExp("(\\d+\\.\\d{" + digits + "})(\\d)"),
        m = this.toString().match(re);
      return m ? parseFloat(m[1]) : this.valueOf();
    };

    function number_format(amount, decimals) {
      return parseFloat(amount).toFixed(decimals);
    }



    function confirmar(msj, type, formName) {
      Swal.fire({
        title: msj,
        text: '', //mas texto
        icon: type, //e=[success,error,warning,info]

        showCancelButton: true, //para que se muestre el boton de cancelar
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'SÍ',
        cancelButtonText: 'NO',
        reverseButtons: true


      }).then((result) => {

        if (result.isConfirmed) {
          document.getElementById(formName).submit();
        }
      })


    }

    function alerta(msj) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        html: msj,
        confirmButtonColor: "#3085d6"
      })
    }

    function alertaMensaje(title, msj, type) {
      Swal.fire({
        title: title,
        html: msj,
        icon: type, //e=[success,error,warning,info,question]
        showCancelButton: false, //para que se muestre el boton de cancelar
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK',


      })
    }


    function alertaExitosa(titulo, msj) {

      Swal.fire({
        title: titulo,
        html: msj,
        icon: "success", //e=[success,error,warning,info,question]
        showCancelButton: false, //para que se muestre el boton de cancelar
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK',


      })

    }


    function confirmarCerrarSesion() {
      confirmarConMensaje("Cerrar Sesión", "¿Seguro que desea finalizar su sesión?", "warning", function() {
        location.href = "{{ route('user.cerrarSesion') }}"
      });

    }


    /*                       input= id del elemento del que vamos a contar caracteres
      output = bold que está dentro del label en el que pondremos el avance */
    function contadorCaracteres(input, output, valValidacion) {
      //console.log('entro');
      setInterval(function() {
        var c = $('#' + input).val();
        var longMax = valValidacion;
        longMax = parseInt(longMax);

        if (c.length > longMax) {
          color = "red";
        } else {
          color = "rgba(0, 0, 0, 0.548)";
        }
        document.getElementById(output).style.color = color;
        document.getElementById(output).innerHTML = '(' + c.length + '/' + longMax + ')';
      }, 0300);


    }


    function actualizarEstadoMenu(element) {
      let parent = element.parentElement;

      let rol = element.getAttribute("data-rolname");
      let estado = parent.classList.contains("menu-open") ? "closed" : "open";
      let url = "{{ route('ActualizarEstadoMenu') }}";
      let data = {
        'rol': rol,
        'estado': estado,
        '_token': "{{ csrf_token() }}"
      };

      $.post(url, data, function(response) {

        let obj = JSON.parse(response);
        console.log(obj);
      });

    }

    const NotificacionAbajoDerecha = Swal.mixin({
      toast: true,
      position: 'bottom-end',
      showConfirmButton: false,
      timer: 3000,

    });


    function mostrarNotificacion(icono, texto) {
      // [success,error,warning,info,question]
      NotificacionAbajoDerecha.fire({
        icon: icono,
        title: texto
      })

    }

    // api_response = objRespuesta
    function mostrarNotificacionSegunRespuesta(api_response) {
      if (api_response.ok == 1 || api_response.ok == "1") {

        mostrarNotificacion(api_response.tipoWarning, api_response.mensaje)
      } else {

        alertaMensaje(api_response.titulo, api_response.mensaje, api_response.tipoWarning);
      }
    }
  </script>


  @yield('script')

</body>

</html>
