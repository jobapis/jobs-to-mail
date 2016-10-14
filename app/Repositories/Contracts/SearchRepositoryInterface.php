<?php namespace JobApis\JobsToMail\Repositories\Contracts;

interface SearchRepositoryInterface
{
    public function create($userId = null, $data = []);
}
