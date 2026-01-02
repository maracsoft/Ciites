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

class SeeLoginTest extends DuskTestCase
{


  /* PARA CORRER SOLO ESTE TEST
		php artisan dusk tests/Browser/SeeLoginTest.php
	
    Este test es para verificar el funcionamiento de laravel dusk y su integracion con chrome web driver xd
    */


  public function test()
  {
    $this->browse(function (Browser $browser) {

      $browser = $browser
        ->visit('/login')
        ->pause(100)
        ->assertSee('USUARIO');
    });
  }
}
