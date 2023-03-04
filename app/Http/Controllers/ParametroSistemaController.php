<?php

namespace App\Http\Controllers;

use App\Configuracion;
use App\ErrorHistorial;
use App\Http\Controllers\Controller;
use App\ParametroSistema;
use App\RespuestaAPI;
use App\TipoParametroSistema;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParametroSistemaController extends Controller
{
    //

    public function listar(){
        $listaTipoParametro = TipoParametroSistema::All();
        $lista = ParametroSistema::All();

        return view('ParametroSistema.ListarParametros',compact('lista','listaTipoParametro'));

    }

    public function inv_listado(){

        $lista = ParametroSistema::All();

        return view('ParametroSistema.inv_ListarParametros',compact('lista'));

    }

    public function JSON_GetParametros(){
        return json_encode(ParametroSistema::All());


    }

    public function guardarYActualizar(Request $request){

        try{
            DB::beginTransaction();
            

            if($request->codParametro=="0"){ // NUEVO

                $parametro = new ParametroSistema();
                $parametro->fechaHoraCreacion = Carbon::now();
                $msj = "creado";
            
            }else{ //EXISTENTE 
                $parametro = ParametroSistema::findOrFail($request->codParametro);
                $parametro->fechaHoraActualizacion = Carbon::now();
                $msj = "actualizado";
            }
            $parametro->nombre = $request->nombre;
            $parametro->valor = $request->valor;
            $parametro->descripcion = $request->descripcion;
            $parametro->codTipoParametro = $request->codTipoParametro;
            
            
            $parametro->save();

            db::commit();
            return RespuestaAPI::respuestaOk("Se ha $msj el parámetro ".$parametro->nombre." exitosamente");

        }catch(\Throwable $th){
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
            
        }

    }

    public function darDeBaja($codParametro){
        try{
            DB::beginTransaction();
            
            $parametro = ParametroSistema::findOrFail($codParametro);
            $parametro->fechaHoraBaja = Carbon::now();
            
            $parametro->save();

            db::commit();
            return RespuestaAPI::respuestaOk("Se ha dado de baja el parámetro ".$parametro->nombre." exitosamente");
        }catch(\Throwable $th){
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                            app('request')->route()->getAction(),
                                                            $codParametro
                                                            );
            return RespuestaAPI::respuestaError(Configuracion::getMensajeError($codErrorHistorial));
            
        }
    }


}
