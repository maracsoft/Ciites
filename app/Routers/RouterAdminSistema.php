<?php

namespace App\Routers;

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ErrorHistorialController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\LogeoHistorialController;
use App\Http\Controllers\MigracionController;
use App\Http\Controllers\OperacionesController;
use App\Http\Controllers\ParametroSistemaController;
use App\Http\Controllers\PeriodoDirectorController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\TipoOperacionController;
use App\Http\Controllers\UnidadMedidaController;
use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterAdminSistema implements ModuleRouterInterface
{
  public static function RegisterRoutes()
  {
    Route::get('/GestionUsuarios/asignarProyectoAContador/{cadena}', [EmpleadoController::class, 'asignarProyectoAContador']);
    Route::get('/GestionUsuarios/asignarContadorATodosProyectos/{codEmpleadoContador}', [EmpleadoController::class, 'asignarContadorATodosProyectos']);
    Route::get('/GestionUsuarios/quitarContadorATodosProyectos/{codEmpleadoContador}', [EmpleadoController::class, 'quitarContadorATodosProyectos']);


    Route::get('/GestionUsuarios/asignarProyectoAObservador/{cadena}', [EmpleadoController::class, 'asignarProyectoAObservador']);
    Route::get('/GestionUsuarios/asignarObservadorATodosProyectos/{codEmpleadoContador}', [EmpleadoController::class, 'asignarObservadorATodosProyectos']);
    Route::get('/GestionUsuarios/quitarObservadorATodosProyectos/{codEmpleadoContador}', [EmpleadoController::class, 'quitarObservadorATodosProyectos']);

    Route::get('/Sede/cambiarAdministrador/{cadena}', [SedeController::class, 'cambiarAdministrador']);

    /* FUNCIONES PROPIAS DEL ADMINISTRADOR DEL SISTEMA */
    Route::group(['middleware' => "ValidarSesionAdminSistema"], function () {

      Route::get('/AdminPanel/Ver', [AdminPanelController::class, 'VerPanel'])->name('AdminPanel.VerPanel');
      Route::get('/AdminPanel/VerPhpInfo', [AdminPanelController::class, 'VerPhpInfo'])->name('AdminPanel.VerPhpInfo');


      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */
      /* *********************** MODULO DE JOBS ************************ */

      Route::get('/Jobs/Listar', [JobsController::class, 'ListarJobs'])->name('Jobs.Listar');
      Route::get('/Jobs/Crear', [JobsController::class, 'Crear'])->name('Jobs.Crear');
      Route::post('/Jobs/GuardarEditar', [JobsController::class, 'GuardarEditar'])->name('Jobs.GuardarEditar');
      Route::get('/Jobs/{codJob}/Editar', [JobsController::class, 'Editar'])->name('Jobs.Editar');

      Route::get('/Jobs/{codJob}/RunJob', [JobsController::class, 'RunJob'])->name('Jobs.RunJob');
      Route::get('/Jobs/{codJob}/UnRunJob', [JobsController::class, 'UnRunJob'])->name('Jobs.UnRunJob');


      Route::get('/Jobs/{codJob}/Eliminar', [JobsController::class, 'Eliminar'])->name('Jobs.Eliminar');

      /* *********************** MODULO DE MIGRACIONES ************************ */
      /* *********************** MODULO DE MIGRACIONES ************************ */
      /* *********************** MODULO DE MIGRACIONES ************************ */
      /* *********************** MODULO DE MIGRACIONES ************************ */
      /* *********************** MODULO DE MIGRACIONES ************************ */
      Route::get('/Migraciones/Listar', [MigracionController::class, 'ListarMigraciones'])->name('Migraciones.Listar');
      Route::get('/Migraciones/Inv_ListarMigraciones', [MigracionController::class, 'Inv_ListarMigraciones'])->name('Migraciones.Inv_Listar');


      /* Modulo de modificaciones de la bd */


      Route::get('/DB/GenerarBackup', [OperacionesController::class, 'GenerarBackup']);
      Route::get('/DB/CorrerMigraciones', [MigracionController::class, 'CorrerMigraciones']);

      Route::post('/testearPOST',     [OperacionesController::class, 'testearPOST'])->name('TestearPost');




      Route::get('/TipoOperaciones/Listar', [TipoOperacionController::class, 'listar'])->name('TipoOperacion.Listar');

      Route::get('/Operaciones/Listar', [OperacionesController::class, 'ListarOperaciones'])->name('Operaciones.Listar');
      Route::get('/Operaciones/Eliminar/{codOperacion}', [OperacionesController::class, 'EliminarOperacion'])->name('Operaciones.EliminarOperacion');




      /* **************************** MODULO DE CONFIGURACIÓN DE PERIODOS ********************* */

      Route::get('/PeriodoDirector/Listar', [PeriodoDirectorController::class, 'ListarPeriodos'])->name('PeriodoDirector.Listar');
      Route::get('/PeriodoDirector/Inv_Listar', [PeriodoDirectorController::class, 'Inv_ListarPeriodos'])->name('PeriodoDirector.Inv_Listar');

      Route::get('/PeriodoDirector/GetFormInvocable/{codPeriodoDirector}', [PeriodoDirectorController::class, 'GetFormInvocable'])->name('PeriodoDirector.GetFormInvocable');

      Route::post('/PeriodoDirector/GuardarActualizar', [PeriodoDirectorController::class, 'GuardarActualizar'])->name('PeriodoDirector.GuardarActualizar');


      /* MODULO DE PARAMETROS DEL SISTEMA */


      Route::get('/ParametroSistema/Listar', [ParametroSistemaController::class, 'listar'])->name('ParametroSistema.Listar');

      Route::get('/ParametroSistema/Inv/TablaListar', [ParametroSistemaController::class, 'inv_listado'])->name('ParametroSistema.inv_listado');
      Route::get('/ParametroSistema/JSON/GetParametros', [ParametroSistemaController::class, 'JSON_GetParametros'])->name('ParametroSistema.JSON_GetParametros');

      Route::post('/ParametroSistema/guardarYActualizar', [ParametroSistemaController::class, 'guardarYActualizar'])->name('ParametroSistema.guardarYActualizar');
      Route::get('/ParametroSistema/darDeBaja/{codParametro}', [ParametroSistemaController::class, 'darDeBaja'])->name('ParametroSistema.darDeBaja');






      /* -----------------------------------------MODULO HISTORIAL DE ERRORES-------------------------- */

      //listar errores
      Route::get('/HistorialErrores', [ErrorHistorialController::class, 'listarErrores'])->name('HistorialErrores.Listar');
      Route::get('/HistorialErrores/{codError}/cambiarEstadoError', [ErrorHistorialController::class, 'cambiarEstadoError'])->name('HistorialErrores.cambiarEstadoError');
      Route::get('/HistorialErrores/ver/{id}', [ErrorHistorialController::class, 'ver'])->name('HistorialErrores.ver');
      Route::post('/HistorialErrores/guardarRazonSolucionError', [ErrorHistorialController::class, 'guardarRazonSolucionError'])->name('HistorialErrores.guardarRazonSolucionError');


      /* -----------------------------------------MODULO HISTORIAL DE LOGEOS-------------------------- */

      //listar logeos
      Route::get('/HistorialLogeos', [LogeoHistorialController::class, 'listarLogeos'])->name('HistorialLogeos.Listar');
      Route::post('/HistorialLogeos/getDataGrafico', [LogeoHistorialController::class, 'getDataGrafico'])->name('HistorialLogeos.getDataGrafico');





      /* Invocable */
      Route::get('/HistorialLogeos/OperacionesDeSesion/{codSesion}', [LogeoHistorialController::class, 'inv_operacionesDeSesion'])->name('HistorialLogeos.inv_operacionesDeSesion');


      /* ----------------------------------------------        MODULO GESTIÓN DE USUARIOS ---------------------------- */
      Route::get('/GestionUsuarios/listar', [EmpleadoController::class, 'listarEmpleados'])->name('GestionUsuarios.Listar');

      Route::get('/GestionUsuarios/crear', [EmpleadoController::class, 'crearEmpleado'])->name('GestionUsuarios.create');

      Route::post('/GestionUsuarios/save', [EmpleadoController::class, 'guardarCrearEmpleado'])->name('GestionUsuarios.store');

      Route::get('/GestionUsuarios/verProyectosContador/{codEmpleado}', [EmpleadoController::class, 'verProyectosContador'])->name('GestionUsuarios.verProyectosContador');
      Route::get('/GestionUsuarios/verProyectosObservador/{codEmpleado}', [EmpleadoController::class, 'verProyectosObservador'])->name('GestionUsuarios.verProyectosObservador');


      Route::get('/GestionUsuarios/{id}/editarUsuario', [EmpleadoController::class, 'editarUsuario'])->name('GestionUsuarios.editUsuario');
      Route::get('/GestionUsuarios/{id}/editarEmpleado', [EmpleadoController::class, 'editarEmpleado'])->name('GestionUsuarios.editEmpleado');
      Route::post('/GestionUsuarios/updateUsuario', [EmpleadoController::class, 'guardarEditarUsuario'])->name('GestionUsuarios.updateUsuario');
      Route::post('/GestionUsuarios/updateEmpleado', [EmpleadoController::class, 'guardarEditarEmpleado'])->name('GestionUsuarios.updateEmpleado');

      Route::get('/GestionUsuarios/{id}/cesar', [EmpleadoController::class, 'cesarEmpleado'])->name('GestionUsuarios.cesar');
      Route::get('/GestionUsuarios/{id}/reactivar', [EmpleadoController::class, 'reactivarEmpleado'])->name('GestionUsuarios.reactivar');


      Route::get('/GestionUsuarios/ActualizarSedeContador/{cadena}', [EmpleadoController::class, 'cambiarSedeAContador'])->name('GestionUsuarios.cambiarSedeAContador');






      /* ----------------------------------------------        MODULO PUESTOS           ------------------------------------------ */
      Route::get('/GestionPuestos/listar', [PuestoController::class, 'listarPuestos'])->name('GestionPuestos.Listar');

      Route::get('/GestionPuestos/crear', [PuestoController::class, 'crearPuesto'])->name('GestionPuestos.create');
      Route::post('/GestionPuestos/save', [PuestoController::class, 'guardarCrearPuesto'])->name('GestionPuestos.store');

      Route::get('/GestionPuestos/{id}/editar', [PuestoController::class, 'editarPuesto'])->name('GestionPuestos.edit');
      Route::post('/GestionPuestos/update', [PuestoController::class, 'guardarEditarPuesto'])->name('GestionPuestos.update');

      Route::get('/GestionPuestos/{id}/eliminar', [PuestoController::class, 'eliminarPuesto'])->name('GestionPuestos.delete');

      Route::get('/GestionPuestos/TogleEmpleadoPuesto', [EmpleadoController::class, 'TogleEmpleadoPuesto'])->name('GestionPuestos.TogleEmpleadoPuesto');





      /* ---------------------------------------------- MODULO UNIDAD DE MEDIDA -------------------------------------------- */
      Route::get('/GestiónUnidadMedida/listar', [UnidadMedidaController::class, 'listarUnidades'])->name('GestiónUnidadMedida.listar');

      Route::get('/GestiónUnidadMedida/crear', [UnidadMedidaController::class, 'crearUnidad'])->name('GestiónUnidadMedida.crear');
      Route::post('/GestiónUnidadMedida/store', [UnidadMedidaController::class, 'store'])->name('GestiónUnidadMedida.store');

      Route::get('/GestiónUnidadMedida/{id}/editar', [UnidadMedidaController::class, 'editarUnidad'])->name('GestiónUnidadMedida.editar');
      Route::post('/GestiónUnidadMedida/update', [UnidadMedidaController::class, 'update'])->name('GestiónUnidadMedida.update');

      Route::get('/GestiónUnidadMedida/{id}/eliminar', [UnidadMedidaController::class, 'delete'])->name('GestiónUnidadMedida.eliminar');



      Route::get('/Sede/listarSedes', [SedeController::class, 'listarSedes'])->name('Sede.ListarSedes');

      Route::post('/Sede/GuardarEditar', [SedeController::class, 'GuardarEditar'])->name('Sede.GuardarEditar');





      Route::get('/BuscadorMaestro', [OperacionesController::class, 'buscadorMaestro'])->name('BuscadorMaestro');

      Route::get('/BuscadorMaestro/CambiarEstadoDocumento', [OperacionesController::class, 'CambiarEstadoDocumento'])->name('BuscadorMaestro.CambiarEstadoDocumento');
      Route::get('/BuscadorMaestro/REQ_CambiarTieneFactura', [OperacionesController::class, 'REQ_CambiarTieneFactura'])->name('BuscadorMaestro.REQ_CambiarTieneFactura');
      Route::get('/BuscadorMaestro/REQ_CambiarFacturaContabilizada', [OperacionesController::class, 'REQ_CambiarFacturaContabilizada'])->name('BuscadorMaestro.REQ_CambiarFacturaContabilizada');
      Route::get('/BuscadorMaestro/REQ_BorrarArchivosAdministrador', [OperacionesController::class, 'REQ_BorrarArchivosAdministrador'])->name('BuscadorMaestro.REQ_BorrarArchivosAdministrador');

      Route::get('/BuscadorMaestro/Invocables/GetListadoBusqueda', [OperacionesController::class, 'GetListadoBusqueda'])
        ->name('GetListadoBusqueda');
    });
  }
}
