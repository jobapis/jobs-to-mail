<?php namespace JobApis\JobsToMail\Tests\Integration;

use JobApis\JobsToMail\Tests\TestCase;
use JobApis\JobsToMail\Models\User;

class UserModelTest extends TestCase
{
    public function testItGeneratesUuidUponCreation()
    {
        $email = $this->faker->email();
        $user = User::create([
            'email' => $email,
            'keyword' => uniqid(),
            'location' => uniqid(),
        ]);
        $this->assertNotNull($user->id);
        $this->assertEquals($email, $user->email);
    }

    public function testItCanGetAssociatedModelSearch()
    {
        $user = User::with('searches')->first();
        foreach ($user->searches as $search) {
            $this->assertEquals($search->user_id, $user->id);
        }
    }

    public function testItCanGetAssociatedModelToken()
    {
        $user = User::with('tokens')->first();
        foreach ($user->tokens as $token) {
            $this->assertEquals($token->user_id, $user->id);
        }
    }

    public function testItCanFilterConfirmedUsers()
    {
        $users = User::confirmed()->get();
        foreach ($users as $user) {
            $this->assertNotNull($user->confirmed_at);
        }
    }

    public function testItCanFilterUnconfirmedUsers()
    {
        $users = User::unconfirmed()->get();
        foreach ($users as $user) {
            $this->assertNull($user->confirmed_at);
        }
    }

    public function testItCanGetMaximumSearchesWhenUserHasMax()
    {
        $user = User::whereNotNull('max_searches')->first();
        $this->assertGreaterThanOrEqual(config('app.max_searches'), $user->max_searches);
    }

    public function testItCanGetMaximumSearchesWhenUserHasNoMax()
    {
        $user = User::whereNull('max_searches')->first();
        $this->assertEquals(config('app.max_searches'), $user->max_searches);
    }
}
