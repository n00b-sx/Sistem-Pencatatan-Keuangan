<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id',
        'name',
        'price',
        'qty',
        'subtotal',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
