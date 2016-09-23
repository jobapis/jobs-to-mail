<?php namespace JobApis\JobsToMail\Repositories;

use JobApis\JobsToMail\Models\Token;
use JobApis\JobsToMail\Models\User;
use JobApis\JobsToMail\Notifications\TokenGenerated;

class UserRepository implements Contracts\UserRepositoryInterface
{
    /**
     * @var Token model
     */
    public $tokens;

    /**
     * @var User model
     */
    public $users;

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $users, Token $tokens)
    {
        $this->users = $users;
        $this->tokens = $tokens;
    }

    /**
     * Creates a single new user if data is valid
     *
     * @param $data array
     *
     * @return \JobApis\JobsToMail\Models\User
     */
    public function create($data = [])
    {
        // Create the user
        if ($user = $this->users->create($data)) {
            // Create a token
            $token = $this->tokens->generate($user->id, config('tokens.types.confirm'));
            // Email the token in link to the User
            $user->notify(new TokenGenerated($token));
        }
        return $user;
    }

    /**
     * Retrieves a single record by ID
     *
     * @param $id string
     * @param $options array
     *
     * @return \JobApis\JobsToMail\Models\User
     */
    public function getById($id = null, $options = [])
    {
        return $this->model->where('id', $id)->first();
    }
}
