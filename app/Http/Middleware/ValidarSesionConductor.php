<?php

namespace App\Http\Middleware;

use Closure;
use App\Debug;
use App\Empleado;
use App\ErrorHistorial;
use App\Utils\Configuracion;

class ValidarSesionConductor
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $logeado = Empleado::getEmpleadoLogeado();

    if (!$logeado->esConductor()) {
      $codErrorHistorial = ErrorHistorial::registrarError("Acceso a ruta sin permiso ValidarSesionConductor", app('request')->route()->getAction(), "");
      $msj = Configuracion::getMensajeError($codErrorHistorial);
      return redirect()->route('error')->with('datos', $msj);
    }


    return $next($request);
  }
}
