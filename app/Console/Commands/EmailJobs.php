<?php namespace JobApis\JobsToMail\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use JobApis\JobsToMail\Jobs\CollectJobsForUser;
use JobApis\JobsToMail\Repositories\UserRepository;

class EmailJobs extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collects job listing results to each active user in the DB.';

    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserRepository $users)
    {
        parent::__construct();
        $this->users = $users;
    }

    /**
     * Goes through each user and queues up a task to collect and email them their jobs.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->users->getConfirmed() as $user) {
            $this->dispatch(new CollectJobsForUser($user));
        }
        return $this->info("User job searches queued for collection.");
    }
}
