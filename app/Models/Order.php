<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'comment',
        'delivery_date',
    ];

    /**
     * Get all orders for admin orders page
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Order::query()->select(
            'orders.*',
            'users.name as courier_name',
            'order_status.title as status'
        )
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->join('order_status', 'orders.order_status_id', '=', 'order_status.id')
            ->get();
    }

    public function find($id): Model|Collection|Builder|array|null
    {
        return Order::query()->select(
                'orders.*',
                'users.name as courier_name',
                'order_status.title as status'
            )
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->join('order_status', 'orders.order_status_id', '=', 'order_status.id')
            ->find($id);
    }

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
