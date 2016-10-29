<?php namespace JobApis\JobsToMail\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function confirm($token = null);

    public function create($data = []);

    public function delete($id = null);

    public function firstOrCreate($data = []);

    public function generateToken($user_id = null, $type = 'confirm');

    public function getById($id = null, $options = []);

    public function getByEmail($email = null, $options = []);

    public function update($id = null, $data = []);
}
