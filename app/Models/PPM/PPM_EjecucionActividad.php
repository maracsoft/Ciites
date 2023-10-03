<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\ComponentRenderizer;
use App\Debug;
use App\Distrito;
use App\Empleado;
use App\Fecha;
use App\MesAño;
use App\Semestre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PPM_EjecucionActividad extends Model
{
    public $table = "ppm-ejecucion_actividad";
    protected $primaryKey ="codEjecucionActividad";

    public $timestamps = false;
    protected $fillable = [''];
    
    public function getObjetivo(){
      return PPM_Objetivo::findOrFail($this->codObjetivo);
    }
    public function getIndicador(){
      return PPM_Indicador::findOrFail($this->codIndicador);
    }
    
    
    public function verificarYGenerarRelacionPersonaSemestre(PPM_Persona $persona){

      $semestres = $this->getSemestres();
      foreach ($semestres as $semestre) {
        $existe = PPM_RelacionPersonaSemestre::existeRelacion($semestre->codSemestre,$persona->codPersona);

        if($existe){
          $rela = PPM_RelacionPersonaSemestre::FindRelacion($semestre->codSemestre,$persona->codPersona);
          
          $rela->añadirEjecucionQueSustenta($this);
          $rela->save();
          
          
        }else{
          
          $rela_persona_semestre = new PPM_RelacionPersonaSemestre();
          $rela_persona_semestre->codSemestre = $semestre->codSemestre;
          $rela_persona_semestre->codPersona = $persona->codPersona;
          $rela_persona_semestre->añadirEjecucionQueSustenta($this);
          $rela_persona_semestre->save();

          
        }
      }
        

    }
    
    public function setDataFromRequest(Request $request,$creating){
      if($creating){  
        $actividad = PPM_Actividad::findOrFail($request->codActividad);
        $indicador = $actividad->getIndicador();
        $objetivo = $indicador->getObjetivo();
  
        $this->codOrganizacion = $request->codOrganizacion;
        
        $this->codIndicador = $indicador->codIndicador;
        $this->codObjetivo = $objetivo->codObjetivo;
        $this->fechaInicio = Fecha::formatoParaSQL($request->fechaInicio);
        $this->fechaFin = Fecha::formatoParaSQL($request->fechaFin);

        $this->codsSemestres = Semestre::GetCodigosSemestresInvolucrados($this->fechaInicio,$this->fechaFin);
      }
      $this->codActividad = $request->codActividad;
        
      $distrito = Distrito::findOrFail($request->ComboBoxDistrito);
      $provincia = $distrito->getProvincia();
      $departamento = $provincia->getDepartamento();

      $this->descripcion = $request->descripcion;
      
      $this->codDistrito = $request->ComboBoxDistrito;
  
      $this->codProvincia = $provincia->codProvincia;
      $this->codDepartamento = $departamento->codDepartamento;
      

    }

    public function getSemestres() : Collection {
      $string = str_replace("(","",$this->codsSemestres);
      $string = str_replace(")","",$string);
      
      
      $array = explode(",",$string);


      return Semestre::whereIn('codSemestre',$array)->get();
    }

    public function getResumenSemestres(){
      $semestres = $this->getSemestres();
      $textos = [];
      foreach ($semestres as $semestre) {
        $textos[] = $semestre->getTexto();
      }
      return implode(" , ",$textos);

    }

    

    public function getOrganizacion(){
      return PPM_Organizacion::findOrFail($this->codOrganizacion);
    }

    function getTextoLugar(){
      $dist = $this->getDistrito();
      return $dist->getTextoUbicacion();
    }

   

    public function getEmpleadoCreador(){
      return Empleado::findOrFail($this->codEmpleadoCreador);
    }

    function getFechaHoraCreacion(){
      return Fecha::formatoFechaHoraParaVistas($this->fechaHoraCreacion);
    }




     

    function getNombreDepartamento(){
        if (!$this->codDistrito)
            return "NO INFO";

        $dist = $this->getDistrito();
        return $dist->getProvincia()->getDepartamento()->nombre;
    }


    function getNombreProvincia(){
        if (!$this->codDistrito)
            return "NO INFO";

        $dist = $this->getDistrito();
        return $dist->getProvincia()->nombre;
    }


    public function getNombreDistrito(){
        if (!$this->codDistrito)
            return "NO INFO";
        return Distrito::findOrFail($this->codDistrito)->nombre;
    }

    public function getDistrito(){
      if (!$this->codDistrito)
          return "NO INFO";
      return Distrito::findOrFail($this->codDistrito);
    }

    public function getParticipaciones(){
      return PPM_Participacion::where('codEjecucionActividad',$this->codEjecucionActividad)->get();
    }

    //retorna un array de Usuarios asociados , con un booleano de si participo o no en el servicio actual
    function getSociosYAsistencia(){
      $organizacion = $this->getOrganizacion();
      $personasAsociadas = $organizacion->getPersonasAsociadas();

      foreach ($personasAsociadas as $persona) {
          $persona->asistencia = $this->verificarAsistenciaDePersona($persona->getId());
          $persona->nuevaAsistencia = $persona->asistencia;
      }

      return $personasAsociadas;
    }


    /* Los que asistieron */
    function getPersonasQueAsistieron(){
        $participaciones = PPM_Participacion::where('codEjecucionActividad',$this->getId())->get();
        $array = [];
        foreach ($participaciones as $parti) {
            array_push($array,$parti->codPersona);
        }

        $listaPersonas = PPM_Persona::whereIn('codPersona',$array)->orderBy('nombres','ASC')->get();
        return $listaPersonas;

    }


    function verificarAsistenciaDePersona($codPersona){
      $list = PPM_Participacion::where('codEjecucionActividad',$this->getId())->where('codPersona',$codPersona)->get();
      return count($list)>0;
    }

    public function getActividad(){
      return PPM_Actividad::findOrFail($this->codActividad);
    }

    public function getFechaInicio(){
      return Fecha::formatoParaVistas($this->fechaInicio);

    }
    public function getFechaFin(){
      return Fecha::formatoParaVistas($this->fechaFin);
      
    }


    public function getListaArchivoServicio(){
      return PPM_ArchivoEjecucion::where('codEjecucionActividad',$this->getId())->get();
    }


    //se eliminan las que no tienen ninguna ejecucion actividad que haga que existan
    public function eliminarRelacionOrganizacionSemestre_NoSustentadas(){
      $organizacion = $this->getOrganizacion();
        
      // primero eliminamos las relacion_organizacion_semestre que no corresponden
      // Recorremos cada RelacionOrganizacionSemestre de esta organizacion y a cada una le buscamos una actividad (minimo), si no encontramos, borramos la relacion
      $listaRelaciones = PPM_RelacionOrganizacionSemestre::where('codOrganizacion',$organizacion->codOrganizacion)->get();
      foreach ($listaRelaciones as $relacion) {
        //  (1),(2)  like %(2)%
        $buscar = PPM_EjecucionActividad::where('codsSemestres','like',"%(".$relacion->codSemestre.")%")
        ->where('codIndicador',$relacion->codIndicador)
        ->where('codOrganizacion',$relacion->codOrganizacion)
        ->get();

        if(count($buscar)==0){
          $relacion->delete();
        }
      }

    }

    public function crearRelacionOrganizacionSemestre_NoExistentes(){

      $organizacion = $this->getOrganizacion();
      //Ahora creamos las relacion_organizacion_semestre que no existan
      $semestres = $this->getSemestres();
    
      foreach ($semestres as $semestre) {
      

        //verificamos si ya existe la relacion semestre-org-indicador (con cada uno de los semestres)
        $existe = PPM_RelacionOrganizacionSemestre::BuscarRegistro($organizacion,$semestre);
        if($existe){
          $relacion = $existe;
          $relacion->añadirEjecucionQueSustenta($this);
          $relacion->save();

        }else{
          $relacion = new PPM_RelacionOrganizacionSemestre();
          $relacion->codSemestre = $semestre->codSemestre;
          $relacion->codOrganizacion = $organizacion->codOrganizacion;
          
          $relacion->añadirEjecucionQueSustenta($this);
          $relacion->save();
        }
      }

    }


    public function eliminarRelacionPersonaSemestre_NoSustentadas(){
      $id = $this->getId();
      $lista = PPM_RelacionPersonaSemestre::where('codsEjecuciones','like',"%($id)%")->get();
      foreach ($lista as $relacion) {
        
      }


    }


    public function apareceEnOtrasTablas() : bool {
      $id = $this->getId();

      $cant = 0;

      $cant1 = PPM_Participacion::where('codEjecucionActividad',$id)->count();
      $cant2 = PPM_ArchivoEjecucion::where('codEjecucionActividad',$id)->count();
      $cant3 = PPM_RelacionOrganizacionSemestre::where('codsEjecuciones','like',"%(".$id.")%")->count();
      

      
      $cant = $cant1+$cant2+$cant3;

      return $cant > 0;

    }
    public function sePuedeBorrar(){
      
      return !$this->apareceEnOtrasTablas();
    }
    


    private static function getCodsEjecucionesValidasParaFechasFiltradas($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomicaSeleccionada) : array {
      
      $lista = PPM_EjecucionActividad::where(static::FiltroEspecialFechas($fechaInicio_sql,$fechaTermino_sql))->get();
      $array = [];
      foreach ($lista as $ejecucion) {
        $org = $ejecucion->getOrganizacion();
        $valido = false;
        
        if($codActividadEconomicaSeleccionada){
          if($org->codActividadEconomica == $codActividadEconomicaSeleccionada){
            $valido = true;
          }
        }else{
          $valido = true;
        }

        if($valido){
          $array[] = $ejecucion->getId();
        }
          
      }
      return $array;
    }

    
    

    /* OBJETOS REPORTES */
    static function getReporteServiciosPorObjetivo($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomicaSeleccionada){

      $codsEjecucionesValidas = static::getCodsEjecucionesValidasParaFechasFiltradas($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomicaSeleccionada);
      
      $string_cods = implode(",",$codsEjecucionesValidas);
      

      if($string_cods == ""){
        $where = " false ";
      }else{
        $where = " EA.codEjecucionActividad IN ($string_cods) ";
      }

      $sqlServiciosPorRegion =
          "SELECT 
            count(EA.codEjecucionActividad) as cantidad, 
            CONCAT(OB.indice,'. ',SUBSTRING(OB.nombre,1,85),'...') as objetivo,
            OB.nombre as objetivo_completo,
            OB.indice as indice
          FROM `ppm-ejecucion_actividad` EA
          INNER JOIN `ppm-objetivo` OB on OB.codObjetivo = EA.codObjetivo
          WHERE $where
          GROUP BY OB.nombre,OB.indice
          ORDER BY count(EA.codEjecucionActividad) DESC";

      $labels = [];
      $valores = [];
      $colores = [];
      $listaObjetivos = DB::select($sqlServiciosPorRegion);
      foreach ($listaObjetivos as $obj) {

          $labels[] = $obj->objetivo;
          $valores[] = $obj->cantidad;
          $r= rand(50,255);
          $g = rand(80,200);
          $colores[] = "rgb($r,$g,100)";
      }

      $resp = [
          'listaObjetivos'=>$listaObjetivos,
          'labels'=>$labels,
          'valores'=>$valores,
          'colores'=>$colores
      ];

      return $resp;
    }


    static function getReporteServiciosPorActividad($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomicaSeleccionada){

      $codsEjecucionesValidas = static::getCodsEjecucionesValidasParaFechasFiltradas($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomicaSeleccionada);
      
      $string_cods = implode(",",$codsEjecucionesValidas);
      

      if($string_cods == ""){
        $where = " false ";
      }else{
        $where = " EA.codEjecucionActividad IN ($string_cods) ";
      }

      $sqlServiciosPorRegion =
          "SELECT 
            count(EA.codEjecucionActividad) as cantidad, 
            CONCAT(A.codigo_presupuestal,') ',A.descripcion_corta) as actividad,
            CONCAT(A.codigo_presupuestal,') ',A.descripcion) as descripcion_larga
      
          FROM `ppm-ejecucion_actividad` EA
          INNER JOIN `ppm-actividad` A on A.codActividad = EA.codActividad
          WHERE $where
          GROUP BY A.descripcion_corta,A.codigo_presupuestal,A.descripcion
          ORDER BY count(EA.codEjecucionActividad) DESC";

      $labels = [];
      $valores = [];
      $colores = [];
      $listaActividades = DB::select($sqlServiciosPorRegion);
      foreach ($listaActividades as $obj) {

          $labels[] = $obj->actividad;
          $valores[] = $obj->cantidad;
          $r= rand(50,255);
          $g = rand(80,200);
          $colores[] = "rgb($r,$g,100)";
      }

      $resp = [
          'listaActividades'=>$listaActividades,
          'labels'=>$labels,
          'valores'=>$valores,
          'colores'=>$colores
      ];

      return $resp;
    }

    static function getReporteServiciosPorRegion($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomicaSeleccionada){

        $codsEjecucionesValidas = static::getCodsEjecucionesValidasParaFechasFiltradas($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomicaSeleccionada);
        
        $string_cods = implode(",",$codsEjecucionesValidas);
        
  
        if($string_cods == ""){
          $where = " false ";
        }else{
          $where = " EA.codEjecucionActividad IN ($string_cods) ";
        }

        $sqlServiciosPorRegion =
            "SELECT 
              count(EA.codEjecucionActividad) as cantidad, 
              DEP.nombre as region, 
              DEP.codDepartamento 
              
                FROM `ppm-ejecucion_actividad` EA
                INNER JOIN departamento DEP on DEP.codDepartamento = EA.codDepartamento
                WHERE $where
                GROUP BY DEP.codDepartamento,DEP.nombre
                ORDER BY count(EA.codEjecucionActividad) DESC";


        $labels = [];
        $valores = [];
        $colores = [];
        $listaRegiones = DB::select($sqlServiciosPorRegion);
        foreach ($listaRegiones as $region) {

            $labels[] = $region->region;
            $valores[] = $region->cantidad;
            $r= rand(50,255);
            $g = rand(80,200);
            $colores[] = "rgb($r,$g,100)";
        }

        $obj = [
            'listaRegiones'=>$listaRegiones,
            'labels'=>$labels,
            'valores'=>$valores,
            'colores'=>$colores
        ];

        return $obj;
    }


    public static function getReporteServiciosPorProvincia($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomicaSeleccionada){
        $codsEjecucionesValidas = static::getCodsEjecucionesValidasParaFechasFiltradas($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomicaSeleccionada);
        $string_cods = implode(",",$codsEjecucionesValidas);

        if($string_cods == ""){
          $where = " false ";
        }else{
          $where = " EA.codEjecucionActividad IN ($string_cods) ";
        }

        $sqlServiciosPorProvincia =
            "SELECT 
              count(EA.codEjecucionActividad) as cantidad, 
              P.nombre as provincia, 
              P.codProvincia,
              DEP.nombre as departamento
            FROM `ppm-ejecucion_actividad` EA
            INNER JOIN provincia P on P.codProvincia = EA.codProvincia
            INNER JOIN departamento DEP on DEP.codDepartamento = P.codDepartamento
            WHERE $where
            GROUP BY P.codProvincia,P.nombre,DEP.nombre
            ORDER BY count(EA.codEjecucionActividad) DESC";


        $labels = [];
        $valores = [];
        $colores = [];
        $listaProvincias = DB::select($sqlServiciosPorProvincia);
        foreach ($listaProvincias as $provincia) {

            $labels[] = $provincia->provincia;
            $valores[] = $provincia->cantidad;
            $r= rand(50,255);
            $g = rand(80,200);
            $colores[] = "rgb($r,$g,100)";
        }

        $obj = [
            'listaProvincias'=>$listaProvincias,
            'labels'=>$labels,
            'valores'=>$valores,
            'colores'=>$colores
        ];

        return $obj;
    }

    public static function getReporteServiciosPorUnidad($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomicaSeleccionada){
        $codsEjecucionesValidas = static::getCodsEjecucionesValidasParaFechasFiltradas($fechaInicio_sql,$fechaTermino_sql,$codActividadEconomicaSeleccionada);
        $string_cods = implode(",",$codsEjecucionesValidas);

        if($string_cods == ""){
          $where = " false ";
        }else{
          $where = " EA.codEjecucionActividad IN ($string_cods) ";
        }

        $sqlServiciosPorUnidad =
            "SELECT
                O.codOrganizacion,
                O.razon_social as razon_social ,
                count(EA.codEjecucionActividad) as CantidadEjecuciones
            FROM `ppm-organizacion` O
            INNER JOIN `ppm-ejecucion_actividad` EA on EA.codOrganizacion = O.codOrganizacion
            WHERE $where
            GROUP BY O.codOrganizacion,O.razon_social
            ORDER BY CantidadEjecuciones DESC
            ";


        $labels = [];
        $valores_CantidadEjecuciones = [];
        

        $colores = [];
        $listaUnidades = DB::select($sqlServiciosPorUnidad);
        foreach ($listaUnidades as $unid) {

    
            $labels[] = $unid->razon_social;
            
            $valores_CantidadEjecuciones[] = $unid->CantidadEjecuciones;
           
            $r= rand(50,255);
            $g = rand(80,200);
            $colores[] = "rgb($r,$g,100)";
        }

        $obj = [
            'listaUnidades'=>$listaUnidades,
            'labels'=>$labels,
            'valores_CantidadEjecuciones'=>$valores_CantidadEjecuciones,
            
            'colores'=>$colores
        ];

        return $obj;

    }


    public static function FiltroEspecialFechas($fechaInicio,$fechaFin){
      return function($query) use ($fechaInicio,$fechaFin) {
        $query->where(function($query1) use ($fechaInicio,$fechaFin){
         $query1->where('fechaInicio','<=',$fechaInicio)->where('fechaFin','>=',$fechaInicio)->where('fechaFin','<=',$fechaFin);
        })
        ->orWhere(function($query2) use ($fechaInicio,$fechaFin){
         $query2->where('fechaInicio','>=',$fechaInicio)->where('fechaInicio','<=',$fechaFin)->where('fechaFin','>=',$fechaFin);
        })
        ->orWhere(function($query3) use ($fechaInicio,$fechaFin){
         $query3->where('fechaInicio','<=',$fechaInicio)->where('fechaFin','>=',$fechaFin);
        })
        ->orWhere(function($query4) use ($fechaInicio,$fechaFin){
         $query4->where('fechaInicio','>=',$fechaInicio)->where('fechaFin','<=',$fechaFin);
        });
     };

    }


    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */
    /* ----------------------------------------- HTML COMPONENTS ------------------------------------ */


    public function html_getArchivosDelServicio(bool $mostrarBotonEliminar){
      
      $listaArchivos = [];
      foreach($this->getListaArchivoServicio() as $archivoServicio) {
          $archivoGen = $archivoServicio->getArchivo();
          array_push($listaArchivos,[
              'nombreAparente'=> $archivoGen->nombreAparente,
              'linkDescarga'=> route('PPM.Actividad.DescargarArchivo',$archivoGen->getId()),
              'linkEliminar' => route('PPM.Actividad.EliminarArchivo',$archivoServicio->getId())
          ]);
      }
      
      return ComponentRenderizer::DescargarArchivos("Archivos del servicio",$listaArchivos,$mostrarBotonEliminar);
    }

    
}
