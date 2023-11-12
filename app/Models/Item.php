<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Item extends Model
{
  use HasFactory;
  protected $table = "items";
  protected $fillable = [
    'name',
    'photo',
    'active',
    'categori_id',
    'gumla_price_tl',
    'gumla_price_usd',
    'count'
  ];
  public function priceCategories()
  {
    return $this->belongsToMany(priceCategori::class, 'price_category_item', 'items_id', 'price_categoris_id')
      ->withPivot('percent');
  }

  public function category()
  {
    return $this->belongsTo('App\Models\ItemCategory', 'categori_id')->onDelete('cascade');
  }
  public function order()
  {
    return $this->hasMany(order::class, 'item_id', 'id');
  }
}
