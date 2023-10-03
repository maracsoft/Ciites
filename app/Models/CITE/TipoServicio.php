<?php

namespace App\Models\CITE;

use App\Debug;
use App\MaracModel;
use App\Models\PPM\PPM_Organizacion;
use Exception;
use Illuminate\Database\Eloquent\Model;

class TipoServicio extends MaracModel
{
    public $table = "cite-tipo_servicio";
    protected $primaryKey ="codTipoServicio";

    public $timestamps = false;
    protected $fillable = [''];


    public function getModalidad(){
      return ModalidadServicio::findOrFail($this->codModalidad);
    }

    function getActividades(){
        return ActividadCite::where('codTipoServicio',$this->getId())->get();
    }
     
    
    public function getCantServiciosPagados($fechaInicio,$fechaFin){
      $codTipoAccesoPagado = TipoAcceso::getCodPagado();
      return Servicio::where('codTipoServicio',$this->getId())->where('codTipoAcceso',$codTipoAccesoPagado)
            ->where(Servicio::FiltroEspecialFechas($fechaInicio,$fechaFin))->count();
    }
    public function getCantServiciosGratuitos($fechaInicio,$fechaFin){
      $codTipoAccesoGratuito = TipoAcceso::getCodGratuito();
      return Servicio::where('codTipoServicio',$this->getId())->where('codTipoAcceso',$codTipoAccesoGratuito)
      ->where(Servicio::FiltroEspecialFechas($fechaInicio,$fechaFin))->count();
    }

    public function getCantServicios($fechaInicio,$fechaFin){
      return Servicio::where('codTipoServicio',$this->getId())
      ->where(Servicio::FiltroEspecialFechas($fechaInicio,$fechaFin))->count();
    }

    public function getServicios($fechaInicio,$fechaFin){
      return Servicio::where('codTipoServicio',$this->getId())
      ->where(Servicio::FiltroEspecialFechas($fechaInicio,$fechaFin))->get();
    }

    public function getTotalPagadoServicios($fechaInicio,$fechaFin){
      $servicios = $this->getServicios($fechaInicio,$fechaFin);
      $monto = 0;
      $codTipoAccesoPagado = TipoAcceso::getCodPagado();
      foreach ($servicios as $servicio) {
        if($servicio->codTipoAcceso == $codTipoAccesoPagado){
          $monto += $servicio->total;
        }
        
      }
      return $monto;
    }


    public function getUnidadesDeServicios($fechaInicio,$fechaFin){
      $servicios = $this->getServicios($fechaInicio,$fechaFin);
      $codsUnidades = [];
      foreach ($servicios as $servicio) {
        $codsUnidades[] = $servicio->codUnidadProductiva;
      }

      return UnidadProductiva::whereIn('codUnidadProductiva',$codsUnidades)->get();
    }

    /* 
    tipo puede ser

      MIPYME
      GRAN EMPRESA
      ASOCIACIÓN
      COOPERATIVA
      OTRO

      Persona natural con negocio y sin negocio son productores y 
      Cooperativa va a asociaciones
        
    */
    public function getCantUnidades($tipo,$fechaInicio,$fechaFin){
      $unidades = $this->getUnidadesDeServicios($fechaInicio,$fechaFin);
     

      switch ($tipo) {
        case 'MIPYME':
          $nombres_coincidentes = ["MIPYME"];
          break;
        case 'GRAN EMPRESA':
          $nombres_coincidentes = ["GRAN EMPRESA"];
          break;
        case 'ASOCIACIÓN':
          $nombres_coincidentes = ["COOPERATIVA","ASOCIACION"];
          break;
        case 'PRODUCTORES':
          $nombres_coincidentes = ["PERSONA NATURAL SIN NEGOCIO","PERSONA NATURAL CON NEGOCIO"];
          break;
        case 'OTROS':
          $nombres_coincidentes = ["OTRO"];
          break;
        default :
          throw new Exception("Tipo no admitido");
        break;
      }

      

      $cant = 0;
      foreach ($unidades as $unidad) {
        $nombre_tp_actual = $unidad->getTipoPersoneria()->nombre;
        
         
        if(in_array($nombre_tp_actual,$nombres_coincidentes)){
          $cant++;
        }
      }
      return $cant;
    }


}
