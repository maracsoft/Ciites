<?php

namespace App\Models\PPM;

use App\ArchivoGeneral;
use App\Departamento;
use App\Distrito;
use App\Empleado;
use App\MaracModel;
use App\Semestre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PPM_RelacionOrganizacionSemestre extends MaracModel
{
    public $table = "ppm-relacion_organizacion_semestre";
    protected $primaryKey ="codRelacion";

    public $timestamps = false;
    protected $fillable = [''];

    public function getSemestre(){
      return Semestre::findOrFail($this->codSemestre);
    }

    public function getOrganizacion(){
      return PPM_Organizacion::findOrFail($this->codOrganizacion);
    }

    

    public function getMarcaciones(){
      return PPM_FGE_Marcacion::where('codRelacion',$this->codRelacion)->get();
    }

    public function calcularNivelGestionEmpresarial()  {
      
      $segmentos = PPM_FGE_Segmento::All();
      
      $sum_segmentos = 0;
      $cant_segmentos = 0;
      foreach ($segmentos as $segmento) {
        $sum_items = 0;
        $cant_items = 0;
        foreach ($segmento->getItems() as $item) {
          $marcacion = PPM_FGE_Marcacion::getByRelacionItem($this,$item);
          $option_seleccionada = $marcacion->getOptionSeleccionada();
          $sum_items += $option_seleccionada->valor;
          $cant_items++;
        }

        $promedio_segmento_actual = $sum_items/$cant_items;
        $sum_segmentos += $promedio_segmento_actual;
        $cant_segmentos++;
      }

      $promedio_final = $sum_segmentos / $cant_segmentos;

      return $promedio_final;
    }

    public function getNivelGestionEmpresarialLabel(){
      $nivel = $this->nivel_gestion_empresarial;
      if($nivel <= 0.8){
        return "En Etapa Inicial";
      }
      if($nivel <= 1.6){
        return "En fortalecimiento interno";
      }
      if($nivel <= 2.4){
        return "En desarrollo";
      }
      if($nivel <= 3.2){
        return "Fortaleciendo la inserción al mercado";
      }
      if($nivel <= 4){
        return "Posicionada en el mercado y responsable socialmente";
      }
    }
    
    public static function BuscarRegistro(PPM_Organizacion $organizacion, Semestre $semestre){
      $search = PPM_RelacionOrganizacionSemestre::where('codOrganizacion',$organizacion->codOrganizacion)
                                        ->where('codSemestre',$semestre->codSemestre)
                                        ->get();

      if(count($search) == 0){
        return false;
      }
      return $search[0];
    }

    public function getEmpleadosCreadores(){

      $ejecuciones = $this->getEjecucionesQueSustentan();
      $array = [];
      foreach ($ejecuciones as $ejec) {
        $array[] = $ejec->codEmpleadoCreador;
      }

      return Empleado::whereIn('codEmpleado',$array)->get();
    }

    
    public function getDepartamentosEjecucion(){

      $ejecuciones = $this->getEjecucionesQueSustentan();
      $array = [];
      foreach ($ejecuciones as $ejec) {
        $array[] = $ejec->codDepartamento;
      }
      
      return Departamento::whereIn('codDepartamento',$array)->get();
    }

    public function getEjecucionesQueSustentan(){
      $string = str_replace("(","",$this->codsEjecuciones);
      $string = str_replace(")","",$string);
      
      $array = explode(",",$string);

      return PPM_EjecucionActividad::whereIn('codEjecucionActividad',$array)->get();
    }
        
    public function getCodsEjecucionesSinParentesis(){
      $string = str_replace("(","",$this->codsEjecuciones);
      $string = str_replace(")","",$string);
      return $string;
    }

    public function getEmpleadosCreadoresLabel(){
      $empleados = $this->getEmpleadosCreadores();
      $array_nombres = [];
      foreach ($empleados as $empleado) {
        $array_nombres[] = $empleado->getNombreCompleto();
      }

      return implode(",",$array_nombres);
    }


    public function getDepartamentosLabel(){
      $departamentos = $this->getDepartamentosEjecucion();
      $array_nombres = [];
      foreach ($departamentos as $depa) {
        $array_nombres[] = $depa->nombre;
      }

      return implode(",",$array_nombres);
    }


    public function añadirEjecucionQueSustenta(PPM_EjecucionActividad $ejecucion){
 
      $ejecuciones = $this->getEjecucionesQueSustentan();
      $codsEjecuciones_new = [];
      foreach ($ejecuciones as $ejecucion) {
        $codsEjecuciones_new[] = "(".$ejecucion->codEjecucionActividad.")";
      }

      $new = "(".$ejecucion->codEjecucionActividad.")";
      if(!in_array($new,$codsEjecuciones_new)){
        $codsEjecuciones_new[] = $new;
      }
      asort($codsEjecuciones_new);
      
      $this->codsEjecuciones =  implode(",",$codsEjecuciones_new);

    }
    

    public function quitarEjecucionQueSustenta(PPM_EjecucionActividad $ejecucion_eliminar){
      //primero agarramos la lista de ejecuciones, exceptuando la que vamos a quitar
      $ejecuciones = $this->getEjecucionesQueSustentan();
      foreach ($ejecuciones as $ejecucion_i) {
        $lista_ejecuciones = new Collection();
        if($ejecucion_i->getId() == $ejecucion_eliminar->getId()){

        }else{
          $lista_ejecuciones->push($ejecucion_i);
        }
      }
      // reseteamos los cods actuales
      
      
      $this->codsEjecuciones = "";
      $this->save();

      //de luego añadimos 
      foreach ($lista_ejecuciones as $ejecucion_j) {
         $this->añadirEjecucionQueSustenta($ejecucion_j);
      }
      $this->save();

      //si al quitar la ejecucion, ya no quedó ninguna, se elimina puesto que no está sustentada en ninguna ejecucion
      if(count($lista_ejecuciones) == 0){
        $this->eliminarRegistroEHijos();
      }  
    }


    public function eliminarRegistroEHijos(){
      PPM_FGE_Marcacion::where('codRelacion',$this->getId())->delete();
      
      $detalles = PPM_DetalleProducto::where('codRelacion',$this->getId())->get();
      foreach ($detalles as $det) {
        PPM_AsistenciaDetalleprod::where('codDetalleProducto',$det->codDetalleProducto)->delete();
        $det->delete();
      }

      $this->delete();
    }


    public function getDetallesProducto_Producto(){
      $codTipoProducto_Producto = PPM_TipoProducto::getCodigoDeProducto();
      $detalles = PPM_DetalleProducto::where('codRelacion',$this->getId())->where('codTipoProducto',$codTipoProducto_Producto)->get();
      return $detalles;

    }
    public function getDetallesProducto_CultivoCadena(){
      $codTipoProducto_cultivocadena = PPM_TipoProducto::getCodigoDeCultivoCadena();
      $detalles = PPM_DetalleProducto::where('codRelacion',$this->getId())->where('codTipoProducto',$codTipoProducto_cultivocadena)->get();
      return $detalles;
      
    }
    

}