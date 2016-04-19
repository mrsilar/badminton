<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                if($request->is('admin/*')&&!$request->is('admin/auth/login')){
                    return redirect()->guest('/admin/auth/login');
                }elseif($request->is('web/*')&&!$request->is('web/auth/login')){
                    return redirect()->guest('/web/auth/login');
                }elseif($request->is('h5/*')&&!$request->is('h5/auth/login')){
                    return redirect()->guest('/h5/auth/login');
                }else{
                    //½Ó¿Ú
                    return response('Unauthorized.', 401);
                }
            }
        }

        return $next($request);
    }
}
