<?php namespace JobApis\JobsToMail\Tests\Unit\Notifications;

use JobApis\JobsToMail\Repositories\SearchRepository;
use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;

class SearchRepositoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->searches = m::mock('JobApis\JobsToMail\Models\Search');
        $this->repository = new SearchRepository($this->searches);
    }

    public function testItCanCreateSearch()
    {
        $user_id = $this->faker->uuid();
        $data = [
            'keyword' => uniqid(),
            'location' => uniqid(),
        ];

        $this->searches->shouldReceive('create')
            ->with(array_merge(['user_id' => $user_id], $data))
            ->once()
            ->andReturnSelf();

        $result = $this->repository->create($user_id, $data);

        $this->assertEquals($this->searches, $result);
    }
}
