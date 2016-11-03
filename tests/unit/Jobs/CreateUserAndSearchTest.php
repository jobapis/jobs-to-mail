<?php namespace JobApis\JobsToMail\Tests\Unit\Jobs;

use Illuminate\Support\Facades\Log;
use JobApis\JobsToMail\Http\Messages\FlashMessage;
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

    public function testItCanHandleIfFreeUserExistedWithNoSearches()
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
        $user->shouldReceive('getAttribute')
            ->with('existed')
            ->twice()
            ->andReturn(true);
        $user->shouldReceive('getAttribute')
            ->with('tier')
            ->once()
            ->andReturn(config('app.user_tiers.free'));
        $user->shouldReceive('searches')
            ->once()
            ->andReturn($search);
        $search->shouldReceive('count')
            ->once()
            ->andReturn(0);

        $result = $this->job->handle($userRepository, $searchRepository);

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-success', $result->type);
    }

    public function testItCanHandleIfFreeUserExistedWithMaxSearches()
    {
        $userRepository = m::mock('JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface');
        $user = m::mock('JobApis\JobsToMail\Models\User');
        $searchRepository = m::mock('JobApis\JobsToMail\Repositories\Contracts\SearchRepositoryInterface');
        $search = m::mock('JobApis\JobsToMail\Models\Search');

        $userRepository->shouldReceive('firstOrCreate')
            ->with($this->input)
            ->once()
            ->andReturn($user);
        $user->shouldReceive('getAttribute')
            ->with('existed')
            ->once()
            ->andReturn(true);
        $user->shouldReceive('getAttribute')
            ->with('tier')
            ->twice()
            ->andReturn(config('app.user_tiers.free'));
        $user->shouldReceive('searches')
            ->once()
            ->andReturn($search);
        $search->shouldReceive('count')
            ->once()
            ->andReturn(config(
                'app.user_tier_permissions.free.max_search_count'
            ));

        $result = $this->job->handle($userRepository, $searchRepository);

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-danger', $result->type);
    }

    public function testItCanHandleIfUserNotExisted()
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
        $user->shouldReceive('getAttribute')
            ->with('tier')
            ->once()
            ->andReturn(config('app.user_tiers.free'));
        $user->shouldReceive('getAttribute')
            ->with('existed')
            ->twice()
            ->andReturn(false);

        $result = $this->job->handle($userRepository, $searchRepository);

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-success', $result->type);
    }

    public function testItCanHandleIfExceptionThrown()
    {
        $userRepository = m::mock('JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface');
        $searchRepository = m::mock('JobApis\JobsToMail\Repositories\Contracts\SearchRepositoryInterface');$search = m::mock('JobApis\JobsToMail\Models\Search');

        $userRepository->shouldReceive('firstOrCreate')
            ->with($this->input)
            ->once()
            ->andThrow(\Exception::class);
        Log::shouldReceive('error')
            ->once()
            ->andReturnSelf();

        $result = $this->job->handle($userRepository, $searchRepository);

        $this->assertEquals(FlashMessage::class, get_class($result));
        $this->assertEquals('alert-danger', $result->type);
    }
}
