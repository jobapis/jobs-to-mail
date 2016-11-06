<?php namespace JobApis\JobsToMail\Http\Middleware;

use Closure;

class VerifyLogin
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
        if (!$request->session()->get('user')) {
            $request->session()->flash(
                'alert-danger',
                'You must be logged in for access.'
            );
            return redirect('/login');
        }

        return $next($request);
    }
}
