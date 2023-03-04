<?php

namespace App\Models\CITE;

use App\ArchivoGeneral;
use App\Distrito;
use App\Fecha;
use App\Mes;
use Illuminate\Database\Eloquent\Model;

class EstadoReporteMensual extends Model
{
    public $table = "cite-estado_reporte_mensual";
    protected $primaryKey ="codEstado";

    public $timestamps = false;
    protected $fillable = [''];

    private static function buscarEstado($nombre) : EstadoReporteMensual{
        return EstadoReporteMensual::where('nombre',$nombre)->first();
    }

    public static function getCodigoNoProgramado() : int{
        return EstadoReporteMensual::buscarEstado('No programado')->getId();
    }
    public static function getCodigoProgramado() : int{
        return EstadoReporteMensual::buscarEstado('Programado')->getId();
    }
    public static function getCodigoReportado() : int{
        return EstadoReporteMensual::buscarEstado('Reportado')->getId();
    }
    public static function getCodigoAprobado() : int{
        return EstadoReporteMensual::buscarEstado('Aprobado')->getId();
    }
    public static function getCodigoObservado() : int{
        return EstadoReporteMensual::buscarEstado('Observado')->getId();
    }
    public static function getCodigoSubsanado() : int{
        return EstadoReporteMensual::buscarEstado('Subsanado')->getId();
    }
}