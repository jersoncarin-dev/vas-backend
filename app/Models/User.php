<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function isAdmin()
    {
        return $this->role === 'ADMIN';
    }

    public function isClient()
    {
        return $this->role === 'CLIENT';
    }

    public function isStaff()
    {
        return $this->role === 'STAFF';
    }
}
