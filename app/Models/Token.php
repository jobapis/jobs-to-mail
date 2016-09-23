<?php namespace JobApis\JobsToMail\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    /**
     * Indicates that the IDs are not auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'token';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = null;

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate a secure random token
            $model->{$model->getKeyName()} = bin2hex(openssl_random_pseudo_bytes(16));
        });
    }

    /**
     * Defines the relationship to User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generates and returns a token for a specific User Id
     *
     * @param null $user_id
     * @param string $type
     *
     * @return Token
     */
    public function generate($user_id = null, $type = 'confirm')
    {
        return $this->create([
            'user_id' => $user_id,
            'type' => $type,
        ]);
    }
}
