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
        $cliente = auth()->user()->client;
        $database = Session::get('sqlsrv2');
        if (!$database) {
            return redirect('/sistema/chooseTipoYProceso')->with(compact('cliente'));
        }
        return $next($request);
    }
}
