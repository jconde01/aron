<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class BasicMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //$selCliente = \Cache::get('selCliente'); 
        $selCliente = Session::get('selCliente');       
        if ($selCliente == "") {
            return redirect('/sistema/chooseClienteYNomina');
        }
        return $next($request);
    }
}
