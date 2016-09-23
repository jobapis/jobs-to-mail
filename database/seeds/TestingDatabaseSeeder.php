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
        DB::statement('BEGIN;');
        DB::statement('ALTER TABLE tokens DISABLE TRIGGER ALL;');
        DB::statement('TRUNCATE users CASCADE');
        DB::statement('ALTER TABLE tokens ENABLE TRIGGER ALL;');
        DB::statement('COMMIT;');

        $this->createActiveUsers();
        $this->createDeletedUsers();
        $this->createUnconfirmedUsers();
    }

    private function createActiveUsers($num = 25)
    {
        foreach(range(1, $num) as $index)
        {
            $user = User::create([
                'email' => $this->faker->email(),
                'keyword' => $this->faker->word(),
                'location' => $this->faker->sentence(2),
                'confirmed_at' => $this->faker->dateTimeThisYear(),
            ]);
            Token::create([
                'user_id' => $user['id'],
                'type' => 'confirm',
            ]);
        }
    }

    private function createDeletedUsers($num = 25)
    {
        foreach(range(1, $num) as $index)
        {
            $user = User::create([
                'email' => $this->faker->email(),
                'keyword' => $this->faker->word(),
                'location' => $this->faker->sentence(2),
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

    private function createUnconfirmedUsers($num = 25)
    {
        foreach(range(1, $num) as $index)
        {
            $user = User::create([
                'email' => $this->faker->email(),
                'keyword' => $this->faker->word(),
                'location' => $this->faker->sentence(2),
            ]);
            Token::create([
                'user_id' => $user['id'],
                'type' => 'confirm',
            ]);
        }
    }
}
