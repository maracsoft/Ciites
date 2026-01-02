<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Caja;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Proyecto extends MaracModel
{
  public $table = "proyecto";
  protected $primaryKey = "codProyecto";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = [
    'codProyecto',
    'codigoPresupuestal',
    'nombre',
    'codEmpleadoDirector',
    'codSedePrincipal',
    'nombreLargo',
    'codEntidadFinanciera',
    'codPEI',
    'objetivoGeneral',
    'fechaInicio',
    'importePresupuestoTotal',
    'codMonedaPresupuestoTotal',
    'importeContrapartidaCedepas',
    'codMonedaContrapartidaCedepas',
    'importeContrapartidaPoblacionBeneficiaria',
    'codMonedaContrapartidaPoblacionBeneficiaria',
    'importeContrapartidaOtros',
    'codMonedaContrapartidaOtros',
    'codTipoFinanciamiento'
  ];

  public static function añadirNombreYcod(Collection $listaProyectos): Collection
  {


    foreach ($listaProyectos as $proy) {
      $proy['nombreYcod'] = "[" . $proy->codigoPresupuestal . "] " . $proy->nombre;
    }
    return $listaProyectos;
  }



  public function setDataFromRequest(Request $request)
  {
    $this->codigoPresupuestal = $request->codigoPresupuestal;
    $this->nombre = $request->nombre;
    $this->nombreLargo = $request->nombreLargo;
    $this->codEmpleadoDirector = $request->codEmpleadoDirector;
    $this->codSedePrincipal = $request->codSedePrincipal;
  }



  public function getLugaresEjecucion()
  {
    return LugarEjecucion::where('codProyecto', '=', $this->codProyecto)->get();
  }



  public function getOrigenYNombre()
  {
    return "[" . $this->codigoPresupuestal . "] " . $this->nombre;
  }


  //si el empleado que se manda tiene asignado este proyecto, retorna checked
  public function getCheckedSiTieneContador($codEmpleadoContador)
  {
    if ($this->getTieneAContador($codEmpleadoContador))
      return "checked";

    return "";
  }

  //si el empleado que se manda tiene asignado este proyecto, retorna checked
  public function getCheckedSiTieneObservador($codEmpleado)
  {
    if ($this->getTieneAObservador($codEmpleado))
      return "checked";

    return "";
  }



  public function getTieneAContador($codEmpleadoContador)
  {
    $lista = ProyectoContador::where('codProyecto', '=', $this->codProyecto)
      ->where('codEmpleadoContador', '=', $codEmpleadoContador)->get();

    return count($lista) > 0;
  }


  public function getTieneAObservador($codEmpleado)
  {
    $lista = ProyectoObservador::where('codProyecto', '=', $this->codProyecto)->where('codEmpleadoObservador', '=', $codEmpleado)->get();

    return count($lista) > 0;
  }


  public static function getCodEstado($nombreEstado)
  {
    $lista = EstadoProyecto::where('nombre', '=', $nombreEstado)->get();
    if (count($lista) == 0)
      throw new Exception("Modelo Proyecto:: getCodEstado, no se encontró un estado con este nombre.", 1);


    $estado = $lista[0];
    return $estado->codEstadoProyecto;
  }

  /* Si el proyecto no se puede editar, retorna "readonly" */
  public function getReadonly()
  {
    if (!$this->sePuedeEditar())
      return "readonly";

    return "";
  }

  //se puede editar si esta en estado "En Registro" y la persona que lo esta viendo es UGE
  public function sePuedeEditar()
  {

    return $this->verificarEstado('En Registro') && Empleado::getEmpleadoLogeado()->esUGE();
  }
  public function enEjecucion()
  {
    return $this->verificarEstado('En Ejecucion');
  }

  public function estaFinalizado()
  {/* En este estado, el proyecto ya no está activo */
    return $this->verificarEstado('Finalizado');
  }

  public function estaActivo()
  {

    return !$this->estaFinalizado();
  }

  public static function findByCodigoPresupuestal($codigo): Proyecto
  {
    $search = Proyecto::where('codigoPresupuestal', '=', $codigo)->where('codEstadoProyecto', '!=', 3)->get();
    if (count($search) == 0) {
      throw new Exception("No hay ningun proyecto con codigo presupuestal $codigo");
    }

    return $search[0];
  }


  public function verificarEstado($estado)
  {

    return $this->getEstado()->nombre == $estado;
  }


  public function getEstado()
  {
    return EstadoProyecto::findOrFail($this->codEstadoProyecto);
  }

  public function getAñoInicio()
  {
    return  date('Y', strtotime($this->fechaInicio));
  }

  public function getFechaInicio()
  {
    return Fecha::formatoParaVistas($this->fechaInicio);
  }
  public function getFechaFinalizacion()
  {
    return Fecha::formatoParaVistas($this->fechaFinalizacion);
  }

  // le entra string "dias" o "meses" o "años"
  public function getDuracion($tipo, bool $agregado)
  {
    //agregado = true -> retorna la cantidad neta agregada (por ejemplo, 3 años 3 meses 5 días)
    //agregado = false -> retorna las cantidades desagregadas (por ejemplo 3 años, 39 meses, 1190 dias )

    $date1 = new DateTime($this->fechaInicio);
    $date2 = new DateTime($this->fechaFinalizacion);
    $diff = $date1->diff($date2);
    $vectorDif = json_decode(json_encode($diff), true);
    /* diff es:
            {
                "y":1,"m":0,"d":1,"h":0,"i":0,"s":0,"f":0,"weekday":0,"weekday_behavior":0,
            "first_last_day_of":0,"invert":0,"days":367,"special_type":0,"special_amount":0,
            "have_weekday_relative":0,"have_special_relative":0
            }

        */

    switch ($tipo) {
      case "dias":
        if ($agregado)
          $retorno = $vectorDif['d'];
        else
          $retorno = 365 * $vectorDif['y'] + 30 * $vectorDif['m'] + $vectorDif['d'];;
        break;
      case "meses":
        if ($agregado)
          $retorno = $vectorDif['m'];
        else
          $retorno = $vectorDif['y'] * 12 + $vectorDif['m'];
        break;
      case "años":
        $retorno = $vectorDif['y'];
        break;
    }
    settype($retorno, "integer");

    return $retorno;
  }




  public function getMoneda()
  {
    return Moneda::findOrFail($this->codMoneda);
  }


  public function getSede()
  {
    return Sede::findOrFail($this->codSedePrincipal);
  }




  //obtiene el siguiente nombre de guardado disponible para un archivo que se creará
  public function getNombreGuardadoNuevoArchivo($indice)
  {
    //FORMATO PARA NOMBRE DE GUARDADO
    //ArchProy-000000-00.marac
    $nombre = "ArchProy-" . Debug::rellernarCerosIzq($this->codProyecto, 6) . "-" . Debug::rellernarCerosIzq($indice, 2) . ".marac";
    return $nombre;
  }

  public function getListaArchivos()
  {
    return ArchivoProyecto::where('codProyecto', '=', $this->codProyecto)->get();
  }

  public function getCantidadArchivos()
  {

    return count($this->getListaArchivos());
  }

  //borra los archivos del proyecto
  public function eliminarArchivos()
  {



    foreach ($this->getListaArchivos() as $itemArchivo) {
      $nombre = $itemArchivo->nombreDeGuardado;
      Storage::disk('proyectos')->delete($nombre);
      Debug::mensajeSimple('Se acaba de borrar el archivo:' . $nombre);
    }
    ArchivoProyecto::where('codProyecto', '=', $this->codProyecto)->delete();
  }


  public function getGerente()
  {
    return Empleado::findOrFail($this->codEmpleadoDirector);
  }

  public function getNombreCompletoGerente()
  {
    $empleado = Empleado::where('codEmpleado', '=', $this->codEmpleadoDirector)->get();
    if (count($empleado) != 1) {
      return "*No definido*";
    } else {
      return $empleado[0]->nombres . ' ' . $empleado[0]->apellidos;
    }
  }




  public static function getProyectosActivos()
  {
    //return Proyecto::All();
    $lista = Proyecto::where('codEstadoProyecto', '!=', '3')
      ->orderBy('codigoPresupuestal', 'ASC')
      ->get();

    foreach ($lista as $proy) {
      $proy['nombreYcod'] = "[" . $proy->codigoPresupuestal . "] " . $proy->nombre;
    }

    return $lista;
  }

  public function getContadores()
  {
    $detalles = ProyectoContador::where('codProyecto', '=', $this->codProyecto)->get();
    $arr = [];
    foreach ($detalles as $itemdetalle) {
      $arr[] = $itemdetalle->codEmpleadoContador;
    }
    return Empleado::whereIn('codEmpleado', $arr)->get();
  }

  public function nroContadores()
  {
    $detalles = ProyectoContador::where('codProyecto', '=', $this->codProyecto)->get();
    return count($detalles);
  }

  public function evaluador()
  {
    $empleado = Empleado::find($this->codEmpleadoDirector);
    return $empleado;
  }







  //retorna una lista con los contadores del proyecto
  public function getListaContadores()
  {
    $listaRelaciones = ProyectoContador::where('codProyecto', '=', $this->codProyecto)->get();
    $listaContadores = new Collection();

    foreach ($listaRelaciones as $relacion) {
      $empleadoContador = $relacion->getContador();
      $listaContadores->push($empleadoContador);
    }
    return $listaContadores;
  }







  //mes (1-12) y año entran como numeros
  public function calcularReposicionesEmitidasEnMesAño($mes, $año)
  {

    $listaRepos = ReposicionGastos::where('codProyecto', '=', $this->codProyecto)
      ->whereMonth('fechaHoraEmision', '=', $mes)
      ->whereYear('fechaHoraEmision', '=', $año)
      ->get();
    return count($listaRepos);
  }
  public function calcularReposicionesRechazadasEnMesAño($mes, $año)
  {

    $listaRepos = ReposicionGastos::where('codProyecto', '=', $this->codProyecto)
      ->whereMonth('fechaHoraEmision', '=', $mes)
      ->whereYear('fechaHoraEmision', '=', $año)
      ->where('codEstadoReposicion', '=', ReposicionGastos::getCodEstado('Rechazada'))
      ->get();
    return count($listaRepos);
  }




  public function calcularImporteMesAñoBanco($mes, $año, $codBanco, $codMoneda)
  {
    $codP = $this->codProyecto;
    $sql = "
            select sum(totalImporte) as 'Suma'
            from reposicion_gastos R
            where
                codProyecto = '$codP' and
                month(R.fechaHoraEmision) = '$mes' and
                year(R.fechaHoraEmision) = '$año' and
                codMoneda = '$codMoneda' and
                codBanco = '$codBanco'
        ";


    $respuesta = DB::select($sql);

    return number_format($respuesta[0]->Suma, 2);
  }
}
