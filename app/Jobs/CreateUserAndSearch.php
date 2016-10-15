<?php namespace JobApis\JobsToMail\Jobs;

use JobApis\JobsToMail\Repositories\Contracts\SearchRepositoryInterface;
use JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface;

class CreateUserAndSearch
{
    /**
     * @var array $data
     */
    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Create a Search for new or existing User
     *
     * @param UserRepositoryInterface $users
     *
     * @return string
     */
    public function handle(
        UserRepositoryInterface $users,
        SearchRepositoryInterface $searches
    ) {
        // Get or create the user
        $user = $users->firstOrCreate($this->data);

        // Create a new search for this user
        $searches->create($user->id, $this->data);

        // User already existed
        if ($user->existed === true) {
            return 'A new search has been created for your account.
                you will start receiving jobs within 24 hours.';
        }
        // User is new to our system
        return 'A confirmation email has been sent. 
                    Once confirmed, you will start receiving jobs within 24 hours.';
    }
}
