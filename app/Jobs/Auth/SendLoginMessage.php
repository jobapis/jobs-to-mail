<?php namespace JobApis\JobsToMail\Jobs\Auth;

use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Models\Token;
use JobApis\JobsToMail\Notifications\LoginTokenGenerated;
use JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface;

class SendLoginMessage
{
    /**
     * @var string $email
     */
    protected $email;

    /**
     * Create a new job instance.
     */
    public function __construct($email = null)
    {
        $this->email = $email;
    }

    /**
     * Send user a login token to their email.
     *
     * @param UserRepositoryInterface $users
     *
     * @return FlashMessage
     */
    public function handle(UserRepositoryInterface $users, Token $token)
    {
        $user = $users->getByEmail($this->email);
        if ($user) {
            // Generate a token and send it to the user
            $user->notify(new LoginTokenGenerated($users->generateToken($user->id, 'login')));

            return new FlashMessage(
                'alert-success',
                'We have sent a login token to you. Please check your email.',
                '/confirm'
            );
        }
        return new FlashMessage(
            'alert-danger',
            'This email address is not registered. Please try another email or
                create a new account.',
            '/login'
        );
    }
}
