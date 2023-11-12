<?php

namespace App\Http\Controllers;


use App\Models\Item;
use App\Models\sales;
use App\Models\User;
use Carbon\Carbon;

class salesController extends Controller
{
  public function index()
  {


    $data = Sales::select('*')
      // ->where('user_id', $id)
      ->where('active', 1)
      ->orderBy('id', 'DESC')->get();
    // return $dataofsalesOnDay;
    $total_sales_tl = Sales::where('active', 1)->where('currency', 1)->sum('total');
    $total_sales_usd = Sales::where('active', 1)->where('currency', 2)->sum('total');
    // if ($data) {
    //   foreach ($data as $info) {
    //     if ($info->currency == 2) {
    //       $total_sales_tl += $info->total;
    //     } elseif ($info->currency == 1) {
    //       $total_sales_usd += $info->total;
    //     }
    //   }
    // }
    return view('sales.index', compact('total_sales_usd', 'total_sales_tl',  'data'));
  }
}