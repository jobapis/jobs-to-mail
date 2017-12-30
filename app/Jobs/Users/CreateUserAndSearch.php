<?php namespace JobApis\JobsToMail\Jobs\Users;

use Illuminate\Support\Facades\Log;
use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Models\User;
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
     * @param SearchRepositoryInterface $searches
     *
     * @return FlashMessage
     */
    public function handle(
        UserRepositoryInterface $users,
        SearchRepositoryInterface $searches
    ): FlashMessage {
        try {
            return $this->createUserAndSearch($users, $searches);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->flashDanger(
                'Something went wrong and your job search was not saved. Please try again.'
            );
        }
    }

    /**
     * Create or get the user and search term
     *
     * @param UserRepositoryInterface $users
     * @param SearchRepositoryInterface $searches
     *
     * @return FlashMessage
     */
    private function createUserAndSearch(
        UserRepositoryInterface $users,
        SearchRepositoryInterface $searches
    ): FlashMessage {
        $user = $users->firstOrCreate($this->data);

        if (!$this->userAtOrOverMaximum($user)) {
            return $this->createSearchForUser($user, $searches);
        }

        $adminEmail = config('mail.from.address');

        return $this->flashDanger("You have reached your maximum number of 
            {$user->max_searches} job searches. Unsubscribe from a search 
            or contact {$adminEmail} to upgrade your account.");
    }

    /**
     * Creates a search for a new or existing user
     *
     * @param User $user
     * @param SearchRepositoryInterface $searches
     *
     * @return FlashMessage
     */
    private function createSearchForUser(
        User $user,
        SearchRepositoryInterface $searches
    ): FlashMessage {
        $searches->create($user->id, $this->data);

        if ($user->existed === true) {
            return $this->flashSuccess('A new search has been created for your 
            account. You should start receiving jobs within 24 hours.');
        }
        return $this->flashSuccess('A confirmation email has been sent. Once 
            confirmed, you should start receiving jobs within 24 hours.');
    }

    /**
     * Determine whether or not this user has reached the max number of allowed searches
     *
     * @param User $user
     * @return bool
     */
    private function userAtOrOverMaximum(User $user): bool
    {
        return $user->existed === true && $user->searches()->count() >= $user->max_searches;
    }

    /**
     * Returns a danger flash message
     *
     * @param string $message
     * @return FlashMessage
     */
    private function flashDanger(string $message): FlashMessage
    {
        return new FlashMessage('alert-danger', $message);
    }

    /**
     * Returns a success flash message
     *
     * @param string $message
     * @return FlashMessage
     */
    private function flashSuccess(string $message): FlashMessage
    {
        return new FlashMessage('alert-success', $message);
    }
}
