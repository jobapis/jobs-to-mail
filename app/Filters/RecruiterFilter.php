<?php namespace JobApis\JobsToMail\Filters;

use JobApis\Jobs\Client\Job;
use JobApis\JobsToMail\Models\Recruiter;
use JobApis\JobsToMail\Models\Search;

class RecruiterFilter
{
    public function __construct(Recruiter $recruiter)
    {
        $this->recruiter = $recruiter;
    }

    /**
     * Filters out jobs from recruiting companies if the user prefers it.
     *
     * @param array $jobs
     * @param Search $search
     *
     * @return array
     */
    public function filter(array $jobs, Search $search)
    {
        return array_filter($jobs, function (Job $job) use ($search) {
            // Make sure this job has a company
            if (isset($job->company) && $job->company) {
                // See if this company is not a recruiter
                if ($this->recruiter->whereNameLike($job->company)->first()) {
                    if ($search->no_recruiters === true) {
                        return false;
                    } else {
                        $job->setIndustry("Staffing");
                    }
                }
            }
            return true;
        });
    }
}
