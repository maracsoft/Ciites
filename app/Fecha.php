<?php

namespace App;

use Carbon\Carbon;
use DateTime;
use Exception;

class Fecha
{
    
    var $fechaEnSQL; /* Valor  de la fecha en formato SQL  YYYY-MM-DD*/
    var $fechaEnLegible;/* Valor de la fecha en formato legible perú DD/MM/YYYY */
    


    public function nuevaFechaSQL($legible){
        $this->fechaEnLegible = $legible ;
        
        $sql = substr($legible,6,4).'-'.substr($legible,3,2).'-'.substr($legible,0,2);
        $this->fechaEnSQL = $sql;
    }


    /* funcion tipo libreria
    ingresa una fecha en formato peruano DD/MM/YYYY
    sale una fecha en formato sql YYYY-MM-DD

    */
    public static function formatoParaSQL($fecha){

        // date('d/m/Y', strtotime($this->fechaInicio));
        /*              año                 mes                 dia*/
        return substr($fecha,6,4).'-'.substr($fecha,3,2).'-'.substr($fecha,0,2);
    }
    

    /* funcion tipo libreria 
        ingresa una fecha en formato sql YYYY-MM-DD
        sale una fecha en formato peruano DD/MM/YYYY
    */
    public static function formatoParaVistas($fecha){
        return date('d/m/Y', strtotime($fecha));

    }

    public static function formatoFechaHoraParaVistas($fecha){
        return date('d/m/Y H:i:s', strtotime($fecha));


    }

    public static function getFechaHoraActual(){
        $fecha = Carbon::now();
        return Fecha::formatoFechaHoraParaVistas($fecha);
    }


    public static function getFechaAntigua(){
        return "01/01/2000";

    }


    /* 
        funcion para IndicadorActividadController registrarMetaProgramada
        compara 2 fechas que llegan en vectores 
        $fecha1 = 
        [
            'año'=>2000,
            'mes'=>5
        ]
    */
    public static function compararFechas($fecha1,$fecha2){


    }

    //llega string y objeto proyecto
    // 2020-01-20
    public static function dentroDeFechasProyecto($fechaMetaString,$proyecto){
        $fechaMinima = strtotime(substr($proyecto->fechaInicio,0,8)."01");
        $fechaMaxima = strtotime(substr($proyecto->fechaFinalizacion,0,8)."31");



        $fechaMeta = strtotime($fechaMetaString);
 
    
        Debug::mensajeSimple($proyecto->fechaInicio." () ".$proyecto->fechaFinalizacion);
        

        return ($fechaMeta <= $fechaMaxima && $fechaMeta >= $fechaMinima);

    }


    /* Se le pasa una String de fecha en formato SQL y retorna la fecha escrita tipo "4 de Enero de 2019" */
    public static function escribirEnTexto($fecha){

        
        $dia = date('d', strtotime($fecha));
        $mes = date('m', strtotime($fecha));
        $año = date('Y', strtotime($fecha));
        

        $nombreMes = Mes::findOrFail($mes)->nombre;
        return $dia." de ".$nombreMes." de ".$año;

    }
    
    //le resta dias a una fecha
    public static function restarDias(string $date, int $dias){

      return date('Y-m-d',(strtotime ( '-'.$dias.' day' , strtotime ( $date) ) ));

    }
    public static function getFechaActualMenosXDias(int $dias){
      $fecha = date("Y-m-d");
      return Fecha::restarDias($fecha,$dias);

    }




    // dates incomes format  Y-m-d
    // https://stackoverflow.com/questions/2157282/generate-days-from-date-range
    public static function getSQLFechasExistentes(string $date_start,string $date_end){

      return "
      SELECT a.Date as fecha
        FROM (
          SELECT curdate() - INTERVAL (a.a + (10 * b.a) + (100 * c.a) + (1000 * d.a) ) DAY as Date
          from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
          cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
          cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
          cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as d
        ) a
        where a.Date between '$date_start' and '$date_end' 

      ";

    }
    
    /* Tratar de convertir esto en el front */
    public static function traducirDiaAEspañol(string $nombreDia) : string{

      $nombreDia = strtolower($nombreDia);
      $resultado = "";
      switch ($nombreDia) {
        case 'monday':
          $resultado = "Lunes";
          break;
        case 'tuesday':
          $resultado = "Martes";
          break;
        case 'wednesday':
          $resultado = "Miércoles";
          break;
        case 'thursday':
          $resultado = "Jueves";
          break;
        case 'friday':
          $resultado = "Viernes";
          break;
        case 'saturday':
          $resultado = "Sábado";
          break;
        case 'sunday':
          $resultado = "Domingo";
          break;
                                                
        default:
          throw new Exception("No hay un nombre asociado para este día.");
          break;
      }
      return $resultado;

    }
}
