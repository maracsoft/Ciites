<?php

namespace App\Utils;

use App\Debug;
use Exception;

class MaracEstado
{

  public $codigo;
  public $descripcion;
  public $nombreAparente;

  public function __construct(string $codigo)
  {


    $descs = $this->getDescripciones();
    if (!array_key_exists($codigo, $descs)) {
      throw new Exception("No existe el estado con codigo " . $codigo);
    }


    $nombres = $this->GetNombresAparentes();
    if (!array_key_exists($codigo, $nombres)) {
      throw new Exception("No existe el estado con codigo " . $codigo);
    }

    $this->codigo = $codigo;
    $this->descripcion = $descs[$codigo];
    $this->nombreAparente = $nombres[$codigo];
  }
  public static function getDescripciones()
  {
    return [];
  }
  public static function GetNombresAparentes()
  {
    return [];
  }

  public function __toString()
  {
    return json_encode($this);
  }
}
