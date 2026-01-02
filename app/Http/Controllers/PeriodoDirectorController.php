<?php

namespace App\Http\Controllers;

use App\Utils\Configuracion;
use App\Utils\Debug;
use App\Empleado;
use App\ErrorHistorial;
use App\Utils\Fecha;
use App\Http\Controllers\Controller;
use App\Moneda;
use App\ObjetivoProgramacion;
use App\PeriodoDirectorGeneral;
use App\ProgramacionAsesores;
use App\RelacionPaquetePeriodoDirectorGeneral;
use App\Utils\RespuestaAPI;
use App\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodoDirectorController extends Controller
{

  public function ListarPeriodos()
  {
    $listaPeriodos = PeriodoDirectorGeneral::All();

    return view('PeriodoDirector.ListarPeriodos', compact('listaPeriodos'));
  }


  public function Inv_ListarPeriodos()
  {
    $listaPeriodos = PeriodoDirectorGeneral::All();

    return view('PeriodoDirector.Inv_ListaPeriodos', compact('listaPeriodos'));
  }

  public function GetFormInvocable($codPeriodoDirector)
  {
    $periodo = PeriodoDirectorGeneral::find($codPeriodoDirector);

    if ($periodo) {
      $titulo_modal = "Editar periodo";
    } else {
      $periodo = new PeriodoDirectorGeneral();
      $periodo->nombre = "";

      $titulo_modal = "Nuevo periodo";
    }


    return view('PeriodoDirector.Inv_FormPeriodo', compact('periodo', 'titulo_modal'));
  }


  /*

  */
  public function GuardarActualizar(Request $request)
  {
    try {
      DB::beginTransaction();
      $codPeriodoDirector = $request->codPeriodoDirector;
      $emp = Empleado::getEmpleadoLogeado();


      if ($codPeriodoDirector == 0) { //nueva
        $periodo = new PeriodoDirectorGeneral();
        $periodo->fechaHoraCreacion = Carbon::now();

        $msj = "guardó";
      } else {
        $periodo = PeriodoDirectorGeneral::findOrFail($codPeriodoDirector);

        $msj = "actualizó";
      }

      $periodo->fecha_inicio = Fecha::formatoParaSQL($request->fecha_inicio);
      $periodo->fecha_fin = Fecha::formatoParaSQL($request->fecha_fin);
      $periodo->nombres = $request->nombres;
      $periodo->apellidos = $request->apellidos;
      $periodo->dni = $request->dni;
      $periodo->sexo = $request->sexo;

      $periodo->save();

      DB::commit();
      return RespuestaAPI::respuestaOk("Se $msj exitosamente el periodo");
    } catch (\Throwable $th) {
      Debug::LogMessage($th);
      DB::rollBack();

      $codErrorHistorial = ErrorHistorial::registrarError($th, app('request')->route()->getAction(), json_encode($request));
      $msj_error = Configuracion::getMensajeError($codErrorHistorial);

      return RespuestaAPI::respuestaError($msj_error);
    }
  }
}
