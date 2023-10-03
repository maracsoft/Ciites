<?php

namespace App\Models\CITE;

use Illuminate\Database\Eloquent\Model;

class ModalidadServicio extends Model
{
    public $table = "cite-modalidad_servicio";
    protected $primaryKey ="codModalidad";

    public $timestamps = false;
    protected $fillable = [''];



    public function getTiposServicio(){
      return TipoServicio::where('codModalidad',$this->codModalidad)->get();
    }

}
