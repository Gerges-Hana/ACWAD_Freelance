<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sales extends Model
{
  use HasFactory;
  protected $table = "sales";
  protected $fillable = [
    'user_id', 'item_id', 'currency', 'count', 'total', 'active'
  ];
  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function item()
  {
    return $this->belongsTo(Item::class);
  }
}
