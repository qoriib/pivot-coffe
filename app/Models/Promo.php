<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'description', 'discount_type',
        'discount_value', 'is_active', 'valid_from', 'valid_until',
    ];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'is_active'      => 'boolean',
            'valid_from'     => 'date',
            'valid_until'    => 'date',
        ];
    }

    public function isValid(): bool
    {
        $today = Carbon::today();
        return $this->is_active
            && $today->greaterThanOrEqualTo($this->valid_from)
            && $today->lessThanOrEqualTo($this->valid_until);
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($this->discount_type === 'percent') {
            return round($subtotal * ($this->discount_value / 100), 2);
        }
        return min((float) $this->discount_value, $subtotal);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
