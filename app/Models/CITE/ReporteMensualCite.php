<?php

namespace App\Models\CITE;

use App\Distrito;
use App\DocumentoAdministrativo;
use App\Empleado;
use App\Fecha;
use App\Mes;
use App\OperacionDocumento;
use Illuminate\Database\Eloquent\Model;

class ReporteMensualCite extends DocumentoAdministrativo
{
    public $table = "cite-reporte_mensual";
    protected $primaryKey ="codReporte";

    public $timestamps = false;
    protected $fillable = [''];
     
    const codTipoDocumento = "5";

    //esto es para el historial de operaciones
    public function getVectorDocumento(){
        return [
            'codTipoDocumento' => ReporteMensualCite::codTipoDocumento,
            'codDocumento' => $this->getId()
        ];
    }

    public function getMesYAñoEscrito(){
        return $this->getMes()->nombre . "-".$this->año;
    }


    public function getMes(){
        return Mes::findOrFail($this->codMes);
    }

    public function getDebeReportar() : bool{
        return $this->debeReportar == 1;
    }
     

    public function getEstado(){
        return EstadoReporteMensual::findOrFail($this->codEstado);
    }


    public function getOperaciones(){
        return OperacionDocumento::where('codDocumento','=',$this->getId())
                                ->where('codTipoDocumento',5)
                                ->get();

    }
    
    /* Solo se puede cancelar la programación si está no reportada (recien programada) */
    public function sePuedeCancelarProgramacion(){
        return $this->estaProgramado();
    }

    /* Solo se puede observar o aprobar si está Reportado o Subsanado */
    public function sePuedeEvaluar() : bool{
        return $this->estaReportado() || $this->estaSubsanado();
    }

    public function puedeParcarComoListo(){
        return $this->estaProgramado() || $this->estaObservado();
    }
    


    /* VERIFICACIONES ESTADOS */
    public function estaNoProgramado() : bool{
        return $this->verificarEstado('No programado');
    }
    public function estaProgramado() : bool{
        return $this->verificarEstado('Programado');
    }
    public function estaReportado() : bool{
        return $this->verificarEstado('Reportado');
    }
    public function estaAprobado() : bool{
        return $this->verificarEstado('Aprobado');
    }
    public function estaObservado() : bool{
        return $this->verificarEstado('Observado');
    }
    public function estaSubsanado() : bool{
        return $this->verificarEstado('Subsanado');
    }
     
    
    private function verificarEstado(string $nombreEstado):bool{

        return mb_strtolower($this->getEstado()->nombre) == mb_strtolower($nombreEstado);
    }


    

    function getEmpleado(){
        return Empleado::findOrFail($this->codEmpleado);
    }

    /* 
    Diego ernesto vigo briones para ENERO 2020
    */
    function getMsjInfo(){
        
        $nombre = $this->getEmpleado()->getNombreCompleto();
        $nombreMes = $this->getMes()->nombre;

        return "$nombre para $nombreMes de ".$this->año;
    }


    /*  */
    static function AllWithData(){
        $listaReportesMensuales = ReporteMensualCite::All();
        foreach ($listaReportesMensuales as $rep) {
            $rep->nombrePersona = $rep->getEmpleado()->getNombreCompleto();
            $rep->getMsjInfo = $rep->getMsjInfo();
            $rep->nombreMes = $rep->getMes()->nombre;
            
            $rep->estadoImprimible = $rep->getEstado()->nombre;
       
                
            $rep->listaOperaciones =  $rep->getOperaciones();
            
        }   
        return $listaReportesMensuales;


    }
}
