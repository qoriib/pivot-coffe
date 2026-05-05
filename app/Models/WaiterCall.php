<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaiterCall extends Model
{
    use HasFactory;

    protected $fillable = ['table_id', 'status'];

    public function table()
    {
        return $this->belongsTo(CafeTable::class, 'table_id');
    }
}
