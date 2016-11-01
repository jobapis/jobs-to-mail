<?php namespace JobApis\JobsToMail\Http\Middleware;

use Closure;
use JobApis\JobsToMail\Models\User;

class UpdateSessionUser
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
        if ($userId = $request->session()->get('user.id')) {
            // Update the user's session
            $request->session()->put(
                'user',
                User::where('id', $userId)->first()
            );
        }
        return $next($request);
    }
}