<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class RedirectIfAuthenticated
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
        if ($this->auth->check()) {
            if($request->is('admin/*')&&!$request->is('admin/home/index')){
              //  return redirect('/admin/home/index');
            }elseif($request->is('web/*')&&!$request->is('web/home/index')){
                return redirect('/web/home/index');
            }elseif($request->is('h5/*')){
                return redirect()->back();
            }else{
                return response('Unauthorized.', 401);
            }
        }

        return $next($request);
    }
}
