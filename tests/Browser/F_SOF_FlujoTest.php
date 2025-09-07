<?php

namespace Tests\Browser;

use App\Configuracion;
use App\Debug;
use App\Empleado;
use App\FakerCedepas;
use App\Proyecto;
use App\SolicitudFondos;
use App\User;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker\Factory as Faker;

/* Frontend Solicitud fondos test */

class F_SOF_FlujoTest extends DuskTestCase
{

  public $codigoSOF = "";
  public $solicitud;

  public static $codUsuarioEmisor;

  const delta_time = 1000;
  /* PARA CORRER SOLO ESTE TEST
        php artisan dusk tests/Browser/F_SOF_FlujoTest.php

    */
  public function atestLogin()
  {
    $this->browse(function (Browser $browser) {
      $browser
        ->visit('/login')
        ->type('usuario', 'admin')
        ->type('password', env('ADMIN_PASSWORD'))
        ->press('ingresar')
        ->assertSee('Solicitud de Fondos');
    });
  }

  #region TestSOF
  public function testFlujoSOF()
  {
    //Debug::LogMessage('EL DIR ES:'.__DIR__);
    // $this->activarInputsEscondidos();

    // las variables que almacenemos aqui como $this->algo solo guardan ese valor dentro de este test

    // $this->assertTrue(Configuracion::mostrarInputsEscondidos());

    self::$codUsuarioEmisor = env('TEST_USER_ID');
    $this->login();

    for ($i = 0; $i < 1; $i++) {

      $this->empleado_crearSolicitud();
      //Debug::LogMessage("El cod presupuestal es: '" . $this->codigoSOF . "'");
      $this->solicitud = SolicitudFondos::where('codigoCedepas', '=', $this->codigoSOF)->first();

      //$this->empleado_editarSolicitud();
      $this->gerente_aprobarSolicitud();
      $this->administrador_abonarSolicitud();
      $this->contador_contabilizarSolicitud();
    }

    Debug::LogMessage("Se terminó el flujo de Solicitud.");
  }

  public function login()
  {
    $this->browse(function (Browser $browser) {
      $usuario = User::findOrFail(self::$codUsuarioEmisor);

      $browser
        ->loginAs($usuario);
      // ->visit('/SolicitudFondos/Empleado/Crear');
    });
  }

  public function empleado_crearSolicitud()
  {

    $this->browse(function (Browser $browser) {
      $proyecto = Proyecto::findOrFail(env('TEST_PROYECTO_ID'));
      $cuerpo = FakerCedepas::F_SOL_generarCuerpo($proyecto);
      // $usuario = User::findOrFail(self::$codUsuarioEmisor);
      $faker = Faker::create();

      $browser
        // ->loginAs($usuario)
        ->visit('/SolicitudFondos/Empleado/Crear');
      foreach ($cuerpo as $nombreCampo => $valor) {
        Debug::LogMessage($nombreCampo . "=" . $valor);
        if (in_array($nombreCampo, ['ComboBoxProyecto', 'ComboBoxMoneda', 'ComboBoxBanco']))
          $browser->select('#' . $nombreCampo, $valor);
        else
          $browser->type("#" . $nombreCampo, $valor);
      }

      $cantidadItems = rand(1, 5);
      for ($i = 0; $i < $cantidadItems; $i++) {
        $detalle = FakerCedepas::F_SOL_GenerarDetalle($proyecto);
        $browser
          ->type('#concepto', $detalle['concepto'])
          ->type('#importe', $detalle['importe'])
          ->type('#codigoPresupuestal', $detalle['codigoPresupuestal'])
          ->press('#btnadddet');
      }

      if ($faker->boolean) {
        $nombreArchivo = "Ms Excel.pdf";
        $browser->attach('#filenames', __DIR__ . '/ArchivosPrueba/' . $nombreArchivo);
        //$browser->type('@file_names', json_encode([$nombreArchivo])); //ESTO CAMBIA 
      }

      $browser
        ->press('#btnRegistrar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Seguro de crear la solicitud?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Se ha creado la solicitud');

      $mensajeLlegada = $browser->text('#msjEmergenteDatos');
      $this->codigoSOF = mb_substr($mensajeLlegada, 26, 12);
    });
  }


  public function empleado_editarSolicitud()
  {
    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $proyecto = $solicitud->getProyecto();
      $cuerpo = FakerCedepas::F_SOL_generarCuerpo($proyecto);
      $usuario = User::findOrFail($solicitud->getEmpleadoSolicitante()->usuario()->codUsuario);


      $browser
        // ->loginAs($usuario)
        ->visit(route('SolicitudFondos.Empleado.Edit', $solicitud->codSolicitud));

      foreach ($cuerpo as $nombreCampo => $valor) {
        Debug::LogMessage($nombreCampo . "=" . $valor);
        if (in_array($nombreCampo, ['ComboBoxProyecto', 'ComboBoxMoneda', 'ComboBoxBanco']))
          $browser->select('#' . $nombreCampo, $valor);
        else
          $browser->type("#" . $nombreCampo, $valor);
      }

      //esta es la cantidad de items que se añadirán
      $cantidadItems = rand(1, 5);
      for ($i = 0; $i < $cantidadItems; $i++) {
        $detalle = FakerCedepas::F_SOL_GenerarDetalle($proyecto);
        $browser
          ->type('#concepto', $detalle['concepto'])
          ->type('#importe', $detalle['importe'])
          ->type('#codigoPresupuestal', $detalle['codigoPresupuestal'])
          ->press('#btnadddet');
      }

      $browser

        ->press('#btnRegistrar')
        ->assertSee('¿Seguro de actualizar la solicitud?')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion

        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('actualizado')
        ->pause(self::delta_time);
    });
  }

  public function gerente_aprobarSolicitud()
  {

    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;


      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail($solicitud->getProyecto()->getGerente()->usuario()->codUsuario);

      $browser
        // ->loginAs($usuario)
        ->visit(route('SolicitudFondos.Gerente.Revisar', $solicitud->codSolicitud));

      /* LOS CODIGOS PRESUPUESTALES NO LOS CAMBIAMOS */
      $browser
        ->press('#botonActivarEdicion')
        ->pause(self::delta_time)
        ->type('#justificacion', $solicitud->justificacion . " CORREGIDO") //EL TYPE LO REMPLAZA TOTALMENTE
        ->pause(self::delta_time);

      $browser

        ->press('#botonAprobar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Está seguro de Aprobar la Solicitud?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Aprobada')
        ->pause(self::delta_time);
    });
  }

  public function administrador_abonarSolicitud()
  {

    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $proyecto = $solicitud->getProyecto();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail(9); //administradora MARYCRUZ BRIONES

      $browser
        // ->loginAs($usuario)
        ->visit(route('SolicitudFondos.Administracion.verAbonar', $solicitud->codSolicitud));

      $browser

        ->press('#botonAbonar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Está seguro de marcar como abonada la solicitud?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Abonada');
    });
  }



  public function contador_contabilizarSolicitud()
  {

    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $proyecto = $solicitud->getProyecto();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail(33); //contadora

      $browser
        // ->loginAs($usuario)
        ->visit(route('SolicitudFondos.Contador.verContabilizar', $solicitud->codSolicitud));
      $browser

        ->press('#botonContabilizar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Desea marcar como contabilizada la solicitud?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Contabilizada');
    });
  }

  #endregion testSOF

}
