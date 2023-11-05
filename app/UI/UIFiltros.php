<?php

namespace App\UI;

use App\Debug;
use App\Departamento;
use App\Fecha;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UIFiltros implements NotFillableInterface {

    private $filtros = []; //array que configura los filtros
    private $filtros_usados; //filtros usados en la query actual
    private $hacerDesplegable ; //
    private $randomNumber;

    /*
    Filtros es un arreglo de objectos, cada objeto es así:
    {
      'name'=>'codDepartamento', //nombre con el que llegará al backend y nombre de la columna en la bd
      'label'=>'Departamento:' //contenido del label que aparecerá al ladito
      'show_label'=>true/false
      'placeholder'=>'placeholder', //placeholder del input text o contenido por defecto del select
      'type'=>'text/select/select2/date_start/date_end/date_interval/checkbox/multiple_select', //tipo de filtro que se mandará
      'function'=>'equals/contains/different/minor/mayor/between/between_dates/in',
      'options'=>[modelos] //array de modelos que se listarán en el select(si fuera un select)
      'options_label_field'=> 'nombre' //campo que se jalará de cada modelo de options (por ejemplo nombre o descripcion)
      'size'=>'xs/sm/md/', //tamaño que tendrá el input
      'max_width'=>'', //maximo tamaño que tendrá el input
      'value'=>'',
      'direct_search => false // permite añadir campos a la busqueda que no serán procesados directamente hacia SQL, y los podemos recuperar en el controller con UIFiltros::getValorRequestDirectSearch($request,"telefono_sucio");

    }
    */
    const camposObligatorios = [
      'name',
      'label',
      'show_label',
      'placeholder',
      'type',
      'function',
      'options',
      'options_label_field',
      'options_id_field',
      'size',
      'max_width',
    ];
    const typesPosibles = [
      'text',
      'select',
      'select2',
      'date_start',
      'date_end',
      'date_interval',
      'checkbox',
      'multiple_select',
      'direct_search'
    ];

    public function __construct(bool $hacerDesplegable, array $filtros_usados){
      $this->randomNumber = rand(1,9999);

      $this->hacerDesplegable = $hacerDesplegable;
      $this->filtros_usados = $filtros_usados;


    }


    /*
    $filtro = [
      'name'=>'codEmpleadoCreador',
      'label'=>':',
      'show_label'=>false,
      'placeholder'=>'Buscar por usuario que registró',
      'type'=>'select2',
      'function'=>'equals',
      'options'=>$listaEmpleados,
      'options_label_field'=>'nombreCompleto',
      'options_id_field'=>null,
      'size'=>'sm',
      'max_width'=>'',
    ]

    */
    public function añadirFiltro(array $filtro){
      $msj = $this->validarFiltro($filtro);
      if($msj != ""){
        throw new Exception($msj, 1);
      }

      /* VALORES POR DEFECTO */
      if(!array_key_exists("direct_search",$filtro)){
        $filtro['direct_search'] = false;
      }

      array_push($this->filtros,$filtro);

    }
    /* Misma que arriba */

    function validarFiltro(array $filtro){

      /* Validamos que tenga todos los campos obligatorios */
      foreach (UIFiltros::camposObligatorios as $campo) {
        if(!array_key_exists($campo,$filtro))
          return "Missing field " . $campo;
      }

      if(!in_array($filtro['type'],UIFiltros::typesPosibles))
        return "Filter type '".$filtro['type']."' not allowed ";

      return "";
    }


    // El random number se genera aqui al ser inicializado el objeto (como esta funcion es llamada 2 veces, no puede generarse aquí)

    public function render(){
      $r = $this->randomNumber;
      $filtros = $this->filtros;
      $filtros_usados = $this->filtros_usados;

      $hacerDesplegable = $this->hacerDesplegable;

      return view('ComponentesUI.Filtros',compact('r','filtros','hacerDesplegable','filtros_usados'));
    }





    /*
    En esta funcion entra una pre query de un Model y esta le aplica los filtros que vengan en el urlQuery
    ejemplo de urlQuery
      nombre.contains=diego ernesto&codCadena.equals=6&ruc.in=20,13
    ejemplo de query_orm
      $query_orm = Empleado::where('codEmpleado','>',0);

    */
    public static function buildQuery(Builder $query_orm,$urlQuery){
      if($urlQuery==""){
        return $query_orm;
      }



      $filters = static::getValidatedFilters($query_orm,$urlQuery);

      foreach ($filters as $filter) {
        //Primero extraemos cada uno de los filtros

        $value = $filter['value'];
        $name = $filter['name'];
        $function = $filter['function'];

        $operator = "";
        switch ($function) {
          case 'equals':
            $operator = "=";
            $query_orm = $query_orm->where($name,$operator,$value);
            break;
          case 'different':
            $operator = "!=";
            $query_orm = $query_orm->where($name,$operator,$value);
            break;
          case 'contains':
            $operator = "like";
            $value = "%$value%";
            $query_orm = $query_orm->where($name,$operator,$value);
            break;
          case 'minor':
            $operator = "<";
            $query_orm = $query_orm->where($name,$operator,$value);
            break;
          case 'mayor':
            $operator = ">";
            $query_orm = $query_orm->where($name,$operator,$value);
            break;
          case 'between_dates':

            //$value = urldecode($value);

            $date_start = explode(',',$value)[0];
            $date_end = explode(',',$value)[1];

            $date_start = Fecha::formatoParaSQL($date_start);
            $date_end = Fecha::formatoParaSQL($date_end);

            $query_orm = $query_orm->where($name,'>',$date_start." 00:00:00")->where($name,'<',$date_end." 23:59:59");
            break;
          case 'in':
            $array = explode(",",$value);
            $query_orm = $query_orm->whereIn($name,$array);
            break;
          case 'in_departamento':
            $dep = Departamento::findOrFail($value);
            $codDistritos = $dep->getArrayCodDistritos();
            $value = $codDistritos;
            $query_orm = $query_orm->whereIn($name,$value);
            break;

          case 'direct_search':
            break;
          default:
            throw new Exception("(UIFiltros) buildQuery la function $function no tiene un case asignado.", 1);
            break;
        }






      }
      $queryWithParam = UIFiltros::str_ireplace_array('?',$query_orm->getBindings(),$query_orm->toSql());

      return $query_orm;
    }

    /*
    Entra urlQuery y query_orm
    sale un arreglo de filtros de tipo name=>value
      "codCadena"=> 5
      "codDepartamento"=>1

    */
    public static function getQueryValues(Builder $query_orm, $urlQuery){
      if($urlQuery==""){
        return [];
      }



      $filters = static::getValidatedFilters($query_orm,$urlQuery);
      $array = [];
      foreach ($filters as $filter) {
        //Primero extraemos cada uno de los filtros
        $array[$filter['name']] = $filter['value'];
      }


      return $array;
    }


    /*
    Entra urlQuery y query_orm
    sale un arreglo de filtros de tipo name.function=>value
      "codDistrito.in_departamento"=> 5
      "fechaHoraCreacion.between_dates"=>"31/08/2022,04/09/2022"


    Esta funcion se usa para pasar a la vista los valores tal y como entran en la URL a los links de la paginacion
    */
    public static function getFiltersCompleteArray(Builder $query_orm, $urlQuery){
      if($urlQuery==""){
        return [];
      }

      $filters = static::getValidatedFilters($query_orm,$urlQuery);
      $array = [];
      foreach ($filters as $filter) {
        //Primero extraemos cada uno de los filtros
        $array[$filter['name'].".".$filter['function']] = $filter['value'];
      }


      return $array;
    }



    /*
      le entra el query_orm y el urlQuery
      le sale un array donde cada elemento es un filtro con los datos value,name,function

      Lo que hace es validar si:
        - La Url es valida
        - Los campos existen en la BD
      Dejar pasar los filtros que sí son validos
    */

    public static function getValidatedFilters(Builder $query_orm,string $urlQuery){
      if($urlQuery=="")
        return [];

      $urlQuery = urldecode($urlQuery);


      $filters = explode('&',$urlQuery);
      $array = [];
      foreach ($filters as $filter) {
        //Primero extraemos cada uno de los filtros

        try {
          $name_and_function = explode('=',$filter)[0];
          $value = explode('=',$filter)[1];

          $name = explode('.',$name_and_function)[0];
          $function = explode('.',$name_and_function)[1];
        } catch (\Throwable $th) {
          continue;
        }


        if($query_orm->isThisAColumn($name) || $function == 'direct_search'){
          $array[$name] = [
            'value'=>$value,
            'name'=>$name,
            'function'=>$function,
          ];
        }
      }

      return $array;
    }

    /*
    Esta función nos permite obtener la query SQL que se ejecutará
    $replace =  array (
      0 => 7,
      1 => '4',
    )
    $subject = "select * from `contacto` where `codCuenta` = ? and `codProgramacion` = ?
    OUTPUT: select * from `contacto` where `codCuenta` = 7 and `codProgramacion` = 4
    */

    static function str_ireplace_array($search, array $replace, $subject){
      if (0 === $tokenc = substr_count(strtolower($subject), strtolower($search))) {
          return $subject;
      }

      $string  = '';
      if (count($replace) >= $tokenc) {
          $replace = array_slice($replace, 0, $tokenc);
          $tokenc += 1;
      } else {
          $tokenc = count($replace) + 1;
      }
      foreach(preg_split('/'.preg_quote($search, '/').'/i', $subject, $tokenc) as $part) {
          $string .= $part.array_shift($replace);
      }

      return $string;
    }

    public static function getValorRequestDirectSearch(Request $request,$field){

      $name = $field.'_direct_search';
      $value = $request->$name;
      return $value;
    }
}
