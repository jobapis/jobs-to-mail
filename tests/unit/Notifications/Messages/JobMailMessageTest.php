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

        $listing = [
            'link' => uniqid(),
            'text' => $title.' at '.$company.' in '.$location.'.',
        ];

        $job->shouldReceive('getTitle')
            ->once()
            ->andReturn($title);
        $job->shouldReceive('getCompanyName')
            ->twice()
            ->andReturn($company);
        $job->shouldReceive('getLocation')
            ->twice()
            ->andReturn($location);
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
