<?php namespace JobApis\JobsToMail\Jobs\Users;

use Illuminate\Support\Facades\Mail;
use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Models\User;
use JobApis\JobsToMail\Notifications\PremiumUserSignup as Notification;
use Ramsey\Uuid\Uuid;

class PremiumUserSignup
{
    /**
     * @var string $data
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
     * Send an email to the admin about this new user signup
     *
     * @return FlashMessage
     */
    public function handle()
    {
        $user = new User(['email' => env('ADMIN_EMAIL', 'admin@jobstomail.com')]);

        $user->notify(new Notification($this->data));

        return new FlashMessage(
            'alert-success',
            'We have received your request for Premium access. We will reach out within 48 hours.'
        );
    }
}