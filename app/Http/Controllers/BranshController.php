<?php

namespace App\Http\Controllers;

use App\Models\User;
use Artisan;
use Illuminate\Http\Request;
use App\Http\Requests\branchRequest;
use App\Http\Requests\editBranchRequest;
use App\Models\Debts;
use App\Models\priceCategori;
use App\Models\inventory;
use App\Models\Item;
use App\Models\order;
use App\Models\sales;
use App\Models\outlay;
use App\Http\Controllers\Controller;

use DateTime;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class BranshController extends Controller
{
  // public function index()
  // {
  //   $data = User::where('role', 2)->get();
  //   return view('branch.index', compact('data'));
  // }
  public function index()
  {

    $data = User::where('role', 2)->get();

    return view('branch.index', compact('data'));
  }


  public function show($id)
  {
    $data = User::select('*')->where(['id' => $id, 'role' => 2])->first();
    // الطلبات
    $orders = Order::select('*')
      ->where('user_id', $id)
      // ->where('accept', 1)
      ->orderBy('id', 'DESC')->get();

    // المخزن
    $inventory = inventory::select('*')
      ->where('user_id', $data->id)
      ->orderBy('id', 'DESC')->get();



    // المصاريف
    $outlays_total_tl = 0;
    $outlays_total_usd = 0;
    $outlay = Outlay::select('*')
      ->where('user_id', $id)->orderBy('id', 'DESC')->get();
    if ($outlay) {
      foreach ($outlay as $info) {
        if ($info->currency == 2) {
          $outlays_total_tl += $info->total;
        } elseif ($info->currency == 1) {
          $outlays_total_usd += $info->total;
        }
      }
    }


    // المبيعات لهذا اليوم
    $dataofsalesOnDay = Sales::select('*')
      ->where('user_id', $id)
      ->where('active', 1)
      ->orderBy('id', 'DESC')->get();
    // return $dataofsalesOnDay;
    $total_sales_tl = 0;
    $total_sales_usd = 0;
    if ($dataofsalesOnDay) {
      foreach ($dataofsalesOnDay as $info) {
        if ($info->currency == 2) {
          $total_sales_tl += $info->total;
        } elseif ($info->currency == 1) {
          $total_sales_usd += $info->total;
        }
      }
    }
    // صندوق admin
    $adminTL = $data->boxTl;
    $adminUSD = $data->boxUsd;
    // المخزن
    $totalPriceTL = inventory::where('id', $data->id)->sum('price_tl');
    $totalPriceUSD = inventory::where('id', $data->id)->sum('price_usd');
    // الداين
    $totalDebtsTL = Debts::where('id', $data->id)->sum('price_tl');
    $totalDebtsUSD = Debts::where('id', $data->id)->sum('price_usd');

    // المبيعات
    // $total_sales_tl = 0;
    // $total_sales_usd = 0;
    // // المصاريف
    // $outlays_total_tl = 0;
    // $outlays_total_usd = 0;

    $TotalTL = ($adminTL + $totalPriceTL + $totalDebtsTL + $total_sales_tl - $outlays_total_tl);
    $TotalUSD = ($adminUSD + $totalPriceUSD + $totalDebtsUSD + $total_sales_usd - $outlays_total_usd);

    return view('branch.show', [
      'data' => $data,
      'TotalTL' => $TotalTL,
      'TotalUSD' => $TotalUSD,
      'totalDebtsTL' =>  $totalDebtsTL,
      'totalDebtsUSD' => $totalDebtsUSD,
      'totalPriceUSD' => $totalPriceUSD,
      'totalPriceTL' => $totalPriceTL,
      'inventory' => $inventory,
      'dataofsalesOnDay' => $dataofsalesOnDay,
      'orders' => $orders,
      'outlay' => $outlay,
      'outlays_total_tl' => $outlays_total_tl,
      'outlays_total_usd' => $outlays_total_usd,
      'total_sales_tl' => $total_sales_tl,
      'total_sales_usd' => $total_sales_usd
    ]);
  }

  public function create()
  {
    $price_categorie_name = priceCategori::where('active', 1)
      ->orderBy('id', 'DESC')
      ->get(['id', 'name']);

    return view('branch.create', compact('price_categorie_name'));
  }

  public function store(Request $request)
  {



    // العثور على أخر حساب متاح
    $lastUser = User::where('role', 2)->orderBy('id', 'desc')->first();
    $data_insert = [];

    if ($lastUser) {
      $data_insert['account_number'] = $lastUser->account_number + 1;
    } else {
      $data_insert['account_number'] = 1;
    }

    // التحقق من وجود اسم الفرع مسبقًا
    $nameExists = User::where(['name' => $request->name, 'role' => 2])->first();
    if ($nameExists) {
      return redirect()->back()->with(['error' => 'عفوا، اسم الفرع موجود بالفعل'])->withInput();
    }
    // إنشاء توكن عشوائي فريد
    $uniqueToken = Str::random(60);
    while (User::where('remember_token', $uniqueToken)->exists()) {
      $uniqueToken = Str::random(60);
    }

    // إنشاء السجل الجديد
    $data_insert = array_merge($data_insert, [
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'role' => 2,
      'outlay' => 0,
      'invantory' => 0,
      'salary' => 0,
      'phone' => $request->phone,
      'address' => $request->address,
      'boxTl' => 0,
      'boxUsd' => 0,
      'remember_token' => $uniqueToken,
    ]);

    User::create($data_insert);

    return redirect()->route('branch.index')->with(['success' => 'تم اضافه  الفرع بنجاح']);
  }
  public function edit($id)
  {
    $data = User::where('id', $id)->first();
    // get_cols_where_row(new User(), array("*"), array('id' => $id));
    $price_categorie_name = priceCategori::where('active', 1)
      ->orderBy('id', 'DESC')->get();

    return view(
      'branch.edit',
      [
        'data' => $data, 'price_categorie_name' => $price_categorie_name
      ]
    );
  }


  public function update($id, Request $request)
  {
    // $validator = Validator::make($request->all(), [
    //   'name' => 'required|min:3|max:255|unique:users',
    //   'email' => 'required|email|unique:users',

    // ], [
    //   'name.required' => 'حقل الاسم مطلوب',
    //   'name.min' => 'الاسم يجب أن يحتوي على 3 أحرف على الأقل',
    //   'name.max' => 'الاسم لا يمكن أن يتجاوز 255 حرفًا',
    //   'name.unique' => 'هذا الاسم موجود بالفعل',

    //   'email.required' => 'حقل الايميل مطلوب',
    //   'email.email' => 'لابد ان يكون ايميل صحيح ',
    //   'email.unique' => 'هذا الايميل موجود بالفعل',

    // ]);

    // if ($validator->fails()) {
    //   return redirect()->back()
    //     ->withErrors($validator)
    //     ->withInput();
    // }

    $data = User::where('id', $id)->first();

    if (empty($data)) {
      return redirect()->back()->with(['error' => 'لا يمكن الوصول إلى البيانات المطلوبة!'])->withInput();
    }

    $nameExists = User::where(['name' => $request->name, 'role' => 2])->where('id', '!=', $id)->first();

    if ($nameExists == null) {
      $data_to_update['name'] = $request->name;
      $data_to_update['email'] = $request->email;
      $data_to_update['password'] = $request->password ? bcrypt($request->password) : $data->password;
      $data_to_update['account_number'] = $data->account_number;
      $data_to_update['role'] = 2;
      $data_to_update['phone'] = $request->phone;
      $data_to_update['address'] = $request->address;
      // $data_to_update['price_categori'] = $request->price_categori;
      $data_to_update['updated_at'] = now();

      User::where(['id' => $id, 'role' => 2])->update($data_to_update);

      return redirect()->route('branch.index')->with(['success' => 'تم تعديل البيانات بنجاح']);
    } else {
      return redirect()->back()->with(['error' => 'عفوًا، اسم الفرع موجود بالفعل'])->withInput();
    }
  }



  public function orders($id)
  {
    $data = order::select("*")
      ->where('created_at', '>', Carbon::now()->subDays(7))
      ->where('id', $id, 'accept', 1)
      ->orderby('id', 'DESC')->paginate(PAGINATION_COUNT);
    if (!empty($data)) {
      foreach ($data as $info) {
        $info->branch_name =
          get_field_value(
            new User(),
            'name',
            array('id' => $info->user_id)
          );
        $info->item_name =
          get_field_value(
            new Item(),
            'name',
            array('id' => $info->item_id)
          );
      }
    }
    $branch_name = get_cols_where(
      new User(),
      array('id', 'name'),
      array('role' => 2),
      'id',
      'DESC'
    );
    $item_name = get_cols_where(
      new Item(),
      array('id', 'name'),
      array('active' => 1),
      'id',
      'DESC'
    );
    return view(
      'order.index',
      [
        'data' => $data,
        'branch_name' => $branch_name,
        'item_name' => $item_name
      ]
    );
  }





  function bayout($id)
  {
    try {
      // جلب وتحديث الطلبات (orders)
      $orders = DB::table('orders')
        ->where('user_id', $id)
        ->where('accept', 1)
        ->get();

      if (!$orders->isEmpty()) {
        foreach ($orders as $order) {
          DB::table('orders')
            ->where('id', $order->id)
            ->update(['accept' => 4]);
        }
      }

      // جلب وتحديث المبيعات (sales)
      $sales = DB::table('sales')
        ->where('user_id', $id)
        ->where('active', 1)
        ->get();

      if (!$sales->isEmpty()) {
        foreach ($sales as $sale) {
          DB::table('sales')
            ->where('id', $sale->id)
            ->update(['active' => 4]);
        }
      }

      // جلب وتحديث النفقات (outlays)
      $outlays = DB::table('outlays')
        ->where('user_id', $id)
        ->where('active', 1)
        ->get();

      if (!$outlays->isEmpty()) {
        foreach ($outlays as $outlay) {
          DB::table('outlays')
            ->where('id', $outlay->id)
            ->update(['active' => 4]);
        }
      }

      return redirect()->back()->with(['success' => 'تم بدأ يوم جديد بنجاح']);
    } catch (QueryException $ex) {
      return redirect()->back()->with(['error' => 'حدث خطأ ما: ' . $ex->getMessage()]);
    } catch (\Exception $ex) {
      return redirect()->back()->with(['error' => 'حدث خطأ ما: ' . $ex->getMessage()]);
    }
  }




  public function delete($id)
  {
    $user = User::find($id);

    if ($user) {


      if ($user->inventories()->count() > 0) {
        return back()->with(['error' => 'لا يمكن حذف هذه الفئة لأنها تحتوي على مخزون مرتبط']);
      }
      if ($user->outlay()->count() > 0) {
        return back()->with(['error' => 'لا يمكن حذف هذه الفئة لأنها تحتوي على مصاريف مرتبطة']);
      }
      if ($user->debts()->count() > 0) {
        return back()->with(['error' => 'لا يمكن حذف هذه الفئة لأنها تحتوي على مديونيه مرتبطة']);
      }
      if ($user->orders()->count() > 0) {
        return back()->with(['error' => 'لا يمكن حذف هذه الفئة لأنها تحتوي على طلبيات مرتبطة']);
      }


      $user->delete();
      return redirect()->route('branch.index')->with('success', 'تم حذف المستخدم بنجاح');
    } else {
      return redirect()->route('branch.index')->with('error', 'المستخدم غير موجود');
    }
  }
}
