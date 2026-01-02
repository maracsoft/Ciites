<?php

namespace App\Http\Controllers\Notificacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ActividadPrincipal;
use App\Utils\Configuracion;
use App\Debug;
use App\Empleado;
use App\ErrorHistorial;
use App\Models\Notificaciones\Notificacion;
use Illuminate\Support\Facades\DB;

class NotificacionController extends Controller
{

  /* Marca como vista la notificacion y redirige al usuario al link */
  public function marcarComoVista($codNotificacion)
  {
    $emp = Empleado::getEmpleadoLogeado();
    $notificacion = Notificacion::findOrFail($codNotificacion);
    if ($emp->getId() != $notificacion->codEmpleado) {
      return redirect()->route('error')->with('datos', "Ocurrió un error inesperado.");
    }


    $notificacion->visto = 1;
    $notificacion->save();

    return redirect($notificacion->link)->with('datos', "Mensaje notificación: " . $notificacion->descripcion);
  }
}
