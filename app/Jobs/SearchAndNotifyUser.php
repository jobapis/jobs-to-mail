<?php namespace JobApis\JobsToMail\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use JobApis\Jobs\Client\Collection;
use JobApis\Jobs\Client\JobsMulti;
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
    public function handle(JobsMulti $jobsClient, Recruiter $recruiter)
    {
        // Going to use the recruiter model
        $this->recruiter = $recruiter;

        // Collect jobs based on the Search keyword and location
        $jobsByProvider = $jobsClient->setKeyword($this->search->keyword)
            ->setLocation($this->search->location)
            ->setPage(1, self::MAX_JOBS_FROM_PROVIDER)
            ->getAllJobs();

        // Get jobs in one array
        $this->jobs = $this->getJobsFromCollections($jobsByProvider);

        // Sort the jobs
        $this->sortJobs();

        // Filter jobs from recruiters
        $this->filterRecruiterJobs();

        // Trigger notification to user
        if ($this->jobs) {
            $this->search->user->notify(new JobsCollected($this->jobs, $this->search));
        } else {
            Log::info("No jobs found for search {$this->search->id}");
        }
        return $this->jobs;
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
            function (Collection $collection) use (&$jobs) {
                $this->logErrorsFromCollection($collection);
                $jobListings = array_slice(
                    $collection->all(),
                    0,
                    self::MAX_JOBS_FROM_PROVIDER
                );
                foreach ($jobListings as $jobListing) {
                    $jobs[] = $jobListing;
                }
            }
        );
        return $jobs;
    }

    /**
     * Filters out jobs from recruiting companies if the user's prefers it.
     *
     * @return void
     */
    protected function filterRecruiterJobs()
    {
        // Make sure this search wants to filter recruiters
        if ($this->search->no_recruiters === true) {
            $this->jobs = array_filter($this->jobs, function ($job) {
                // Make sure this job has a company
                if (isset($job->company)) {
                    // Make sure this company is not a recruiter
                    $recruiter = $this->recruiter->whereNameLike($job->company)->first();
                    if ($recruiter) {
                        return false;
                    }
                }
                return true;
            });
        }
    }

    /**
     * Logs all the errors attached to a collection
     *
     * @param array $jobsByProvider
     *
     * @return void
     */
    protected function logErrorsFromCollection(Collection $collection)
    {
        if ($collection->getErrors()) {
            foreach ($collection->getErrors() as $error) {
                Log::error($error);
            }
        }
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
}
