<?php namespace JobApis\JobsToMail\Jobs\Searches;

use JobApis\JobsToMail\Repositories\Contracts\SearchRepositoryInterface;

class GetUserSearches
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
     * Get the searches belonging to this user
     *
     * @param SearchRepositoryInterface $searches
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function handle(SearchRepositoryInterface $searches)
    {
        return $searches->getByUserId($this->userId);
    }
}
