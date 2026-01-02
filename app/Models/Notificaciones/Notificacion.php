<?php

namespace App\Models\Notificaciones;

use App\Empleado;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends MaracModel
{
  public $timestamps = false;

  public $table = 'notificacion';

  protected $primaryKey = 'codNotificacion';

  protected $fillable = [];

  public function getTipoNotificacion()
  {
    return TipoNotificacion::findOrFail($this->codTipoNotificacion);
  }

  public function getEmpleado()
  {
    return Empleado::findOrFail($this->codEmpleado);
  }

  public function estaVisto()
  {
    return $this->visto == '1';
  }

  public function getClaseVista()
  {
    if ($this->estaVisto())
      return "NotificacionVista";
    return "";
  }
}
