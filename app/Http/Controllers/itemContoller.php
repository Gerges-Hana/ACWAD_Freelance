<?php

namespace App\Http\Controllers;

use App\Http\Requests\itemCardRequest;
use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class itemContoller extends Controller
{
  public function index()
  {

    $data = Item::all();
    $inv_itemcard_categorie_name = Item::where('active', 1);
    return view('item_card.index', compact('data', 'inv_itemcard_categorie_name'));
  }


  public function create()
  {

    $inv_itemcard_categorie_name = ItemCategory::where('active', 1)->get();
    return view('item_card.create', compact('inv_itemcard_categorie_name'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|min:3|max:255|unique:items',
      'categori_id' => 'required',
      'gumla_price_tl' => 'required',
      'gumla_price_usd' => 'required',
      'count' => 'required',
      'active' => 'required|in:0,1',
      'photo' => 'nullable|mimes:png,jpg,jpeg,svg|max:2000',
    ], [
      'name.required' => 'حقل الاسم مطلوب',
      'name.min' => 'الاسم يجب أن يحتوي على 3 أحرف على الأقل',
      'name.max' => 'الاسم لا يمكن أن يتجاوز 255 حرفًا',
      'name.unique' => 'هذا الاسم موجود بالفعل',
      'categori_id.required' => 'حقل الفئة مطلوب',
      'gumla_price_tl.required' => 'حقل السعر TL مطلوب',
      'gumla_price_usd.required' => 'حقل السعر USD مطلوب',
      'count.required' => 'حقل العدد مطلوب',
      'active.required' => 'حقل الحالة مطلوب',
      'active.in' => 'قيمة الحالة غير صحيحة',
      'photo.mimes' => 'يجب أن تكون الصورة من نوع png, jpg, jpeg, أو svg',
      'photo.max' => 'حجم الصورة لا يجب أن يتجاوز 2000 كيلوبايت',
    ]);

    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput();
    }


    $name_Exisets = Item::where(['name' => $request->name])->first();
    if (!empty($name_Exisets)) {
      return redirect()->back()->with(['error' => 'عفواً، اسم الصنف موجود بالفعل'])->withInput();
    }

    $data_insert['name'] = $request->name;
    $data_insert['categori_id'] = $request->categori_id;
    $data_insert['gumla_price_tl'] = $request->gumla_price_tl;
    $data_insert['gumla_price_usd'] = $request->gumla_price_usd;
    $data_insert['gumla_price_usd'] = $request->gumla_price_usd;
    $data_insert['count'] = $request->count;
    $data_insert['active'] = $request->active;

    if ($request->hasFile('photo')) {
      $request->validate([
        'photo' => 'required|mimes:png,jpg,jpeg,svg|max:2000',
      ]);

      $folder = 'assets/admin/uploads';
      $image = $request->file('photo');
      $extension = strtolower($image->extension());
      $filename = time() . rand(100, 999) . '.' . $extension;
      $image->move($folder, $filename);
      $data_insert['photo'] = $filename;
    }

    Item::create($data_insert);
    return redirect()->route('itemcard.index')->with(['success' => 'تم الاضافه البيانات بنجاح']);
  }

  public function edit($id)
  {

    $data = Item::where('id', $id)->first();
    $inv_itemcard_categorie_name = ItemCategory::where('active', 1)->get();
    return view('item_card.edit', compact('data', 'inv_itemcard_categorie_name'));
  }

  public function update($id, Request $request)
  {

    // ================================================
    $validator = Validator::make($request->all(), [
      'name' => 'required|min:3|max:255',
      'categori_id' => 'required',
      'gumla_price_tl' => 'required',
      'gumla_price_usd' => 'required',
      'count' => 'required',
      'active' => 'required|in:0,1',
      'photo' => 'nullable|mimes:png,jpg,jpeg,svg|max:2000',
    ], [
      'name.required' => 'حقل الاسم مطلوب',
      'name.min' => 'الاسم يجب أن يحتوي على 3 أحرف على الأقل',
      'name.max' => 'الاسم لا يمكن أن يتجاوز 255 حرفًا',
      'name.unique' => 'هذا الاسم موجود بالفعل',
      'categori_id.required' => 'حقل الفئة مطلوب',
      'gumla_price_tl.required' => 'حقل السعر TL مطلوب',
      'gumla_price_usd.required' => 'حقل السعر USD مطلوب',
      'count.required' => 'حقل العدد مطلوب',
      'active.required' => 'حقل الحالة مطلوب',
      'active.in' => 'قيمة الحالة غير صحيحة',
      'photo.mimes' => 'يجب أن تكون الصورة من نوع png, jpg, jpeg, أو svg',
      'photo.max' => 'حجم الصورة لا يجب أن يتجاوز 2000 كيلوبايت',
    ]);

    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput();
    }

    // ================================================
    $data = Item::select('*')->where('id', $id)->first();

    if (empty($data)) {
      return redirect()->back()->with(['error' => 'لا يمكن الوصول إلى البيانات المطلوبة!'])->withInput();
    }

    $nameExists = Item::where([
      'name' => $request->name,
    ])->where('id', '!=', $id)->first();
    if ($nameExists == null) {
      $data_to_update['name'] = $request->name;
      $data_to_update['categori_id'] = $request->categori_id;
      $data_to_update['gumla_price_tl'] = $request->gumla_price_tl;
      $data_to_update['gumla_price_usd'] = $request->gumla_price_usd;
      $data_to_update['count'] = $request->count;

      $data_to_update['active'] = $request->active;
      if ($request->hasFile('photo')) {

        $request->validate([
          'photo' => 'required|mimes:png,jpg,jpeg,svg|max:2000',
        ]);
        $oldimage = $data['photo'];
        $folder = 'assets/admin/uploads';
        $image = $request->file('photo');
        $extension = strtolower($image->extension());
        $filename = time() . rand(100, 999) . '.' . $extension;
        $image->move($folder, $filename);
        $the_file_path = $filename;


        if (file_exists('assets/admin/uploads/' . $oldimage) and !empty($oldimage)) {
          unlink('assets/admin/uploads/' . $oldimage);
        }
        $data_to_update['photo'] = $the_file_path;
      }


      $item = Item::find($id);

      if (!$item) {
        return redirect()->back()->with(['error' => 'لا يمكن العثور على العنصر المطلوب'])->withInput();
      }

      $item->update($data_to_update);

      return redirect()->route('itemcard.index')->with(['success' => 'تم  تعديل البيانات بنجاح']);
    } else {
      return redirect()->back()->with(['error' => 'عفوا اسم الصنف موجود بالفعل'])->withInput();
    }
  }

  public function delete($id)
  {
    // return $id;

    $item = Item::find($id);

    if (!$item) {
      return back()->with(['error' => 'لا يمكن العثور على الفئة المطلوبة']);
    }

    if ($item->active == 1) {
      return back()->with(['error' => 'لا يمكن حذف هذه الفئة، عليك تعطيلها أولا']);
    }
    if ($item->order()->count() > 0) {
      return back()->with(['error' => 'لا يمكن حذف هذه الفئة لأنها تحتوي على طلبيات مرتبطة']);
    }

    // تعطيل القيود المشترطة
    DB::statement('SET FOREIGN_KEY_CHECKS=0');

    // حذف السجل من الجدول الرئيسي
    $item->delete();

    // تمكين القيود المشترطة
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
    return back()->with(['success' => 'تم حذف البيانات بنجاح']);
  }
}
