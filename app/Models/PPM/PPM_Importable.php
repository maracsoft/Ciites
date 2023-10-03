<?php

namespace App\Models\PPM;

use App\Debug;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class PPM_Importable implements ToArray,WithCalculatedFormulas
{
     
    
    public function array($array,$calculateFormulas = true){
 
    }


    /* Mismo orden */
    const Campos = [
      "dni",
      "nombres",
      "apellido_paterno",
      "apellido_materno",
      
      "NUPP_numero", 
      "NUPP_unidad_medida_escrita", 

      "PTP_cantidad", 
      "PTP_unidad_medida_escrita",
      
      "PTC_cantidad", 
      "PTC_unidad_medida_escrita", 
      
      "pventa_unidad",
      "costo_prod_unidad",
      "ingreso_neto22",

      "RZ_rendimiento", 
      "RZ_unidad_medida", 
      "RZ_fuente", 
      "ingreso_semestre", 
      "RS_rendimiento",
      "RS_unidad_medida"
    ];

    const FilaPrimerDato = 8;
    const Columnas = "ABCDEFGHIJKLMNOPQRS";

    public static function ProcesarArray(array $array){
      $filas_primera_hoja = $array[0];
      
      $fila_primer_dato = static::FilaPrimerDato;
      $fila_excel = 1;
      $result = [];
      
      foreach ($filas_primera_hoja as $fila) {
        if($fila_excel >= $fila_primer_dato){
          $datos_fila = [];
          $j = 0;
          foreach ($fila as $valor_celda) {
            $campos_disponibles = static::Campos;
            if(key_exists($j,$campos_disponibles)){
              $fieldname = $campos_disponibles[$j];
              $datos_fila[$fieldname] = $valor_celda;
            }
            $j++;
          }
          if($datos_fila['dni'] != ""){
            $result[] = $datos_fila;
          }
           
          
        }
        $fila_excel++;
      }

      return $result;
    }
   
    //retorna un array de mensajes de errores
    public static function ValidarArray($array) : array {
      
      $msjs_errores = [];

      foreach ($array as $file_number => $fila_actual) {
        $column_i = 0;
        foreach ($fila_actual as $fieldname => $value) {
          Debug::LogMessage("value is:");
          Debug::LogMessage($value);
              
          if($value === 0){
            
          }else{
            if($value == ""){
              
              $excel_number = $file_number + static::FilaPrimerDato;
              $column_letter = static::Columnas[$column_i];
              $celda = $column_letter.$excel_number; 
              $msjs_errores[] = "[Celda $celda] El campo no puede estar vacío"; 
            }
          }
          $column_i++;
        }
      }
      
      return $msjs_errores;
    }
}