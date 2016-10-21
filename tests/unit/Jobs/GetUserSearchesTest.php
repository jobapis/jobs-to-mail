<?php namespace JobApis\JobsToMail\Tests\Unit\Jobs;

use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Jobs\GetUserSearches;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;

class GetUserSearchesTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->userId = uniqid();
        $this->job = new GetUserSearches($this->userId);
    }

    public function testItCanHandle()
    {
        $repository = m::mock('JobApis\JobsToMail\Repositories\Contracts\SearchRepositoryInterface');
        $searches = m::mock('Illuminate\Database\Eloquent\Collection');

        $repository->shouldReceive('getByUserId')
            ->with($this->userId)
            ->once()
            ->andReturn($searches);

        $result = $this->job->handle($repository);

        $this->assertEquals($searches, $result);
    }
}
