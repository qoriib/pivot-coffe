<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class CafeTable extends Model
{
    use HasFactory;

    protected $table = 'cafe_tables';

    protected $fillable = ['number', 'qr_token'];

    protected static function booted(): void
    {
        static::creating(function (CafeTable $table) {
            if (empty($table->qr_token)) {
                $table->qr_token = Str::uuid()->toString();
            }
        });
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'table_id');
    }

    public function waiterCalls()
    {
        return $this->hasMany(WaiterCall::class, 'table_id');
    }
}
