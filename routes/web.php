<?php

use App\Http\Controllers\AdminPanelSettingController;
use App\Http\Controllers\API\OrderApiController;
use App\Http\Controllers\BranshController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Item_CategoryController;
use App\Http\Controllers\itemContoller;
use App\Http\Controllers\PriceCategoryContoller;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\NotifcationController;
use App\Http\Controllers\ordersController;
use App\Http\Controllers\outlay_categoriController;
use App\Http\Controllers\outlayContoller;
use App\Http\Controllers\salesController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteSe rviceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Auth::routes(['register' => false]);

Route::get('/hana', function () {
  return view('home');
});

Route::get('/gerges', function () {
  return view('index');
});

Route::group(['middleware' => ['auth']], function () {

  // Route::get('/dashboard', function () {
  //   return view('adminHome.home');
  // })->name('dashboard');
  Route::get('/', [HomeController::class, 'reports'])->name('dashboard');


  Route::get('/adminPanelSetting/show/{id}', [AdminPanelSettingController::class, 'show'])->name('adminPanelSetting.show');
  Route::get('/adminPanelSetting/edit/{id}', [AdminPanelSettingController::class, 'edit'])->name('adminPanelSetting.edit');
  Route::put('/adminPanelSetting/update/{id}', [AdminPanelSettingController::class, 'update'])->name('adminPanelSetting.update');



  // start branch
  Route::get('/branch/index', [BranshController::class, 'index'])->name('branch.index');
  Route::get('/branch/create', [BranshController::class, 'create'])->name('branch.create');
  Route::post('/branch/store', [BranshController::class, 'store'])->name('branch.store');
  Route::get('/branch/edit/{id}', [BranshController::class, 'edit'])->name('branch.edit');
  Route::put('/branch/update/{id}', [BranshController::class, 'update'])->name('branch.update');
  Route::delete('/branch/delete/{id}', [BranshController::class, 'delete'])->name('branch.delete');
  Route::get('/branch/show/{id}', [BranshController::class, 'show'])->name('branch.show');
  Route::get('/branch/bayout/{id}', [BranshController::class, 'bayout'])->name('branch.bayout');
  Route::post('/branch/ajax_search', [BranshController::class, 'ajax_search'])->name('branch.ajax_search');
  // end branch


  // start item Categori
  Route::get('/itemcard_categories/index', [Item_CategoryController::class, 'index'])->name('itemcard_categories.index');
  Route::get('/itemcard_categories/create', [Item_CategoryController::class, 'create'])->name('itemcard_categories.create');
  Route::post('/itemcard_categories/store', [Item_CategoryController::class, 'store'])->name('itemcard_categories.store');
  Route::get('/itemcard_categories/edit/{id}', [Item_CategoryController::class, 'edit'])->name('itemcard_categories.edit');
  Route::post('/itemcard_categories/update/{id}', [Item_CategoryController::class, 'update'])->name('itemcard_categories.update');
  Route::delete('/itemcard_categories/delete/{id}', [Item_CategoryController::class, 'delete'])->name('itemcard_categories.delete');
  // end item Categori


  // start priceCategory
  Route::get('/priceCategory/index', [PriceCategoryContoller::class, 'index'])->name('priceCategory.index');
  Route::get('/priceCategory/create', [PriceCategoryContoller::class, 'create'])->name('priceCategory.create');
  Route::post('/priceCategory/store', [PriceCategoryContoller::class, 'store'])->name('priceCategory.store');
  Route::get('/priceCategory/edit/{id}', [PriceCategoryContoller::class, 'edit'])->name('priceCategory.edit');
  Route::post('/priceCategory/update/{id}', [PriceCategoryContoller::class, 'update'])->name('priceCategory.update');
  Route::delete('/priceCategory/delete/{id}', [PriceCategoryContoller::class, 'delete'])->name('priceCategory.delete');
  // end priceCategory



  // start item Categori
  Route::get('/itemcard/index', [itemContoller::class, 'index'])->name('itemcard.index');
  Route::get('/itemcard/create', [itemContoller::class, 'create'])->name('itemcard.create');
  Route::post('/itemcard/store', [itemContoller::class, 'store'])->name('itemcard.store');
  Route::get('/itemcard/edit/{id}', [itemContoller::class, 'edit'])->name('itemcard.edit');
  Route::post('/itemcard/update/{id}', [itemContoller::class, 'update'])->name('itemcard.update');
  Route::delete('/itemcard/delete/{id}', [itemContoller::class, 'delete'])->name('itemcard.delete');
  Route::post('/itemcard/ajax_search', [itemContoller::class, 'ajax_search'])->name('itemcard.ajax_search');

  // end item Categori
  // start priceCategory
  Route::get('/orders/index', [ordersController::class, 'index'])->name('orders.index');
  Route::get('/orders/create', [ordersController::class, 'create'])->name('orders.create');
  Route::post('/orders/store', [ordersController::class, 'store'])->name('orders.store');
  Route::get('/orders/accept/{id}', [ordersController::class, 'accept'])->name('orders.accept');
  Route::put('/orders/update/{id}', [ordersController::class, 'update'])->name('orders.update');
  Route::get('/orders/unaccepted/{id}', [ordersController::class, 'unaccepted'])->name('orders.unaccepted');
  // end priceCategory
  // API priceCategory




  // start outlay_categori
  Route::get('/outlay_categori/index', [outlay_categoriController::class, 'index'])->name('outlay_categori.index');
  Route::get('/outlay_categori/create', [outlay_categoriController::class, 'create'])->name('outlay_categori.create');
  Route::post('/outlay_categori/store', [outlay_categoriController::class, 'store'])->name('outlay_categori.store');
  Route::get('/outlay_categori/edit/{id}', [outlay_categoriController::class, 'edit'])->name('outlay_categori.edit');
  Route::post('/outlay_categori/update/{id}', [outlay_categoriController::class, 'update'])->name('outlay_categori.update');
  Route::delete('/outlay_categori/delete/{id}', [outlay_categoriController::class, 'delete'])->name('outlay_categori.delete');
  // end outlay_categori
  // start outlay
  Route::get('/outlay/index', [outlayContoller::class, 'index'])->name('outlay.index');
  Route::get('/outlay/create', [outlayContoller::class, 'create'])->name('outlay.create');
  Route::post('/outlay/store', [outlayContoller::class, 'store'])->name('outlay.store');
  Route::get('/outlay/edit/{id}', [outlayContoller::class, 'edit'])->name('outlay.edit');
  Route::post('/outlay/update/{id}', [outlayContoller::class, 'update'])->name('outlay.update');
  Route::delete('/outlay/delete/{id}', [outlayContoller::class, 'delete'])->name('outlay.delete');
  // end outlay

  // start sales
  Route::get('/sales/index', [salesController::class, 'index'])->name('sales.index');
  // end sales
  Route::get('MarkAsRead_all', [NotifcationController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');
  Route::get('unreadNotifications_count', [NotifcationController::class, 'unreadNotifications_count'])->name('unreadNotifications_count');
  Route::get('unreadNotifications', [NotifcationController::class, 'unreadNotifications'])->name('unreadNotifications');



  Route::resource('roles', RoleController::class);
  Route::resource('users', UserController::class);

  Route::get('search', [SearchController::class, 'invoke']);
  Route::get('user_search', [SearchUserController::class, '__invoke']);
});


// Route::group(['middleware' => ['auth']], function () {

// Route::resource('products', ProductController::class);
// });


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
