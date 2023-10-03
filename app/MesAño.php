<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MesAño extends MaracModel
{
    public $timestamps = false;

    public $table = 'mes_anio';

    protected $primaryKey = 'codMesAño';
    
    protected $fillable = [];

    function  getMes(){
        return Mes::findOrFail($this->codMes);

    }

    /* Retorna Marzo 2022 */
    function  getTexto(){

        $mes = $this->getMes();
        return $mes->nombre." ".$this->año;
    }

    static function getActual(){
        $añoActual = date("Y");
        $mesActual = intval(date("m"));

        return MesAño::where('codMes',$mesActual)->where('año',$añoActual)->get()[0];

        
    }

    public static function getMesesDeEsteAñoYAnterior(){
        $añoActual = date("Y");
        $añoAnterior = $añoActual-1;
        $array = [$añoActual,$añoAnterior];

        $lista = MesAño::whereIn('año',$array)->get();

        foreach ($lista as $elem) {
          $elem['texto'] = $elem->getTexto();
        }

        return $lista;

    }
    
}
