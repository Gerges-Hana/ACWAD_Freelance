<?php

namespace App\Http\Controllers;


use App\Models\Item;
use App\Models\outlay;
use App\Models\outlay_categori;
use App\Models\User;
use Carbon\Carbon;

class outlayContoller extends Controller
{
  public function index()
  {

    $data = outlay::all();
    $branch_name = User::where('role', 2)->orderBy('id', 'DESC')->get(['id', 'name']);
    $outlay_categori_name = outlay_categori::where('active', 1)->orderBy('id', 'DESC')->get(['id', 'name']);

    return view('outlay.index', compact('outlay_categori_name', 'branch_name', 'data'));
  }
}