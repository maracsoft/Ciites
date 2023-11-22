<?php

namespace App;

use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContratoPlazo extends Contrato
{
    public $timestamps = false;
    public $table = 'contrato_plazo';

    protected $primaryKey = 'codContratoPlazo';
    protected $fillable = [''];

    const RaizCodigoCedepas = "CP";

    /*

    CONTRATO PLAZO
        fechaInicio
        fechaFin (si es null, es pq es indefinido)
        fechaActual


        tieneHijos
        nombres
        apellidos
        dni
        direccion
        sexo

        codEntidadFinanciera
        codProyecto
        nombrePuesto

        sueldoFijo
        horasSemanales ¿no recuerdo si este estaba?

    */



    /* si es hombre retorna EL TRABAJADOR
    si es mujer, retorna LA TRABAJADORA */
    public function getTrabajadore(){
        if($this->sexo=='M')
            return "EL TRABAJADOR";
        else
            return "LA TRABAJADORA";

    }



    public function getPDF(){

        $contrato = $this;

        /*
        return view('Contratos.contratoLocacionPDF',compact('contrato','listaItems'));
        */

        $pdf = \PDF::loadview('Contratos.contratoPlazoPDF',
            array('contrato'=>$this)
                            )->setPaper('a4', 'portrait');

        return $pdf;
    }


    public function getPDFServicio(){
      $data = array('contrato'=>$this);

      $html_view = view('Contratos.contratoPlazoServicioEspecificoPDF',$data)->render();

      $dompdf = new Dompdf();
      $font = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
      $dompdf->loadHtml($html_view);
      $dompdf->setPaper('A4');
      $dompdf->render();
      $dompdf->getCanvas();//->page_text(478, 805, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 8, array(0,0,0));
      $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));



      return $dompdf;
    }





    //le pasamos un modelo numeracion y calcula la nomeclatura del cod cedepas SOF21-000001
    public static function calcularCodigoCedepas($objNumeracion){
        return  ContratoPlazo::RaizCodigoCedepas.
                substr($objNumeracion->año,2,2).
                '-'.
                ContratoPlazo::rellernarCerosIzq($objNumeracion->numeroLibreActual,4);
    }

    public static function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);

    }







    function tieneAsignacionFamiliar(){
        return $this->asignacionFamiliar=='1';
    }

    /* LOGICA DE GPC Y CEDEPAS */
    function esDeCedepas(){
        return $this->codTipoContrato == '1' || $this->codTipoContrato == '2'; //normal o especial
    }

    function esDeGPC(){ //cuando es 3 O 4
        return !$this->esDeCedepas();
    }

    function getTipoContrato(){
        return TipoContrato::findOrFail($this->codTipoContrato);

    }

    function esContratoNormal(){
        return $this->codTipoContrato == '1' || $this->codTipoContrato == '3'; //normal o GPC

    }





    function getSueldoBrutoEscrito(){

        return Numeros::escribirNumero($this->sueldoBruto);

    }

    function getSede(){
        return Sede::findOrFail($this->codSede);
    }





    static function listaEmpleadosQueGeneraronContratosPlazo(){
        $listaCodigosEmp = ContratoPlazo::select('codEmpleadoCreador')->groupBy('codEmpleadoCreador')->get();
        $objetoResultante = json_decode(json_encode($listaCodigosEmp));
        $arrayDeCodEmpleadosGeneradores = array_column($objetoResultante,'codEmpleadoCreador');

        return Empleado::whereIn('codEmpleado',$arrayDeCodEmpleadosGeneradores)->get();

    }


    static function listaNombresDeContratados(){
      $listaContratos = DB::select("select dni,nombres,apellidos from contrato_plazo group by dni,nombres,apellidos");

      $listaNombres = [];
      foreach ($listaContratos as $contrato) {
        $nombreComp = $contrato->apellidos." ".$contrato->nombres;
        if(!in_array($nombreComp,$listaNombres)){
          $listaNombres[] =[
            'nombre' =>$nombreComp,
            "nombre_dni" => $nombreComp." - ".$contrato->dni,
            "dni" => $contrato->dni
          ];
        }

      }


      return $listaNombres;
    }

}
