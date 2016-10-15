<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use JobApis\JobsToMail\Models\User;
use JobApis\JobsToMail\Models\Search;
use JobApis\JobsToMail\Models\Token;

class TestingDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->faker = Faker::create();
        $this->createActiveUsers();
        $this->createDeletedUsers();
        $this->createUnconfirmedUsers();
    }

    private function createActiveUsers($num = 10)
    {
        return factory(User::class, $num)
            ->states('active')
            ->create()
            ->each(function(User $user) {
                $user->tokens()->save(
                    factory(Token::class)->make()
                );
            })->each(function(User $user) {
                factory(Search::class, rand(1, 3))->create([
                    'user_id' => $user->id
                ]);
            });
    }

    private function createDeletedUsers($num = 10)
    {
        return factory(User::class, $num)
            ->states('active', 'deleted')
            ->create()
            ->each(function(User $user) {
                $user->tokens()->save(
                    factory(Token::class)->make()
                );
            });
    }

    private function createUnconfirmedUsers($num = 10)
    {
        return factory(User::class, $num)
            ->create()
            ->each(function(User $user) {
                $user->tokens()->save(
                    factory(Token::class)->make()
                );
            });
    }
}
