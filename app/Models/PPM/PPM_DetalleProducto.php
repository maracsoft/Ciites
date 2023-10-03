<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Distrito;
use App\MaracModel;
use App\UnidadMedida;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_DetalleProducto extends MaracModel
{
    public $table = "ppm-detalle_producto";
    protected $primaryKey ="codDetalleProducto";

    public $timestamps = false;
    protected $fillable = [''];

    /* 
    CAMPOS DE AMBOS TIPOS 
      codRelacion
      codTipoProducto

      PTC_cantidad
      PTC_codUnidadMedida
      pventa_unidad
      costo_prod_unidad
      ingreso_neto22
      RZ_rendimiento
      RZ_unidad_medida
      RZ_fuente
      ingreso_semestre
      RS_rendimiento
      RS_unidad_medida

    CAMPOS DE PRODUCTO
      codProducto

      NUP_cantidad
      NUP_unidad_medida
      PTUP_cantidad
      PTUP_codUnidadMedida

    CAMPOS DE CULTIVO/CADENA (importable excel)
      NUPP_numero
      NUPP_codUnidadMedida
      PTP_cantidad
      PTP_codUnidadMedida
      edad_cultivo

    */
    

    /* SOLO CULTIVO CADENA */
    public function getUnidadMedida_PTP(){
      return PPM_UnidadMedida::findOrFail($this->PTP_codUnidadMedida);
    }
    public function getUnidadMedida_NUPP(){
      return PPM_UnidadMedida::findOrFail($this->NUPP_codUnidadMedida);
    }
    
    /* SOLO PRODUCTO */
    public function getUnidadMedida_PTUP(){
      return PPM_UnidadMedida::findOrFail($this->PTUP_codUnidadMedida);
    }
    
    /* AMBOS */
    public function getUnidadMedida_PTC(){
      return PPM_UnidadMedida::findOrFail($this->PTC_codUnidadMedida);
    }

    /* AQUI HACER EL CAMBIO  */
    public function getPorcentajeAumentoIngresos(){

      if($this->ingreso_neto22 == 0){
        return "HAN EMPEZADO A OBTENER INGRESOS";
      }

      if(is_null($this->ingreso_neto22)){
        return "HAN EMPEZADO A OBTENER INGRESOS";
      }
      
      $tasa =  ($this->ingreso_semestre - $this->ingreso_neto22) / $this->ingreso_neto22; //base 0 a 1.00
      $num = $tasa*100;
      return number_format($num,2)." %";
    }

     
   
    
    public function getProducto(){
      return PPM_Producto::findOrFail($this->codProducto);
    }

    public function tienePersona(){
      if($this->codPersona){
        return true;
      }
      return false;
    }

    public function getPersona() : PPM_Persona{
      if(!$this->tienePersona()){
        $id = $this->getId();
        throw new Exception("El PPM_DetalleProducto actual ($id) no tiene un codPersona enlazado.");
      }

      return PPM_Persona::findOrFail($this->codPersona);

    }

    public function getNombrePersonaSiTiene(){
      if($this->tienePersona()){
        return $this->getPersona()->getNombreCompleto();
      }
      return "";
    }
    public function getDniPersonaSiTiene(){
      if($this->tienePersona()){
        return $this->getPersona()->dni;
      }
      return "";
    }

    public function getRelacion(){
      return PPM_RelacionOrganizacionSemestre::findOrFail($this->codRelacion);
    }
    public function getOrganizacion(){
      $relacion = $this->getRelacion();
      return $relacion->getOrganizacion();

    }

    function verificarAsistenciaDePersona($codPersona){
      $list = PPM_AsistenciaDetalleprod::where('codDetalleProducto',$this->getId())->where('codPersona',$codPersona)->get();
      return count($list)>0;
    }


    //retorna un array de Usuarios asociados , con un booleano de si participo o no en el servicio actual
    function getSociosYAsistencia(){
      $organizacion = $this->getOrganizacion();
      $personasAsociadas = $organizacion->getPersonasAsociadas();

      foreach ($personasAsociadas as $persona) {
          $persona->asistencia = $this->verificarAsistenciaDePersona($persona->getId());
          $persona->nuevaAsistencia = $persona->asistencia;
      }

      return $personasAsociadas;
    }
    
    public function getPersonasAsistentes(){
      $relas = PPM_AsistenciaDetalleprod::where('codDetalleProducto',$this->getId())->get();
      $array_codsPersona = [];
      foreach ($relas as $rela) {
        $array_codsPersona[] = $rela->codPersona;
      }

      $lista = PPM_Persona::whereIn('codPersona',$array_codsPersona)->get();
      return $lista;

    }

    public function getResumenAsistentes(){

      $asistentes = $this->getPersonasAsistentes();
      $nombres = [];
      foreach ($asistentes as $persona) {
        $dni = $persona->dni;
        $nombres[] = $persona->getNombreCompleto(). " ($dni)";
      }
      return implode(", ",$nombres);
    }

  }