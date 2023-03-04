<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvanceEntregable extends Model
{
    public $timestamps = false;
    public $table = 'avance_entregable';

    protected $primaryKey = 'codAvance';
    protected $fillable = [''];


    public function getFechaEntrega(){
        return Fecha::formatoParaVistas($this->fechaEntrega);
    }

    function getMonto(){
        return number_format($this->monto,2);
    }

    
    function getFechaEntregaEscrita(){
        return Fecha::escribirEnTexto($this->fechaEntrega);
    }

}
