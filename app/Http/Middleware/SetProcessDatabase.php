<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SetProcessDatabase
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
        // Close any connection made before to avoid conflicts
        DB::disconnect('sqlsrv2');
         // Set the connection's database to the selected database
        Config::set("database.connections.sqlsrv2", Session::get('sqlsrv2'));
        return $next($request);
    }
}
