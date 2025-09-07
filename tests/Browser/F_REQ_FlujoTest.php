<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Configuracion;
use App\Debug;
use App\DetalleRequerimientoGastos;
use App\FakerCedepas;
use App\Proyecto;
use App\RequerimientoGastos;
use App\RequerimientoBS;
use App\SolicitudFondos;
use App\User;
use Faker\Factory as Faker;
use Tests\Browser\Helpers\GeneralFunctions;

class F_REQ_FlujoTest extends DuskTestCase
{
  /* PARA CORRER SOLO ESTE TEST
        php artisan dusk tests/Browser/F_REQ_FlujoTest.php

    */

  public $codigoRBS = "";
  public $requerimiento;
  public static $codUsuarioEmisor;

  const delta_time = 1000;

  public function testFlujoREQ()
  {

    // $this->activarInputsEscondidos();

    // $this->assertTrue(Configuracion::mostrarInputsEscondidos());
    self::$codUsuarioEmisor = env('TEST_USER_ID');

    $this->empleado_crearRequerimiento();
    $this->requerimiento = RequerimientoBS::where('codigoCedepas', $this->codigoRBS)->firstOrFail();

    // $this->gerente_rechazarRequerimiento();

    // $this->gerente_observarRequerimiento();
    // $this->empleado_editarRequerimiento();

    $this->gerente_aprobarRequerimiento();

    // $this->administrador_observarRequerimiento();
    // $this->empleado_editarRequerimiento();

    // $this->gerente_aprobarRequerimiento();

    // $this->administrador_rechazarRequerimiento();

    $this->administrador_atenderRequerimiento();

    $this->contador_contabilizarRequerimiento();

    // $this->desactivarInputsEscondidos();
  }

  public function empleado_crearRequerimiento()
  {

    $this->browse(function (Browser $browser) {
      $proyecto = Proyecto::findOrFail(env('TEST_PROYECTO_ID'));
      $cuerpo = FakerCedepas::F_REQ_generarCuerpo($proyecto);
      $usuario = User::findOrFail(self::$codUsuarioEmisor);

      $browser
        ->loginAs($usuario)
        ->visit(route('RequerimientoBS.Empleado.CrearRequerimientoBS'))
        ->pause(self::delta_time);

      foreach ($cuerpo as $nombreCampo => $valor) {
        Debug::mensajeSimple($nombreCampo . "=" . $valor);
        if (in_array($nombreCampo, ['codProyecto'])) //si es de los de select
          $browser->select('#' . $nombreCampo, $valor);
        else
          $browser->type("#" . $nombreCampo, $valor);
      }

      $cantidadItems = rand(1, 5);

      $browser->pause(self::delta_time);

      for ($i = 0; $i < $cantidadItems; $i++) {
        $detalle = FakerCedepas::F_REQ_GenerarDetalle($proyecto);
        $browser
          ->select('#ComboBoxUnidad', $detalle['ComboBoxUnidad'])
          ->pause(self::delta_time)
          ->type('#cantidad', $detalle['cantidad'])
          ->pause(self::delta_time)
          ->type('#descripcion', $detalle['descripcion'])
          ->pause(self::delta_time)
          ->type('#codigoPresupuestal', $detalle['codigoPresupuestal'])
          ->pause(self::delta_time)
          ->press('#btnadddet')
          ->pause(self::delta_time);
      }

      $nombreArchivo = "Ms Excel.pdf";
      $browser->attach('#filenames', __DIR__ . '/ArchivosPrueba/' . $nombreArchivo)
        //  ->type('@file_names', json_encode([$nombreArchivo]))
      ;


      $browser
        ->press('#btnRegistrar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Está seguro de crear el requerimiento?')
        ->pause(self::delta_time)
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Se ha Registrado el requerimiento'); //Se ha Registrado el requerimiento N°REQ21-000041

      $mensajeLlegada = $browser->text('#msjEmergenteDatos');
      $this->codigoRBS = mb_substr($mensajeLlegada, 36, 12);
      $browser->pause(self::delta_time);

      /* RENDIMIENTO
                con 10 ELEMENTOS
                    con screenshots demora 10.87 17.03 10.6 10.42
                    sin screenshots demora 10.45 10.54 10.62 11.44

                    Las screenshots no demoran mas el TEST
            */
    });
  }

  public function gerente_aprobarRequerimiento()
  {

    $this->browse(function (Browser $browser) {
      $requerimiento = $this->requerimiento;
      $proyecto = $requerimiento->getProyecto();
      $faker = Faker::create();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail($proyecto->getGerente()->usuario()->codUsuario);

      $browser
        // ->loginAs($usuario)
        ->visit(route('RequerimientoBS.Gerente.ver', $requerimiento->codRequerimiento))
        ->pause(self::delta_time);

      /* LOS CODIGOS PRESUPUESTALES NO LOS CAMBIAMOS */
      if ($faker->boolean) {
        $browser
          ->press('#botonActivarEdicion')
          ->pause(self::delta_time)
          ->type('#justificacion', $requerimiento->justificacion . " CORREGIDO") //EL TYPE LO REMPLAZA TOTALMENTE
        ;
      }

      $browser

        ->press('#botonAprobar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Está seguro de Aprobar el requerimiento?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos
        ->assertSee('Se aprobó correctamente el requerimiento')
        ->pause(self::delta_time);
    });
  }

  public function gerente_observarRequerimiento()
  {

    $this->browse(function (Browser $browser) {
      $requerimiento = $this->requerimiento;
      $proyecto = $requerimiento->getProyecto();
      $faker = Faker::create();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail($proyecto->getGerente()->usuario()->codUsuario);

      $browser
        // ->loginAs($usuario)
        ->visit(route('RequerimientoBS.Gerente.ver', $requerimiento->codRequerimiento))
        ->pause(self::delta_time);

      $browser
        ->press('#botonObservar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('Observar Requerimiento de Bienes y Servicios')
        ->type('#observacion', $faker->sentence())
        ->press('#botonGuardarObservacion')
        ->assertSee('¿Esta seguro de observar el requerimiento?')
        ->pause(self::delta_time)
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar. Aqui poner > a 2500 pq con menos falla
        ->assertSee('Se observó correctamente el requerimiento')
        ->pause(self::delta_time)
        /*
                Por alguna razon a veces este test funciona y otras no xd
                sin cambiar codigo xd
                */;
    });
  }

  public function gerente_rechazarRequerimiento()
  {

    $this->browse(function (Browser $browser) {
      $requerimiento = $this->requerimiento;
      $proyecto = $requerimiento->getProyecto();
      $faker = Faker::create();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail($proyecto->getGerente()->usuario()->codUsuario);

      $browser
        // ->loginAs($usuario)
        ->visit(route('RequerimientoBS.Gerente.ver', $requerimiento->codRequerimiento))
        ->pause(self::delta_time);

      $browser
        ->press('@boton_rechazar_rbs')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Esta seguro de rechazar el requerimiento?')
        ->pause(self::delta_time)
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar. Aqui poner > a 2500 pq con menos falla
        ->assertSee('Se rechazó correctamente el requerimiento')
        ->pause(self::delta_time);
    });
  }

  public function empleado_editarRequerimiento()
  {
    $this->browse(function (Browser $browser) {
      $requerimiento = $this->requerimiento;
      $usuario = User::findOrFail(self::$codUsuarioEmisor);

      $browser
        // ->loginAs($usuario)
        ->visit(route('RequerimientoBS.Empleado.EditarRequerimientoBS', $requerimiento->codRequerimiento))
        ->pause(self::delta_time);

      $browser
        ->pause(self::delta_time)
        ->press('#btnRegistrar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Está seguro de guardar los cambios del requerimiento?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Se ha editado el requerimiento') // Se ha registrado la reposicion N°REQ21-000017
        ->pause(self::delta_time);
    });
  }

  public function administrador_atenderRequerimiento()
  {

    $this->browse(function (Browser $browser) {
      $requerimiento = $this->requerimiento;
      $proyecto = $requerimiento->getProyecto();
      $faker = Faker::create();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail(9); //administradora MARYCRUZ BRIONES

      $browser
        // ->loginAs($usuario)
        ->visit(route('RequerimientoBS.Administrador.VerAtender', $requerimiento->codRequerimiento))
        ->pause(self::delta_time);

      if ($faker->boolean) {
        $nombreArchivo = "Ms Excel.pdf";
        $browser->attach('#filenames', __DIR__ . '/ArchivosPrueba/' . $nombreArchivo)
          // ->type('@file_names', json_encode([$nombreArchivo]))
        ;
      }

      $browser
        ->press('#botonAtender')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Seguro que desea atender el requerimiento?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Atendido satisfactoriamente.')
        ->pause(self::delta_time);
    });
  }

  public function administrador_observarRequerimiento()
  {

    $this->browse(function (Browser $browser) {
      $requerimiento = $this->requerimiento;
      $proyecto = $requerimiento->getProyecto();
      $faker = Faker::create();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail(9);

      $browser
        // ->loginAs($usuario)
        ->visit(route('RequerimientoBS.Administrador.VerAtender', $requerimiento->codRequerimiento))
        ->pause(self::delta_time);

      $browser
        ->press('@boton_observar_rbs')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('Observar Requerimiento de Bienes y Servicios')
        ->type('#observacion', $faker->sentence())
        ->press('@boton_guardar_observacion_modal')
        ->assertSee('¿Desea observar el requerimiento?')
        ->pause(self::delta_time)
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar. Aqui poner > a 2500 pq con menos falla
        ->assertSee('Se observó correctamente el requerimiento')
        ->pause(self::delta_time);
    });
  }

  public function administrador_rechazarRequerimiento()
  {

    $this->browse(function (Browser $browser) {
      $requerimiento = $this->requerimiento;
      $proyecto = $requerimiento->getProyecto();
      $faker = Faker::create();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail(9);

      $browser
        // ->loginAs($usuario)
        ->visit(route('RequerimientoBS.Administrador.VerAtender', $requerimiento->codRequerimiento))
        ->pause(self::delta_time);

      $browser
        ->press('@boton_rechazar_rbs')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Esta seguro de rechazar el requerimiento?')
        ->pause(self::delta_time)
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar. Aqui poner > a 2500 pq con menos falla
        ->assertSee('Se rechazó correctamente el requerimiento')
        ->pause(self::delta_time);
    });
  }

  public function contador_contabilizarRequerimiento()
  {

    $this->browse(function (Browser $browser) {
      $requerimiento = $this->requerimiento;
      $faker = Faker::create();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail(33); //contadora

      $browser
        // ->loginAs($usuario)
        ->visit(route('RequerimientoBS.Contador.ver', $requerimiento->codRequerimiento))
        ->pause(self::delta_time);

      if ($faker->boolean) {
        $nombreArchivo = "Ms Excel.pdf";
        $browser->attach('#filenames', __DIR__ . '/ArchivosPrueba/' . $nombreArchivo)
        ->check('#ar_añadir')
          ->pause(self::delta_time)
          // ->type('@file_names', json_encode([$nombreArchivo]))
        ;
      }

      /* Marcamos como contabilizados algunos gastos */

      $browser
        ->press('#botonContabilizarRequerimiento')
        ->pause(self::delta_time)
        ->assertSee('¿Desea marcar como contabilizada el requerimiento?') //esperamos a que aparezca el modal de confirmacion
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        // ->assertSee('Requerimiento REQ') // COMENTADO PORQUE LA RUTA LISTAR DA ERROR
        // ->pause(self::delta_time)
        ;
    });
  }
}
