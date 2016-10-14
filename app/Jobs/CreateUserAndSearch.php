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
     * @return \JobApis\JobsToMail\Models\User
     */
    public function handle(
        UserRepositoryInterface $users,
        SearchRepositoryInterface $searches
    ) {
        // Get or create the user
        $user = $users->firstOrCreate($this->data);

        // Create a new search for this user
        $searches->create($user->id, $this->data);

        return $user;
    }
}
