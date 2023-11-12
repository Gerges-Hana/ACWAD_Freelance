<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\order;
use Illuminate\Http\Request;
use App\Http\Requests\adminPanelRequset;
use App\Http\Requests\EditadminPanelRequset;
use App\Models\Item;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminPanelSettingController extends Controller
{
  public function show($id)
  {
    $data = User::where('id', $id)->first();
    return view('adminPanelSetting.show', [
      'data' => $data,
    ]);
  }


  public function update(Request $request, $id)
  {
    // قواعد التحقق من الصحة
    $rules = [
      'address' => 'required|string',
      'phone' => 'required|string',
      'password' => 'nullable|min:8', // يمكنك تغيير الحد الأدنى للحد الذي تريده
      'email' => 'required|email',
      'name' => 'required|string',
    ];

    $messages = [
      'required' => 'حقل :attribute مطلوب.',
      'email' => 'البريد الإلكتروني يجب أن يكون عنوان بريد إلكتروني صالح.',
      'min' => 'يجب أن تحتوي كلمة المرور على الأقل على :min أحرف.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return redirect()->route('adminPanelSetting.show', 1)->withErrors($validator)->withInput()->with('error', 'يوجد خطأ تاكد من ادخال البيانات');
    }

    $user = User::find($id);
    $user->address = $request->input('address');
    $user->phone = $request->input('phone');
    if ($request->input('password')) {
      $user->password = bcrypt($request->input('password'));
    }
    $user->email = $request->input('email');
    $user->name = $request->input('name');
    $user->save();
    session()->flash('edit', 'تم تعديل الفاتورة بنجاح');

    return redirect()->route('adminPanelSetting.show', 1)->with('success', 'تم تحديث البيانات بنجاح.');
  }
}