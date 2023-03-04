<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RevisionInventario extends Model
{
    public $table = "inv-revision_inventario";
    protected $primaryKey ="codRevision";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['fechaHoraInicio','fechaHoraCierre','codEmpleadoResponsable','descripcion'];

    function getDetalles(){
        $detalles=DetalleRevision::where('codRevision','=',$this->codRevision)->get();
        return $detalles;
    }


    function getDetallesAPI(){
        $detalles=DetalleRevision::where('codRevision','=',$this->codRevision)->get();
        
        foreach ($detalles as $det) {
            $det['activo'] = $det->getActivo();
            $det['estado'] = $det->getEstado();
        }
        
        return $detalles;
    }



    function getResponsable(){
        $empleado=Empleado::find($this->codEmpleadoResponsable);
        return $empleado;
    }
    
    function parametros(){
        $cantNoRevisado=0;
        $contDisponible=0;
        $contNoHabido=0;
        $contDeteriorado=0;
        $contDonado=0;

        $detalles=DetalleRevision::where('codRevision','=',$this->codRevision)->get();
        foreach ($detalles as $itemdetalle) {
            switch ($itemdetalle->codEstado) {
                case '0':
                    $cantNoRevisado++;
                    break;
                case '1':
                    $contDisponible++;
                    break;
                case '2':
                    $contNoHabido++;
                    break;
                case '3':
                    $contDeteriorado++;
                    break;
                case '4':
                    $contDonado++;
                    break;
            }
        }
        $total=$cantNoRevisado+$contDisponible+$contNoHabido+$contDeteriorado+$contDonado;

        $cantNoRevisado=(float)$cantNoRevisado/$total*100;
        $contDisponible=(float)$contDisponible/$total*100;
        $contNoHabido=(float)$contNoHabido/$total*100;
        $contDeteriorado=(float)$contDeteriorado/$total*100;
        $contDonado=(float)$contDonado/$total*100;

        return array($cantNoRevisado,$contDisponible,$contNoHabido,$contDeteriorado,$contDonado);
    }

    function seRevisoTodo(){
        
        foreach ($this->getDetalles() as $itemdetalle) {
            if($itemdetalle->seReviso==0){
                return 0;
            }
        }
        return 1;
    }

    function estaAbierta(){
        return is_null($this->fechaHoraCierre);

    }


    public static function hayUnaRevisionActiva(){
        $listaRevActivas = RevisionInventario::where('fechaHoraCierre','=',null)->get();
        return count($listaRevActivas)>0;
    }

    public static function getRevisionActiva(){
        $listaRevActivas = RevisionInventario::where('fechaHoraCierre','=',null)->get();
        return $listaRevActivas[0];
    }

    
    public function tieneAEmpleado($codEmpleado){
        $lista = EmpleadoRevisador::where('codEmpleado',$codEmpleado)
            ->where('codRevision',$this->codRevision)->get();

        return count($lista)>0;
    }

    public function getFechaHoraInicio(){
        return Fecha::formatoFechaHoraParaVistas($this->fechaHoraInicio);
    }

    public function getFechaHoraCierre(){
        return Fecha::formatoFechaHoraParaVistas($this->fechaHoraCierre);
    }



    /* FUNCIONES VISUALES */
    public function getNombreEstado(){
        if($this->estaAbierta())    
            return "Abierta";

        return "Cerrada";

    }

    public function getClaseBotonSegunEstado(){
        if($this->estaAbierta())    
            return "btn-success";

        return "btn-danger";

    }
    public function getMsjAlerta(){
        if($this->estaAbierta())    
            return "La revisión sigue abierta, aún se pueden cambiar los estados de los activos.";

        return "La revisión está cerrada, ya no se pueden hacer modificaciones.";


    }


    //Retorna un vector, cada elemento es un codActivo de esta revision
    public function getVectorCodigosActivos(){
        
        $lista = json_decode(json_encode ($this->getDetalles() ));
        
        return array_column($lista,'codActivo');
    }
    
}
