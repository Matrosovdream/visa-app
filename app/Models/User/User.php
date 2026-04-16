<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Order\Order;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected static function newFactory()
    {
        return \Database\Factories\UserFactory::new();
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'pin',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'pin',
        'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function isAdmin()
    {
        return $this->roles()->where('slug', 'admin')->exists();
    }

    public function isManager()
    {
        return $this->roles()->where('slug', 'manager')->exists();
    }

    public function isUser()
    {
        return $this->roles()->where('slug', 'user')->exists();
    }

    public function getRole()
    {
        return $this->roles()->first();
    }

    public function hasRole($roles)
    {
        return $this->roles()->whereIn('slug', $roles)->exists();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function setRole($role_slug)
    {
        $role = Role::where('slug', $role_slug)->first();
        if (!$role) { return false; }
        return $this->roles()->sync($role->id);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'pin' => 'hashed',
        ];
    }
}
