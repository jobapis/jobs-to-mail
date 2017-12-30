<?php

use Illuminate\Database\Seeder;
use JobApis\JobsToMail\Models\Recruiter;

class RecruiterDatabaseSeeder extends Seeder
{
    public function run()
    {
        $csv = League\Csv\Reader::createFromPath(__DIR__.'/recruiters.csv');
        foreach($csv as $recruiter) {
            Recruiter::create([
                'name' => $recruiter[0],
            ]);
        }
    }
}
