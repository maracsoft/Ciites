<?php

namespace Tests\Browser;

use App\Proyecto;
use App\SolicitudFondos;
use App\User;
use App\Utils\Configuracion;
use App\Utils\Debug;
use App\Utils\FakerCedepas;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/* Frontend Solicitud fondos test */

class F_SOF_FlujoTest extends DuskTestCase
{

  public $codigoPresupuestal = "";
  public $solicitud;

  const codUsuarioEmisor = 9;
  const codUsuarioAdministrador = 9;
  const codUsuarioContador = 9;
  const DeltaTime = 300;

  /* PARA CORRER SOLO ESTE TEST
        php artisan dusk tests/Browser/F_SOF_FlujoTest.php

    */
  public function atestLogin()
  {
    $this->browse(function (Browser $browser) {
      $browser = $browser
        ->visit('/login')
        ->type('usuario', 'admin')
        ->type('password', env('ADMIN_PASSWORD'))
        ->press('ingresar')
        ->pause(static::DeltaTime)
        ->assertSee('Solicitud de Fondos');
    });
  }

  #region TestSOF
  public function testFlujoSOF()
  {
    //Debug::mensajeSimple('EL DIR ES:'.__DIR__);

    // las variables que almacenemos aqui como $this->algo solo guardan ese valor dentro de este test
    /* PARA QUE LOS TESTS FUNCIONEN, DEBEMOS PONER EL Configuracion::mostrarInputsEscondidos en true */
    $this->assertTrue(Configuracion::mostrarInputsEscondidos());

    $this->crearSolicitud();
    Debug::mensajeSimple("El cod presupuestal es: '" . $this->codigoPresupuestal . "'");
    $this->solicitud = SolicitudFondos::where('codigoCedepas', '=', $this->codigoPresupuestal)->first();

    //$this->editarSolicitud();
    $this->aprobarSolicitud();
    $this->abonarSolicitud();
    //$this->contabilizarSolicitud();
    Debug::mensajeSimple("Se terminó el flujo de Solicitud.");
    $this->crearRendicion();
    /*
    $this->gerente_observarRendicion();
    $this->emp_editarRend();
    */
    $this->aprobarRendicion();
    $this->contabilizarRendicion();
    Debug::mensajeSimple("Se terminó el flujo de Solicitud y Rendición");
  }

  public function crearSolicitud()
  {

    $this->browse(function (Browser $browser) {
      $proyecto = Proyecto::findOrFail(64);
      $cuerpo = FakerCedepas::F_SOL_generarCuerpo($proyecto);
      $usuario = User::findOrFail(static::codUsuarioEmisor);


      $browser = $browser
        ->loginAs($usuario)
        ->visit('/SolicitudFondos/Empleado/Crear');
      foreach ($cuerpo as $nombreCampo => $valor) {
        Debug::mensajeSimple($nombreCampo . "=" . $valor);
        if (in_array($nombreCampo, ['ComboBoxProyecto', 'ComboBoxMoneda', 'ComboBoxBanco']))
          $browser = $browser->select('#' . $nombreCampo, $valor);
        else
          $browser = $browser->type("#" . $nombreCampo, $valor);
      }

      $cantidadItems = 10;
      for ($i = 0; $i < $cantidadItems; $i++) {
        $detalle = FakerCedepas::F_SOL_GenerarDetalle($proyecto);
        $browser = $browser
          ->type('#concepto', $detalle['concepto'])
          ->type('#importe', $detalle['importe'])
          ->type('#codigoPresupuestal', $detalle['codigoPresupuestal'])
          ->press('#btnadddet')
          ->pause(static::DeltaTime);
      }

      $browser = $browser

        ->press('#btnRegistrar')
        ->pause(static::DeltaTime) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Seguro de crear la solicitud?')
        ->press('SÍ')
        ->pause(static::DeltaTime) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Se ha creado');
      $mensajeLlegada = $browser->text('#msjEmergenteDatos');
      //Debug::mensajeSimple($mensajeLlegada);
      $this->codigoPresupuestal = mb_substr($mensajeLlegada, 26, 12);

      /* RENDIMIENTO
                con 10 ELEMENTOS
                    con screenshots demora 10.87 17.03 10.6 10.42
                    sin screenshots demora 10.45 10.54 10.62 11.44

                    Las screenshots no demoran mas el TEST
            */
    });
  }


  public function editarSolicitud()
  {

    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $proyecto = $solicitud->getProyecto();
      $cuerpo = FakerCedepas::F_SOL_generarCuerpo($proyecto);
      $usuario = User::findOrFail($solicitud->getEmpleadoSolicitante()->usuario()->codUsuario);


      $browser = $browser
        ->loginAs($usuario)
        ->visit(route('SolicitudFondos.Empleado.Edit', $solicitud->codSolicitud));

      foreach ($cuerpo as $nombreCampo => $valor) {
        Debug::mensajeSimple($nombreCampo . "=" . $valor);
        if (in_array($nombreCampo, ['ComboBoxProyecto', 'ComboBoxMoneda', 'ComboBoxBanco']))
          $browser = $browser->select('#' . $nombreCampo, $valor);
        else
          $browser = $browser->type("#" . $nombreCampo, $valor);
      }

      //esta es la cantidad de items que se aÃ±adirÃ¡n
      $cantidadItems = 10;
      for ($i = 0; $i < $cantidadItems; $i++) {
        $detalle = FakerCedepas::F_SOL_GenerarDetalle($proyecto);
        $browser = $browser
          ->type('#concepto', $detalle['concepto'])
          ->type('#importe', $detalle['importe'])
          ->type('#codigoPresupuestal', $detalle['codigoPresupuestal'])
          ->press('#btnadddet')
          ->pause(static::DeltaTime);
      }

      $browser = $browser

        ->press('#btnRegistrar')
        ->pause(static::DeltaTime) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Seguro de actualizar la solicitud?')
        ->press('SÍ')
        ->pause(static::DeltaTime) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('actualizado');
    });
  }

  public function aprobarSolicitud()
  {

    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $proyecto = $solicitud->getProyecto();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail($solicitud->getProyecto()->getGerente()->usuario()->codUsuario);

      $browser = $browser
        ->loginAs($usuario)
        ->visit(route('SolicitudFondos.Gerente.Revisar', $solicitud->codSolicitud));

      /* LOS CODIGOS PRESUPUESTALES NO LOS CAMBIAMOS */
      $browser = $browser
        ->press('#botonActivarEdicion')
        ->pause(static::DeltaTime)
        ->type('#justificacion', $solicitud->justificacion . " CORREGIDO") //EL TYPE LO REMPLAZA TOTALMENTE

      ;

      $browser = $browser

        ->press('#botonAprobar')
        ->pause(static::DeltaTime) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Está seguro de Aprobar la Solicitud?')

        ->press('SÍ')
        ->pause(static::DeltaTime) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Aprobada');
    });
  }

  public function abonarSolicitud()
  {

    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $proyecto = $solicitud->getProyecto();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail(self::codUsuarioAdministrador); //administradora MARYCRUZ BRIONES

      $browser = $browser
        ->loginAs($usuario)
        ->visit(route('SolicitudFondos.Administracion.verAbonar', $solicitud->codSolicitud));

      $browser = $browser

        ->press('#botonAbonar')
        ->pause(static::DeltaTime) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Está seguro de marcar como abonada la solicitud?')
        ->press('SÍ')
        ->pause(static::DeltaTime) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Abonada');
    });
  }



  public function contabilizarSolicitud()
  {

    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $proyecto = $solicitud->getProyecto();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail(self::codUsuarioContador); //contadora

      $browser = $browser
        ->loginAs($usuario)
        ->visit(route('SolicitudFondos.Contador.verContabilizar', $solicitud->codSolicitud));
      $browser = $browser

        ->press('#botonContabilizar')
        ->pause(static::DeltaTime) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Desea marcar como contabilizada la solicitud?')
        ->press('SÍ')
        ->pause(static::DeltaTime) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Contabilizada');
    });
  }


  public function crearRendicion()
  {


    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $proyecto = $solicitud->getProyecto();
      $cuerpo = FakerCedepas::F_REN_generarCuerpo($solicitud);
      $usuario = $solicitud->getEmpleadoSolicitante()->usuario();


      $browser = $browser
        ->loginAs($usuario)
        ->visit(route('SolicitudFondos.Empleado.Rendir', $solicitud->codSolicitud));

      $browser = $browser->type("#resumen", $cuerpo['resumen']);

      $cantidadItems = 4;
      for ($i = 0; $i < $cantidadItems; $i++) {
        $detalle = FakerCedepas::F_REN_generarDetalle($proyecto);
        $browser = $browser
          ->type('#fechaComprobante', $detalle['colFecha'])
          ->select('#ComboBoxCDP', $detalle['colTipo'])
          ->type('#ncbte', $detalle['colComprobante'])
          ->type('#concepto', $detalle['colConcepto'])
          ->type('#importe', $detalle['colImporte'])
          ->type('#codigoPresupuestal', $detalle['colCodigoPresupuestal'])
          ->press('#btnadddet')
          ->pause(static::DeltaTime);
      }
      /* FALTARIA SUBIR LOS ARCHIVOS AQUI */
      $nombreArchivo = "Ms Excel.pdf";
      $browser = $browser
        ->attach('#filenames', __DIR__ . '/ArchivosPrueba/' . $nombreArchivo)
        ->type('#nombresArchivos', json_encode([$nombreArchivo]));



      //Debug::mensajeSimple('EL DIR ES:'.__DIR__);
      /* PARA QUE FUNCIONE EL TEST, EL Configuracion::mostrarInputsEscondidos debe estar en TRUE */
      //__DIR__ = C:\xampp\htdocs\Cedepas\tests\Browser

      $browser = $browser
        ->press('#btnRegistrar')
        ->pause(static::DeltaTime) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Estás seguro de crear la Rendición?')
        ->press('SÍ')
        ->pause(static::DeltaTime) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Se ha creado la');
      $mensajeLlegada = $browser->text('#msjEmergenteDatos');
      //Debug::mensajeSimple($mensajeLlegada);
      $this->codigoPresupuestal = mb_substr($mensajeLlegada, 26, 12);
      Debug::mensajeSimple($mensajeLlegada);
      /* RENDIMIENTO
                con 10 ELEMENTOS
                    con screenshots demora 10.87 17.03 10.6 10.42
                    sin screenshots demora 10.45 10.54 10.62 11.44

                    Las screenshots no demoran mas el TEST
            */
    });
  }


  public function aprobarRendicion()
  {


    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $proyecto = $solicitud->getProyecto();
      $rendicion = $solicitud->getRendicion();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail($proyecto->getGerente()->usuario()->codUsuario);

      $browser = $browser
        ->loginAs($usuario)
        ->visit(route('RendicionGastos.Gerente.Ver', $rendicion->codRendicionGastos));

      /* LOS CODIGOS PRESUPUESTALES NO LOS CAMBIAMOS */
      $browser = $browser
        ->press('#botonActivarEdicion')
        ->pause(static::DeltaTime)
        ->type('#resumen', $rendicion->resumen . " CORREGIDO") //EL TYPE LO REMPLAZA TOTALMENTE
      ;

      $browser = $browser

        ->press('#botonAprobar')
        ->pause(static::DeltaTime) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Está seguro de Aprobar la Rendición?')
        ->press('SÍ')
        ->pause(static::DeltaTime) //esperamos a que nos redirija a la pagina de listar
        ->assertSee($rendicion->codigoCedepas . " Aprobada");
    });
  }


  public function contabilizarRendicion()
  {


    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $rendicion = $solicitud->getRendicion();
      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);
      $usuario = User::findOrFail(self::codUsuarioContador); //contadora
      $browser = $browser
        ->loginAs($usuario)
        ->visit(route('RendicionGastos.Contador.verContabilizar', $rendicion->codRendicionGastos));

      foreach ($rendicion->getDetalles() as $detalle) {
        $browser = $browser->press("#checkBoxContabilizar" . $detalle->codDetalleRendicion)
          ->pause(static::DeltaTime);
      }

      $browser = $browser
        ->press('#botonContabilizar')
        ->pause(static::DeltaTime) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Seguro de contabilizar la rendicion?')
        ->press('SÍ')
        ->pause(static::DeltaTime) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Se contabilizó correctamente la Rendición');
    });
  }

  public function gerente_observarRendicion()
  {

    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $proyecto = $solicitud->getProyecto();
      $rendicion = $solicitud->getRendicion();

      //$cuerpo = FakerCedepas::F_SOL_generarCuerpoAprobacion($proyecto);

      $usuario = User::findOrFail($proyecto->getGerente()->usuario()->codUsuario);

      $browser = $browser
        ->loginAs($usuario)
        ->visit(route('RendicionGastos.Gerente.Ver', $rendicion->codRendicionGastos));

      /* LOS CODIGOS PRESUPUESTALES NO LOS CAMBIAMOS */
      $browser = $browser
        ->press('#botonActivarEdicion')
        ->pause(static::DeltaTime)
        ->type('#resumen', $rendicion->resumen . "x") //EL TYPE LO REMPLAZA TOTALMENTE
      ;

      $browser = $browser

        ->press('#botonObservar')
        ->pause(static::DeltaTime) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('Observar Rendición de Gastos')

        ->type("#observacion", "este es el texto de la observacion")
        ->press('#guardarObservacion')
        ->pause(static::DeltaTime)
        ->assertSee("Rendicion " . $rendicion->codigoCedepas . " Observada");
    });
  }

  public function emp_editarRend()
  {


    $this->browse(function (Browser $browser) {
      $solicitud = $this->solicitud;
      $usuario = $solicitud->getEmpleadoSolicitante()->usuario();
      $rendicion = $solicitud->getRendicion();

      $browser = $browser
        ->loginAs($usuario)
        ->visit(route('RendicionGastos.Empleado.Editar', $rendicion->codRendicionGastos));

      /*
            AQUI EL ERROR PARECE SER QUE EL BOTON NO ES CLICKEABLE PQ HAY OTRO ELMEENTO QUE LO TAPA, PERO LA VERDA QEU NO Xd



            */
      $browser = $browser
        ->pause(static::DeltaTime)
        ->press('#botonActualizar')
        ->pause(static::DeltaTime) //esperamos a que aparezca el modal de confirmacion
        ->assertSee('¿Está seguro de actualizar la rendición?')
        ->press('SÍ')
        ->pause(static::DeltaTime) //esperamos a que nos redirija a la pagina de listar
        ->assertSee('Se ha Editado la rendición NÂ°' . $rendicion->codigoCedepas);
    });
  }


  #endregion testSOF




}
