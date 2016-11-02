<?php namespace JobApis\JobsToMail\Http\Middleware;

use Closure;
use JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface;

class UpdateSessionUser
{
    /**
     * @var UserRepositoryInterface
     */
    public $users;

    /**
     * UpdateSessionUser constructor.
     *
     * @param UserRepositoryInterface $users
     */
    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

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
                $this->users->getById($userId)
            );
        }
        return $next($request);
    }
}
