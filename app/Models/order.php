<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
  use HasFactory;
  protected $table = "orders";
  protected $fillable = [
    'user_id', 'user_token',
    'item_id', 'currency', 'count', 'notes', 'accept', 'wait'
  ];

  public function user()
  {
    return $this->belongsTo(User::class ,'user_id','id');
  }
  public function item()
  {
    return $this->belongsTo(Item::class,'item_id','id');
  }
}