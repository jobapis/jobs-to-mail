<?php namespace JobApis\JobsToMail\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
    ];

    /**
     * Indicates that the IDs are not auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
