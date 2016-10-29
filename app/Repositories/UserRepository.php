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
        if (!$this->getById($token->user_id)->confirmed_at) {
            if ($this->update($token->user_id, ['confirmed_at' => Carbon::now()])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Creates a single new user, generate a token and notify the user.
     *
     * @param $data array
     *
     * @return \JobApis\JobsToMail\Models\User
     */
    public function create($data = [])
    {
        $user = $this->users->create($data);

        $this->sendConfirmationToken($user);

        return $user;
    }

    /**
     * Deletes a user.
     *
     * @param $id string
     *
     * @return boolean
     */
    public function delete($id = null)
    {
        return $this->users->where('id', $id)->delete();
    }

    /**
     * Creates a single new user or returns an existing one by email
     *
     * @param $data array
     *
     * @return \JobApis\JobsToMail\Models\User
     */
    public function firstOrCreate($data = [])
    {
        if ($user = $this->users->where('email', $data['email'])->first()) {
            // Resend the user a confirmation token if they haven't confirmed
            if (!$user->confirmed_at) {
                $this->sendConfirmationToken($user);
            }
            $user->existed = true;
            return $user;
        }
        return $this->create($data);
    }

    /**
     * Generates and returns a token for a specific User Id
     *
     * @param null $user_id
     * @param string $type
     *
     * @return Token
     */
    public function generateToken($user_id = null, $type = 'confirm')
    {
        return $this->tokens->create([
            'user_id' => $user_id,
            'type' => $type,
        ]);
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
     * Retrieves a single record by Email
     *
     * @param $email string
     * @param $options array
     *
     * @return \JobApis\JobsToMail\Models\User
     */
    public function getByEmail($email = null, $options = [])
    {
        return $this->users->where('email', $email)->first();
    }

    /**
     * Get Confirmation Token by token id if not expired
     *
     * @param string $token
     *
     * @return mixed
     */
    public function getToken($token = null, $daysToExpire = 30)
    {
        return $this->tokens
            ->where('token', $token)
            ->where('created_at', '>', Carbon::now()->subDays($daysToExpire))
            ->first();
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
     * Generates a new confirmation token and sends it to the user
     *
     * @param User $user
     *
     * @return Token
     */
    private function sendConfirmationToken(User $user)
    {
        // Create a token
        $token = $this->generateToken($user->id, config('tokens.types.confirm'));
        // Email the token in link to the User
        $user->notify(new TokenGenerated($token));

        return $token;
    }
}
