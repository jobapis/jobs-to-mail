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
        $listing = [
            'link' => uniqid(),
            'text' => $title.'.',
        ];

        $job->shouldReceive('getTitle')
            ->once()
            ->andReturn($title);
        $job->shouldReceive('getCompanyName')
            ->once()
            ->andReturn(null);
        $job->shouldReceive('getLocation')
            ->once()
            ->andReturn(null);
        $job->shouldReceive('getUrl')
            ->once()
            ->andReturn($listing['link']);

        $result = $message->listing($job);

        $this->assertEquals($listing, $result->jobListings[0]);
    }
}
