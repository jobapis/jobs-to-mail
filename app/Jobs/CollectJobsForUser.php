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
     * The maximum number of jobs to return
     */
    const MAX_JOBS = 50;

    /**
     * The maximum number of jobs from each provider
     */
    const MAx_JOBS_FROM_PROVIDER = 10;

    /**
     * The maximum age of a job to be included
     */
    const MAX_DAYS_OLD = 14;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Collect and sort jobs from multiple APIs using the JobsMulti client.
     *
     * @param JobsMulti $jobsClient
     *
     * @return array
     */
    public function handle(JobsMulti $jobsClient)
    {
        // Collect jobs based on the user's keyword and location
        $jobsByProvider = $jobsClient->setKeyword($this->user->keyword)
            ->setLocation($this->user->location)
            ->setPage(1, self::MAx_JOBS_FROM_PROVIDER)
            ->getAllJobs();

        // Sort jobs into one array
        $jobs = $this->getJobsFromCollections($jobsByProvider);
        $jobs = $this->sortJobs($jobs);
        dd(json_encode($jobs));

        // Trigger notification to user
        if ($jobs) {
            $this->user->notify(new JobsCollected($jobs));
        } else {
            Log::info("No jobs found for user {$this->user->id}");
        }
        return $jobs;
    }

    /**
     * Sort jobs by date posted, desc
     *
     * @param array $jobs
     *
     * @return array
     */
    protected function sortJobs($jobs = [])
    {
        // Sort by date
        usort($jobs, function ($item1, $item2) {
            return $item2->datePosted <=> $item1->datePosted;
        });
        // Filter any older than max age
        $jobs = array_filter($jobs, function ($job) {
            return $job->datePosted > new \DateTime(self::MAX_DAYS_OLD.' days ago');
        });
        // Truncate to the max number of results
        return array_slice($jobs, 0, self::MAX_JOBS);
    }

    /**
     * Convert the array of collections to one large array
     *
     * @param array $collectionsArray
     *
     * @return array
     */
    protected function getJobsFromCollections($collectionsArray = [])
    {
        $jobs = [];
        array_walk_recursive(
            $collectionsArray,
            function(Collection $collection) use (&$jobs) {
                $jobListings = array_slice(
                    $collection->all(),
                    0,
                    self::MAx_JOBS_FROM_PROVIDER
                );
                foreach ($jobListings as $jobListing) {
                    $jobs[] = $jobListing;
                }
            }
        );
        return $jobs;
    }
}
