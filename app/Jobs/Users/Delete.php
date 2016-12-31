<?php namespace JobApis\JobsToMail\Jobs\Users;

use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface;

class Delete
{
    /**
     * @var string $userId
     */
    protected $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($userId = null)
    {
        $this->userId = $userId;
    }

    /**
     * Unsubscribe a user's by deleting their account
     *
     * @param UserRepositoryInterface $users
     *
     * @return FlashMessage
     */
    public function handle(UserRepositoryInterface $users)
    {
        if ($users->delete($this->userId)) {
            return new FlashMessage(
                'alert-success',
                'Your account has been cancelled. You will no longer receive any emails from us.'
            );
        }
        return new FlashMessage(
            'alert-danger',
            'We couldn\'t unsubscribe you. Please try again later or contact us.'
        );
    }
}
