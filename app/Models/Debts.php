<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debts extends Model
{
    use HasFactory;
    protected $table = "debts";
    protected $fillable = [
        'debtor_id',
        'item_id',
        'user_id',
        'count',
        'paid',
        'price_tl',
        'price_usd',
    ];
}
