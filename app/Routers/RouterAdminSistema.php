<?php

namespace App\Routers;

use App\Models\ModuleRouterInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RouterAdminSistema implements ModuleRouterInterface
{
  public static function RegisterRoutes()
  {
    Route::get('/GestionUsuarios/asignarProyectoAContador/{cadena}', 'EmpleadoController@asignarProyectoAContador');
    Route::get('/GestionUsuarios/asignarContadorATodosProyectos/{codEmpleadoContador}', 'EmpleadoController@asignarContadorATodosProyectos');
    Route::get('/GestionUsuarios/quitarContadorATodosProyectos/{codEmpleadoContador}', 'EmpleadoController@quitarContadorATodosProyectos');


    Route::get('/GestionUsuarios/asignarProyectoAObservador/{cadena}', 'EmpleadoController@asignarProyectoAObservador');
    Route::get('/GestionUsuarios/asignarObservadorATodosProyectos/{codEmpleadoContador}', 'EmpleadoController@asignarObservadorATodosProyectos');
    Route::get('/GestionUsuarios/quitarObservadorATodosProyectos/{codEmpleadoContador}', 'EmpleadoController@quitarObservadorATodosProyectos');

    Route::get('/Sede/cambiarAdministrador/{cadena}', 'SedeController@cambiarAdministrador');

    /* FUNCIONES PROPIAS DEL ADMINISTRADOR DEL SISTEMA */
    Route::group(['middleware' => "ValidarSesionAdminSistema"], function () {

      Route::get('/AdminPanel/Ver', 'AdminPanelController@VerPanel')->name('AdminPanel.VerPanel');
      Route::get('/AdminPanel/VerPhpInfo', 'AdminPanelController@VerPhpInfo')->name('AdminPanel.VerPhpInfo');


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

      Route::get('/Jobs/Listar', 'JobsController@ListarJobs')->name('Jobs.Listar');
      Route::get('/Jobs/Crear', 'JobsController@Crear')->name('Jobs.Crear');
      Route::post('/Jobs/GuardarEditar', 'JobsController@GuardarEditar')->name('Jobs.GuardarEditar');
      Route::get('/Jobs/{codJob}/Editar', 'JobsController@Editar')->name('Jobs.Editar');

      Route::get('/Jobs/{codJob}/RunJob', 'JobsController@RunJob')->name('Jobs.RunJob');
      Route::get('/Jobs/{codJob}/UnRunJob', 'JobsController@UnRunJob')->name('Jobs.UnRunJob');


      Route::get('/Jobs/{codJob}/Eliminar', 'JobsController@Eliminar')->name('Jobs.Eliminar');

      /* *********************** MODULO DE MIGRACIONES ************************ */
      /* *********************** MODULO DE MIGRACIONES ************************ */
      /* *********************** MODULO DE MIGRACIONES ************************ */
      /* *********************** MODULO DE MIGRACIONES ************************ */
      /* *********************** MODULO DE MIGRACIONES ************************ */
      Route::get('/Migraciones/Listar', 'MigracionController@ListarMigraciones')->name('Migraciones.Listar');
      Route::get('/Migraciones/Inv_ListarMigraciones', 'MigracionController@Inv_ListarMigraciones')->name('Migraciones.Inv_Listar');


      /* Modulo de modificaciones de la bd */


      Route::get('/DB/GenerarBackup', 'OperacionesController@GenerarBackup');
      Route::get('/DB/CorrerMigraciones', 'MigracionController@CorrerMigraciones');

      Route::post('/testearPOST',     'OperacionesController@testearPOST')->name('TestearPost');




      Route::get('/TipoOperaciones/Listar', 'TipoOperacionController@listar')->name('TipoOperacion.Listar');

      Route::get('/Operaciones/Listar', 'OperacionesController@ListarOperaciones')->name('Operaciones.Listar');
      Route::get('/Operaciones/Eliminar/{codOperacion}', 'OperacionesController@EliminarOperacion')->name('Operaciones.EliminarOperacion');




      /* **************************** MODULO DE CONFIGURACIÓN DE PERIODOS ********************* */

      Route::get('/PeriodoDirector/Listar', 'PeriodoDirectorController@ListarPeriodos')->name('PeriodoDirector.Listar');
      Route::get('/PeriodoDirector/Inv_Listar', 'PeriodoDirectorController@Inv_ListarPeriodos')->name('PeriodoDirector.Inv_Listar');

      Route::get('/PeriodoDirector/GetFormInvocable/{codPeriodoDirector}', 'PeriodoDirectorController@GetFormInvocable')->name('PeriodoDirector.GetFormInvocable');

      Route::post('/PeriodoDirector/GuardarActualizar', 'PeriodoDirectorController@GuardarActualizar')->name('PeriodoDirector.GuardarActualizar');


      /* MODULO DE PARAMETROS DEL SISTEMA */


      Route::get('/ParametroSistema/Listar', 'ParametroSistemaController@listar')->name('ParametroSistema.Listar');

      Route::get('/ParametroSistema/Inv/TablaListar', 'ParametroSistemaController@inv_listado')->name('ParametroSistema.inv_listado');
      Route::get('/ParametroSistema/JSON/GetParametros', 'ParametroSistemaController@JSON_GetParametros')->name('ParametroSistema.JSON_GetParametros');

      Route::post('/ParametroSistema/guardarYActualizar', 'ParametroSistemaController@guardarYActualizar')->name('ParametroSistema.guardarYActualizar');
      Route::get('/ParametroSistema/darDeBaja/{codParametro}', 'ParametroSistemaController@darDeBaja')->name('ParametroSistema.darDeBaja');






      /* -----------------------------------------MODULO HISTORIAL DE ERRORES-------------------------- */

      //listar errores
      Route::get('/HistorialErrores', 'ErrorHistorialController@listarErrores')->name('HistorialErrores.Listar');
      Route::get('/HistorialErrores/{codError}/cambiarEstadoError', 'ErrorHistorialController@cambiarEstadoError')->name('HistorialErrores.cambiarEstadoError');
      Route::get('/HistorialErrores/ver/{id}', 'ErrorHistorialController@ver')->name('HistorialErrores.ver');
      Route::post('/HistorialErrores/guardarRazonSolucionError', 'ErrorHistorialController@guardarRazonSolucionError')->name('HistorialErrores.guardarRazonSolucionError');


      /* -----------------------------------------MODULO HISTORIAL DE LOGEOS-------------------------- */

      //listar logeos
      Route::get('/HistorialLogeos', 'LogeoHistorialController@listarLogeos')->name('HistorialLogeos.Listar');
      Route::post('/HistorialLogeos/getDataGrafico', 'LogeoHistorialController@getDataGrafico')->name('HistorialLogeos.getDataGrafico');





      /* Invocable */
      Route::get('/HistorialLogeos/OperacionesDeSesion/{codSesion}', 'LogeoHistorialController@inv_operacionesDeSesion')->name('HistorialLogeos.inv_operacionesDeSesion');


      /* ----------------------------------------------        MODULO GESTIÓN DE USUARIOS ---------------------------- */
      Route::get('/GestionUsuarios/listar', 'EmpleadoController@listarEmpleados')->name('GestionUsuarios.Listar');

      Route::get('/GestionUsuarios/crear', 'EmpleadoController@crearEmpleado')->name('GestionUsuarios.create');

      Route::post('/GestionUsuarios/save', 'EmpleadoController@guardarCrearEmpleado')->name('GestionUsuarios.store');

      Route::get('/GestionUsuarios/verProyectosContador/{codEmpleado}', 'EmpleadoController@verProyectosContador')->name('GestionUsuarios.verProyectosContador');
      Route::get('/GestionUsuarios/verProyectosObservador/{codEmpleado}', 'EmpleadoController@verProyectosObservador')->name('GestionUsuarios.verProyectosObservador');


      Route::get('/GestionUsuarios/{id}/editarUsuario', 'EmpleadoController@editarUsuario')->name('GestionUsuarios.editUsuario');
      Route::get('/GestionUsuarios/{id}/editarEmpleado', 'EmpleadoController@editarEmpleado')->name('GestionUsuarios.editEmpleado');
      Route::post('/GestionUsuarios/updateUsuario', 'EmpleadoController@guardarEditarUsuario')->name('GestionUsuarios.updateUsuario');
      Route::post('/GestionUsuarios/updateEmpleado', 'EmpleadoController@guardarEditarEmpleado')->name('GestionUsuarios.updateEmpleado');

      Route::get('/GestionUsuarios/{id}/cesar', 'EmpleadoController@cesarEmpleado')->name('GestionUsuarios.cesar');
      Route::get('/GestionUsuarios/{id}/reactivar', 'EmpleadoController@reactivarEmpleado')->name('GestionUsuarios.reactivar');


      Route::get('/GestionUsuarios/ActualizarSedeContador/{cadena}', 'EmpleadoController@cambiarSedeAContador')->name('GestionUsuarios.cambiarSedeAContador');






      /* ----------------------------------------------        MODULO PUESTOS           ------------------------------------------ */
      Route::get('/GestionPuestos/listar', 'PuestoController@listarPuestos')->name('GestionPuestos.Listar');

      Route::get('/GestionPuestos/crear', 'PuestoController@crearPuesto')->name('GestionPuestos.create');
      Route::post('/GestionPuestos/save', 'PuestoController@guardarCrearPuesto')->name('GestionPuestos.store');

      Route::get('/GestionPuestos/{id}/editar', 'PuestoController@editarPuesto')->name('GestionPuestos.edit');
      Route::post('/GestionPuestos/update', 'PuestoController@guardarEditarPuesto')->name('GestionPuestos.update');

      Route::get('/GestionPuestos/{id}/eliminar', 'PuestoController@eliminarPuesto')->name('GestionPuestos.delete');

      Route::get('/GestionPuestos/TogleEmpleadoPuesto', 'EmpleadoController@TogleEmpleadoPuesto')->name('GestionPuestos.TogleEmpleadoPuesto');





      /* ---------------------------------------------- MODULO UNIDAD DE MEDIDA -------------------------------------------- */
      Route::get('/GestiónUnidadMedida/listar', 'UnidadMedidaController@listarUnidades')->name('GestiónUnidadMedida.listar');

      Route::get('/GestiónUnidadMedida/crear', 'UnidadMedidaController@crearUnidad')->name('GestiónUnidadMedida.crear');
      Route::post('/GestiónUnidadMedida/store', 'UnidadMedidaController@store')->name('GestiónUnidadMedida.store');

      Route::get('/GestiónUnidadMedida/{id}/editar', 'UnidadMedidaController@editarUnidad')->name('GestiónUnidadMedida.editar');
      Route::post('/GestiónUnidadMedida/update', 'UnidadMedidaController@update')->name('GestiónUnidadMedida.update');

      Route::get('/GestiónUnidadMedida/{id}/eliminar', 'UnidadMedidaController@delete')->name('GestiónUnidadMedida.eliminar');



      Route::get('/Sede/listarSedes', 'SedeController@listarSedes')->name('Sede.ListarSedes');

      Route::post('/Sede/GuardarEditar', 'SedeController@GuardarEditar')->name('Sede.GuardarEditar');





      Route::get('/BuscadorMaestro', 'OperacionesController@buscadorMaestro')->name('BuscadorMaestro');

      Route::get('/BuscadorMaestro/CambiarEstadoDocumento', 'OperacionesController@CambiarEstadoDocumento')->name('BuscadorMaestro.CambiarEstadoDocumento');
      Route::get('/BuscadorMaestro/REQ_CambiarTieneFactura', 'OperacionesController@REQ_CambiarTieneFactura')->name('BuscadorMaestro.REQ_CambiarTieneFactura');
      Route::get('/BuscadorMaestro/REQ_CambiarFacturaContabilizada', 'OperacionesController@REQ_CambiarFacturaContabilizada')->name('BuscadorMaestro.REQ_CambiarFacturaContabilizada');
      Route::get('/BuscadorMaestro/REQ_BorrarArchivosAdministrador', 'OperacionesController@REQ_BorrarArchivosAdministrador')->name('BuscadorMaestro.REQ_BorrarArchivosAdministrador');

      Route::get('/BuscadorMaestro/Invocables/GetListadoBusqueda', 'OperacionesController@GetListadoBusqueda')
        ->name('GetListadoBusqueda');
    });
  }
}
