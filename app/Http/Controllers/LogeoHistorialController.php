<?php

namespace App\Http\Controllers;

use App\Utils\Debug;
use App\Empleado;
use App\Utils\Fecha;
use App\Http\Controllers\Controller;
use App\LogeoHistorial;
use App\OperacionDocumento;
use App\UI\UIFiltros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogeoHistorialController extends Controller
{
  const PAGINATION = '50';

  public function listarLogeos(Request $request)
  {
    /*
          El gráfico se muestra a nivel de todas las páginas
          La tabla es solo de la página actual
        */

    $grafico_fechaInicio_defecto = Fecha::formatoParaVistas(Fecha::getFechaActualMenosXDias(30));
    $grafico_fechaFin_defecto = Fecha::formatoParaVistas(date("Y-m-d"));

    $listaLogeos = LogeoHistorial::query();
    $filtros_usados_paginacion = UIFiltros::getFiltersCompleteArray($listaLogeos, $request->getQueryString());
    $listaLogeos = UIFiltros::buildQuery($listaLogeos, $request->getQueryString());
    $filtros_usados = UIFiltros::getQueryValues($listaLogeos, $request->getQueryString());



    $listaLogeos = $listaLogeos->orderBy('fechaHoraLogeo', 'DESC')->paginate(static::PAGINATION);


    $listaEmpleados = Empleado::getListaEmpleadosPorApellido();


    return view('HistorialLogeos.ListarLogeos', compact('listaLogeos', 'listaEmpleados', 'filtros_usados', 'filtros_usados_paginacion', 'grafico_fechaInicio_defecto', 'grafico_fechaFin_defecto'));
  }

  /* Ruta de API */
  public function getDataGrafico(Request $request)
  {
    try {

      $fechaInicio = Fecha::formatoParaSQL($request->fechaInicio);
      $fechaFin = Fecha::formatoParaSQL($request->fechaFin);

      $busquedaPorEmpleado = "";
      if ($request->codEmpleado)
        $busquedaPorEmpleado = " AND codEmpleado="  . $request->codEmpleado;

      $sql = "

          SELECT
            CAST(fechaHoraLogeo AS DATE) as fecha,
            DAYNAME(fechaHoraLogeo) as dia_semana,
            COUNT(*) as cantidadLogeos from logeo_historial
          WHERE
                fechaHoraLogeo > '$fechaInicio 00:00:00'
            AND fechaHoraLogeo < '$fechaFin 23:59:59'
            $busquedaPorEmpleado

          GROUP BY
            CAST(fechaHoraLogeo AS DATE),
            DAYNAME(fechaHoraLogeo)

        ";
      Debug::mensajeSimple($sql);
      $logeosAcumuladosPorDia = DB::select($sql);

      return $logeosAcumuladosPorDia;


      //code...
    } catch (\Throwable $th) {
      Debug::mensajeSimple($th);
      return ["error" => $th];
    }
  }

  function inv_operacionesDeSesion($codSesion)
  {

    $logeo = LogeoHistorial::findOrFail($codSesion);
    $listaOperacionesDuranteSesion = $logeo->getOperacionesDuranteSesion();
    $empleado = Empleado::findOrFail($logeo->codEmpleado);
    return view('HistorialLogeos.inv_OperacionesSesion', compact('empleado', 'logeo', 'listaOperacionesDuranteSesion'));
  }
}
