<?php namespace JobApis\JobsToMail\Filters;

use Illuminate\Support\Facades\Log;
use JobApis\Jobs\Client\Collection;

class CollectionFilter
{
    /**
     * Convert the array of collections to one large array of Jobs
     *
     * @param array $collectionsArray
     *
     * @return array
     */
    public function getJobsFromCollections($collectionsArray = [], $max = 50)
    {
        $jobs = [];
        array_walk_recursive(
            $collectionsArray,
            function (Collection $collection) use (&$jobs, $max) {
                $this->logErrorsFromCollection($collection);
                $jobListings = array_slice($collection->all(), 0, $max);
                foreach ($jobListings as $jobListing) {
                    $jobs[] = $jobListing;
                }
            }
        );
        return $jobs;
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
}
