<?php namespace JobApis\JobsToMail\Tests\Unit\Jobs\Searches;

use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Jobs\Searches\Delete;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;

class DeleteTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->id = $this->faker->uuid();
        $this->job = new Delete($this->id);
    }

    public function testItCanHandleIfUserConfirmed()
    {
        $repository = m::mock('JobApis\JobsToMail\Repositories\Contracts\SearchRepositoryInterface');

        $repository->shouldReceive('delete')
            ->with($this->id)
            ->once()
            ->andReturn(true);

        $result = $this->job->handle($repository);

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-success', $result->type);
    }

    public function testItCanHandleIfExceptionThrown()
    {
        $repository = m::mock('JobApis\JobsToMail\Repositories\Contracts\SearchRepositoryInterface');

        $repository->shouldReceive('delete')
            ->with($this->id)
            ->once()
            ->andReturn(false);

        $result = $this->job->handle($repository);

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-danger', $result->type);
    }
}
