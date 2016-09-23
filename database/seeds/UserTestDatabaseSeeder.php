<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use JobApis\JobsToMail\Models\User;
use Illuminate\Support\Facades\DB;

class UserTestDatabaseSeeder extends Seeder
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
    }

    private function createActiveUsers($num = 50)
    {
        foreach(range(1, $num) as $index)
        {
            User::create([
                'id' => $this->faker->uuid(),
                'email' => $this->faker->email(),
                'keyword' => $this->faker->word(),
                'location' => $this->faker->sentence(2),
                'confirmed_at' => $this->faker->dateTimeThisYear(),
            ]);
        }
    }

    private function createDeletedUsers($num = 50)
    {
        foreach(range(1, $num) as $index)
        {
            User::create([
                'id' => $this->faker->uuid(),
                'email' => $this->faker->email(),
                'keyword' => $this->faker->word(),
                'location' => $this->faker->sentence(2),
                'confirmed_at' => $this->faker->dateTimeThisYear(),
                'deleted_at' => $this->faker->dateTimeThisYear(),
            ]);
        }
    }
}
