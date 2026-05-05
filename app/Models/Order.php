<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 'table_id', 'customer_name', 'promo_id',
        'subtotal', 'discount', 'total', 'payment_method',
        'payment_status', 'order_status', 'notes', 'snap_token',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'total'    => 'decimal:2',
        ];
    }

    public function table()
    {
        return $this->belongsTo(CafeTable::class, 'table_id');
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
