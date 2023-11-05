<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Debug extends Model
{
    //ESTE NO ES UN MODELO, ES UNA CLASE PARA PRINTEAR MSJS BACANES EN LA CONSOLA

    public static function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);

    }


    public static function abreviar($cadena,$limiteCaracteres){

        // Si la longitud es mayor que el límite...
        if(strlen($cadena) > $limiteCaracteres){
            // Entonces corta la cadena y ponle el sufijo
            return substr($cadena, 0, $limiteCaracteres) . '...';
        }

        // Si no, entonces devuelve la cadena normal
        return $cadena;

    }

    public static function mensajeError($claseDondeOcurrio, $mensajeDeError){
        error_log('********************************************

            HA OCURRIDO UN ERROR EN : '.$claseDondeOcurrio.'

            MENSAJE DE ERROR:

            '.$mensajeDeError.'


        ***************************************************************
        ');

    }

    public static function mensajeSimple($msj){
        error_log('********************************************
            MENSAJE SIMPLE:

            '.$msj.'


        ***************************************************************
        ');

    }

    public static function contenidoEnJS($cont){
        return $cont.' <script> x = '.$cont.' </script>';
    }


    public static function LogMessage($msg,$msj2 = null){

      if(gettype($msg) == 'array'){
        $msg = json_encode($msg, JSON_PRETTY_PRINT);
      }

      if($msj2){
        if(gettype($msj2) == 'array'){
          $msj2 = json_encode($msj2, JSON_PRETTY_PRINT);
        }
      }

      $segundo_msj = "";
      if($msj2)
        $segundo_msj = ": ".$msj2;

      Log::channel('maraclog')->info($msg.$segundo_msj);
    }


}
