<?php namespace JobApis\JobsToMail\Tests\Integration;

use JobApis\JobsToMail\Models\Search;
use JobApis\JobsToMail\Models\User;
use JobApis\JobsToMail\Tests\TestCase;

class SearchModelTest extends TestCase
{
    public function testItGeneratesIdUponCreation()
    {
        $keyword = $this->faker->word();
        $user_id = User::first()->id;
        $search = Search::create([
            'user_id' => $user_id,
            'keyword' => $keyword,
            'location' => uniqid(),
        ]);
        $this->assertNotNull($search->id);
        $this->assertEquals($keyword, $search->keyword);
        $this->assertEquals($user_id, $search->user_id);
    }

    public function testItCanGetAssociatedModelUser()
    {
        $search = Search::with('user')->first();
        $this->assertEquals($search->user_id, $search->user->id);
    }

    public function testItCanFilterActiveSearchs()
    {
        $searches = Search::active()->get();
        foreach ($searches as $search) {
            $this->assertNotNull($search->user->confirmed_at);
        }
    }

    public function testItCanFilterByUserEmail()
    {
        $email = User::first()->email;
        $searches = Search::whereUserEmail($email)->get();
        foreach ($searches as $search) {
            $this->assertEquals($email, $search->user->email);
        }
    }
}
