<?php

namespace App;

use App\Models\MaracModelInterface;
use App\Models\Notificaciones\Notificacion;
use App\Models\Notificaciones\TipoNotificacion;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\User;
use Exception;

//START MODEL_HELPER
/**
 * @property int $codEmpleado int(11)     
 * @property int $codUsuario int(11)     
 * @property string $codigoCedepas varchar(50)     
 * @property string $nombres varchar(300)     
 * @property string $apellidos varchar(300)     
 * @property string $correo varchar(60)     
 * @property string $dni char(8)     
 * @property int $codPuesto int(11) NULLABLE    
 * @property int $activo int(11)     
 * @property string $fechaRegistro date     
 * @property string $fechaDeBaja date NULLABLE    
 * @property int $codSede int(11)     
 * @property string $sexo char(1)     
 * @property string $fechaNacimiento date     
 * @property string $nombreCargo varchar(100)     
 * @property string $direccion varchar(300)     
 * @property string $nroTelefono varchar(20)     
 * @property int $codSedeContador int(11) NULLABLE    
 * @property int $mostrarEnListas tinyint(4)     
 * @property string $tipo_menu_lateral varchar(50)     
 * @property string $menus_abiertos text NULLABLE    
 * @method static Empleado findOrFail($primary_key)
 * @method static Empleado | null find($primary_key)
 * @method static EmpleadoCollection all()
 * @method static \App\Builders\EmpleadoBuilder query()
 * @method static \App\Builders\EmpleadoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\EmpleadoBuilder where(string $column,string $value)
 * @method static \App\Builders\EmpleadoBuilder whereNotNull(string $column) 
 * @method static \App\Builders\EmpleadoBuilder whereNull(string $column) 
 * @method static \App\Builders\EmpleadoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\EmpleadoBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class Empleado extends MaracModel implements MaracModelInterface
{
  public $table = "empleado";
  protected $primaryKey = "codEmpleado";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = ['codUsuario', 'nombres', 'apellidos', 'activo', 'codigoCedepas', 'dni', 'fechaRegistro', 'fechaDeBaja', 'codSede'];

  /* Facade para findOrFail, por temas de intellise */
  public static function findf(int $id): Empleado
  {
    return Empleado::findOrFail($id);
  }

  public function getFechaNacimiento(): string
  {
    return Fecha::formatoParaVistas($this->fechaNacimiento);
  }

  public static function prepararParaSelect($listaEmpleados)
  {
    foreach ($listaEmpleados as $empleado) {
      $empleado['getNombreCompleto'] = $empleado->getNombreCompleto();
      $empleado['nombreCompleto'] = $empleado->getNombreCompleto();
    }

    return $listaEmpleados;
  }


  public function getSedeQueAdministra()
  {
    $lista = Sede::where('codEmpleadoAdministrador', '=', $this->codEmpleado)->get();
    if (count($lista) == 0)
      return new Sede();

    return $lista[0];
  }

  /* busca un empleado, si encuentra uno retorna el objeto empleado. si no retorna "" */
  public static function buscarPorDNI($DNI)
  {
    $lista = Empleado::where('dni', '=', $DNI)->get();

    if (count($lista) == 0)
      return "";

    return $lista[0];
  }

  public function getSolicitudesPorRendir()
  {
    $vector = [SolicitudFondos::getCodEstado('Abonada'), SolicitudFondos::getCodEstado('Contabilizada')];

    return SolicitudFondos::whereIn('codEstadoSolicitud', $vector)
      ->where('codEmpleadoSolicitante', '=', $this->codEmpleado)
      ->where('estaRendida', '=', 0)
      ->get();
  }


  public function getSolicitudesObservadas()
  {
    return SolicitudFondos::where('codEstadoSolicitud', '=', SolicitudFondos::getCodEstado('Observada'))
      ->where('codEmpleadoSolicitante', '=', $this->codEmpleado)
      ->get();
  }


  public function getReposicionesObservadas()
  {

    return ReposicionGastos::where('codEmpleadoSolicitante', '=', $this->codEmpleado)
      ->where('codEstadoReposicion', '=', ReposicionGastos::getCodEstado('Observada'))
      ->get();
  }
  public function getRequerimientosObservados()
  {

    return RequerimientoBS::where('codEmpleadoSolicitante', '=', $this->codEmpleado)
      ->where('codEstadoRequerimiento', '=', RequerimientoBS::getCodEstado('Observada'))
      ->get();
  }
  public function getRendicionesObservadas()
  {

    return RendicionGastos::where('codEmpleadoSolicitante', '=', $this->codEmpleado)
      ->where('codEstadoRendicion', '=', RendicionGastos::getCodEstado('Observada'))
      ->get();
  }



  public function getDetallesPendientesRendicion()
  {
    $rendicionesDelEmpleado = RendicionGastos::where('codEmpleadoSolicitante', '=', $this->codEmpleado)
      ->get();
    $vectorDeCodsRendicion = [];

    foreach ($rendicionesDelEmpleado as $item) {
      array_push($vectorDeCodsRendicion, $item->codRendicionGastos);
    }
    //Debug::mensajeSimple(implode(' , ',$vectorDeCodsRendicion));



    $lista =  DetalleRendicionGastos::whereIn('codRendicionGastos', $vectorDeCodsRendicion)
      ->where('pendienteDeVer', '=', '1')
      ->get();

    return $lista;
  }
  public function getDetallesPendientesReposicion()
  {
    $reposicionesDelEmpleado = ReposicionGastos::where('codEmpleadoSolicitante', '=', $this->codEmpleado)
      ->get();
    $vectorDeCodsReposicion = [];

    foreach ($reposicionesDelEmpleado as $item) {
      array_push($vectorDeCodsReposicion, $item->codReposicionGastos);
    }
    //Debug::mensajeSimple(implode(' , ',$vectorDeCodsRendicion));

    $lista =  DetalleReposicionGastos::whereIn('codReposicionGastos', $vectorDeCodsReposicion)
      ->where('pendienteDeVer', '=', '1')
      ->get();

    return $lista;
  }

  public function getListaEmpleadoPuesto(): Collection
  {
    return EmpleadoPuesto::where('codEmpleado', $this->codEmpleado)->get();
  }


  public function getPuestos()
  {
    $listaEmpleadoPuesto = $this->getListaEmpleadoPuesto();
    $codPuestos = [];
    foreach ($listaEmpleadoPuesto as $empleadoPuesto) {
      array_push($codPuestos, $empleadoPuesto->codPuesto);
    }

    $listaPuestos = Puesto::whereIn('codPuesto', $codPuestos)->orderBy('ordenListado', 'ASC')->get();
    return $listaPuestos;
  }

  public function getPuestosPorComas()
  {
    $array = [];
    $lista = $this->getPuestos();
    foreach ($lista as $pue) {
      $array[] = $pue->nombre;
    }
    return implode(",", $array);
  }

  public function getLetraSegunSexo()
  {
    if ($this->sexo == "H")
      return "o";
    else
      return "a";
  }





  //le pasamos la id del usuario y te retorna el codigo cedepas del empleado
  public function getNombrePorUser($idAuth)
  {
    $lista = Empleado::where('codUsuario', '=', $idAuth)->get();
    return $lista[0]->nombres;
  }

  public function esEmpleado(): bool
  {
    $codPuestoEsperado = Puesto::getCodPuesto_Empleado();
    return $this->verificarPuesto($codPuestoEsperado);
  }

  public function esGerente(): bool
  {

    $codPuestoEsperado = Puesto::getCodPuesto_Gerente();
    return $this->verificarPuesto($codPuestoEsperado);
  }

  public function esContador(): bool
  {
    $codPuestoEsperado = Puesto::getCodPuesto_Contador();
    return $this->verificarPuesto($codPuestoEsperado);
  }
  public function esObservador(): bool
  {
    $codPuestoEsperado = Puesto::getCodPuesto_Observador();
    return $this->verificarPuesto($codPuestoEsperado);
  }

  public function esConductor(): bool
  {
    $codPuestoEsperado = Puesto::getCodPuesto_Conductor();
    return $this->verificarPuesto($codPuestoEsperado);
  }

  public function esAprobadorViajes(): bool
  {
    $codPuestoEsperado = Puesto::getCodPuesto_AprobadorViajes();
    return $this->verificarPuesto($codPuestoEsperado);
  }



  /* Retorna el obj sede si el empleado es contador */
  public function getSedeContador()
  {
    return Sede::findOrFail($this->codSedeContador);
  }

  public function getSedeContadorOAdministrador()
  {
    if ($this->esContador())
      return $this->getSedeContador();

    if ($this->esJefeAdmin())
      return $this->getSedeQueAdministra();
  }

  public function esAdminSistema()
  {
    $usuario = User::findOrFail($this->codUsuario);
    return $usuario->isAdmin == '1';
  }
  public function verificarPuesto($codPuestoEsperado): bool
  {
    $listaEmpleadoPuesto = $this->getListaEmpleadoPuesto();
    foreach ($listaEmpleadoPuesto as $emp_puesto) {
      if ($emp_puesto->codPuesto == $codPuestoEsperado)
        return true;
    }
    return false;
  }

  public function esUGE()
  {
    $codPuestoEsperado = Puesto::getCodPuesto_UGE();
    return $this->verificarPuesto($codPuestoEsperado);
  }

  public function esAdministrador()
  {
    $codPuestoEsperado = Puesto::getCodPuesto_Administrador();
    return $this->verificarPuesto($codPuestoEsperado);
  }



  /* REFACTORIZAR ESTO PARA LA NUEVA CONFIGURACION DEL A BASE DE DATOOOOOOOOOOOOOOOOOOOOOOOOOS
    SOLO TIENES K CAMBIAR TODAS LAS FUNCIONES QUE USEN EL codPuesto POR LA NUEVA TABLA

    */
  //para modulo ProvisionFondos.
  public function esJefeAdmin(): bool
  {
    $codPuestoEsperado = Puesto::getCodPuesto_Administrador();
    return $this->verificarPuesto($codPuestoEsperado);
  }

  public function getPuestoOld()
  {
    if ($this->codPuesto != null)
      return $this->getPuesto()->nombre;

    return "";
  }
  public function getPuesto()
  {

    return Puesto::findOrFail($this->codPuesto);
  }

  public function estaActivo()
  {
    return $this->activo == '1';
  }

  public function getColorSegunActivo()
  {
    return $this->estaActivo() ? '' : 'rgb(250,200,200)';
  }




  public static function getListaGerentesActivos(): Collection
  {

    $arrayCodEmp = [];
    $listaEmpleadoPuesto = EmpleadoPuesto::where('codPuesto', Puesto::getCodigo('Gerente'))->get();
    foreach ($listaEmpleadoPuesto as $emp) {
      $arrayCodEmp[] = $emp->codEmpleado;
    }

    $lista = Empleado::whereIn('codEmpleado', $arrayCodEmp)->where('activo', '=', '1')->get();

    return $lista;
  }

  public static function getListaContadoresActivos()
  {
    $arrayCodEmp = [];
    $listaEmpleadoPuesto = EmpleadoPuesto::where('codPuesto', Puesto::getCodigo('Contador'))->get();
    foreach ($listaEmpleadoPuesto as $emp) {
      $arrayCodEmp[] = $emp->codEmpleado;
    }

    $lista = Empleado::whereIn('codEmpleado', $arrayCodEmp)->where('activo', '=', '1')->get();

    return $lista;
  }

  public static function getListaAdministradoresActivos()
  {
    $arrayCodEmp = [];
    $listaEmpleadoPuesto = EmpleadoPuesto::where('codPuesto', Puesto::getCodigo('Administrador'))->get();
    foreach ($listaEmpleadoPuesto as $emp) {
      $arrayCodEmp[] = $emp->codEmpleado;
    }

    $lista = Empleado::whereIn('codEmpleado', $arrayCodEmp)->where('activo', '=', '1')->get();

    return $lista;
  }


  public function getListaProyectosObservador(): Collection
  {

    $listaProyectoObservador = ProyectoObservador::where('codEmpleadoObservador', $this->getId())->get();
    $codsProyectos = [];
    foreach ($listaProyectoObservador as $proy_obs) {
      $codsProyectos[] = $proy_obs->codProyecto;
    }

    $proyectos = Proyecto::whereIn('codProyecto', $codsProyectos)->get();
    $proyectos = Proyecto::añadirNombreYcod($proyectos);
    return $proyectos;
  }


  //solo se aplica a los gerentes, retorna lista de proyectos que este gerente lidera
  public function getListaProyectos(): Collection
  {
    $proy = Proyecto::where('codEmpleadoDirector', '=', $this->codEmpleado)->get();
    $proy = Proyecto::añadirNombreYcod($proy);
    //retornamos el Collection
    return $proy;
  }

  // solo para gerente
  public function getListaSolicitudesDeGerente()
  {

    $listaSolicitudesFondos = $this->getListaSolicitudesDeGerente2()->get();
    return $listaSolicitudesFondos;
  }

  public function getListaSolicitudesDeGerente2()
  {
    //Construimos primero la busqueda de todos los proyectos que tenga este gerente
    $listaProyectos = $this->getListaProyectos();
    $vecProy = [];
    foreach ($listaProyectos as $itemProyecto) {
      array_push($vecProy, $itemProyecto->codProyecto);
    }

    $listaSolicitudesFondos = SolicitudFondos::whereIn('codProyecto', $vecProy);

    return $listaSolicitudesFondos;
  }

  //solo para gerente
  /* DEPRECATED */






  public static function hayEmpleadoLogeado(): bool
  {
    if (is_null(Auth::id())) {

      return false;
    }



    return true;
  }


  public static function getEmpleadoLogeado(): Empleado
  {
    $codUsuario = Auth::id();
    $empleados = Empleado::where('codUsuario', '=', $codUsuario)->get();

    if (is_null(Auth::id())) {
      throw new Exception("No hay ningún usuario logeado");
    }


    if (count($empleados) < 0) //si no encontró el empleado de este user
    {
      Debug::mensajeError('Empleado', '    getEmpleadoLogeado() ');
      throw new Exception("El usuario logeado no tienen ningun empleado");
    }
    return $empleados[0];
  }



  public function usuario()
  {

    try {
      $usuario = User::findOrFail($this->codUsuario);
    } catch (Throwable $th) {
      Debug::mensajeError('MODELO EMPLEADO', $th);

      return "usuario no encontrado.";
    }

    return $usuario;
  }


  public function getNombreCompleto()
  {
    return $this->apellidos . ' ' . $this->nombres;
  }

  public static function getEmpleadosActivos()
  {
    return Empleado::where('activo', '=', '1')
      ->get();
  }

  //obtiene una lista de los empleados ordenada alfabeticamente por apellidos (excepto el admin)
  //ESTA FUNCION DEBE USARSE SIEMPRE PARA MOSTRARLE A LOS USUARIOS LA LISTA DE EMPLEADOS (en un select x ejemplo)
  public static function getListaEmpleadosPorApellido(): Collection
  {

    $lista = Empleado::where('mostrarEnListas', '=', "1")->orderBy('apellidos')->get();
    foreach ($lista as $emp) {
      $emp['nombreCompleto'] = $emp->getNombreCompleto();
    }
    return $lista;
  }
  public static function getMesActual()
  {
    date_default_timezone_set('America/Lima');
    return (int)date('m');
  }


  public function getNotificaciones(string $nombreTipoNotificacion, bool $mostrarSoloNoVistas)
  {
    $tipoNoti = TipoNotificacion::where('nombre', $nombreTipoNotificacion)->first();

    $query =  Notificacion::where('codEmpleado', '=', $this->codEmpleado)->where('codTipoNotificacion', $tipoNoti->getId());
    if ($mostrarSoloNoVistas)
      $query = $query->where('visto', 0);

    return $query->get();
  }





  public static function getAdministradorAleatorio(): Empleado
  {
    $emp_puesto = EmpleadoPuesto::where('codPuesto', '=', Puesto::getCodPuesto_Administrador())->get();
    $index = rand(1, count($emp_puesto)) - 1;
    $admin = Empleado::findOrFail($emp_puesto[$index]->codEmpleado);
    return $admin;
  }

  public static function getContadorAleatorio($codProyecto): Empleado
  {

    $listaContadoresDeProyecto = ProyectoContador::where('codProyecto', '=', $codProyecto)->get();
    $num = rand(1, count($listaContadoresDeProyecto)) - 1;

    $codEmpleadoContador = $listaContadoresDeProyecto[$num]->codEmpleadoContador;
    //error_log($codEmpleadoContador);
    return Empleado::findOrFail($codEmpleadoContador);
  }



  public function getListaIPs()
  {
    $listaLogeos = LogeoHistorial::where('codEmpleado', '=', $this->codEmpleado)->get();
    $listaIps = [];
    foreach ($listaLogeos as $logeo) {
      if (!in_array($logeo->ipLogeo, $listaIps))
        $listaIps[] = $logeo->ipLogeo;
    }
    return $listaIps;
  }

  //retorna la IP con la que más frecuentemente se conecta
  public function getIPPrincipal()
  {
    $id = $this->codEmpleado;
    $SQL = "select
                    codEmpleado,ipLogeo,count(codLogeoHistorial) as 'CantidadIngresos'
                from logeo_historial
                WHERE codEmpleado = $id
                GROUP by codEmpleado, ipLogeo
                ORDER by count(codLogeoHistorial) DESC";

    $resultados = DB::select($SQL);
    if (count($resultados) == 0)
      return "No hay ingresos.";

    $vector = json_decode(json_encode($resultados), false);
    $logeoPrincipal = $vector[0];

    return  $logeoPrincipal->ipLogeo;
  }

  public function getCantidadDeLogeosDeUnaIP($ip)
  {
    $lista = LogeoHistorial::where('codEmpleado', '=', $this->codEmpleado)
      ->where('ipLogeo', '=', $ip)
      ->get();
    return count($lista);
  }

  public function getIPyCantidadLogeos()
  {
    $ip = $this->getIPPrincipal();
    $cant = $this->getCantidadDeLogeosDeUnaIP($ip);
    return $ip . " ($cant)";
  }











  public function getCantidadObservacionesMesAño($mes, $año)
  {
    $id = $this->codEmpleado;

    //Cantidad de observaciones de todas las reposiciones de un empleado
    $sql = "
            select
                R.codEmpleadoSolicitante,
                count(O.codOperacionDocumento) as 'cant'

            from operacion_documento O
                inner join reposicion_gastos R on
                    R.codReposicionGastos = O.codDocumento and
                    O.codTipoDocumento = '3'

            where
                O.codTipoOperacion = 32 and
                month(R.fechaHoraEmision) = '$mes' and
                YEAR(R.fechaHoraEmision) = '$año' and
                R.codEmpleadoSolicitante = $id
            group by R.codEmpleadoSolicitante
        ";

    //Debug::mensajeSimple($sql);
    $respuesta = DB::select($sql);

    if (empty($respuesta)) {
      Debug::mensajeSimple("ES NULO");
      return 0;
    }
    return $respuesta[0]->cant;
  }


  function tieneAccesoAInventario()
  {

    if (!RevisionInventario::hayUnaRevisionActiva())
      return false;


    $ultimaRevision = RevisionInventario::getRevisionActiva();
    return $ultimaRevision->tieneAEmpleado($this->codEmpleado);
  }


  public static function getEmpleadosConductores(): Collection
  {
    return static::getEmpleadosConPuesto(Puesto::getCodPuesto_Conductor());
  }

  public static function getEmpleadosAprobadoresViajes(): Collection
  {
    return static::getEmpleadosConPuesto(Puesto::getCodPuesto_AprobadorViajes());
  }
  //prepararParaSelect
  private static function getEmpleadosConPuesto(int $codPuesto)
  {
    $codsEmpleadosValidos = EmpleadoPuesto::where('codPuesto', $codPuesto)->pluck('codEmpleado')->toArray();
    $empleados = Empleado::whereIn('codEmpleado', $codsEmpleadosValidos)->get();
    return static::prepararParaSelect($empleados);
  }



  const TipoMenuLateral_Agrupado = "agrupado";
  const TipoMenuLateral_Desagrupado = "desagrupado";

  public function seDebeAgruparMenu(): bool
  {
    return  $this->tipo_menu_lateral == Empleado::TipoMenuLateral_Agrupado;
  }


  public function getMenusAbiertosArray(): array
  {
    if ($this->menus_abiertos == null)
      return [];
    return json_decode($this->menus_abiertos, true);
  }


  public function tieneMenuAbierto(string $role_name): bool
  {
    return in_array($role_name, $this->getMenusAbiertosArray());
  }

  public function getRolesWithRoutes()
  {
    $routes = $this->getAccesibleRoutes();

    $roles = [
      Puesto::Empleado => [],
      Puesto::Gerente => [],
      Puesto::Contador => [],
      Puesto::Administrador => [],
      Puesto::UGE => [],

      Puesto::Observador => [],
      Puesto::ReportadorHoras => [],
      Puesto::Conductor => [],

      Puesto::AprobadorViajes => [],
    ];

    foreach ($routes as $route) {
      foreach ($route->roles as $rol_con_permiso) {
        $roles[$rol_con_permiso][] = $route;
      }
    }

    // retorna un array en el que cada elemento es un puesto y el valor es un array de rutas

    return $roles;
  }

  public function getAccesibleRoutes()
  {
    $rutas = [];

    if ($this->esEmpleado()) {
      $rutas[] = (object)  [
        "url" => route('SolicitudFondos.Empleado.Listar'),
        "label" => "Mis Solicitudes",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Empleado]
      ];
      $rutas[] = (object)  [
        "url" => route('RendicionGastos.Empleado.Listar'),
        "label" => "Mis Rendiciones",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Empleado]
      ];
      $rutas[] = (object)  [
        "url" => route('ReposicionGastos.Empleado.Listar'),
        "label" => "Mis Reposiciones",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Empleado]
      ];
      $rutas[] = (object)  [
        "url" => route('RequerimientoBS.Empleado.Listar'),
        "label" => "Mis Requerimientos",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Empleado]
      ];


      $rutas[] = (object)  [
        "url" => route('DJMovilidad.Empleado.Listar'),
        "label" => "DJ Mov",
        "icon_class" => "far fa-file-contract",
        "roles" => [Puesto::Empleado]
      ];
      $rutas[] = (object)  [
        "url" => route('DJViaticos.Empleado.Listar'),
        "label" => "DJ Viaticos",
        "icon_class" => "far fa-file-contract",
        "roles" => [Puesto::Empleado]
      ];
      $rutas[] = (object)  [
        "url" => route('DJVarios.Empleado.Listar'),
        "label" => "DJ Varios",
        "icon_class" => "far fa-file-contract",
        "roles" => [Puesto::Empleado]
      ];
    }


    if ($this->esGerente()) {

      $rutas[] = (object)  [
        "url" =>  route('SolicitudFondos.Gerente.Listar'),
        "label" => " Aprobar Solicitudes",
        "icon_class" => "fas fa-tasks",
        "roles" => [Puesto::Gerente]
      ];
      $rutas[] = (object)  [
        "url" => route('RendicionGastos.Gerente.Listar'),
        "label" => "Aprobar Rendiciones",
        "icon_class" => "fas fa-tasks",
        "roles" => [Puesto::Gerente]
      ];
      $rutas[] = (object)  [
        "url" => route('ReposicionGastos.Gerente.Listar'),
        "label" => "Aprobar Reposiciones",
        "icon_class" => "fas fa-tasks",
        "roles" => [Puesto::Gerente]
      ];
      $rutas[] = (object)  [
        "url" => route('RequerimientoBS.Gerente.Listar'),
        "label" => "Aprobar Requerimientos",
        "icon_class" => "fas fa-tasks",
        "roles" => [Puesto::Gerente]
      ];


      $rutas[] = (object)  [
        "url" => route('GestionProyectos.VerDashboard'),
        "label" => "Dashboard",
        "icon_class" => "fas fa-chart-line",
        "roles" => [Puesto::Gerente]
      ];
    }


    if ($this->esAdministrador()) {
      $rutas[] = (object)  [
        "url" => route('SolicitudFondos.Administracion.Listar'),
        "label" => "Abonar Solicitudes",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Administrador]
      ];
      $rutas[] = (object)  [
        "url" => route('RendicionGastos.Administracion.Listar'),
        "label" => "Observar Rendiciones",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Administrador]
      ];
      $rutas[] = (object)  [
        "url" => route('ReposicionGastos.Administracion.Listar'),
        "label" => "Abonar Reposiciones",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Administrador]
      ];
      $rutas[] = (object)  [
        "url" => route('RequerimientoBS.Administrador.Listar'),
        "label" => "Atender Requerimientos",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Administrador]
      ];
      $rutas[] = (object)  [
        "url" => route('OrdenCompra.Empleado.Listar'),
        "label" => "Orden de Compra",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Administrador]
      ];

      $rutas[] = (object)  [
        "url" => route('ConstanciaDepositoCTS.Listar'),
        "label" => "Const Deposito CTS",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Administrador]
      ];


      $rutas[] = (object)  [
        "url" => route('ContratosLocacion.Listar'),
        "label" => "Contratos Locacion Serv ",
        "icon_class" => "fas fa-file-signature",
        "roles" => [Puesto::Administrador]
      ];
      $rutas[] = (object)  [
        "url" => route('ContratosPlazo.Listar'),
        "label" => "Contr Planilla",
        "icon_class" => "fas fa-file-signature",
        "roles" => [Puesto::Administrador]
      ];
      $rutas[] = (object)  [
        "url" => route('ContratosPlazoNuevo.Listar'),
        "label" => "Contr Planilla Nuevo",
        "icon_class" => "fas fa-file-signature",
        "roles" => [Puesto::Administrador]
      ];
    }


    if ($this->esContador()) {

      $rutas[] = (object)  [
        "url" => route('SolicitudFondos.Contador.Listar'),
        "label" => "Solicitudes",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Contador]
      ];
      $rutas[] = (object)  [
        "url" => route('RendicionGastos.Contador.Listar'),
        "label" => "Rendiciones",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Contador]
      ];
      $rutas[] = (object)  [
        "url" => route('ReposicionGastos.Contador.Listar'),
        "label" => "Reposiciones",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Contador]
      ];
      $rutas[] = (object)  [
        "url" => route('RequerimientoBS.Contador.Listar'),
        "label" => "Requerimientos",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Contador]
      ];
      $rutas[] = (object)  [
        "url" => route('OrdenCompra.Empleado.Listar'),
        "label" => "Orden de Compra",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Contador]
      ];


      $rutas[] = (object)  [
        "url" => route('ConstanciaDepositoCTS.Listar'),
        "label" => "Const Deposito CTS",
        "icon_class" => "fas fa-file-pdf",
        "roles" => [Puesto::Contador]
      ];
    }



    if ($this->esObservador()) {
      $rutas[] = (object)  [
        "url" => route('SolicitudFondos.Observador.Listar'),
        "label" => "Solicitudes",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Observador]
      ];
      $rutas[] = (object)  [
        "url" => route('RendicionGastos.Observador.Listar'),
        "label" => "Rendiciones",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Observador]
      ];
      $rutas[] = (object)  [
        "url" => route('ReposicionGastos.Observador.Listar'),
        "label" => "Reposiciones",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Observador]
      ];
      $rutas[] = (object)  [
        "url" => route('RequerimientoBS.Observador.Listar'),
        "label" => "Requerimientos",
        "icon_class" => "far fa-file-alt",
        "roles" => [Puesto::Observador]
      ];
      $rutas[] = (object)  [
        "url" => route('GestionProyectos.VerDashboard'),
        "label" => "Dashboard",
        "icon_class" => "fas fa-chart-pie",
        "roles" => [Puesto::Observador]
      ];
    }





    if ($this->esAprobadorViajes()) {
      $rutas[] = (object)  [
        "url" => route('ViajeVehiculo.Aprobador.Listar'),
        "label" => "Aprobar viajes",
        "icon_class" => "fas fa-route",
        "roles" => [Puesto::AprobadorViajes]
      ];
      $rutas[] = (object)  [
        "url" => route('Vehiculo.Listar'),
        "label" => "Vehículos",
        "icon_class" => "far fa-truck-pickup",
        "roles" => [Puesto::AprobadorViajes]
      ];
    }


    if ($this->esConductor()) {
      $rutas[] = (object)  [
        "url" => route('ViajeVehiculo.Conductor.Listar'),
        "label" => "Mis viajes",
        "icon_class" => "fas fa-route",
        "roles" => [Puesto::Conductor]
      ];
    }

    if ($this->esContador()) {
      $rutas[] = (object)  [
        "url" => route('ViajeVehiculo.Contador.Listar'),
        "label" => "Viajes - Contador",
        "icon_class" => "fas fa-route",
        "roles" => [Puesto::Contador]
      ];
    }





    return $rutas;
  }
}
