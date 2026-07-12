<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'date', 'type', 'allocation', 'category_id', 'source_account_id', 
        'destination_account_id', 'amount', 'discount', 'related_party', 'description', 
        'receipt_path'
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sourceAccount()
    {
        return $this->belongsTo(Account::class, 'source_account_id');
    }

    public function destinationAccount()
    {
        return $this->belongsTo(Account::class, 'destination_account_id');
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
