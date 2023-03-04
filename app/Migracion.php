<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Migracion extends Model
{
    public $table = "phinxlog";
    protected $primaryKey ="version";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

    
    // le indicamos los campos de la tabla 
    protected $fillable = [''];

 
    public function getStartTime(){
      return Fecha::formatoFechaHoraParaVistas($this->start_time);
    }
    public function getEndTime(){
      return Fecha::formatoFechaHoraParaVistas($this->end_time);
    }
    
    
}
