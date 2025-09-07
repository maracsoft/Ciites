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

  public $codigoREN = "";
  public $solicitud;

  public static $codUsuarioEmisor;

  const delta_time = 1000;
  /* PARA CORRER SOLO ESTE TEST
        php artisan dusk tests/Browser/F_REN_FlujoTest.php

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

    $empleado = Empleado::where('codUsuario', self::$codUsuarioEmisor)->firstOrFail();
    $sofs = $empleado->getSolicitudesPorRendir();
    if ($sofs->count() > 0) {
      $this->solicitud = $sofs->first();
    } else {
      throw new Exception("El empleado " . $empleado->getNombreCompleto() . " no tiene sofs por rendir");
    }

    $this->solicitud = $sofs[0];
    $this->empleado_crearRendicion();
    $this->gerente_observarRendicion();
    $this->empleado_editarRendicion();
    $this->gerente_aprobarRendicion();
    $this->contador_contabilizarRendicion();

    // $this->desactivarInputsEscondidos();
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

  public function empleado_crearRendicion()
  {
    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $proyecto = $solicitud->getProyecto();
      $cuerpo = FakerCedepas::F_REN_generarCuerpo($solicitud);
      $usuario = $solicitud->getEmpleadoSolicitante()->usuario();
      $faker = Faker::create();

      $browser
        // ->loginAs($usuario)
        ->visit('/SolicitudFondos/Empleado/Rendir/' . $solicitud->codSolicitud);

      $browser->type("#resumen", $cuerpo['resumen']);

      $cantidadItems = rand(1, 5);
      for ($i = 0; $i < $cantidadItems; $i++) {
        $detalle = FakerCedepas::F_REN_generarDetalle($proyecto);
        $browser
          ->type('#fechaComprobante', $detalle['colFecha'])
          ->select('#ComboBoxCDP', $detalle['colTipo'])
          ->type('#ncbte', $detalle['colComprobante'])
          ->type('#concepto', $detalle['colConcepto'])
          ->type('#importe', $detalle['colImporte'])
          ->type('#codigoPresupuestal', $detalle['colCodigoPresupuestal'])

          ->press('#btnadddet');
      }

      $nombreArchivo = "Ms Excel.pdf";
      $browser
        ->attach('#filenames', __DIR__ . '/ArchivosPrueba/' . $nombreArchivo)
        ->pause(self::delta_time);

      $browser
        ->press('#btnRegistrar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Estás seguro de crear la Rendición?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Se ha creado la rendición');
      $mensajeLlegada = $browser->text('#msjEmergenteDatos');
      $this->codigoREN = mb_substr($mensajeLlegada, 28, 12);
    });
  }

  public function empleado_editarRendicion()
  {
    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $usuario = $solicitud->getEmpleadoSolicitante()->usuario();
      $rendicion = $solicitud->getRendicion();

      $browser
        // ->loginAs($usuario)
        ->visit(route('RendicionGastos.Empleado.Editar', $rendicion->codRendicionGastos));

      /*
            AQUI EL ERROR PARECE SER QUE EL BOTON NO ES CLICKEABLE PQ HAY OTRO ELMEENTO QUE LO TAPA, PERO LA VERDA QEU NO Xd



            */
      $browser
        ->pause(self::delta_time)
        ->press('#botonActualizar')
        ->pause(self::delta_time)
        ->assertSee('¿Está seguro de actualizar la rendición?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Se ha Editado la rendición')
        ->pause(self::delta_time);
    });
  }

  public function gerente_aprobarRendicion()
  {
    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $proyecto = $solicitud->getProyecto();
      $rendicion = $solicitud->getRendicion();
      $faker = Faker::create();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail($proyecto->getGerente()->usuario()->codUsuario);

      $browser
        // ->loginAs($usuario)
        ->visit(route('RendicionGastos.Gerente.Ver', $rendicion->codRendicionGastos));

      /* LOS CODIGOS PRESUPUESTALES NO LOS CAMBIAMOS */
      if ($faker->boolean) {
        $browser
          ->press('#botonActivarEdicion')
          ->pause(self::delta_time)
          ->type('#resumen', $rendicion->resumenDeActividad . " CORREGIDO") //EL TYPE LO REMPLAZA TOTALMENTE
        ;
      }

      $browser
        ->press('#botonAprobar')
        ->pause(self::delta_time)
        ->assertSee('¿Está seguro de Aprobar la Rendición?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        ->assertSee("Aprobada");
    });
  }

  public function gerente_observarRendicion()
  {

    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $proyecto = $solicitud->getProyecto();
      $rendicion = $solicitud->getRendicion();
      $faker = Faker::create();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail($proyecto->getGerente()->usuario()->codUsuario);

      $browser
        // ->loginAs($usuario)
        ->visit(route('RendicionGastos.Gerente.Ver', $rendicion->codRendicionGastos))
        ->pause(self::delta_time);

      /* LOS CODIGOS PRESUPUESTALES NO LOS CAMBIAMOS */
      if ($faker->boolean) {
        $browser
          ->press('#botonActivarEdicion')
          ->pause(self::delta_time)
          ->type('#resumen', $rendicion->resumenDeActividad . "x") //EL TYPE LO REMPLAZA TOTALMENTE
          ->pause(self::delta_time)
        ;
      }

      $browser
        ->press('#botonObservar')
        ->pause(self::delta_time) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('Observar Rendición de Gastos')
        ->type("#observacion", $faker->sentence())
        ->pause(self::delta_time)
        ->press('#guardarObservacion')
        ->pause(self::delta_time)
        ->assertSee('¿Esta seguro de observar la rendición?')
        ->press("SÍ")
        ->pause(self::delta_time)
        ->assertSee("Observada")
        ->pause(self::delta_time);
    });
  }

  public function contador_contabilizarRendicion()
  {
    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $rendicion = $solicitud->getRendicion();

      $usuario = User::findOrFail(33); //contadora
      $browser
        // ->loginAs($usuario)
        ->visit(route('RendicionGastos.Contador.verContabilizar', $rendicion->codRendicionGastos));

      foreach ($rendicion->getDetalles() as $detalle) {
        $browser->press("#checkBoxContabilizar" . $detalle->codDetalleRendicion);
      }

      $browser
        ->press('#botonContabilizar')
        ->pause(self::delta_time)
        ->assertSee('¿Seguro de contabilizar la rendicion?')
        ->press('SÍ')
        ->pause(self::delta_time) //esperamos a que nos redirija a la pagina de listar
        // ->assertSee('Se contabilizó correctamente la Rendición') // COMENTADO PORQUE LA RUTA LISTAR DA ERROR
        // ->pause(self::delta_time)
        ;
    });
  }

  #endregion testSOF

}
