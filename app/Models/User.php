<?php namespace JobApis\JobsToMail\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class User extends Model
{
    use Notifiable, SoftDeletes;

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
        'email',
        'keyword',
        'location',
    ];

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4();
        });
    }

    /**
     * Defines the relationship to Token model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tokens()
    {
        return $this->hasMany(Token::class);
    }
}
