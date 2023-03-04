<?php

namespace App\UI;

use Illuminate\Database\Eloquent\Model;

class UIDesplegable implements FillableInterface{
    
    private $titulo;
    private $randomNumber;

    public function __construct($titulo){
      $this->randomNumber = rand(1,9999);
      $this->titulo = $titulo;
    }

//    apertura 'open'-> renderiza la parte inicial,
      //    si es 'close' renderiza la final
      // El random number debe mandarse sí o sí y generarse desde la plantilla (como esta funcion es llamada 2 veces, no puede generarse aquí)
      
    public function renderOpen(){
      $r = $this->randomNumber;
      $titulo = $this->titulo;
      $apertura = true;
      error_log($titulo);

      return view('ComponentesUI.Desplegable',compact('r','apertura','titulo'));
    }
    
    public function renderClose(){
      $r = $this->randomNumber;
      $titulo = $this->titulo;
      $apertura = false;
      
      return view('ComponentesUI.Desplegable',compact('r','apertura','titulo'));
    }
    

}
