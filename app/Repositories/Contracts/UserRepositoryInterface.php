<?php namespace JobApis\JobsToMail\Repositories\Contracts;

use JobApis\JobsToMail\Models\User;

interface UserRepositoryInterface
{
    public function confirm(User $user);

    public function create($data = []);

    public function delete($id = null);

    public function firstOrCreate($data = []);

    public function generateToken($user_id = null, $type = 'confirm');

    public function getById($id = null, $options = []);

    public function getToken($token = null, $daysToExpire = 30);

    public function getByEmail($email = null, $options = []);

    public function update($id = null, $data = []);
}
