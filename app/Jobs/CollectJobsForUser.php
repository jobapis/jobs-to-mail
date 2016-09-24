<?php namespace JobApis\JobsToMail\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use JobApis\Jobs\Client\Collection;
use JobApis\Jobs\Client\JobsMulti;
use JobApis\JobsToMail\Models\User;
use JobApis\JobsToMail\Notifications\JobsCollected;

class CollectJobsForUser implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User user to send jobs to.
     */
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(JobsMulti $jobsClient)
    {
        // Collect jobs based on the user's keyword and location
        $jobsByProvider = $jobsClient->setKeyword($this->user->keyword)
            ->setLocation($this->user->location)
            ->setPage(1, 10)
            ->getAllJobs();

        // Sort jobs into one array
        $jobs = $this->sortJobs($jobsByProvider);

        // Trigger notification to user
        if ($jobs) {
            $this->user->notify(new JobsCollected($jobs));
        } else {
            Log::info("No jobs found for user {$this->user->id}");
        }
    }

    protected function sortJobs($collectionsArray = [])
    {
        $jobs = [];
        // Convert the array of collections to one large array
        foreach ($collectionsArray as $collection) {
            foreach (array_slice($collection->all(), 0, 10) as $jobListing) {
                $jobs[] = $jobListing;
            }
        }
        // Order by date posted, desc
        usort($jobs, function ($item1, $item2) {
            return $item2->datePosted <=> $item1->datePosted;
        });
        return $jobs;
    }
}
