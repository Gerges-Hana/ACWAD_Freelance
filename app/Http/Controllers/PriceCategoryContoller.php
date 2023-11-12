<?php

namespace App\Http\Controllers;


use App\Models\Item;
use App\Models\priceCategori;

use App\Models\PriceCategoryItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PriceCategoryContoller extends Controller
{
  public function index()
  {
    $data = priceCategori::with('items')->get();
    // return $date;
    return view('price_category.index', compact('data'));
  }

  public function create()
  {
    $items = Item::all();
    $branches = User::where('role', 2)->get();
    return view('price_category.create', compact('items', 'branches'));
  }

  public function store(Request $request)
  {
    // return  $request;
    // $rules = [
    //   'price_name' => 'required|unique:price_categoris,name|max:255',
    //   'active' => 'required|boolean',
    //   'percent' => ['required', 'integer'], // القيمة مطلوبة ويجب أن تكون صحيحة

    // ];

    // $messages = [
    //   'price_name.required' => 'حقل الاسم مطلوب.',
    //   'price_name.unique' => 'عذرًا، هذا الاسم موجود بالفعل.',
    //   'price_name.max' => 'الحد الأقصى للأحرف المسموح به هو :max أحرف.',
    //   'active.required' => 'حقل النشاط مطلوب.',
    //   'active.boolean' => 'حقل النشاط يجب أن يكون قيمة منطقية.',

    // ];
    // $validator = Validator::make($request->all(), $rules, $messages);
    // return $validator;
    // $request->validate($rules, $messages);
    // if ($validator->fails()) {
    //   return redirect()->back()
    //     ->withErrors($validator)
    //     ->withInput();
    // }
    $name_Exisets = priceCategori::where(['name' => $request->price_name, 'active' => 1])->first();
    if (!$name_Exisets) {

      $items_count = Item::count();
      $branchs_count = User::where('role', 2)->count();
      priceCategori::create([
        'name' => $request->input('price_name'),
        "active" => $request->input('active'),
      ]);
      $priceCategori = priceCategori::latest('id')->first();
      // return $priceCategori->id;
      for ($i = 0; $i <= $items_count; $i++) {
        // $request->validate([
        //   "percent_" . $i => ['required', 'integer'],
        // ]);

        if ($request->input('name_' . $i) && $request->input('percent_' . $i) != null) {


          PriceCategoryItem::create([
            'price_categoris_id' => $priceCategori->id,
            'items_id' => $request->input('item_id_' . $i),
            'percent' => $request->input('percent_' . $i)
          ]);
        } elseif ($request->input('name_' . $i) && $request->input('percent_' . $i) == null) {

          return redirect()->back()->with('error', 'يرجا التاكد من ادخال النسبه للاصناف المختاره');
        }
      }

      for ($i = 0; $i <= $branchs_count; $i++) {
        if ($request->input('branch_name_' . $i)) {
          $branchName = $request->input('branch_name_' . $i);
          $branchPriceCategoryId = $request->input('branch_id_' . $i);
          // تحقق مما إذا كان معرف الفرع موجودًا في جدول users
          $user = User::where('id', $branchPriceCategoryId)->first();
          // return [$user, $branchPriceCategoryId];

          if ($user) {
            // تحديث قيمة price_categoris_id في جدول المستخدمين
            $user->update(['price_categoris_id' => $priceCategori->id]);
          } else {

            return redirect()->back()->with(['error' => 'عفوًا،  الفرع غير موجود '])
              ->withInput();
          }
        }
      }


      return redirect()->route('priceCategory.index')->with('success', 'تم حفظ البيانات بنجاح');
    } else {
      return redirect()->back()->with(['error' => 'عفوًا، اسم الفئة موجود بالفعل'])
        ->withInput();
    }
  }



  public function edit($id)
  {

    $data = priceCategori::where('id', $id)->with('items')->first();
    $items = Item::all();
    $branches = User::where('role', 2)->get();
    return view('price_category.edit', compact('data', 'items', 'branches'));
  }

  public function update(Request $request, $id)
  {
    // $rules = [
    //   'price_name' => 'required',
    //   'active' => 'required',
    // ];

    // $items_count = Item::count();

    // for ($i = 0; $i <= $items_count; $i++) {
    //   $rules['name_' . $i] = 'required';
    //   $rules['percent_' . $i] = 'required|numeric|min:0';
    // }

    // $validator = Validator::make($request->all(), $rules);

    // if ($validator->fails()) {
    //   return redirect()->route('priceCategory.edit', $id)
    //     ->withErrors($validator)
    //     ->withInput();
    // }

    $items_count = Item::count();
    $branchs_count = User::where('role', 2)->count();

    $priceCategori_item = PriceCategoryItem::where('price_categoris_id', $id)->delete();
    $priceCategori = priceCategori::where('id', $id)->first();

    $priceCategori->update([
      'name' => $request->input('price_name'),
      "active" => $request->input('active'),
    ]);

    for ($i = 0; $i <= $items_count; $i++) {

      if ($request->input('name_' . $i) && $request->input('percent_' . $i) != null) {
        PriceCategoryItem::create([
          'price_categoris_id' => $priceCategori->id,
          'items_id' => $request->input('item_id_' . $i),
          'percent' => $request->input('percent_' . $i)
        ]);
      } elseif ($request->input('name_' . $i) && $request->input('percent_' . $i) == null) {

        return redirect()->back()->with('error', 'يرجا التاكد من ادخال النسبه للاصناف المختاره');
      }
    }


    for ($i = 0; $i <= $branchs_count; $i++) {
      if ($request->input('branch_name_' . $i)) {
        $branchName = $request->input('branch_name_' . $i);
        $branchPriceCategoryId = $request->input('branch_id_' . $i);
        // تحقق مما إذا كان معرف الفرع موجودًا في جدول users
        $user = User::where('id', $branchPriceCategoryId)->first();
        // return [$user, $branchPriceCategoryId];

        if ($user) {
          // تحديث قيمة price_categoris_id في جدول المستخدمين
          $user->update(['price_categoris_id' => $priceCategori->id]);
          return redirect()->route('priceCategory.index')->with('success', 'تم تعديل البيانات بنجاح');
        } else {

          return redirect()->back()->with(['error' => 'عفوًا،  الفرع غير موجود '])
            ->withInput();
        }
      }
    }

    return redirect()->route('priceCategory.index')->with('success', 'تم تعديل البيانات بنجاح');
  }

  public function delete($id)
  {

    try {

      $item_row = priceCategori::where('id', $id)->first();
      // dd($item_row->active);
      if (!empty($item_row)) {
        if ($item_row->active == 0) {
          $item_row->delete();
          return redirect()->route('priceCategory.index')->with(['succes' => 'تم حذف البيانات بنجاح']);
        } elseif ($item_row->active == 1) {
          return redirect()->route('priceCategory.index')->with(['error' => 'لايمكن حذف هذه الفئة عليك تعطيلها أولا']);
        }
      } else {
        return redirect()->route('priceCategory.index')->with(['error' => 'لايمكن الوصول الى البيانات المطلوبة']);
      }
    } catch (\Exception $ex) {
      return redirect()->route('priceCategory.index')->with(['error' => 'حدث خطأ ما... ' . $ex->getMessage()]);
    }
  }
}
