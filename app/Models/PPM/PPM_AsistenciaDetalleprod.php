<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Distrito;
use App\MaracModel;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_AsistenciaDetalleprod extends MaracModel
{
    public $table = "ppm-asistencia_detalleprod";
    protected $primaryKey ="codAsistencia";
    public $timestamps = false;
    protected $fillable = [''];


    public function getPersona() : PPM_Persona {
      return PPM_Persona::findOrFail($this->codPersona);
    }

    public function getDetalleProducto() : PPM_DetalleProducto {
      return PPM_DetalleProducto::findOrFail($this->codDetalleProducto);
    }


    public static function VerificarAsistencia($codPersona,$codDetalleProducto){
      $cant = PPM_AsistenciaDetalleprod::where('codPersona',$codPersona)->where('codDetalleProducto',$codDetalleProducto)->count();
      if($cant == 0)
        return false;

      return true;
    }

    public static function GetAsistenciaDetalle($codPersona,$codDetalleProducto){
      $lista = PPM_AsistenciaDetalleprod::where('codPersona',$codPersona)->where('codDetalleProducto',$codDetalleProducto)->get();
      if(count($lista) == 0)
        throw new Exception("No existe la asistencia_detalleprod con esos codPersona $codPersona y codDetalleProducto $codDetalleProducto");

      return $lista[0];
    }
    

  }