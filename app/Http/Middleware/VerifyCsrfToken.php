<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        "/PPM/Indicadores/Inv_VerTabla",
        "/PPM/Indicadores/GuardarIndicadores11",
        "/PPM/Indicadores/GuardarIndicadores12",
        "/PPM/Indicadores/GuardarIndicadores21",
        "/PPM/Indicadores/GuardarIndicadores22",
        "/PPM/Indicadores/GuardarIndicadores31",
        "/PPM/Indicadores/GuardarIndicadores32",
        "/PPM/Indicadores/DescargarReporteIndicador",
        "/PPM/Organizacion/SincronizarConCITE",
        "/PPM/Organizacion/ActualizarCargo",
        "/PPM/Indicadores/ActualizarFichaGestionEmpresarial",
        "/PPM/SemestreOrganizacion/GuardarAsistenciaDetalleProd",
        "/PPM/Actividad/GuardarAsistenciaInterna"
        
    ];
}
