<?php

namespace App\Models;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

/* 
Interfaz para obligar a todos los modelos a implementar findf para sustituir findOrFail
*/
interface MaracModelInterface
{
  public static function findf(int $id) : Model;
}

