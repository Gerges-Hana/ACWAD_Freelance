<?php

namespace App\Http\Controllers;


use App\Models\Item;
use App\Models\order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ordersController extends Controller
{
  public function index()
  {
    $data = order::where('accept', 0)->get();
    return view('order.index', compact('data'));
  }

  public function accept($id)
  {
    $order = Order::find($id);

    if (!$order) {
      return redirect()->route('orders.index')->with(['error' => 'الطلب غير موجود']);
    }

    $item = Item::find($order->item_id);

    if (!$item || $item->count < $order->count) {
      return redirect()->route('orders.index')->with(['error'  => 'عفوًا، المخزون غير كافٍ']);
    }

    $SERVER_API_KEY = 'AAAApUgU3kk:APA91bF2msVrXgwod4ZkhPcs9yB0JR-ougMNd_qhUaEmKuRmiTM720W7_Y4B3vszsgbyQIdLWuwh6vc7E8ByDKfIKhR1gxBNmCanSSLcjDkA7Smkztxx6ouwbhGvUhYxGBQFmaMbkngG';
    $token = $order->device_key;

    $notification = [
      "title" => 'تنبيه',
      "body" => 'تم اعتماد طلبك بنجاح',
      "sound" => "default", // مطلوب للصوت على نظام iOS
    ];

    $data = [
      "registration_ids" => [$token],
      "notification" => $notification,
    ];

    $response = Http::withHeaders([
      'Authorization' => 'key=' . $SERVER_API_KEY,
      'Content-Type' => 'application/json',
    ])->post('https://fcm.googleapis.com/fcm/send', $data);

    if ($response->successful()) {
      // return [$order, $item];
      $order->accept = 1;
      $item->count -= $order->count;

      $order->save();
      $item->save();

      return redirect()->route('orders.index')->with(['success' => 'تم  الاضافة البيانات بنجاح']);

      // return ['success' => 'تم اعتماد الطلب بنجاح'];
    } else {
      return redirect()->route('orders.index.index')->with(['error' => 'حدث خطأ ما... ']);
    }
  }

  public function unaccepted($id)
  {
    $order = Order::where('id', $id)->first();

    if ($order) {
      $SERVER_API_KEY = 'AAAApUgU3kk:APA91bF2msVrXgwod4ZkhPcs9yB0JR-ougMNd_qhUaEmKuRmiTM720W7_Y4B3vszsgbyQIdLWuwh6vc7E8ByDKfIKhR1gxBNmCanSSLcjDkA7Smkztxx6ouwbhGvUhYxGBQFmaMbkngG';
      $token = $order->device_key;

      $notification = [
        "title" => 'تنبيه',
        "body" => 'تم اعتماد طلبيتك بنجاح',
        "sound" => "default",
      ];

      $data = [
        "registration_ids" => [$token],
        "notification" => $notification,
      ];

      $response = Http::withHeaders([
        'Authorization' => 'key=' . $SERVER_API_KEY,
        'Content-Type' => 'application/json',
      ])->post('https://fcm.googleapis.com/fcm/send', $data);

      $order->accept = 2;
      $order->save();


      return redirect()->route('orders.index')->with(['success' => 'تم رفض الطلب بنجاح']);
    } else {
      return redirect()->route('orders.index.index')->with(['error' => 'الطلب غير موجود']);
    }
  }

  public function update($id, Request $request)
  {
    $request->validate([
      'count' => 'required|numeric',
    ]);

    $order = order::where('id', $id)->first();

    if (!$order) {
      return redirect()->route('orders.index')->with(['error' => 'الطلب غير موجود']);
    }

    $item = Item::find($order->item_id);

    if (!$item || $item->count < $request->count) {
      return redirect()->route('orders.index')->with(['error' => 'عفوًا، المخزون غير كافٍ']);
    }

    $order->update([
      'count' => $request->count,
    ]);

    return redirect()->route('orders.index')->with(['success' => 'تم تحديث البيانات بنجاح']);
  }
}
