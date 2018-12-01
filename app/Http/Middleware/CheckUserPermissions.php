<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserPermissions
{
    protected $except_urls = [
        'home'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(! check_user_permissions($request, $this->except_urls))
        {
            if($request->ajax())
                return response()->json(__('auth.permission_error'), 403);

            abort(403, "You Don't Have Permission For This Page");
        }
        
        return $next($request);
    }

    public static function getExceptUrls()
    {
        $self = new CheckUserPermissions();
        return $self->except_urls;
    }
}
