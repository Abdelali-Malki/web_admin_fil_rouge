<?php



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

use App\Models\Collections;
use App\Models\Color;
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

        'colorImageDir' => asset('images/colors'),

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

Route::get('/color/{id}/{limit?}/{page?}', function ($id, $limit=0, $page=1) {

    $collectionInfo = Color::where('status',1)->where('id',$id);



    if(!$collectionInfo->exists()){

        return response()->json([

            'message' => 'No data found. If error persists, contact info@coder71.com'

        ], 204);

    }



    $products = Products::where('status',1)->whereRaw("find_in_set($id,colors)")->paginate($limit, ['*'], 'page', $page);



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

            'icon'=> asset("upload/".env("RECENT")),

    ];



    $data [] = [

        'id'=>'popular',

        'name'=>'Popular',

        'icon'=> asset("upload/".env("MOST_POPULAR")),

    ];



    return response()->json($data, 200);

});



Route::get('/color-group', function(){

    
    $data = Color::where('status',1)->get()->toArray();

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

    if($q!=''){
        $model = new Statistics;
        $model->action_type = 'Search-Query';
        $model->action_id = 0;
        $model->platform = 'All';
        $model->source_page = 'Home';
        $model->additional_data = json_encode(['query'=>$q]);
        $model->save();
    }

    $foundTags=[];

    $find = TagSuggestions::where('name', 'LIKE', $q.'%')
    ->orderBy('hit','desc')
    ->orderBy('last_hit_datetime','desc')
    ->limit(10);

    if($find->exists()){

        foreach($find->get() as $tag):
            $data['data'][]=$tag;
            $foundTags[]=$tag;
        endforeach;

        if(count($foundTags)>0){
            $model->additional_data = json_encode(['query'=>$q, 'results'=>$foundTags]);
            $model->save();
        }

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



Route::get("/app_info",function(){

    $data["app_name"] = env('APP_NAME');

    $data["about_us_link"] = env('ABOUT_US_LINK');

    $data["app_share_link"] = env('SHARE_LINK');

    $data["app_logo"] = (env("ADMIN_LOGO") !="" && file_exists(public_path("upload/" . env("ADMIN_LOGO"))))?(public_path("upload/" . env("ADMIN_LOGO"))):(asset("images/common/logo/WallIcon.png"));

    $data["most_popular"] = (env("MOST_POPULAR") !="" && file_exists(public_path("upload/" . env("MOST_POPULAR"))))?(public_path("upload/" . env("MOST_POPULAR"))):(asset("images/common/logo/WallIcon.png"));

    $data["recent"] = (env("RECENT") !="" && file_exists(public_path("upload/" . env("RECENT"))))?(public_path("upload/" . env("RECENT"))):(asset("images/common/logo/WallIcon.png"));

    $data["full_screen_slider_delay"] = (int) env('FULL_SCREEN_SLIDER_DELAY');

    return response()->json($data, 200);

});



Route::get("/ads_info",function(){

    $data["ads_status"] = env('ADS_STATUS');

    $data["app_open_unit_id"] = env('MOBILE_APP_OPEN_AND_UNIT_ID');

    $data["add_mob_banner_ads_unit_id"] = env('ADD_MOBILE_BANNER_UNIT_ID');

    $data["add_mob_banner_ads_status"] = env('ADD_BANNER_ADD_STATUS');

    $data["add_mob_interstitial_ads_unit_id"] = env('ADD_MOBILE_INITIAL_ADD_UNIT');

    $data["add_interstitial_interval"] = env('ADD_INTERSTITIAL_INTERVAL');

    $data["add_mob_interstitial_ads_status"] = env('ADD_MOBILE_ADD_STATUS');



    return response()->json($data, 200);


});
