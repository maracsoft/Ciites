<?php

namespace App\Http\Controllers;

use App\Banco;
use App\BusquedaRepo;
use App\Debug;
use App\Empleado;
use App\Http\Controllers\Controller;
use App\Mes;
use App\Proyecto;
use App\RegresionLineal;
use App\ReposicionGastos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{

    public function Listar(){



        $estadosSolicitudes = DB::select(
            "SELECT ESOF.nombre, count(SOF.codSolicitud)  FROM solicitud_fondos SOF 
                INNER JOIN estado_solicitud_fondos ESOF ON SOF.codEstadoSolicitud = ESOF.codEstadoSolicitud
                GROUP BY ESOF.nombre
        ");


        $estadosRendiciones = DB::select("SELECT EREN.nombre, count(REN.codRendicionGastos)  from rendicion_gastos REN 
            inner join estado_rendicion_gastos EREN on REN.codEstadoRendicion = EREN.codEstadoRendicion
            group by EREN.nombre");


        $estadosReposicion = DB::select("SELECT EREP.nombre, count(REP.codReposicionGastos)  from reposicion_gastos REP 
            inner join estado_reposicion_gastos EREP on REP.codEstadoReposicion = EREP.codEstadoReposicion
            group by EREP.nombre");

        $estadosRequerimiento = DB::select(
            "SELECT EREQ.nombre, count(REQ.codRequerimiento)  from requerimiento_bs REQ 
            inner join estado_requerimiento_bs EREQ on REQ.codEstadoRequerimiento = EREQ.codEstadoRequerimiento
            group by EREQ.nombre"
        );
        

        return view('ReportesSistema.ListarReportes');
    }



    public function ImportesREPyREN(Request $request){
        //cuando lleguen que lleguen en formato 01 los meses
        $inicio_mes = $request->inicio_mes;
        $inicio_año = $request->inicio_año;

        $fin_mes = $request->fin_mes;
        $fin_año = $request->fin_año;


        $sqlFiltroREP = "";
        $sqlFiltroREN = "";
        if($inicio_año!=""){
            $sqlFiltroREP = " WHERE fechaHoraEmision > '$inicio_año-$inicio_mes-01' AND fechaHoraEmision < '$fin_año-$fin_mes-31' ";
            $sqlFiltroREN = " WHERE fechaHoraRendicion > '$inicio_año-$inicio_mes-01' AND fechaHoraRendicion < '$fin_año-$fin_mes-31' ";    
        }

        $sqlREP =  
            "SELECT YEAR(fechaHoraEmision) as 'año',MONTH(fechaHoraEmision) as 'mes', SUM(totalImporte) as 'total'
                from reposicion_gastos
                $sqlFiltroREP
                group by YEAR(fechaHoraEmision),MONTH(fechaHoraEmision)";

        $sqlREN = 
            "SELECT YEAR(fechaHoraRendicion) as 'año',MONTH(fechaHoraRendicion) as 'mes',SUM(totalImporteRendido) as 'total' 
                FROM `rendicion_gastos`
                $sqlFiltroREN
                group by YEAR(fechaHoraRendicion),MONTH(fechaHoraRendicion)";

        $listaREP = DB::select($sqlREP);
        $listaREN = DB::select($sqlREN);
        
        $tablaFinal = [];
        foreach ($listaREP as $mesAño) { //llenamos la tabla inicialmente
            
            $objeto = [
                'index'=>0,
                'REP' => 0,
                'REN' => 0,
                'Total' => 0
            ];
            $objeto['index']= ($mesAño->año*12 ) +  $mesAño->mes;
            $objeto['REP'] = round($mesAño->total,2);
            $objeto['Total'] = round($objeto['REP'] + $objeto['REN'],2);
            $tablaFinal[$mesAño->año."-".$mesAño->mes] = $objeto; 

            
            $numeroUltimoMes = $mesAño->mes;
            $ultimoAño = $mesAño->año;

        }

        //Debug::mensajeSimple(json_encode($tablaFinal));

        foreach ($listaREN as $mesAño) {
            $mes_año = $mesAño->año."-".$mesAño->mes;
            
            if( array_key_exists($mes_año , $tablaFinal )  ){ //Este mes ya existe en el array (tiene valor REP)
                $objeto = $tablaFinal[$mes_año];
            }else{ //si el mes no existe en el array
                error_log("el mes $mes_año no existe en el array");
                $objeto = [
                    'index'=>0,
                    'REP' => 0,
                    'REN' => 0,
                    'Total' => 0
                ];
            }

            $objeto['index']= ($mesAño->año*12 ) +  $mesAño->mes;
            $objeto['REN'] += round($mesAño->total,2); 
            $objeto['Total'] = round($objeto['REP'] + $objeto['REN'],2);

            $tablaFinal[$mes_año] = $objeto;

            $numeroUltimoMes = $mesAño->mes;
            $ultimoAño = $mesAño->año;
        }



        $listaMeses = Mes::All();
        $listaAños = [2016,2017,2018,2019,2020,2021,2022];

        $vectorAImprimir = [];
        $i = 1;

        //creamos el modelo de reg
        $modeloTotal = RegresionLineal::calcularModelo(
            array_column($tablaFinal,'index'),
            array_column($tablaFinal,'Total')
        );

        //llenamos el array que imprimirá el gráfico
        foreach ($tablaFinal as $mesAño => $valor) {
             
            $vectorAImprimir[] = array(
                            'index'=>$valor['index'],
                            'mes-anio'=>$mesAño,
                            'REP'=>$valor['REP'],
                            'REN'=>$valor['REN'],
                            'Total'=>$valor['Total'],
                            'TotalProyectado'=> round(RegresionLineal::proyectar($modeloTotal,$valor['index']),2)
                        );
             $valorIndex = $valor['index'];

        }

        
        sort($vectorAImprimir);
        $añoActual = $ultimoAño;
        $mesActual = $numeroUltimoMes;

        
        //proyecciones de un año completo
        for ($i= 1 ; $i <= 12 ; $i++) { 
            $mesActual++;
            if($mesActual==13){
                $mesActual=1;
                $añoActual++;
            }

            $index = ($añoActual*12 ) +  $mesActual;
            $vectorAImprimir[] = array(
                'index'=> $index,
                'mes-anio'=> $añoActual."-".$mesActual,
                'REP'=> 0,
                'REN'=> 0,
                'Total'=>0,
                'TotalProyectado'=> round(RegresionLineal::proyectar($modeloTotal,$index),2)
            );
        }
       
 
        return view('ReportesSistema.ImportesREPyREN',compact('listaREP','listaREN','tablaFinal','listaMeses',
                        'listaAños','inicio_mes','inicio_año','fin_mes','fin_año','vectorAImprimir'));

    }


    function ImportesREPporProyectos(){
        $sql = "SELECT sum(REP.totalImporte) as 'Total',p.nombre as 'Proyecto' from reposicion_gastos REP 
                    INNER JOIN proyecto P on P.codProyecto = REP.codProyecto
                GROUP BY P.nombre";

        $labels = [];
        $valores = [];
        $colores = [];
        $listaProyectos = DB::select($sql);
        foreach ($listaProyectos as $proy) {
            $proy->Total = round($proy->Total,2);
            $labels[] = $proy->Proyecto;
            $valores[] = $proy->Total;
            $r= rand(50,255);
            $g = rand(80,200);
            $colores[] = "rgb($r,$g,100)";
        }

        return view('ReportesSistema.TotalesPorProyecto',compact('listaProyectos','labels','valores','colores'));
    }

    public function verPDF_ImportesREPporProyectos(){

        $sql = "SELECT sum(REP.totalImporte) as 'Total',p.nombre as 'Proyecto' from reposicion_gastos REP 
                    INNER JOIN proyecto P on P.codProyecto = REP.codProyecto
                GROUP BY P.nombre";

        $labels = [];
        $valores = [];
        $colores = [];
        $listaProyectos = DB::select($sql);
        $total=0;
        foreach ($listaProyectos as $proy) {
            $proy->Total = round($proy->Total,2);
            $labels[] = $proy->Proyecto;
            $valores[] = $proy->Total;
            $r= rand(50,255);
            $g = rand(80,200);
            $colores[] = "rgb($r,$g,100)";
            $total+=$proy->Total;
        }

         
        $pdf = \PDF::loadview('ReportesSistema.TotalesPorProyectoPDF',
                array(
                    'listaProyectos'=>$listaProyectos,
                    'labels'=>$labels,
                    'valores'=> $valores,
                    'colores'=> $colores,
                    'total'=>$total
                )
            )->setPaper('a4', 'portrait');
        
        return $pdf->stream('Reporte .Pdf');;
    }





    public function ListarTiemposBusqueda(){
        $listaBusquedas = BusquedaRepo::orderBy('fechaHoraInicioBuscar','DESC')->get();
        
        return view('ReportesSistema.ListarBusquedas',compact('listaBusquedas'));

    }

    public function ReporteTesis(){

        $cantDatos = 74;
        $listaRepos = ReposicionGastos::orderBy('fechaHoraEmision','DESC')->take($cantDatos)->get();

        return view('ReportesSistema.ReporteTesis',compact('listaRepos'));
    }

    public function ReposRechazadas(){

        $listaProyectos = Proyecto::where('codProyecto','<=','10')->get();
        $listaMeses = Mes::All();
        $listaAños = [2019,2020];
        return view('ReportesSistema.ReposRechazadas',compact('listaProyectos','listaMeses','listaAños'));
    
    }

    public function Importe(){

        $listaProyectos = Proyecto::where('codProyecto','<=','10')->get();
        $listaMeses = Mes::All();
        $listaAños = [2019,2020];
        $listaBancos = Banco::All();
        return view('ReportesSistema.Importes',compact('listaProyectos','listaMeses','listaAños','listaBancos'));
    

    }


    public function Observaciones(){
        $listaProyectos = Proyecto::where('codProyecto','<=','10')->get();
        $listaMeses = Mes::All();
        $listaAños = [2019];
        $listaBancos = Banco::All();
        $listaEmpleados = Empleado::All();
        return view('ReportesSistema.Observaciones',compact('listaProyectos','listaMeses','listaAños','listaBancos','listaEmpleados'));
    

    }

}
