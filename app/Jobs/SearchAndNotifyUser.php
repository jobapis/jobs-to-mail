<?php namespace JobApis\JobsToMail\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use JobApis\Jobs\Client\JobsMulti;
use JobApis\JobsToMail\Filters\CollectionFilter;
use JobApis\JobsToMail\Filters\JobFilter;
use JobApis\JobsToMail\Filters\RecruiterFilter;
use JobApis\JobsToMail\Models\Recruiter;
use JobApis\JobsToMail\Models\Search;
use JobApis\JobsToMail\Notifications\JobsCollected;

class SearchAndNotifyUser implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array Jobs collected from providers.
     */
    protected $jobs = [];

    /**
     * @var Recruiter recruiter model
     */
    protected $recruiter;

    /**
     * @var Search search to conduct
     */
    protected $search;

    /**
     * The maximum number of jobs to return
     */
    const MAX_JOBS = 50;

    /**
     * The maximum number of jobs from each provider
     */
    const MAX_JOBS_FROM_PROVIDER = 10;

    /**
     * The maximum age of a job to be included
     */
    const MAX_DAYS_OLD = 14;

    /**
     * Create a new job instance.
     */
    public function __construct(Search $search)
    {
        $this->search = $search;
    }

    /**
     * Collect and sort jobs from multiple APIs using the JobsMulti client.
     *
     * @param JobsMulti $jobsClient
     *
     * @return array
     */
    public function handle(
        JobsMulti $jobsClient,
        CollectionFilter $collectionFilter,
        JobFilter $jobFilter,
        RecruiterFilter $recruiterFilter
    ) {
        // Collect jobs based on the Search keyword and location
        $jobsByProvider = $jobsClient->setKeyword($this->search->keyword)
            ->setLocation($this->search->location)
            ->setPage(1, self::MAX_JOBS_FROM_PROVIDER)
            ->getAllJobs();

        // Get jobs Array from array of Collections
        $jobs = $collectionFilter->getJobsFromCollections($jobsByProvider, self::MAX_JOBS_FROM_PROVIDER);

        // Sort the jobs
        $jobs = $jobFilter->sort($jobs, self::MAX_DAYS_OLD, self::MAX_JOBS);

        // Filter jobs from recruiters
        $jobs = $recruiterFilter->filterRecruiterJobs($jobs, $this->search);

        // Trigger notification to user
        if ($jobs) {
            $this->search->user->notify(new JobsCollected($jobs, $this->search));
        } else {
            Log::info("No jobs found for search {$this->search->id}");
        }
        return $jobs;
    }
}
