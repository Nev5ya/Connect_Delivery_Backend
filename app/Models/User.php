<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'coords',
        'user_status_id',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAll(): Collection
    {
        return User::query()->select(
            'users.*',
            'user_status.title as user_status',
            'role.id as role_id',
            'role.title as role_title',
        )
            ->join('role', 'role.id', '=', 'users.role_id')
            ->join('user_status', 'user_status.id', '=', 'users.user_status_id')
            ->where('role_id', '=', 1) //get only couriers
            ->get();
    }

    public function find(int $id): Model|Collection|Builder|array|null
    {
        return User::query()->select(
            'users.*',
            'role.id as role_id',
            'role.title as role_title',
            'user_status.title as user_status',
        )
            ->join('role', 'role.id', '=', 'users.role_id')
            ->join('user_status', 'user_status.id', '=', 'users.user_status_id')
            ->find($id);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'id', 'user_id');
    }
}
