<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
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

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
