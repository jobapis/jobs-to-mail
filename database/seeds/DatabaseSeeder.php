<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Unlock models
        Model::unguard();
        $this->call(DatabaseTruncater::class);
        $this->call(TestingDatabaseSeeder::class);
        $this->call(RecruiterDatabaseSeeder::class);

    }
}
