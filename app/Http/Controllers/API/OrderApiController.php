<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order;
use App\Models\User;
use App\Notifications\add_orders;
use Illuminate\Support\Facades\Notification;

class OrderApiController extends Controller
{
  public function store(Request $request)
  {
    // التحقق من صحة البيانات المرسلة
    // return response()->json(['message' => 'تم إضافة الطلب بنجاح']);
    // $request->validate([
    //   'user_id' => 'required',
    //   'user_token' => 'required',
    //   'item_id' => 'required',
    //   'currency' => 'required',
    //   'count' => 'required',
    //   'notes' => 'nullable|string',
    //   'accept' => 'required',
    // ]);

    // إنشاء طلب جديد
    $order = order::create([
      'user_id' => $request->user_id,
      'user_token' => $request->user_token,
      'item_id' => $request->item_id,
      'currency' => $request->currency,
      'count' => $request->count,
      'notes' => $request->notes,
      'accept' => $request->accept,
    ]);

    $orders = order::latest()->first();
    $user = User::get();
    Notification::send($user, new add_orders($orders));
    // إرجاع الرد بنجاح مع البيانات الجديدة للطلب
    return response()->json(['message' => 'تم إضافة الطلب بنجاح', 'data' => $order], 201);
  }
}