<?php namespace JobApis\JobsToMail\Jobs\Auth;

use Illuminate\Http\Request;
use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Models\Token;
use JobApis\JobsToMail\Models\User;
use JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface;

class LoginUserWithToken
{
    /**
     * Number of days until tokens "expire"
     */
    const DAYS_TO_EXPIRE = 7;

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
     * @param Request $request
     *
     * @return FlashMessage
     */
    public function handle(UserRepositoryInterface $users, Request $request)
    {
        $token = $users->getToken($this->token, self::DAYS_TO_EXPIRE);
        if ($token) {
            // Log in the user
            $user = $this->loginUser($token, $request);

            // Send them a flash message response
            if ($users->confirm($user)) {
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

    /**
     * Handles the login and destruction of tokens
     *
     * @param Token $token
     * @param Request $request
     *
     * @return User
     */
    private function loginUser(Token $token, Request $request)
    {
        // Invalidate the user's current session
        $request->session()->invalidate();

        // Log in the user by token
        $request->session()->put('user', $token->user->toArray());

        // Destroy the token
        $token->delete();

        return $token->user;
    }
}
