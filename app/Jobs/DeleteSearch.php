<?php namespace JobApis\JobsToMail\Jobs;

use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Repositories\Contracts\SearchRepositoryInterface;

class DeleteSearch
{
    /**
     * @var string $searchId
     */
    protected $searchId;

    /**
     * Create a new job instance.
     */
    public function __construct($searchId = null)
    {
        $this->searchId = $searchId;
    }

    /**
     * Unsubscribe from a search by deleting it.
     *
     * @param SearchRepositoryInterface $users
     *
     * @return FlashMessage
     */
    public function handle(SearchRepositoryInterface $searches)
    {
        if ($searches->delete($this->searchId)) {
            return new FlashMessage(
                'alert-success',
                'You will no longer receive emails for this search.'
            );
        }
        return new FlashMessage(
            'alert-danger',
            'We couldn\'t unsubscribe you. Please try again later or contact us.'
        );
    }
}
