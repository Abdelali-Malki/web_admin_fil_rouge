<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/collections', [App\Http\Controllers\CollectionController::class, 'index'])->name('collections');
    Route::get('/collections/data', [App\Http\Controllers\CollectionController::class, 'data'])->name('collections-data');
    Route::any('/collections/new', [App\Http\Controllers\CollectionController::class, 'new'])->name('collections-new');
    Route::post('/collections/delete', [App\Http\Controllers\CollectionController::class, 'delete'])->name('collections-delete');
    Route::any('/collections/edit/{id}', [App\Http\Controllers\CollectionController::class, 'edit'])->name('collections-edit');

    Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
    Route::get('/products/data', [App\Http\Controllers\ProductController::class, 'data'])->name('products-data');
    Route::any('/products/new', [App\Http\Controllers\ProductController::class, 'new'])->name('products-new');
    Route::post('/products/delete', [App\Http\Controllers\ProductController::class, 'delete'])->name('products-delete');
    Route::get('/products/get-collection-name', [App\Http\Controllers\ProductController::class, 'getCollectionName'])->name('products-collection-name');
    Route::any('/products/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('products-edit');

    Route::post('/products/temp-image-upload', [App\Http\Controllers\ProductController::class, 'tempImageUpload'])->name('temp-image-upload');

    Route::get('/generateWebp', [App\Http\Controllers\ProductController::class, 'generateWebp']);

    Route::get('/generateTagSuggestions', [App\Http\Controllers\ProductController::class, 'generateTagSuggestions']);
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/page/{slug}', function($slug){
    return view('page.'.$slug);
})->where(['slug'=>'[a-z0-9]+(?:-[a-z0-9]+)*']);

Route::get('/share/image/{id}', [App\Http\Controllers\ShareController::class, 'index'])->name('share')->where(['id' => '[0-9]+']);
