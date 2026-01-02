<?php

namespace App;

use App\Utils\Debug;
use App\Utils\DocumentoAdministrativo;
use App\Utils\Fecha;
use App\Utils\MaracUtils;
use App\Utils\Numeros;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
//START MODEL_HELPER

/**
 * @property int $codSolicitud int(11)
 * @property int $codProyecto int(11)
 * @property string $codigoCedepas varchar(200)
 * @property int $codEmpleadoSolicitante int(11)
 * @property string $fechaHoraEmision datetime
 * @property float $totalSolicitado float NULLABLE
 * @property string $girarAOrdenDe varchar(200)
 * @property string $numeroCuentaBanco varchar(200)
 * @property int $codBanco int(11)
 * @property string $justificacion varchar(350) NULLABLE
 * @property int $codEmpleadoEvaluador int(11) NULLABLE
 * @property string $fechaHoraRevisado datetime NULLABLE
 * @property int $codEstadoSolicitud int(11)
 * @property string $fechaHoraAbonado datetime NULLABLE
 * @property string $observacion varchar(300) NULLABLE
 * @property string $terminacionArchivo varchar(10) NULLABLE
 * @property int $codEmpleadoAbonador int(11) NULLABLE
 * @property int $estaRendida int(11) NULLABLE
 * @property int $codEmpleadoContador int(11) NULLABLE
 * @property int $codMoneda int(11)
 * @property string $codigoContrapartida varchar(200) NULLABLE
 * @method static SolicitudFondos findOrFail($primary_key)
 * @method static SolicitudFondos | null find($primary_key)
 * @method static SolicitudFondosCollection all()
 * @method static \App\Builders\SolicitudFondosBuilder query()
 * @method static \App\Builders\SolicitudFondosBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\SolicitudFondosBuilder where(string $column,string $value)
 * @method static \App\Builders\SolicitudFondosBuilder whereNotNull(string $column)
 * @method static \App\Builders\SolicitudFondosBuilder whereNull(string $column)
 * @method static \App\Builders\SolicitudFondosBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\SolicitudFondosBuilder orderBy(string $column,array $sentido)
 */
//END MODEL_HELPER
class SolicitudFondos extends DocumentoAdministrativo
{
  public $table = "solicitud_fondos";
  protected $primaryKey = "codSolicitud";

  public $timestamps = false;  //para que no trabaje con los campos fecha

  const RaizCodigoCedepas = "SOF";
  const codTipoDocumento = "1";

  const raizArchivo = "SolFon-";


  // le indicamos los campos de la tabla
  protected $fillable = [
    'codProyecto',
    'codigoCedepas',
    'codEmpleadoSolicitante',
    'fechaHoraEmision',
    'totalSolicitado',
    'girarAOrdenDe',
    'numeroCuentaBanco',
    'codBanco',
    'justificacion',
    'codEmpleadoEvaluador',
    'fechaHoraRevisado',
    'codEstadoSolicitud',
    'observacion',
    'codMoneda'
  ];

  //esto es para el historial de operaciones
  public function getVectorDocumento()
  {
    return [
      'codTipoDocumento' => SolicitudFondos::codTipoDocumento,
      'codDocumento' => $this->codSolicitud
    ];
  }

  public function borrarArchivos()
  {
    foreach ($this->getListaArchivos() as $itemArchivo) {
      $nombre = $itemArchivo->nombreDeGuardado;
      Storage::disk('solicitudes')->delete($nombre);
      Debug::mensajeSimple('Se acaba de borrar el archivo:' . $nombre);
    }
    return ArchivoSolicitud::where('codSolicitud', '=', $this->codSolicitud)->delete();
  }


  public function getCantidadArchivos()
  {
    return count($this->getListaArchivos());
  }
  public function getListaArchivos()
  {

    return ArchivoSolicitud::where('codSolicitud', '=', $this->codSolicitud)->get();
  }

  public function getNombreGuardadoNuevoArchivo($j)
  {
    return  SolicitudFondos::raizArchivo .
      SolicitudFondos::rellernarCerosIzq($this->codSolicitud, 6) .
      '-' .
      SolicitudFondos::rellernarCerosIzq($j, 2) .
      '.marac';
  }

  /** FORMATO PARA FECHAS*/
  public function formatoFechaHoraEmision()
  {
    $fecha = date('d/m/Y H:i:s', strtotime($this->fechaHoraEmision));
    return $fecha;
  }
  public function formatoFechaHoraRevisado()
  {


    if (is_null($this->fechaHoraRevisado))
      return "No revisado";


    $fecha = date('d/m/Y H:i:s', strtotime($this->fechaHoraRevisado));
    return $fecha;
  }
  public function formatoFechaHoraDesembolso()
  {


    if (is_null($this->fechaHoraAbonado))
      return "No abonado";


    $fecha = date('d/m/Y H:i:s', strtotime($this->fechaHoraAbonado));
    return $fecha;
  }


  public function getFechaHoraUltimaEdicion()
  {
    $tipo_documento = TipoDocumento::where('abreviacion', 'SOL')->first();
    $tipo_operacion = TipoOperacion::where('codTipoDocumento', $tipo_documento->getId())->where('nombre', 'Editar')->first();

    $listaOperacionesEdicion = OperacionDocumento::where('codDocumento', $this->getId())
      ->where('codTipoDocumento', $tipo_documento->getId())
      ->where('codTipoOperacion', $tipo_operacion->getId())
      ->orderBy('fechaHora', 'DESC')
      ->get();

    /* en algunos casos los documentos no tienen ni operaciones */
    if (count($listaOperacionesEdicion) == 0) {
      return $this->formatoFechaHoraEmision();
    }

    $ultima_operacion_edicion = $listaOperacionesEdicion[0];
    return Fecha::formatoFechaHoraParaVistas($ultima_operacion_edicion->fechaHora);
  }



  //le pasamos un modelo numeracion y calcula la nomeclatura del cod cedepas SOF21-000001
  public static function calcularCodigoCedepas($objNumeracion)
  {
    return  SolicitudFondos::RaizCodigoCedepas .
      substr($objNumeracion->año, 2, 2) .
      '-' .
      SolicitudFondos::rellernarCerosIzq($objNumeracion->numeroLibreActual, 6);
  }
  public static function rellernarCerosIzq($numero, $nDigitos)
  {
    return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
  }


  public function buildPDF(): Dompdf
  {
    $solicitud = $this;
    $listaItems = $this->getDetalles();

    $html_view = view('SolicitudFondos.Plantillas.PdfSolicitudFondos', compact('solicitud', 'listaItems'))->render();
    $dompdf = MaracUtils::BuildDompdf($html_view);

    return $dompdf;
  }

  public function getPdfName(): string
  {
    return 'Solicitud de fondos ' . $this->codigoCedepas . '.pdf';
  }

  /*
  para frontend, esto hace un echo como tal asi que no es necesario ningun return
  */
  public function getPdf(bool $download)
  {
    $pdf = $this->buildPDF();
    $output = $pdf->output();
    $pdfname = $this->getPdfName();

    return MaracUtils::ResponsePdf($output, $download, $pdfname);
  }

  public function getFilenameWithRoute(): string
  {
    $codigo = $this->codigoCedepas;
    return "/pdfs_regenerados/SOF/$codigo.pdf";
  }

  public function guardarPdfStorage()
  {
    $pdf_binary = $this->buildPDF()->output();
    Storage::put($this->getFilenameWithRoute(), $pdf_binary);
  }

  public function archivoPdfYaExiste(): bool
  {
    return Storage::exists($this->getFilenameWithRoute());
  }





  public function getDetalles()
  {
    return DetalleSolicitudFondos::where('codSolicitud', '=', $this->codSolicitud)->get();
  }
  public function getNombreProyecto()
  {
    $proyecto = Proyecto::findOrFail($this->codProyecto);
    return $proyecto->nombre;
  }
  public function getProyecto()
  {
    $proyecto = Proyecto::findOrFail($this->codProyecto);
    return $proyecto;
  }

  public function getNombreEstado()
  {
    $estado = $this->getEstado();
    if ($estado->nombre == "Creada")
      return "Por Aprobar";
    return $estado->nombre;
  }

  public function getEstado()
  {
    return EstadoSolicitudFondos::findOrFail($this->codEstadoSolicitud);
  }

  public function setEstado($codEstado)
  {
    $this->codEstadoSolicitud = $codEstado;
    $this->save();
  }

  public function getNombreBanco()
  {
    $banco = Banco::findOrFail($this->codBanco);
    return $banco->nombreBanco;
  }

  public function getJustificacionAbreviada()
  {
    return Debug::abreviar($this->justificacion, 60);
  }
  /* Retorna el codigo del estado indicado por el str parametro */
  public static function getCodEstado($nombreEstado)
  {
    $lista = EstadoSolicitudFondos::where('nombre', '=', $nombreEstado)->get();
    if (count($lista) == 0)
      return 'Nombre no valido';

    return $lista[0]->codEstadoSolicitud;
  }


  public function estaRendida()
  {
    return $this->estaRendida == 1;
  }

  public function estaRendidaSIoNo()
  {
    if ($this->estaRendida())
      return "SÍ";

    return "NO";
  }
  /* Retorna TRUE or FALSE cuando le mandamos el nombre de un estado */
  public function verificarEstado($nombreEstado)
  {



    $lista = EstadoSolicitudFondos::where('nombre', '=', $nombreEstado)->get();
    if (count($lista) == 0)
      return false;

    $estado = $lista[0];
    if ($estado->codEstadoSolicitud == $this->codEstadoSolicitud)
      return true;

    return false;
  }


  public function listaParaAprobar()
  {
    return $this->verificarEstado('Creada') || $this->verificarEstado('Subsanada');
  }
  public function listaParaAbonar()
  {
    return $this->verificarEstado('Aprobada');
  }
  public function listaParaContabilizar()
  {
    return $this->verificarEstado('Abonada');
  }
  public function listaParaUpdate()
  {
    return $this->verificarEstado('Creada') ||
      $this->verificarEstado('Subsanada') ||
      $this->verificarEstado('Observada');
  }



  public function listaParaCancelar()
  { //solo en los que no fue abonada
    return
      $this->verificarEstado('Creada') ||
      $this->verificarEstado('Aprobada') ||
      $this->verificarEstado('Observada') ||
      $this->verificarEstado('Subsanada');
  }


  //ENTRA formato MySQL 2020-12-03
  //
  public function getFechaHoraEmision()
  {

    $stringFecha = $this->fechaHoraEmision;

    $nuevaFechaHora = substr($stringFecha, 8, 2) . '/' . substr($stringFecha, 5, 2) . '/' . substr($stringFecha, 0, 4) . ' ' . substr($stringFecha, 11, 8);

    return $nuevaFechaHora;
  }

  public function getNombreSolicitante()
  {
    $emp = Empleado::findOrFail($this->codEmpleadoSolicitante);
    return $emp->nombres . ' ' . $emp->apellidos;
  }

  public function getEmpleadoSolicitante()
  {
    return Empleado::findOrFail($this->codEmpleadoSolicitante);
  }
  public function getBanco()
  {
    return Banco::findOrFail($this->codBanco);
  }
  public function getRendicion()
  {


    $rend = (RendicionGastos::where('codSolicitud', '=', $this->codSolicitud)->get())[0];
    return $rend;
  }

  public function getNombreMoneda()
  {
    $moneda = Moneda::findOrFail($this->codMoneda);
    return $moneda->nombre;
  }

  public function getMoneda()
  {
    $moneda = Moneda::findOrFail($this->codMoneda);
    return $moneda;
  }

  //retorna el objeto empleado del que lo revisó (su director / gerente)
  public function getEvaluador()
  {

    if ($this->codEmpleadoEvaluador == null)
      return "";
    $e = Empleado::findOrFail($this->codEmpleadoEvaluador);
    return $e;
  }



  //si está en esos estados retorna la obs, sino retorna ""
  public function getObservacionONull()
  {
    if ($this->verificarEstado('Observada') || $this->verificarEstado('Subsanada'))
      return ": " . $this->observacion;

    return "";
  }


  public function getMensajeEstado()
  {
    $mensaje = '';
    switch ($this->codEstadoSolicitud) {
      case $this::getCodEstado('Creada'):
        $mensaje = 'La solicitud está a espera de ser aprobada por el responsable del proyecto.';
        break;
      case $this::getCodEstado('Aprobada'):
        $mensaje = 'La solicitud está a espera de ser abonada.';
        break;
      case $this::getCodEstado('Abonada'):
        $mensaje = 'La solicitud está a espera de ser contabilizada.';
        break;

      case $this::getCodEstado('Contabilizada'):
        $mensaje = 'El flujo de la solicitud ha finalizado.';
        break;
      case $this::getCodEstado('Observada'):
        $mensaje = 'La solicitud tiene algún error y fue observada.';
        break;
      case $this::getCodEstado('Subsanada'):
        $mensaje = 'La observación de la solicitud ya fue corregida por el empleado.';
        break;
      case $this::getCodEstado('Rechazada'):
        $mensaje = 'La solicitud fue rechazada por algún responsable, el flujo ha terminado.';
        break;
      case $this::getCodEstado('Cancelada'):
        $mensaje = 'La solicitud fue cancelada por el mismo empleado que la realizó.';
        break;
    }
    return $mensaje;
  }

  public function getColorEstado()
  { //BACKGROUND
    $color = '';
    switch ($this->codEstadoSolicitud) {
      case $this::getCodEstado('Creada'): //CREADO
        $color = 'rgb(255,193,7)';
        break;
      case $this::getCodEstado('Aprobada'): //aprobado
        $color = 'rgb(0,154,191)';
        break;
      case $this::getCodEstado('Abonada'): //abonado
        $color = 'rgb(243,141,57)';
        break;
      case $this::getCodEstado('Contabilizada'): //rendida
        $color = 'rgb(40,167,69)';
        break;
      case $this::getCodEstado('Observada'): //observada
        $color = 'rgb(217,217,217)';
        break;
      case $this::getCodEstado('Cancelada'): //rechazada
        $color = 'rgb(149,51,203)';
        break;
    }
    return $color;
  }

  public function getColorLetrasEstado()
  {
    $color = '';
    switch ($this->codEstadoSolicitud) {
      case $this::getCodEstado('Creada'): //creada
        $color = 'black';
        break;
      case $this::getCodEstado('Aprobada'): //aprobada
        $color = 'white';
        break;
      case $this::getCodEstado('Abonada'): //abonada
        $color = 'white';
        break;
      case $this::getCodEstado('Contabilizada'): //rendida
        $color = 'white';
        break;
      case $this::getCodEstado('Observada'): //observada
        $color = 'black';
        break;
      case $this::getCodEstado('Cancelada'): //rechazada
        $color = 'white';
        break;
    }
    return $color;
  }
  public function getNombreEvaluador()
  {
    if (is_null($this->codEmpleadoEvaluador))
      return "";

    $ev = Empleado::findOrFail($this->codEmpleadoEvaluador);
    return $ev->getNombreCompleto();
  }



  public static function filtrarPorEmpleadoSolicitante($coleccion, $codEmpleado)
  {
    $listaNueva = new Collection();
    foreach ($coleccion as $item) {
      if ($item->codEmpleadoSolicitante == $codEmpleado)
        $listaNueva->push($item);
    }
    return $listaNueva;
  }

  //ingresa una coleccion y  el codEstadoSolicitud y retorna otra coleccion  con los elementos de esa coleccion que están en ese estado
  public static function separarDeColeccion($coleccion, $codEstadoSolicitud)
  {
    $listaNueva = new Collection();
    foreach ($coleccion as $item) {
      if ($item->codEstadoSolicitud == $codEstadoSolicitud)
        $listaNueva->push($item);
    }
    return $listaNueva;
  }


  // Observadas->subsanadas-> Creadas -> Aprobadas ->abonadas-> Contabilizadas -> canceladas->rechazadas
  public static function ordenarParaEmpleado(Builder $queryBuilder): Collection
  {

    $queryBuilder = $queryBuilder->join('estado_solicitud_fondos', 'estado_solicitud_fondos.codEstadoSolicitud', '=', 'solicitud_fondos.codEstadoSolicitud')
      ->orderBy('ordenListadoEmpleado', 'ASC')->orderBy('codSolicitud', 'DESC');
    return $queryBuilder->get();
  }


  //Creada->Subsanada->Aprobadas->Abonadas->Contabilizada
  public static function ordenarParaGerente(Builder $queryBuilder): Collection
  {

    $queryBuilder = $queryBuilder->join('estado_solicitud_fondos', 'estado_solicitud_fondos.codEstadoSolicitud', '=', 'solicitud_fondos.codEstadoSolicitud')
      ->orderBy('ordenListadoGerente', 'ASC')->orderBy('codSolicitud', 'DESC');
    return $queryBuilder->get();
  }

  //Aprobadas->Abonadas->Contabilizadas
  public static function ordenarParaAdministrador(Builder $queryBuilder): Collection
  {

    $queryBuilder = $queryBuilder->join('estado_solicitud_fondos', 'estado_solicitud_fondos.codEstadoSolicitud', '=', 'solicitud_fondos.codEstadoSolicitud')
      ->orderBy('ordenListadoAdministrador', 'ASC')->orderBy('codSolicitud', 'DESC');
    return $queryBuilder->get();
  }

  //Aprobadas->Abonadas->Contabilizadas
  public static function ordenarParaContador(Builder $queryBuilder): Collection
  {

    $queryBuilder = $queryBuilder->join('estado_solicitud_fondos', 'estado_solicitud_fondos.codEstadoSolicitud', '=', 'solicitud_fondos.codEstadoSolicitud')
      ->orderBy('ordenListadoContador', 'ASC')->orderBy('codSolicitud', 'DESC');
    return $queryBuilder->get();
  }


  //obtiene una lista de solicitudes que adentro, en algun lado, tengan esa cadena de caracteres exacta
  public static function buscarPorPalabras(Builder $queryPreconstruida, string $cadenaBuscada): Collection
  {

    $busqueda = "select * from solicitud_fondos SF
            inner join detalle_solicitud_fondos DSF on DSF.codSolicitud = SF.codSolicitud
            where SF.girarAOrdenDe like '%contenido%'";

    $emp = Empleado::getEmpleadoLogeado();
    $lista = $queryPreconstruida->get(); //obtenemos la lista base

    $listaNuevaResultados = new Collection();

    foreach ($lista as $soli) {
      //empezamos a filtrar
      $cumpleConElFiltro =
        str_contains($soli->justificacion, $cadenaBuscada) ||
        str_contains($soli->numeroCuentaBanco, $cadenaBuscada) ||
        str_contains($soli->codigoCedepas, $cadenaBuscada);
      if ($cumpleConElFiltro)
        $listaNuevaResultados->push($soli);
    }

    foreach ($lista as $soli) {
      //empezamos a filtrar
      if (!$listaNuevaResultados->contains($soli)) {
        $cumpleConElFiltro = false;
        foreach ($soli->getDetalles() as $detalle) {
          $cumpleConElFiltro = str_contains($detalle->concepto, $cadenaBuscada);

          if ($cumpleConElFiltro)
            $listaNuevaResultados->push($soli);
        }
      }
    }



    return $listaNuevaResultados;
  }


  /**ESCRIBIR NUMEROSSSSS */
  function escribirTotalSolicitado()
  {
    return Numeros::escribirNumero($this->totalSolicitado);
  }


  public static function getDashboardInfo(array $codsProyectos)
  {

    $today = date('Y-m-d') . " 00:00:00";
    $date_sup_limit = date('Y-m-d') . " 23:59:59";
    $last_monday = date('Y-m-d', strtotime('-1 Monday')) . " 00:00:00";
    $first_day_month = date('Y-m-') . "01 00:00:00";
    $oneMonthAgo = Fecha::getFechaActualMenosXDias(30);
    $codsProyectosImploted = implode(",", $codsProyectos);


    $cant_emitidos_dia = SolicitudFondos::whereIn('codProyecto', $codsProyectos)->where('fechaHoraEmision', '>=', $today)->count();
    $cant_emitidos_semana = SolicitudFondos::whereIn('codProyecto', $codsProyectos)->where('fechaHoraEmision', '>=', $last_monday)->count();
    $cant_emitidos_mes = SolicitudFondos::whereIn('codProyecto', $codsProyectos)->where('fechaHoraEmision', '>=', $first_day_month)->count();

    $cant_aprobados_dia = SolicitudFondos::whereIn('codProyecto', $codsProyectos)->where('fechaHoraRevisado', '>=', $today)->count();
    $cant_aprobados_semana = SolicitudFondos::whereIn('codProyecto', $codsProyectos)->where('fechaHoraRevisado', '>=', $last_monday)->count();
    $cant_aprobados_mes = SolicitudFondos::whereIn('codProyecto', $codsProyectos)->where('fechaHoraRevisado', '>=', $first_day_month)->count();


    $diasExistentesSQL = Fecha::getSQLFechasExistentes($oneMonthAgo, $date_sup_limit);


    $emitidos_sql = "
        SELECT
            COUNT(codSolicitud) as cantidad_docs,
            SUM(totalSolicitado) as monto_total,
            CAST(fechaHoraEmision as Date) as fecha
        FROM solicitud_fondos
        WHERE codProyecto IN ($codsProyectosImploted)
            AND fechaHoraEmision >= '$oneMonthAgo'
            GROUP BY cast(fechaHoraEmision as Date)
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
    $SOL = compact(
      'cant_emitidos_dia',
      'cant_emitidos_semana',
      'cant_emitidos_mes',
      'cant_aprobados_dia',
      'cant_aprobados_semana',
      'cant_aprobados_mes',
      'cant_emitidos_historico'
    );


    return $SOL;
  }


  /* Convierte el objeto en un vector con elementos leibles directamente por la API */
  public function getVectorParaAPI()
  {
    $itemActual = $this;
    $itemActual['codigoYproyecto'] = $this->getProyecto()->getOrigenYNombre();
    $itemActual['montoSolicitado'] = $this->getMoneda()->simbolo . " " . number_format($this->totalSolicitado, 2);
    $itemActual['nombreEstado'] = $this->getNombreEstado();
    $itemActual['nombreBanco'] = $this->getBanco()->nombreBanco;
    $itemActual['fechaHoraEmision'] = $this->getFechaHoraEmision();

    $itemActual['colorFondo'] = $this->getColorEstado();
    $itemActual['colorLetras'] = $this->getColorLetrasEstado();
    $itemActual['simboloMoneda'] = $this->getMoneda()->simbolo;

    return $itemActual;
  }
}
