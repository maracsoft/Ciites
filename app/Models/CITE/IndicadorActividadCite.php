<?php

namespace App\Models\CITE;

use App\ArchivoGeneral;
use App\Departamento;
use App\Distrito;
use App\Fecha;
use App\IndicadorActividad;
use App\MedioVerificacionMeta;
use App\Mes;
use Exception;
use Illuminate\Database\Eloquent\Model;

class IndicadorActividadCite extends Model
{
    public $table = "cite-indicador_actividad";
    protected $primaryKey ="codIndicador";

    public $timestamps = false;
    protected $fillable = [''];
  
    public function getActividad(){
      return ActividadCite::findOrFail($this->codActividad);
    }
    
    public function tieneValorMeta_Mes(IndicadorActividadCite $indicador,MesConvenioCite $mes){
      $cant = MetaPat::where('codMes',$mes->codMes)->where('codIndicador',$indicador->codIndicador)->count();
      return $cant > 0;
    }

    public function getValorMeta_Mes(IndicadorActividadCite $indicador,MesConvenioCite $mes){
      $meta = MetaPat::where('codMes',$mes->codMes)->where('codIndicador',$indicador->codIndicador)->first();
      return $meta->valor_meta;
    }

    public function tieneValorMeta_Region(IndicadorActividadCite $indicador,Departamento $departamento){
      $cant = MetaPat::where('codDepartamento',$departamento->codDepartamento)->where('codIndicador',$indicador->codIndicador)->count();
      return $cant > 0;
    }

    public function getValorMeta_Region(IndicadorActividadCite $indicador,Departamento $departamento){
      $meta = MetaPat::where('codDepartamento',$departamento->codDepartamento)->where('codIndicador',$indicador->codIndicador)->first();
      return $meta->valor_meta;
    }


    public static function getServicios_Mes(IndicadorActividadCite $indicador,MesConvenioCite $mes){

      $fecha_inicio = $mes->fecha_inicio;
      $fecha_fin = $mes->fecha_fin;

      $actividad = $indicador->getActividad();

      $listaServicios = Servicio::where('fechaTermino','>',$fecha_inicio)->where('fechaTermino','<',$fecha_fin)
      ->where('codActividad',$actividad->codActividad)
      ->get();
      return $listaServicios;
    }
    public function getValorEjecutado_Mes(IndicadorActividadCite $indicador,MesConvenioCite $mes){

      $listaServicios = static::getServicios_Mes($indicador,$mes);

      return static::getMedicionSegunTipoReporte($indicador,$listaServicios);

    }

    public static function getServicios_Region(IndicadorActividadCite $indicador,Departamento $departamento){

      $actividad = $indicador->getActividad();
      $codsDistritosDelDepartamento = $departamento->getArrayCodDistritos();

      $listaServicios = Servicio::whereIn('codDistrito',$codsDistritosDelDepartamento)
      ->where('codActividad',$actividad->codActividad)
      ->get();
      return $listaServicios;
    }

    public function getValorEjecutado_Region(IndicadorActividadCite $indicador,Departamento $departamento){
      
      $listaServicios = static::getServicios_Region($indicador,$departamento);
      return static::getMedicionSegunTipoReporte($indicador,$listaServicios);
    }

    public static function getListadoEntidadesMediblesSegunIndicador($listaServicios,$tipo_reporte){
      switch ($tipo_reporte) {
        case 'servicios':
          return $listaServicios;
          break;
        case 'unidades':
          
          $codsUnidadesProds = [];
          foreach ($listaServicios as $serv) {
            $codsUnidadesProds[] = $serv->codUnidadProductiva;
          }

          $listaUnidades = UnidadProductiva::whereIn('codUnidadProductiva',$codsUnidadesProds)->get();
          return $listaUnidades;

          break;
        case 'usuarios':
          $codsServicios = [];
          foreach ($listaServicios as $serv) {
            $codsServicios[] = $serv->codServicio;
          }

          $listaAsistencias = AsistenciaServicio::whereIn('codServicio',$codsServicios)->get();
          
          return $listaAsistencias;
          break;
            
        default:
          throw new Exception("El tipo de reporte ".$tipo_reporte." no existe");
          break;
      }

    }

    private static function getMedicionSegunTipoReporte(IndicadorActividadCite $indicador,$listaServicios){
      $listaEntidades = static::getListadoEntidadesMediblesSegunIndicador($listaServicios,$indicador->tipo_reporte);
      return count($listaEntidades);
      
    }
}