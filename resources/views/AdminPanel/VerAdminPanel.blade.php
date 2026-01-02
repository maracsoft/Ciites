@extends('Layout.Plantilla')
@section('titulo')
  Flujograma
@endsection
@section('tiempoEspera')
  <div class="loader" id="pantallaCarga"></div>
@endsection
@section('contenido')
  @include('Layout.MensajeEmergenteDatos')
  <div class="row">
    <div class="col text-center">
      <h1>
        Bienvenido Juguitoooooooooo
      </h1>
    </div>
  </div>



  <div class="row mt-1">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h3>
            Servicios
          </h3>
        </div>
        <div class="card-body">

          <a href="{{ route('HistorialErrores.Listar') }}" class="btn btn-primary">
            Historial de Errores
          </a>
          <a href="{{ route('HistorialLogeos.Listar') }}" class="btn btn-primary">
            Historial de Logeos
          </a>
          <a href="{{ route('Operaciones.Listar') }}" class="btn btn-primary">
            Operaciones
          </a>
          <a href="{{ route('BuscadorMaestro') }}" class="btn btn-primary">
            BuscadorMaestro
          </a>

          <a href="{{ route('ParametroSistema.Listar') }}" class="btn btn-primary">
            Parametros
          </a>
          <a href="{{ route('AdminPanel.VerPanel') }}" class="btn btn-primary">
            AdminPanel
          </a>
          <a href="{{ route('Jobs.Listar') }}" class="btn btn-primary">
            JOBS
          </a>

          <a href="{{ route('Migraciones.Listar') }}" class="btn btn-primary">
            Migraciones
          </a>

          <a href="{{ route('AdminPanel.VerPhpInfo') }}" class="btn btn-primary">
            PHP INFO
          </a>

          <a href="{{ route('PeriodoDirector.Listar') }}" class="btn btn-primary">
            Periodos de Director General
          </a>



        </div>
      </div>
    </div>
  </div>





  <div class="row mt-1">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h3>
            Usuarios
          </h3>

        </div>
        <div class="card-body">
          <a href="{{ route('GestionUsuarios.Listar') }}" class="btn btn-primary">
            Empleados
          </a>
          <a href="{{ route('GestionPuestos.Listar') }}" class="btn btn-primary">
            Puestos
          </a>
        </div>
      </div>
    </div>
  </div>
  @csrf


  <div class="row mt-1">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h3>
            Procesos
          </h3>

        </div>
        <div class="card-body">
          <button type="button" class="btn btn-primary" onclick="generarBackup()">
            <i class="fas fa-database"></i>
            Generar Backup Estructural de la Base de datos
          </button>


          <button type="button" class="btn btn-primary" onclick="testearPOST()">
            <i class="fas fa-wrench"></i>
            Testear POST en la APP
          </button>



          <form method="POST" action="{{ route('TestearPost') }}" id="formTestearPost" name="formTestearPost">
            @csrf

          </form>




        </div>
      </div>
    </div>
  </div>


  <div class="row mt-1">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h3>
            CRUDS
          </h3>

        </div>
        <div class="card-body">

          <a href="{{ route('GestiónUnidadMedida.listar') }}" class="btn btn-primary">
            Unidades de Medida
          </a>
          <a href="{{ route('TipoOperacion.Listar') }}" class="btn btn-primary">
            Tipo Operacion
          </a>




          <a href="{{ route('Sede.ListarSedes') }}" class="btn btn-primary">
            Sedes
          </a>

          <a href="{{ route('GestionProyectos.VerDashboard') }}" class="btn btn-primary">
            Dashboard Proyectos
          </a>


        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      $(".loader").fadeOut("slow");
    });

    function generarBackup() {
      $(".loader").show();
      $.get('/DB/GenerarBackup', function(data) {
        $(".loader").fadeOut("slow");
        objetoRespuesta = JSON.parse(data);
        alertaMensaje(objetoRespuesta.titulo, objetoRespuesta.mensaje, objetoRespuesta.tipoWarning);

      });

    }






    function testearPOST() {
      document.formTestearPost.submit();
    }
  </script>
@endsection

@section('estilos')
  <style>
    .card-body>.btn {
      margin: 3px;
    }
  </style>
@endsection
