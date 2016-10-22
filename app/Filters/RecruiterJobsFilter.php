<?php namespace JobApis\JobsToMail\Filters;

use JobApis\JobsToMail\Models\Recruiter;
use JobApis\JobsToMail\Models\Search;
use JobApis\JobsToMail\Models\User;

class RecruiterJobsFilter
{
    public function __construct(
        Recruiter $recruiter,
        Search $search,
        User $user
    ) {
        $this->recruiter = $recruiter;
        $this->search = $search;
    }

    public function filter($jobs = [])
    {
        foreach ($jobs as $job) {
            // Make sure this job has a company
            if (isset($job->company)) {
                // Make sure this search wants to filter recruiters
                if ($this->search->no_recruiters) {
                    // Make sure this company is not a recruiter
                    if ($this->recruiter->where('name', 'LIKE', $job->company)) {
                        return false;
                    }
                }
            }
            return true;
        }
    }
}
