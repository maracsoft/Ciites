<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ArchivoOrdenCompra;
use App\ArchivoProyecto;
use App\ArchivoRendicion;
use App\ArchivoReposicion;
use App\ArchivoReqAdmin;
use App\ArchivoReqEmp;
use App\ArchivoSolicitud;
use App\Configuracion;
use App\DetalleRendicionGastos;
use App\DetalleReposicionGastos;
use App\Empleado;
use App\ErrorHistorial;
use App\EstadoRendicionGastos;
use App\EstadoReposicionGastos;
use App\EstadoRequerimientoBS;
use App\EstadoSolicitudFondos;
use App\FakerCedepas;
use App\Numeracion;
use App\OperacionDocumento;
use App\Proyecto;
use App\Puesto;
use App\RendicionGastos;
use App\ReposicionGastos;
use App\RequerimientoBS;
use App\RespuestaAPI;
use App\SolicitudFondos;
use App\TipoOperacion;
use DateTime;
use Facade\FlareClient\Report;
use Illuminate\Support\Facades\DB;


class PobladorBDController extends Controller
{   
/* 
ESTE CONTROLLER SIRVE PARA POBLAR DE DATOS ALEATORIOS A LA TABLA REPOSICIÓN DE GASTOS, DETALLE REPOSICION Y OPERACION_DOCUMENTO
SOLO SE USARÁ PARA EL PROYECTO DE SISTEMAS DE INFORMACIÓN GERENCIAL.
*/

/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */
/* ----------- PELIGRO -------- NO CORRER EN PRODUCCIÓN -------- PELIGRO -------- NO CORRER EN PRODUCCIÓN --------  */

   
    const cantidadRepos                 = 50;
    const cantDetalles_limInf           =  4;
    const cantDetalles_limSup           = 15;
    const tiempoAprobacion_limInf       =  1;
    const tiempoAprobacion_limSup       = 10;
    const tiempoAbonacion_limInf        =  1;
    const tiempoAbonacion_limSup        = 10;
    const tiempoContabilizacion_limInf  =  1;
    const tiempoContabilizacion_limSup  = 10;

    const tiempoObservacion_limInf  =  1;
    const tiempoObservacion_limSup  = 10;
    
    const tiempoEdicion_limInf = 1;
    const tiempoEdicion_limSup = 10;

    const tiempoRechazo_limInf  =  1;
    const tiempoRechazo_limSup  = 10;
    

 
    function poblarReposiciones(){
        if(Configuracion::enProduccion())
            return "CUIDADO, ESTÁS EN PRODUCCIÓN Y NO DEBERÍAS CORRER ESTA FUNCION PORQUE ES SOLO PARA EL CURSO DE SIG";

        /* Primero generaré una Reposicion */

        $cantidadRepos = static::cantidadRepos;
        /* 
            REPO = 11 000
            DET = 106 000
            OP =   51 000
                168 000

            DEBO HACER 6 500 REPOS PARA OBTENER 100 000 REGISTROS ENTRE TODOS
            HARÉ 7 000
        */
        try{
            
            for ($j=0; $j < $cantidadRepos ; $j++){
                DB::beginTransaction();
                
                //Sistema de distribución probabilistica
                $aleat = rand(1,10);
                $this->flujo1();

                //switch($aleat){
                //    case 1: case 2: case 3: case 4: $this->flujo1(); break;
                //    case 5: $this->flujo2(); break;
                //    case 6: $this->flujo3(); break;
                //    case 7: $this->flujo4(); break;
                //    case 8: $this->flujo5(); break;
                //    case 9: $this->flujo6(); break;
                //    case 10: $this->flujo7(); break;
                //}
                //
                db::commit();
                error_log($j);
            }

            $cant = count(OperacionDocumento::All()) + count(ReposicionGastos::All()) + count(DetalleReposicionGastos::All()); 
            return "exito. Cantidad de registros totales:".$cant;  
            
        } catch (\Throwable $th) {
            
            DB::rollBack();
            error_log($th);
            throw $th;
            return "FALLO";
        }


    }


    /* Cada uno de estos flujos implica una serie diferente de actividades, creé varios para generar diversidad en la BD*/
    function flujo1(){
        //Flujo original, sin interrupciones

        $rep = $this->crearRepo();
        $rep = $this->aprobarRepo($rep);
        $rep = $this->abonarRepo($rep);
        $rep = $this->contabilizarRepo($rep);

    }

    function flujo2(){
        //El gerente observa una vez

        $rep = $this->crearRepo();
        $rep = $this->observarRepo($rep,$rep->getProyecto()->codEmpleadoDirector); //el gerente observa

        $rep = $this->editarRepo($rep); //empleado subsana
        
        $rep = $this->aprobarRepo($rep);
        $rep = $this->abonarRepo($rep);
        $rep = $this->contabilizarRepo($rep);


    }



    function flujo3(){
        //admin observa
        $rep = $this->crearRepo();
        $rep = $this->aprobarRepo($rep);


        $rep = $this->observarRepo($rep, Empleado::getAdministradorAleatorio()->codEmpleado); //el admin observa
        $rep = $this->editarRepo($rep); //empleado subsana

        $rep = $this->aprobarRepo($rep);
        $rep = $this->abonarRepo($rep);
        $rep = $this->contabilizarRepo($rep);

    }


    function flujo4(){
        //gerente observa 2 veces

        $rep = $this->crearRepo();

        $rep = $this->observarRepo($rep,$rep->getProyecto()->codEmpleadoDirector); //el gerente observa
        $rep = $this->editarRepo($rep); //empleado subsana
        
        $rep = $this->observarRepo($rep, $rep->getProyecto()->codEmpleadoDirector); //el gerente observa
        $rep = $this->editarRepo($rep); //empleado subsana
        
        $rep = $this->aprobarRepo($rep);
        $rep = $this->abonarRepo($rep);
        $rep = $this->contabilizarRepo($rep);

    }

    function flujo5(){
        // gerente rechaza
        $rep = $this->crearRepo();
        $rep = $this->rechazarRepo($rep,$rep->getProyecto()->codEmpleadoDirector);

    }

    function flujo6(){
        // admin rechaza
        $rep = $this->crearRepo();
        $rep = $this->aprobarRepo($rep);
        $rep = $this->rechazarRepo($rep,Empleado::getAdministradorAleatorio()->codEmpleado );

    }


    function flujo7(){
        //gerente observa, emp subsana, admin observa, emp subsana, y sigue normal
        $rep = $this->crearRepo();

        $rep = $this->observarRepo($rep,$rep->getProyecto()->codEmpleadoDirector); //el gerente observa
        $rep = $this->editarRepo($rep); //empleado subsana
        
        $rep = $this->aprobarRepo($rep);

        $rep = $this->observarRepo($rep, Empleado::getAdministradorAleatorio()->codEmpleado ); // 
        $rep = $this->editarRepo($rep); //empleado subsana
        
        $rep = $this->aprobarRepo($rep);
        $rep = $this->abonarRepo($rep);
        $rep = $this->contabilizarRepo($rep);

    }







    /* FLUJO ORIGINAL */

    function crearRepo() : ReposicionGastos{

        $cuerpo = FakerCedepas::poblar_REP_generarCuerpo();
        $rep = new ReposicionGastos($cuerpo);
        Numeracion::aumentarNumeracionREP();
        $rep->save();

        $cantidadDetalles = rand(static::cantDetalles_limInf,static::cantDetalles_limSup);
        $monto = 0;
        for ($i=1; $i <= $cantidadDetalles ; $i++) { 
            $cuerpoDet = FakerCedepas::poblar_REP_GenerarDetalle($rep,$i);
            $detalleRep = new DetalleReposicionGastos($cuerpoDet);
            $detalleRep->save();
            $monto += $detalleRep-> importe;
        }
        
        $rep->totalImporte = $monto; 
        $rep->save();

        $rep->registrarOperacionBase(
            TipoOperacion::getCodTipoOperacion('REP','Crear'),
            null,
            Puesto::getCodPuesto_Empleado(),
            $rep->fechaHoraEmision,
            $rep->codEmpleadoSolicitante
        );

        //FIN CREACION
        return $rep;

         
    }

    function aprobarRepo($rep) : ReposicionGastos{


        //INICIO APROBACIÓN
        $empGerente = $rep->getProyecto()->getGerente();
        $x = rand(static::tiempoAprobacion_limInf,static::tiempoAprobacion_limSup);
        $fechaAprobacion = date("Y-m-d",strtotime($rep->getFechaHoraUltimaOperacion()."+ $x days")); 

        $rep->codEstadoReposicion =  ReposicionGastos::getCodEstado('Aprobada');
        $rep->codEmpleadoEvaluador = $empGerente->codEmpleado;
        $rep->fechaHoraRevisionGerente= $fechaAprobacion;
        $rep->save();

        $rep->registrarOperacionBase(
            TipoOperacion::getCodTipoOperacion('REP','Aprobar'),
            null, 
            Puesto::getCodPuesto_Gerente(),
            $fechaAprobacion,
            $empGerente->codEmpleado
        );

        // FIN APROBACIÓN
        return $rep;

    }

    function abonarRepo($rep) : ReposicionGastos{
        //INICIO ABONACIÓN
        $empAdministrador = Empleado::getAdministradorAleatorio();
        $x = rand(static::tiempoAbonacion_limInf,static::tiempoAbonacion_limSup);
        $fechaAbonacion = date("Y-m-d",strtotime($rep->getFechaHoraUltimaOperacion()."+ $x days")); 

        $rep->codEstadoReposicion=ReposicionGastos::getCodEstado('Abonada');
        $rep->codEmpleadoAdmin= $empAdministrador->codEmpleado;
        $rep->fechaHoraRevisionAdmin= $fechaAbonacion;
        $rep->save();

        $rep->registrarOperacionBase(
            TipoOperacion::getCodTipoOperacion('REP','Abonar'),
            null, 
            Puesto::getCodPuesto_Administrador(),
            $fechaAbonacion,                    
            $empAdministrador->codEmpleado

        ); //siempre abonará el admin

        // FIN ABONACIÓN    
        return $rep;


    }

    function contabilizarRepo($rep): ReposicionGastos{
        // INICIO CONTABILIZACION
        $empContador = Empleado::getContadorAleatorio($rep->codProyecto);
        $x = rand(static::tiempoContabilizacion_limInf,static::tiempoContabilizacion_limSup);
        $fechaContabilizacion = date("Y-m-d",strtotime($rep->getFechaHoraUltimaOperacion()."+ $x days")); 

        $rep->codEstadoReposicion =  ReposicionGastos::getCodEstado('Contabilizada');
        $rep->codEmpleadoConta = $empContador->codEmpleado;
        $rep->fechaHoraRevisionConta= $fechaContabilizacion ;
        $rep->save();

        $rep->registrarOperacionBase(
            TipoOperacion::getCodTipoOperacion('REP','Contabilizar'),
            null, 
            Puesto::getCodPuesto_Contador(),
            $fechaContabilizacion,
            $empContador->codEmpleado
        ); 
        $detallesDeReposicion = $rep->detalles();
        foreach ($detallesDeReposicion as $detGasto) { //guardamos como contabilizados los items que nos llegaron
            $detGasto->contabilizado = 1;
            $detGasto->pendienteDeVer = 0;                          

            $detGasto->save();   
        }
        // FIN CONTABILIZACION

        return $rep;
    }


    /* FLUJOS ALTERNOS */

    function observarRepo($rep,$codEmpleadoObservador) : ReposicionGastos{
        $x = rand(static::tiempoObservacion_limInf,static::tiempoObservacion_limSup);
        $fechaObservacion = date("Y-m-d",strtotime($rep->getFechaHoraUltimaOperacion()."+ $x days")); 

        $empObservador = Empleado::findOrFail($codEmpleadoObservador);

        $rep->observacion="Incorrectos comprobantes, no se pueden leer.";
             
        $rep->save();

        $rep->registrarOperacionBase(
            TipoOperacion::getCodTipoOperacion('REP','Observar'),
            $rep->observacion, 
            $empObservador->codPuesto,
            $fechaObservacion,
            $codEmpleadoObservador,
        ); 

        return $rep;
    }


    function editarRepo($rep) : ReposicionGastos{
         
        $x = rand(static::tiempoEdicion_limInf,static::tiempoEdicion_limSup);
        $fechaEdicion = date("Y-m-d",strtotime($rep->getFechaHoraUltimaOperacion()."+ $x days")); 

        $rep->resumen=$rep->resumen." editada";
        //si estaba observada, pasa a subsanada
        if($rep->verificarEstado('Observada'))
            $rep->codEstadoReposicion = ReposicionGastos::getCodEstado('Subsanada');
        else
            $rep->codEstadoReposicion = ReposicionGastos::getCodEstado('Creada');
        $rep-> save();        
        
        $rep->registrarOperacionBase(
            TipoOperacion::getCodTipoOperacion('REP','Editar'),
            null, 
            Puesto::getCodPuesto_Empleado(),
            $fechaEdicion,
            $rep->codEmpleadoSolicitante        
        ); //siempre EditarA el empleado
        
        return $rep;


    }


    function rechazarRepo($rep,$codEmpleadoRechazador) : ReposicionGastos{
        
        
        $x = rand(static::tiempoRechazo_limInf,static::tiempoRechazo_limSup);
        $fechaRechazo = date("Y-m-d",strtotime($rep->getFechaHoraUltimaOperacion()."+ $x days")); 

        $empRechazador = Empleado::findOrFail($codEmpleadoRechazador);


        if($empRechazador->esJefeAdmin()){
            $rep->codEmpleadoAdmin=$empRechazador->codEmpleado;
            $rep->fechaHoraRevisionAdmin=  $fechaRechazo;
        }
        if($empRechazador->esGerente()){
            $rep->codEmpleadoEvaluador=$empRechazador->codEmpleado;
            $rep->fechaHoraRevisionGerente=  $fechaRechazo;
        }


        $rep->codEstadoReposicion=ReposicionGastos::getCodEstado('Rechazada');
        $rep->save();

        $rep->registrarOperacionBase(
            TipoOperacion::getCodTipoOperacion('REP','Rechazar'),
            null, 
            $empRechazador->codPuesto,
            $fechaRechazo,
            $codEmpleadoRechazador
        ); //siempre 
        
        return $rep;

    }


}
