<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';

    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];
    protected function casts(): array { return ['email_verified_at' => 'datetime', 'password' => 'hashed']; }

    public function orders(): HasMany { return $this->hasMany(Order::class); }
    public function cartItems(): HasMany { return $this->hasMany(CartItem::class); }
    public function wishlist(): BelongsToMany { return $this->belongsToMany(Product::class)->withTimestamps(); }
    public function isAdmin(): bool { return $this->role === self::ROLE_ADMIN; }
}
