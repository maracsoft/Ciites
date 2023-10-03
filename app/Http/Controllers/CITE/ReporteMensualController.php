<?php

namespace App\Http\Controllers\CITE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ActividadPrincipal;
use App\Configuracion;
use App\Debug;
use App\Empleado;
use App\Models\CITE\UnidadProductiva as UnidadProductiva; 

use App\ErrorHistorial;
use App\Mes;
use App\Models\CITE\EstadoReporteMensual;
use App\Models\CITE\ReporteMensualCite;
use App\Models\Notificaciones\Notificacion;
use App\ParametroSistema;
use App\Puesto;
use App\TipoOperacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteMensualController extends Controller
{
    

    /* 
        Crea los registros de reporte_mensual para que estos puedan ser marcados 
        (cada registro corresponde a un mes y a un miembro de equipo cite)
        Por defecto se crean como debeReportar = 0  y codEstado = 0
        
    
    */
    function poblarReportesDelAño($año){
        
        try {
            
            DB::beginTransaction();
            $codigosEmpEquipo = ParametroSistema::getParametroSistema('listaEquipos')->valor;
            $listaCodigos = explode(',',$codigosEmpEquipo);
            $listaEmpleados = Empleado::whereIn('codEmpleado',$listaCodigos)->get();
            
            $msjEmpleados = "";
            foreach ($listaEmpleados as $emp){
                for ($codMes=1; $codMes <= 12 ; $codMes++) { 

                    //verificamos la existencia de ese emp y codMes y año
                    $buscarReporte = ReporteMensualCite::where('codEmpleado',$emp->getId())->where('codMes',$codMes)->where('año',$año)->get();
                    if(count($buscarReporte) > 0){
                        
                        //ya existe esa instancia de reporte para ese mes
                    }else{
                        $reporte = new ReporteMensualCite();
                        $reporte->año = $año;
                        $reporte->codMes = $codMes;
                        $reporte->codEmpleado = $emp->getId();
                        $reporte->comentario = "";
                        $reporte->debeReportar = 0;
                        
                        $reporte->codEstado = EstadoReporteMensual::getCodigoNoProgramado();
                        $reporte->save();
                        $msjEmpleados .= ",".$emp->getNombreCompleto() ." mes=".$codMes." <br>";
                    }
                }
                
                
            }
            
            DB::commit();
            return "Se completó la poblacion de los empleados $msjEmpleados para el año $año";
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }


        
    }


    function VerMatriz(){
        try {

            $codigosEmpEquipo = ParametroSistema::getParametroSistema('listaEquipos')->valor;
            $listaCodigos = explode(',',$codigosEmpEquipo);
            $listaEmpleados = Empleado::whereIn('codEmpleado',$listaCodigos)->get();
            $listaAños =  [2022];
            $listaMeses = Mes::All();
            
            $listaReportesMensuales = ReporteMensualCite::AllWithData();
            $listaEstados = EstadoReporteMensual::All();
    
            return view('CITE.ReporteMensual.Matriz',compact('listaEmpleados','listaMeses','listaAños','listaReportesMensuales','listaEstados'));
    
        } catch (\Throwable $th) {
            error_log($th);
            throw $th;
        }
       
    }

    function inv_EvaluarReporte($codReporte){
        $reporte = ReporteMensualCite::findOrFail($codReporte);
        return view('CITE.ReporteMensual.inv_EvaluarReporte',compact('reporte'));
    }

    /* Primer paso del historial */
    function Programar($codReporte){
        $reporte = ReporteMensualCite::findOrFail($codReporte);
        $reporte->debeReportar = 1;
        $reporte->codEstado = EstadoReporteMensual::getCodigoProgramado();
        $reporte->save();

        $emp = Empleado::getEmpleadoLogeado();
        if($emp->esArticulador())
            $codPuesto = Puesto::getCodPuesto_Articulador();
        else
            $codPuesto = Puesto::getCodPuesto_UGE();

        $reporte->registrarOperacion(
            TipoOperacion::getCodTipoOperacion('RCITE','Programar'),
            null, 
            $codPuesto
        );  
    
        return redirect()->route('CITE.ReporteMensual.VerMatriz')
            ->with('datos',"Se programó exitosamente un reporte de ".$reporte->getMsjInfo());

    }
    function Cancelar($codReporte){
        $reporte = ReporteMensualCite::findOrFail($codReporte);
        $reporte->debeReportar = 0;
        $reporte->codEstado = EstadoReporteMensual::getCodigoNoProgramado();
        
        $reporte->save();

        
        $emp = Empleado::getEmpleadoLogeado();
        if($emp->esArticulador())
            $codPuesto = Puesto::getCodPuesto_Articulador();
        else
            $codPuesto = Puesto::getCodPuesto_UGE();

        $reporte->registrarOperacion(
            TipoOperacion::getCodTipoOperacion('RCITE','Cancelar'),
            null, 
            $codPuesto
        );  

        return redirect()->route('CITE.ReporteMensual.VerMatriz')
            ->with('datos',"Se Canceló exitosamente el reporte de ".$reporte->getMsjInfo());
    }


    /* Articuladores y uge */
    function Observar(Request $request){
        try {
            db::beginTransaction();
            
            $reporte = ReporteMensualCite::findOrFail($request->codReporte);
            $reporte->observacion = $request->observacion;
            $reporte->codEstado = EstadoReporteMensual::getCodigoObservado();
            $reporte->save();
            
            $emp = Empleado::getEmpleadoLogeado();
            if($emp->esArticulador())
                $codPuesto = Puesto::getCodPuesto_Articulador();
            else
                $codPuesto = Puesto::getCodPuesto_UGE();

            $reporte->registrarOperacion(
                TipoOperacion::getCodTipoOperacion('RCITE','Observar'),
                $reporte->observacion, 
                $codPuesto
            );  


            /* Enviamos un mensaje al empleado de que su reporte fue observado */
            $notificacion = new Notificacion();
            $notificacion->codTipoNotificacion = 1;//CITE
            $notificacion->codEmpleado = $reporte->codEmpleado;
            $notificacion->descripcionAbreviada = "Su reporte de ".$reporte->getMesYAñoEscrito()." fue observado.";
            $notificacion->descripcion = "Su reporte de ".$reporte->getMesYAñoEscrito()." fue observado.";
            $notificacion->visto = 0;
            $notificacion->link = route('CITE.ReporteMensual.MisReportes');
            $notificacion->fechaHoraCreacion = Carbon::now(); 
            $notificacion->save();

            db::commit();
            return redirect()->route('CITE.ReporteMensual.VerMatriz')
                ->with('datos',"Se Observó exitosamente el reporte de ".$reporte->getMsjInfo());


        } catch (\Throwable $th) {
            db::rollBack();
            throw $th;
            
        }

    }


    function Aprobar($codReporte){
        try {
            db::beginTransaction();
            
            $reporte = ReporteMensualCite::findOrFail($codReporte);
            $reporte->codEstado = EstadoReporteMensual::getCodigoAprobado();
            $reporte->observacion = ""; //borramos la observacion si hubiera
            $reporte->save();
            
            $emp = Empleado::getEmpleadoLogeado();
            if($emp->esArticulador())
                $codPuesto = Puesto::getCodPuesto_Articulador();
            else
                $codPuesto = Puesto::getCodPuesto_UGE();

            $reporte->registrarOperacion(
                TipoOperacion::getCodTipoOperacion('RCITE','Aprobar'),
                null, 
                $codPuesto
            );  

            db::commit();
            return redirect()->route('CITE.ReporteMensual.VerMatriz')
                ->with('datos',"Se Aprobó exitosamente el reporte de ".$reporte->getMsjInfo());

        } catch (\Throwable $th) {
            db::rollBack();
            throw $th;
            
        }
    }





    /* 
    Cambia el estado del reporte a Reportado o Subsanado, segun el estado en el que este    
    */
    function MarcarReporteComoListo($codReporte){
        $reporte = ReporteMensualCite::findOrFail($codReporte);
        $empReporte = $reporte->getEmpleado();
        if($reporte->estaObservado()){
            $reporte->codEstado = EstadoReporteMensual::getCodigoSubsanado();;//subsanado
            $msjNotificacion ="SUBSANADO";
            $nombreOperacion = "Subsanar";
        }else{
            $reporte->codEstado = EstadoReporteMensual::getCodigoReportado();;
            $nombreOperacion = "Reportar";
            $msjNotificacion ="LISTO";
        }
        $reporte->save();
        $reporte->registrarOperacion(
            TipoOperacion::getCodTipoOperacion('RCITE',$nombreOperacion),
            null, 
            Puesto::getCodPuesto_Equipo()
        );  

        $listaUgesYArticuladores = Empleado::getListaUgesYArticuladores();
        foreach ($listaUgesYArticuladores as $empleado) {
            $notificacion = new Notificacion();
            $notificacion->codTipoNotificacion = 1;//CITE
            $notificacion->codEmpleado = $empleado->getId();
            $notificacion->descripcionAbreviada = "Reporte de ".$empReporte->apellidos." ".$reporte->getMesYAñoEscrito()." $msjNotificacion.";
            $notificacion->descripcion = $empReporte->getNombreCompleto()." marcó como $msjNotificacion su reporte de ".$reporte->getMesYAñoEscrito();
            $notificacion->visto = 0;
            $notificacion->link = route('CITE.ReporteMensual.VerMatriz');
            $notificacion->fechaHoraCreacion = Carbon::now(); 
            $notificacion->save();
        }
        
        return redirect()->route('CITE.ReporteMensual.MisReportes')
            ->with('datos',"Se marcó como listo el reporte de ".$reporte->getMsjInfo());
    }
    

    

    function MisReportes(){

        $emp = Empleado::getEmpleadoLogeado();
        $listaReportes = ReporteMensualCite::where('año',2022)->where('codEmpleado','=',$emp->getId())->get();
        return view('CITE.ReporteMensual.MisReportes',compact('listaReportes'));

    }
 
}
