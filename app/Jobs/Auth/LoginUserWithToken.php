<?php namespace JobApis\JobsToMail\Jobs\Auth;

use Illuminate\Http\Request;
use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface;

class LoginUserWithToken
{
    /**
     * Number of days until tokens "expire"
     */
    const DAYS_TO_EXPIRE = 30;

    /**
     * @var string $token
     */
    protected $token;

    /**
     * Create a new job instance.
     */
    public function __construct($token = null)
    {
        $this->token = $token;
    }

    /**
     * Login to/Confirm a user's account using a token
     *
     * @param UserRepositoryInterface $users
     *
     * @return FlashMessage
     */
    public function handle(UserRepositoryInterface $users, Request $request)
    {
        $token = $users->getToken($this->token, self::DAYS_TO_EXPIRE);
        if ($token) {
            // Log in the user
            $request->session()->invalidate();
            $request->session()->put('user', $token->user->toArray());

            // Send them a flash message response
            if ($users->confirm($token)) {
                // If token is confirm token, show:
                return new FlashMessage(
                    'alert-success',
                    'Your email address has been confirmed. 
                        Look for new jobs in your inbox tomorrow.'
                );
            } else {
                // If token is login token, show:
                return new FlashMessage(
                    'alert-success',
                    'Welcome back! You are now logged in.'
                );
            }
        }
        return new FlashMessage(
            'alert-danger',
            'That token is invalid or expired. Please login to generate a new token.'
        );
    }
}
