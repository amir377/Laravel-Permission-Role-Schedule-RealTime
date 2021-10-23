<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
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

    const ROLE_ADMIN = 1;
    const ROLE_WORKER = 2;
    const ROLE_NAMES = [
        Role::ROLE_ADMIN => 'admin',
        Role::ROLE_WORKER => 'worker',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
