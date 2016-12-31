<?php namespace JobApis\JobsToMail\Jobs\Users;

use Illuminate\Support\Facades\Log;
use JobApis\JobsToMail\Http\Messages\FlashMessage;
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
     * @return FlashMessage
     */
    public function handle(
        UserRepositoryInterface $users,
        SearchRepositoryInterface $searches
    ) {
        try {
            // Get or create the user
            $user = $users->firstOrCreate($this->data);

            // Make sure the user isn't over their maximum
            $maxSearches = config('app.user_tier_permissions.'.$user->tier.'.max_search_count');

            if ($user->existed === true && $user->searches()->count() >= $maxSearches) {
                return new FlashMessage(
                    'alert-danger',
                    "You have reached your maximum number of job searches. As a 
                        {$user->tier} user you can create {$maxSearches} searches. 
                        Unsubscribe from a search or contact upgrade@jobstomail.com 
                        to upgrade your account."
                );
            }

            // Create a new search for this user
            $searches->create($user->id, $this->data);

            // User already existed
            if ($user->existed === true) {
                // User is new to our system
                return new FlashMessage(
                    'alert-success',
                    'A new search has been created for your account.
                        you should start receiving jobs within 24 hours.'
                );
            }
            // User is new to our system
            return new FlashMessage(
                'alert-success',
                'A confirmation email has been sent. 
                    Once confirmed, you should start receiving jobs within 24 hours.'
            );
        } catch (\Exception $e) {
            // Log the error and let the user know something went wrong
            Log::error($e->getMessage());
            return new FlashMessage(
                'alert-danger',
                'Something went wrong and your job search was not saved.
                    Please try again.'
            );
        }
    }
}
