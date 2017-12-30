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
     * Gets the user's maximum number of allowed searches
     *
     * @return int
     */
    public function getMaxSearchesAttribute($value): int
    {
        return $value ?? (int) config('app.max_searches');
    }

    /**
     * Defines the relationship to Search model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function searches()
    {
        return $this->hasMany(Search::class);
    }

    /**
     * Defines the relationship to Token model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    /**
     * Limits query to "confirmed" users
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConfirmed($query)
    {
        return $query->whereNotNull('confirmed_at');
    }

    /**
     * Limits query to "unconfirmed" users
     *
     * @param $query \Illuminate\Database\Eloquent\Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnconfirmed($query)
    {
        return $query->whereNull('confirmed_at');
    }

    /**
     * Defines the relationship to Notification model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(CustomDatabaseNotification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }
}
