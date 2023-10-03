<?php

namespace App\Http\Middleware;

use App\Configuracion;
use App\Empleado;
use App\ErrorHistorial;
use Closure;

class ValidarSesionPPM
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
      $emp =Empleado::getEmpleadoLogeado(); 
      if($emp->esAdminSistema()) //si es admin sistema, no valida nada
          return $next($request);
          
          
      if($emp->esDireccionPPM() || $emp->esEquipoPPM() || $emp->esUGE() ) // verifica que el user tenga al menos uno de los roles del cite
          return $next($request);
      
      //si no tuvo ninguno, lo echa patras
      $codErrorHistorial = ErrorHistorial::registrarError("Acceso a ruta sin permiso ValidarSesionPPM", app('request')->route()->getAction(),"");
      $msj = Configuracion::getMensajeError($codErrorHistorial);
      return redirect()->route('error')->with('datos',$msj);


    }
}
