<?php

namespace App\Models\PPM;

use App\MaracModel;
use Exception;

class PPM_TipoProducto extends MaracModel
{
    public $table = "ppm-tipo_producto";
    protected $primaryKey = "codTipoProducto";

    public $timestamps = false;
    protected $fillable = [''];



    public static function getByCode($code){
      $list = PPM_TipoProducto::where('codigo',$code)->get();
      if(count($list) == 0){
        throw new Exception("No existe el tipo producto con codigo $code");
      }
      return $list[0];
    }

    public static function getCodigoDeProducto(){
      return static::getByCode("producto")->codTipoProducto;
    }

    public static function getCodigoDeCultivoCadena(){
      return static::getByCode("cultivo/cadena")->codTipoProducto;
    }
  
}