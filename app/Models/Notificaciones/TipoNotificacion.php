<?php

namespace App\Models\Notificaciones;

use Illuminate\Database\Eloquent\Model;

class TipoNotificacion extends Model
{
    public $timestamps = false;

    public $table = 'tipo_notificacion';

    protected $primaryKey = 'codTipoNotificacion';

    protected $fillable = [];
 
    

}
