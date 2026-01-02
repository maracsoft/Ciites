<?php

namespace App;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;


//START MODEL_HELPER
/**
 * @property int $codRendicionGastos int(11)     
 * @property int $codSolicitud int(11)     
 * @property int $codMoneda int(11)     
 * @property string $codigoCedepas varchar(50)     
 * @property float $totalImporteRecibido float NULLABLE    
 * @property float $totalImporteRendido float NULLABLE    
 * @property float $saldoAFavorDeEmpleado float NULLABLE    
 * @property string $resumenDeActividad varchar(350)     
 * @property int $codEstadoRendicion int(11)     
 * @property string $fechaHoraRendicion datetime NULLABLE    
 * @property string $fechaHoraRevisado datetime NULLABLE    
 * @property string $observacion varchar(500) NULLABLE    
 * @property int $codEmpleadoSolicitante int(11)     
 * @property int $codEmpleadoEvaluador int(11) NULLABLE    
 * @property int $codEmpleadoContador int(11) NULLABLE    
 * @property int $cantArchivos int(11) NULLABLE    
 * @property string $terminacionesArchivos varchar(200) NULLABLE    
 * @property int $codProyecto int(11)     
 * @property string $codigoContrapartida varchar(200) NULLABLE    
 * @method static RendicionGastos findOrFail($primary_key)
 * @method static RendicionGastos | null find($primary_key)
 * @method static RendicionGastosCollection all()
 * @method static \App\Builders\RendicionGastosBuilder query()
 * @method static \App\Builders\RendicionGastosBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\RendicionGastosBuilder where(string $column,string $value)
 * @method static \App\Builders\RendicionGastosBuilder whereNotNull(string $column) 
 * @method static \App\Builders\RendicionGastosBuilder whereNull(string $column) 
 * @method static \App\Builders\RendicionGastosBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\RendicionGastosBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class RendicionGastos extends DocumentoAdministrativo
{
  public $table = "rendicion_gastos";
  protected $primaryKey = "codRendicionGastos";

  const raizArchivo = "RendGast-CDP-";
  const RaizCodigoCedepas = "REN";
  const codTipoDocumento = "2";

  public $timestamps = false;  //para que no trabaje con los campos fecha


  // le indicamos los campos de la tabla
  protected $fillable = [
    'codSolicitud',
    'codigoCedepas',
    'totalImporteRecibido',
    'totalImporteRendido',
    'saldoAFavorDeEmpleado',
    'resumenDeActividad',
    'codEstadoRendicion',
    'fechaHoraRendicion',
    'cantArchivos',
    'terminacionesArchivos',
    'codEmpleadoEvaluador'
  ];

  //esto es para el historial de operaciones
  public function getVectorDocumento()
  {
    return [
      'codTipoDocumento' => RendicionGastos::codTipoDocumento,
      'codDocumento' => $this->codRendicionGastos
    ];
  }

  public function getDetalles()
  {
    return DetalleRendicionGastos::where('codRendicionGastos', '=', $this->codRendicionGastos)
      ->get();
  }

  /** FORMATO PARA FECHAS*/
  public function formatoFechaHoraRendicion()
  {
    if (is_null($this->fechaHoraRendicion))
      return "";

    $fecha = date('d/m/Y H:i:s', strtotime($this->fechaHoraRendicion));
    return $fecha;
  }

  public function getFechaHoraUltimaEdicion()
  {
    $tipo_documento = TipoDocumento::where('abreviacion', 'REN')->first();
    $tipo_operacion = TipoOperacion::where('codTipoDocumento', $tipo_documento->getId())->where('nombre', 'Editar')->first();

    $listaOperacionesEdicion = OperacionDocumento::where('codDocumento', $this->getId())
      ->where('codTipoDocumento', $tipo_documento->getId())
      ->where('codTipoOperacion', $tipo_operacion->getId())
      ->orderBy('fechaHora', 'DESC')
      ->get();

    /* en algunos casos los documentos no tienen ni operaciones */
    if (count($listaOperacionesEdicion) == 0) {
      return $this->formatoFechaHoraRendicion();
    }

    $ultima_operacion_edicion = $listaOperacionesEdicion[0];
    return Fecha::formatoFechaHoraParaVistas($ultima_operacion_edicion->fechaHora);
  }


  public function formatoFechaHoraRevisionGerente()
  {

    if (is_null($this->fechaHoraRevisado))
      return "";

    $fecha = date('d/m/Y H:i:s', strtotime($this->fechaHoraRevisado));
    return $fecha;
  }

  public function getResumenAbreviado()
  {
    return Debug::abreviar($this->resumenDeActividad, 60);
  }

  //si está en esos estados retorna la obs, sino retorna ""
  public function getObservacionONull()
  {
    if ($this->verificarEstado('Observada') || $this->verificarEstado('Subsanada'))
      return ": " . $this->observacion;

    return "";
  }


  //ESTAS FUNCIONES DEBEN SER BORRADAS, PQ MUESTRAN LA HORA EN EL FORMATO INCORRECTO XD


  /* AQUI AÑADIR CODIGOS RGB DE LA MARSKY */
  function getColorSaldo()
  {
    if ($this->getSaldoFavorCedepas() > 0)
      return "rgb(0, 167, 14)";
    else
      return "red";
  }


  public static function calcularCodigoCedepas($objNumeracion)
  {
    return  RendicionGastos::RaizCodigoCedepas .
      substr($objNumeracion->año, 2, 2) .
      '-' .
      RendicionGastos::rellernarCerosIzq($objNumeracion->numeroLibreActual, 6);
  }


  public function borrarArchivosCDP()
  { //borra todos los archivos que sean de esa rendicion
    foreach ($this->getListaArchivos() as $itemArchivo) {
      $nombre = $itemArchivo->nombreDeGuardado;
      Storage::disk('rendiciones')->delete($nombre);
      Debug::mensajeSimple('Se acaba de borrar el archivo:' . $nombre);
    }
    return ArchivoRendicion::where('codRendicionGastos', '=', $this->codRendicionGastos)->delete();
  }

  public function getListaArchivos()
  {

    return ArchivoRendicion::where('codRendicionGastos', '=', $this->codRendicionGastos)->get();
  }

  public function getCantidadArchivos()
  {
    return count($this->getListaArchivos());
  }



  //               RendGast-CDP-   000002                           -   5   .  jpg
  public static function getFormatoNombreCDP($codRendicionGastos, $i, $terminacion)
  {
    return  RendicionGastos::raizArchivo .
      RendicionGastos::rellernarCerosIzq($codRendicionGastos, 6) .
      '-' .
      RendicionGastos::rellernarCerosIzq($i, 2) .
      '.' .
      $terminacion;
  }


  public function getNombreGuardadoNuevoArchivo($j)
  {
    return  RendicionGastos::raizArchivo .
      RendicionGastos::rellernarCerosIzq($this->codRendicionGastos, 6) .
      '-' .
      RendicionGastos::rellernarCerosIzq($j, 2) .
      '.marac';
  }

  //retorna vector de strings
  public function getVectorTerminaciones()
  {
    return explode('/', $this->terminacionesArchivos);
  }

  //la primera es la 1 OJO
  public function getTerminacionNro($index)
  {
    $vector = explode('/', $this->terminacionesArchivos);
    return $vector[$index - 1];
  }

  public static function rellernarCerosIzq($numero, $nDigitos)
  {
    return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
  }


  public function getPDF()
  {
    $listaItems = DetalleRendicionGastos::where('codRendicionGastos', '=', $this->codRendicionGastos)->get();


    $pdf = \PDF::loadview(
      'RendicionGastos.PdfRendicionGastos',
      array('rendicion' => $this, 'listaItems' => $listaItems)
    )->setPaper('a4', 'portrait');
    return $pdf;
  }

  public function getNombreEvaluador()
  {
    if (is_null($this->codEmpleadoEvaluador))
      return "";

    $ev = Empleado::findOrFail($this->codEmpleadoEvaluador);
    return $ev->getNombreCompleto();
  }


  /* Retorna el codigo del estado indicado por el str parametro */
  public static function getCodEstado($nombreEstado)
  {
    $lista = EstadoRendicionGastos::where('nombre', '=', $nombreEstado)->get();
    if (count($lista) == 0)
      return 'Nombre no valido';

    return $lista[0]->codEstadoRendicion;
  }

  public function getEstado()
  {
    return EstadoRendicionGastos::findOrFail($this->codEstadoRendicion);
  }

  public function setEstado($codEstado)
  {
    $this->codEstadoRendicion = $codEstado;
    $this->save();
  }


  /* Retorna TRUE or FALSE cuando le mandamos el nombre de un estado */
  public function verificarEstado($nombreEstado)
  {
    $lista = EstadoRendicionGastos::where('nombre', '=', $nombreEstado)->get();
    if (count($lista) == 0)
      return false;
    $estado = $lista[0];
    if ($estado->codEstadoRendicion == $this->codEstadoRendicion)
      return true;

    return false;
  }

  public function listaParaAprobar()
  {
    return $this->verificarEstado('Creada') ||
      $this->verificarEstado('Subsanada');
  }



  public function listaParaActualizar()
  {
    return $this->verificarEstado('Creada') ||
      $this->verificarEstado('Observada') ||
      $this->verificarEstado('Subsanada');
  }


  public function listaParaObservar()
  {
    return $this->verificarEstado('Creada') ||
      $this->verificarEstado('Aprobada') ||
      $this->verificarEstado('Subsanada');
  }

  public function listaParaContabilizar()
  {
    return $this->verificarEstado('Aprobada');
  }

  public function getProyecto()
  {

    return $this->getSolicitud()->getProyecto();
  }


  /* Como todo el sistema de rendiciones lo hice con el paradigma de que el
    saldo a favor del empleado debia mostrarse y ya hay datos en la BD,
    ahora que me dicen que en realidad es el a favor de cedepas, usaré esta funcion para des hacer la resta

    */
  public function getSaldoFavorCedepas()
  {
    return (-1) * $this->saldoAFavorDeEmpleado;
  }

  public function getNombreSolicitante()
  {
    return $this->getSolicitud()->getNombreSolicitante();
  }
  public function getEmpleadoSolicitante()
  {
    return $this->getSolicitud()->getEmpleadoSolicitante();
  }

  public function getNombreProyecto()
  {
    return $this->getSOlicitud()->getNombreProyecto();
  }



  //VER EXCEL https://docs.google.com/spreadsheets/d/1eBQV5QZJ6dTlFtu-PuF3i71Cjg58DIbef2qI0ZqKfoI/edit#gid=1819929291
  public function getNombreEstado()
  {
    $estado = EstadoRendicionGastos::findOrFail($this->codEstadoRendicion);
    if ($estado->nombre == "Creada")
      return "Por Aprobar";
    return $estado->nombre;
  }





  //ingresa una coleccion y  el codEstadoSolicitud y retorna otra coleccion  con los elementos de esa coleccion que están en ese estado
  public static function separarDeColeccion($coleccion, $codEstadoRendicion)
  {
    $listaNueva = new Collection();
    foreach ($coleccion as $item) {
      if ($item->codEstadoRendicion == $codEstadoRendicion)
        $listaNueva->push($item);
    }
    return $listaNueva;
  }




  // Observadas -> Subsanadas-> creadas -> Aprobadas -> Contabilizadas -> rechazadas -> canceladas
  public static function ordenarParaEmpleado(Builder $queryBuilder): Collection
  {

    $queryBuilder = $queryBuilder->join('estado_rendicion_gastos', 'estado_rendicion_gastos.codEstadoRendicion', '=', 'rendicion_gastos.codEstadoRendicion')
      ->orderBy('ordenListadoEmpleado', 'ASC')->orderBy('codRendicionGastos', 'DESC');

    return $queryBuilder->get();
  }


  //Creadas -> Subsanadas -> Aprobadas -> Contabilizadas
  public static function ordenarParaGerente(Builder $queryBuilder): Collection
  {
    $queryBuilder = $queryBuilder->join('estado_rendicion_gastos', 'estado_rendicion_gastos.codEstadoRendicion', '=', 'rendicion_gastos.codEstadoRendicion')
      ->orderBy('ordenListadoGerente', 'ASC')->orderBy('codRendicionGastos', 'DESC');

    return $queryBuilder->get();
  }


  public static function ordenarParaContador(Builder $queryBuilder): Collection
  {

    $queryBuilder = $queryBuilder->join('estado_rendicion_gastos', 'estado_rendicion_gastos.codEstadoRendicion', '=', 'rendicion_gastos.codEstadoRendicion')
      ->orderBy('ordenListadoContador', 'ASC')->orderBy('codRendicionGastos', 'DESC');

    return $queryBuilder->get();
  }













  public function getMensajeEstado()
  {
    $mensaje = '';
    switch ($this->codEstadoRendicion) {
      case $this::getCodEstado('Creada'):
        $mensaje = 'La rendición está a espera de ser aprobada por el responsable del proyecto.';
        break;
      case $this::getCodEstado('Aprobada'):
        $mensaje = 'La rendición está a espera de ser contabilizada.';
        break;
      case $this::getCodEstado('Contabilizada'):
        $mensaje = 'El flujo de la Rendición ha finalizado.';
        break;
      case $this::getCodEstado('Observada'):
        $mensaje = 'La rendición tiene algún error y fue observada.';
        break;
      case $this::getCodEstado('Subsanada'):
        $mensaje = 'La observación de la rendición ya fue corregida por el empleado.';
        break;
      case $this::getCodEstado('Rechazada'):
        $mensaje = 'La rendición fue rechazada por algún responsable, el flujo ha terminado.';
        break;
      case $this::getCodEstado('Cancelada'):
        $mensaje = 'La rendición fue cancelada por el mismo empleado que la realizó.';
        break;
    }
    return $mensaje;
  }


  public function getColorEstado()
  { //BACKGROUND
    $color = '';
    switch ($this->codEstadoRendicion) {
      case $this::getCodEstado('Creada'):
        $color = 'rgb(255,193,7)';
        break;
      case $this::getCodEstado('Aprobada'):
        $color = 'rgb(0,154,191)';
        break;
      case $this::getCodEstado('Contabilizada'):
        $color = 'rgb(40,167,69)';
        break;
      case $this::getCodEstado('Observada'):
        $color = 'rgb(244,246,249)';
        break;
      case $this::getCodEstado('Subsanada'):
        $color = 'rgb(68,114,196)';
        break;
      case $this::getCodEstado('Rechazada'):
        $color = 'rgb(192,0,0)';
        break;
    }
    return $color;
  }

  public function getColorLetrasEstado()
  {
    $color = '';
    switch ($this->codEstadoRendicion) {
      case $this::getCodEstado('Creada'):
        $color = 'black';
        break;
      case $this::getCodEstado('Aprobada'):
        $color = 'white';
        break;
      case $this::getCodEstado('Contabilizada'):
        $color = 'white';
        break;
      case $this::getCodEstado('Observada'):
        $color = 'black';
        break;
      case $this::getCodEstado('Subsanada'):
        $color = 'white';
        break;
      case $this::getCodEstado('Rechazada'):
        $color = 'white';
        break;
    }
    return $color;
  }

  public function getMoneda()
  {
    return $this->getSolicitud()->getMoneda();
  }

  public function getSolicitud()
  {
    return SolicitudFondos::findOrFail($this->codSolicitud);
  }




  /**ESCRIBIR NUMEROSSSSS */
  function escribirImporteRecibido()
  {
    return Numeros::escribirNumero($this->totalImporteRecibido);
  }
  function escribirImporteRendido()
  {
    return Numeros::escribirNumero($this->totalImporteRendido);
  }


  public static function getDashboardInfo(array $codsProyectos)
  {
    $today = date('Y-m-d') . " 00:00:00";
    $date_sup_limit = date('Y-m-d') . " 23:59:59";
    $last_monday = date('Y-m-d', strtotime('-1 Monday')) . " 00:00:00";
    $first_day_month = date('Y-m-') . "01 00:00:00";
    $oneMonthAgo = Fecha::getFechaActualMenosXDias(30);
    $codsProyectosImploted = implode(",", $codsProyectos);


    $cant_emitidos_dia = RendicionGastos::whereIn('codProyecto', $codsProyectos)->where('fechaHoraRendicion', '>=', $today)->count();
    $cant_emitidos_semana = RendicionGastos::whereIn('codProyecto', $codsProyectos)->where('fechaHoraRendicion', '>=', $last_monday)->count();
    $cant_emitidos_mes = RendicionGastos::whereIn('codProyecto', $codsProyectos)->where('fechaHoraRendicion', '>=', $first_day_month)->count();

    $cant_aprobados_dia = 0;
    $cant_aprobados_semana = 0;
    $cant_aprobados_mes = 0;


    $diasExistentesSQL = Fecha::getSQLFechasExistentes($oneMonthAgo, $date_sup_limit);

    $emitidos_sql = "
        SELECT
            COUNT(codRendicionGastos) as cantidad_docs,
            SUM(totalImporteRendido) as monto_total,
            CAST(fechaHoraRendicion as Date) as fecha
        FROM rendicion_gastos
        WHERE codProyecto IN ($codsProyectosImploted)
            AND fechaHoraRendicion >= '$oneMonthAgo'
            GROUP BY cast(fechaHoraRendicion as Date)
            ORDER BY fecha
      ";


    $final_sql = "
        SELECT
          dias_existentes.fecha,
          IFNULL(emitidos.cantidad_docs,0) as cantidad_docs,
          ROUND(IFNULL(emitidos.monto_total,0),2) as monto_total

        FROM ($emitidos_sql) emitidos
        RIGHT JOIN ($diasExistentesSQL) dias_existentes on emitidos.fecha = dias_existentes.fecha
      ";


    $cant_emitidos_historico = DB::select($final_sql);


    $REN =  compact(
      'cant_emitidos_dia',
      'cant_emitidos_semana',
      'cant_emitidos_mes',
      'cant_aprobados_dia',
      'cant_aprobados_semana',
      'cant_aprobados_mes',
      'cant_emitidos_historico'
    );

    return $REN;
  }


  /* Convierte el objeto en un vector con elementos leibles directamente por la API */
  public function getVectorParaAPI()
  {
    $itemActual = $this;
    $solicitud = $this->getSolicitud();

    $itemActual['codigoYproyecto'] = $solicitud->getProyecto()->getOrigenYNombre();
    $itemActual['montoRendido'] = $this->getSolicitud()->getMoneda()->simbolo . " " . $this->totalImporteRendido;
    $itemActual['nombreEstado'] = $this->getEstado()->nombre;
    $itemActual['nombreEmisor'] = $this->getEmpleadoSolicitante()->getNombreCompleto();
    $itemActual['codigoEmpleadoEmisor'] = $this->getEmpleadoSolicitante()->codigoCedepas;


    $itemActual['codigoCedepasSolicitud'] = $this->getSolicitud()->codigoCedepas;
    $itemActual['colorFondo'] = $this->getColorEstado();
    $itemActual['colorLetras'] = $this->getColorLetrasEstado();
    $itemActual['simboloMoneda'] = $solicitud->getMoneda()->simbolo;
    $itemActual['fechaHoraRendicion'] = $this->formatoFechaHoraRendicion();

    $itemActual['montoRecibido'] = $this->getSolicitud()->getMoneda()->simbolo . " " . $this->totalImporteRecibido;


    return $itemActual;
  }

  public function getDetallesParaAPI()
  {
    $listaDetalles = $this->getDetalles();
    $listaPreparada = [];
    foreach ($listaDetalles as $det) {
      $listaPreparada[] = $det->getVectorParaAPI();
    }
    return $listaPreparada;
  }
}
