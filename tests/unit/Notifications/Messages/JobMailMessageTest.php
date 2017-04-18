<?php namespace JobApis\JobsToMail\Tests\Unit\Notifications;

use JobApis\JobsToMail\Notifications\Messages\JobMailMessage;
use Mockery as m;
use JobApis\JobsToMail\Tests\TestCase;

class JobMailMessageTest extends TestCase
{
    public function testItCanAddListingWithAllValues()
    {
        $message = new JobMailMessage();
        $job = m::mock('JobApis\Jobs\Client\Job');

        $title = uniqid();
        $company = uniqid();
        $location = uniqid();
        $date = $this->faker->monthName().' '.rand(1,28).', '.$this->faker->year();

        $listing = [
            'link' => uniqid(),
            'title' => $title,
            'company' => ' at '.$company,
            'location' => ' in '.$location,
            'date' => $date,
        ];

        $job->shouldReceive('getTitle')
            ->once()
            ->andReturn($title);
        $job->shouldReceive('getCompanyName')
            ->once()
            ->andReturn($company);
        $job->shouldReceive('getIndustry')
            ->once()
            ->andReturn(null);
        $job->shouldReceive('getLocation')
            ->once()
            ->andReturn($location);
        $job->shouldReceive('getDatePosted')
            ->once()
            ->andReturn(new \DateTime($date));
        $job->shouldReceive('getUrl')
            ->once()
            ->andReturn($listing['link']);

        $result = $message->listing($job);

        $this->assertEquals($listing, $result->jobListings[0]);
    }

    public function testItCanGetDataArray()
    {
        $message = new JobMailMessage();
        $message->jobListings = [
            uniqid(),
            uniqid(),
            uniqid(),
        ];
        $result = $message->data();

        $this->assertContains($message->jobListings, $result);
    }
}
