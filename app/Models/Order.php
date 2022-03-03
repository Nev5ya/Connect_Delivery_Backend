<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'order_comment',
        'delivery_date',
        'user_id',
    ];

    /**
     * Get all orders for admin orders page
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Order::query()->select('orders.*', 'users.name as courier_name', 'order_status.title as status')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_status', 'orders.order_status_id', '=', 'order_status.id')
            ->get();
    }

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
