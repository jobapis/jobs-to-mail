<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use JobApis\JobsToMail\Models\User;
use JobApis\JobsToMail\Models\Token;
use Illuminate\Support\Facades\DB;

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
        foreach(range(1, $num) as $index)
        {
            $user = User::create([
                'email' => $this->faker->email(),
                'keyword' => $this->faker->word(),
                'location' => $this->faker->word().', '.$this->faker->word(),
                'confirmed_at' => $this->faker->dateTimeThisYear(),
            ]);
            Token::create([
                'user_id' => $user['id'],
                'type' => 'confirm',
            ]);
        }
    }

    private function createDeletedUsers($num = 10)
    {
        foreach(range(1, $num) as $index)
        {
            $user = User::create([
                'email' => $this->faker->email(),
                'keyword' => $this->faker->word(),
                'location' => $this->faker->word().', '.$this->faker->word(),
                'confirmed_at' => $this->faker->dateTimeThisYear(),
                'deleted_at' => $this->faker->dateTimeThisYear(),
            ]);
            Token::create([
                'user_id' => $user['id'],
                'type' => 'confirm',
            ]);
            Token::create([
                'user_id' => $user['id'],
                'type' => 'unsubscribe',
            ]);
        }
    }

    private function createUnconfirmedUsers($num = 10)
    {
        foreach(range(1, $num) as $index)
        {
            $user = User::create([
                'email' => $this->faker->email(),
                'keyword' => $this->faker->word(),
                'location' => $this->faker->word().', '.$this->faker->word(),
            ]);
            Token::create([
                'user_id' => $user['id'],
                'type' => 'confirm',
            ]);
        }
    }
}
