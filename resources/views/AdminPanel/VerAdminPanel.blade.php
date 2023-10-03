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

                    <a href="{{route('HistorialErrores.Listar')}}" class="btn btn-primary">
                        Historial de Errores
                    </a>
                    <a href="{{route('HistorialLogeos.Listar')}}" class="btn btn-primary">
                        Historial de Logeos
                    </a>
                    <a href="{{route('Operaciones.Listar')}}" class="btn btn-primary">
                        Operaciones
                    </a>
                    <a href="{{route('BuscadorMaestro')}}" class="btn btn-primary">    
                        BuscadorMaestro
                    </a>
                    <a href="{{route('Reportes.Listar')}}" class="btn btn-primary">
                        Reportes
                    </a>
                    <a href="{{route('ParametroSistema.Listar')}}" class="btn btn-primary">    
                        Parametros
                    </a>
                    <a href="{{route('AdminPanel.VerPanel')}}" class="btn btn-primary">    
                      AdminPanel
                    </a>
                    <a href="{{route('Jobs.Listar')}}" class="btn btn-primary">    
                      JOBS
                    </a>

                    <a href="{{route('Migraciones.Listar')}}" class="btn btn-primary">    
                      Migraciones
                    </a>
                    
                    <a href="{{route('AdminPanel.VerPhpInfo')}}" class="btn btn-primary">    
                      PHP INFO
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
                    <a href="{{route('GestionUsuarios.Listar')}}" class="btn btn-primary">
                        Empleados 
                      </a>
                    <a href="{{route('GestionPuestos.Listar')}}" class="btn btn-primary">
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

                  <button type="button" class="btn btn-primary" onclick="actualizarGit()">

                    <svg class="mr-1" width="30" height="30" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMinYMin meet">
                      <path d="M104.529 49.53L58.013 3.017a6.86 6.86 0 0 0-9.703 0l-9.659 9.66 12.253 12.252a8.145 8.145 0 0 1 8.383 1.953 8.157 8.157 0 0 1 1.936 8.434L73.03 47.125c2.857-.984 6.154-.347 8.435 1.938a8.161 8.161 0 0 1 0 11.545 8.164 8.164 0 0 1-13.324-8.88L57.129 40.716l-.001 28.98a8.248 8.248 0 0 1 2.159 1.544 8.164 8.164 0 0 1 0 11.547c-3.19 3.19-8.36 3.19-11.545 0a8.164 8.164 0 0 1 2.672-13.328v-29.25a8.064 8.064 0 0 1-2.672-1.782c-2.416-2.413-2.997-5.958-1.759-8.925l-12.078-12.08L2.011 49.314a6.863 6.863 0 0 0 0 9.706l46.516 46.514a6.862 6.862 0 0 0 9.703 0l46.299-46.297a6.866 6.866 0 0 0 0-9.707" fill="#DE4C36" />
                    </svg>
                    Git Pull
                  </button>
                  
                  <form method="POST" action="{{route('TestearPost')}}" id="formTestearPost" name="formTestearPost">
                    @csrf

                  </form>

                  <a  class="btn btn-primary" href="{{route('CITE.verReporteRepetidos')}}">
                    CITE Verificar Repetidos
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
                        CRUDS
                    </h3>
                    
                </div>
                <div class="card-body">
                    
                    <a href="{{route('GestiónUnidadMedida.listar')}}" class="btn btn-primary">
                        Unidades de Medida
                    </a>
                    <a href="{{route('TipoOperacion.Listar')}}" class="btn btn-primary">
                        Tipo Operacion
                    </a>
                    <a href="{{route('PlanEstrategico.listar')}}" class="btn btn-primary">
                        Plan Estratégico
                    </a>
                    <a href="{{route('GestiónTipoPersonaJuridica.Listar')}}" class="btn btn-primary">
                        Tipo Personal Juridico
                    </a>
                    <a href="{{route('EntidadFinanciera.listar')}}" class="btn btn-primary">
                        Financieras
                    </a>
                    <a href="{{route('TipoFinanciamiento.listar')}}" class="btn btn-primary">          
                        Tipos de Financiamiento
                    </a>
                    <a href="{{route('GestiónProyectos.AdminSistema.listarPersonasRegistradas')}}" class="btn btn-primary">    
                        P. Naturales y Jur
                    </a>
                    <a href="{{route('ObjetivoMilenio.listar')}}" class="btn btn-primary">    
                        Obj. Milenio
                    </a>
                    <a href="{{route('Sede.ListarSedes')}}" class="btn btn-primary">
                        Sedes
                    </a>
                    <a href="{{route('ActividadPrincipal.Listar')}}" class="btn btn-primary">
                      Actividades de Personas
                  </a>
                  <a href="{{route('GestionProyectos.VerDashboard')}}" class="btn btn-primary">
                    Dashboard Proyectos
                  </a>
                  
                
                </div>
            </div>
        </div>
    </div>


 
    

@endsection

@section('script')
<script>
    $(document).ready(function(){
        $(".loader").fadeOut("slow");
    });

    function generarBackup(){
        $(".loader").show();
        $.get('/DB/GenerarBackup',function(data){
            $(".loader").fadeOut("slow");
            objetoRespuesta = JSON.parse(data);
            alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);

        });

    }


    
    function actualizarGit(){
        $(".loader").show();
        csrf = document.getElementsByName('_token')[0].value;

        var datosAEnviar = {
          _token:   csrf,
        };

        $.post('/Git/ActualizarRepositorio',datosAEnviar,function(data){
            $(".loader").fadeOut("slow");
            objetoRespuesta = JSON.parse(data);
            alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);

        });

    }



    function testearPOST(){
      document.formTestearPost.submit();
    }
 
    

</script>
@endsection

@section('estilos')
<style>
    .card-body > .btn{
        margin:3px;
    }
</style>
@endsection