<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;



use App\DetalleReposicionGastos;

use App\Proyecto;
use App\ReposicionGastos;
use App\SolicitudFondos;
use App\User;
use App\Utils\Configuracion;
use App\Utils\Debug;
use App\Utils\FakerCedepas;

class F_REP_FlujoTest extends DuskTestCase
{


  /* PARA CORRER SOLO ESTE TEST
        php artisan dusk tests/Browser/F_REP_FlujoTest.php

    */

  public $codigoPresupuestal = "";
  public $reposicion;

  const codUsuarioEmisor = 9;
  const codUsuarioAdministrador = 9;
  const codProyecto = 64;
  const codUsuarioContador = 9;

  const DeltaTime = 300;

  public function testFlujoREP()
  {
    Debug::mensajeSimple("INICIANDO EL FLUJO DE REPOSICION");
    $this->assertTrue(Configuracion::mostrarInputsEscondidos());
    $this->crearReposicion();

    Debug::mensajeSimple("El cod presupuestal de la repo es: '" . $this->codigoPresupuestal . "'");
    $this->reposicion = ReposicionGastos::where('codigoCedepas', '=', $this->codigoPresupuestal)->first();

    $this->gerente_observarReposicion();
    $this->empleado_editarReposicion();

    $this->gerente_observarReposicion();
    $this->empleado_editarReposicion();

    $this->gerente_observarReposicion();
    $this->empleado_editarReposicion();

    $this->aprobarReposicion();
    $this->abonarReposicion();
    $this->contabilizarReposicion();

    Debug::mensajeSimple("FLUJO DE REPOSICION FINALIZADO");
  }

  public function crearReposicion()
  {


    $this->browse(function (Browser $browser) {
      $proyecto = Proyecto::findOrFail(self::codProyecto);
      $cuerpo = FakerCedepas::F_REP_generarCuerpo($proyecto);
      $usuario = User::findOrFail(static::codUsuarioEmisor);


      $browser = $browser
        ->loginAs($usuario)
        ->visit('/ReposicionGastos/Empleado/crear');

      foreach ($cuerpo as $nombreCampo => $valor) {
        Debug::mensajeSimple($nombreCampo . "=" . $valor);
        if (in_array($nombreCampo, ['codProyecto', 'codBanco', 'codMoneda'])) //si es de los de select
          $browser = $browser->select('#' . $nombreCampo, $valor);
        else
          $browser = $browser->type("#" . $nombreCampo, $valor);
      }


      $cantidadItems = 10;
      for ($i = 0; $i < $cantidadItems; $i++) {
        $detalle = FakerCedepas::F_REP_GenerarDetalle($proyecto);
        $browser = $browser
          ->type('#fechaComprobante', $detalle['colFecha'])
          ->select('#ComboBoxCDP', $detalle['colTipo'])
          ->type('#ncbte', $detalle['colComprobante'])
          ->type('#concepto', $detalle['colConcepto'])
          ->type('#importe', $detalle['colImporte'])
          ->type('#codigoPresupuestal', $detalle['colCodigoPresupuestal'])
          ->press('#btnadddet')
          ->pause(self::DeltaTime);
      }

      $nombreArchivo = "Ms Excel.pdf";
      $browser = $browser->attach('#filenames', __DIR__ . '/ArchivosPrueba/' . $nombreArchivo);
      $browser = $browser->type('#nombresArchivos', json_encode([$nombreArchivo])); //ESTO CAMBIA


      $browser = $browser
        ->press('#btnRegistrar')
        ->pause(self::DeltaTime)
        ->assertSee('¿Está seguro de crear la reposicion?')
        ->pause(self::DeltaTime)
        ->press('SÍ')
        ->pause(self::DeltaTime)
        ->assertSee('Se ha registrado la rep');



      $mensajeLlegada = $browser->text('#msjEmergenteDatos');
      //Debug::mensajeSimple($mensajeLlegada);
      $this->codigoPresupuestal = mb_substr($mensajeLlegada, 33, 12);
    });
  }

  public function aprobarReposicion()
  {

    $this->browse(function (Browser $browser) {
      $reposicion = $this->reposicion;
      $proyecto = $reposicion->getProyecto();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail($proyecto->getGerente()->usuario()->codUsuario);

      $browser = $browser
        ->loginAs($usuario)
        ->visit(route('ReposicionGastos.Gerente.ver', $reposicion->codReposicionGastos));

      /* LOS CODIGOS PRESUPUESTALES NO LOS CAMBIAMOS */
      $browser = $browser
        ->press('#botonActivarEdicion')
        ->pause(self::DeltaTime)
        ->type('#resumen', $reposicion->resumen . " CORREGIDO") //EL TYPE LO REMPLAZA TOTALMENTE
      ;

      $browser = $browser

        ->press('#botonAprobar')
        ->pause(self::DeltaTime)
        ->assertSee('¿Está seguro de Aprobar la Reposición?')
        ->press('SÍ')
        ->pause(self::DeltaTime)
        ->assertSee('Se aprobó correctamente la Reposic');
    });
  }

  public function gerente_observarReposicion()
  {

    $this->browse(function (Browser $browser) {
      $reposicion = $this->reposicion;
      $proyecto = $reposicion->getProyecto();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail($proyecto->getGerente()->usuario()->codUsuario);

      $browser = $browser
        ->loginAs($usuario)
        ->visit(route('ReposicionGastos.Gerente.ver', $reposicion->codReposicionGastos));

      $browser = $browser
        ->press('#botonObservar')
        ->pause(self::DeltaTime)
        ->assertSee('Observar Reposición de Gastos')
        ->type('#observacion', "este es el texto de la observación.")
        ->press('#botonGuardarObservacion')
        ->pause(self::DeltaTime)
        ->assertSee('¿Esta seguro de observar la reposicion?')
        ->press('SÍ')
        ->pause(self::DeltaTime)
        ->assertSee('correctamente la Rep')

        /*
                Por alguna razon a veces este test funciona y otras no xd
                sin cambiar codigo xd
                */;
    });
  }

  public function empleado_editarReposicion()
  {


    $this->browse(function (Browser $browser) {
      $reposicion = $this->reposicion;
      $usuario = User::findOrFail(static::codUsuarioEmisor);

      $browser = $browser
        ->loginAs($usuario)
        ->visit(route('ReposicionGastos.Empleado.editar', $reposicion->codReposicionGastos));

      $browser = $browser
        ->pause(self::DeltaTime)
        ->press('#btnRegistrar')
        ->pause(self::DeltaTime)
        ->assertSee('¿Seguro de guardar los cambios de la reposición?')
        ->pause(self::DeltaTime * 2)
        ->press('SÍ')
        ->pause(self::DeltaTime)
        ->assertSee('Se ha editado la reposi');
    });
  }

  public function abonarReposicion()
  {

    $this->browse(function (Browser $browser) {
      $reposicion = $this->reposicion;
      $proyecto = $reposicion->getProyecto();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail(9); //administradora MARYCRUZ BRIONES

      $browser = $browser
        ->loginAs($usuario)
        ->visit(route('ReposicionGastos.Administracion.ver', $reposicion->codReposicionGastos));

      $browser = $browser
        ->press('#botonAbonar')
        ->pause(self::DeltaTime)
        ->assertSee('¿Esta seguro de abonar la reposicion?')
        ->press('SÍ')
        ->pause(self::DeltaTime)
        ->assertSee('Se abonó correctamente l');
    });
  }
  public function contabilizarReposicion()
  {

    $this->browse(function (Browser $browser) {
      $reposicion = $this->reposicion;
      $proyecto = $reposicion->getProyecto();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail(self::codUsuarioContador); //contadora

      $browser = $browser
        ->loginAs($usuario)
        ->visit(route('ReposicionGastos.Contador.ver', $reposicion->codReposicionGastos));

      /* Marcamos como contabilizados algunos gastos */

      $detalles  = $reposicion->detalles();
      foreach ($detalles as $detalle) {
        $num = rand(0, 1); //Aleatoriamente marcamos algunos
        if ($num == 0) {
          $browser = $browser->press('#checkBoxContabilizarItem' . $detalle->codDetalleReposicion)
            ->pause(self::DeltaTime);
        }
      }


      $browser = $browser
        ->press('#botonContabilizar')
        ->pause(self::DeltaTime)
        ->assertSee('¿Seguro de contabilizar la reposicion?')
        ->press('SÍ')
        ->pause(self::DeltaTime)
        ->assertSee('Se contabilizó correctam');
    });
  }
}
