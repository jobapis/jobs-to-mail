<?php namespace JobApis\JobsToMail\Repositories;

use Carbon\Carbon;
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
     * Confirms a user's email and activates their account.
     *
     * @param $token string
     *
     * @return boolean
     */
    public function confirm($token = null)
    {
        $tokenObject = $this->getUnexpiredConfirmationToken($token);
        if ($tokenObject) {
            if ($this->update($tokenObject->user_id, ['confirmed_at' => Carbon::now()])) {
                return true;
            }
        }
        return false;
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
            $token = $this->generateToken($user->id, config('tokens.types.confirm'));
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
        return $this->users->where('id', $id)->first();
    }

    /**
     * Retrieves all active user accounts
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getConfirmed()
    {
        return $this->users->confirmed()->get();
    }

    /**
     * Update a single user
     *
     * @param $id string
     * @param $data array
     *
     * @return boolean
     */
    public function update($id = null, $data = [])
    {
        return $this->users->where('id', $id)->update($data);
    }

    /**
     * Deletes a user.
     *
     * @param $id string
     *
     * @return boolean
     */
    public function unsubscribe($id = null)
    {
        return $this->users->where('id', $id)->delete();
    }

    /**
     * Get Confirmation Token by token id if not expired
     *
     * @param string $token
     *
     * @return mixed
     */
    private function getUnexpiredConfirmationToken($token = null, $daysToExpire = 30)
    {
        return $this->tokens
            ->where('token', $token)
            ->where('type', config('tokens.types.confirm'))
            ->where('created_at', '>', Carbon::now()->subDays($daysToExpire))
            ->first();
    }

    /**
     * Generates and returns a token for a specific User Id
     *
     * @param null $user_id
     * @param string $type
     *
     * @return Token
     */
    private function generateToken($user_id = null, $type = 'confirm')
    {
        return $this->tokens->create([
            'user_id' => $user_id,
            'type' => $type,
        ]);
    }
}
