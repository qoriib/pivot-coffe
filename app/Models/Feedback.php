<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = ['order_id', 'rating', 'comment'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
