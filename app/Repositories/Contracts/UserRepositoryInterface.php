<?php namespace JobApis\JobsToMail\Repositories\Contracts;

interface UserRepositoryInterface
{
    /**
     * Creates a single new user if data is valid
     *
     * @param $data array
     *
     * @return \JobApis\JobsToMail\Models\User
     */
    public function create($data = []);

    /**
     * Retrieves a single record by ID
     *
     * @param $id string
     * @param $options array
     *
     * @return \JobApis\JobsToMail\Models\User
     */
    public function getById($id = null, $options = []);
}
