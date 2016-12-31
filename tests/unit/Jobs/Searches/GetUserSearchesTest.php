<?php namespace JobApis\JobsToMail\Tests\Unit\Jobs\Searches;

use JobApis\JobsToMail\Jobs\Searches\GetUserSearches;
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
