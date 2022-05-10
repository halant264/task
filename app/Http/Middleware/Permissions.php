<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use  Auth;


class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next , ...$permission)
    {
        // dd(auth::user()->roles());
        $i=0;
        while( $i < auth::user()->roles->count() && auth::user()->roles->count() > 0  ){
            foreach(auth::user()->roles[$i]->permissions as $per){
                if (auth::user() && in_array($per->key, $permission)) {
                    return $next($request);
                }
            }
            $i++;
        }
        return  response()->json([
            'message' =>  'cant access to this route',
            'success' => false
        ], 401);
    }
}
