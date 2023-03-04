<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContratoLocacion extends Contrato
{
    public $timestamps = false;
    public $table = 'contrato_locacion';

    protected $primaryKey = 'codContratoLocacion';
    protected $fillable = [''];

    const RaizCodigoCedepas = "CL";

    /* 
    CONTRATO LOCACIÓN 
        
        fechaActual
        fechaInicio
        fechaFin 
        
        apellidos
        nombres
        dni
        direccion
        motivoContrato
     
        retribucionTotal    
    */


    /* 
        AÑADIR RUC
        Provincia y departamento
        MONEDA

        añadir booleano GPC
        
        
    */


    //le pasamos un modelo numeracion y calcula la nomeclatura del cod cedepas  
    public static function calcularCodigoCedepas($objNumeracion){
        return  ContratoLocacion::RaizCodigoCedepas.
                substr($objNumeracion->año,2,2).
                '-'.
                ContratoLocacion::rellernarCerosIzq($objNumeracion->numeroLibreActual,4);
    }
    public static function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
        
    }


    public function getPDF(){
        $listaItems = $this->getAvances();
        $contrato = $this;
        
        /* 
        return view('Contratos.contratoLocacionPDF',compact('contrato','listaItems'));
        */ 

        $pdf = \PDF::loadview('Contratos.contratoLocacionPDF',
            array('contrato'=>$this,'listaItems'=>$listaItems)
                            )->setPaper('a4', 'portrait');
        
        return $pdf;
    }

    public function getAvances(){
        return AvanceEntregable::where('codContratoLocacion',$this->codContratoLocacion)
            ->orderBy('fechaEntrega','ASC')
            ->get();
    }

    

    function getRetribucionTotal(){
        return number_format($this->retribucionTotal,2);
    }


    function getSede(){
        return Sede::findOrFail($this->codSede);
    }


    function esDeCedepas(){
        return $this->esDeCedepas=='1';
    }



    function esDeGPC(){
        return !$this->esDeCedepas();
    }

    function getTipoContrato(){
        if($this->esDeCedepas())
            return "CEDEPAS";
        return "GPC";
    }

    function esDeNatural(){
        return $this->esPersonaNatural=='1';
    }


    
    /* 
        Si es persona jurídica, será EL LOCADOR
        Si es persona natural:
            Hombre: EL LOCADOR
            Mujer : LA LOCADORA


    */
    public function getLocadore(){
        if($this->esDeNatural()){
            if($this->sexo=="F")
                return "LA LOCADORA";
            else 
                return "EL LOCADOR";
        }

        return "EL LOCADOR";

    }
   






    static function listaEmpleadosQueGeneraronContratosLocacion(){
        $listaCodigosEmp = ContratoLocacion::select('codEmpleadoCreador')->groupBy('codEmpleadoCreador')->get();
        $objetoResultante = json_decode(json_encode($listaCodigosEmp));
        $arrayDeCodEmpleadosGeneradores = array_column($objetoResultante,'codEmpleadoCreador');

        return Empleado::whereIn('codEmpleado',$arrayDeCodEmpleadosGeneradores)->get();

    }
    


}
