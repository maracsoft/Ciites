<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;

class RegresionLineal
{
    
    /**
     *Funcion original obtenida de  https://www.lawebdelprogramador.com/foros/PHP/1499427-regresion-lineal.html
    * linear regression function
    * @param $x array x-coords
    * @param $y array y-coords
    * @returns array() m=>slope, b=>intercept


    * Y = m*X + b
    */

        
    static function calcularModelo($x, $y) {
    
        // calculate number points
        $n = count($x);
    
        // ensure both arrays of points are the same size
        if ($n != count($y))
            throw new Exception("La cantidad de elementos de X debe ser igual a la de Y");
        
    
        // calculate sums
        $x_sum = array_sum($x);
        $y_sum = array_sum($y);
        
        $xx_sum = 0;
        $xy_sum = 0;
    
        for($i = 0; $i < $n; $i++) {
            $xy_sum+=($x[$i]*$y[$i]);
            $xx_sum+=($x[$i]*$x[$i]);
        }
    
        // calcular pendiente
        $m = (($n * $xy_sum) - ($x_sum * $y_sum)) / (($n * $xx_sum) - ($x_sum * $x_sum));
    
        // calcular intercepto
        $b = ($y_sum - ($m * $x_sum)) / $n;
    
        // return result
        return array("m"=>$m, "b"=>$b);

    }


    //modelo es un ['m'=5,'b'=1];
    public static function proyectar($modelo,$x){
        return $modelo['m']*$x + $modelo['b'];
    }
}   
