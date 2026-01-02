<?php

namespace App\Utils;

use App\Empleado;
use App\MaracModel;
use App\OperacionDocumento;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
//START MODEL_HELPER

/**
 * @method static DocumentoAdministrativo findOrFail($primary_key)
 * @method static DocumentoAdministrativo | null find($primary_key)
 * @method static DocumentoAdministrativoCollection all()
 * @method static \App\Builders\DocumentoAdministrativoBuilder query()
 * @method static \App\Builders\DocumentoAdministrativoBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\DocumentoAdministrativoBuilder where(string $column,string $value)
 * @method static \App\Builders\DocumentoAdministrativoBuilder whereNotNull(string $column)
 * @method static \App\Builders\DocumentoAdministrativoBuilder whereNull(string $column)
 * @method static \App\Builders\DocumentoAdministrativoBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\DocumentoAdministrativoBuilder orderBy(string $column,array $sentido)
 */
//END MODEL_HELPER
class DocumentoAdministrativo extends MaracModel
{
  /* Funciones que serán para todos los documentos SOL REN REP REQ */
  //esta funcion es llamada automaticamente cada vez que se realiza una accion sobre un documento
  public function registrarOperacion($codTipoOperacion, $observacion, $codPuesto)
  {

    $empleadoLogeado = Empleado::getEmpleadoLogeado();
    $fechaHoraActual = Carbon::now();

    $this->registrarOperacionBase($codTipoOperacion, $observacion, $codPuesto, $fechaHoraActual, $empleadoLogeado->codEmpleado);
  }

  //separé esta funcion para poder añadir en operacion documento, operaciones artificiales (Esto es solo para el trabajo de SIG)
  public function registrarOperacionBase($codTipoOperacion, $observacion, $codPuesto, $fechaHora, $codEmpleado)
  {

    $vector = $this->getVectorDocumento();

    $operacion = new OperacionDocumento();
    $operacion->codTipoDocumento = $vector['codTipoDocumento'];
    $operacion->codTipoOperacion = $codTipoOperacion;
    $operacion->codDocumento = $vector['codDocumento'];

    $operacion->codEmpleado = $codEmpleado;

    $operacion->fechaHora = $fechaHora;
    $operacion->descripcionObservacion = $observacion;
    $operacion->codPuesto = $codPuesto;
    $operacion->save();
  }

  public function getListaOperaciones()
  {
    $vector = $this->getVectorDocumento();
    $codTipoDocumento = $vector['codTipoDocumento'];
    $codDocumento = $vector['codDocumento'];

    return OperacionDocumento::where('codTipoDocumento', '=', $codTipoDocumento)
      ->where('codDocumento', '=', $codDocumento)
      ->get();
  }


  public function getUltimaOperacion()
  {
    $lista = $this->getListaOperaciones();

    return $lista[count($lista) - 1];
  }

  public function getFechaHoraUltimaOperacion()
  {

    return $this->getUltimaOperacion()->fechaHora;
  }
}
