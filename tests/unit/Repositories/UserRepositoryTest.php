<?php namespace JobApis\JobsToMail\Tests\Unit\Notifications;

use Carbon\Carbon;
use Mockery as m;
use JobApis\JobsToMail\Repositories\UserRepository;
use JobApis\JobsToMail\Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->users = m::mock('JobApis\JobsToMail\Models\User');
        $this->tokens = m::mock('JobApis\JobsToMail\Models\Token');
        $this->repository = new UserRepository($this->users, $this->tokens);
    }

    public function testItCanConfirmUnconfirmedUserFromToken()
    {
        $token = m::mock('JobApis\JobsToMail\Models\Token');
        $user = m::mock('JobApis\JobsToMail\Models\User');

        $token->shouldReceive('getAttribute')
            ->with('user')
            ->twice()
            ->andReturn($user);
        $user->shouldReceive('getAttribute')
            ->with('confirmed_at')
            ->once()
            ->andReturn(false);
        $user->shouldReceive('update')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->repository->confirm($token));
    }

    public function testItWillSkipConfirmedUser()
    {
        $token = m::mock('JobApis\JobsToMail\Models\Token');
        $user = m::mock('JobApis\JobsToMail\Models\User');

        $token->shouldReceive('getAttribute')
            ->with('user')
            ->once()
            ->andReturn($user);
        $user->shouldReceive('getAttribute')
            ->with('confirmed_at')
            ->once()
            ->andReturn(true);

        $this->assertFalse($this->repository->confirm($token));
    }

    public function testItCanCreateUserAndToken()
    {
        $data = [
            'email' => $this->faker->email(),
            'keyword' => uniqid(),
            'location' => uniqid(),
        ];
        $user_id = uniqid();

        $this->users->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('getAttribute')
            ->with('id')
            ->once()
            ->andReturn($user_id);
        $this->tokens->shouldReceive('create')
            ->with(['user_id' => $user_id, 'type' => 'confirm'])
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('notify')
            ->once()
            ->andReturnSelf();

        $result = $this->repository->create($data);

        $this->assertEquals($this->users, $result);
    }

    public function testItCanGetFirstOrCreateWhenUserExistsAndIsConfirmed()
    {
        $data = [
            'email' => $this->faker->email(),
            'keyword' => uniqid(),
            'location' => uniqid(),
        ];
        $user = m::mock('JobApis\JobsToMail\Models\User');

        $this->users->shouldReceive('where')
            ->with('email', $data['email'])
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('first')
            ->once()
            ->andReturn($user);
        $user->shouldReceive('getAttribute')
            ->with('confirmed_at')
            ->andReturn(Carbon::now()->format('Y-m-d H:i:s'));
        $user->shouldReceive('setAttribute')
            ->with('existed', true)
            ->andReturnSelf();

        $result = $this->repository->firstOrCreate($data);

        $this->assertEquals($user, $result);
    }

    public function testItCanGetFirstOrCreateWhenUserExistsAndIsNotConfirmed()
    {
        $data = [
            'email' => $this->faker->email(),
        ];
        $user_id = uniqid();
        $user = m::mock('JobApis\JobsToMail\Models\User');

        $this->users->shouldReceive('where')
            ->with('email', $data['email'])
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('first')
            ->once()
            ->andReturn($user);
        $user->shouldReceive('getAttribute')
            ->with('confirmed_at')
            ->andReturnNull();
        $user->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($user_id);
        $this->tokens->shouldReceive('create')
            ->with(['user_id' => $user_id, 'type' => 'confirm'])
            ->once()
            ->andReturnSelf();
        $user->shouldReceive('notify')
            ->once()
            ->andReturnSelf();
        $user->shouldReceive('setAttribute')
            ->with('existed', true)
            ->andReturnSelf();

        $result = $this->repository->firstOrCreate($data);

        $this->assertEquals($user, $result);
    }

    public function testItCanGetFirstOrCreateWhenUserNotExists()
    {
        $data = [
            'email' => $this->faker->email(),
        ];

        $this->users->shouldReceive('where')
            ->with('email', $data['email'])
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('first')
            ->once()
            ->andReturn(null);

        $user_id = uniqid();

        $this->users->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('getAttribute')
            ->with('id')
            ->once()
            ->andReturn($user_id);
        $this->tokens->shouldReceive('create')
            ->with(['user_id' => $user_id, 'type' => 'confirm'])
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('notify')
            ->once()
            ->andReturnSelf();

        $result = $this->repository->firstOrCreate($data);

        $this->assertEquals($this->users, $result);
    }

    public function testItCanGetUserByEmail()
    {
        $email = uniqid();

        $this->users->shouldReceive('where')
            ->with('email', $email)
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('first')
            ->once()
            ->andReturnSelf();

        $result = $this->repository->getByEmail($email);

        $this->assertEquals($this->users, $result);
    }

    public function testItCanGetUserById()
    {
        $id = uniqid();

        $this->users->shouldReceive('where')
            ->with('id', $id)
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('first')
            ->once()
            ->andReturnSelf();

        $result = $this->repository->getById($id);

        $this->assertEquals($this->users, $result);
    }

    public function testItCanGetToken()
    {
        $token = uniqid();
        $days = rand(1, 20);

        $this->tokens->shouldReceive('where')
            ->with('token', $token)
            ->once()
            ->andReturnSelf();
        $this->tokens->shouldReceive('where')
            ->once()
            ->andReturnSelf();
        $this->tokens->shouldReceive('first')
            ->once()
            ->andReturnSelf();

        $result = $this->repository->getToken($token, $days);

        $this->assertEquals($this->tokens, $result);
    }

    public function testItCanDeleteUser()
    {
        $id = uniqid();
        $this->users->shouldReceive('where')
            ->with('id', $id)
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('delete')
            ->once()
            ->andReturn(true);
        $this->assertTrue($this->repository->delete($id));
    }

    public function testItCanUpdateUser()
    {
        $input = [uniqid() => uniqid()];
        $id = uniqid();
        $this->users->shouldReceive('where')
            ->with('id', $id)
            ->once()
            ->andReturnSelf();
        $this->users->shouldReceive('update')
            ->with($input)
            ->once()
            ->andReturn(true);
        $this->assertTrue($this->repository->update($id, $input));
    }
}
