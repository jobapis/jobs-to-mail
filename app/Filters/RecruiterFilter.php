<?php namespace JobApis\JobsToMail\Filters;

use JobApis\JobsToMail\Models\Recruiter;
use JobApis\JobsToMail\Models\Search;

class RecruiterFilter
{
    public function __construct(Recruiter $recruiter)
    {
        $this->recruiter = $recruiter;
    }

    /**
     * Filters out jobs from recruiting companies if the user's prefers it.
     *
     * @param array $jobs
     * @param Search $search
     *
     * @return array
     */
    public function filter(array $jobs, Search $search)
    {
        // Make sure this search wants to filter recruiters
        if ($search->no_recruiters === true) {
            return array_filter($jobs, function ($job) {
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
        return $jobs;
    }
}
