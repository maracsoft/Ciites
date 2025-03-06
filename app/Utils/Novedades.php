<?php

namespace App\Utils;

use Exception;

class Novedades

{



  /*

primer digito -> migracion de version de laravel
segundo digito -> nuevo modulo
tercer digito -> fixes

  */



  public static function getNovedades()
  {

    return [

      (object)[
        "version" => "1.9.0",
        "title" => "Nuevo módulo de gestión vehicular y menú lateral personalizable",
        "date" => "3 de Marzo, 2024",
        "changes" => [
          "Gestión de vehiculos",
          "Gestión de viajes vehiculares",
          "Registro de viajes usando códigos QR impresos",
          "Ahora puede configurar la forma en que se muestra el menú lateral en Mi Cuenta / Mis Datos",
        ]
      ]

    ];
  }
}
