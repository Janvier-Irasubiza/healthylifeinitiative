<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Checkout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    public function handle(Request $request, Closure $next): Response
    {
        $validData = session()->get('validData', []);
        $data_order = session()->get('data_order', []); 

        if(empty($validData) && empty($data_orde)){
            return redirect() -> route('client.dashboard');
        }

        return $next($request);
    }
}
