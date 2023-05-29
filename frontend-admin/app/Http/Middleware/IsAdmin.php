<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(isset($_COOKIE['my_token']) && isset($_COOKIE['my_key'])) {
            $user = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $_COOKIE['my_token'],
            ])->get(env('SERVER_API') . 'users/' . $_COOKIE['my_key']);
    
            if(json_decode($user)->status == 'success') {
                if(json_decode($user)->data->user_level == 'admin') {
                    return $next($request);
                }
                abort(403);
            }
        }

        abort(403);
    }
}
