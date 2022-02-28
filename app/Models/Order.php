<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'order_comment',
        'delivery_date',
        'courier_ID',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
