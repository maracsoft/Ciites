<?php

namespace App\Models\PPM;

use App\Debug;
use App\Models\CITE\RelacionUsuarioUnidad;
use App\Models\CITE\UnidadProductiva;
use App\Models\CITE\UsuarioCite;

class PPM_Sincronizador
{

  const Organizacion = "ORG";
  const UnidadProductiva = "UNI";
  
  public static function SincronizarSocios(PPM_Organizacion $organizacion, UnidadProductiva $unidad_productiva) : array {
    
    Debug::LogMessage("Inicio de sincronización de org ".$organizacion->getId(). " y unidad ". $unidad_productiva->getId());
    

    $dnis_organizacion = [];
    foreach ($organizacion->getRelacionesPersonasAsociadas() as $suscripcion) {
      $persona = $suscripcion->getPersona();
      if($persona->dni){
        $dnis_organizacion[] = $persona->dni;
      }
    }
    
    $dnis_unidad = [];
    foreach ($unidad_productiva->getUsuariosAsociados() as $usuario) {
      if($usuario->dni){
        $dnis_unidad[] = $usuario->dni;
      }
    }

    Debug::LogMessage("dnis_organizacion ". json_encode($dnis_organizacion));
    Debug::LogMessage("dnis_unidad ". json_encode($dnis_unidad));
    
    
    //obtenemos a los dnis que están en la organizacion pero no en la unidad
    $dnis_organizacion_nounidad = [];
    foreach ($dnis_organizacion as $dni) {
      
      $esta_en_unidad = in_array($dni,$dnis_unidad);
      if(!$esta_en_unidad){
        $dnis_organizacion_nounidad[] = $dni;
      }
    }


    //obtenemos a los dnis que están en la unidad pero no en la organizacion
    $dnis_unidad_noorganizacion = [];
    foreach ($dnis_unidad as $dni) {
      $esta_en_organizacion = in_array($dni,$dnis_organizacion);
      if(!$esta_en_organizacion){
        $dnis_unidad_noorganizacion[] = $dni;
      }
    }


    Debug::LogMessage("dnis_organizacion_nounidad ". json_encode($dnis_organizacion_nounidad));
    Debug::LogMessage("dnis_unidad_noorganizacion ". json_encode($dnis_unidad_noorganizacion));
    
     
    
    //recorremos a las personas de la organizacion que no estan en la unidad, verificamos si existen como usuariocite y las suscribimos a la unidad
    foreach ($dnis_organizacion_nounidad as $dni) {
      $persona = PPM_Persona::findByDNI($dni);
      $existe_usuario_cite = $persona->existeUsuarioCiteConEstosDatos();
      if($existe_usuario_cite){
        $usuario_cite = UsuarioCite::findByDNI($dni);
      
        $usuario_cite->save();
      }else{
        $usuario_cite = $persona->crearUsuarioCiteConEstosDatos();
      }

      //lo suscribimos a la unidad
      $suscripcion_unidad = new RelacionUsuarioUnidad();
      $suscripcion_unidad->codUnidadProductiva = $unidad_productiva->getId();
      $suscripcion_unidad->codUsuario = $usuario_cite->getId();
      $suscripcion_unidad->save();
    }


    //recorremos a los usuariosCite de la unidad que no estan en la organizacion, verificamos si existen como personas y las suscribimos a la organizacion
    foreach ($dnis_unidad_noorganizacion as $dni) {
      $usuario_cite = UsuarioCite::findByDNI($dni);
      $existe_persona = $usuario_cite->existePersonaPPMConEstosDatos();
      if($existe_persona){
        $persona = PPM_Persona::findByDNI($dni);
       
        $usuario_cite->save();

      }else{
        $persona = $usuario_cite->crearPersonaPPMConEstosDatos();
      }

      //lo suscribimos a la org
      $suscripcion_org = new PPM_Inscripcion();
      $suscripcion_org->codOrganizacion = $organizacion->codOrganizacion;
      $suscripcion_org->codPersona = $persona->codPersona;
      $suscripcion_org->cargo = "-";
      $suscripcion_org->save();

    }

    //------------ a esta altura todas las personas tienen su par de usuario cite
    // cruzamos los datos que se tengan de cada una 
    foreach ($organizacion->getPersonasAsociadas() as $persona) {
      $usuario_cite = UsuarioCite::findByDNI($persona->dni);

      static::ComplementarCamposFaltantes($persona,$usuario_cite);
    }

    Debug::LogMessage("Fin de sincronización de org ".$organizacion->getId(). " y unidad ". $unidad_productiva->getId());

    $response_array = [
      "dnis_añadidos_a_unidad" => $dnis_organizacion_nounidad,
      "dnis_añadidos_a_organizacion" => $dnis_unidad_noorganizacion,
    ];
    return $response_array;

  }


  private static function GetMsjAñadicion($dnis_añadidos, $tipo_añadicion){

    if(count($dnis_añadidos['dnis_añadidos_a_unidad']) == 0){
      $dnis_añadidos_a_unidad_msj = "No se añadió ningún DNI a la unidad productiva";
    }else{
      $dnis_añadidos_a_unidad_msj = "Se añadieron las siguientes personas a la unidad productiva (DNIs): ".implode(",",$dnis_añadidos['dnis_añadidos_a_unidad']);
    }
    
    if(count($dnis_añadidos['dnis_añadidos_a_organizacion']) == 0){
      $dnis_añadidos_a_organizacion_msj = "No se añadió ningún DNI a la organizacion";
    }else{
      $dnis_añadidos_a_organizacion_msj = "Se añadieron las siguientes personas a la organización (DNIs): ".implode(",",$dnis_añadidos['dnis_añadidos_a_organizacion']);
    }
    
    //orden del mensaje
    if($tipo_añadicion == static::Organizacion){
      $msj_dnis = $dnis_añadidos_a_organizacion_msj." y " . $dnis_añadidos_a_unidad_msj;
    }else{
      $msj_dnis = $dnis_añadidos_a_unidad_msj." y " . $dnis_añadidos_a_organizacion_msj;
    }
    

    $msj = "Se realizó la sincronización correctamente:   ".$msj_dnis;
    return $msj;
  }

  public static function GetMsjAñadicionOrganizacion($dnis_añadidos){
    return static::GetMsjAñadicion($dnis_añadidos,static::Organizacion);
  }

  public static function GetMsjAñadicionUnidad($dnis_añadidos){
    return static::GetMsjAñadicion($dnis_añadidos,static::UnidadProductiva);
  }
  

  //complementa los datos faltantes de persona o usuariocite, jalandolo de su vinculado
  private static function ComplementarCamposFaltantes(PPM_Persona $persona, UsuarioCite $usuario){
    

    //si la persona tiene telefono pero el usuario no
    if($persona->telefono && !$usuario->telefono){
      
    
      $usuario->telefono = $persona->telefono;
    }
    //si el usuario tiene telefono pero la persona no
    if($usuario->telefono && !$persona->telefono){
      
    
      $persona->telefono = $usuario->telefono;
    }


    //si la persona tiene correo pero el usuario no
    if($persona->correo && !$usuario->correo){
      
    
      $usuario->correo = $persona->correo;
    }
    //si el usuario tiene correo pero la persona no
    if($usuario->correo && !$persona->correo){
      
    
      $persona->correo = $usuario->correo;
    }

    
    $persona->save();
    $usuario->save();
    
  }


}