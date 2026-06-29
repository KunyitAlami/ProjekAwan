<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StorageAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('storage_authenticated')) {
            return redirect()->route('storage.login');
        }

        return $next($request);
    }
}