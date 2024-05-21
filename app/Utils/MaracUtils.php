<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;

class MaracUtils
{
  
  public static function FormatearMonto(float $monto){
    return  number_format($monto, 2, '.', ' ');
  }

  public static function rellernarCerosIzq($numero, $nDigitos)
  {
    return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
  }
  
}
