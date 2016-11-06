<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use JobApis\JobsToMail\Models\User;
use JobApis\JobsToMail\Models\CustomDatabaseNotification as Notification;
use JobApis\JobsToMail\Models\Search;
use JobApis\JobsToMail\Models\Token;

class TestingDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->faker = Faker::create();
        $this->createActiveUsers();
        $this->createPremiumUsers();
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
            })->each(function(User $user) { // Create searches
                factory(Search::class, rand(1, 3))->create([
                    'user_id' => $user->id
                    ])->each(function(Search $search) { // Create notifications
                        factory(Notification::class, rand(1, 3))->create([
                            'notifiable_id' => $search->user_id,
                            'search_id' => $search->id,
                        ]);
                    });
            });
    }

    private function createPremiumUsers($num = 2)
    {
        return factory(User::class, $num)
            ->states('active', 'premium')
            ->create()
            ->each(function(User $user) {
                $user->tokens()->save(
                    factory(Token::class)->make()
                );
            })->each(function(User $user) { // Create searches
                factory(Search::class, rand(2, 10))->create([
                    'user_id' => $user->id
                ])->each(function(Search $search) { // Create notifications
                    factory(Notification::class, rand(1, 3))->create([
                        'notifiable_id' => $search->user_id,
                        'search_id' => $search->id,
                    ]);
                });
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
