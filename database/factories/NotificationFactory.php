<?php

/*
|--------------------------------------------------------------------------
| Notification Factory
|--------------------------------------------------------------------------
*/
$notificationClass = \JobApis\JobsToMail\Models\CustomDatabaseNotification::class;
$dataJson = json_decode('[{"url":"http://example.com/","name":"Technical Workforce Recruiter","query":"DevOps","title":"Technical Workforce Recruiter","skills":null,"source":"Careerjet","company":"AE Business Solutions","endDate":null,"industry":null,"location":"Madison, WI","sourceId":null,"startDate":null,"workHours":null,"baseSalary":null,"datePosted":"2017-12-22","description":" to Have:   Bachelors degree or higher.  Experience recruiting candidates with technical skill sets such as Cloud Architects","jobBenefits":null,"jobLocation":null,"alternateName":null,"maximumSalary":null,"minimumSalary":null,"employmentType":null,"qualifications":null,"salaryCurrency":null,"javascriptAction":null,"responsibilities":null,"hiringOrganization":{"url":null,"logo":null,"name":"AE Business Solutions","email":null,"address":null,"telephone":null,"description":null,"alternateName":null},"javascriptFunction":null,"specialCommitments":null,"occupationalCategory":null,"educationRequirements":null,"incentiveCompensation":null,"experienceRequirements":null}]');

$factory->define($notificationClass, function (Faker\Generator $faker) use ($dataJson) {
    return [
        'id' => $faker->uuid(),
        'type' => 'JobApis\JobsToMail\Notifications\JobsCollected',
        'notifiable_id' => null,
        'notifiable_type' => 'user',
        'data' => $dataJson,
        'read_at' => null,
    ];
});
