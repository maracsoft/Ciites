<?php

namespace App\Http\Middleware;

use App\Empleado;
use Closure;
use App\ErrorHistorial;
use App\Utils\Configuracion;

class ValidarSesionAdministracionOContador
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
    $emp_logeado = Empleado::getEmpleadoLogeado();

    if (!$emp_logeado->esAdminSistema())
      if (!$emp_logeado->esContador() && ! $emp_logeado->esJefeAdmin()) {
        $codErrorHistorial = ErrorHistorial::registrarError("Acceso a ruta sin permiso", app('request')->route()->getAction(), "Middleware ValidarSesionAdministracionOContador");
        $msj = Configuracion::getMensajeError($codErrorHistorial);
        return redirect()->route('error')->with('datos', $msj);
      }


    return $next($request);
  }
}
