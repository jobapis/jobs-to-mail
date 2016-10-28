<?php namespace JobApis\JobsToMail\Filters;

class JobFilter
{
    /**
     * Sort jobs by date posted, desc
     *
     * @param array $jobs
     *
     * @return array
     */
    public function sort($jobs = [], $maxAge = 14, $maxJobs = 50)
    {
        // Sort by date
        usort($jobs, function ($item1, $item2) {
            return $item2->datePosted <=> $item1->datePosted;
        });
        // Filter any older than max age
        $jobs = array_filter($jobs, function ($job) use ($maxAge) {
            return $job->datePosted > new \DateTime($maxAge.' days ago');
        });
        // Truncate to the max number of results
        return array_slice($jobs, 0, $maxJobs);
    }
}
