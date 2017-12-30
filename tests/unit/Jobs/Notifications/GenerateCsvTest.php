<?php namespace JobApis\JobsToMail\Tests\Unit\Jobs\Notifications;

use JobApis\JobsToMail\Jobs\Notifications\GenerateCsv;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;

class GenerateCsvTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->notificationId = $this->faker->uuid();
        $this->job = new GenerateCsv($this->notificationId);
    }

    public function testItCanHandle()
    {
        $notifications = m::mock('JobApis\JobsToMail\Models\CustomDatabaseNotification');
        $filter = m::mock('JobApis\JobsToMail\Filters\JobFilter');
        $writer = m::mock('League\Csv\Writer');

        $jobsData = [
            ['name' => uniqid()],
        ];
        $csvHeaders = [
            'name',
            'description',
            'url',
            'company',
            'location',
            'query',
            'industry',
            'source',
            'datePosted',
        ];
        $path = storage_path('app/'.$this->notificationId.'.csv');

        $notifications->shouldReceive('where')
            ->with('id', $this->notificationId)
            ->once()
            ->andReturnSelf();
        $notifications->shouldReceive('first')
            ->once()
            ->andReturn((object) ['data' => $jobsData]);
        $filter->shouldReceive('filterFields')
            ->with($jobsData, $csvHeaders)
            ->once()
            ->andReturn($jobsData);
        $writer->shouldReceive('createFromPath')
            ->with($path, 'x+')
            ->once()
            ->andReturnSelf();
        $writer->shouldReceive('insertOne')
            ->with(array_keys($jobsData[0]))
            ->once()
            ->andReturn(1);
        $writer->shouldReceive('insertAll')
            ->with($jobsData)
            ->once()
            ->andReturn(1);

        $result = $this->job->handle($notifications, $filter, $writer);

        $this->assertEquals($path, $result);
    }
}
