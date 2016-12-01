<?php namespace JobApis\JobsToMail\Jobs\Users;

use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Models\User;
use JobApis\JobsToMail\Notifications\PremiumUserSignup as Notification;

class PremiumUserSignup
{
    /**
     * @var User $admin
     */
    public $admin;

    /**
     * @var string $data
     */
    public $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data = [])
    {
        $this->data = $data;
        $this->admin = new User(
            ['email' => env('ADMIN_EMAIL', 'admin@jobstomail.com')]
        );
    }

    /**
     * Send an email to the admin about this new user signup
     *
     * @return FlashMessage
     */
    public function handle()
    {
        $this->admin->notify(new Notification($this->data));

        return new FlashMessage(
            'alert-success',
            'We have received your request for Premium access. We will reach out within 48 hours.'
        );
    }
}
