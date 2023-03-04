<?php

namespace App\View\Components;

use Exception;
use Illuminate\View\Component;
use Illuminate\View\View;

class Aislator
{

  /* 
    Esta función remplaza las cadenas "CSS_SEP" y "JS_SEP" con los separadores que se renderizarán finalmente
    Esto para que el código sea más limpio

  */
  public static function aislate(View $view ,int $r,string $name){

    
    
    $css_separator = "css_separator_$r"."_"."$name";
    $js_separator = "js_separator_$r"."_"."$name";
  

    $view = str_replace("CSS_SEP",$css_separator,$view);
    $view = str_replace("JS_SEP" ,$js_separator,$view);

    return $view;
  }
     
}
