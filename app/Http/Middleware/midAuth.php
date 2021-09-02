<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Human;

class midAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $req, Closure $next)
    {
    	if (!$req->api_token)
    		return response()->json("Не введен api_token");

    	if (!Human::where('api_token', $req->api_token)->first())
    		return response()->json("Такого пользователя не существует");

        return $next($req);
    }
}
