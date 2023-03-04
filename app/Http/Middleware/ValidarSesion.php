<?php

namespace App\Http\Middleware;

use App\Debug;
use App\Empleado;
use Closure;

class ValidarSesion
{
    
    public function handle($request, Closure $next)
    {

        if(!Empleado::hayEmpleadoLogeado()){
            return redirect()->route('user.verLogin');
        }

        return $next($request);
    }
}
