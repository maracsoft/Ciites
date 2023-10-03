<?php

namespace App\Models\PPM;


use App\ArchivoGeneral;
use App\Debug;
use App\Distrito;
use App\MaracModel;
use App\Models\PPM\PPM_Inscripcion;
use App\Models\CITE\UnidadProductiva;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PPM_Organizacion extends MaracModel
{
    public $table = "ppm-organizacion";
    protected $primaryKey = "codOrganizacion";

    public $timestamps = false;
    protected $fillable = [''];

    
    
    public static function TodasParaSelect(){
      $list = PPM_Organizacion::All();
      foreach ($list as $u) {
        $u->razonYRUC = $u->getDenominacion()." - ".$u->getRucODNI();
      }
      return $list;
    }
 
    //Por defecto retorna la razón social, si no tiene retorna la persona, y si no tiene LANZA ERROR
    function getDenominacion(){

        if ($this->razon_social != "")
            return $this->razon_social;

        
        
        return "EN PROCESO DE FORMALIZACIÓN";
      
    }

    public function getTipoOrganizacion(){
      return PPM_TipoOrganizacion::findOrFail($this->codTipoOrganizacion);
    }

    //Por defecto retorna la razón social, si no tiene retorna la persona, y si no tiene LANZA ERROR
    function getRucODNI(){

        if ($this->ruc != "")
            return $this->ruc;
         
        return "EN PROCESO DE FORMALIZACIÓN";


        
    }

    function getActividadEconomica(){
      return PPM_ActividadEconomica::findOrFail($this->codActividadEconomica);
    }

    public function getCantidadEjecuciones(){
      return PPM_EjecucionActividad::where('codOrganizacion',$this->codOrganizacion)->count();
    }
    
    public function getCantidadAsociados(){
      return PPM_Inscripcion::where('codOrganizacion',$this->codOrganizacion)->count();
    }
    
    public function getEjecuciones(){
      return PPM_EjecucionActividad::where('codOrganizacion',$this->codOrganizacion)->get();
    }

    public function getRelacionesPersonasAsociadas(){
      return PPM_Inscripcion::where('codOrganizacion',$this->codOrganizacion)->get();
    }

    function getPersonasAsociadas(){
      $lista = $this->getRelacionesPersonasAsociadas();
      $array = [];
      foreach ($lista as $rela) {
          array_push($array,$rela->codPersona);
      }

      $listaUsuarios = PPM_Persona::whereIn('codPersona',$array)
                        ->orderBy('nombres','ASC')
                        ->orderBy('apellido_paterno','ASC')
                        ->get();
      return $listaUsuarios;

    }

    public function tienePersonaAsociada($codPersona){
      $lista = PPM_Inscripcion::where('codOrganizacion',$this->codOrganizacion)
          ->where('codPersona',$codPersona)
          ->get();

      return count($lista) > 0;

    }


    function getTextoLugar(){
        if (!$this->codDistrito)
            return "NO INFO";

        $dist = $this->getDistrito();
        return $dist->getTextoUbicacion();
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

    function tieneActividadEconomica(){
        return $this->tiene_act_economica == 1;
    }
    function tieneEnlaceCite(){
      return $this->activar_enlace_cite == 1;
    }
    function documentoEnTramite(){
      return $this->documento_en_tramite == 1;
    }
    

    function getDepartamento(){
        if (!$this->codDistrito)
            return "NO INFO";

        $dist = $this->getDistrito();
        return $dist->getProvincia()->getDepartamento();
    }


    function getProvincia(){
        if (!$this->codDistrito)
            return "NO INFO";

        $dist = $this->getDistrito();
        return $dist->getProvincia();
    }


    public function getDistrito(){
        if (!$this->codDistrito)
            return "NO INFO";
        return Distrito::findOrFail($this->codDistrito);
    }

    public function getTipoDocumento(){
      return PPM_TipoDocumento::findOrFail($this->codTipoDocumento);
    }


    public function procesarRequest(Request $request){

      $distrito = Distrito::findOrFail($request->ComboBoxDistrito);
      $provincia = $distrito->getProvincia();
      $departamento = $provincia->getDepartamento();

      $this->codTipoDocumento = $request->codTipoDocumento;
      
      
      $this->tiene_act_economica =intval($request->boolean('tiene_act_economica'));
      $this->activar_enlace_cite =intval($request->boolean('activar_enlace_cite'));
      
      $this->codTipoOrganizacion = $request->codTipoOrganizacion; 
      $this->codDistrito = $request->ComboBoxDistrito;
      $this->codProvincia = $provincia->codProvincia;
      $this->codDepartamento = $departamento->codDepartamento;
      
      $this->direccion = $request->direccion;

 
 
      $this->razon_social = null;
      $this->ruc = null;

      $this->razon_social = $request->razon_social; 

      if($this->codTipoDocumento == PPM_TipoDocumento::RUC){
        $this->ruc = $request->ruc;
        $this->documento_en_tramite = intval($request->boolean('documento_en_tramite'));
      }else{
        $this->documento_en_tramite = 0;
      }

      


      if($this->tiene_act_economica == 1){
        if($request->input_nueva_actividad_boolean == "1"){ //crear nueva
       
          $nueva_actividad = new PPM_ActividadEconomica();
          $nueva_actividad->nombre = $request->input_nueva_actividad;
          $nueva_actividad->save();

          $this->codActividadEconomica = $nueva_actividad->codActividadEconomica;
        }else{

          $this->codActividadEconomica = $request->codActividadEconomica;        
        }
      }else{
        $this->codActividadEconomica = null;
      }

      if($this->activar_enlace_cite == 1){ 
        $this->codUnidadProductivaEnlazadaCITE = $request->codUnidadProductivaEnlazadaCITE;
        // AQUI FALTA AGREGAR CODIGO QUE VINCULA DESDE EL CITE A PPM
        $unid = UnidadProductiva::findOrFail($this->codUnidadProductivaEnlazadaCITE);
        $unid->codOrganizacionEnlazadaPPM = $this->getId();
        $unid->activar_enlace_ppm = 1;
        $unid->save();
      }else{

        if($this->codUnidadProductivaEnlazadaCITE != null){ //si tiene una enlazada, rompemos el enlace de UnidadProductiva a Organizacion 
          $unid = UnidadProductiva::findOrFail($this->codUnidadProductivaEnlazadaCITE);
          $unid->activar_enlace_ppm = 0;
          $unid->codOrganizacionEnlazadaPPM = null;
          $unid->save();
        }
        
        $this->codUnidadProductivaEnlazadaCITE = null;
      }


    }


    public function getUnidadProductivaEnlazada(){
      return UnidadProductiva::findOrFail($this->codUnidadProductivaEnlazadaCITE);
    }


}
