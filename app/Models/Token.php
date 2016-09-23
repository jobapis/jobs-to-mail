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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
