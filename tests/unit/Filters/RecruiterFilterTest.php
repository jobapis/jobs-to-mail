<?php namespace JobApis\JobsToMail\Tests\Unit\Http\Messages;

use JobApis\Jobs\Client\Job;
use JobApis\JobsToMail\Filters\RecruiterFilter;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;

class RecruiterFilterTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->recruiter = m::mock('JobApis\JobsToMail\Models\Recruiter');
        $this->search = m::mock('JobApis\JobsToMail\Models\Search');
        $this->filter = new RecruiterFilter($this->recruiter);
    }

    public function testItSkipsFilterIfSearchDoesntRequestIt()
    {
        $jobsArray = $this->getJobsArray();
        foreach ($jobsArray as &$job) {
            $job->setCompany(uniqid());
        }

        $this->recruiter->shouldReceive('whereNameLike')
            ->times(count($jobsArray))
            ->andReturnSelf();
        $this->recruiter->shouldReceive('first')
            ->times(count($jobsArray))
            ->andReturnSelf();
        $this->search->shouldReceive('getAttribute')
            ->with('no_recruiters')
            ->times(count($jobsArray))
            ->andReturn(false);

        $result = $this->filter->filter($jobsArray, $this->search);

        $this->assertEquals($jobsArray, $result);
    }

    public function testItSkipsFilterIfJobsDontHaveCompany()
    {
        $jobsArray = $this->getJobsArray();

        $result = $this->filter->filter($jobsArray, $this->search);

        $this->assertEquals($jobsArray, $result);
    }

    public function testItFiltersIfJobsDoHaveCompanyThatIsRecruiter()
    {
        $recruitingCompany = uniqid();
        $jobsArray = $this->getJobsArray();
        foreach ($jobsArray as &$job) {
            $job->setCompany($recruitingCompany);
        }

        $this->recruiter->shouldReceive('whereNameLike')
            ->with($recruitingCompany)
            ->times(count($jobsArray))
            ->andReturnSelf();
        $this->recruiter->shouldReceive('first')
            ->times(count($jobsArray))
            ->andReturnSelf();
        $this->search->shouldReceive('getAttribute')
            ->with('no_recruiters')
            ->times(count($jobsArray))
            ->andReturn(true);

        $result = $this->filter->filter($jobsArray, $this->search);

        $this->assertEmpty($result);
    }

    private function getJobsArray($number = 2)
    {
        $jobsArray = [];
        $count = 0;
        while ($count < $number) {
            $jobsArray[] = new Job([
                'title' => $this->faker->sentence(),
                'datePosted' => new \DateTime(),
                'company' => null,
            ]);
            $count++;
        }
        return $jobsArray;
    }
}
