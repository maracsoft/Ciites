<?php

namespace App\UI;

use App\Debug;
use Illuminate\Database\Eloquent\Model;

class UIDesplegable implements FillableInterface{
    
    private $titulo;
    private $randomNumber;
    private $abierto_inicialmente;

    public function __construct($titulo,$abierto = true){
      $this->randomNumber = rand(1,9999);
      $this->titulo = $titulo;
      $this->abierto_inicialmente = $abierto;
    }

//    apertura 'open'-> renderiza la parte inicial,
      //    si es 'close' renderiza la final
      // El random number debe mandarse sí o sí y generarse desde la plantilla (como esta funcion es llamada 2 veces, no puede generarse aquí)
      
    public function renderOpen(){
      $r = $this->randomNumber;
      $titulo = $this->titulo;
      $apertura = true;
      $abierto_inicialmente = $this->abierto_inicialmente;

      
      
      return view('ComponentesUI.Desplegable',compact('r','apertura','titulo','abierto_inicialmente'));
    }
    
    public function renderClose(){
      $r = $this->randomNumber;
      $titulo = $this->titulo;
      $apertura = false;
      $abierto_inicialmente = $this->abierto_inicialmente;
      
      return view('ComponentesUI.Desplegable',compact('r','apertura','titulo','abierto_inicialmente'));
    }
    

}
