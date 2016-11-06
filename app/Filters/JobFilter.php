<?php namespace JobApis\JobsToMail\Filters;

class JobFilter
{
    /**
     * Returns an array of jobs each with only the attributes specified
     *
     * @param array $jobs
     * @param array $fields
     *
     * @return array
     */
    public function filterFields($jobs = [], $fields = [])
    {
        foreach ($jobs as &$job) {
            $job = array_filter($job, function ($key) use ($fields) {
                return in_array($key, $fields);
            }, ARRAY_FILTER_USE_KEY);
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
