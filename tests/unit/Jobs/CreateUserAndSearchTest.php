<?php namespace JobApis\JobsToMail\Tests\Unit\Jobs;

use JobApis\JobsToMail\Tests\TestCase;
use Mockery as m;
use JobApis\JobsToMail\Jobs\CreateUserAndSearch;

class CreateUserAndSearchTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->input = [
            'email' => $this->faker->safeEmail(),
            'keyword' => $this->faker->word(),
            'location' => $this->faker->word().', '.$this->faker->word(),
        ];
        $this->job = new CreateUserAndSearch($this->input);
    }

    public function testItCanHandle()
    {
        $userRepository = m::mock('JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface');
        $user = m::mock('JobApis\JobsToMail\Models\User');
        $searchRepository = m::mock('JobApis\JobsToMail\Repositories\Contracts\SearchRepositoryInterface');
        $search = m::mock('JobApis\JobsToMail\Models\Search');
        $userId = $this->faker->uuid();

        $userRepository->shouldReceive('firstOrCreate')
            ->with($this->input)
            ->once()
            ->andReturn($user);
        $user->shouldReceive('getAttribute')
            ->with('id')
            ->once()
            ->andReturn($userId);
        $searchRepository->shouldReceive('create')
            ->with($userId, $this->input)
            ->once()
            ->andReturn($search);

        $result = $this->job->handle($userRepository, $searchRepository);

        $this->assertEquals($user, $result);
    }
}
