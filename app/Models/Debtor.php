<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debtor extends Model
{
    use HasFactory;
    protected $table = "debtors";
    protected $fillable = [
        'name',
        'id_number',
        'total_debtor_box_tl',
        'total_debtor_box_usd',
    ];
}
