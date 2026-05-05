<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public static array $roles = [
        'superadmin' => 'Super Admin',
        'admin'      => 'Admin',
        'kasir'      => 'Kasir',
    ];

    public function getRoleLabelAttribute(): string
    {
        return self::$roles[$this->role] ?? $this->role;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }
}
