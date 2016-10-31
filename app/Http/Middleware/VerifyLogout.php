<?php namespace JobApis\JobsToMail\Http\Middleware;

use Closure;

class VerifyLogout
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->get('user')) {
            return redirect('/');
        }

        return $next($request);
    }

}