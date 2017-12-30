<?php namespace JobApis\JobsToMail\Tests\Unit\Http\Messages;

use JobApis\JobsToMail\Filters\JobFilter;
use JobApis\JobsToMail\Tests\TestCase;

class JobFilterTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->filter = new JobFilter();
    }

    public function testItCanFilterJobFields()
    {
        $jobsArray = array_map(function ($jobObject) {
            return (array) $jobObject;
        }, $this->getJobsArray(20));

        $fields = [
            'id',
            'title',
        ];

        $results = $this->filter->filterFields($jobsArray, $fields);

        foreach ($results as $job) {
            $this->assertTrue(isset($job['id']));
            $this->assertTrue(isset($job['title']));
            $this->assertFalse(isset($job['datePosted']));
        }
    }

    public function testItCanSortJobsAndCutOffAtMaxNumber()
    {
        $jobsArray = $this->getJobsArray(20);

        $results = $this->filter->sort($jobsArray, 14, 10);

        // Ensure that the results cut off at the max
        $this->assertEquals(10, count($results));

        // Ensure that each job has an earlier date than the one previous
        $previousDate = null;
        foreach ($results as $job) {
            if ($previousDate) {
                $this->assertTrue($job->datePosted < $previousDate);
            }
            $previousDate = $job->datePosted;
        }
    }

    public function testItCanSortJobsAndCutOffAtMaxDate()
    {
        $jobsArray = $this->getJobsArray(20);

        $results = $this->filter->sort($jobsArray, 10, 50);

        // Ensure that the results cut off at the max
        $this->assertLessThanOrEqual(20, count($results));

        // Ensure that each job has an earlier date than the one previous
        $previousDate = null;
        foreach ($results as $job) {
            if ($previousDate) {
                $this->assertTrue($job->datePosted < $previousDate);
            }
            $previousDate = $job->datePosted;
        }
    }

    private function getJobsArray($number = 2)
    {
        $jobsArray = [];
        $count = 0;
        while ($count < $number) {
            $jobsArray[] = (object) [
                'id' => $this->faker->uuid(),
                'title' => $this->faker->sentence(),
                'datePosted' => $this->faker->dateTimeBetween('-12 days'),
            ];
            $count++;
        }
        return $jobsArray;
    }
}
