<?php

namespace App\Http\Controllers;

use App\Area;
use App\Configuracion;
use App\Empleado;
use App\PeriodoEmpleado;
use App\Puesto;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Proyecto;
use App\Sede;
use App\Debug;
use App\EmpleadoPuesto;
use App\ErrorHistorial;
use App\Fecha;
use App\Http\Controllers\CITE\ReporteMensualController;
use App\ProyectoContador;
use App\ProyectoObservador;
use App\RespuestaAPI;
use Throwable;

class EmpleadoController extends Controller
{
    const PAGINATION = 20;


    public function listarEmpleados(Request $request){
        $dniBuscar=$request->dniBuscar;
        $nombreBuscar=$request->nombreBuscar;
        $empleados = Empleado::where('dni','like',$dniBuscar.'%')
            ->where(DB::raw('CONCAT(nombres," ",apellidos)'),'like', '%'.$nombreBuscar.'%')
            ->orderBy('activo','DESC')
            ->orderBy('codEmpleado','DESC')
            ->paginate($this::PAGINATION);

        $listaSedes = Sede::All();

        return view('Empleados.ListarEmpleados',compact('empleados','dniBuscar','nombreBuscar','listaSedes'));

    }





    public function crearEmpleado(){

        $puestos=Puesto::where('estado','!=',0)->get();
        $sedes=Sede::all();
        return view('Empleados.CrearEmpleado',compact('puestos','sedes'));
    }


    public function guardarCrearEmpleado(Request $request){
        try{
            db::beginTransaction();

            /* Validamos que no hay otro usuario con el mismo dni */
            $empleadoEncontrado = Empleado::buscarPorDNI($request->DNI);
            if($empleadoEncontrado!="")
                return redirect()->route('GestionUsuarios.Listar')
                    ->with('datos','ERROR: Ya existe un empleado registrado con el DNI "'.$empleadoEncontrado->dni.'"');

            /* Validamos que no hay otro usuario con el mismo nombre de usuario*/
            $usuarioEncontrado = User::buscarPorUsuario($request->usuario);
            if($usuarioEncontrado!="")
                return redirect()->route('GestionUsuarios.Listar')
                    ->with('datos','ERROR: Ya existe un empleado registrado con el nombre de usuario "'.$usuarioEncontrado->usuario.'"');



            //Usuario
            $usuario=new User();
            $usuario->usuario=$request->usuario;
            $usuario->password=hash::make($request->contraseña);
            $usuario->isAdmin=0;
            $usuario->save();

            //Empleado
            $empleado=new Empleado();
            $empleado->codUsuario=$usuario->codUsuario;
            $empleado->nombres=$request->nombres;
            $empleado->apellidos=$request->apellidos;
            $empleado->correo = $request->correo;
            $empleado->activo=1;
            $empleado->codigoCedepas=$request->codigo;
            $empleado->dni=$request->DNI;

            $empleado->mostrarEnListas=$request->mostrarEnListas;



            $empleado->fechaRegistro=date('y-m-d');
            $empleado->codSede=$request->codSede;

            $empleado->sexo=$request->sexo;
            $empleado->fechaNacimiento=substr($request->fechaNacimiento,6,4).'-'.substr($request->fechaNacimiento,3,2).'-'.substr($request->fechaNacimiento,0,2);
            $empleado->nombreCargo=$request->cargo;
            $empleado->direccion=$request->direccion;
            $empleado->nroTelefono=$request->telefono;

            $empleado->save();


            //Puestos del empleado
            if($request->codsPuesto){
              $codigosPuestos = explode(",",$request->codsPuesto);
              foreach ($codigosPuestos as $codPuesto) {
                $emp_puesto = new EmpleadoPuesto();
                $emp_puesto->codPuesto = $codPuesto;
                $emp_puesto->codEmpleado = $empleado->getId();
                $emp_puesto->save();

              }
            }

            ReporteMensualController::PoblarReportesDelAñoActual();
        
            db::commit();
            return redirect()->route('GestionUsuarios.Listar')
                ->with('datos','Empleado '.$empleado->getNombreCompleto().' registrado exitosamente');

        }catch (\Throwable $th) {
            Debug::mensajeError(' EMPLEADO CONTROLLER guardarcrearempleado' ,$th);
            DB::rollback();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return redirect()->route('GestionUsuarios.Listar')
                ->with('datos',Configuracion::getMensajeError($codErrorHistorial));

        }




    }

    public function editarUsuario($id){
        $empleado = Empleado::findf($id);


        $usuario=$empleado->usuario();
        return view('Empleados.EditUsuario',compact('usuario','empleado'));
    }

    public function editarEmpleado($id){
        $puestos=Puesto::where('estado','!=',0)->get();
        $sedes=Sede::all();
        $empleado=Empleado::findf($id);


        return view('Empleados.EditEmpleado',compact('empleado','puestos','sedes'));
    }

    public function guardarEditarUsuario(Request $request){

        try{
            db::beginTransaction();
            //Usuario
            //$usuario=new User();
            $empleado=Empleado::find($request->codEmpleado);
            $usuario=$empleado->usuario();
            $usuario->usuario=$request->usuario;
            $usuario->password=hash::make($request->password1);
            //$usuario->isAdmin=0;
            $usuario->save();

            db::commit();
            return redirect()->route('GestionUsuarios.Listar')->with('datos',"La contraseña se ha actualizado.");

        }catch (\Throwable $th) {
            Debug::mensajeError(' EMPLEADO CONTROLLER guardarEditarUsuario' ,$th);
            DB::rollback();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                            app('request')->route()->getAction(),
                                                            json_encode($request->toArray())
                                                            );
            return redirect()->route('GestionUsuarios.Listar')
                ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }

    }
    public function guardarEditarEmpleado(Request $request){

        try{

            db::beginTransaction();
            $empleado=Empleado::find($request->codEmpleado);

            $empleado->nombres=$request->nombres;
            $empleado->apellidos=$request->apellidos;
            $empleado->codigoCedepas=$request->codigo;
            $empleado->dni=$request->DNI;

            $empleado->codSede=$request->codSede;

            $empleado->sexo=$request->sexo;
            $empleado->fechaNacimiento=Fecha::formatoParaSQL($request->fechaNacimiento);
            $empleado->nombreCargo=$request->cargo;
            $empleado->direccion=$request->direccion;
            $empleado->nroTelefono=$request->telefono;
            $empleado->mostrarEnListas=$request->mostrarEnListas;



            $empleado->save();
            db::commit();

            return redirect()->route('GestionUsuarios.Listar')
                ->with('datos','Empleado "'.$empleado->getNombreCompleto().'"actualizado.');

        }catch (\Throwable $th) {
            Debug::mensajeError(' EMPLEADO CONTROLLER guardarEditarEmpleado' ,$th);
            DB::rollback();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                            app('request')->route()->getAction(),
                                                            json_encode($request->toArray())
                                                            );
            return redirect()->route('GestionUsuarios.Listar')
                ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }
    }

    public function cesarEmpleado($id){

        try{
            db::beginTransaction();
            $empleado=Empleado::find($id);
            $empleado->fechaDeBaja=date('y-m-d');
            $empleado->activo=0;
            $empleado->save();
            $nombres = $empleado->getNombreCompleto();

            db::commit();

            return redirect()->route('GestionUsuarios.Listar')->with('datos',"Se ha desactivado al empleado $nombres.");

        }catch (\Throwable $th) {
            Debug::mensajeError(' EMPLEADO CONTROLLER cesarEmpleado' ,$th);
            DB::rollback();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                            app('request')->route()->getAction(),
                                                            $id
                                                            );
            return redirect()->route('GestionUsuarios.Listar')
                ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }


    }
    public function reactivarEmpleado($id){

        try{
            db::beginTransaction();
            $empleado=Empleado::findf($id);
            $empleado->fechaDeBaja=null;
            $empleado->activo=1;
            $empleado->save();
            $nombres = $empleado->getNombreCompleto();

            db::commit();

            return redirect()->route('GestionUsuarios.Listar')->with('datos',"Se ha reactivado al empleado $nombres.");

        }catch (\Throwable $th) {
            Debug::mensajeError(' EMPLEADO CONTROLLER reactivarEmpleado' ,$th);
            DB::rollback();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                            app('request')->route()->getAction(),
                                                            $id
                                                            );
            return redirect()->route('GestionUsuarios.Listar')
                ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }


    }

    /*
    GET
    Le llega un codEmpleado y codPuesto y le cambia el estado de relacion rol existente a no existente o visceversa
    */
    public function TogleEmpleadoPuesto(Request $request){

      try {
        db::beginTransaction();

        $empleado = Empleado::findOrFail($request->codEmpleado);
        $puesto = Puesto::findOrFail($request->codPuesto);
        $nuevoEstado = EmpleadoPuesto::togleEmpleadoPuesto($empleado,$puesto);
        if($nuevoEstado){
          $msj = "activó";
        }else{
          $msj = "desactivo";
        }

        ReporteMensualController::PoblarReportesDelAñoActual();
        

        db::commit();

        return RespuestaAPI::respuestaOk("¡LISTO! Ya se $msj el Rol de " . $puesto->nombreAparente. " para ".$empleado->getNombreCompleto());

      } catch (\Throwable $th) {
        error_log($th);

        db::rollBack();
        return RespuestaAPI::respuestaError("¡ERROR! Ocurrió un error inesperado");


      }


    }


    public function verMisDatos(){
        $empleado=Empleado::getEmpleadoLogeado();

        return view('Empleados.MisDatos',compact('empleado'));

    }

    public function cambiarContraseña(){
        $empleado=Empleado::getEmpleadoLogeado();

        return view('Empleados.CambiarContraseña',compact('empleado'));
    }


    public function guardarContrasena(Request $request){

        try {
            $empleado=Empleado::find($request->codEmpleado);
            $hashp = $empleado->usuario()->password;

            if(!password_verify($request->contraseñaActual1,$hashp))
                return redirect()->route('GestionUsuarios.cambiarContraseña')
                    ->with('datos','La contraseña actual que ingresó no es correcta.');

            Db::beginTransaction();
            $usuario=$empleado->usuario();
            $usuario->password=hash::make($request->contraseña);
            $usuario->save();

            DB::commit();
            return redirect()->route('GestionUsuarios.cambiarContraseña')
                ->with('datos','Se ha actualizado su contraseña exitosamente.');

        } catch (\Throwable $th) {
            Debug::mensajeError('EMPLEAADO CONTROLLER guardarContraseña',$th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );
            return redirect()->route('GestionUsuarios.cambiarContraseña')
                ->with('datos',Configuracion::getMensajeError($codErrorHistorial));
        }
    }



    public function guardarDPersonales(Request $request){
        try {

            db::beginTransaction();
            $empleado=Empleado::find($request->codEmpleado);
            $empleado->correo=$request->correo;
            $empleado->sexo=$request->sexo;
            $fechaNacimiento = Fecha::formatoParaSQL($request->fechaNacimiento);

            $empleado->fechaNacimiento=$fechaNacimiento;

            $empleado->nombreCargo=$request->cargo;
            $empleado->direccion=$request->direccion;
            $empleado->nroTelefono=$request->telefono;

            $empleado->save();

            DB::commit();
            return redirect()->route('GestionUsuarios.verMisDatos')->with('datos','Datos actualizados exitosamente.');
        } catch (\Throwable $th) {

            Debug::mensajeError('EMPLEAADO CONTROLLER guardarDPersonales',$th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th,
                                                             app('request')->route()->getAction(),
                                                             json_encode($request->toArray())
                                                            );

            return redirect()->route('GestionUsuarios.verMisDatos')->with('datos',Configuracion::getMensajeError($codErrorHistorial));

        }


    }


    /* cadena llega en formato 15*77
        15 es el codigo del empleado contador
        77 el codigo del proyecto a asignar
    */

    /* ESTA FUNCION SIRVE PARA CREAR COMO PARA DESTRUIR */
    public function asignarProyectoAContador($cadena){
        try {
            db::beginTransaction();
            $vector = explode('*',$cadena);
            $codEmpleadoContador = $vector[0];
            $codProyecto = $vector[1];

            /* VERIFICAMOS SI YA EXISTE UNA RELACION  */
            $lista = ProyectoContador::where('codEmpleadoContador','=',$codEmpleadoContador)->where('codProyecto','=',$codProyecto)->get();
            if(count($lista)>0){//YA EXISTE, lo destruimos
                $relacion = $lista[0];
                $relacion->delete();
                $retorno = 1;
            }else{//NO EXISTE, CREAREMOS UNO NUEVO
                $relacion = new ProyectoContador();
                $relacion->codEmpleadoContador = $codEmpleadoContador;
                $relacion->codProyecto = $codProyecto;
                $relacion->save();
                $retorno = 2;
            }

            db::commit();

            return $retorno;
        } catch (\Throwable $th) {
            Debug::mensajeError(' EMPLEADO CONTROLLER asignarProyecto contador' ,$th);
            DB::rollback();
            $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$cadena);
            return 0;
        }


    }


    public function AsignarContadorAProyectosPorComas(Request $request){
      try{
          db::beginTransaction();
          $codEmpleado = $request->codEmpleado;
          $empleado = new Empleado();
          $array_cods_proyectos = explode(',',$request->array_cods_proyectos);
          foreach ($array_cods_proyectos as $codigo_presupuestal) {
            $proyecto = Proyecto::findByCodigoPresupuestal($codigo_presupuestal);
            $ya_existe = ProyectoContador::verificarExistencia($proyecto->codProyecto,$codEmpleado);
            if(!$ya_existe){
              $nuevo = new ProyectoContador();
              $nuevo->codProyecto = $proyecto->codProyecto;
              $nuevo->codEmpleadoContador = $codEmpleado;
              $nuevo->save();
              $nombres[] = $proyecto->nombre; 
            } 

          }
          $nombres = implode(",",$nombres);
          $msj = "Se ha asociado al contador ".$empleado->getNombreCompleto(). " a los proyectos $nombres";

          db::commit();
          return redirect()->route('GestionUsuarios.verProyectosContador',$codEmpleado)->with('datos',$msj);
      } catch (\Throwable $th) {
          Debug::mensajeError(' EMPLEADO CONTROLLER asignar contador a todos los proyectos' ,$th);
          DB::rollback();
          $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$request);

          return redirect()->route('GestionUsuarios.verProyectosContador',$codEmpleado)->with('datos',"Ocurrio un error");
      }


    }



    public function QuitarContadorAProyectosPorComas(Request $request){
      try{
          db::beginTransaction();
          $codEmpleado = $request->codEmpleado;
          $empleado = new Empleado();
          $array_cods_proyectos = explode(',',$request->array_cods_proyectos);
          foreach ($array_cods_proyectos as $codigo_presupuestal) {
            $proyecto = Proyecto::findByCodigoPresupuestal($codigo_presupuestal);
            $ya_existe = ProyectoContador::verificarExistencia($proyecto->codProyecto,$codEmpleado);
            if($ya_existe){
              ProyectoContador::where('codProyecto',$proyecto->codProyecto)->where('codEmpleadoContador',$codEmpleado)->delete();
              $nombres[] = $proyecto->nombre; 
            } 

          }
          $nombres = implode(",",$nombres);
          $msj = "Se ha eliminado al contador ".$empleado->getNombreCompleto(). " de los proyectos $nombres";

          db::commit();
          return redirect()->route('GestionUsuarios.verProyectosContador',$codEmpleado)->with('datos',$msj);
      } catch (\Throwable $th) {
          Debug::mensajeError(' EMPLEADO CONTROLLER asignar contador a todos los proyectos' ,$th);
          DB::rollback();
          $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$request);

          return redirect()->route('GestionUsuarios.verProyectosContador',$codEmpleado)->with('datos',"Ocurrio un error");
      }


    }


    
    public function AsignarObservadorAProyectosPorComas(Request $request){
      try{
          db::beginTransaction();
          $codEmpleado = $request->codEmpleado;
          $empleado = new Empleado();
          $array_cods_proyectos = explode(',',$request->array_cods_proyectos);
          foreach ($array_cods_proyectos as $codigo_presupuestal) {
            $proyecto = Proyecto::findByCodigoPresupuestal($codigo_presupuestal);
            $ya_existe = ProyectoObservador::verificarExistencia($proyecto->codProyecto,$codEmpleado);
            if(!$ya_existe){
              $nuevo = new ProyectoObservador();
              $nuevo->codProyecto = $proyecto->codProyecto;
              $nuevo->codEmpleadoObservador = $codEmpleado;
              $nuevo->save();
              $nombres[] = $proyecto->nombre; 
            } 

          }
          $nombres = implode(",",$nombres);
          $msj = "Se ha asociado al observador ".$empleado->getNombreCompleto(). " a los proyectos $nombres";

          db::commit();
          return redirect()->route('GestionUsuarios.verProyectosObservador',$codEmpleado)->with('datos',$msj);
      } catch (\Throwable $th) {
          Debug::mensajeError(' EMPLEADO CONTROLLER asignar observador a todos los proyectos' ,$th);
          DB::rollback();
          $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$request);

          return redirect()->route('GestionUsuarios.verProyectosObservador',$codEmpleado)->with('datos',"Ocurrio un error");
      }


    }



    public function QuitarObservadorAProyectosPorComas(Request $request){
      try{
          db::beginTransaction();
          $codEmpleado = $request->codEmpleado;
          $empleado = new Empleado();
          $array_cods_proyectos = explode(',',$request->array_cods_proyectos);
          foreach ($array_cods_proyectos as $codigo_presupuestal) {
            $proyecto = Proyecto::findByCodigoPresupuestal($codigo_presupuestal);
            $ya_existe = ProyectoObservador::verificarExistencia($proyecto->codProyecto,$codEmpleado);
            if($ya_existe){
              ProyectoObservador::where('codProyecto',$proyecto->codProyecto)->where('codEmpleadoObservador',$codEmpleado)->delete();
              $nombres[] = $proyecto->nombre; 
            } 

          }
          $nombres = implode(",",$nombres);
          $msj = "Se ha eliminado al observador ".$empleado->getNombreCompleto(). " de los proyectos $nombres";

          db::commit();
          return redirect()->route('GestionUsuarios.verProyectosObservador',$codEmpleado)->with('datos',$msj);
      } catch (\Throwable $th) {
          Debug::mensajeError(' EMPLEADO CONTROLLER asignar observador a todos los proyectos' ,$th);
          DB::rollback();
          $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$request);

          return redirect()->route('GestionUsuarios.verProyectosObservador',$codEmpleado)->with('datos',"Ocurrio un error");
      }


    }


    public function asignarContadorATodosProyectos($codEmpleadoContador){
        try{
            db::beginTransaction();
            ProyectoContador::where('codEmpleadoContador','=',$codEmpleadoContador)->delete();

            $listaProyectos = Proyecto::getProyectosActivos();
            foreach ($listaProyectos as $proy ) {
                $relacion = new ProyectoContador();
                $relacion->codProyecto = $proy->codProyecto;
                $relacion->codEmpleadoContador = $codEmpleadoContador;
                $relacion->save();

            }

            db::commit();
            return 1;
        } catch (\Throwable $th) {
            Debug::mensajeError(' EMPLEADO CONTROLLER asignar contador a todos los proyectos' ,$th);
            DB::rollback();
            $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$codEmpleadoContador);
            return 0;
        }

    }

    public function quitarContadorATodosProyectos($codEmpleadoContador){
        try{
            db::beginTransaction();
            ProyectoContador::where('codEmpleadoContador','=',$codEmpleadoContador)->delete();

            db::commit();
            return 1;
        } catch (\Throwable $th) {
            Debug::mensajeError(' EMPLEADO CONTROLLER quitar contador a todos los proyectos' ,$th);
            DB::rollback();
            $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$codEmpleadoContador);
            return 0;
        }


    }





        /* cadena llega en formato 15*77
        15 es el codigo del empleado observador
        77 el codigo del proyecto a asignar
    */

    /* ESTA FUNCION SIRVE PARA CREAR COMO PARA DESTRUIR */
    public function asignarProyectoAObservador($cadena){
      try {
          db::beginTransaction();
          $vector = explode('*',$cadena);
          $codEmpleadoObservador = $vector[0];
          $codProyecto = $vector[1];

          /* VERIFICAMOS SI YA EXISTE UNA RELACION  */
          $lista = ProyectoObservador::where('codEmpleadoObservador','=',$codEmpleadoObservador)->where('codProyecto','=',$codProyecto)->get();
          if(count($lista)>0){//YA EXISTE, lo destruimos
              $relacion = $lista[0];
              $relacion->delete();
              $retorno = 1;
          }else{//NO EXISTE, CREAREMOS UNO NUEVO
              $relacion = new ProyectoObservador();
              $relacion->codEmpleadoObservador = $codEmpleadoObservador;
              $relacion->codProyecto = $codProyecto;
              $relacion->save();
              $retorno = 2;
          }

          db::commit();

          return $retorno;
      } catch (\Throwable $th) {
          Debug::mensajeError(' EMPLEADO CONTROLLER asignarProyecto observador' ,$th);
          DB::rollback();
          $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$cadena);
          return 0;
      }


  }


  public function asignarObservadorATodosProyectos($codEmpleadoObservador){
      try{

          db::beginTransaction();
          ProyectoObservador::where('codEmpleadoObservador','=',$codEmpleadoObservador)->delete();

          $listaProyectos = Proyecto::getProyectosActivos();
          foreach ($listaProyectos as $proy ) {
              $relacion = new ProyectoObservador();
              $relacion->codProyecto = $proy->codProyecto;
              $relacion->codEmpleadoObservador = $codEmpleadoObservador;
              $relacion->save();

          }

          db::commit();
          return 1;
      } catch (\Throwable $th) {
          Debug::mensajeError(' EMPLEADO CONTROLLER asignar observador a todos los proyectos' ,$th);
          DB::rollback();
          $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$codEmpleadoObservador);
          return 0;
      }

  }

  public function quitarObservadorATodosProyectos($codEmpleadoObservador){
      try{
          db::beginTransaction();
          ProyectoObservador::where('codEmpleadoObservador','=',$codEmpleadoObservador)->delete();

          db::commit();
          return 1;
      } catch (\Throwable $th) {
          Debug::mensajeError(' EMPLEADO CONTROLLER quitar observador a todos los proyectos' ,$th);
          DB::rollback();
          $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$codEmpleadoObservador);
          return 0;
      }


  }




    public function verProyectosContador($codEmpleadoContador){
        $empleado = Empleado::findOrFail($codEmpleadoContador);

        $listaProyectos = Proyecto::getProyectosActivos();

        return view('Empleados.AsignarProyectosAContador',compact('empleado','listaProyectos'));


    }

    public function verProyectosObservador($codEmpleadoContador){
      $empleado = Empleado::findOrFail($codEmpleadoContador);

      $listaProyectos = Proyecto::getProyectosActivos();

      return view('Empleados.AsignarProyectosAObservador',compact('empleado','listaProyectos'));


    }




    /* Funcion ejecutada desde JS con un get */
    /* La cadena tiene el formato 15*2
    Donde 15 esel codigo del empleado contador
    donde 2 es el codigo de la nueva sede
    */
    public function cambiarSedeAContador($cadena){
        try {
            db::beginTransaction();
            $vector = explode('*',$cadena);
            $codEmpleado = $vector[0];
            $codSedeContador = $vector[1];

            $empleado = Empleado::findOrFail($codEmpleado);
            $empleado->codSedeContador = $codSedeContador;
            $empleado->save();

            db::commit();

            return TRUE;
        } catch (\Throwable $th) {

            Debug::mensajeError('PROYECTO CONTROLLER cambiarSedeAContador',$th);
            DB::rollBack();
            $codErrorHistorial=ErrorHistorial::registrarError($th, app('request')->route()->getAction(),$cadena);
            return FALSE;
        }
    }


    /*
    Funcion que solo usaré una vez (espero xd)
        recorre todos los empleados y formatea sus nombres y apellidos

       convertir todos los nombres "DIEGO ERNESTO VIGO BRIONES" o "diego ernesto vigo briones"
        a "Diego Ernesto Vigo Briones"
    */
    public function cambiarNombresEmpleadosAFormatoBonito(){
        return "funcion desactivada";
        try{

            db::beginTransaction();
            $cadena = "";
            $listaEmpleados = Empleado::All();
            foreach ($listaEmpleados as $emp ) {
                $emp->nombres = ucwords(mb_strtolower($emp->nombres));
                $emp->apellidos = ucwords(mb_strtolower($emp->apellidos));
                $emp->save();
            }
            db::commit();

            return "FUNCION cambiarNombresEmpleadosAFormatoBonito ejecutada exitosamente. ".$cadena;
        }catch(Throwable $th){
            Debug::mensajeError('EMPLEADO CONTROLLER cambiarNombresEmpleadosAFormatoBonito',$th);
            db::rollback();

        }


    }

}
