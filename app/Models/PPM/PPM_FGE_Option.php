<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Distrito;
use App\MaracModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_FGE_Option extends MaracModel
{
    public $table = "ppm-fge_item_option";
    protected $primaryKey ="codOption";

    public $timestamps = false;
    protected $fillable = [''];


    public static function BuscarYSiNoExisteCrear(string $descripcion, PPM_FGE_Item $item,int $valor ) : PPM_FGE_Option {

      $buscar = PPM_FGE_Option::where('descripcion',$descripcion)->get();
      if(count($buscar) == 0){ //no existe, lo creamos
        $nuevo = new PPM_FGE_Option();
        $nuevo->descripcion = $descripcion;
        $nuevo->codItem = $item->codItem;
        $nuevo->valor = $valor;
        $nuevo->save();
        return $nuevo;
      }else{
        return $buscar[0];
      }

    }

  }