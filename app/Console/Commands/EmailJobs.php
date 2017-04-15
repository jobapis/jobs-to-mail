<?php namespace JobApis\JobsToMail\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use JobApis\JobsToMail\Jobs\Notifications\SearchAndNotifyUser;
use JobApis\JobsToMail\Repositories\Contracts\SearchRepositoryInterface;

class EmailJobs extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:email {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends job listings for each search created by an active user.';

    /**
     * @var SearchRepositoryInterface
     */
    protected $searches;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SearchRepositoryInterface $searches)
    {
        parent::__construct();
        $this->searches = $searches;
    }

    /**
     * Goes through each user and queues up a task to collect and email them their jobs.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = 0;
        foreach ($this->searches->getActive($this->option('email')) as $search) {
            $this->dispatch(new SearchAndNotifyUser($search));
            $count++;
        }
        return $this->info("{$count} job searches queued for collection.");
    }
}
