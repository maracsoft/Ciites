<?php

namespace App\Http\Controllers;

use App\AvanceEntregable;
use App\Configuracion;
use App\ContratoLocacion;
use App\Debug;
use App\Empleado;
use App\ErrorHistorial;
use App\Fecha;
use App\Http\Controllers\Controller;
use App\Moneda;
use App\Numeracion;
use App\Puesto;
use App\Sede;
use App\TipoOperacion;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContratoLocacionController extends Controller
{
    public function listar(Request $request){

        $listaContratos =  ContratoLocacion::where('codContratoLocacion','>',0);


        $codEmpleadoCreador = $request->codEmpleadoCreador;
        $dni = $request->dni;
        $ruc = $request->ruc;
        $esDeCedepas = $request->esDeCedepas;
        $esPersonaNatural = $request->esPersonaNatural ;
        
        if($codEmpleadoCreador!="" && $codEmpleadoCreador!="-1")
            $listaContratos = $listaContratos->where('codEmpleadoCreador',$codEmpleadoCreador);
        else
            $codEmpleadoCreador = "-1";

        if($dni!=""){
            $listaContratos = $listaContratos->where('dni','like','%'.$dni.'%');
        }

        if($ruc!=""){
            $listaContratos = $listaContratos->where('ruc','like','%'.$ruc.'%');
        }
    
        if($esDeCedepas!=""){
            $listaContratos = $listaContratos->where('esDeCedepas',$esDeCedepas);
        }        

        if($esPersonaNatural!=""){
            $listaContratos = $listaContratos->where('esPersonaNatural',$esPersonaNatural);
        }        

        

        $listaContratos = $listaContratos->orderBy('codContratoLocacion','DESC')->get();
        $listaEmpleadosQueGeneraronContratosLocacion = ContratoLocacion::listaEmpleadosQueGeneraronContratosLocacion();
        

        
        
        
        
        
        return view('Contratos.LocacionServicios.ListarContratosLocacion',
            compact('listaContratos','listaEmpleadosQueGeneraronContratosLocacion','codEmpleadoCreador',
            'dni','ruc','esDeCedepas','esPersonaNatural'));

    }

    public function Crear(){
        
        $listaMonedas = Moneda::All();
        $listaSedes = Sede::All();
        return view('Contratos.LocacionServicios.CrearContratoLocacion',compact('listaMonedas','listaSedes'));

    }

    public function guardar(Request $request){
        try {
            
            DB::beginTransaction();   
            $contrato = new ContratoLocacion();
            $empleadoLogeado = Empleado::getEmpleadoLogeado();
            

            /* Campos generales */
            $contrato->motivoContrato = $request->motivoContrato;
            $contrato->retribucionTotal = $request->retribucionTotal;
            $contrato->codMoneda = $request->codMoneda;
            $contrato->fechaInicio = Fecha::formatoParaSQL($request->fechaInicio);
            $contrato->fechaFin = Fecha::formatoParaSQL($request->fechaFin);            
            $contrato->codSede = $request->codSede;
            $contrato->esPersonaNatural = $request->esPersonaNatural;
            $contrato->esDeCedepas = $request->esDeCedepas;
            $contrato->nombreFinanciera = $request->nombreFinanciera;
            $contrato->nombreProyecto = $request->nombreProyecto;
            
            $contrato->fechaHoraGeneracion =  Carbon::now();
            
            
            
            if($contrato->esPersonaNatural=="1"){ //PERSONA NATURAL

                $contrato->ruc = $request->PN_ruc;
                $contrato->dni = $request->PN_dni;

                $contrato->nombres = $request->PN_nombres;
                $contrato->apellidos = $request->PN_apellidos;
                
                $contrato->sexo = $request->PN_sexo;
                $contrato->direccion = $request->PN_direccion;
                $contrato->provinciaYDepartamento = $request->PN_provinciaYDepartamento;                

            }else{ //PERSONA JURIDICA

                $contrato->ruc = $request->PJ_ruc;
                $contrato->dni = $request->PJ_dni;

                $contrato->nombres = $request->PJ_nombres;
                $contrato->apellidos = $request->PJ_apellidos;
                
                $contrato->sexo = $request->PJ_sexo;
                $contrato->direccion = $request->PJ_direccion;
                $contrato->provinciaYDepartamento = $request->PJ_provinciaYDepartamento;    

                $contrato->razonSocialPJ = $request->PJ_razonSocialPJ;
                $contrato->nombreDelCargoPJ = $request->PJ_nombreDelCargoPJ;
            }
            
            $contrato->codEmpleadoCreador = $empleadoLogeado->codEmpleado;
            
            $contrato->codigoCedepas = ContratoLocacion::calcularCodigoCedepas(Numeracion::getNumeracionCLS());
            Numeracion::aumentarNumeracionCLS();
            
            $contrato->save();

            if($request->cantElementos==0)
                throw new Exception("No se ingresó ningún item.", 1);
             

            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) {
                $avance=new AvanceEntregable();
                $avance->fechaEntrega=         Fecha::formatoParaSQL($request->get('colFecha'.$i));
                $avance->descripcion=          $request->get('colDescripcion'.$i);
                $avance->monto=                $request->get('colMonto'.$i);    
                $avance->porcentaje  =         $request->get('colPorcentaje'.$i);    
                $avance->codContratoLocacion=          $contrato->codContratoLocacion; //ultimo insertad
                
                $avance->save();                         
                $i=$i+1;
            }    

            DB::commit();  
            return redirect()
                ->route('ContratosLocacion.Listar')
                ->with('datos','Se ha creado el contrato '.$contrato->codigoCedepas);
        }catch(\Throwable $th){
            
            Debug::mensajeError('CONTRATO LOCACION : STORE',$th);
            
            DB::rollback();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return redirect()
                ->route('ContratosLocacion.Listar')
                ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }

    }

    public function descargarPDF($codContrato){


        $contrato = ContratoLocacion::findOrFail($codContrato);
        $pdf = $contrato->getPDF();
        //return $pdf;
        return $pdf->download('Contrato '.$contrato->getTituloContrato().'.Pdf');

    }   
    
    public function verPDF($codContrato){
        $contrato = ContratoLocacion::findOrFail($codContrato);
        $pdf = $contrato->getPDF();
        //return view('Contratos.contratoLocacionPDF',compact('contrato'));
        /* 
        return $pdf; 
        */


        return $pdf->stream('Contrato '.$contrato->getTituloContrato().'.Pdf');

    }

    function Ver($codContrato){
        $contrato = ContratoLocacion::findOrFail($codContrato);
        return view('Contratos.LocacionServicios.VerContratoLocacion',compact('contrato'));

    }


    function Anular($codContrato){
        try{
            db::beginTransaction();
            
            
            
            $empleadoLogeado = Empleado::getEmpleadoLogeado();
            $contrato = ContratoLocacion::findOrFail($codContrato);
            
            if($contrato->codEmpleadoCreador != $empleadoLogeado->codEmpleado)
            return redirect()
                ->route('ContratosLocacion.Listar')
                ->with('datos','El contrato solo puede ser anulado por la persona que lo creó');
                
            $contrato->fechaHoraAnulacion = Carbon::now();
            $contrato->save();
            
            DB::commit();  
            return redirect()
                ->route('ContratosLocacion.Listar')
                ->with('datos','Se ha ANULADO el contrato '.$contrato->codigoCedepas);
        }catch(\Throwable $th){
            Debug::mensajeError('CONTRATO LOCACION : ANULAR',$th);
            DB::rollback();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                            $codContrato
                                                            );
            return redirect()
                ->route('ContratosLocacion.Listar')
                ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }
    }

}
