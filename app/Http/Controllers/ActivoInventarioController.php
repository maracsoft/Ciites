<?php

namespace App\Http\Controllers;

use App\ActivoInventario;
use App\CategoriaActivoInventario;
use App\Configuracion;
use App\DetalleRevision;
use App\Empleado;
use App\ErrorHistorial;
use App\EstadoActivoInventario;
use App\Http\Controllers\Controller;
use App\Proyecto;
use App\RespuestaAPI;
use App\RevisionInventario;
use App\Sede;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

class ActivoInventarioController extends Controller
{
    function Listar(Request $request){
        $listaActivos = ActivoInventario::All();

        return view('Inventario.Activos.ListarActivos',compact('listaActivos'));


    }


    function crear(){
        $listaCategorias = CategoriaActivoInventario::All();
        $listaProyectos = Proyecto::All();
        $listaEstados = EstadoActivoInventario::All();
        $listaEmpleados = Empleado::getEmpleadosActivos();
        $listaSedes = Sede::All();

        return view('Inventario.Activos.CrearActivo',
            compact('listaCategorias'
                    ,'listaProyectos'
                    ,'listaEstados'
                    ,'listaEmpleados'
                    ,'listaSedes'));

    }

    function guardar(Request $request){
        $activo = new ActivoInventario();
        $activo->nombre = $request->nombre;
        $activo->caracteristicas = $request->caracteristicas;
        $activo->placa = $request->placa;

        
        $activo->codCategoriaActivo = $request->codCategoriaActivo;
        $activo->codProyecto = $request->codProyecto;
        $activo->codEstado = 1; //refactorizar aqui
        $activo->codEmpleadoResponsable = $request->codEmpleadoResponsable;
        $activo->codSede  = $request->codSede;
        $activo->save();

        
        return redirect()->route('ActivoInventario.Listar')->with('datos','Activo creado exitosamente');

    }

    function VerActivo($codActivo){
        $activo = ActivoInventario::findOrFail($codActivo);
        $listaRevisionesDeActivo = DetalleRevision::where('codActivo',$codActivo)->get();
        $estadosActivo = EstadoActivoInventario::All();
        return view('Inventario.Activos.VerActivo',compact('activo','listaRevisionesDeActivo','estadosActivo'));
        
    }







    /* METODOS PARA API */

    function API_Listar(){

        $lista = ActivoInventario::All();
        foreach ($lista as $activo) {
            $activo['empleadoResponsable'] = $activo->getResponsable();
            $activo['estado'] = $activo->getEstado();
            $activo['categoria'] = $activo->getCategoria();
            $activo['razonBaja'] = $activo->getRazonBaja();
            $activo['proyecto'] = $activo->getProyecto();
            $activo['sede'] = $activo->getSede();

        }
        return $lista;


    }
     
    function API_Crear(){

        $listaCategorias = CategoriaActivoInventario::All();
        $listaProyectos = Proyecto::All();
        $listaEstados = EstadoActivoInventario::All();
        $listaEmpleados = Empleado::getEmpleadosActivos();
        $listaSedes = Sede::All();

        $datos = [
            'listaCategorias' => $listaCategorias,
            'listaProyectos' => $listaProyectos,
            'listaEstados' => $listaEstados,
            'listaEmpleados' => $listaEmpleados,
            'listaSedes' => $listaSedes
        ];

        return $datos;
    }



    function API_GuardarYActualizar(Request $request){


            DB::beginTransaction();

            if(!is_null($request->codActivo)){//si existe
                $activo = ActivoInventario::findOrFail($request->codActivo);
                $msj = " actualizado";
            }else{ //NUEVO

                
                //verificamos que no haya un activo con ese codigo
                $lista = ActivoInventario::where('codigoAparente',$request->codigoAparente)->get();
                if(count($lista)!=0)
                    return RespuestaAPI::respuestaError("Ya hay un activo con este código.");

                $activo = new ActivoInventario();
                $msj = " creado";
                $activo->codEstado = 1; //refactorizar aqui
                
            }

            $activo->nombre = $request->nombre;
            $activo->codigoAparente = $request->codigoAparente;
            
            $activo->caracteristicas = $request->caracteristicas;
            $activo->placa = $request->placa;
            $activo->codCategoriaActivo = $request->codCategoriaActivo;
            $activo->codProyecto = $request->codProyecto;
            
            $activo->codEmpleadoResponsable = $request->codEmpleadoResponsable;
            $activo->codSede  = $request->codSede;
            $activo->save();
            
            if($msj == " creado"){

                
                //si hay una rev activa, le creamos su detalle
                if(RevisionInventario::hayUnaRevisionActiva()){
                    $rev = RevisionInventario::getRevisionActiva();
                    $detalleRevision = new DetalleRevision();
                    $detalleRevision->codActivo = $activo->codActivo;
                    $detalleRevision->codRevision = $rev->codRevision;
                    $detalleRevision->codEstado = 1;
                    $detalleRevision->save();                
                }


            }
    

            db::commit();

            return RespuestaAPI::respuestaOk("Se ha $msj exitosamente el activo ".$activo->codigoAparente);
        


    }
     



    
    public function API_getActivoPorCodigoAparente($codigoAparente){

        
        $listaAct = ActivoInventario::where('codigoAparente',$codigoAparente)->get();
        if(count($listaAct) == 0){
            return RespuestaAPI::respuestaDatosError("No existe ningún activo con el código $codigoAparente en la base de datos");
        }

        $activo = $listaAct[0];
        $activo['empleadoResponsable'] = $activo->getResponsable();
        $activo['categoria'] = $activo->getCategoria();
        
        $nombre = $activo->nombre;
        return RespuestaAPI::respuestaDatosOk("Activo '$nombre' [$codigoAparente] obtenido exitosamente.",$activo);
        

    }

    public function API_getActivo($codActivo){
        $activo = ActivoInventario::findOrFail($codActivo);
        $activo['empleadoResponsable'] = $activo->getResponsable();
        $codigoAparente = $activo->codigoAparente;
        return RespuestaAPI::respuestaDatosOk("Activo $codigoAparente obtenido exitosamente.",$activo);
    }


}
