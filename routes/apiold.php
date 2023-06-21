<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Collections;
use App\Models\Products;
use App\Models\Statistics;
use App\Models\TagSuggestions;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/urls', function () {
    $data = [
        'collectionsImageDir' => asset('images/collections'),
        'productImageDir' => asset('images/products')
    ];
    return response()->json($data, 200);
});

Route::get('/collections', function () {
    $data = Collections::where('status',1)->get()->toArray();
    return response()->json($data, 200);
});

Route::get('/collections/{id}/{limit?}/{page?}', function ($id, $limit=0, $page=1) {
    $collectionInfo = Collections::where('status',1)->where('id',$id);

    if(!$collectionInfo->exists()){
        return response()->json([
            'message' => 'No data found. If error persists, contact info@coder71.com'
        ], 204);
    }

    $products = Products::where('status',1)->whereRaw("find_in_set($id,collections)")->paginate($limit, ['*'], 'page', $page);

    $data = [
        'collection'=>$collectionInfo->first()->toArray(),
        'products'=>$products,
    ];

    return response()->json($data, 200);
})->where(['id' => '[0-9]+', 'limit' => '[0-9]+', 'page' => '[0-9]+']);

Route::get('/featured-group', function(){
    $data [] = [
            'id'=>'recent',
            'name'=>'Recent',
            'icon'=> asset('images/common/recent.jpg'),
    ];

    $data [] = [
        'id'=>'popular',
        'name'=>'Popular',
        'icon'=> asset('images/common/popular.jpg'),
    ];

    return response()->json($data, 200);
});

Route::get('/color-group', function(){
    $data [] = [
            'id'=>'color-black',
            'name'=>'Black',
            'icon'=>'https://cdn2.iconfinder.com/data/icons/random-set-1/433/Asset_95-512.png',
    ];

    $data [] = [
        'id'=>'color-white',
        'name'=>'White',
        'icon'=>'https://cdn2.iconfinder.com/data/icons/random-set-1/433/Asset_95-512.png',
    ];

    $data [] = [
        'id'=>'color-red',
        'name'=>'Red',
        'icon'=>'https://cdn2.iconfinder.com/data/icons/random-set-1/433/Asset_95-512.png',
    ];

    $data [] = [
        'id'=>'color-green',
        'name'=>'Green',
        'icon'=>'https://cdn2.iconfinder.com/data/icons/random-set-1/433/Asset_95-512.png',
    ];

    return response()->json($data, 200);
});

Route::get('/occasion-group', function(){
    $data [] = [
            'id'=>'occasion-mothers-day',
            'name'=>'Mother\'s Day',
            'icon'=>'https://cdn2.iconfinder.com/data/icons/random-set-1/433/Asset_95-512.png',
    ];

    $data [] = [
        'id'=>'occasion-valentines-day',
        'name'=>'Valentines Day',
        'icon'=>'https://cdn2.iconfinder.com/data/icons/random-set-1/433/Asset_95-512.png',
    ];

    $data [] = [
        'id'=>'occasion-halloween',
        'name'=>'Halloween',
        'icon'=>'https://cdn2.iconfinder.com/data/icons/random-set-1/433/Asset_95-512.png',
    ];

    $data [] = [
        'id'=>'occasion-parents-day',
        'name'=>'Parents Day',
        'icon'=>'https://cdn2.iconfinder.com/data/icons/random-set-1/433/Asset_95-512.png',
    ];

    return response()->json($data, 200);
});

Route::get('/products/tags/{tag}/{limit?}/{page?}', function ($tag, $limit=30, $page=1) {
    $data = Products::where('status',1)->where('tags', 'LIKE', '%' . $tag . '%')->orderBy('id','desc');

    if(!$data->exists()){
        return response()->json([
            'message' => 'No data found. If error persists, contact info@coder71.com'
        ], 204);
    }

    return response()->json($data->paginate($limit, ['*'], 'page', $page), 200);

})->where(['tag' => '[a-z0-9]+(?:-[a-z0-9]+)*', 'limit' => '[0-9]+', 'page' => '[0-9]+']);

Route::get('/products/recent/{limit?}/{page?}', function ($limit=30, $page=1) {
    $data = Products::where('status',1)->orderBy('id','desc');

    if(!$data->exists()){
        return response()->json([
            'message' => 'No data found. If error persists, contact info@coder71.com'
        ], 204);
    }

    return response()->json($data->paginate($limit, ['*'], 'page', $page), 200);

})->where(['limit' => '[0-9]+', 'page'=>'[0-9]+']);

Route::get('/products/popular/{day?}/{limit?}/{page?}', function ($day=7, $limit=30, $page=1) {
    $fromDateTime = date("Y-m-d 00:00:00", strtotime("-{$day} days"));
    $toDateTime = date("Y-m-d 23:59:59");

    $data = Products::where('status',1)->orderBy('last_view_datetime','desc')->whereBetween('last_view_datetime', [$fromDateTime, $toDateTime]);

    if(!$data->exists()){
        return response()->json([
            'message' => 'No data found. If error persists, contact info@coder71.com'
        ], 204);
    }

    return response()->json($data->paginate($limit, ['*'], 'page', $page), 200);
    
})->where(['day' => '[0-9]+', 'limit' => '[0-9]+', 'page' => '[0-9]+']);

Route::put('/products/hit/{type}/{id}', function($type, $id){
    $model = Products::find($id);
    if($model){
        $model->$type = $model->$type+1;
        
        if($type=='total_view_count'){
            $model->last_view_datetime = date("Y-m-d H:i:s");
        }

        if($model->save()) {
            $data = [
                'type'=>$type,
                'count'=>$model->$type
            ];
        }else{
            $data = [
                'status'=>'error'
            ];
        }
    }else{
        $data = [
            'status'=>'error'
        ];
        return response()->json($data, 400);
    }
    
    
    return response()->json($data, 200);
});

Route::post('/save-stat', function(Request $request){

    $validator = Validator::make($request->all(), [
        'action_type' => 'required',
        'platform' => 'required',
        'source_page'=>'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'=>'error',
            'message'=>$validator->errors()
        ], 400);
    }

    $model = new Statistics;
    $model->action_type = $request->action_type; //view, heart, download

    if($request->action_id)
        $model->action_id = $request->action_id; //collectionId, productId

    $model->platform = $request->platform; //apk, ios, web
    $model->source_page = $request->source_page; // action come from which page
    $model->additional_data = $request->additional_data;

    if($model->save()) {
        $data = [
            'status'=>'success'
        ];
        return response()->json($data, 200);
    }else{
        $data = [
            'status'=>'error'
        ];
        return response()->json($data, 400);
    }
});

Route::get('/search-suggest/{q}', function($q){
    $data['data'] = [];

    $find = TagSuggestions::where('name', 'LIKE', $q.'%')
    ->orderBy('hit','desc')
    ->orderBy('last_hit_datetime','desc')
    ->limit(10);
    if($find->exists()){
        foreach($find->get() as $tag):
            $data['data'][]=$tag;
        endforeach;
    }

    return response()->json($data, 200);
});

Route::get('/search/{q}/{limit?}/{page?}', function($q, $limit=30, $page=1){
    
    $data = Products::where('status',1)
    ->where('name', 'LIKE', '%' . $q . '%')
    ->orWhere('tags', 'LIKE', '%' . $q . '%')
    ->orWhere('collections_name', 'LIKE', '%' . $q . '%')
    ->orWhere('description', 'LIKE', '%' . $q . '%')
    ->orderBy('id','desc');

    TagSuggestions::increaseHit($q);

    if(!$data->exists()){
        return response()->json([
            'message' => 'No data found. If error persists, contact info@coder71.com'
        ], 204);
    }

    return response()->json($data->paginate($limit, ['*'], 'page', $page), 200);
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@coder71.com'
    ], 404);
});