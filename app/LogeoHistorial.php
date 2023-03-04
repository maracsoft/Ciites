<?php

namespace App;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LogeoHistorial extends Model
{
    public $table = "logeo_historial";
    protected $primaryKey ="codLogeoHistorial";

    public $timestamps = false;   
    protected $fillable = ['codEmpleado','fechaHoraLogeo','ipLogeo'];

    public function getEmpleado(){
        return Empleado::findOrFail($this->codEmpleado);
    }



    //retorna una redireccion a la ruta home
    public static function registrarLogeo(){
        date_default_timezone_set('America/Lima');
        $logeo = new LogeoHistorial();
        $empleado = Empleado::getEmpleadoLogeado();
        $logeo->codEmpleado= $empleado->codEmpleado;

        $logeo->fechaHoraLogeo=new DateTime();

        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $logeo->ipLogeo=$_SERVER['HTTP_CLIENT_IP'];
        }
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $logeo->ipLogeo=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else 
            $logeo->ipLogeo=$_SERVER['REMOTE_ADDR'];

    
        $ipPrincipal = $empleado->getIPPrincipal();
        $listaIPs = $empleado->getListaIPs();
        $ipLogeo = $logeo->ipLogeo;
        
        /*
        if(!in_array($ipLogeo,$listaIPs)){// DETECTÓ IRREGULARIDAD
            MaracsoftBot::enviarMensaje(
                "ALERTA. Inicio de sesión nuevo de '".$empleado->getNombreCompleto()."'. Acaba de ingresar con la IP ".$ipLogeo.
                " que no corresponde con su inicio de sesión normal de IP ".$ipPrincipal. " y no está en la lista de IPs anteriores: ".json_encode($listaIPs). "            Información de logeo: ".json_encode($logeo));
            

            if(Configuracion::activarSeguridadIPs()){
                //cerramos la sesion del usuario manualmente
                Auth::logout();
                //redirigimos al login para que muestre el msj
                return redirect()->route('user.verLogin')
                    ->with('datos','Se le ha negado el acceso al sistema debido a actividad sospechosa, contacte con un administrador del sistema para recuperar el acceso.');
            }else{ //Solo guardamos la IP si se le dejó entrar al sistema
                $logeo->save();
            }
            
        }else{//Si no detectó irregularidad, guarda normal
            $logeo->save(); 
        }
         */


        $logeo->save();
        //if($empleado->esGerente() || $empleado->esObservador())
        //  return redirect()->route('GestionProyectos.VerDashboard');

        return redirect()->route('user.home');
    }

    public function getNombreEmpleado(){
        $empleado=Empleado::findOrFail($this->codEmpleado);
        return $empleado->getNombreCompleto();
    }

    public function getFechaHora(){
        
        return date('d/m/Y H:i:s', strtotime($this->fechaHoraLogeo));
        

    }

    public function getColorAlerta(){
        $emp = $this->getEmpleado();
        if($emp->getIPPrincipal() == $this->ipLogeo )
            return "rgb(116, 209, 116)";

        return "rgb(235, 132, 132)";

    }


    /* Retorna una lista de modelos OperacionDocumento, que fueron los que el empleado realizó en esa sesión */
    public function getOperacionesDuranteSesion(){

        $codEmpleado = $this->codEmpleado;
        $empleado = Empleado::findOrFail($codEmpleado);

        $listaSiguientesLogeos = LogeoHistorial::where('codEmpleado',$codEmpleado)
            ->where('fechaHoraLogeo','>',$this->fechaHoraLogeo)
            ->get();

        if(count($listaSiguientesLogeos) == 0){ //si este es el ultimo logeo de una persona
            $fechaLimite = Carbon::now(); 
        }else{
            $thisSiguiente = $listaSiguientesLogeos[0];
            $fechaLimite = $thisSiguiente->fechaHoraLogeo;
        }

        $fechaInicial = $this->fechaHoraLogeo;
         
        $listaOperacionesDuranteSesion = OperacionDocumento::where('codEmpleado',$codEmpleado)
            ->where('fechaHora','>',$fechaInicial)
            ->where('fechaHora','<',$fechaLimite)
            ->get();

        return $listaOperacionesDuranteSesion;


    }
}
