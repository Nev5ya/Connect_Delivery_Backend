<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAll(): array|Collection
    {
        return User::query()->select(
            'users.id',
            'users.name',
            'users.email',
            'users.user_status_id',
            'user_status.title as user_status',
            'users.coords',
            'users.created_at',
            'role.id as role_id',
            'role.title as role_title',
        )
            ->join('role', 'role.id', '=', 'users.role_id')
            ->join('user_status', 'user_status.id', '=', 'users.user_status_id')
            ->get();
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
