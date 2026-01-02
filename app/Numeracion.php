<?php

namespace App;

use App\Utils\MaracUtils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
//START MODEL_HELPER
/**
 * @property int $codNumeracion int(11)     
 * @property string $nombreDocumento varchar(50)     
 * @property int $año smallint(6)     
 * @property int $numeroLibreActual int(11)     
 * @method static Numeracion findOrFail($primary_key)
 * @method static Numeracion | null find($primary_key)
 * @method static NumeracionCollection all()
 * @method static \App\Builders\NumeracionBuilder query()
 * @method static \App\Builders\NumeracionBuilder where(string $column,string $operator, string $value)
 * @method static \App\Builders\NumeracionBuilder where(string $column,string $value)
 * @method static \App\Builders\NumeracionBuilder whereNotNull(string $column) 
 * @method static \App\Builders\NumeracionBuilder whereNull(string $column) 
 * @method static \App\Builders\NumeracionBuilder whereIn(string $column,array $array)
 * @method static \App\Builders\NumeracionBuilder orderBy(string $column,array $sentido) 
 */
//END MODEL_HELPER
class Numeracion extends MaracModel
{

  public $table = 'numeracion';

  protected $primaryKey = 'codNumeracion';

  protected $fillable = [
    'nombreDocumento',
    'año',
    'numeroLibreActual'
  ];

  public $timestamps = false;

  public static function ConstruirCodigoUnico(string $raiz, Numeracion $objNumeracion, int $cantidad_ceros)
  {
    return $raiz . substr($objNumeracion->año, 2, 2) . '-' . MaracUtils::rellernarCerosIzq($objNumeracion->numeroLibreActual, $cantidad_ceros);
  }

  //Retorna el numero que está libre de Reposicion de gastos
  public static function getNumeracionSOF()
  {
    return Numeracion::getNumeracionLibreDe('Solicitud de Fondos');
  }

  //Retorna el numero que está libre de Rendicion de gastos
  public static function getNumeracionREN()
  {
    return Numeracion::getNumeracionLibreDe('Rendicion de Gastos');
  }

  //Retorna el numero que está libre de Reposicion de gastos
  public static function getNumeracionREP()
  {
    return Numeracion::getNumeracionLibreDe('Reposición de Gastos');
  }

  //Retorna el numero que está libre de Reposicion de gastos
  public static function getNumeracionREQ()
  {
    return Numeracion::getNumeracionLibreDe('Requerimiento de Bienes y Servicios');
  }

  //Retorna el numero que está libre de DJ-MOV
  public static function getNumeracionDJ_MOV()
  {
    return Numeracion::getNumeracionLibreDe('DJ-Mov');
  }

  //Retorna el numero que está libre de DJ-VAR
  public static function getNumeracionDJ_VAR()
  {
    return Numeracion::getNumeracionLibreDe('DJ-Var');
  }

  //Retorna el numero que está libre de DJ-VIATICOS
  public static function getNumeracionDJ_VIA()
  {
    return Numeracion::getNumeracionLibreDe('DJ-Via');
  }

  //Retorna el numero que está libre de Orden de Compra
  public static function getNumeracionOC()
  {
    return Numeracion::getNumeracionLibreDe('Orden de Compra');
  }


  public static function getNumeracionCPF()
  {
    return Numeracion::getNumeracionLibreDe('Contrato de plazo fijo');
  }

  public static function getNumeracionCLS()
  {
    return Numeracion::getNumeracionLibreDe('Contrato de locación de servicios');
  }

  public static function getNumeracionCTS()
  {
    return Numeracion::getNumeracionLibreDe(ConstanciaDepositoCTS::RaizCodigoCedepas);
  }

  public static function aumentarNumeracionCTS()
  {
    return Numeracion::aumentarNumeracionDe(ConstanciaDepositoCTS::RaizCodigoCedepas);
  }


  public static function aumentarNumeracionSOF()
  {
    return Numeracion::aumentarNumeracionDe('Solicitud de Fondos');
  }

  //Retorna el numero que está libre de Rendicion de gastos
  public static function aumentarNumeracionREN()
  {
    return Numeracion::aumentarNumeracionDe('Rendicion de Gastos');
  }

  //Retorna el numero que está libre de Reposicion de gastos
  public static function aumentarNumeracionREP()
  {
    return Numeracion::aumentarNumeracionDe('Reposición de Gastos');
  }

  //Retorna el numero que está libre de Reposicion de gastos
  public static function aumentarNumeracionREQ()
  {
    return Numeracion::aumentarNumeracionDe('Requerimiento de Bienes y Servicios');
  }

  public static function aumentarNumeracionDJ_MOV()
  {
    return Numeracion::aumentarNumeracionDe('DJ-Mov');
  }
  public static function aumentarNumeracionDJ_VIA()
  {
    return Numeracion::aumentarNumeracionDe('DJ-Via');
  }
  public static function aumentarNumeracionDJ_VAR()
  {
    return Numeracion::aumentarNumeracionDe('DJ-Var');
  }

  public static function aumentarNumeracionOC()
  {
    return Numeracion::aumentarNumeracionDe('Orden de Compra');
  }


  public static function aumentarNumeracionCPF()
  {
    return Numeracion::aumentarNumeracionDe('Contrato de plazo fijo');
  }
  public static function aumentarNumeracionCLS()
  {
    return Numeracion::aumentarNumeracionDe('Contrato de locación de servicios');
  }


  /* La primera persona que haga un documento en un nuevo año, obtendrá la numeración 1 y la usará,
    por lo tanto la siguiente deberá obtener la 2

    Es por esto que en realidad, en la BD nunca se almacenará el numero 1
        (porque ahí se almacenan los nros libres y no se sabe si ya pasaron el año hasta que lo activan)
    */

  private static function aumentarNumeracionDe($nombreDocumento)
  {
    $numActual = Numeracion::getNumeracionLibreDe($nombreDocumento); //objeto model



    $numActual->numeroLibreActual = $numActual->numeroLibreActual + 1;

    //Else ya no es necesario pq Ya tenemos ese objeto del nuevo Año en numActual por la funcion  getNumeracionDe
    $numActual->save();
  }





  //Retorna el OBJETO NUMERACION que está libre del tipo  de documento pasado como parametro
  private static function getNumeracionLibreDe($nombreDocumento)
  {
    $añoActual = Carbon::now()->format('Y');
    $lista = Numeracion::where('nombreDocumento', '=', $nombreDocumento)
      ->where('año', '=', $añoActual)
      ->get();


    if (count($lista) == 0) //CASO EXCEPCION
    {
      $ultimoAñoNumerado = Numeracion::getUltimoAñoDe($nombreDocumento);
      if ($ultimoAñoNumerado == $añoActual) //SI EL AÑO ES IGUAL, ENTONCES SE MANDÓ EL NOMBRE MAL xd
        return "ERROR";

      //Si el año es diferente, entons esta es la primera llamada de este año
      $nuevoNumero = new Numeracion();
      $nuevoNumero->numeroLibreActual = 1;
      $nuevoNumero->año = $añoActual;
      $nuevoNumero->nombreDocumento = $nombreDocumento;
    } else { //CASO NORMAL
      $nuevoNumero = $lista[0];
    }

    return $nuevoNumero; //RETORNAMOS OBJETO MODELO
  }

  //retorna el ultimo año del cual está registrada la numeracion del documento indicado
  public static function getUltimoAñoDe($nombreDocumento)
  {
    $lista = Numeracion::where('nombreDocumento', '=', $nombreDocumento)
      ->get();
    $añoMayor = 0;
    foreach ($lista as $item) {
      if ($añoMayor < $item->año)
        $añoMayor = $item->año;
    }
    return $añoMayor;
  }
}
