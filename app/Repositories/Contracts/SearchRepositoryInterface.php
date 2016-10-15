<?php namespace JobApis\JobsToMail\Repositories\Contracts;

interface SearchRepositoryInterface
{
    public function create($userId = null, $data = []);

    public function getActive($userEmail = null);
}
