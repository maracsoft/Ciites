<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Distrito;
use App\MaracModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_Sexo
{
    const Hombre = "H";
    const Mujer = "M";
    const NoBinario = "NB";

    public static function getSexosParaSelect(){
      return [
        0 => [
          "id" => static::Hombre,
          "nombre" => static::getSexoLabel(static::Hombre)
        ],
        1 => [
          "id" => static::Mujer,
          "nombre" => static::getSexoLabel(static::Mujer)
        ],
        2 => [
          "id" => static::NoBinario,
          "nombre" => static::getSexoLabel(static::NoBinario)
        ],
        
      ];
    }
    public static function getSexoLabel($sexo){
      switch ($sexo) {
        case 'H':
          return "Hombre";
          break;
        case 'M':
          return "Mujer";
          break;
        case 'NB':
          return "No Binario";
          break;
      }
    }
    
  
}
