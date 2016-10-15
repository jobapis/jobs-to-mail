<?php namespace JobApis\JobsToMail\Jobs;

use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface;

class ConfirmUser
{
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
     * Confirm a user's account using a token
     *
     * @param UserRepositoryInterface $users
     *
     * @return FlashMessage
     */
    public function handle(UserRepositoryInterface $users)
    {
        if ($users->confirm($this->token)) {
            return new FlashMessage(
                'alert-success',
                'Your email address has been confirmed. 
                    Look for new jobs in your inbox tomorrow.'
            );
        }
        return new FlashMessage(
            'alert-danger',
            'That token is invalid or expired. Please create a new job search.'
        );
    }
}
