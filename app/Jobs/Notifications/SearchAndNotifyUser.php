<?php namespace JobApis\JobsToMail\Jobs\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use JobApis\Jobs\Client\JobsMulti;
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
    const MAX_JOBS = 25;

    /**
     * The maximum number of jobs from each provider
     */
    const MAX_JOBS_FROM_PROVIDER = 10;

    /**
     * The maximum age of a job to be included
     */
    const MAX_DAYS_OLD = 2;

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
     * @param RecruiterFilter $recruiterFilter
     *
     * @return array
     */
    public function handle(
        JobsMulti $jobsClient,
        RecruiterFilter $recruiterFilter
    ) {
        // Add options for max results and age
        $options = [
            'maxAge' => self::MAX_DAYS_OLD,
            'maxResults' => self::MAX_JOBS,
            'orderBy' => 'datePosted',
            'order' => 'desc',
        ];

        // Collect jobs based on the Search keyword and location
        $jobs = $jobsClient->setKeyword($this->search->keyword)
            ->setLocation($this->search->location)
            ->setPage(1, self::MAX_JOBS_FROM_PROVIDER)
            ->getAllJobs($options);

        // Filter jobs from recruiters and convert to array
        $jobs = $recruiterFilter->filter($jobs->all(), $this->search);

        // Trigger notification to user
        if ($jobs) {
            $this->search->user->notify(new JobsCollected($jobs, $this->search));
        } else {
            Log::info("No jobs found for search {$this->search->id}");
        }
        return $jobs;
    }
}
