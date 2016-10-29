<?php namespace JobApis\JobsToMail\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function confirm($token = null);

    public function create($data = []);

    public function delete($id = null);

    public function firstOrCreate($data = []);

    public function getById($id = null, $options = []);

    public function getByEmail($email = null, $options = []);

    public function update($id = null, $data = []);
}
