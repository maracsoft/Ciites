<?php

namespace App\Models\PPM;

use App\MaracModel;

class PPM_Producto extends MaracModel
{
    public $table = "ppm-producto";
    protected $primaryKey = "codProducto";

    public $timestamps = false;
    protected $fillable = [''];

    
    public static function getProductos_Producto(){
      $codTipoProducto_producto = PPM_TipoProducto::getCodigoDeProducto();

      return PPM_Producto::where('codTipoProducto',$codTipoProducto_producto)->get();
    }

    public static function getProductos_CultivoCadena(){
      $codTipoProducto_CultivoCadena = PPM_TipoProducto::getCodigoDeCultivoCadena();
      
      return PPM_Producto::where('codTipoProducto',$codTipoProducto_CultivoCadena)->get();

    }
} 