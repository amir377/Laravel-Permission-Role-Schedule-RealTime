<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    **/
    protected $guarded = [
        'id',
    ];


    /**
    * Schedule Status Const
    **/
    const STATUS_ALLOW = 1;
    const STATUS_WAITING_CONFIRMATION = 2;
    const STATUS_DENIED = 3;

    const STATUS_ALL = [
        self::STATUS_ALLOW => 'allow',
        self::STATUS_WAITING_CONFIRMATION => 'waiting_confirmation',
        self::STATUS_DENIED => 'denied',
    ];


    /**
    * Get User That Are Assigned This Schedule.
    **/
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
