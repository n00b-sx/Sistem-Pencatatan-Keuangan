<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['name', 'initial_balance', 'logo'];

    public function sourceTransactions()
    {
        return $this->hasMany(Transaction::class, 'source_account_id');
    }

    public function destinationTransactions()
    {
        return $this->hasMany(Transaction::class, 'destination_account_id');
    }
}
