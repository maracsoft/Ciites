<?php

namespace App;

use App\Utils\OrdenadorEstados;
use App\Utils\MaracEstado;
use B;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class EstadoViajeVehiculo extends MaracEstado
{

  public function __construct(string $codigo)
  {
    parent::__construct($codigo);
  }




  const OrdenesPorRoles = [
    'conductor' => [
      EstadoViajeVehiculo::ABIERTO => 1,
      EstadoViajeVehiculo::FINALIZADO => 2,
    ],
    'aprobador_viajes' => [
      EstadoViajeVehiculo::ABIERTO => 1,
      EstadoViajeVehiculo::FINALIZADO => 2,
    ],
    'contador' => [
      EstadoViajeVehiculo::ABIERTO => 1,
      EstadoViajeVehiculo::FINALIZADO => 2,
    ]
  ];


  const ABIERTO = "abierto";
  const FINALIZADO = "finalizado";



  public static function GetNombresAparentes()
  {
    return [
      self::ABIERTO => "En Registro",
      self::FINALIZADO => "Finalizado",

    ];
  }


  public static function getDescripciones()
  {
    return [
      self::ABIERTO => 'El usuario empieza el registro de un viaje indicando la fecha, hora de salida , motivo y el usuario que lo aprobó de forma externa al sistema.',
      self::FINALIZADO => 'El viaje ya se terminó, ya tanqueó la camioneta y ya retornó a la oficina.',
    ];
  }



  public static function ordenarParaConductor(Builder $queryBuilder): Builder
  {
    return OrdenadorEstados::ordenarQuerySegunEstados($queryBuilder, self::OrdenesPorRoles['conductor']);
  }


  public static function ordenarParaAprobadorViajes(Builder $queryBuilder): Builder
  {
    return OrdenadorEstados::ordenarQuerySegunEstados($queryBuilder, self::OrdenesPorRoles['aprobador_viajes']);
  }


  public static function ordenarParaContadorViajes(Builder $queryBuilder): Builder
  {
    return OrdenadorEstados::ordenarQuerySegunEstados($queryBuilder, self::OrdenesPorRoles['contador']);
  }
}
