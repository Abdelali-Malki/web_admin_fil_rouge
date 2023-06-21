<?php

use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'installer'], function () {

    Auth::routes(['register' => false]);

    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('registerCreate');

});
 
Route::middleware(['installer', 'auth'])->group(function () {
    Route::get('/categories', [App\Http\Controllers\CollectionController::class, 'index'])->name('collections');
    Route::get('/categories/data', [App\Http\Controllers\CollectionController::class, 'data'])->name('collections-data');
    Route::any('/categories/new', [App\Http\Controllers\CollectionController::class, 'new'])->name('collections-new');
    Route::post('/categories/delete', [App\Http\Controllers\CollectionController::class, 'delete'])->name('collections-delete');
    Route::any('/categories/edit/{id}', [App\Http\Controllers\CollectionController::class, 'edit'])->name('collections-edit');

    Route::get('/colors', [App\Http\Controllers\ColorController::class, 'index'])->name('color');
    Route::get('/colors/data', [App\Http\Controllers\ColorController::class, 'data'])->name('color-data');
    Route::any('/colors/new', [App\Http\Controllers\ColorController::class, 'new'])->name('color-new');
    Route::post('/color/delete', [App\Http\Controllers\ColorController::class, 'delete'])->name('color-delete');
    Route::any('/color/edit/{id}', [App\Http\Controllers\ColorController::class, 'edit'])->name('color-edit');

    Route::get('/wallpapers', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
    Route::get('/wallpapers/data', [App\Http\Controllers\ProductController::class, 'data'])->name('products-data');
    Route::any('/wallpapers/new', [App\Http\Controllers\ProductController::class, 'new'])->name('products-new');
    Route::post('/wallpapers/delete', [App\Http\Controllers\ProductController::class, 'delete'])->name('products-delete');
    Route::get('/wallpapers/get-collection-name', [App\Http\Controllers\ProductController::class, 'getCollectionName'])->name('products-collection-name');
    Route::any('/wallpapers/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('products-edit');

    Route::post('/wallpapers/temp-image-upload', [App\Http\Controllers\ProductController::class, 'tempImageUpload'])->name('temp-image-upload');

    Route::get('/generateWebp/{id?}', [App\Http\Controllers\ProductController::class, 'generateWebp']);

    Route::get('/generateTagSuggestions', [App\Http\Controllers\ProductController::class, 'generateTagSuggestions']);

    Route::get('app_settings',[SettingsController::class, "appSettings"])->name("app_settings");
    Route::post('app_settings',[SettingsController::class, "appSettingsUpdate"]);
    Route::get('ads_settings',[SettingsController::class, "adsSettings"])->name("ads_settings");
    Route::post('ads_settings',[SettingsController::class, "adsSettingsUpdate"]);

    Route::get('update-profle',[SettingsController::class, "updateProfile"])->name("update-profile");
    Route::post('update-profile',[SettingsController::class, "updateProfileupdate"])->name("update-profile-update");


    Route::get('/ajax/viewline', [App\Http\Controllers\AjaxController::class, 'viewline'])->name('viewline');

    Route::post('change-password',[SettingsController::class, "changePassword"])->name("change-password");
    Route::post('save-push',[SettingsController::class, "savePush"])->name("save-pusher");
    Route::get('notification-history',[SettingsController::class, "notificationHistory"])->name("notification-history");
    Route::get('notification-data',[SettingsController::class, "notificationData"])->name("notification-data");

});


Route::group(['middleware' => 'installer'], function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/home', function(){
        return redirect()->route('home');
    });

    Route::get('/page/{slug}', function($slug){
        return view('page.info', compact('slug'));
    })->where(['slug'=>'[a-z0-9]+(?:-[a-z0-9]+)*']);

    Route::get('/share/image/{id}', [App\Http\Controllers\ShareController::class, 'index'])->name('share')->where(['id' => '[0-9]+']);
});


foreach (scandir($path = app_path('Modules')) as $dir) {
    if (file_exists($filepath = "{$path}/{$dir}/routes/web.php")) {
        require $filepath;
    }
}
