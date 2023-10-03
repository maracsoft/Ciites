<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ParametroSistema extends Model
{

    public $table = "parametro_sistema";
    protected $primaryKey ="codParametro";

    public $timestamps = false;  //para que no trabaje con los campos fecha

    const Parametros = [

      "activarAyuda",
      "activarReportesAExcel",
      "activar_subida_admin_REQ",
      "id_subida_admin_REQ",
      "relacion_codEmpleados_remplazar",
      "MOSTRAR_INPUTS_ESCONDIDOS",
      "codEmpleadoAdministradorLibreSubidaArchivos",
        "telegram_errorchannel_id",
      "env",
      "proyect_folder_path",
      "ruta_migraciones"
    ];


    public static function getParametroSistema($nombreParametro){
      $search = ParametroSistema::where('nombre',$nombreParametro)->get();
      if(count($search) == 0){
        throw new Exception("El parametro sistema $nombreParametro no existe");
      }
      return $search[0];


    }

    public static function exportacionExcelActivada() : bool{
        return ParametroSistema::getParametroSistema('activarReportesAExcel')->valor == "true";
    }

    public function getDescripcionAcortada(){
      return Debug::abreviar($this->descripcion,100);
    }
    public function getValorAcortado(){
      return Debug::abreviar($this->valor,40);
    }
    public function getTipo(){

      return TipoParametroSistema::findOrFail($this->codTipoParametro);
    }


    public static function mostrarMsj() : bool{
      $faltantes_db = static::getParametrosFaltantesEnDB();
      $faltantes_codigo = static::getParametrosFaltantesEnCodigo();

      return count($faltantes_db) > 0 || count($faltantes_codigo) > 0;

    }
    public static function getParametrosFaltantesEnDB(){
      //lee la lista de parametros en BD y retorna los que faltan (basandose en el static de acá)
      $lista_db = ParametroSistema::All();
      $lista_nombres_db = [];
      foreach ($lista_db as $db_param) {
        $lista_nombres_db[] = $db_param->nombre;
      }

      $faltantes = [];
      foreach (static::Parametros as $parametro_definido) {
        if(!in_array($parametro_definido,$lista_nombres_db)){
          $faltantes[] = $parametro_definido;
        }
      }

      return $faltantes;

    }

    public static function getParametrosFaltantesEnCodigo(){
      $lista_db = ParametroSistema::All();

      $faltantes = [];
      foreach ($lista_db as $db_param) {
        if(!in_array($db_param->nombre,static::Parametros)){
          $faltantes[] = $db_param->nombre;
        }
      }

      return $faltantes;

    }

    public static function getMsjFaltantes(){
      $faltantes_db = static::getParametrosFaltantesEnDB();
      $faltantes_codigo = static::getParametrosFaltantesEnCodigo();


      if(count($faltantes_db) == 0 && count($faltantes_codigo) == 0)
        return "";


      $msj = "Faltan los parámetros de sistema ";
      if(count($faltantes_db) != 0){

        $msj .= json_encode($faltantes_db)." en la BD.  ";
      }
      if(count($faltantes_codigo) != 0){
        $msj .= json_encode($faltantes_codigo)." en el código fuente.";
      }

      return $msj;

    }


    public static function getEntorno(){
      return ParametroSistema::getParametroSistema("env")->valor;

    }

    public static function getModulosConParametros(){
      $array = DB::select("select modulo from parametro_sistema group by modulo");


      $modulos = [];
      foreach ($array as $element) {
          $nombre_modulo = $element->modulo;

          $lista = ParametroSistema::where('modulo',$nombre_modulo)->orderBy('modulo','DESC')->get();
          $modulos[$nombre_modulo] = $lista;

      }
      return $modulos;

    }

}
