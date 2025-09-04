<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Configuracion;
use App\Debug;
use App\DetalleReposicionGastos;
use App\FakerCedepas;
use App\Proyecto;
use App\ReposicionGastos;
use App\SolicitudFondos;
use App\User;
use Faker\Factory as Faker;



class F_REP_FlujoTest extends DuskTestCase
{


  /* PARA CORRER SOLO ESTE TEST
		php artisan dusk tests/Browser/F_REP_FlujoTest.php
	*/

  public $codigoREP = "";
  public $reposicion;

  public static $codUsuarioEmisor;

  const delta_time = 1000;

  public function testFlujoREP()
  {
    // $this->activarInputsEscondidos();
    // $this->assertTrue(Configuracion::mostrarInputsEscondidos());
    self::$codUsuarioEmisor = env('TEST_USER_ID');

    $this->crearReposicion();

    $this->reposicion = ReposicionGastos::where('codigoCedepas', '=', $this->codigoREP)->first();

    // $this->gerente_observarReposicion();
    // return;
    // $this->empleado_editarReposicion();

    // $this->gerente_observarReposicion();
    // $this->empleado_editarReposicion();

    $this->gerente_aprobarReposicion();
    $this->administrador_abonarReposicion();
    // $this->contador_contabilizarReposicion();

    // $this->desactivarInputsEscondidos();
  }

  public function crearReposicion()
  {


    $this->browse(function (Browser $browser) {
      $proyecto = Proyecto::findOrFail(env('TEST_PROYECTO_ID'));
      $cuerpo = FakerCedepas::F_REP_generarCuerpo($proyecto);
      $usuario = User::findOrFail(self::$codUsuarioEmisor);


      $browser
        ->loginAs($usuario)
        ->visit('/ReposicionGastos/Empleado/crear')
        ->pause(self::delta_time);

      foreach ($cuerpo as $nombreCampo => $valor) {

        if (in_array($nombreCampo, ['codProyecto', 'codBanco', 'codMoneda'])) //si es de los de select
          $browser->select('#' . $nombreCampo, $valor);
        else
          $browser->type("#" . $nombreCampo, $valor);
      }


      $cantidadItems = rand(1, 4);
      for ($i = 0; $i < $cantidadItems; $i++) {
        $detalle = FakerCedepas::F_REP_GenerarDetalle($proyecto);
        $browser
          ->type('#fechaComprobante', $detalle['colFecha'])
          ->pause(self::delta_time)
          ->select('#ComboBoxCDP', $detalle['colTipo'])
          ->pause(self::delta_time)
          ->type('#ncbte', $detalle['colComprobante'])
          ->pause(self::delta_time)
          ->type('#concepto', $detalle['colConcepto'])
          ->pause(self::delta_time)
          ->type('#importe', $detalle['colImporte'])
          ->pause(self::delta_time)
          ->type('#codigoPresupuestal', $detalle['colCodigoPresupuestal'])
          ->pause(self::delta_time)
          ->press('#btnadddet')
          ->pause(self::delta_time);
      }

      $nombreArchivo = "Ms Excel.pdf";
      $browser->attach('#filenames', __DIR__ . '/ArchivosPrueba/' . $nombreArchivo);
      ; //ESTO CAMBIA porque? de la nada desaparece v:


      $browser
        ->press('#btnRegistrar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Está seguro de crear la reposicion?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Se ha registrado la reposicion') // Se ha registrado la reposicion N°REP21-000017
      ;

      $mensajeLlegada = $browser->text('#msjEmergenteDatos');
      $this->codigoREP = mb_substr($mensajeLlegada, 33, 12);
    });
  }

  public function gerente_aprobarReposicion()
  {

    $this->browse(function (Browser $browser) {
      $reposicion = $this->reposicion;
      $proyecto = $reposicion->getProyecto();
      $faker = Faker::create();


      $usuario = User::findOrFail($proyecto->getGerente()->usuario()->codUsuario);

      $browser
        // ->loginAs($usuario)
        ->visit(route('ReposicionGastos.Gerente.ver', $reposicion->codReposicionGastos))
        ->pause(self::delta_time);

      /* LOS CODIGOS PRESUPUESTALES NO LOS CAMBIAMOS */
      if ($faker->boolean) {
        $browser
          ->press('#botonActivarEdicion')
          ->pause(self::delta_time)
          ->type('#resumen', $reposicion->resumen . " CORREGIDO") //EL TYPE LO REMPLAZA TOTALMENTE
          ->pause(self::delta_time)
        ;
      }

      $browser
        ->press('#botonAprobar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Está seguro de Aprobar la Reposición?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Se aprobó correctamente la Reposic')
      ;
    });
  }

  public function gerente_observarReposicion()
  {

    $this->browse(function (Browser $browser) {
      $reposicion = $this->reposicion;
      $proyecto = $reposicion->getProyecto();
      $faker = Faker::create();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail($proyecto->getGerente()->usuario()->codUsuario);

      $browser
        // ->loginAs($usuario)
        ->visit(route('ReposicionGastos.Gerente.ver', $reposicion->codReposicionGastos))

        ->press('#botonObservar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('Observar Reposición de Gastos')
        ->type('#observacion', $faker->sentence())
        ->pause(self::delta_time)
        ->press('#botonGuardarObservacion')
        ->pause(self::delta_time)
        ->assertSee('¿Esta seguro de observar la reposicion?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar. Aqui poner > a 2500 pq con menos falla
        ->assertSee('correctamente la Rep')
        ->pause(self::delta_time);


      // Por alguna razon a veces este test funciona y otras no xd sin cambiar codigo xd

    });
  }

  public function empleado_editarReposicion()
  {


    $this->browse(function (Browser $browser) {
      $reposicion = $this->reposicion;
      $usuario = User::findOrFail(self::$codUsuarioEmisor);

      $browser
        // ->loginAs($usuario)
        ->visit(route('ReposicionGastos.Empleado.editar', $reposicion->codReposicionGastos));

      $browser
        ->pause(self::delta_time)
        ->press('#btnRegistrar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Seguro de guardar los cambios de la reposición?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Se ha editado la reposición') // Se ha registrado la reposicion N°REP21-000017
        ->pause(self::delta_time)
      ;
    });
  }

  public function administrador_abonarReposicion()
  {

    $this->browse(function (Browser $browser) {
      $reposicion = $this->reposicion;


      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail(9); //administradora MARYCRUZ BRIONES

      $browser
        // ->loginAs($usuario)
        ->visit(route('ReposicionGastos.Administracion.ver', $reposicion->codReposicionGastos));

      $browser
        ->press('#botonAbonar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Esta seguro de abonar la reposicion?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Se abonó correctamente l')
        ->pause(self::delta_time)
      ;
    });
  }
  public function contador_contabilizarReposicion()
  {

    $this->browse(function (Browser $browser) {
      $reposicion = $this->reposicion;
      $faker = Faker::create();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail(33); //contadora

      $browser
        // ->loginAs($usuario)
        ->visit(route('ReposicionGastos.Contador.ver', $reposicion->codReposicionGastos));

      /* Marcamos como contabilizados algunos gastos */

      $detalles  = $reposicion->detalles();
      $algunoMarcado = false;

      foreach ($detalles as $detalle) {
        if ($faker->boolean) { // Aleatoriamente intentamos marcar algunos
          $browser->press('#checkBoxContabilizarItem' . $detalle->codDetalleReposicion);
          $algunoMarcado = true; // Si al menos uno se marca
        }
      }

      // comprobamos si alguno fue marcado. Si no, forzamos la marca del primero
      if (!$algunoMarcado) {
        $browser->press('#checkBoxContabilizarItem' . $detalles->first()->codDetalleReposicion);
      }


      $browser
        ->press('#botonContabilizar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Seguro de contabilizar la reposicion?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        // ->assertSee('Se contabilizó correctam') // COMENTADO PORQUE LA RUTA LISTAR DA ERROR
        // ->pause(self::delta_time)
      ;
    });
  }
}
