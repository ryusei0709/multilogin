<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{

    // RouteServiceProviderで設定したasを元に値を hogehoge.login
    protected $user_route = 'user.login';
    protected $owner_route = 'owner.login';
    protected $admin_route = 'admin.login';

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // 認証されていない際のリダイレクト設定
    protected function redirectTo($request)
    {

        if (!$request->expectsJson()) {
            // return route('login');

            // 各認証していない時のリダイレクト先の指定
            if(Route::is('owner.*')) {
                return route($this->owner_route);
            } else if(Route::is('admin.*')) {
                return route($this->admin_route);
            } else {
                return route($this->user_route);
            }

            
        }
    }
}
