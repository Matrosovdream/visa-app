<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

 
    // Get roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    // Check if user has role admin
    public function isAdmin()
    {
        return $this->roles()->where('slug', 'admin')->exists();
    }

    // Check if user has role manager
    public function isManager()
    {
        return $this->roles()->where('slug', 'manager')->exists();
    }

    // Get the user role
    public function getRole()
    {
        return $this->roles()->first();
    }

    // Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
