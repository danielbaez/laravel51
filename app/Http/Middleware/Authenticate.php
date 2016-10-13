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
     * Create a new middleware instance.
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
                return redirect()->guest('auth/login');
            }
        }
        
        if($this->auth->check() && $this->auth->user()->active !== 1){
            $this->auth->logout();
            //return redirect('auth/login')->withErrors('Su cuenta de usuario está desacticada');
            return redirect()->route('login-get')->withErrors('Su cuenta de usuario está desacticada');
        }

        \Session::forget('menu');
        \Session::put('country', $this->auth->user()->country);
        switch (\Session::get('country')) {
            case 'pe':
                \Session::put('country_desc', 'Perú');
                break;
            case 'mx':
            default:
                \Session::put('country_desc', 'México');
                break;
            case 'co':
            default:
                \Session::put('country_desc', 'Colombia');
                break;
        }
        
        if($this->auth->user()->type == 1){
            \Session::push('menu', (object)array('title'=>'Dashboard', 'route'=>'home', 'path' => 'admin', 'icon'=>'fa-dashboard')); 
            \Session::push('menu', (object)array('title'=>'Usuarios','route'=>'admin.user.index', 'path' => 'admin/user', 'icon'=>'fa-users'));

            \Session::push('menu', (object)array('title'=>'Llamadas','route'=>'calls', 'path' => 'admin/calls', 'icon'=>'fa-phone')); 
        }
        if($this->auth->user()->type == 3){
            \Session::push('menu', (object)array('title'=>'Dashboard', 'route'=>'home', 'path' => 'admin', 'icon'=>'fa-dashboard'));  
        }
        if($this->auth->user()->type == 2){
            \Session::push('menu', (object)array('title'=>'Dashboard', 'route'=>'home', 'path' => 'admin', 'icon'=>'fa-dashboard'));
        }

        return $next($request);
    }
}
